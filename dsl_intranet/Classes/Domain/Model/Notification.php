<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Domain\Model;


use DslFactory\DslIntranet\Utility\NewsletterUtility;
use TYPO3\CMS\Core\Utility\DebugUtility;

/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * Notification
 */
class Notification extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
     * @var int
     */
    protected $crdate;


    /**
     * art
     *
     * @var int
     */
    protected $art;

    /**
     * gelesen
     *
     * @var int
     */
    protected $gelesen;

    /**
     * wert1
     *
     * @var string
     */
    protected $wert1;

    /**
     * wert2
     *
     * @var string
     */
    protected $wert2;

    /**
     * wert3
     *
     * @var string
     */
    protected $wert3;

    /**
     * wert4
     *
     * @var string
     */
    protected $wert4;

    /**
     * kundeName
     *
     * @var string
     */
    protected $kundeName;

    /**
     * auftragTitel
     *
     * @var string
     */
    protected $auftragTitel;
	
	 /**
     * mitarbeiter
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Mitarbeiter
     */
    protected $mitarbeiter;

    /**
     * auftrag
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Auftraege
     */
    protected $auftrag;

    /**
     * Ausgelöst durch
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Benutzer
     */
    protected $cruser;

    /**
     * Ausgelöst durch
     * 
     * @var \DslFactory\DslIntranet\Domain\Model\Urlaub
     */
    protected $urlaub;
	
	/**
     * Returns the crdate
     * 
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
    }


    /**
     * Returns the art
     *
     * @return int
     */
    public function getArt()
    {
        return $this->art;
    }
	
	/**
     * Sets the art
     * 
     * @param int $art
     * @param string $wert1
     * @param string $wert2
     * @param string $wert3
     * @param string $wert4
     * @return void
     */
    public function setArt($art, $wert1 = '', $wert2 = '', $wert3 = '', $wert4 = '')
    {
        $this->wert1 = $wert1;
        $this->wert2 = $wert2;
        $this->wert3 = $wert3;
        $this->wert4 = $wert4;
        $this->art = $art;
        switch ($art) {
            case '10':    
            //ein mitarbeiter fügt nachträglich andere mitarbeiter hinzu
            case '20':    
            //statuswechsel auftrag
            case '30':    
            //auftrag angelegt
            case '40':    
            //auftrag geändert
            case '50':    
            //änderung des ansprechpartner im auftrag
            case '60':    
            //Auftrag gelöscht
            case '70':    
            //Kommentar zum Auftrag durch den Kunden
            case '80':    
            //Mitarbeiter lädt eine Datei zum Auftrag hoch
            case '90':    
            //Kunde lädt eine Datei zum Auftrag hoch
            case '100':    
            //Urlaub wird angelegt information an mitarbeiter dem der urlaub zugeordnet ist
            case '110':    //Urlaub wird geändert information an mitarbeiter dem der urlaub zugeordnet ist
                $this->cruser = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                break;
        }
    }
	
	/**
     * Returns the mitarbeiter
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     */
    public function getMitarbeiter()
    {
        return $this->mitarbeiter;
    }

    /**
     * Sets the mitarbeiter
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     * @return void
     */
    public function setMitarbeiter(\DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter)
    {
        $this->mitarbeiter = $mitarbeiter;
    }
	
	 /**
     * Returns the titel
     * 
     * @return string $titel
     */
    public function getTitel()
    {
        return $this->getAuftragTitel();
    }
	
	 /**
     * Returns the body
     * 
     * @return string $body
     */
    public function getBody()
    {
        //return "";
        switch ($this->art) {
            case '10':    //ein mitarbeiter fügt nachträglich andere mitarbeiter hinzu
                return 'hat Sie als Bearbeiter zum Auftrag hinzugefügt.';
                break;
            case '20':    //statusänderung eines auftrags
                return 'hat den Auftragsstatus auf ' . $this->wert2 . ' geändert.';
                break;
            case '30':    //auftrag angelegt
                return 'hat den Auftrag im Status ' . $this->wert1 . ' angelegt.';
                break;
            case '40':    //auftrag angelegt
                return 'hat den Auftrag mit dem Status ' . $this->wert1 . ' bearbeitet.';
                break;
            case '50':    //auftrag angelegt
                return 'hat Sie als Projektleiter im Auftrag mit dem Status ' . $this->wert1 . ' gesetzt.';
                break;
            case '60':    //auftrag gelöscht
                return 'hat den Auftrag mit dem Status ' . $this->wert1 . ' gelöscht.';
                break;
            case '70':    //kommentar durch kunde ergänzt
                return 'der Kunde  hat einen Kommentar dem Auftrag mit dem Status ' . $this->wert1 . ' hinzugefügt.';
                break;
            case '80':    //datei durch mitarbeiter ergänzt
                return 'hat dem Auftrag mit dem Status ' . $this->wert1 . ' eine Datei hinzugefügt.';
                break;
            case '90':    //datei durch kunde ergänzt
                return 'hat dem Auftrag mit dem Status ' . $this->wert1 . ' eine Datei hinzugefügt.';
                break;
            case '100':    //Urlaub wird angelegt information an mitarbeiter dem der urlaub zugeordnet ist
                return 'neuer Urlaub für den ' . $this->wert3 . ' angelegt.';
                break;
            case '110':    //Urlaub wird angelegt information an mitarbeiter dem der urlaub zugeordnet ist
                return 'Urlaub für den ' . $this->wert3 . ' geändert.';
                break;
        }
    }
	
	 /**
     * Returns the zusatz
     * 
     * @return string $zusatz
     */
    public function getZusatz()
    {
        return $this->getKundeName();
    }

    /**
     * Returns the CruserMitarbeiter
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     */
    public function getCruserMitarbeiter()
    {
        return $this->getCruserMitarbeiterHelper($this->cruser);
    }

    /**
     * Returns the CruserIsMitarbeiter
     * 
     * @return bool $cruserIsMitarbeiter
     */
    public function getCruserIsMitarbeiter()
    {
		if($this->cruser){
			if(get_class($this->cruser) == 'DslFactory\DslIntranet\Domain\Model\Mitarbeiter') return true; else return false;
		}else{
			return false;
		}
    }	

	    /**
     * Returns the CruserIsKunde
     * 
     * @return bool $cruserIsKunde
     */
    public function getCruserIsKunde()
    {
		if($this->cruser){
			if(get_class($this->cruser) == 'DslFactory\DslIntranet\Domain\Model\Kunden') return true; else return false;
		}else{
			return false;
		}
   }
	
    /**
     * Returns the CruserMitarbeiter
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     * @return \DslFactory\DslIntranet\Domain\Model\Mitarbeiter $mitarbeiter
     */
    public function getCruserMitarbeiterHelper($mitarbeiter)
    {
        return $mitarbeiter;
    }

    /**
     * Returns the CruserKunde
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Kunden $kunden
     */
    public function getCruserKunde()
    {
        return $this->getCruserKundeHelper($this->cruser);
    }

    /**
     * Returns the CruserMitarbeiter
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Kunde $kunde
     * @return \DslFactory\DslIntranet\Domain\Model\Kunde $kunde
     */
    public function getCruserKundeHelper($kunde)
    {
        return $kunde;
    }
	
	 /**
     * Returns the auftrag
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Auftraege $auftrag
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
        $this->auftragTitel = $auftrag->getTitel();
       if($auftrag->getKunde()!= NULL){
           $this->kundeName = $auftrag->getKunde()->getName();
       }

    }

    /**
     * Returns the cruser
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Benutzer cruser
     */
    public function getCruser()
    {
        return $this->cruser;
    }

    /**
     * Sets the cruser
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Benutzer $cruser
     * @return void
     */
    public function setCruser(\DslFactory\DslIntranet\Domain\Model\Benutzer $cruser)
    {
        $this->cruser = $cruser;
    }

    /**
     * Returns the gelesen
     *
     * @return int
     */
    public function getGelesen()
    {
        return $this->gelesen;
    }

    /**
     * Sets the gelesen
     *
     * @param int $gelesen
     * @return void
     */
    public function setGelesen(int $gelesen)
    {
        $this->gelesen = $gelesen;
    }

    /**
     * Returns the wert1
     *
     * @return string
     */
    public function getWert1()
    {
        return $this->wert1;
    }

    /**
     * Sets the wert1
     *
     * @param string $wert1
     * @return void
     */
    public function setWert1(string $wert1)
    {
        $this->wert1 = $wert1;
    }

    /**
     * Returns the wert2
     *
     * @return string
     */
    public function getWert2()
    {
        return $this->wert2;
    }

    /**
     * Sets the wert2
     *
     * @param string $wert2
     * @return void
     */
    public function setWert2(string $wert2)
    {
        $this->wert2 = $wert2;
    }

    /**
     * Returns the wert3
     *
     * @return string
     */
    public function getWert3()
    {
        return $this->wert3;
    }

    /**
     * Sets the wert3
     *
     * @param string $wert3
     * @return void
     */
    public function setWert3(string $wert3)
    {
        $this->wert3 = $wert3;
    }
	
	 public function resetUid()
    {
        $this->uid = NULL;
        $this->_setClone(FALSE);
    }

    /**
     * Returns if this Model is relevant to save
     * 
     * @return bool
     */
    public function forOtherUser()
    {
        //echo "cruser:".$this->cruser;
        //echo "mitarbeiter:".$this->mitarbeiter;
        if ($this->cruser != $this->mitarbeiter) {
            //Mailversand
            if ($this->mitarbeiter) {
                //muss noch besser gebaut werden
                //$subject = "Nachricht zu einem Auftrag";
                //$body = $this->getBody()."\n\nAuftrag: ".$this->auftragTitel."\nKunde: ".$this->kundeName;
                $replyName = false;
                $replyMail = false;
                $fromName = false;
                $fromMail = false;
                $template = false;
                $priority = false;
                $absenderMitarbeiter = false;
                switch ($this->art) {
                    case '10':    //ein mitarbeiter fügt nachträglich andere mitarbeiter hinzu
                        //return $this->getCruserMitarbeiter()->getFirstName() . ' hat Sie als Bearbeiter zum Auftrag hinzugefügt.';
                        $template = 'Mail/MitarbeiterAuftraegeMitarbeiterHinzugefuegt.html';
                        $absenderMitarbeiter = true;
                        break;
                    case '20':    //statusänderung eines auftrags
                        $template = 'Mail/MitarbeiterAuftraegeStatusAenderung.html';
                        $absenderMitarbeiter = true;
                        break;
                    case '30':    //auftrag angelegt
                        $template = 'Mail/MitarbeiterAuftraegeAngelegt.html';
                        $absenderMitarbeiter = true;
                        break;
                    case '40':    //auftrag bearbeitet
                        $template = 'Mail/MitarbeiterAuftraegeGeaendert.html';
                        $absenderMitarbeiter = true;
                        break;
                    case '50':    //auftrag als ansprechpartner
                        $template = 'Mail/MitarbeiterAuftraegeAnsprechpartnerGeaendert.html';
                        $absenderMitarbeiter = true;
                        //return $this->getCruserMitarbeiter()->getFirstName() . ' hat Sie als Ansprechpartner im Auftrag mit dem Status ' . $this->wert1 . ' gesetzt.';
                        break;
                    case '60':    //auftrag gelöscht
                        $template = 'Mail/MitarbeiterAuftraegeGeloescht.html';
                        $absenderMitarbeiter = true;
                        //return $this->getCruserMitarbeiter()->getFirstName() . ' hat den Auftrag mit dem Status ' . $this->wert1 . ' gelöscht.';
                        break;
                    case '70':    //auftrag kommentar durch den kunde
                        //return $this->getCruserKunde()->getFirstName() . ' hat einen Kommentar dem Auftrag mit dem Status ' . $this->wert1 . ' hinzugefügt.';
                        $template = 'Mail/MitarbeiterAuftraegeNeuerKommentar.html';
                        //$subject = "Kommentar zu einem Auftrag";
                        //$body.="\nKommentar: ".$this->getWert2();
                        $replyName = $this->getKundeName();
                        if ($this->getCruserKunde()->getEmail()) {
                            $replyMail = $this->getCruserKunde()->getEmail();
                        }
                        $priority = 1;
                        break;
                    case '80':    //auftrag neue datei durch mitarbeiter
                        $template = 'Mail/MitarbeiterAuftraegeNeueDatei.html';
                        $absenderMitarbeiter = true;
                        break;
                    case '90':    //auftrag neue datei durch  kunde
                        $template = 'Mail/MitarbeiterAuftraegeNeueDateiDurchKunde.html';
                        $replyName = $this->getKundeName();
                        if ($this->getCruserKunde()->getEmail()) {
                            $replyMail = $this->getCruserKunde()->getEmail();
                        }
                        $priority = 1;
                        break;
                    case '100':    //Urlaub wird angelegt information an mitarbeiter dem der urlaub zugeordnet ist
                        $template = 'Mail/MitarbeiterUrlaubAngelegt.html';
                        $absenderMitarbeiter = true;
                        break;
                    case '110':    //Urlaub wird geändert information an mitarbeiter dem der urlaub zugeordnet ist
                        $template = 'Mail/MitarbeiterUrlaubAenderung.html';
                        $absenderMitarbeiter = true;
                        break;
                    default:    $template = 'Mail/NotificationStandard.html';
                        break;
                }
                if ($absenderMitarbeiter) {
                    $fromName = $this->getCruserMitarbeiter()->getName() . ' - Kundencenter';
                    $fromMail = $this->getCruserMitarbeiter()->getEmail();
                }
                //$template;
                if ($replyName) {
                    $fromName = $replyName;
                }
                $view = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView($template, 'DslIntranet');
                $view->assign('layout', 'MailBetreff');
                $view->assign('notification', $this);
                $subject = $view->render();
                $view->assign('subject', $subject);
                $view->assign('layout', 'MailHtml');
                $bodyHtml = $view->render();
                $view->assign('layout', 'MailText');
                $body = $view->render();
                \DslFactory\DslIntranet\Utility\MailUtility::init()->sendMail($subject, $body, $this->mitarbeiter->getEmail(), $this->mitarbeiter->getName(), $bodyHtml, array(), $fromMail, $fromName, false, false, $replyName, $replyMail, $priority);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the wert4
     *
     * @return string
     */
    public function getWert4()
    {
        return $this->wert4;
    }

    /**
     * Sets the wert4
     *
     * @param string $wert4
     * @return void
     */
    public function setWert4(string $wert4)
    {
        $this->wert4 = $wert4;
    }

    /**
     * Returns the kundeName
     *
     * @return string
     */
    public function getKundeName()
    {
        return $this->kundeName;
    }

    /**
     * Sets the kundeName
     *
     * @param string $kundeName
     * @return void
     */
    public function setKundeName(string $kundeName)
    {
        $this->kundeName = $kundeName;
    }

    /**
     * Returns the auftragTitel
     *
     * @return string
     */
    public function getAuftragTitel()
    {
        if ($this->auftragTitel) {
            return $this->auftragTitel;
        } else {
            return $this->getUrlaubTitel();
        }
    }
	
	/**
     * Returns the urlaubTitel
     * 
     * @return string $urlaubTitel
     */
    public function getUrlaubTitel()
    {
        return $this->getWert1();
    }

    /**
     * Sets the auftragTitel
     *
     * @param string $auftragTitel
     * @return void
     */
    public function setAuftragTitel(string $auftragTitel)
    {
        $this->auftragTitel = $auftragTitel;
    }
	
	/**
     * Returns the urlaub
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub
     */
    public function getUrlaub()
    {
        return $this->urlaub;
    }

    /**
     * Sets the urlaub
     * 
     * @param \DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub
     * @return void
     */
    public function setUrlaub(\DslFactory\DslIntranet\Domain\Model\Urlaub $urlaub)
    {
        $this->urlaub = $urlaub;
    }
}
