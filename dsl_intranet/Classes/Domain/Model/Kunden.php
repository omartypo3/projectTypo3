<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Domain\Model;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
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
 * Kunden
 */
class Kunden extends \DslFactory\DslIntranet\Domain\Model\Benutzer
{
	/**
     * settingsKunde
     * 
     * @var string
     */
    protected $settingsKunde;

    /**
     * nummer
     *
     * @var string
     */
    protected $nummer;

    /**
     * qbrefnum
     *
     * @var string
     */
    protected $qbrefnum;

    /**
     * qbbaddr
     *
     * @var string
     */
    protected $qbbaddr;
	
	/**
     * notizen
     * 
     * @var string
     */
    protected $notizen;

    /**
     * spitzname
     *
     * @var string
     */
    protected $spitzname;

    /**
     * initialien
     *
     * @var string
     */
    protected $initialien;

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz;

    /**
     * freigaben
     *
     * @var string
     */
    protected $freigaben;

    /**
     * history
     *
     * @var string
     */
    protected $history;

    /**
     * qbEmail
     *
     * @var string
     */
    protected $qbEmail;

    /**
     * qbEinvEmail
     *
     * @var string
     */
    protected $qbEinvEmail;

    /**
     * qbCont
     *
     * @var string
     */
    protected $qbCont;

    /**
     * qbAnrede
     *
     * @var string
     */
    protected $qbAnrede;

    /**
     * qbFirstname
     *
     * @var string
     */
    protected $qbFirstname;

    /**
     * qbLastname
     *
     * @var string
     */
    protected $qbLastname;

    /**
     * qbStreet
     *
     * @var string
     */
    protected $qbStreet;

    /**
     * qbPostal
     *
     * @var string
     */
    protected $qbPostal;

    /**
     * qbCity
     *
     * @var string
     */
    protected $qbCity;

    /**
     * qbPhone
     *
     * @var string
     */
    protected $qbPhone;

    /**
     * qbFax
     *
     * @var string
     */
    protected $qbFax;

    /**
     * qbCont2
     *
     * @var string
     */
    protected $qbCont2;

    /**
     * qbPhone2
     *
     * @var string
     */
    protected $qbPhone2;

    /**
     * autologin
     *
     * @var string
     */
    protected $autologin;

    /**
     * emailRechnungen
     *
     * @var string
     */
    protected $emailRechnungen;

    /**
     * emailAngebote
     *
     * @var string
     */
    protected $emailAngebote;

    /**
     * newsletter
     *
     * @var bool
     */
    protected $newsletter;

    /**
     * emailNewsletter
     *
     * @var string
     */
    protected $emailNewsletter;

    /**
     * qbKtoInh
     *
     * @var string
     */
    protected $qbKtoInh;

    /**
     * qbBic
     *
     * @var string
     */
    protected $qbBic;

    /**
     * qbIban
     *
     * @var string
     */
    protected $qbIban;

    /**
     * qbBank
     *
     * @var string
     */
    protected $qbBank;

    /**
     * picDropZugangscode
     *
     * @var string
     */
    protected $picDropZugangscode;

    /**
     * passwortKopie
     *
     * @var string
     */
    protected $passwortKopie;

    /**
     * qbCompany
     *
     * @var string
     */
    protected $qbCompany;

    /**
     * dateien
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Dateien>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $dateien;
	
	/**
     * disable
     * 
     * @var boolean
     */
    protected $disable;
	
	/**
     * Returns true if is kunde
     * 
     * @return boolean
     */
    public function isKunde()
    {
        return true;
    }

    /**
     * Returns true if is mitarbeiter
     * 
     * @return boolean
     */
    public function isMitarbeiter()
    {
        return false;
    }

    /**
     * Returns true if is mitarbeiter
     * 
     * @return boolean
     */
    public function getMitarbeiter()
    {
        return false;
    }

    /**
     * Returns the Kundenname
     * 
     * @return string
     */
    public function getKundenNameForFilter()
    {
        if ($this->nummer) {
            return $this->getName() . ', ' . $this->nummer;
        }
        return $this->getName();
    }

    /**
     * Returns the nummer
     *
     * @return string
     */
    public function getNummer()
    {
        return $this->nummer;
    }

    /**
     * Sets the nummer
     *
     * @param string $nummer
     * @return void
     */
    public function setNummer(string $nummer)
    {
        $this->nummer = $nummer;
    }

