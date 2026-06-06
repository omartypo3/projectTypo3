<?php

declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 xley <xley@e-magineurs.com>
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
use Emagineurs\EAnnuaires\Domain\Repository\CityRepository;
use Emagineurs\EAnnuaires\Domain\Repository\CategorieRepository;
use Emagineurs\EAnnuaires\Utility\GeneralUtility;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility as CoreGeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;


/**
 * Fiche Controller
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FicheController extends ActionController
{
	protected ?array $currentUser = null;

	public function __construct(
		protected readonly FicheRepository $ficheRepository,
		protected readonly CityRepository $communeRepository,
		protected readonly CategorieRepository $categorieRepository,
		protected readonly GeneralUtility $utility,
		protected readonly Context $context
	) {
	}

	/**
	 * initialize action
	 */
	public function initializeAction(): void
	{
		if ($this->arguments->hasArgument('newFiche')) {
			$this->arguments->getArgument('newFiche')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('upload', 'array');
		}

		$this->TSinPlugin();
		$frontendUserAspect = $this->context->getAspect('frontend.user');
		$userId = $frontendUserAspect->get('id');
		if ($userId > 0) {
			// Get user data from request attribute if available
			$feUser = $this->request->getAttribute('frontend.user');
			if ($feUser !== null && isset($feUser->user)) {
				$this->currentUser = $feUser->user;
			} else {
				// Fallback: Get full user data from database if request attribute not available
				$frontendController = $this->request->getAttribute('frontend.controller');
				if ($frontendController !== null) {
					$reflection = new \ReflectionClass($frontendController);
					if ($reflection->hasProperty('fe_user')) {
						$feUserProperty = $reflection->getProperty('fe_user');
						$feUser = $feUserProperty->getValue($frontendController);
						if ($feUser !== null && isset($feUser->user)) {
							$this->currentUser = $feUser->user;
						} else {
							$this->currentUser = ['uid' => $userId];
						}
					} else {
						$this->currentUser = ['uid' => $userId];
					}
				} else {
					$this->currentUser = ['uid' => $userId];
				}
			}
		} else {
			$this->currentUser = null;
		}

		$this->useTsIfFlexIsEmpty();
	}

	public function useTsIfFlexIsEmpty(): void
	{
		$confTsComplete = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

		if (($GLOBALS['TYPO3_REQUEST'] ?? null)?->getAttribute('applicationType') === 1) {
			$confTSWithDots = $confTsComplete['plugin.']['tx_eannuaires.']['settings.'] ?? [];
		} else {
			$confTSWithDots = $confTsComplete['module.']['tx_eannuaires_annuaireoffre.']['settings.'] ?? [];
		}

		$confTS = \Emagineurs\EAnnuaires\Utility\GeneralUtility::removeDotsInConf($confTSWithDots);

		foreach ($confTS as $conf => $value) {
			if (!array_key_exists($conf, $this->settings) || empty($this->settings[$conf])) {
				if (!empty($value)) {
					$this->settings[$conf] = $value;
				}
			}
		}
	}

	/**
	 * action list
	 */
	public function listAction(): ResponseInterface
	{
		
		$cObj = CoreGeneralUtility::makeInstance(ContentObjectRenderer::class);	
		$this->ficheRepository->setSettings($this->settings, ['liste' => 1, 'cObj' => $cObj]);
		$arrayAssignation = [];

		$currentRequest = $this->request->getArguments();

		if (!empty($currentRequest['communeUid'])) {
			$commune = $this->getCommuneUid((int)$currentRequest['communeUid']);
		}
		if (!empty($currentRequest['commissionUid'])) {
			$commission = $this->getCommissionUid((int)$currentRequest['commissionUid']);
		}
		if ($this->settings['getListe'] ?? false) {
			foreach ($this->settings['getListe'] as $listeNom => $listeItems) {
				$arrayAssignation[$listeNom] = $this->getListeItems($listeItems);
			}
		}

		// Info dechets
		if (in_array($this->settings['templateLayoutListe'] ?? 0, [50, 51], true)) {
			$fiches = $this->ficheRepository->findWithSettingsRaw($currentRequest);
		} else {
			$fiches = $this->ficheRepository->findWithSettings($currentRequest);

			if ($this->settings['organigramme']['chef'] ?? false) {
				$organigramme = $this->generateOrganigramme($fiches);
			}
		}

		$totalFiches = $this->ficheRepository->findWithSettings($currentRequest, 1);

		if($this->settings['pageBrowser'] != 0){
			$itemsPerPage = (int)(($paginationConfiguration['nbElement'] ?? '') ?: 10);
			$currentPage = max(1, $this->request->hasArgument('currentPage') ? (int)$this->request->getArgument('currentPage') : 1);
			$paginator = new ArrayPaginator($fiches, $currentPageNumber, $itemsPerPage);
			$pagination = new SimplePagination($paginator);

			$this->view->assign('pagination', [
				'currentPage' => $currentPage,
				'paginator' => $paginator,
				'pagination' => $pagination,
			]);
			
		}

		$arrayAssignation['totalFiches'] = $totalFiches;
		$arrayAssignation['countFiches'] = $paginate ?? null;
		$arrayAssignation['commune'] = $commune ?? null;
		$arrayAssignation['commissionItem'] = $commission ?? null;
		$arrayAssignation['settings'] = $this->settings;
		$arrayAssignation['fiches'] = $fiches;
		$arrayAssignation['organigramme'] = $organigramme ?? null;

		$this->view->assignMultiple($arrayAssignation);
		return $this->htmlResponse();
	}

	public function getListeItems(string $listeItems): array
	{
		$select = '*';
		$table = $listeItems;
		$where = ' deleted = 0 AND hidden = 0 ';

		$queryBuilder = CoreGeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)
			->getQueryBuilderForTable($table);
		$req = $queryBuilder
			->select('*')
			->from($table)
			->where(
				$queryBuilder->expr()->eq('deleted', 0),
				$queryBuilder->expr()->eq('hidden', 0)
			)
			->executeQuery()
			->fetchAllAssociative();

		$result = [];
		foreach ($req as $item) {
			if ($this->utility->checkRootPage($item['pid']) === true) {
				$result[] = $item;
			}
		}

		return $result;
	}

	public function getCommuneUid(int $communeUid): ?\Emagineurs\EAnnuaires\Domain\Model\City
	{
		return $this->communeRepository->findByUid($communeUid);
	}

	public function getCommissionUid(int $commissionUid): ?array
	{
		$queryBuilder = CoreGeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)
			->getQueryBuilderForTable('tx_eannuaires_domain_model_commission');
		
		$result = $queryBuilder
			->select('*')
			->from('tx_eannuaires_domain_model_commission')
			->where(
				$queryBuilder->expr()->eq('deleted', 0),
				$queryBuilder->expr()->eq('hidden', 0),
				$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($commissionUid, \PDO::PARAM_INT))
			)
			->executeQuery()
			->fetchAssociative();

		return $result ?: null;
	}

	public function generateOrganigramme(iterable $fiches): array
	{
		$result = [];
		$chefField = $this->settings['organigramme']['chef'];
		$getterChef = 'get' . ucfirst($chefField);
		
		foreach ($fiches as $fiche) {
			if ($fiche->$getterChef() == 1) {
				foreach ($fiche->getCategories() as $category) {
					$result[$category->getUid()][0][$fiche->getUid()] = $fiche;
					break;
				}
			} else {
				foreach ($fiche->getCategories() as $category) {
					$result[$category->getUid()][1][$fiche->getUid()] = $fiche;
					break;
				}
			}
			ksort($result);
		}

		return $result;
	}

	/**
	 * action search
	 */
	public function searchAction(): ResponseInterface
	{
		$cObj = CoreGeneralUtility::makeInstance(ContentObjectRenderer::class);	

		$this->ficheRepository->setSettings($this->settings, ['cObj' => $cObj]);
		$arrayAssignation = [];
		$currentRequest = $this->request->getArguments();

		$searchObjet = CoreGeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Search::class);
		if (!empty($currentRequest['search'])) {
			$searchObjet = $this->setSearchObjet($searchObjet, $currentRequest);
		}

		$properties = $this->settings['search']['properties'] ?? [];

		foreach ($properties as $key => $property) {
			if (is_array($property)) {
				if (array_key_exists('array', $property)) {
					$currentArray = $this->utility->getArrayForSearchForm($property['array'], $this->settings);

					$arrayAssignation[$key] = $currentArray;
				}
			}
		}

		$arrayAssignation['settings'] = $this->settings;
		$arrayAssignation['searchObjet'] = $searchObjet;

		$this->view->assignMultiple($arrayAssignation);
		return $this->htmlResponse();
	}

	public function setSearchObjet(object $searchObjet, array $currentRequest): object
	{
		if (is_array($currentRequest['search']) && count($currentRequest['search']) > 0) {
			foreach ($currentRequest['search'] as $field => $value) {
				$setMethod = 'set' . ucFirst($field);

				$searchObjet->$setMethod($value);
			}
		}

		return $searchObjet;
	}

	/**
	 * action resultat
	 */
	public function resultatAction(): ResponseInterface
	{
		$cObj = CoreGeneralUtility::makeInstance(ContentObjectRenderer::class);	

		$this->ficheRepository->setSettings($this->settings, ['cObj' => $cObj]);
		$arrayAssignation = [];
		$currentRequest = $this->request->getArguments();

		// Si on a des critères de recherche, on les applique en indiquant qu'on est dans une recherche
		if ($currentRequest['search'] ?? false) {
			$this->ficheRepository->setSettings($this->settings, ['search' => 1]);

			// On affiche la liste des fiches, les critère de recherche sont contenus dans $currentRequest
			$fiches = $this->ficheRepository->findWithSettings($currentRequest);
			$totalFiches = $this->ficheRepository->findWithSettings($currentRequest, 1);

			if ($this->settings['organigramme']['chef'] ?? false) {
				$organigramme = $this->generateOrganigramme($fiches);
			}
		}
		
		$arrayAssignation['totalFiches'] = $totalFiches ?? null;
		$arrayAssignation['countFiches'] = $paginate ?? null;
		$arrayAssignation['fiches'] = $fiches ?? null;
		$arrayAssignation['searchObjet'] = $currentRequest['search'] ?? null;
		$arrayAssignation['organigramme'] = $organigramme ?? null;

		$this->view->assignMultiple($arrayAssignation);
		return $this->htmlResponse();
	}

	/**
	 * action show
	 */
	public function showAction(?\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche = null): ResponseInterface
	{
		$arrayAssignation = [];
		if ($fiche === null) {
			if (!empty($this->settings['filtre']['whichMember']['value'])) {
				$uid = explode(',', $this->settings['filtre']['whichMember']['value']);
				$uidUsed = (int)$uid[0];

				$fiche = $this->ficheRepository->findByUid($uidUsed);
			}
		}

		if ($fiche === null) {
			$this->view->assign('noFiche', true);
		} else {
			$currentRequest = $this->request->getArguments();

			// On passe également l'url du site car dans les player les adresses relatives se basent sur le dossier du player et pas sur le baseurl
			$siteUrl = CoreGeneralUtility::getIndpEnv('TYPO3_SITE_URL');
			$this->settings['siteUrl'] = $siteUrl;

			$this->titleTag($fiche->getTitle());

			$arrayAssignation['currentRequest'] = $currentRequest;
			$arrayAssignation['fiche'] = $fiche;
			$arrayAssignation['settings'] = $this->settings;
		}

		$this->view->assignMultiple($arrayAssignation);
		return $this->htmlResponse();
	}

	public function titleTag(string $titlePage): void
	{
		$content = trim($titlePage);
		if (!empty($content)) {
			// Get frontend controller from request attribute 
			$frontendController = $this->request->getAttribute('frontend.controller');
			if ($frontendController !== null) {
				// Set page title and indexed document title directly
				$frontendController->page['title'] = $content;
				if (property_exists($frontendController, 'indexedDocTitle')) {
					$reflection = new \ReflectionClass($frontendController);
					if ($reflection->hasProperty('indexedDocTitle')) {
						$property = $reflection->getProperty('indexedDocTitle');
						$property->setValue($frontendController, $content);
					}
				}
			}
		}
	}

	/**
	 * action catmenu
	 */
	public function catmenuAction(): ResponseInterface
	{
		if ($this->settings['filtre']['categories']['value'] ?? false) {
			$cats = explode(',', $this->settings['filtre']['categories']['value']);
			$categories = $this->categorieRepository->findFromSettings($cats);
		} else {
			$categories = $this->categorieRepository->findCatFirstLvl();
		}

		$this->view->assign('categories', $categories);

		return $this->htmlResponse();
	}

	public function TSinPlugin(): void
	{
		$flexformTyposcript = $this->settings['myTS'] ?? '';
		if ($flexformTyposcript) {
			

			$filtersArray = $this->parseTypoScriptString($flexformTyposcript);
			// On enleve les "points" dans les clés du tableau
			$tsparser = \Emagineurs\EAnnuaires\Utility\GeneralUtility::removeDotsInConf($filtersArray);
			// Copy the resulting setup back into conf
			\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($this->settings, $tsparser);
		}
	}

	/**
	 * sendMail action
	 */
	public function sendMailAction(?\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche = null): ResponseInterface
	{
		$currentRequest = $this->request->getArguments();
		$arrayAssignation = [];
		$sendObjet = CoreGeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Send::class);

		// On récupère l'état à partir du paramètre activeSend, qui indique s'il faut affiché le formulaire ou envoyé le mail
		$etat = ($currentRequest['activeSend'] ?? '0') == '1' ? 'send' : 'form';

		// On envoi le mail si $etat vaut 'send'
		if ($etat == 'send') {
			$destinataire = $currentRequest['customExpediteur'] ?? '';
			$this->sendMail($fiche, $currentRequest['fields'], $destinataire);
		}

		// on assigne ensuite les valeurs au template de la vue
		// Si on est dans l'etat form on affiche le formulaire, sinon on affiche que le mail a bien été envoyé
		$arrayAssignation['fields'] = $currentRequest['fields'] ?? [];
		$arrayAssignation['etat'] = $etat;
		$arrayAssignation['sendObjet'] = $sendObjet;
		$arrayAssignation['fiche'] = $fiche;

		// Génère les tableaux configuré dans les settings via l'option properties
		$assignProperties = $this->getArrayToAssignFromProperties();

		$this->view->assignMultiple($assignProperties);
		$this->view->assignMultiple($arrayAssignation);
		
		return $this->htmlResponse();
	}

	public function getArrayToAssignFromProperties(): array
	{
		$arrayToAssign = [];

		// On récupère les propriétés définis dans les settings
		$properties = $this->settings['sendMail']['properties'] ?? [];

		// Pour chaque propriété on génère le tableau correspondant puis on l'inclut dans le tableau afin qu'il soit assigné à la vue par la suite
		foreach ($properties as $key => $property) {
			if (is_array($property)) {
				if (array_key_exists('array', $property)) {
					$currentArray = $this->utility->getArrayForSearchForm($property['array'], $this->settings);

					$arrayToAssign[$key] = $currentArray;
				}
			}
		}

		return $arrayToAssign;
	}

	public function sendMail(?\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche, array $fields, string $destinataire = ''): void
	{
		//On crée le contenu du mail et du sujet
		$assign = [
			'fields' => $fields,
			'fiche' => $fiche,
			'siteUrl' => CoreGeneralUtility::getIndpEnv('TYPO3_SITE_URL'),
			'settings' => $this->settings
		];

		// Le chemin pour le mail et le sujet peut soit être donnée sous la form du chemin du template soit en entrant directant le code du template
		// Le sujet dispose d'un textarea dans le flexform prévu à cet effet, pour le mail il est préferable d'utiliser un template externe (plus simple mais techniquement, passé directement le code fonctionne aussi)
		// mail
		$mailPath = $this->settings['sendMail']['templateMail'] ?? 'EXT:e_annuaires/Private/Templates/Custom/SendMail.html';

		$contenuMail = \Emagineurs\EAnnuaires\Utility\GeneralUtility::createTemplateFluid($mailPath, $assign);

		// sujet
		$subjectPath = $this->settings['sendMail']['sujetMail'] ?? '';
		$sujetMail = \Emagineurs\EAnnuaires\Utility\GeneralUtility::createTemplateFluid($subjectPath, $assign, 1);

		// On configure les différentes adresses mail
		$mailExpediteurMail = $this->settings['sendMail']['mailExpediteur'] ?? '';
		$nomExpediteurMail = $this->settings['sendMail']['nomExpediteur'] ?? '';
		$destinataireMail = $destinataire !== '' ? $destinataire : explode(',', $this->settings['sendMail']['destinataireMail'] ?? '');

		// On prépare le mail puis on l'envoie
		$mail = CoreGeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
		$mail->to(...(is_array($destinataireMail) ? $destinataireMail : [$destinataireMail]))
			->from(new \Symfony\Component\Mime\Address($mailExpediteurMail, $nomExpediteurMail))
			->subject($sujetMail)
			->returnPath($mailExpediteurMail)
			->replyTo(new \Symfony\Component\Mime\Address($mailExpediteurMail, $nomExpediteurMail))
			->html($contenuMail);

		$mail->send();
	}

	function parseTypoScriptString(string $tsString): array {
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


}
