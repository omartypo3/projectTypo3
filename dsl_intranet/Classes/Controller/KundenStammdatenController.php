<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;

use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 
 */

/**
 * KundenStammdatenController
 */
class KundenStammdatenController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * kundenStammdatenRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\KundenStammdatenRepository
     */
    protected $kundenStammdatenRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\KundenStammdatenRepository $kundenStammdatenRepository
     */
    public function injectKundenStammdatenRepository(\DslFactory\DslIntranet\Domain\Repository\KundenStammdatenRepository $kundenStammdatenRepository)
    {
        $this->kundenStammdatenRepository = $kundenStammdatenRepository;
    }

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->protokolleRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');
        $this->kundenStammdatenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenStammdatenRepository');
        $this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
        $this->frontendUserRepository = $this->objectManager->get('TYPO3\\CMS\\FrontendLogin\\Domain\\Repository\\FrontendUserRepository');
    }

    /**
     * action ajax
     *
     * @return void
     */
    public function ajaxAction()
    {
        $this->view->assign('return', '');
        if ($this->request->hasArgument('switch')) {
            // echo "switch ja";
            $this->view->assign('switch', $this->request->getArgument('switch'));
            switch ($this->request->getArgument('switch')) {
                case 'requestUpdatePasswortCheckOldPassword':    $kunde = $this->kundenStammdatenRepository->getByFeUser();
                    $kundeTmp = $this->kundenRepository->findByUid($kunde->getUid());
                    $altesPwHash = $kundeTmp->getPassword();
                    $altesPw = $this->request->getArgument('password_alt');
                    if ($this->checkPassword($altesPw, $altesPwHash)) {
                        $this->view->assign('return', 'true');
                    } else {
                        $this->view->assign('return', 'false');
                    }
                    break;
                case 'requestUpdatePasswort':    $kunde = $this->kundenStammdatenRepository->getByFeUser();
                    $kundeTmp = $this->kundenRepository->findByUid($kunde->getUid());
                    $altesPwHash = $kundeTmp->getPassword();
                    $altesPw = $this->request->getArgument('password_alt');
                    //"dslweb";
                    $neuesPw = $this->request->getArgument('password_neu');
                    $neuesPw2 = $this->request->getArgument('password_neu_confirm');
                    $neuesPwCheck = FALSE;
                    if ($neuesPw == $neuesPw2) {
                        $neuesPwCheck = TRUE;
                    }
                    $neuesPwHash = $this->encryptPassword($neuesPw);
                    $pwCheck = $this->checkPassword($altesPw, $altesPwHash);
                    if ($pwCheck && $neuesPwCheck) {
                        $kundeTmp->setPassword($neuesPwHash);
                        $kundeTmp->setPasswortKopie($neuesPw);
                        $this->kundenRepository->update($kundeTmp);
                        //$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        $this->view->assign('return', 'true');
                    }
                    //echo $altesPw.','.$altesPwHash.":";
                    //echo "true";
                    //print_r(array($pwCheck,$neuesPwCheck));
                    break;
                case 'requestUpdateStammdatenCheckEmail':    if (count($this->kundenStammdatenRepository->checkOtherForEmail($this->request->getArgument('email')))) {
                    $this->view->assign('return', 'false');
                } else {
                    $this->view->assign('return', 'true');
                }
                    //echo 'false';
                    break;
                case 'requestUpdateStammdaten':  
						
					$kunde = $this->kundenStammdatenRepository->getByFeUser();
                    //echo $kunde->getUid();
						$kunde->setCompany($this->request->getArgument('company'));
						$kunde->setTitle($this->request->getArgument('title'));
						$kunde->setFirstName($this->request->getArgument('firstName'));
						$kunde->setLastName($this->request->getArgument('lastName'));
						$kunde->setZip($this->request->getArgument('zip'));
						$kunde->setCity($this->request->getArgument('city'));
						$kunde->setAddress($this->request->getArgument('address'));
						$kunde->setTelephone($this->request->getArgument('telephone'));
						$kunde->setFax($this->request->getArgument('fax'));
						$kunde->setQbBic($this->request->getArgument('qbBic'));
						$kunde->setQbBank($this->request->getArgument('qbBank'));
						$kunde->setQbKtoInh($this->request->getArgument('qbKtoInh'));
						$kunde->setQbIban($this->request->getArgument('qbIban'));
						$kunde->setQbPhone2($this->request->getArgument('qbPhone2'));
						$kunde->setQbCont2($this->request->getArgument('qbCont2'));
						$kunde->setEmail($this->request->getArgument('email'));
						$kunde->setEmailRechnungen($this->request->getArgument('emailRechnungen'));
						$kunde->setEmailAngebote($this->request->getArgument('emailAngebote'));
						$protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
						//echo $this->settings['protokollePid'];
						$protokolle->setPid((int)$this->settings['protokollePid']);
						$protokolle->setAktion(100);
						$protokolle->setZeitpunkt(new \DateTime());
						
						$feUser = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
						if (is_object($feUser)) {
    						$protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
							$protokolle->setNotiz(implode(", ", $this->request->getArguments()));
							$protokolle->sendAdminInfoMail();
							$this->protokolleRepository->add($protokolle);
						}
			
						
						 // oder per Session
						//$protokolle->setNotiz($this->request->getArgument('text'));
						
                    //zus Ansprechpartner cont2
                    //phone2
						$this->kundenStammdatenRepository->update($kunde);
						$this->view->assign('kunde', $kunde);

					
                    break;
                /*
                                                                                                                case 'requestUpdateStammdaten':
                                                                                                					//nicht mehr genutzt !=
                                                                                                					//print_r($this->request->getArgument('text'));
                                                                                                                    //echo nl2br($this->request->getArgument('text'));
                                                                                                                    $this->view->assign('text', $this->request->getArgument('text'));
                                                                                                                    $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                                                                                                                    //echo $this->settings['protokollePid'];
                                                                                                                    $protokolle->setPid($this->settings['protokollePid']);
                                                                                                                    $protokolle->setAktion(100);
                                                                                                                    $protokolle->setZeitpunkt(new \DateTime());
                                                                                                                    $protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                                                                                                                    $protokolle->setNotiz($this->request->getArgument('text'));
                                                                                                                    $protokolle->sendAdminInfoMail();
                                                                                                                    $this->protokolleRepository->add($protokolle);
                                                                                                                    break;*/

                case 'toggleSwitch':    if ($this->request->hasArgument('key')) {
                    switch ($this->request->getArgument('key')) {
                        case 'newsletter':    //echo "newsletter gefunden!!".$this->request->getArgument('value').":";
                            //if($this->request->getArgument('value')) echo "aktiv"; else echo "inaktiv";
                            //echo boolval($this->request->getArgument('value'));
                            //echo (boolval($this->request->getArgument('value')) ? 1 : 0);
                            //echo ($this->request->getArgument('value') === 'true');
                            $kunde = $this->kundenStammdatenRepository->getByFeUser();
                            $kunde->setNewsletter($this->request->getArgument('value') === 'true');
                            $this->kundenStammdatenRepository->update($kunde);
                            //echo $kunde->getNewsletter();
                            break;
                        default:    $kunde = $this->kundenStammdatenRepository->getByFeUser();
                            $settingsKunde = $kunde->getSettingsKunde();
                            $settingsKunde[$this->request->getArgument('key')] = $this->request->getArgument('value') === 'true';
                            $kunde->setSettingsKunde($settingsKunde);
                            $this->kundenStammdatenRepository->update($kunde);
                            break;
                    }
                }
                    //echo "juhu";die;
                    break;
                case 'setKundeNewsletterEmail':    if ($this->request->hasArgument('email')) {
                    //$this->request->getArgument('email')
                    $kunde = $this->kundenStammdatenRepository->getByFeUser();
                    $kunde->setEmailNewsletter($this->request->getArgument('email'));
                    $this->kundenStammdatenRepository->update($kunde);
                }
                    break;
            }
        }
    }

    //Abgeschaut aus: sf_register_6.2.8 // FeuserController.php
    /**
     * Encrypt the password
     *
     * @param string $password
     * @return string
     */
    public static function encryptPassword($password)
    {
		/** @var PasswordHashFactory $passwordHashFactory */
        $passwordHashFactory = GeneralUtility::makeInstance(PasswordHashFactory::class);
        $passwordHash = $passwordHashFactory->getDefaultHashInstance('FE');
        $password =  $passwordHash->getHashedPassword($password);
        return $password;
    }

    /**
     * Check the password
     *
     * @param string $password
     * @param string $saltedPassword
     * @return boolean
     */
    public static function checkPassword($password, $saltedPassword)
    {
       
		$passwordHashFactory = GeneralUtility::makeInstance(PasswordHashFactory::class);
        $passwordHashInstance = $passwordHashFactory->getDefaultHashInstance('FE');
		if ($passwordHashInstance) {
			return $passwordHashInstance->checkPassword($password, $saltedPassword);
		}
        return FALSE;
    }

    /**
     * action settings
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function settingsAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
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
        $kunde = $this->kundenStammdatenRepository->getByFeUser();
		if($kunde){
        //if($kunde) echo "gefunden";else echo "nicht gefunden";
        //echo $kunde->getUid()."bla;";
			if ($kunde->getUid() == 1706) {
				//echo $kunde->getKundennummer();
				//$kundeTmp = $this->kundenRepository->findByNummer(90000);
				$kundeTmp = $this->kundenRepository->findByUid($kunde->getUid());
				//echo $kundeTmp->getUid();
				$altesPwHash = $kundeTmp->getPassword();
				//			echo ":".$kundeTmp->getPasswortKopie()."!!!";
				$altesPw = 'dslweb';
				$neuesPw = 'dslfactoryweb';
				$neuesPw2 = 'dslfactoryweb';
				$neuesPwCheck = FALSE;
				if ($neuesPw == $neuesPw2) {
					$neuesPwCheck = TRUE;
				}
				$neuesPwHash = $this->encryptPassword($neuesPw);
				$pwCheck = $this->checkPassword($altesPw, $altesPwHash);
				if ($pwCheck && $neuesPwCheck) {
					$kundeTmp->setPassword($neuesPwHash);
					$kundeTmp->setPasswortKopie($neuesPw);
					$this->kundenRepository->update($kundeTmp);
					$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
				}
			}
		}else{
			 $user = $GLOBALS['TSFE']->fe_user->user;
		 $kunde = $this->kundenRepository->findByUid($user['uid']);
		}
        //$kundenStammdatens = $this->kundenStammdatenRepository->findAll();
        $this->view->assign('kunde', $kunde);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenStammdaten $kundenStammdaten
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\KundenStammdaten $kundenStammdaten): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('kundenStammdaten', $kundenStammdaten);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenStammdaten $newKundenStammdaten
     */
    public function createAction(\DslFactory\DslIntranet\Domain\Model\KundenStammdaten $newKundenStammdaten)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenStammdatenRepository->add($newKundenStammdaten);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenStammdaten $kundenStammdaten
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("kundenStammdaten")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\KundenStammdaten $kundenStammdaten): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('kundenStammdaten', $kundenStammdaten);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenStammdaten $kundenStammdaten
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\KundenStammdaten $kundenStammdaten)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenStammdatenRepository->update($kundenStammdaten);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\KundenStammdaten $kundenStammdaten
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\KundenStammdaten $kundenStammdaten)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->kundenStammdatenRepository->remove($kundenStammdaten);
        $this->redirect('list');
    }
}