    /**
     * Returns the qbrefnum
     *
     * @return string
     */
    public function getQbrefnum()
    {
        return $this->qbrefnum;
    }

    /**
     * Sets the qbrefnum
     *
     * @param string $qbrefnum
     * @return void
     */
    public function setQbrefnum(string $qbrefnum)
    {
        $this->qbrefnum = $qbrefnum;
    }

    /**
     * Returns the qbbaddr
     *
     * @return string
     */
    public function getQbbaddr()
    {
        return $this->qbbaddr;
    }

    /**
     * Sets the qbbaddr
     *
     * @param string $qbbaddr
     * @return void
     */
    public function setQbbaddr(string $qbbaddr)
    {
        $this->qbbaddr = $qbbaddr;
    }
	
	 /**
     * Returns the notizen
     * 
     * @return string $notizen
     */
    public function getNotizen()
    {
        return $this->notizen;
    }

    /**
     * Sets the notizen
     * 
     * @param string $notizen
     * @return void
     */
    public function setNotizen(string $notizen)
    {
        $this->notizen = $notizen;
    }
	
	/**
     * Returns the boolean state of qbhidden
     * 
     * @return boolean
     */
    public function isQbhidden()
    {
        return $this->qbhidden;
    }

    /**
     * Returns the spitzname
     *
     * @return string
     */
    public function getSpitzname()
    {
        return $this->spitzname;
    }

    /**
     * Sets the spitzname
     *
     * @param string $spitzname
     * @return void
     */
    public function setSpitzname(string $spitzname)
    {
        $this->spitzname = $spitzname;
    }

    /**
     * Returns the initialien
     *
     * @return string
     */
    public function getInitialien()
    {
        return $this->initialien;
    }

    /**
     * Sets the initialien
     *
     * @param string $initialien
     * @return void
     */
    public function setInitialien(string $initialien)
    {
        $this->initialien = $initialien;
    }

    /**
     * Returns the notiz
     *
     * @return string
     */
    public function getNotiz()
    {
        return $this->notiz;
    }

    /**
     * Sets the notiz
     *
     * @param string $notiz
     * @return void
     */
    public function setNotiz(string $notiz)
    {
        $this->notiz = $notiz;
    }

    /**
     * Returns the freigaben
     *
     * @return string
     */
    public function getFreigaben()
    {
        return $this->freigaben;
    }

    /**
     * Sets the freigaben
     *
     * @param string $freigaben
     * @return void
     */
    public function setFreigaben(string $freigaben)
    {
        $this->freigaben = $freigaben;
    }
	
	/**
     * Returns the boolean Loginstate
     * 
     * @return bool
     */
    public function isLogin()
    {
        $groupUidForKundenLogin = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('groupUidForKundenLogin');
        //Configuration Laden für Gruppenprüfung
        /*  $configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
            $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
            $settings = $extbaseFrameworkConfiguration['plugin.']['tx_dslintranet.']['settings.'];*/

        //return print_r($settings,1);groupUidForKundenLogin
        // return $settings['groupUidForKundenLogin'];
        //prüfen ob die Gruppe für den Kundenlogin stimmt
        $kundenLoginGruppe = false;
        if (is_object($this->usergroup)) {
            foreach ($this->usergroup as $group) {
                if ($group->getUid() == $groupUidForKundenLogin) {
                    $kundenLoginGruppe = true;
                }
            }
        }
        if (!$kundenLoginGruppe) {
            return false;
        }
        //return print_r((array)$this->usergroup,1);
        if ($this->username) {
            // && $this->password
            return true;
        }
        return false;
    }
	
