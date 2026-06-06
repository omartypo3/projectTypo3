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
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

/**
 * Offre Controller
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class OffreController extends ActionController
{
	public function __construct(
        protected readonly FicheRepository $ficheRepository,
		protected readonly PageRenderer $pageRenderer,
		protected readonly ConnectionPool $connectionPool,
        protected readonly ModuleTemplateFactory $moduleTemplateFactory
	)
	{}

	public function initializeAction(): void
	{
	}

	/**
	 * action candidatures
	 * L'essentiel de la gestion est géré par la librairie jquery DataTable
	 * On va se contenter de passer les bonnes données à la vue qui les mettra sous forme de tableau
	 */
	public function candidaturesAction(): ResponseInterface
	{
		$offres = $this->ficheRepository->findByTypeelement($this->settings['typeCandidature']);
		/*$this->view->assign('offres', $offres);
		$this->view->assign('token', hash('sha256', $_COOKIE['be_typo_user'] ?? ''));*/
		$jsFiles = [
			// Only include jQuery if necessary; TYPO3 backend already has jQuery
			'https://code.jquery.com/jquery-3.7.1.min.js',
			'EXT:e_annuaires/Resources/Public/Js/jquery.datatables.js',
			'EXT:e_annuaires/Resources/Public/Js/jquery.datatables.columnFilter.js',
			'EXT:e_annuaires/Resources/Public/Js/jquery.datatables.setup.js',
		];

		$cssFiles = [
			'EXT:e_annuaires/Resources/Public/Css/mod1_eoffresdemploi.css',
			'EXT:e_annuaires/Resources/Public/Css/table.css',
			'EXT:e_annuaires/Resources/Public/Css/bootstrap.css',

			
		];
		foreach ($jsFiles as $js) {
        	$this->pageRenderer->addJsFile($js, 'text/javascript', false, false, '', true);
		}

		foreach ($cssFiles as $css) {
			$this->pageRenderer->addCssFile($css, 'stylesheet', false, false, '', true);
		}

	



		$moduleTemplate = $this->moduleTemplateFactory->create($this->request);        
        $moduleTemplate->assignMultiple(array(
            'offres' => $offres,
            'token' => hash('sha256', $_COOKIE['be_typo_user'] ?? ''),
        ));
       return $moduleTemplate->renderResponse('Offre/Candidatures');
		
	   //return $this->htmlResponse();
	}

	/**
	 * action show
	 */
	public function showAction(?\Emagineurs\EAnnuaires\Domain\Model\Fiche $candidature = null): ResponseInterface
	{
		$args = $this->request->getArguments();

		$be_cookie = $args['token'] ?? '';
		// On vérifie que l'utilisateur est bien connecté en backend
		if (!empty($GLOBALS['BE_USER']->user) || hash('sha256', $_COOKIE['be_typo_user'] ?? '') == $be_cookie) {
			// On génère l'objet à la main si ce n'est pas fait automatiquement par extbase
			if ($candidature === null) {
				$candidature = $this->ficheRepository->findByUid($args['candidature']);
			}

			// On assigne la candidature à la vue
			$this->view->assign('candidature', $candidature);
		} else {
			return $this->htmlResponse('Vous n\'avez pas l\'autorisation d\'accéder à cette page.');
		}
		
		return $this->htmlResponse();
	}

	/**
	 * action markAsRead
	 */
	public function markAsReadAction(?\Emagineurs\EAnnuaires\Domain\Model\Fiche $candidature = null): ResponseInterface
	{
		// On récupère les arguments
		$args = $this->request->getArguments();

		// Si l'objet candidature n'a pas été généré automatiquement, on le fait à la main. (ne devrait pas arriver)
		if ($candidature === null && !empty($args['candidature'])) {
			$candidature = $this->ficheRepository->findByUid($args['candidature']);
		}

		// Si la case à cocher à la valeur 1, on va enregistré le champ comme Lu
		if (($args['markAsRead'] ?? '0') == '1') {
			// On set la nouvelle valeur
			$candidature->setCedex('Lu');
		} else {
			$candidature->setCedex('Non');
		}

		// On update dans le repo
		$this->ficheRepository->update($candidature);

		// On persist pour rendre les modifications sur l'objet effectives en base de donnée
		$persistenceManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
		$persistenceManager->persistAll();

		// On vérifie le succès de la requête en regénérant l'objet après la persistence
		$candidatureLu = $this->ficheRepository->findByUid($candidature->getUid());

		if ($candidatureLu->getCedex() == $candidature->getCedex()) {
			$this->view->assign('message', 'success');
		} else {
			$this->view->assign('message', 'fail');
		}

		$this->view->assign('etat', $candidatureLu->getCedex());
		
		return $this->htmlResponse();
	}

	/**
	 * action convertToPdf
	 */
	public function convertToPdfAction(?\Emagineurs\EAnnuaires\Domain\Model\Fiche $candidature = null): ResponseInterface
	{
		// On récupère les arguments
		$args = $this->request->getArguments();

		// Si l'objet candidature n'a pas été généré automatiquement, on le fait à la main. (ne devrait pas arriver)
		if ($candidature === null && !empty($args['candidature'])) {
			$candidature = $this->ficheRepository->findByUid($args['candidature']);
		}

		$this->view->assign('candidature', $candidature);
		
		return $this->htmlResponse();
	}

	/**
	 * sendMail action
	 */
	public function sendMailAction(?\Emagineurs\EAnnuaires\Domain\Model\Fiche $fiche = null): ResponseInterface
	{
		$currentRequest = $this->request->getArguments();
		$sendObjet = GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Send::class);

		// On récupère l'état à partir du paramètre activeSend, qui indique s'il faut affiché le formulaire ou envoyé le mail
		$etat = (($currentRequest['activeSend'] ?? '0') == '1') ? 'send' : 'form';

		// On envoi le mail si $etat vaut 'send'
		if ($etat == 'send') {
			$destinataire = $currentRequest['customExpediteur'] ?? '';

			$this->sendMail($fiche, $currentRequest['fields'] ?? [], $destinataire);
		}

		// on assigne ensuite les valeurs au template de la vue
		// Si on est dans l'etat form on affiche le formulaire, sinon on affiche que le mail a bien été envoyé
		// Note : dans l'idéal il faudra s'assurer que l'envoi de mail a effectivement fonctionné afin d'adapté le message de la vue avec l'etat send.
		$this->view->assign('fields', $currentRequest['fields'] ?? []);
		$this->view->assign('etat', $etat);
		$this->view->assign('sendObjet', $sendObjet);
		$this->view->assign('fiche', $fiche);

		// Génère les tableaux configuré dans les settings via l'option properties
		$assignProperties = $this->getArrayToAssignFromProperties();

		$this->view->assignMultiple($assignProperties);
		
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
					$utility = GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Utility\GeneralUtility::class);
					$currentArray = $utility->getArrayForSearchForm($property['array'], $this->settings);

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
			'siteUrl' => GeneralUtility::getIndpEnv('TYPO3_SITE_URL'),
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
		$mail = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
		$mail->to(...(is_array($destinataireMail) ? $destinataireMail : [$destinataireMail]))
			->from(new \Symfony\Component\Mime\Address($mailExpediteurMail, $nomExpediteurMail))
			->subject($sujetMail)
			->returnPath($mailExpediteurMail)
			->replyTo(new \Symfony\Component\Mime\Address($mailExpediteurMail, $nomExpediteurMail))
			->html($contenuMail);

		$mail->send();
	}

	/**
	 * exportCsv
	 */
	public function exportCsv(array $arrayToCsv): array
	{
		$newArray = [];
		foreach ($arrayToCsv as $key => $value) {
			$newArray[$key] = str_replace('"', '', $value);
		}
		$filename = trim($_POST['settings']['csvNameForExport'] ?? 'export.csv');
		$absoluteFileName = GeneralUtility::getFileAbsFileName('fileadmin/' . trim($_POST['settings']['csvNameForExport'] ?? 'export.csv'));

		$fp = fopen($absoluteFileName, 'w');
		fputcsv($fp, $newArray, ',');
		fclose($fp);

		// Post traiment to delete quote
		$str = file_get_contents($absoluteFileName);
		$str = str_replace('"', '', $str);
		file_put_contents($absoluteFileName, $str);

		return [$absoluteFileName, $filename];
	}

	/**
	 * export action
	 */
	public function exportAction(): ResponseInterface
	{
		$request = $_POST['request'] ?? [];
		$offres = $this->searchForExport($request);
		$resources = [];

		foreach ($offres as $offre) {
			foreach ($offre->getMedia() as $media) {
				$file = $media->getOriginalResource()->getOriginalFile();
				$resources[] = $file;
			}
			foreach ($offre->getDocuments() as $doc) {
				foreach ($doc->getFichier() as $fichier) {
					$file = $fichier->getOriginalResource()->getOriginalFile();
					$resources[] = $file;
				}
			}
		}
		$this->view->assign('offres', $offres);
		$this->view->assign('settings', $_POST['settings'] ?? []);
		$arrayToCsv = ['content' => $this->view->render()];

		$zipname = $this->createZip($resources, $arrayToCsv);
		$GLOBALS['BE_USER']->setAndSaveSessionData('export', $zipname);
		
		return $this->htmlResponse();
	}

	/**
	 * searchForExport
	 */
	public function searchForExport(array $request): iterable
	{
		// Query Initialisation
		$query = $this->ficheRepository->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);

		$constraints = [];
		foreach ($request as $requestUnit) {
			if ($requestUnit !== "") {

				// Parse the request for get real search attributes
				$typeRequest = explode(';', $requestUnit)[1] ?? '';
				$fields = explode('=', explode(';', $requestUnit)[0] ?? '')[0] ?? '';
				$values = explode('=', explode(';', $requestUnit)[0] ?? '')[1] ?? '';
				$fieldArray = explode(',', $fields);
				$fieldsExternals = explode('.', $fields);

				// The search actions ! :)
				if (count($fieldsExternals) > 1) {

					$table = 'tx_eannuaires_domain_model_fiche';
					$i = 0;
					$conf = [];
					foreach ($fieldsExternals as $fieldExternal) {
						$conf[$i] = $GLOBALS['TCA'][$table]['columns'][$fieldExternal]['config'] ?? [];
						$conf[$i]['foreign_table_to_use'] = $conf[$i - 1]['foreign_table'] ?? '';
						$table = $conf[$i]['foreign_table'] ?? '';
						$i++;
					}

					$conf = array_reverse($conf);
					$i = 0;
					$external = [];
					$externalAgain = [];
					foreach (array_reverse($fieldsExternals) as $reverseField) {
						// Reinitialize variables for good looping !
						$constraintsOr = [];
						$arrayModelBis = explode('_', $conf[$i]['foreign_table_to_use'] ?? '');
						if (isset($conf[$i]['foreign_table'])) {
							if (($conf[$i]['foreign_table'] ?? '') !== 'tx_eannuaires_domain_model_fiche') {
								// There is a foreign table - instancie repository
								$customRepo = GeneralUtility::makeInstance('Emagineurs\\EAnnuaires\\Domain\\Repository\\' . ucFirst(end($arrayModelBis)) . 'Repository');
								$query = $customRepo->createQuery();
								$query->getQuerySettings()->setRespectStoragePage(false);
								foreach ($external as $externalEach) {
									$constraintsOr[] = $query->contains($reverseField, $externalEach);
								}
								$constraints[] = $query->logicalOr($constraintsOr);
								$constraints[] = $query->equals('typeelement', $_POST['settings']['typeOffre'] ?? '');
								$externalAgain = $query->matching($query->logicalAnd($constraints))->execute();
							} else {
								// There is a foreign table but with the classic FicheRepository
								$query = $this->ficheRepository->createQuery();
								$query->getQuerySettings()->setRespectStoragePage(false);
								foreach ($externalAgain as $externalAgainEach) {
									$constraintsOr[] = $query->contains($reverseField, $externalAgainEach);
								}
								$constraints[] = $query->logicalOr($constraintsOr);
							}
						} else {
							// Direct look at the field
							$customRepoBis = GeneralUtility::makeInstance('Emagineurs\\EAnnuaires\\Domain\\Repository\\' . ucFirst(end($arrayModelBis)) . 'Repository');
							$query = $customRepoBis->createQuery();
							$query->getQuerySettings()->setRespectStoragePage(false);
							$external = $query->matching($query->like($reverseField, '%' . $values . '%'))->execute();
						}
						$i++;
					}
				} else {
					$constraintsOr = [];
					if (count($fieldArray) > 1) {
						if ($typeRequest == 'text') {
							foreach ($fieldArray as $field) {
								$constraintsOr[] = $query->like($field, '%' . $values . '%');
							}
						}
						if ($typeRequest == 'select') {
							foreach ($fieldArray as $field) {
								$constraintsOr[] = $query->equals($field, $values);
							}
						}
						if ($typeRequest == 'date') {
							foreach ($fieldArray as $field) {
								$constraints[] = $query->between(
									$field,
									strtotime(date_format(date_create_from_format('d/m/Y', $values), 'm/d/Y')),
									strtotime(date_format(date_create_from_format('d/m/Y', $values), 'm/d/Y')) + 86400
								);
							}
						}
						$constraints[] = $query->logicalOr($constraintsOr);
					} else {
						if ($typeRequest == 'text') {
							$constraints[] = $query->like($fields, '%' . $values . '%');
						}
						if ($typeRequest == 'select') {
							$constraints[] = $query->equals($fields, $values);
						}
						if ($typeRequest == 'date') {
							$constraints[] = $query->between(
								$fields,
								strtotime(date_format(date_create_from_format('d/m/Y', $values), 'm/d/Y')),
								strtotime(date_format(date_create_from_format('d/m/Y', $values), 'm/d/Y')) + 86400
							);
						}
					}
				}
			}
		}
		$constraints[] = $query->equals('typeelement', $_POST['settings']['typeCandidature'] ?? '');
		if (!empty($constraints)) {
			$query->matching($query->logicalAnd($constraints));
		}

		// Sorting gestion
		$sortingArray = explode('=', $_POST['sorting'] ?? '');
		$sortingArrayFields = explode(',', $sortingArray[0] ?? '');
		if (count($sortingArrayFields) > 0) {
			$sortingArray[0] = $sortingArrayFields[0];
		}
		if (trim($sortingArray[1] ?? '') == 'ASC') {
			$query->setOrderings([trim($sortingArray[0]) => QueryInterface::ORDER_ASCENDING]);
		}
		if (trim($sortingArray[1] ?? '') == 'DESC') {
			$query->setOrderings([trim($sortingArray[0]) => QueryInterface::ORDER_DESCENDING]);
		}
		$offres = $query->execute();

		return $offres;
	}

	/**
	 * createZip
	 */
	public function createZip(array $resources, array $arrayToCsv): string
	{
		$zip = new \ZipArchive();
		$fileToCreate = GeneralUtility::getFileAbsFileName('fileadmin/' . trim($_POST['settings']['zipNameForExport'] ?? 'export.zip'));
		$fileToDownload = '../fileadmin/' . trim($_POST['settings']['zipNameForExport'] ?? 'export.zip');
		
		if ($zip->open($fileToCreate, \ZipArchive::CREATE) !== true) {
			exit("Impossible d'ouvrir le fichier <$fileToCreate>\n");
		}
		if ($resources !== []) {
			foreach ($resources as $file) {
				$zip->addFile(GeneralUtility::getFileAbsFileName('fileadmin' . $file->getIdentifier()), $file->getName());
			}
		}
		$csv = $this->exportCsv($arrayToCsv);
		$zip->addFile($csv[0], $csv[1]);
		$zip->close();
		
		return $fileToDownload;
	}

	/**
	 * deleteAction
	 */
	public function deleteAction(): ResponseInterface
	{
		unlink(GeneralUtility::getFileAbsFileName('fileadmin/' . trim($_POST['settings']['zipNameForExport'] ?? '')));
		unlink(GeneralUtility::getFileAbsFileName('fileadmin/' . trim($_POST['settings']['csvNameForExport'] ?? '')));
		
		return $this->htmlResponse();
	}
}
