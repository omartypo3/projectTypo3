<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Domain\Model;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * Protokolle
 */
class Protokolle extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * hidden
     * 
     * @var bool
     */
    protected $hidden;

    /**
     * forceMailSettings
     * 
     * @var string
     */
    protected $forceMailSettings;
    /**
     * aktion
     *
     * @var int
     */
    protected $aktion;

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz;

    /**
     * kundeninfoTime
     *
     * @var \DateTime
     */
    protected $kundeninfoTime;

    /**
     * kundeninfoMail
     *
     * @var string
     */
    protected $kundeninfoMail;

    /**
     * notizSystem
     *
     * @var string
     */
    protected $notizSystem;

    /**
     * zeitpunkt
     *
     * @var \DateTime
     */
    protected $zeitpunkt;

    /**
     * kundeninfoSichtbarkeit
     *
     * @var int
     */
    protected $kundeninfoSichtbarkeit;

    /**
     * auftragStatusAlt
     *
     * @var int
     */
    protected $auftragStatusAlt;

    /**
     * auftragStatusNeu
     *
     * @var int
     */
    protected $auftragStatusNeu;

    /**
     * auftrag
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Auftraege
     */
    protected $auftrag;

    /**
     * datei
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Dateien
     */
    protected $datei;

    /**
     * pending
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\ProtokollePending>
     */
    protected $pending;

    /**
     * agenturvertrag
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Agenturvertraege
     */
    protected $agenturvertrag;

    /**
     * cruser
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $cruser;

    /**
     * Returns the aktion
     *
     * @return int
     */
    public function getAktion()
    {
        return $this->aktion;
    }

    /**
     * Sets the aktion
     *
     * @param int $aktion
     * @return void
     */
    public function setAktion(int $aktion)
    {
        $this->aktion = $aktion;
        switch ($aktion) {
            case 5:    /* Auftragsstatus Änderung */
                $this->notizSystem = 'Auftrag angelegt';
                $this->kundeninfoSichtbarkeit = 1;
                break;
            case 10:    /* Auftragsstatus Änderung */
                $this->notizSystem = 'Statusänderung: ' . $this->auftrag->getStatusText();
                $this->kundeninfoSichtbarkeit = 1;
                break;
            case 20:    /* Manueller Kommentar */
                break;
            case 30:    /* Wartungsvertrag Rechnung Status auf fällig gesetzt */
                break;
            case 40:    /* Wartungsvertrag Rechnung für zeitraum Neu erstellt  */
                break;
            case 50:    /* Wartungsvertrag Zeitraum Neu erstellt  */
                break;
            case 60:    /* Wartungsvertrag Rechnung Status auf erledigt/berechnet (30 gesetzt)  */
                break;
            case 70:    /* Wartungsvertrag Rechnung Mehraufwand Status auf erledigt/berechnet gesetzt  */
                break;
            case 80:    /* Wartungsvertrag Rechnung Zeitraum Status änderung von 0 auf Mehraufwand berechnen oder nicht  */
                break;
            case 90:    /* Finanzcenter datei bereitgestellt  */
                $this->notizSystem = 'Finanzcenter / Datei bereitgestellt / ' . $this->datei->getDateiName() . ' / ' . $this->datei->getTypeName();
                $this->kundeninfoSichtbarkeit = 1;
                break;
            case 100:    /*Stammdatenänderung Antrag durch kunde*/
                break;
        }
    }

    /**
     * Returns the notiz
     *
     * @return string
     */
    public function getNotiz()
    {
         if ($this->getAktion() == 100) {
            return unserialize($this->notiz);
        } else {
            return $this->notiz;
        }
    }

    /**
     * Sets the notiz
     *
     * @param string $notiz
     * @return void
     */
    public function setNotiz(string $notiz)
    {
       if ($this->getAktion() == 100) {
            $this->notiz = serialize($notiz);
        } else {
            $this->notiz = $notiz;
        }
    }

    /**
     * Returns the kundeninfoTime
     *
     * @return \DateTime
     */
    public function getKundeninfoTime()
    {
        return $this->kundeninfoTime;
    }

    /**
     * Sets the kundeninfoTime
     *
     * @param \DateTime $kundeninfoTime
     * @return void
     */
    public function setKundeninfoTime(\DateTime $kundeninfoTime)
    {
        $this->kundeninfoTime = $kundeninfoTime;
    }

    /**
     * Returns the kundeninfoMail
     *
     * @return string
     */
    public function getKundeninfoMail()
    {
        return $this->kundeninfoMail;
    }

    /**
     * Sets the kundeninfoMail
     *
     * @param string $kundeninfoMail
     * @return void
     */
    public function setKundeninfoMail(string $kundeninfoMail)
    {
        $this->kundeninfoMail = $kundeninfoMail;
    }

    /**
     * Returns the notizSystem
     *
     * @return string
     */
    public function getNotizSystem()
    {
        return $this->notizSystem;
    }
	
	 /**
     * Returns the notizSystemMail
     * 
     * @return string $notizSystemMail
     */
    public function getNotizSystemKunde()
    {
        switch ($this->aktion) {
            case 10:    /* Auftragsstatus Änderung */
                $statusArr = $this->getAuftrag()->getStatussKunde();
                //getStatussKunde
                return 'Statusänderung: ' . $statusArr[$this->getAuftragStatusNeu()];
                //return "Statusänderung: <f:translate key="tx_dslintranet_domain_model_auftraege.kundenstatusnr.{protokolle.auftragStatusNeu}" />. <f:translate key="tx_dslintranet_domain_model_auftraege.kundenstatus.{protokolle.auftragStatusNeu}" />";
                // return $this->auftrag->getStatusText();
                break;
        }
        return $this->notizSystem;
    }
	
	 /**
     * Returns the notizSystemMail
     * 
     * @return string $notizSystemMail
     */
    public function getNotizSystemMail()
    {
        switch ($this->aktion) {
            case 5:    /* Auftragsstatus Änderung */
                return $this->notizSystem;
                break;
            case 10:    /* Auftragsstatus Änderung */
                return $this->auftrag->getStatusText();
                break;
            case 20:    /* Manueller Kommentar */
                break;
            case 30:    /* Wartungsvertrag Rechnung Status auf fällig gesetzt */
                break;
            case 40:    /* Wartungsvertrag Rechnung für zeitraum Neu erstellt  */
                break;
            case 50:    /* Wartungsvertrag Zeitraum Neu erstellt  */
                break;
            case 60:    /* Wartungsvertrag Rechnung Status auf erledigt/berechnet (30 gesetzt)  */
                break;
            case 70:    /* Wartungsvertrag Rechnung Mehraufwand Status auf erledigt/berechnet gesetzt  */
                break;
            case 80:    /* Wartungsvertrag Rechnung Zeitraum Status änderung von 0 auf Mehraufwand berechnen oder nicht  */
                break;
            case 90:    /* Wartungsvertrag Rechnung Zeitraum Status änderung von 0 auf Mehraufwand berechnen oder nicht  */
                return $this->notizSystem;
                break;
        }
    }

    /**
     * Sets the notizSystem
     *
     * @param string $notizSystem
     * @return void
     */
    public function setNotizSystem(string $notizSystem)
    {
        $this->notizSystem = $notizSystem;
    }

    /**
     * Returns the zeitpunkt
     *
     * @return \DateTime
     */
    public function getZeitpunkt()
    {
        return $this->zeitpunkt;
    }

    /**
     * Sets the zeitpunkt
     *
     * @param \DateTime $zeitpunkt
     * @return void
     */
    public function setZeitpunkt(\DateTime $zeitpunkt)
    {
        $this->zeitpunkt = $zeitpunkt;
    }
	
	 /**
     * Sets hidden
     * 
     * @param boolean $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Returns the boolean state of hidden
     * 
     * @return boolean
     */
    public function isHidden()
    {
        return $this->getHidden();
    }

    /**
     * Returns hidden
     * 
     * @return boolean $hidden
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /*dsl userrights*/
    public function getRights()
    {
        $rights = array(
            'edit' => false,
            'delete' => false,
            'mail' => false
        );
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        foreach ($this->getAuftrag()->getMitarbeiter() as $ma) {
            if ($ma == $mitarbeiter) {
                $rights['mail'] = true;
            }
        }
        if (method_exists($mitarbeiter, 'getRechteExternerMitarbeiter')) {
            if($mitarbeiter->getRechteExternerMitarbeiter()){
                $rights['mail'] = false;
            }
        }
        if ($this->isKommentar()) {
            foreach ($this->getAuftrag()->getMitarbeiter() as $ma) {
                if ($ma == $mitarbeiter) {
                    if ($this->getCruser() == $mitarbeiter) {
                        $rights['delete'] = true;
                        $rights['edit'] = true;
                    }
                }
            }
            if (method_exists($mitarbeiter, 'getRechteAdminAuftraege')) {
                if ($mitarbeiter->getRechteAdminAuftraege()) {
                    $rights['delete'] = true;
                    $rights['edit'] = true;
                }
            }
            /* if ($mitarbeiter == $this->getCruser()) {
               $rights['delete'] = true;
               }*/
			if($this->getCruser()){
				if ($this->getCruser()->isKunde()) {
					//wenn der kommentar durch den kunden erstellt wurde
					$rights['delete'] = true;
				}
			}
        }
        return $rights;
    }

    public function toggleKundeninfoSichtbarkeit()
    {
        if ($this->kundeninfoSichtbarkeit) {
            $this->kundeninfoSichtbarkeit = 0;
        } else {
            $this->kundeninfoSichtbarkeit = 1;
        }
    }

    public function getShowBtnToggleKundeninfoSichtbarkeit()
    {
        $rights = $this->getRights();
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($mitarbeiter->getRechteAdminAuftraege()) {
            return true;
        }
        if ($this->aktion == 5 || $this->aktion == 10 || $this->getCruser()->isKunde() || !$rights['edit']) {
            //angelegt oder statuswechsel oder kundenkommentar
            return false;
        }
        //if($this->kundeninfoSichtbarkeit())
        //return false;
        return true;
    }

    public function sendMitarbeiterinfoMail()
    {
        //eigentlich nicht mehr genutzt
        //        $templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Templates/');
        //        $templateLayoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Layouts/');
        //        $templatePartialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Partials/');
        switch ($this->aktion) {
            case 10:    //$mailTemplate = 'MailStatus';
                //$mailBetreff = 'Statusänderung Auftrag';
                break;
            case 20:    //  $mailTemplate = 'MailKommentarMitarbeiter';
                //    $mailBetreff = 'Kommentar zu einem Auftrag';
                break;
        }
        if ($mailTemplate && $mailBetreff) {

        } else {
            die;
        }
    }

    public function sendAdminInfoMail()
    {
        //eigentlich nicht mehr genutzt
        //        $templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Templates/');
        //        $templateLayoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Layouts/');
        //        $templatePartialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dsl_intranet/Resources/Private/Partials/');
        switch ($this->aktion) {
            case 100:    $template = 'Mail/AdminStammdatenAenderung.html';
                break;
        }
        if ($template) {
            //echo "ja".$this->getCruser()->getUid();
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $kundenRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
            $kunde = $kundenRepository->findByUid($this->getCruser()->getUid());
            $attachments = array();
            $view = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView($template, 'DslIntranet');
            $view->assign('kundenname', $kunde->getName() . ' [' . $kunde->getNummer() . ']');
            $view->assign('layout', 'MailBetreff');
            $view->assign('protokolle', $this);
            $subject = $view->render();
            $view->assign('layout', 'MailHtml');
            $bodyHtml = $view->render();
            $view->assign('layout', 'MailText');
            $body = $view->render();
            if (\DslFactory\DslIntranet\Utility\MailUtility::init()->sendMail($subject, $body, 'info@dsl-factory.de', 'dsl factory', $bodyHtml, $attachments, $fromMail = false, $fromName = $kunde->getName(), $toMailCC = false, $toNameCC = false, $kunde->getName(), $kunde->getEmail(), 1, $archivMail = false, $archivName = false) == true) {
                $this->kundeninfoTime = new \DateTime();
                $this->kundeninfoMail = 'info@dsl-factory.de';
            }
        } else {
            die;
        }
    }

    public function getTemplateForMail()
    {
        switch ($this->aktion) {
            case 5:    //$mailTemplate = 'MailAuftragAngelegtKunde';
                return $template = 'Mail/KundenAuftraegeAngelegt.html';
                //MailAuftragAngelegtKunde.html
                // $mailBetreff = 'Neuer Auftrag';
                break;
            case 10:    return $template = 'Mail/KundenAuftraegeStatusAenderung.html';
                //MailStatusKunde.html
                // $mailBetreff = 'Statusänderung Auftrag';
                break;
            case 20:    return $template = 'Mail/KundenAuftraegeNeuerKommentar.html';
                //MailKommentarKunde
                // $mailBetreff = 'Kommentar zu Ihrem Auftrag';
                break;
            case 90:    if ($this->auftrag) {
                    if ($this->getDatei()) {
                        if ($this->getDatei()->getType() == 20) {
                            return 'Mail/KundenAuftraegeNeuesAngebot.html';
                        }
                        if ($this->getDatei()->getType() == 30) {
                            return 'Mail/KundenAuftraegeNeueRechnung.html';
                        }
                        return 'Mail/KundenAuftraegeNeueDatei.html';
                    }
                } else {
                    if ($this->getDatei()) {
                        if ($this->getDatei()->getType() == 20) {
                            return 'Mail/KundenNeuesAngebot.html';
                        }
                        if ($this->getDatei()->getType() == 30) {
                            return 'Mail/KundenNeueRechnung.html';
                        }
                        return 'Mail/KundenNeueDatei.html';
                    }
                }
                break;
        }
        return false;
    }

    /**
     * @param $forceMailSettings
     */
    public function setForceMailSettings($forceMailSettings)
    {
        $this->forceMailSettings = serialize($forceMailSettings);
    }

    public function isValidAuftrag()
    {
        //echo "function isValidAuftrag";
        if ($this->aktion == 10 || $this->aktion == 5) {
            if ($this->getAuftrag() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                $this->getAuftrag()->_loadRealInstance();
            }
            if (!$this->getAuftrag()) {
                return false;
            }
        }
        if ($this->aktion == 90) {
            // prüfung valide datei
            if ($this->getDatei() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                $this->getDatei()->_loadRealInstance();
            }
            if (!$this->getDatei()) {
                return false;
            } else {
                if ($this->getDatei()->getKunden() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                    $this->getDatei()->getKunden()->_loadRealInstance();
                }
                if (!$this->getDatei()->getKunden()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param $forceMailInfo
     */
    public function getMailSettings($forceMailInfo = false)
    {
        if ($this->forceMailSettings) {
            $forceMailSettings = unserialize($this->forceMailSettings);
        } else {
            $forceMailSettings = array();
        }
        //echo "<hr>".$forceMailSettings["subject"]."<hr>";
        $fromMail = false;
        $fromName = false;
        $checkWantMailFunc = false;
        switch ($this->aktion) {
            case 90:    //  $template = 'Mail/KundenAuftraegeNeueDatei.html';
                
                if ($this->auftrag) {
                    //$template = 'Mail/KundenAuftraegeNeueDatei.html';
                    if ($this->getDatei()) {
                        if ($this->getDatei()->getType() == 20) {
                            $checkWantMailFunc = 'wantMailForAngebote';
                        }
                        if ($this->getDatei()->getType() == 30) {
                            $checkWantMailFunc = 'wantMailForRechnungen';
                        }
                    }
                } else {
                    //$template = 'Mail/KundenNeueDatei.html';
                    if ($this->getDatei()) {
                        if ($this->getDatei()->getType() == 20) {
                            $checkWantMailFunc = 'wantMailForAngebote';
                        }
                        if ($this->getDatei()->getType() == 30 || $this->getDatei()->getType() == 35) {//Rechnung oder Agenturvertrags-Rechnung
                            $checkWantMailFunc = 'wantMailForRechnungen';
                        }
                    }
                }
                if ($checkWantMailFunc == 'wantMailForRechnungen') {
                    $configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
                    $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
                    $settings = $extbaseFrameworkConfiguration['plugin.']['tx_dslintranet.']['settings.'];
                    $fromMail = $settings['absenderBuchhaltungEmail'];
                    $fromName = $settings['absenderBuchhaltungName'];
                }
                //,$fromMail = false,$fromName = false
                //MailDateiKunde
                //  $mailBetreff = 'Datei zu Ihrem Auftrag';
                break;
        }
        if (!$fromMail) {
            $fromMail = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('absenderEmail');
        }
        if (!$fromName) {
            $fromName = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('absenderName');
        }
        $mailSettings = array(
            'fromMail' => $fromMail,
            'fromName' => $fromName,
            'checkWantMailFunc' => $checkWantMailFunc,
            'template' => $this->getTemplateForMail(),
            'attachments' => array(),
            'mailInfoDenied' => false,
            'kunde' => false,
            'kundeName' => false,
            'kundeNameCC' => false,
            'mailTo' => false,
            'mailToCC' => false,
            'subject' => '',//'test:'.$checkWantMailFunc,
            'kommentar' => $this->getNotiz(),
            'mitteilung' => '',
            'bodyHtml' => '',
            'body' => '',
            'mailReadyToSend' => false,
            'archivMail' => '',
            'archivName' => 'Archiv'
        );
        //kunde bestücken
        if ($mailSettings['template']) {
            if ($this->auftrag) {
                $mailSettings['kunde'] = $this->getAuftrag()->getKunde();
                $mailSettings['archivName'] .= ' - A' . $this->getAuftrag()->getUid();
            } elseif ($this->agenturvertrag) {
                $mailSettings['kunde'] = $this->getAgenturvertrag()->getKunde();
                $mailSettings['archivName'] .= ' - AV' . $this->getAgenturvertrag()->getUid();
            } else {
                if ($this->getDatei()) {
                    $mailSettings['kunde'] = $this->getDatei()->getKunden();
                }
            }
            if ($mailSettings['kunde']) {
                if ($mailSettings['kunde'] instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                    $mailSettings['kunde']->_loadRealInstance();
                }
            }
            //mailto abfragen
            if ($mailSettings['kunde']) {
                if ($mailSettings['kunde']->getEmail()) {
                    $mailSettings['mailTo'] = $mailSettings['kunde']->getEmail();
                } else {
                    if ($mailSettings['kunde']->getQbEmail()) {
                        $mailSettings['mailTo'] = $mailSettings['kunde']->getQbEmail();
                    }
                }
                $mailSettings['kundeName'] = $mailSettings['kunde']->getName();
                $mailSettings['archivName'] .= ' - K' . $mailSettings['kunde']->getNummer();
            }
            //	echo "6573";echo ":";die;echo $this->request->getArgument('uid');die;
            if ($this->getDatei()) {
                if ($this->getDatei()->getType() == 20 || $this->getDatei()->getType() == 30) {
                    // nur Angebote / Rechnungen
                    if ($this->getDatei()->getKundenVersandEmail()) {
                        $mailSettings['mailTo'] = $this->getDatei()->getKundenVersandEmail();
                    }
                    //$attachments = array("test.pdf"=>"test2test.pdf");
                    //echo $this->datei->getOriginalResource()->
                    if ($dateiOriginalResource = $this->getDatei()->getDatei()->getOriginalResource()) {
                        $storageCfg = $dateiOriginalResource->getOriginalFile()->getStorage()->getConfiguration();
                        $mailSettings['attachments'][rtrim($storageCfg['basePath'], '/') . $dateiOriginalResource->getOriginalFile()->getIdentifier()] = $dateiOriginalResource->getName();
                    }
                }
            }
        }
        if ($mailSettings['kunde']) {
            if (!$mailSettings['kunde']->getDisable()) {
                // && $mailSettings['mailTo']
                $mailSettings['mailInfoDenied'] = false;
                if (!$forceMailInfo) {
                    //prüfung noch sinnlos
                    //force bei versand durch admin über protokollecontroller aufruf
                    switch ($this->aktion) {
                        case 10:    //Statusänderung
                            if (!$mailSettings['kunde']->wantMailForStatuschange()) {
                                $mailSettings['mailInfoDenied'] = true;
                            }
                            break;
                        case 90:    //Rechnungen / Angebote
                            //if(!$kunde->{$checkWantMailFunc}()) $mailInfoDenied = true;
							if($mailSettings['checkWantMailFunc']){
								if (!call_user_func(array($mailSettings['kunde'], $mailSettings['checkWantMailFunc']))) {
									$mailSettings['mailInfoDenied'] = true;
								}
							}
							
                            //wantMailForRechnungen
                            break;
                        case 5:    
                        //Auftrag Angelegt
                        case 20:    //MailKommentarKunde
                            if (!$mailSettings['kunde']->wantMailGlobal()) {
                                $mailSettings['mailInfoDenied'] = true;
                            }
                            break;
                    }
                }
                foreach (['subject', 'mitteilung', 'mailTo', 'kundeName', 'mailToCC', 'kundeNameCC', 'fromName', 'fromMail'] as $key) {
                    if (isset($forceMailSettings[$key]) && $forceMailSettings[$key]) {
                        $mailSettings[$key] = $forceMailSettings[$key];
                    }
                }
                //if (!$mailSettings["mailInfoDenied"]) {
                $view = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView($mailSettings['template'], 'DslIntranet');
				
				
				if($this->auftrag){
					if($this->auftrag->getDatumproduktion()){
						$view->assign('auftragDatumproduktion', $this->auftrag->getDatumproduktion());
					}
					$view->assign('auftragLieferungAnKunde', $this->auftrag->getLieferungAnKunde());
				}
				
                $view->assign('protokolle', $this);
                $view->assign('kommentar', $mailSettings['kommentar']);
                $view->assign('mitteilung', $mailSettings['mitteilung']);
                if (!$mailSettings['subject']) {
                    $view->assign('layout', 'MailBetreff');
                    $mailSettings['subject'] = $view->render();
                }
                $view->assign('layout', 'MailHtml');
                $view->assign('subject', $mailSettings['subject']);
                $mailSettings['bodyHtml'] = $view->render();
                $view->assign('layout', 'MailText');
                $mailSettings['body'] = $view->render();
            }
        }
        if (!$mailSettings['mailInfoDenied'] && $mailSettings['body']) {
            $mailSettings['mailReadyToSend'] = true;
        }
        return $mailSettings;
    }

    /**
     * @param $forceMailInfo
     */
    public function sendKundeninfoMail($forceMailInfo = false)
    {
        //echo "a";
        $mailSettings = $this->getMailSettings($forceMailInfo);
        //echo "b";
        if ($mailSettings['mailReadyToSend']) {
            //echo "c";
            if (\DslFactory\DslIntranet\Utility\MailUtility::init()->sendMail($mailSettings['subject'], $mailSettings['body'], $mailSettings['mailTo'], $mailSettings['kundeName'], $mailSettings['bodyHtml'], $mailSettings['attachments'], $mailSettings['fromMail'], $mailSettings['fromName'], $mailSettings['mailToCC'], $mailSettings['kundeNameCC'], false, false, false, $mailSettings['archivMail'], $mailSettings['archivName']) == true) {
                //echo "d";
                $this->kundeninfoTime = new \DateTime();
                $this->kundeninfoMail = $mailSettings['mailTo'];
                $this->kundeninfoSichtbarkeit = 1;
                //echo "e";
                $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
                $protokolleRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');
                //echo "f-";
                $protokolleRepository->update($this);
            }
        }
    }
	
	/**
     * Returns the boolean state of aenderungStatus
     * 
     * @return bool
     */
    public function isAenderungStatus()
    {
        if ($this->aktion == 10) {
            return true;
        }
        return false;
    }

    /**
     * Returns the boolean state of kommentar
     * 
     * @return bool
     */
    public function isKommentar()
    {
        if ($this->aktion == 20) {
            return true;
        }
        return false;
    }

    /**
     * Returns the kundeninfoSichtbarkeit
     *
     * @return int
     */
    public function getKundeninfoSichtbarkeit()
    {
        return $this->kundeninfoSichtbarkeit;
    }

    /**
     * Sets the kundeninfoSichtbarkeit
     *
     * @param int $kundeninfoSichtbarkeit
     * @return void
     */
    public function setKundeninfoSichtbarkeit(int $kundeninfoSichtbarkeit)
    {
        $this->kundeninfoSichtbarkeit = $kundeninfoSichtbarkeit;
    }

    /**
     * Returns the auftragStatusAlt
     *
     * @return int
     */
    public function getAuftragStatusAlt()
    {
        return $this->auftragStatusAlt;
    }

    /**
     * Sets the auftragStatusAlt
     *
     * @param int $auftragStatusAlt
     * @return void
     */
    public function setAuftragStatusAlt(int $auftragStatusAlt)
    {
        $this->auftragStatusAlt = $auftragStatusAlt;
    }

    /**
     * Returns the auftragStatusNeu
     *
     * @return int
     */
    public function getAuftragStatusNeu()
    {
        return $this->auftragStatusNeu;
    }
	
	/**
     * Returns the auftragStatusAktuell
     * 
     * @return int $auftragStatusAktuell
     */
    public function getAuftragStatusAktuell()
    {
        if ($auftrag = $this->getAuftrag()) {
            return $this->getAuftrag()->getStatus();
        }
        return $this->auftragStatusNeu;
    }

    /**
     * Sets the auftragStatusNeu
     * 
     * @param int $auftragStatusNeu
     * @return void
     */
    public function setAuftragStatusNeu(int $auftragStatusNeu)
    {
        $this->auftragStatusNeu = $auftragStatusNeu;
    }

	
	/**
     * Returns the kunden versandEmail
     * 
     * @return string $email
     */
    public function getKundenVersandEmail()
    {
        if ($this->datei) {
            return $this->datei->getKundenVersandEmail();
        } else {
            return $this->getAuftrag()->getKunde()->getEmail();
        }
    }


    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->pending = $this->pending ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the auftrag
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Auftraege
     */
    public function getAuftrag()
    {
        return $this->auftrag;
    }

    /**
     * Sets the auftrag
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftrag
     * @return void
     */
    public function setAuftrag(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftrag)
    {
        $this->auftrag = $auftrag;
		$this->auftragStatusNeu = $auftrag->getStatus();

    }

    /**
     * Returns the datei
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Dateien
     */
    public function getDatei()
    {
        return $this->datei;
    }

    /**
     * Sets the datei
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $datei
     * @return void
     */
    public function setDatei(\DslFactory\DslIntranet\Domain\Model\Dateien $datei)
    {
        $this->datei = $datei;
    }

    /**
     * Adds a ProtokollePending
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ProtokollePending $pending
     * @return void
     */
    public function addPending(\DslFactory\DslIntranet\Domain\Model\ProtokollePending $pending)
    {
        $this->pending->attach($pending);
    }

    /**
     * Removes a ProtokollePending
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ProtokollePending $pendingToRemove The ProtokollePending to be removed
     * @return void
     */
    public function removePending(\DslFactory\DslIntranet\Domain\Model\ProtokollePending $pendingToRemove)
    {
        $this->pending->detach($pendingToRemove);
    }

    /**
     * Returns the pending
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\ProtokollePending>
     */
    public function getPending()
    {
        return $this->pending;
    }

    /**
     * Sets the pending
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\ProtokollePending> $pending
     * @return void
     */
    public function setPending(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $pending)
    {
        $this->pending = $pending;
    }

    /**
     * Returns the agenturvertrag
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Agenturvertraege
     */
    public function getAgenturvertrag()
    {
        return $this->agenturvertrag;
    }

    /**
     * Sets the agenturvertrag
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Agenturvertraege $agenturvertrag
     * @return void
     */
    public function setAgenturvertrag(\DslFactory\DslIntranet\Domain\Model\Agenturvertraege $agenturvertrag)
    {
        $this->agenturvertrag = $agenturvertrag;
    }

    /**
     * Returns the cruser
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $cruser
     */
    public function getCruser()
    {
        return $this->cruser;
    }

    /**
     * Sets the cruser
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $cruser
     * @return void
     */
    public function setCruser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $cruser)
    {
        $this->cruser = $cruser;
    }
}
