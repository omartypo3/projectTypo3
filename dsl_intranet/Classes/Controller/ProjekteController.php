<?php
namespace DslFactory\DslIntranet\Controller;

use DslFactory\DslIntranet\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\Processing\FileDeletionAspect;
use DslFactory\DslIntranet\Utility\FileUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
/***
 *
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * AgenturvertraegeController
 */
class ProjekteController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	/**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
        $this->auftraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        $this->projekteRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProjekteRepository');
    }
  
    /**
     * action list
     * 
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
		
		$projekte = $this->projekteRepository->findAll();
		$projekteOffen = $this->projekteRepository->findAllOffen();
		$projekteAbgeschlossen = $this->projekteRepository->findAllAbgeschlossen();
        //echo count($projekte);die;
		$this->view->assign('projekte', $projekte);
		$this->view->assign('projekteOffen', $projekteOffen);
		$this->view->assign('projekteAbgeschlossen', $projekteAbgeschlossen);

        return $this->htmlResponse();
    }

    /**
     * action show
     * 
     * @return void
     */
    public function showAction()
    {
	//	die;
        $this->view->assign('projekt', $this->projekteRepository->findByUid((int)$_GET['tx_dslintranet_projektliste']['projekte']));
        $newDateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
        $this->view->assign('newDateien', $newDateien);
    }

    /**
     * action new
     * 
     * @return void
     */
    public function newAction()
    {
        $newProjekt = new \DslFactory\DslIntranet\Domain\Model\Projekte();
        $kundens = $this->kundenRepository->getActive();
        $this->view->assign('kundens', $kundens);
        //$newAgenturvertrag->setBeschreibung('bla');
        $now = new \DateTime();
        //$newAgenturvertrag->setBeschreibung($vertragsbegin->format("Y")." ".$vb->format("d.m.Y"));
        //$vertragsbegin->setD
        $newProjekt->setProjektbegin(new \DateTime('01.' . $now->format('m.Y')));
        $this->view->assign('projekt', $newProjekt);
    }


    /**
     * action create
     * 
     * @return void
     */
    public function createAction()
    {
        //print_r($this->request->getArguments());
        //echo "bla";
        //die;
        //$newAgenturvertrag = new \DslFactory\DslIntranet\Domain\Model\Agenturvertraege();
        $projekte = new \DslFactory\DslIntranet\Domain\Model\Projekte();

        $projekte = $this->updateProjektFromRequest($projekte);
        $this->projekteRepository->add($projekte);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //echo json_encode(array('newUid' => $newAgenturvertrag->getUid()));
        $this->view->assign('projekt', $projekte);
        $this->view->assign('returnString', json_encode(array('newUid' => $projekte->getUid())));
    }

    /**
     * action edit
     * 
     * @return void
     */
    public function editAction()
    {
	//	echo $this->request->getArgument('projekte');
		$projekte = $this->projekteRepository->findByUid($this->request->getArgument('projekte'));
	//	echo "bla";die;
		
        $kundens = $this->kundenRepository->getActive();
        $this->view->assign('kundens', $kundens);
        $this->view->assign('projekt', $projekte);
    }


    /**
     * action update
     * 
     * @return void
     */
    public function updateAction()
    {
        $projekte = $this->projekteRepository->findByUid((int)$this->request->getArgument('projekte')['__identity']);
        $projekte = $this->updateProjektFromRequest($projekte);
        $this->projekteRepository->update($projekte);
        $this->view->assign('projekt', $projekte);
        $this->view->assign('returnString', json_encode(array('editUid' => $projekte->getUid())));
		
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Projekte vertrag
     */
    private function updateProjektFromRequest($projekt)
    {
		
        if ($this->request->hasArgument('projekte')) {
            $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            $FileDeletionAspect = GeneralUtility::makeInstance(FileDeletionAspect::class);
            $fileUtility = new FileUtility($resourceFactory, $FileDeletionAspect);

            $uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('projekte');
           // $uploadSettings['falStorageSubDir'] = "quickbooks_importe";


            //$uploadedImage = $this->createUserProfileImage($image);
            // Index the image, it will move the file and return the FAL file object
			if($this->request->getArgument('projekte')['vertrag']){
				$indexedFiles = $fileUtility->indexImages($this->request->getArgument('projekte')['vertrag'], $uploadSettings['falStorageSubDir'], true);

				if (!empty($indexedFiles)) {
					$falFile = $indexedFiles[0];

					// Now, you can create a FileReference from this FAL file and save it to your model
					$fileReference = $fileUtility->createFileReferenceFromFalFileObject($falFile, 0, 0,'','');

					// Assuming you have an Event model that accepts a FileReference
					$projekt->setVertrag($fileReference);


				}
			}
        }

        if ($this->request->hasArgument('kunde')) {
            if (is_array($this->request->getArgument('kunde'))) {
                foreach ($this->request->getArgument('kunde') as $kunde) {
                    $projekt->setKunde($this->kundenRepository->findByUid($kunde));
                }
            } else {
                $projekt->setKunde($this->kundenRepository->findByUid($this->request->getArgument('kunde')));
            }
        }
        if ($this->request->hasArgument('beschreibung')) {
            $projekt->setBeschreibung($this->request->getArgument('beschreibung'));
        }
        if ($this->request->hasArgument('projektbegin')) {
            $projekt->setProjektbegin(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('projektbegin'))));
        }
        if ($this->request->hasArgument('projektende')) {
            if ($this->request->getArgument('projektende')) {
                $projekt->setProjektende(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('projektende'))));
            } else {
                $projekt->clearProjektende();
            }
        }
		if ($this->request->hasArgument('titel')) {
            $projekt->setTitel($this->request->getArgument('titel'));
        }
        //$projekt->setVertragsende(NULL);
        if ($this->request->hasArgument('stunden')) {
            $projekt->setStunden($this->request->getArgument('stunden'));
        }
        if ($this->request->hasArgument('preis')) {
            $projekt->setPreis($this->request->getArgument('preis'));
        }
        if ($this->request->hasArgument('preisMehraufwandStunde')) {
            $projekt->setPreisMehraufwandStunde($this->request->getArgument('preisMehraufwandStunde'));
        }

        if ($this->request->hasArgument('abgeschlossen')) {
            if ($this->request->getArgument('abgeschlossen')) {
                $projekt->setAbgeschlossen(true);
            } else {
                $projekt->setAbgeschlossen(false);
            }
        }

        return $projekt;
    }

    /**
     * action delete
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Projekte $projekte
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("projekte")
     * @return void
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Projekte $projekte)
    {
        /*$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);*/
        $this->projekteRepository->remove($projekte);
		$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        die;
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
                case 'deleteProjektVertrag':
                    if ($projekt = $this->projekteRepository->findByUid($this->request->getArgument('projekte'))) {
                        $projekt->clearVertrag();
                    }
                    die;
                    break;
                default:    die;
                    break;
            }
        }
        //return $this->htmlResponse();
    }
}