	/**
     * Sets the Login Kunden Group
     * 
     * @param bool $login
     * @return void
     */
    public function setLogin($login)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        //$groupRepository = $objectManager->get('TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserGroupRepository');
        $groupRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenFegroupsRepository');
        $groupUidForKundenLogin = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('groupUidForKundenLogin');
        $group = $groupRepository->findByUid($groupUidForKundenLogin);
        if (!$this->getUsergroup()) {
            $this->setUsergroup(new \TYPO3\CMS\Extbase\Persistence\ObjectStorage());
        }
        if ($login) {
            $this->addUsergroup($group);
        } else {
            $this->removeUsergroup($group);
        }
        $this->username = $this->nummer;
    }
	
	/**
     * Returns the Ansprechpartner
     * 
     * @return string
     */
    public function getAnsprechpartner()
    {
        $ansprechpartner = array();
        if ($this->firstName) {
            $ansprechpartner[] = $this->firstName;
        }
        if ($this->lastName) {
            $ansprechpartner[] = $this->lastName;
        }
        if (!count($ansprechpartner)) {
            return false;
        }
        return implode(' ', $ansprechpartner);
    }

    /**
     * Returns the history
     *
     * @return string
     */
    public function getHistory()
    {
        //return $this->history;
        if ($this->history) {
            //accessMail
            $arr = (array) json_decode($this->history);
            $arr['accessMail'][0]->content = str_replace('<br />', '', $arr['accessMail'][0]->content);
            //$arr["accessMail"][0]->content = 'asd';
            //print_r($arr["accessMail"][0]->content);
            //die;
            //history.accessMail.0.content
            return $arr;
        } else {
            return array();
        }
    }

    /**
     * Sets the history
     *
     * @param string $history
     * @return void
     */
    public function setHistory(string $history)
    {
        $this->history = $history;
    }
	
	/**
     * Sets the history
     * 
     * @param string $type
     * @param array $history
     * @return void
     */
    public function addHistory($type, $history)
    {
        //print_r($history);
        $time = new \DateTime();
        $history['_timestamp'] = $time->getTimestamp();
        //print_r($history);
        if ($this->history) {
            //		echo "if!!";
            $json = (array) json_decode($this->history);
        } else {
            //		echo "else!!";
            $json = array();
        }
        if (!is_array($json[$type])) {
            //		echo "!isarray";
            $json[$type] = array();
        }
        $json[$type] = array_merge(array($history), $json[$type]);
        /*echo "--";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        	 print_r($json);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        	 echo "--";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        	 echo json_encode($json);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        	 echo "--";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        	 //$json[$type][0]["content"] = utf8_encode($json[$type][0]["content"]);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        	 //unset($json[$type][0]["content"]);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        	 echo json_encode($json);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        	 echo "--";*/

        //		$json[$type][] = $history;
        $this->history = json_encode($json);
    }
	
	 /**
     * Returns the auftraege
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege> auftraege
     */
    public function getAuftraege()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $auftraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        $auftraege = $auftraegeRepository->findByFilter(array('kundens' => array($this)));
        return $auftraege;
    }

    /**
     * Returns the auftraege
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege> auftraege
     */
    public function getAgenturAuftraege()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $auftraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        $auftraege = $auftraegeRepository->findByFilter(array('kundens' => array($this), 'auftragsartens' => array(6)));
        return $auftraege;
    }

    /**
     * Returns the wartungsvertraege
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Wartungsvertraege> wartungsvertraege
     */
    public function getWartungsvertraege()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $wartungsvertraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRepository');
        $wartungsvertraege = $wartungsvertraegeRepository->findByFilter(array('kundens' => array($this)));
        return $wartungsvertraege;
    }

    /**
     * Returns the hosting
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Hosting> hosting
     */
    public function getHosting()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $hostingRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\HostingRepository');
        $hosting = $hostingRepository->findByFilter(array('kundens' => array($this)));
        return $hosting;
    }

    /**
     * Returns the hosting
     * 
     * @return integer related
     */
    public function getRelated()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $settings = array('kundens' => array($this));
        $auftraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        $wartungsvertraegeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRepository');
        $hostingRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\HostingRepository');
        return count($auftraegeRepository->findByFilter($settings)) + count($wartungsvertraegeRepository->findByFilter($settings)) + count($hostingRepository->findByFilter($settings));
    }

    /**
     * Returns the qbEmail
     *
     * @return string
     */
    public function getQbEmail()
    {
        return $this->qbEmail;
    }

    /**
     * Sets the qbEmail
     *
     * @param string $qbEmail
     * @return void
     */
    public function setQbEmail(string $qbEmail)
    {
        $this->qbEmail = $qbEmail;
    }

    /**
     * Returns the qbEinvEmail
     *
     * @return string
     */
    public function getQbEinvEmail()
    {
        return $this->qbEinvEmail;
    }

    /**
     * Sets the qbEinvEmail
     *
     * @param string $qbEinvEmail
     * @return void
     */
    public function setQbEinvEmail(string $qbEinvEmail)
    {
        $this->qbEinvEmail = $qbEinvEmail;
    }

    /**
     * Returns the qbCont
     *
     * @return string
     */
    public function getQbCont()
    {
        return $this->qbCont;
    }

    /**
     * Sets the qbCont
     *
     * @param string $qbCont
     * @return void
     */
    public function setQbCont(string $qbCont)
    {
        $this->qbCont = $qbCont;
    }

    /**
     * Returns the qbAnrede
     *
     * @return string
     */
    public function getQbAnrede()
    {
        return $this->qbAnrede;
    }

    /**
     * Sets the qbAnrede
     *
     * @param string $qbAnrede
     * @return void
     */
    public function setQbAnrede(string $qbAnrede)
    {
        $this->qbAnrede = $qbAnrede;
    }

    /**
     * Returns the qbFirstname
     *
     * @return string
     */
    public function getQbFirstname()
    {
        return $this->qbFirstname;
    }

    /**
     * Sets the qbFirstname
     *
     * @param string $qbFirstname
     * @return void
     */
    public function setQbFirstname(string $qbFirstname)
    {
        $this->qbFirstname = $qbFirstname;
    }

    /**
     * Returns the qbLastname
     *
     * @return string
     */
    public function getQbLastname()
    {
        return $this->qbLastname;
    }

    /**
     * Sets the qbLastname
     *
     * @param string $qbLastname
     * @return void
     */
    public function setQbLastname(string $qbLastname)
    {
        $this->qbLastname = $qbLastname;
    }

    /**
     * Returns the qbStreet
     *
     * @return string
     */
    public function getQbStreet()
    {
        return $this->qbStreet;
    }

    /**
     * Sets the qbStreet
     *
     * @param string $qbStreet
     * @return void
     */
    public function setQbStreet(string $qbStreet)
    {
        $this->qbStreet = $qbStreet;
    }

    /**
     * Returns the qbPostal
     *
     * @return string
     */
    public function getQbPostal()
    {
        return $this->qbPostal;
    }

    /**
     * Sets the qbPostal
     *
     * @param string $qbPostal
     * @return void
     */
    public function setQbPostal(string $qbPostal)
    {
        $this->qbPostal = $qbPostal;
    }

    /**
     * Returns the qbCity
     *
     * @return string
     */
    public function getQbCity()
    {
        return $this->qbCity;
    }

    /**
     * Sets the qbCity
     *
     * @param string $qbCity
     * @return void
     */
    public function setQbCity(string $qbCity)
    {
        $this->qbCity = $qbCity;
    }
	
	 /**
     * Returns the state vor zugangsdaten versand
     * 
     * @return boolean
     */
    public function getReadyForZugangsdatenMail()
    {
        if (!$this->disable && $this->isLogin() && $this->username) {
            return true;
        }
        return false;
    }

    /**
     * Returns the qbPhone
     *
     * @return string
     */
    public function getQbPhone()
    {
        return $this->qbPhone;
    }

    /**
     * Sets the qbPhone
     *
     * @param string $qbPhone
     * @return void
     */
    public function setQbPhone(string $qbPhone)
    {
        $this->qbPhone = $qbPhone;
    }

    /**
     * Returns the qbFax
     *
     * @return string
     */
    public function getQbFax()
    {
        return $this->qbFax;
    }

    /**
     * Sets the qbFax
     *
     * @param string $qbFax
     * @return void
     */
    public function setQbFax(string $qbFax)
    {
        $this->qbFax = $qbFax;
    }

    /**
     * Returns the qbCont2
     *
     * @return string
     */
    public function getQbCont2()
    {
        return $this->qbCont2;
    }

    /**
     * Sets the qbCont2
     *
     * @param string $qbCont2
     * @return void
     */
    public function setQbCont2(string $qbCont2)
    {
        $this->qbCont2 = $qbCont2;
    }

    /**
     * Returns the qbPhone2
     *
     * @return string
     */
    public function getQbPhone2()
    {
        return $this->qbPhone2;
    }

    /**
     * Sets the qbPhone2
     *
     * @param string $qbPhone2
     * @return void
     */
    public function setQbPhone2(string $qbPhone2)
    {
        $this->qbPhone2 = $qbPhone2;
    }

    /**
     * Returns the autologin
     *
     * @return string
     */
    public function getAutologin()
    {
        return $this->autologin;
    }

    /**
     * Sets the autologin
     *
     * @param string $autologin
     * @return void
     */
    public function setAutologin(string $autologin)
    {
        $this->autologin = $autologin;
    }

    /**
     * Returns the emailRechnungen
     *
     * @return string
     */
    public function getEmailRechnungen()
    {
        return $this->emailRechnungen;
    }

    /**
     * Sets the emailRechnungen
     *
     * @param string $emailRechnungen
     * @return void
     */
    public function setEmailRechnungen(string $emailRechnungen)
    {
        $this->emailRechnungen = $emailRechnungen;
    }

    /**
     * Returns the emailAngebote
     *
     * @return string
     */
    public function getEmailAngebote()
    {
        return $this->emailAngebote;
    }

    /**
     * Sets the emailAngebote
     *
     * @param string $emailAngebote
     * @return void
     */
    public function setEmailAngebote(string $emailAngebote)
    {
        $this->emailAngebote = $emailAngebote;
    }

    /**
     * Returns the newsletter
     *
     * @return bool
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Sets the newsletter
     *
     * @param bool $newsletter
     * @return void
     */
    public function setNewsletter(bool $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * Returns the boolean state of newsletter
     *
     * @return bool
     */
    public function isNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Returns the emailNewsletter
     *
     * @return string
     */
    public function getEmailNewsletter()
    {
        return $this->emailNewsletter;
    }

    /**
     * Sets the emailNewsletter
     *
     * @param string $emailNewsletter
     * @return void
     */
    public function setEmailNewsletter(string $emailNewsletter)
    {
        $this->emailNewsletter = $emailNewsletter;
    }

    /**
     * Returns the qbKtoInh
     *
     * @return string
     */
    public function getQbKtoInh()
    {
        return $this->qbKtoInh;
    }

    /**
     * Sets the qbKtoInh
     *
     * @param string $qbKtoInh
     * @return void
     */
    public function setQbKtoInh(string $qbKtoInh)
    {
        $this->qbKtoInh = $qbKtoInh;
    }

    /**
     * Returns the qbBic
     *
     * @return string
     */
    public function getQbBic()
    {
        return $this->qbBic;
    }

    /**
     * Sets the qbBic
     *
     * @param string $qbBic
     * @return void
     */
    public function setQbBic(string $qbBic)
    {
        $this->qbBic = $qbBic;
    }

    /**
     * Returns the qbIban
     *
     * @return string
     */
    public function getQbIban()
    {
        return $this->qbIban;
    }

    /**
     * Sets the qbIban
     *
     * @param string $qbIban
     * @return void
     */
    public function setQbIban(string $qbIban)
    {
        $this->qbIban = $qbIban;
    }

    /**
     * Returns the qbBank
     *
     * @return string
     */
    public function getQbBank()
    {
        return $this->qbBank;
    }

    /**
     * Sets the qbBank
     *
     * @param string $qbBank
     * @return void
     */
    public function setQbBank(string $qbBank)
    {
        $this->qbBank = $qbBank;
    }

    /**
     * Returns the picDropZugangscode
     *
     * @return string
     */
    public function getPicDropZugangscode()
    {
        return $this->picDropZugangscode;
    }

    /**
     * Sets the picDropZugangscode
     *
     * @param string $picDropZugangscode
     * @return void
     */
    public function setPicDropZugangscode(string $picDropZugangscode)
    {
        $this->picDropZugangscode = $picDropZugangscode;
    }

    /**
     * Returns the passwortKopie
     *
     * @return string
     */
    public function getPasswortKopie()
    {
       return base64_decode($this->passwortKopie);
    }
	
	/**
     * Returns the passwortKopieKlartext
     * 
     * @return mixed $passwortKopieKlartext
     */
    public function getPasswortKopieKlartext()
    {
        $passwordValid = FALSE;
		
		$passwordHashFactory = GeneralUtility::makeInstance(PasswordHashFactory::class);
		$passwordHashInstance = $passwordHashFactory->getDefaultHashInstance('FE');

        if ($passwordHashInstance) {
            
                $passwordValid = $passwordHashInstance->checkPassword($this->getPasswortKopie(), $this->getPassword());
            
        }
        if ($passwordValid) {
            return $this->getPasswortKopie();
        } else {
            //$this->setPasswortKopie("DURCHEMAILGEAENDERT");
            //$this->kundenRepository->update($kundeTmp);
            //$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            return '';
        }
    }

    /**
     * Sets the passwortKopie
     *
     * @param string $passwortKopie
     * @return void
     */
    public function setPasswortKopie(string $passwortKopie)
    {
		$this->passwortKopie = base64_encode($passwortKopie);
    }

    /**
     * Returns the qbCompany
     *
     * @return string
     */
    public function getQbCompany()
    {
        return $this->qbCompany;
    }

    /**
     * Sets the qbCompany
     *
     * @param string $qbCompany
     * @return void
     */
    public function setQbCompany(string $qbCompany)
    {
        $this->qbCompany = $qbCompany;
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
        $this->dateien = $this->dateien ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a Dateien
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $dateien
     * @return void
     */
    public function addDateien(\DslFactory\DslIntranet\Domain\Model\Dateien $dateien)
    {
        $this->dateien->attach($dateien);
    }

    /**
     * Removes a Dateien
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $dateienToRemove The Dateien to be removed
     * @return void
     */
    public function removeDateien(\DslFactory\DslIntranet\Domain\Model\Dateien $dateienToRemove)
    {
        $this->dateien->detach($dateienToRemove);
    }

    /**
     * Returns the dateien
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Dateien>
     */
    public function getDateien()
    {
        return $this->dateien;
    }

    /**
     * Sets the dateien
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Dateien> $dateien
     * @return void
     */
    public function setDateien(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $dateien)
    {
        $this->dateien = $dateien;
    }
	
	/*dsl userrights*/
    public function getRights()
    {
        $rights = array(
            'history' => false
        );
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($mitarbeiter->getRechteAdminAuftraege()) {
            $rights['history'] = true;
        }
        return $rights;
    }
	
	/**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        if ($this->company) {
            return $this->company;
        }
        if ($this->firstName || $this->lastName) {
            if ($this->title) {
                $arr[] = $this->title;
            }
            if ($this->firstName) {
                $arr[] = $this->firstName;
            }
            if ($this->lastName) {
                $arr[] = $this->lastName;
            }
            return implode(' ', $arr);
        }
        return $this->name;
    }
	
	/**
     * Returns the settingsKunde
     * 
     * @return string $settingsKunde
     */
    public function getSettingsKunde()
    {
        $filterArr = array();
        if ($this->settingsKunde) {
            $filterArr = unserialize($this->settingsKunde);
        }
        if (!isset($filterArr['becomeInfoGlobal'])) {
            $filterArr['becomeInfoGlobal'] = 1;
        }
        if (!isset($filterArr['becomeInfoStatuschange'])) {
            $filterArr['becomeInfoStatuschange'] = 1;
        }
        if (!isset($filterArr['becomeInfoDownloads'])) {
            $filterArr['becomeInfoDownloads'] = 1;
        }
        if (!isset($filterArr['becomeInfoAngebote'])) {
            $filterArr['becomeInfoAngebote'] = 1;
        }
        if (!isset($filterArr['becomeInfoRechnungen'])) {
            $filterArr['becomeInfoRechnungen'] = 1;
        }
        return $filterArr;
    }
	
	/**
     * Returns true if want
     * 
     * @return boolean
     */
    public function wantMailForStatuschange()
    {
        $settings = $this->getSettingsKunde();
        if ($settings['becomeInfoGlobal'] && $settings['becomeInfoStatuschange']) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if want
     * 
     * @return boolean
     */
    public function wantMailForAngebote()
    {
        $settings = $this->getSettingsKunde();
        if ($settings['becomeInfoGlobal'] && $settings['becomeInfoAngebote']) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if want
     * 
     * @return boolean
     */
    public function wantMailForRechnungen()
    {
        $settings = $this->getSettingsKunde();
        if ($settings['becomeInfoGlobal'] && $settings['becomeInfoRechnungen']) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if want
     * 
     * @return boolean
     */
    public function wantMailGlobal()
    {
        $settings = $this->getSettingsKunde();
        if ($settings['becomeInfoGlobal']) {
            return true;
        }
        return false;
    }
	
	 /**
     * Sets the disable status
     * 
     * @param bool $disable
     * @return void
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;
    }

    /**
     * Returns the disable
     * 
     * @return bool $disable
     */
    public function getDisable()
    {
        return $this->disable;
    }
}
