<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;
use DslFactory\DslIntranet\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\Processing\FileDeletionAspect;
use DslFactory\DslIntranet\Utility\FileUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * AgenturvertraegeController
 */
class AgenturvertraegeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * agenturvertraegeRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\AgenturvertraegeRepository
     */
    protected $agenturvertraegeRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\AgenturvertraegeRepository $agenturvertraegeRepository
     */
    public function injectAgenturvertraegeRepository(\DslFactory\DslIntranet\Domain\Repository\AgenturvertraegeRepository $agenturvertraegeRepository)
    {
        $this->agenturvertraegeRepository = $agenturvertraegeRepository;
    }
	
	/**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->agenturvertraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AgenturvertraegeRepository');
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->auftraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        $this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
    }

    /**
     * action kundenlist
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function kundenlistAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action kundenshow
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function kundenshowAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action kundenajax
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function kundenajaxAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action ajax
     *
     * @return void
     */
    public function ajaxAction()
    {
		//print_r($this->request->getArguments());
        if ($this->request->hasArgument('switch')) {
            // echo "switch ja";
            $this->view->assign('switch', $this->request->getArgument('switch'));
            switch ($this->request->getArgument('switch')) {
                case 'setNewRange':    $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    $settings = $mitarbeiter->getSettingsAgenturauftrag();
                    $settings['start'] = $this->request->getArgument('start');
                    $settings['end'] = $this->request->getArgument('end');
                    //$this->view->assign('agenturvertrag', $agenturvertraege);
                    //$mitarbeiter->setSettingsAgenturauftrag($settings);
                    $mitarbeiter->setSettingsAgenturauftrag(json_encode($settings));
                    $this->mitarbeiterRepository->update($mitarbeiter);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    $agenturvertraeges = $this->agenturvertraegeRepository->findAll();
                    $this->view->assign('agenturvertraeges', $agenturvertraeges);
                    break;
                case 'setOpenAuftrag':    if ($auftrag = $this->auftraegeRepository->findByUid($this->request->getArgument('auftrag'))) {
                        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                        $mitarbeiter->addOffeneAuftraege($auftrag);
                        $mitarbeiter->setGeoeffneterAuftrag($auftrag->getUid());
                        $this->mitarbeiterRepository->update($mitarbeiter);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    }
                    //auftraege->
                    //					echo $auftrag->getUid();
                    //					echo $mitarbeiter->getUid();
                    //$benutzer = $this->mitarbeiterRepository->findByUid($user['uid']);
                    /*$benutzer->addOffeneAuftraege($auftraege);
                      $benutzer->setGeoeffneterAuftrag($auftraege->getUid());*/

                    break;
                case 'deleteAgenturvertragVertrag':    if ($agenturvertrag = $this->agenturvertraegeRepository->findByUid($this->request->getArgument('agenturvertraege'))) {
                        $agenturvertrag->clearVertrag();
                    }
                    break;
                default:    die;
                    break;
            }
        }
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $agenturvertraeges = $this->agenturvertraegeRepository->findAll();
        $this->view->assign('agenturvertraeges', $agenturvertraeges);
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
		
        $settings = $mitarbeiter->getSettingsAgenturauftrag();

        if ($settings['start']) {
            $start = new \DateTime($settings['start']);
        }
        if ($settings['end']) {
            $end = new \DateTime($settings['end']);
        }
        $this->view->assign('start', $start);
        $this->view->assign('end', $end);
        $agenturvertraegeByKunde = $this->auftraegeRepository->anzahlAVByKunde();
        $this->view->assign('agenturvertraegeByKunde', $agenturvertraegeByKunde);
        $agenturvertraegeRange = $this->auftraegeRepository->getAgenturvertraegeRange();
        $this->view->assign('agenturvertraegeRange', $agenturvertraegeRange);
        //prüfung auf einträge ohne zuordnung!!!!
        $auftraegeAgenturvertragArr = array();
        $auftraegesJahr = $this->auftraegeRepository->findAuftraegeByAgenturvertragJahr();
        foreach ($auftraegesJahr as $auftrag) {
            $auftraegeAgenturvertragArr[] = $auftrag->getUid();
        }
        $auftraegeInAgenturvertragArr = array();
        foreach ($agenturvertraeges as $av) {
            $auftraegesJahr = $this->auftraegeRepository->findAuftraegeByAgenturvertragJahr($av);
            foreach ($auftraegesJahr as $auftrag) {
                $auftraegeInAgenturvertragArr[] = $auftrag->getUid();
            }
        }
        $avOutside = array_diff($auftraegeAgenturvertragArr, $auftraegeInAgenturvertragArr);
        $avOhneZuordnung = array();
        foreach ($avOutside as $uid) {
            $avOhneZuordnung[] = $this->auftraegeRepository->findByUid($uid);
        }
        $this->view->assign('avOhneZuordnung', $avOhneZuordnung);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Agenturvertraege $agenturvertraege
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("agenturvertraege")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Agenturvertraege $agenturvertraege): \Psr\Http\Message\ResponseInterface
    {
		//\TYPO3\CMS\Core\Utility\DebugUtility::debug($agenturvertraege);
        $this->view->assign('agenturvertrag', $agenturvertraege);
        $newDateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
        $this->view->assign('newDateien', $newDateien);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        $newAgenturvertrag = new \DslFactory\DslIntranet\Domain\Model\Agenturvertraege();

        $kundens = $this->kundenRepository->getActive();
        $this->view->assign('kundens', $kundens);
        //$newAgenturvertrag->setBeschreibung('bla');
        $now = new \DateTime();
        //$newAgenturvertrag->setBeschreibung($vertragsbegin->format("Y")." ".$vb->format("d.m.Y"));
        //$vertragsbegin->setD
        $newAgenturvertrag->setVertragsbegin(new \DateTime('01.' . $now->format('m.Y')));
        $this->view->assign('agenturvertrag', $newAgenturvertrag);
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @return void
     */
    public function createAction()
    {

        $agenturvertraege = new \DslFactory\DslIntranet\Domain\Model\Agenturvertraege();

        $agenturvertraege = $this->updateAgenturvertragFromRequest($agenturvertraege);
        $this->agenturvertraegeRepository->add($agenturvertraege);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //echo json_encode(array('newUid' => $newAgenturvertrag->getUid()));
        $this->view->assign('agenturvertrag', $agenturvertraege);
        $this->view->assign('returnString', json_encode(array('newUid' => $agenturvertraege->getUid())));

    }


    /**
     * action edit
     *
     * @return void
     */
    public function editAction()
    {
        $agenturvertraege = $this->agenturvertraegeRepository->findByUid($this->request->getArgument('agenturvertraege'));

        $this->view->assign('agenturvertraege', $agenturvertraege);
		$kundens = $this->kundenRepository->getActive();

		$this->view->assign('kundens', $kundens);
    }

    /**
     * action update
     *
     * @return void
     */
    public function updateAction()
    {

        $agenturvertraege = $this->agenturvertraegeRepository->findByUid((int)$this->request->getArgument('agenturvertraege')['__identity']);
        $agenturvertraege = $this->updateAgenturvertragFromRequest($agenturvertraege);
		//die();
        $this->agenturvertraegeRepository->update($agenturvertraege);
        $this->view->assign('agenturvertrag', $agenturvertraege);
        $this->view->assign('returnString', json_encode(array('editUid' => $agenturvertraege->getUid())));
    }
	
	/**
     * @param \DslFactory\DslIntranet\Domain\Model\Agenturvertraege vertrag
     */
    private function updateAgenturvertragFromRequest($vertrag)
    {

        if ($this->request->hasArgument('agenturvertraege')) {
            $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            $FileDeletionAspect = GeneralUtility::makeInstance(FileDeletionAspect::class);
            $fileUtility = new FileUtility($resourceFactory, $FileDeletionAspect);

            $uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('agenturvertraege');

            //$uploadedImage = $this->createUserProfileImage($image);
            // Index the image, it will move the file and return the FAL file object

            if($this->request->getArgument('agenturvertraege')['vertrag']){
                $indexedFiles = $fileUtility->indexImages($this->request->getArgument('agenturvertraege')['vertrag'], $uploadSettings['falStorageSubDir'], true);
				
                if (!empty($indexedFiles)) {
                    $falFile = $indexedFiles[0];
				
                    // Now, you can create a FileReference from this FAL file and save it to your model
                    $fileReference = $fileUtility->createFileReferenceFromFalFileObject($falFile, 0, 0,'','');
					 // Assuming you have an Event model that accepts a FileReference
                    $vertrag->setVertrag($fileReference);


                }
            }


        }

        if ($this->request->hasArgument('kunde')) {
            if (is_array($this->request->getArgument('kunde'))) {
                foreach ($this->request->getArgument('kunde') as $kunde) {
                    $vertrag->setKunde($this->kundenRepository->findByUid($kunde));
                }
            } else {
                $vertrag->setKunde($this->kundenRepository->findByUid($this->request->getArgument('kunde')));
            }
        }
        if ($this->request->hasArgument('beschreibung')) {
            $vertrag->setBeschreibung($this->request->getArgument('beschreibung'));
        }
        if ($this->request->hasArgument('vertragsbegin')) {
            $vertrag->setVertragsbegin(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('vertragsbegin'))));
        }
        if ($this->request->hasArgument('vertragsende')) {
            if ($this->request->getArgument('vertragsende')) {
                $vertrag->setVertragsende(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('vertragsende'))));
            } else {
                $vertrag->clearVertragsende();
            }
        }
        //$vertrag->setVertragsende(NULL);
        if ($this->request->hasArgument('stundenMonatlich')) {
            $vertrag->setStundenMonatlich($this->request->getArgument('stundenMonatlich'));
        }
        if ($this->request->hasArgument('preisMonatlich')) {
            $vertrag->setPreisMonatlich($this->request->getArgument('preisMonatlich'));
        }
        if ($this->request->hasArgument('preisMehraufwandStunde')) {
            $vertrag->setPreisMehraufwandStunde($this->request->getArgument('preisMehraufwandStunde'));
        }

        return $vertrag;
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Agenturvertraege $agenturvertraege
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("agenturvertraege")
     * @return void
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Agenturvertraege $agenturvertraege)
    {
        $this->agenturvertraegeRepository->remove($agenturvertraege);
    }
}
