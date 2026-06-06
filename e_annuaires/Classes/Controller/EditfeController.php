<?php

declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 xley <xley@e-magineurs.com>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Emagineurs\EAnnuaires\Domain\Repository\FicheRepository;
use Emagineurs\EAnnuaires\Domain\Repository\Conf\ChampbddRepository;
use Emagineurs\EAnnuaires\Utility\GeneralUtility;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Registry;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility as CoreGeneralUtility;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Editfe Controller
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class EditfeController extends ActionController
{
	protected FicheRepository $ficheRepository;
	protected ChampbddRepository $champBddRepository;
	protected GeneralUtility $utility;
	protected ?array $currentUser = null;
	protected ?object $ficheModelSchema = null;
	protected ?object $lienModelSchema = null;
	protected ?object $mandatModelSchema = null;
	protected ?object $documentsModelSchema = null;
	protected ?object $imageModelSchema = null;
	protected \TYPO3\CMS\Extbase\Reflection\ReflectionService $reflectionService;
	protected \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $persistenceManager;
	protected \Emagineurs\EAnnuaires\Domain\Repository\FilereferenceRepository $fileRefRepository;
	protected \Emagineurs\EAnnuaires\Domain\Repository\GroupepolitiqueRepository $groupepolitiqueRepository;
	protected \Psr\EventDispatcher\EventDispatcherInterface $eventDispatcher;

	public function __construct(
		FicheRepository $ficheRepository,
		ChampbddRepository $champBddRepository,
		GeneralUtility $utility,
		\TYPO3\CMS\Extbase\Reflection\ReflectionService $reflectionService,
		\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $persistenceManager,
		\Emagineurs\EAnnuaires\Domain\Repository\FilereferenceRepository $fileRefRepository,
		\Emagineurs\EAnnuaires\Domain\Repository\GroupepolitiqueRepository $groupepolitiqueRepository,
		\Psr\EventDispatcher\EventDispatcherInterface $eventDispatcher
	) {
		$this->ficheRepository = $ficheRepository;
		$this->champBddRepository = $champBddRepository;
		$this->utility = $utility;
		$this->reflectionService = $reflectionService;
		$this->persistenceManager = $persistenceManager;
		$this->fileRefRepository = $fileRefRepository;
		$this->groupepolitiqueRepository = $groupepolitiqueRepository;
		$this->eventDispatcher = $eventDispatcher;
	}
	
	/**
	 * initialize action
	 */
	public function initializeAction(): void
	{
		$this->TSinPlugin();
		
		// Get current user from request attribute instead of $GLOBALS['TSFE']
		$feUser = $this->getFrontendUser();
		$this->currentUser = $feUser ? $feUser->user : null;

		// On génère le tableau avec toutes les infos sur le model
		$this->ficheModelSchema = $this->reflectionService->getClassSchema(\Emagineurs\EAnnuaires\Domain\Model\Fiche::class);
		$this->lienModelSchema = $this->reflectionService->getClassSchema(\Emagineurs\EAnnuaires\Domain\Model\Lien::class);
		$this->mandatModelSchema = $this->reflectionService->getClassSchema(\Emagineurs\EAnnuaires\Domain\Model\Mandat::class);
		$this->documentsModelSchema = $this->reflectionService->getClassSchema(\Emagineurs\EAnnuaires\Domain\Model\Documents::class);
		$this->imageModelSchema = $this->reflectionService->getClassSchema(\Emagineurs\EAnnuaires\Domain\Model\Image::class);

		$this->useTsIfFlexIsEmpty();
	}

	/**
	 * Get frontend user from request attribute
	 *
	 * @return \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication|null
	 */
	protected function getFrontendUser(): ?\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
	{
		return $this->request->getAttribute('frontend.user');
	}

	/**
	 * Get current page ID from request
	 *
	 * @return int
	 */
	protected function getCurrentPageId(): int
	{
		$routing = $this->request->getAttribute('routing');
		if ($routing !== null && method_exists($routing, 'getPageId')) {
			return $routing->getPageId();
		}
		
		$frontendController = $this->request->getAttribute('frontend.controller');
		if ($frontendController !== null && property_exists($frontendController, 'id')) {
			return $frontendController->id;
		}
		
		// Fallback to query parameters
		$queryParams = $this->request->getQueryParams();
		return (int)($queryParams['id'] ?? 0);
	}

	/**
	 * Parse TypoScript string (simple parser for flexform TypoScript)
	 *
	 * @param string $tsString
	 * @return array
	 */
	protected function parseTypoScriptString(string $tsString): array
	{
		$lines = preg_split('/\r\n|\r|\n/', $tsString);
		$result = [];
		$currentPath = [];
		$current = &$result;

		foreach ($lines as $line) {
			$line = trim($line);
			if ($line === '') continue;

			// Start of block
			if (preg_match('/^([a-z0-9_.]+)\s*\{$/i', $line, $matches)) {
				$currentPath = explode('.', $matches[1]);
				$current = &$result;
				foreach ($currentPath as $p) {
					$pDot = $p . '.';
					if (!isset($current[$pDot])) {
						$current[$pDot] = [];
					}
					$current = &$current[$pDot];
				}
				continue;
			}

			// End of block
			if ($line === '}') {
				$currentPath = [];
				$current = &$result;
				continue;
			}

			// key = value
			if (strpos($line, '=') !== false) {
				[$key, $value] = array_map('trim', explode('=', $line, 2));

				// If key contains dot, create nested array
				if (strpos($key, '.') !== false) {
					$parts = explode('.', $key);
					$ref = &$current;
					foreach ($parts as $i => $part) {
						// If last part, assign value
						if ($i === count($parts) - 1) {
							$ref[$part] = $value;
						} else {
							$partDot = $part . '.';
							if (!isset($ref[$partDot])) {
								$ref[$partDot] = [];
							}
							$ref = &$ref[$partDot];
						}
					}
				} else {
					$current[$key] = $value;
				}
			}
		}

		return $result;
	}
    
	public function useTsIfFlexIsEmpty(): void
	{
		$confTsComplete = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

		$confTSWithDots = $confTsComplete['plugin.']['tx_eannuaires.']['settings.'] ?? [];

		$confTS = \Emagineurs\EAnnuaires\Utility\GeneralUtility::removeDotsInConf($confTSWithDots);

		foreach ($confTS as $conf => $value) {
			if (!array_key_exists($conf, $this->settings) || empty($this->settings[$conf])) {
				if (trim($value) != '' && !empty($value)) {
					$this->settings[$conf] = $value;
				}
			}
		}
	}

	public function TSinPlugin(): void
	{
		$flexformTyposcript = $this->settings['myTS'] ?? '';

		if ($flexformTyposcript) {
			// Parse TypoScript string manually (simple parser for flexform TypoScript)
			$setup = $this->parseTypoScriptString($flexformTyposcript);

			// On enleve les "points" dans les clés du tableau
			$setup = \Emagineurs\EAnnuaires\Utility\GeneralUtility::removeDotsInConf($setup);

			// Copy the resulting setup back into conf
			\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($this->settings, $setup);
		}
	}
	
	/**
	 * Allow properties for property mapping
	 */
	protected function allowProperties(string $property): void
	{
		$propertyMappingConfiguration = $this->arguments[$property]->getPropertyMappingConfiguration();
		$propertyMappingConfiguration->allowAllProperties();
		$propertyMappingConfiguration->setTypeConverterOption(
			\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::class,
			\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
			true
		);
	}

	protected function initializeEditLienAction(): void
	{
		$this->allowProperties('lien');
	}

	protected function initializeCreateLienAction(): void
	{
		$this->allowProperties('lien');
	}

	protected function initializeCreateMandatAction(): void
	{
		$this->allowProperties('mandat');
	}

	protected function initializeEditMandatAction(): void
	{
		$this->allowProperties('mandat');
	}

	protected function initializeCreateDocumentsAction(): void
	{
		$this->allowProperties('documents');
	}

	protected function initializeEditDocumentsAction(): void
	{
		$this->allowProperties('documents');
	}

	protected function initializeEditAction(): void
	{
		$this->allowProperties('fiche');
	}

	protected function initializeCreateAction(): void
	{
		$this->allowProperties('fiche');
	}

	/**
	 * action manage 
	 */
	public function manageAction(?\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche = null, string $status = ''): ResponseInterface
	{
		$arrayAssignation = [];
		if ($status == 'add') {
			$this->addFlashMessage(LocalizationUtility::translate('add', 'e_annuaires') ?? '', '');
		}
		$currentRequest = $this->request->getArguments();

		// On donne une valeur à la variable $status selon le cas de figure:
		// updateDone si on vient de mettre à jour la fiche
		// no_user si il n'y a pas d'utilisateur fe connecté
		// Si aucun des deux cas précédents pas de status
		if (empty($this->currentUser)) {
			$status = 'no_user';
		}

		// Si on a pas de status, on affiche le formulaire adéquat
		if ($fiche === null && empty($this->settings['allowAllUsers'])) {
			$fichesUser = $this->ficheRepository->getFichesUser($this->currentUser['uid']);
			$arrayAssignation['fiches'] = $fichesUser;
		} else {
			$this->redirect('edit', null, null, ['fiche' => $fiche]);
		}

		$arrayAssignation['status'] = $status;

		$this->view->assignMultiple($arrayAssignation);
		
		return $this->htmlResponse();
	}

	/**
	 * action edit -> Display edition form (only display)
	 */
	public function editAction(?\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche = null): ResponseInterface
	{
		$arrayAssignation = [];

		// On transmet les settings au repository. Utilisé pour la génération des tableaux
		$this->ficheRepository->setSettings($this->settings, ['cObj' => $this->configurationManager->getContentObject()]);

		// Si aucune fiche n'est passé en paramètre (=création d'une nouvelle fiche), on fait l'instanciation à la main
		if ($fiche === null) {
			$fiche = CoreGeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Fiche::class);
		}

		// On assigne la fiche au formulaires
		$arrayAssignation['fiche'] = $fiche;

		// Gestion des tableaux pour les selects du TCA
		$this->handleArrayAssignitionForFeEdition();

		//Ajout du js pour les inlines
		$this->addJsEditFe();

		if (!empty($this->currentUser)) {
			$arrayAssignation['user'] = $this->currentUser;
		}

		$this->view->assignMultiple($arrayAssignation);

		// On met en place une validation par token pour empecher la validation multiple en faidant retour navigateur -> submit
		if ($this->settings['editFe']['activeTokenValidation'] ?? false) {
			$tokenValidationArray = $this->getTokenValidationArray();
			$this->view->assignMultiple($tokenValidationArray);
		}
		
		return $this->htmlResponse();
	}	
    
	/**
	 * Génération des données pour la validation du token
	 */
	public function getTokenValidationArray(): array
	{
		// On instancie un sys_registry
		$registry = CoreGeneralUtility::makeInstance(Registry::class);

		// On génère les valeurs qui vont servir à identifier le formulaire en cours et son token
		$newToken = md5((string)rand());
		$countFiche = $this->ficheRepository->findAll()->count();
		$idForm = (int)$countFiche + 1;

		// On enregistre le token dans les registres
		$registry->set('tx_eannuaires', 'editFeIdForm' . $idForm, $newToken);

		// On retourne les données du token
		return [
			'token' => $newToken,
			'idForm' => $idForm,
		];
	}
	
	/**
	 * Ajout du javascript associé au formulaire d'edition frontend (but initial gestion des inlines)
	 */
	public function addJsEditFe(): void
	{
		$jsPath = !empty($this->settings['editFe']['jsPath'])
			? $this->settings['editFe']['jsPath']
			: 'EXT:e_annuaires/Resources/Public/Js/eannuairesFrontend.js';

		$pageRenderer = CoreGeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
		$pageRenderer->addJsFooterFile($jsPath);
	}

	/**
	 * Gestion de l'assignation des tableaux pour l'edition frontend
	 */
	public function handleArrayAssignitionForFeEdition(): void
	{
		// On utilise la même fonction pour générer les tableaux du formulaire d'edition frontend que pour générer ceux de la recherche
		// Par défaut, on retrouve une conf pour tous les select dans la conf static 
		$properties = $this->settings['editFe']['arrays'] ?? [];

		// On récupère également la conf du filtre par type, si elle est défini on ne génère que les tableaux correspondant au type indiqué
		$currentType = $this->settings['editFe']['defaultValues']['typeelement'] ?? '';

		// Si on a un type de défini dans le flexform, on ne génère que les tableaux correspondants aux select de ce type
		if ($this->champBddRepository->selectConfType($currentType)->count() > 0) {
			$champs = $this->champBddRepository->selectConfType($currentType);
		} else {
			// Sinon, on le fait pour tous les champs générés dans la conf

			// On récupère la liste des champs configuré 
			$allChamps = $this->champBddRepository->findAll();
            // n.b : solution concurrentes -> utilisé la fonction admin_get_fields qui récupère tous les champs de la table,
            // mais ne renvoie pas d'objet donc plus compliqué pour ensuite traiter tous les champs via une seule et même fonction
            // $champs = $GLOBALS['TYPO3_DB']->admin_get_fields('tx_eannuaires_domain_model_fiche');
			
			// On dédoublonne (pas de array_unique car pour un même champs on pourra avoir 2 objets différents
			// s'il sont utilisé dans 2 type d'annuaires différents).
			$champs = [];
			if (count($allChamps) > 0) {
				$arrayVerif = [];
				foreach ($allChamps as $currentChamp) {
					if (!in_array($currentChamp->getTitle(), $arrayVerif, true)) {
						$champs[] = $currentChamp;
						$arrayVerif[] = $currentChamp->getTitle();
					}
				}
			}
		}

		$this->handleArrayForDefinedType($champs, $properties);
	}

	/**
	 * Gestion des tableaux
	 */
	public function handleArrayForDefinedType(iterable $champs, array $properties): void
	{
		foreach ($champs as $currentField) {
			// On n'applique la config que pour les champs select du tca
			if (($GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns'][$currentField->getTitle()]['config']['type'] ?? '') == 'select') {
				// On prepare la "variable" que l'on assigne, en accord avec ce qui a été défini dans les templates générés par le module 
				$currentArray = 'array' . ucFirst($currentField->getTitle());

				// On récupère la conf TS correspondantes 
				$currentProperty = $properties[$currentArray] ?? null;

				// Si on trouve une conf, on lance la génération du tableau
				if (is_array($currentProperty)) {
					$this->assignArrayFromTca($currentProperty, $currentArray, $currentField);
				}
			}
		}
	}

	/**
	 * On assigne à la vue les tableaux correspondant aux select que l'on remonte dans le formulaire d'edition frontend
	 */
	public function assignArrayFromTca(array $currentProperty, string $currentArray, object $currentField): void
	{
		// Si le champ est identifé en TS comme basé sur du tsconfig
		if (array_key_exists('fromTsconfig', $currentProperty)) {
			$arrayPath = explode('.', $currentProperty['fromTsconfig']);
			$tsconfig = BackendUtility::getPagesTSconfig($this->getCurrentPageId());

			if (count($arrayPath) > 0) {
				// On a le chemin dans la ts config, on la parcore donc etape par etape en gardant a chaque fois le resultat
				foreach ($arrayPath as $step) {
					$tsconfig = $tsconfig[$step . '.'] ?? [];
				}

				$this->view->assign($currentArray, $tsconfig);
			}
		} elseif (array_key_exists('manualList', $currentProperty)) {
			// Si le champ est identifé en TS comme basé sur des items défini à la main dans le TCA
			$manuallySetItems = $GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns'][$currentField->getTitle()]['config']['items'] ?? [];
			$arrayToAssign = [];
			foreach ($manuallySetItems as $item) {
				$arrayToAssign[$item[1]] = $item[0];
			}

			$this->view->assign($currentArray, $arrayToAssign);
		} else {
			// Sinon, le tableau est généré à partir d'enregistrements de la bdd (même fonction que pour les tableaux de la recherche)
			$arrayToAssign = $this->utility->getArrayForSearchForm($currentProperty, $this->settings);
			$this->view->assign($currentArray, $arrayToAssign);
		}
	}

	/**
	 * action create -> create the new fiche then redirect to manageAction
	 */
	public function createAction(?\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche = null): ResponseInterface
	{
		// On recupère les infos de validation du token et on ne laisse l'action se poursuivre que si le token est validé
		if ($this->settings['editFe']['activeTokenValidation'] ?? false) {
			$args = $this->request->getArguments();
			$idForm = $args['idForm'] ?? '';
			$token = $args['token'] ?? '';

			// On instancie un sys_registry
			$registry = CoreGeneralUtility::makeInstance(Registry::class);
			$registeredToken = $registry->get('tx_eannuaires', 'editFeIdForm' . $idForm);

			if ($token == $registeredToken) {
				$registry->remove('tx_eannuaires', 'editFeIdForm' . $idForm);
			} else {
				return $this->htmlResponse(LocalizationUtility::translate('editFe.validationToken.failed', 'e_annuaires') ?? 'Token validation failed');
			}
		}

		$status = '';
		if ($fiche instanceof \Emagineurs\EAnnuaires\Domain\Model\Fiche && $fiche !== null) {
			// On set le feuser qui a créé la fiche
			if (empty($this->settings['allowAllUsers']) && !empty($this->currentUser)) {
				$fiche = $this->setFeuserFiche($fiche);
			}

			// On set les autres champs indispensables mais non editable par l'utilisateur (défini dans le flexform par défaut)
			$fiche = $this->setPropertiesFromSettingsDatas($fiche);

			// On set les inlines à partir des données en sessions (création d'enregistrements + renvoi de l'objet correspondant)
			$fiche = $this->setInlines($fiche);

			if ($fiche->getUid()) {
				$this->ficheRepository->update($fiche);
				$status = 'update';
			} else {
				$this->ficheRepository->add($fiche);
				$status = 'add';
			}

			$persistenceManager = CoreGeneralUtility::makeInstance(PersistenceManager::class);
			$persistenceManager->persistAll();
		}

		$this->sendMails($fiche);

		$this->forward('manage', null, null, ['status' => $status]);
	}
	
	public function setFeuserFiche(\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche): \Emagineurs\EAnnuaires\Domain\Model\Fiche
	{
		// On set à la fiche le feuser qui lui correspond
		// Query frontend user directly instead of using deprecated FrontendUserRepository
		$connectionPool = CoreGeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class);
		$queryBuilder = $connectionPool->getQueryBuilderForTable('fe_users');
		
		$feuserData = $queryBuilder
			->select('*')
			->from('fe_users')
			->where(
				$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int)$this->currentUser['uid'], \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
			)
			->executeQuery()
			->fetchAssociative();
		
		if ($feuserData) {
			// Set the frontend user UID directly without using deprecated FrontendUser model
			// The setFeuser() method accepts ObjectStorage, so we store the UID
			$fiche->setFeuser((int)$feuserData['uid']);
		}

		return $fiche;
	}
	
	public function setPropertiesFromSettingsDatas(\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche): \Emagineurs\EAnnuaires\Domain\Model\Fiche
	{
		// On set les valeurs par défaut qui ont été défini dans le flexform (ne fonctionne pas pour les relations complexe entre table, mm par exemple)
		if (is_array($this->settings['editFe']['defaultValues'] ?? null) && count($this->settings['editFe']['defaultValues']) > 0) {
			foreach ($this->settings['editFe']['defaultValues'] as $field => $defaultValue) {
				$setter = 'set' . ucFirst($field);

				// Depuis la v8, le champ identifier dans le TCA comme servant a determiner le type d'enregistrement
				// doit être sous forme de tableau, sinon il est vider par le datamapper (cf dataMapFactory)
				$defaultValue = ($GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['ctrl']['type'] ?? '') == $field ? [$defaultValue] : $defaultValue;
				$fiche->$setter($defaultValue);
			}
		}

		return $fiche;
	}
	
	public function setInlines(\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche): \Emagineurs\EAnnuaires\Domain\Model\Fiche
	{
		// On parcoure le TCA pour trouver les champs de type inline
		foreach ($GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns'] ?? [] as $annuaireField => $configField) {
			if (($configField['config']['type'] ?? '') == 'inline') {
				$tableArray = explode('_', $configField['config']['foreign_table']);
				$objName = end($tableArray);

				$feUser = $this->getFrontendUser();
				$datasFromSessionForCurrentField = $feUser ? $feUser->getKey('user', 'inlineForm-' . ucFirst($objName)) : null;

				// Si on a bien des données dans les sessions, on traite le champ
				if (!empty($datasFromSessionForCurrentField)) {
					$objStorage = CoreGeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
					$setterOj = 'set' . ucFirst($annuaireField);

					foreach ($datasFromSessionForCurrentField as $currentInlineDatas) {
						$objStorage = $this->setCurrentInline($objStorage, $objName, $currentInlineDatas, $fiche);
					}

					$fiche->$setterOj($objStorage);
					$this->cleanSessionsDatas('inlineForm-' . ucFirst($objName));
					$this->cleanSessionsDatas('inlineFormUpload');
				}
			}
		}

		return $fiche;
	}
	
	public function setCurrentInline(object $objStorage, string $objName, array $currentInlineDatas, \Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche): object
	{
		// Fonctionnement de base si tous les champs sont settables directement,
		// on ajoutera par la suite les cas plus compliqué type FAL ou storage objects
		$modelName = 'Emagineurs\\EAnnuaires\\Domain\\Model\\' . ucFirst($objName);
		$repoName = 'Emagineurs\\EAnnuaires\\Domain\\Repository\\' . ucFirst($objName) . 'Repository';
		$obj = CoreGeneralUtility::makeInstance($modelName);

		$schema = $objName . 'ModelSchema';
		$modelConfig = $this->$schema->getProperties();

		// On set le pid
		$obj->setPid($fiche->getPid());

		foreach ($currentInlineDatas as $field => $value) {
			$setter = 'set' . ucFirst($field);

			if (($modelConfig[$field]['type'] ?? '') == 'TYPO3\CMS\Extbase\Persistence\ObjectStorage') {
				if (!empty($value)) {
					$inlineObjStorage = CoreGeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
					$model = $modelConfig[$field]['elementType'] ?? '';
					if ($model == 'Emagineurs\EAnnuaires\Domain\Model\Filereference') {
						$inlineObjStorage = $this->setCurrentInlineFile($obj, $value, $objName, $field, $inlineObjStorage);
					} else {
						$repoArray = explode('\\', $model);
						$countModel = count($repoArray);
						$repoArray[$countModel - 2] = 'Repository';
						$repoArray[$countModel - 1] .= 'Repository';
						$inlineRepoName = implode('\\', $repoArray);
						$repo = CoreGeneralUtility::makeInstance($inlineRepoName);
						$valueArray = explode(',', $value);

						foreach ($valueArray as $currentValue) {
							$inlineObj = $repo->findByUid($currentValue);
							$inlineObjStorage->attach($inlineObj);
						}
					}
					$obj->$setter($inlineObjStorage);
				}
			} else {
				$obj->$setter($value);
			}
		}

		// On crée en base de données l'enregistrement correspondant à l'objet de l'inline courant
		$repoObj = CoreGeneralUtility::makeInstance($repoName);
		$repoObj->add($obj);

		$persistenceManager = CoreGeneralUtility::makeInstance(PersistenceManager::class);
		$persistenceManager->persistAll();

		// On l'ajoute ensuite à la fiche annuaire en cours de création
		$objStorage->attach($obj);

		return $objStorage;
	}
	
	public function setCurrentInlineFile(object $obj, array $fileIdentifier, string $objName, string $field, object $inlineObjStorage): object
	{
		$resourceFactory = CoreGeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ResourceFactory::class);

		foreach ($fileIdentifier as $currentFileIdentifier) {
			$fileRef = CoreGeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Filereference::class);

			if (is_array($currentFileIdentifier)) {
				$identifier = $currentFileIdentifier['identifier'];

				foreach ($currentFileIdentifier as $fileProperty => $propertyValue) {
					if ($fileProperty != 'identifier') {
						$setter = 'set' . ucFirst($fileProperty);
						$fileRef->$setter($propertyValue);
					}
				}
			} else {
				$identifier = $currentFileIdentifier;
			}

			$file = $resourceFactory->getFileObjectByStorageAndIdentifier(1, $identifier);
			$originalResource = \Emagineurs\EAnnuaires\Utility\FileUtility::createFileReference($file);

			$fileRef->setOriginalResource($originalResource);
			$fileRef->setTableLocal('sys_file');
			$fileRef->setShowinpreview(true);

			$inlineObjStorage->attach($fileRef);
		}

		return $inlineObjStorage;
	}
	
	public function cleanSessionsDatas(string $sessionToClean): void
	{
		$feUser = $this->getFrontendUser();
		if ($feUser) {
			$feUser->setKey('user', $sessionToClean, null);
		}
	}
	
	/**
	 * action handleInlineGeneration -> Redirect to the right action according to the field param
	 *
	 * @param \string $table
	 * @param \string $item
	 * @return void
	 */
	public function removeInlineItemAction($table, $item){
		// On supprime dans sessions l'item inline que l'on ne souhaite plus
		$sessionKey = "inlineForm-".ucFirst($table);
		$feUser = $this->getFrontendUser();
		$datasFromSession = $feUser ? $feUser->getKey('user', $sessionKey) : null;
		unset($datasFromSession[$item]);
		if ($feUser) {
			$datasFromSession = $feUser->setKey('user', $sessionKey, $datasFromSession);
		}
		
		$this->forward('edit'.ucFirst($table),null,null,null);
	}
	
	/**
	 * action remove the clicked image
	 *
	 * @param \string $imageToRemove
	 * @param \string $uidFiche
	 * @return void
	 */
	public function removeFileAction($imageToRemove, $uidFiche){
		// On récupère la fiche courante afin de supprimer l'image qui lui est attaché.
		$fiche = $this->ficheRepository->findByUid($uidFiche);
		
		// On récupère la la filereference de l'image choisie
		$fileRefToDelete = $this->fileRefRepository->findByUid($imageToRemove);
		
		// On detach l'image de l'object storage puis on update
		$getter = 'get'.ucFirst($fileRefToDelete->getFieldname());
		$fiche->$getter()->detach($fileRefToDelete);
		$this->ficheRepository->update($fiche);
			
		// On persist pour rendre les modifications sur l'objet effectives en base de donnée
		$this->persistenceManager->persistAll();
	}
	
	/**
	 * action remove the clicked image of an inline
	 *
	 * @param \string $imageToRemove
	 * @param \string $uidInline
	 * @param \string $typeInline
	 * @return void
	 */
	public function removeInlineImageAction($imageToRemove,$uidInline,$typeInline){
		// On instancie le repo de l'inline auquel on souhaite enlever une image
		$repoName = 'Emagineurs\\EAnnuaires\\Domain\\Repository\\'.ucFirst($typeInline).'Repository';
		$repository = CoreGeneralUtility::makeInstance($repoName);
		
		// On récupère l'inline courant afin de supprimer l'image qui lui est attaché.
		$inline = $repository->findByUid($uidInline);
		
		// On récupère la la filereference de l'image choisie
		$fileRefToDelete = $this->fileRefRepository->findByUid($imageToRemove);
		
		// On detach l'image de l'object storage puis on update
		if($typeInline == 'documents'){
			$getter = 'getFichier';
		} elseif($typeInline == 'uploadimage'){
			$getter = 'getMedia';
		}
		if(!empty($getter)){
			$inline->$getter()->detach($fileRefToDelete);
			$repository->update($inline);
				
			// On persist pour rendre les modifications sur l'objet effectives en base de donnée
			$this->persistenceManager->persistAll();
		}
	}
	
	/**
	 * action handleInlineGeneration -> Redirect to the right action according to the field param
	 *
	 * @param \string $field
	 * @return void
	 */
	#[IgnoreValidation(['value' => 'field'])]
	public function handleInlineGenerationAction($field){
		// Appelé via de l'ajax, redirige vers l'action correspondant au formulaire (pour un champ inline) que l'on souhaite affiché
		$action = 'edit'.ucFirst($field);
		$this->forward($action);
	}
	
	/**
	 * action handleInlineSubmit -> Redirect to the right action according to the field param
	 *
	 * @param \array $dataForm
	 * @return void
	 */
	public function handleInlineSubmitAction($dataForm = array()){		
		// on modifie le contenu du champ name pour généré un tableau qui permettra d'avoir un parametre pour l'action vers laquelle on va être redirigé
		$arrayFromDatas = explode('[',$dataForm[0]['name']);
		$table = substr($arrayFromDatas[1],0,-1);
		
		$formDatas = array();
		
		foreach($dataForm as $datas){
			$arrayFromCurrentDatas = explode('[',$datas['name']);
			
			if(!empty(substr(end($arrayFromCurrentDatas),0,-1))){
				$field = substr(end($arrayFromCurrentDatas),0,-1);
			} else {
				$count = count($arrayFromCurrentDatas);
				$field = substr($arrayFromCurrentDatas[$count-2],0,-1);
			}
			
			if(empty($formDatas[$field])){
				$formDatas[$field] = $datas['value'];
			} else {
				$formDatas[$field] .= ','.$datas['value'];
			}
		}
		
		$action = 'create'.ucFirst($table);
		$this->forward($action,null,null,array($table => $formDatas));
	}
	
	/**
	 * action uploadInlineImage -> create the fal entry for the inline record that is being created
	 *
	 * @return void
	 */
	public function uploadInlineImageAction(){
		if(!empty($_FILES)){
			foreach($_FILES as $key => $fileInfo){
				if(!empty($fileInfo['name'])){					
					$file = \Emagineurs\EAnnuaires\Utility\FileUtility::generateFile($fileInfo);		
					
					$feUser = $this->getFrontendUser();
					$fileSession = $feUser ? $feUser->getKey('user', 'inlineFormUpload') : null;
					
					if($fileSession === null){
						$fileSession = array();
					}
					$keyArray = explode('-',$key);					
					
					$fileSession[$keyArray[0]][$keyArray[1]][] = $file->getIdentifier();
					
					$feUser = $this->getFrontendUser();
					if ($feUser) {
						$feUser->setKey('user', 'inlineFormUpload', $fileSession);
					}
					
					$this->view->assign('image',$file);
				}
			}
		}
	}
	
	/**
	 * add fields that cannot be sent during the upload of the file
	 *
	 * @param array $fileInfo
	 * @return void
	 */
	public function addFileInfoAction($fileInfo = array()){
		$feUser = $this->getFrontendUser();
		$fileSession = $feUser ? $feUser->getKey('user', 'inlineFormUpload') : null;
		
		if(count($fileInfo) > 0){
			$newFileArray = array();
			
			// On va se basé sur le nom du champ pour retrouver l'entrée dans les sessions qui nous interesse
			$firstFileInfo = reset($fileInfo);
			$firstFileInfoName = $firstFileInfo['name'];
			$nameArray = explode('-',$firstFileInfoName);
			
			if(!empty($fileSession[$nameArray[0]][$nameArray[1]])){
				$currentFile = array_pop($fileSession[$nameArray[0]][$nameArray[1]]);
				$newFileArray['identifier'] = $currentFile;
				
				foreach($fileInfo as $currentFileInfo){
					$currentNameArray = explode('-',$currentFileInfo['name']);
					$newFileArray[$currentNameArray[2]] = $currentFileInfo['value'];
				}
				
				$fileSession[$nameArray[0]][$nameArray[1]][] = $newFileArray;
				$feUser = $this->getFrontendUser();
				if ($feUser) {
					$feUser->setKey('user', 'inlineFormUpload', $fileSession);
				}
			}
		}
		
		return TRUE;
	}
	
	/**
	 * action edition frontend pour la table tx_eannuaires_domain_model_lien
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Lien $lien
	 * @return void
	 */
	public function editLienAction(\Emagineurs\EAnnuaires\Domain\Model\Lien $lien = null){
		$arrayAssignation = [];
        
		if($lien === null){
			$lien = CoreGeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Lien::class);
		}
		
		$feUser = $this->getFrontendUser();
		$datasFromSession = $feUser ? $feUser->getKey('user', 'inlineForm-Lien') : null;
        
		// $this->view->assign('submittedLien', $datasFromSession);
        $arrayAssignation['submittedLien'] = $datasFromSession;
		
		// $this->view->assign('lien', $lien);
		$arrayAssignation['lien'] = $lien;
		
        
		$this->view->assignMultiple($arrayAssignation);
	}
	
	/**
	 * action edition frontend pour la table tx_eannuaires_domain_model_lien
	 *
	 * @param \array $lien
	 * @return void
	 */
	public function createLienAction($lien){
				
		$feUser = $this->getFrontendUser();
		$existingLien = $feUser ? $feUser->getKey('user', 'inlineForm-Lien') : null;
		
		if(empty($existingLien)){
			$existingLien = array();
		}
		
		$existingLien[] = $lien;
			
		/*** PAS DE CREATION D'ENREGISTREMENT ICI, ON ATTEND LA SOUMISSION DU FORMULAIRE POUR EVITER DE CREER DES ENREGISTREMENTS INUTILE SI LA PERSONNE NE VALIDE PAS ***/
		/*** A LA PLACE ON STOCKE EN SESSION, ON GENERERA LES OBJET PLUS TARD ***/
		$feUser = $this->getFrontendUser();
		if ($feUser) {
			$feUser->setKey('user', 'inlineForm-Lien', $existingLien);
		}
		
		
		$this->forward('editLien',null,null,array());
	}
	
	/**
	 * action edition frontend pour la table tx_eannuaires_domain_model_mandat
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Mandat $mandat
	 * @param \integer $typeMandat
	 * @return void
	 */
	public function editMandatAction(\Emagineurs\EAnnuaires\Domain\Model\Mandat $mandat = null, $typeMandat = 1){		
		$arrayAssignation = [];
        
		if($mandat === null){
			$mandat = CoreGeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Mandat::class);
			$mandat->setTypemandat($typeMandat);
		}
		
		$feUser = $this->getFrontendUser();
		$datasFromSession = $feUser ? $feUser->getKey('user', 'inlineForm-Mandat') : null;
		
        // $this->view->assign('submittedMandat', $datasFromSession);
		$arrayAssignation['submittedMandat'] = $datasFromSession;
		
		// On génère les tableaux pour les select du template
		$this->generateMandatArrays($typeMandat);
		
		// $this->view->assign('typeMandat', $typeMandat);
		// $this->view->assign('mandat', $mandat);
		$arrayAssignation['typeMandat'] = $typeMandat;
		$arrayAssignation['mandat'] = $mandat;
		$arrayAssignation['mandat'] = $mandat;
		
        
		$this->view->assignMultiple($arrayAssignation);
	}
	
	public function generateMandatArrays($typeMandat){
		// liste des arrays :
		$mandatArrays = array('typemandat', 'communemandat', 'groupepolitique', 'circonscription', 'nomepci', 'canton', 'fonctions');
		
		foreach($mandatArrays as $arrayToGenerate){
			$method = 'get'.ucFirst($arrayToGenerate).'Array';
			$this->view->assign($arrayToGenerate,$this->$method($typeMandat));
		}
	}
	
	public function getTypemandatArray($typeMandat){
		$tsconfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($this->getCurrentPageId());
		$currentArray = (!empty($tsconfig['tx_eannuaires.']['itemTypeMandat.'])) ? $tsconfig['tx_eannuaires.']['itemTypeMandat.'] : NULL ;
		return $currentArray;
	}
	
	public function getCommunemandatArray($typeMandat){
		$tsconfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($this->getCurrentPageId());
		$typeElement = $tsconfig['TCEFORM.']['tx_eannuaires_domain_model_fiche.']['typeelement.']['PAGE_TSCONFIG_ID'];

		if(intval($typeElement) > 0){
			$listeCommune = $this->ficheRepository->findByTypeelement($typeElement)->toArray();
			$communeArray = array();
			
			if(is_array($listeCommune) && count($listeCommune) > 0){
				foreach($listeCommune as $commune){
					$communeArray[$commune->getUid()] = $commune->getTitle();
				}
			}
			
			return $communeArray;
		} else {
			return NULL;
		}
	}
	
	public function getGroupepolitiqueArray($typeMandat){
		$groupepolitiqueRepo = $this->groupepolitiqueRepository;
				
		if(intval($typeMandat) > 0){
			$listeGroupe = $groupepolitiqueRepo->findByTypemandat($typeMandat)->toArray();		
			$groupeArray = array();
			
			if(is_array($listeGroupe) && count($listeGroupe) > 0){
				foreach($listeGroupe as $groupe){
					$groupeArray[$groupe->getUid()] = $groupe->getIntitule();
				}
			}
			
			return $groupeArray;
		} else {
			return NULL;
		}       
	}
	
	public function getCirconscriptionArray($typeMandat){
		$tsconfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($this->getCurrentPageId());
		$currentArray = (!empty($tsconfig['tx_eannuaires.']['itemCircLegislative.'])) ? $tsconfig['tx_eannuaires.']['itemCircLegislative.'] : NULL ;
		return $currentArray;
	}
	
	public function getNomepciArray($typeMandat){
		$tsconfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($this->getCurrentPageId());
		$pid = $tsconfig['TCEFORM.']['tx_eannuaires_domain_model_fiche.']['pid.']['PAGE_TSCONFIG_ID'];

		if(intval($pid) > 0){
			$listeEpci = $this->ficheRepository->findByPid($pid)->toArray();
			$epciArray = array();
			
			if(is_array($listeEpci) && count($listeEpci) > 0){
				foreach($listeEpci as $epci){
					$epciArray[$epci->getUid()] = $epci->getTitle();
				}
			}
			
			return $epciArray;
		} else {
			return NULL;
		}
	}
	
	public function getCantonArray($typeMandat){
		$tsconfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($this->getCurrentPageId());
		$currentArray = (!empty($tsconfig['tx_eannuaires.']['itemCanton.'])) ? $tsconfig['tx_eannuaires.']['itemCanton.'] : NULL ;
		return $currentArray;
	}
	
	public function getFonctionsArray($typeMandat){
		$tsconfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($this->getCurrentPageId());
		$currentArray = (!empty($tsconfig['tx_eannuaires.']['itemFonctions.'])) ? $tsconfig['tx_eannuaires.']['itemFonctions.'] : NULL ;
		return $currentArray;
		
	}
	
	/**
	 * action edition frontend pour la table tx_eannuaires_domain_model_mandat
	 *
	 * @param \array $mandat
	 * @return void
	 */
	public function createMandatAction($mandat){
				
		$feUser = $this->getFrontendUser();
		$existingMandat = $feUser ? $feUser->getKey('user', 'inlineForm-Mandat') : null;
		
		if(empty($existingMandat)){
			$existingMandat = array();
		}
		
		$existingMandat[] = $mandat;
				
		/*** PAS DE CREATION D'ENREGISTREMENT ICI, ON ATTEND LA SOUMISSION DU FORMULAIRE POUR EVITER DE CREER DES ENREGISTREMENTS INUTILE SI LA PERSONNE NE VALIDE PAS ***/
		/*** A LA PLACE ON STOCKE EN SESSION, ON GENERERA LES OBJET PLUS TARD ***/
		$feUser = $this->getFrontendUser();
		if ($feUser) {
			$feUser->setKey('user', 'inlineForm-Mandat', $existingMandat);
		}
		
		
		$this->forward('editMandat',null,null,array());
	}
	
	/**
	 * action edition frontend pour le champ documents > champ du FAL
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Documents $documents
	 * @return void
	 */
	public function editDocumentsAction(\Emagineurs\EAnnuaires\Domain\Model\Documents $documents = null){
		$arrayAssignation = [];
        
		if($documents === null){
			$documents = CoreGeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Documents::class);
		}
		
		$feUser = $this->getFrontendUser();
		$datasFromSession = $feUser ? $feUser->getKey('user', 'inlineForm-Documents') : null;
		
        // $this->view->assign('submittedDocuments', $datasFromSession);
        $arrayAssignation['submittedDocuments'] = $datasFromSession;
		
		// $this->view->assign('documents', $documents);
		$arrayAssignation['documents'] = $documents;
				
		$conf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['e_annuaires'] ?? [];
		$typedisplayArray = explode(',', $conf['typedisplay'] ?? '');
		$typedisplay = array();
		
		foreach($typedisplayArray as $type){
			$typedisplay[$type] = $type;
		}
		
		// $this->view->assign('typedisplay', $typedisplay);
		$arrayAssignation['typedisplay'] = $typedisplay;
		
        
		$this->view->assignMultiple($arrayAssignation);
	}
	
	/**
	 * action edition frontend pour le champ documents > champ du FAL
	 *
	 * @param \array $documents
	 * @return void
	 */
	public function createDocumentsAction($documents){
				
		$feUser = $this->getFrontendUser();
		$existingDocuments = $feUser ? $feUser->getKey('user', 'inlineForm-Documents') : null;

		$existingFiles = $feUser ? $feUser->getKey('user', 'inlineFormUpload') : null;
		$existingFilesSave = $existingFiles;
						
		$feUser = $this->getFrontendUser();
		if ($feUser) {
			$feUser->setKey('user', 'inlineFormUpload', null);
		}
		
		if(is_array($existingFilesSave) && count($existingFilesSave) > 0){
			foreach($existingFilesSave['documents'] as $field => $currentFileIdentifier){
				$documents[$field] = $currentFileIdentifier;
			}
		}
		
		if(empty($existingDocuments)){
			$existingDocuments = array();
		}
		
		$existingDocuments[] = $documents;
							
		/*** PAS DE CREATION D'ENREGISTREMENT ICI, ON ATTEND LA SOUMISSION DU FORMULAIRE POUR EVITER DE CREER DES ENREGISTREMENTS INUTILE SI LA PERSONNE NE VALIDE PAS ***/
		/*** A LA PLACE ON STOCKE EN SESSION, ON GENERERA LES OBJET PLUS TARD ***/
		$feUser = $this->getFrontendUser();
		if ($feUser) {
			$feUser->setKey('user', 'inlineForm-Documents', $existingDocuments);
		}
		
		
		$this->forward('editDocuments',null,null,array());
	}
	
	/**
	 * action edition frontend pour le champ Uploadimage > champ du FAL
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Image $uploadimage
	 * @return void
	 */
	public function editUploadimageAction(\Emagineurs\EAnnuaires\Domain\Model\Image $uploadimage = null){
		$arrayAssignation = [];
        
		if($uploadimage === null){
			$uploadimage = CoreGeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Image::class);
		}
		
		$feUser = $this->getFrontendUser();
		$datasFromSession = $feUser ? $feUser->getKey('user', 'inlineForm-Image') : null;
		
        // $this->view->assign('submittedUploadimage', $datasFromSession);
        $arrayAssignation['submittedUploadimage'] = $datasFromSession;
		
		// $this->view->assign('uploadimage', $uploadimage);
		$arrayAssignation['uploadimage'] = $uploadimage;
				
        
		$this->view->assignMultiple($arrayAssignation);
	}
	
	/**
	 * action edition frontend pour le champ uploadimage > champ du FAL
	 *
	 * @param \array $uploadimage
	 * @return void
	 */
	public function createUploadimageAction($uploadimage){
				
		$feUser = $this->getFrontendUser();
		$existingUploadimage = $feUser ? $feUser->getKey('user', 'inlineForm-Image') : null;

		$existingFiles = $feUser ? $feUser->getKey('user', 'inlineFormUpload') : null;
		$existingFilesSave = $existingFiles;
						
		$feUser = $this->getFrontendUser();
		if ($feUser) {
			$feUser->setKey('user', 'inlineFormUpload', null);
		}
		
		if(is_array($existingFilesSave) && count($existingFilesSave) > 0){
			foreach($existingFilesSave['uploadimage'] as $field => $currentFileIdentifier){
				$uploadimage[$field] = $currentFileIdentifier;
			}
		}
		
		if(empty($existingUploadimage)){
			$existingUploadimage = array();
		}
		
		$existingUploadimage[] = $uploadimage;
							
		/*** PAS DE CREATION D'ENREGISTREMENT ICI, ON ATTEND LA SOUMISSION DU FORMULAIRE POUR EVITER DE CREER DES ENREGISTREMENTS INUTILE SI LA PERSONNE NE VALIDE PAS ***/
		/*** A LA PLACE ON STOCKE EN SESSION, ON GENERERA LES OBJET PLUS TARD ***/
		$feUser = $this->getFrontendUser();
		if ($feUser) {
			$feUser->setKey('user', 'inlineForm-Image', $existingUploadimage);
		}
		

		
		$this->forward('editUploadimage',null,null,array());
	}

	/**
	 * Set fields edited through a RTE
	 */
	public function setRteValues($rte,$fiche){
		if(is_array($rte) && !empty($rte)){
			// Pour chaque champ identifé comme un rte dans le template fluid,
			foreach($rte as $key => $value){
				// On récupère la cellule du tableau des RTE qui contient la valeur à mettre à jour
				if(strpos($key,'_TRANSFORM_') === false){
					// On génère le nom du setter correspondant
					$setter = 'set'.ucFirst($key);
					// On l'appelle pour modifier la valeur de l'objet fiche
					$fiche->$setter($value);
				}
			}
			return $fiche;
		}
	}

	/**
	 * action delete
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche
	 * @return void
	 */
	#[IgnoreValidation(['value' => 'fiche'])]
	public function deleteAction(\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche) {
		$this->ficheRepository->remove($fiche);
		
		$this->persistenceManager->persistAll();
			
		$this->forward('manage',null,null,array('status' => 'deleted'));
	}

	/**
	 * Handle the sending of the differents mails
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche
	 * @return void
	 */
	#[IgnoreValidation(['value' => 'fiche'])]
	public function sendMails(\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche) {
	    $typeelement = reset($fiche->getTypeelement());
		if($this->settings['sendMail'][$typeelement]['sendToUser'] == '1') {
            $this->sendMailUser($fiche, $this->settings, 'user');
		}
		if($this->settings['sendMail'][$typeelement]['sendToAdmin'] == '1') {
			$this->sendMailAdmin($fiche, $this->settings, 'admin');
		}
		if($this->settings['sendMail'][$typeelement]['sendToFicheManager'] == '1') {
			$this->sendMailFicheManager($fiche, $this->settings, 'manager');
		}
	}

	/**
	 * Handle the sending of the differents mails
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche
	 * @return void
	 */
	#[IgnoreValidation(['value' => 'fiche'])]
	public function sendMailUser(\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche) {
        GeneralUtility::sendMail($fiche, 'user', $this->settings);
	}

	/**
	 * Handle the sending of the differents mails
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche
	 * @return void
	 */
	#[IgnoreValidation(['value' => 'fiche'])]
	public function sendMailAdmin(\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche) {
		GeneralUtility::sendMail($fiche, 'admin', $this->settings);
	}

	/**
	 * Handle the sending of the differents mails
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche
	 * @return void
	 */
	#[IgnoreValidation(['value' => 'fiche'])]
	public function sendMailFicheManager(\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche) {
		GeneralUtility::sendMail($fiche, 'manager', $this->settings);
	}
	
	public function errorAction(): \Psr\Http\Message\ResponseInterface
	{
		$this->clearCacheOnError();
		foreach ($this->arguments->getValidationResults()->getFlattenedErrors() as $errors) {
			foreach ($errors as $error) {
		        $this->addFlashMessage($error->render(), '', ContextualFeedbackSeverity::ERROR);
			}
		}
        return $this->forwardToReferringRequest();
	}
}
?>