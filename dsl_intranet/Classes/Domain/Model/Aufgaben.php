<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Domain\Model;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 
 */

/**
 * Aufgaben
 */
class Aufgaben extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
     * @var int
     */
    protected $crdate;

    /**
     * @var int
     */
    protected $tstamp;

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz;

    /**
     * begin
     *
     * @var \DateTime
     */
    protected $begin;

    /**
     * end
     *
     * @var \DateTime
     */
    protected $end;

    /**
     * erledigt
     *
     * @var bool
     */
    protected $erledigt;

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
     * cruser
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $cruser;

    /**
     * Returns the notizGenerated
     * 
     * @return string $notizFromAuftrag
     */
    public function getNotizVonAuftrag()
    {
        if ($this->getAuftrag()) {
			if($this->getAuftrag()->getUid()){
				if ($this->getAuftrag()->getKunde()) {
					return $this->getAuftrag()->getUid() . ': ' . $this->getAuftrag()->getKunde()->getName() . ': ' . $this->getAuftrag()->getTitel();
				} else {
					return $this->getAuftrag()->getUid() . ': ' . $this->getAuftrag()->getTitel();
					//return '';
				}
			}
        }
		return $this->getNotiz();
    }

    /**
     * Returns the notizFuerKalender
     * 
     * @return string $notizFuerKalender
     */
    public function getNotizFuerKalender()
    {
		$auftragUid = '';
        if ($this->getAuftrag()) if($this->getAuftrag()->getUid()) $auftragUid = $this->getAuftrag()->getUid() . ': ';
       
        if ($this->notiz) {
            return $auftragUid . $this->notiz;
        } else {
            //return 'gla';
            //return 'gla';
            return $this->getNotizVonAuftrag();
        }
    }

    /**
     * Returns the notiz
     * 
     * @return string $notiz
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
    public function setNotiz($notiz)
    {
        $this->notiz = $notiz;
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
     * Returns the auftrag
     * 
     * @return \DslFactory\DslIntranet\Domain\Model\Auftraege $auftrag
     */
    public function getAuftrag()
    {
        /*if($this->auftrag){
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                			$rights = $this->auftrag->getRights();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                			if($rights["edit"])
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                		}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                		if()auftraege.rights*/

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
    }

    /**
     * Returns the begin
     * 
     * @return \DateTime $begin
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Sets the begin
     * 
     * @param \DateTime $begin
     * @return void
     */
    public function setBegin(\DateTime $begin)
    {
        $this->begin = $begin;
    }

    /**
     * Returns the end
     * 
     * @return \DateTime $end
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Sets the end
     * 
     * @param \DateTime $end
     * @return void
     */
    public function setEnd(\DateTime $end)
    {
        $this->end = $end;
    }

    /**
     * Returns the duration
     * 
     * @return integer $duration
     */
    public function getDuration()
    {
        return $this->getEnd()->getTimestamp() - $this->getBegin()->getTimestamp();
    }

    /**
     * Returns the erledigt
     * 
     * @return bool $erledigt
     */
    public function getErledigt()
    {
        return $this->erledigt;
    }

    /**
     * Sets the erledigt
     * 
     * @param bool $erledigt
     * @return void
     */
    public function setErledigt($erledigt)
    {
        $this->erledigt = $erledigt;
    }

    /**
     * Returns the boolean state of erledigt
     * 
     * @return bool
     */
    public function isErledigt()
    {
        return $this->erledigt;
    }

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
     * Returns the tstamp
     * 
     * @return int
     */
    public function getTstamp()
    {
        return $this->tstamp;
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
}
