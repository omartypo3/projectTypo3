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
 * Zeiteintraege
 */
class Zeiteintraege extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
     * auftraege
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Auftraege
     */
    protected $auftraege;

    /**
     * wartungsvertraegeZeitraeume
     *
     * @var \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume
     */
    protected $wartungsvertraegeZeitraeume;

    /**
     * text
     *
     * @var string
     */
    protected $text;

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
     * kontingent
     *
     * @var int
     */
    protected $kontingent;

    /**
     * zeitnahme
     *
     * @var int
     */
    protected $zeitnahme;

    /**
     * oldid
     *
     * @var int
     */
    protected $oldid;

    /**
     * sichtbarkeit
     *
     * @var bool
     */
    protected $sichtbarkeit;

    /**
     * zeitnahmeAutoStopped
     *
     * @var bool
     */
    protected $zeitnahmeAutoStopped;

    /**
     * phase
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Phasen
     */
    protected $phase;

    /**
     * tracker
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\TrackerSegmente>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $tracker;

    /**
     * segmente
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $segmente;
	
	/**
     * kontingentMehraufwand
     *
     * @var int
     */
    protected $kontingentMehraufwand;
	
	/**
     * cruser
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $cruser;

    /**
     * Returns the text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Sets the text
     *
     * @param string $text
     * @return void
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }
	
	 /**
     * Returns the cruser
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser cruser
     */
    public function getCruser()
    {
        //echo (int)$this->cruser;
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

    /**
     * Returns the begin
     *
     * @return \DateTime
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
     * @return \DateTime
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
     * Returns the kontingent
     *
     * @return int
     */
    public function getKontingent()
    {
        return $this->kontingent;
    }
	
	/**
     * Returns the minutes
     *
     * @return integer $minutes
     */
    public function getMinutes()
    {
        if ($this->kontingent) {
            return $this->kontingent;
        } else {
            return $this->getTrackerMinutes();
        }
    }
	
	 /**
     * Returns the time in seconds
     *
     * @return integer $seconds
     */
    public function getTrackerMinutes()
    {
        return ceil($this->getTrackerSeconds() / 60);
    }
	
	/**
     * Returns the kontingent
     *
     * @return array $kontingentSet
     */
    public function getKontingentSet()
    {
        $stunden = floor($this->kontingent / 60);
        $minuten = $this->kontingent - $stunden * 60;
        return array('stunden' => $stunden, 'minuten' => $minuten);
    }

    /**
     * Sets the kontingent
     *
     * @param int $kontingent
     * @return void
     */
    public function setKontingent(int $kontingent)
    {
        $this->kontingent = $kontingent;
    }

    /**
     * Returns the zeitnahme
     *
     * @return int
     */
    public function getZeitnahme()
    {
        return $this->zeitnahme;
    }

    /**
     * Sets the zeitnahme
     *
     * @param int $zeitnahme
     * @return void
     */
    public function setZeitnahme(int $zeitnahme)
    {
        $this->zeitnahme = $zeitnahme;
    }

    /**
     * Returns the oldid
     *
     * @return int
     */
    public function getOldid()
    {
        return $this->oldid;
    }

    /**
     * Sets the oldid
     *
     * @param int $oldid
     * @return void
     */
    public function setOldid(int $oldid)
    {
        $this->oldid = $oldid;
    }

    /**
     * Returns the sichtbarkeit
     *
     * @return bool
     */
    public function getSichtbarkeit()
    {
        return $this->sichtbarkeit;
    }

    /**
     * Sets the sichtbarkeit
     *
     * @param bool $sichtbarkeit
     * @return void
     */
    public function setSichtbarkeit(bool $sichtbarkeit)
    {
        $this->sichtbarkeit = $sichtbarkeit;
    }

    /**
     * Returns the boolean state of sichtbarkeit
     *
     * @return bool
     */
    public function isSichtbarkeit()
    {
        return $this->sichtbarkeit;
    }

    /**
     * Returns the zeitnahmeAutoStopped
     *
     * @return bool
     */
    public function getZeitnahmeAutoStopped()
    {
        return $this->zeitnahmeAutoStopped;
    }

    /**
     * Sets the zeitnahmeAutoStopped
     *
     * @param bool $zeitnahmeAutoStopped
     * @return void
     */
    public function setZeitnahmeAutoStopped(bool $zeitnahmeAutoStopped)
    {
        $this->zeitnahmeAutoStopped = $zeitnahmeAutoStopped;
    }

    /**
     * Returns the boolean state of zeitnahmeAutoStopped
     *
     * @return bool
     */
    public function isZeitnahmeAutoStopped()
    {
        return $this->zeitnahmeAutoStopped;
    }

    /**
     * @return false|mixed|null
     */
    public function getLastTrackerSegmente()
    {
        // Check if the segmente collection is initialized and not empty
        
        $tmpArr = array();
        foreach ($this->tracker as $item) {
            $tmpArr[$item->getBegin()->getTimestamp()] = $item;
        }
        krsort($tmpArr);
        foreach ($tmpArr as $item) {
            return $item;
        }
        /*$tmpArr = $this->tracker;
          $tracker = $this->tracker->toArray();
          if (count($tracker)) {
          return end($tracker);
          }*/

        /*return $this->getTracker()->last(); 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        		if(count($this->tracker)){
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        			$tracker = (array)$this->tracker;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        			return end($tracker); 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        		}*/

        //foreach($this->tracker as $tracker) return $tracker;
        /*foreach ($this->tracker as $tracker) {
          if ($tracker->isOpened()) {
          return $tracker;
          }
          }*/

        return false;

        // Return null if no segments exist
        return null;
    }
    public function isValidToTrack()
    {
        if (!$this->getLastTrackerSegmente()) {
            return true;
        }
        if ($this->getLastTrackerSegmente()->getEnd()) {
            if ($this->getLastTrackerSegmente()->getEnd()->format('Ymd') < date('Ymd')) {
                return false;
            }
        }
        if ($this->getLastTrackerSegmente()->getBegin()) {
            if ($this->getLastTrackerSegmente()->getBegin()->format('Ymd') < date('Ymd')) {
                return false;
            }
        }
        //if($this->zeitnahmeAutoStopped) return false;
        return true;
    }

    public function toggleSichtbarkeit()
    {
        if ($this->sichtbarkeit) {
            $this->sichtbarkeit = 0;
        } else {
            $this->sichtbarkeit = 1;
        }
    }
	
	 /**
     * Returns the kontingentMehraufwand
     *
     * @return int $kontingentMehraufwand
     */
    public function getKontingentMehraufwand()
    {
        return $this->kontingentMehraufwand;
    }

    /**
     * Sets the kontingentMehraufwand
     *
     * @param int $kontingentMehraufwand
     * @return void
     */
    public function setKontingentMehraufwand($kontingentMehraufwand)
    {
        $this->kontingentMehraufwand = $kontingentMehraufwand;
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
        $this->tracker = $this->tracker ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->segmente = $this->segmente ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
	
	public function clearPhase()
    {
        //$this->phase = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        //unset($this->phase);
        $this->phase = 0;
    }

    /**
     * Returns the phase
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Phasen
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * Sets the phase
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Phasen $phase
     * @return void
     */
    public function setPhase(\DslFactory\DslIntranet\Domain\Model\Phasen $phase)
    {
        $this->phase = $phase;
    }

    /**
     * Adds a TrackerSegmente
     *
     * @param \DslFactory\DslIntranet\Domain\Model\TrackerSegmente $tracker
     * @return void
     */
    public function addTracker(\DslFactory\DslIntranet\Domain\Model\TrackerSegmente $tracker)
    {
        $this->tracker->attach($tracker);
    }

    /**
     * Removes a TrackerSegmente
     *
     * @param \DslFactory\DslIntranet\Domain\Model\TrackerSegmente $trackerToRemove The TrackerSegmente to be removed
     * @return void
     */
    public function removeTracker(\DslFactory\DslIntranet\Domain\Model\TrackerSegmente $trackerToRemove)
    {
        $this->tracker->detach($trackerToRemove);
    }

    /**
     * Returns the tracker
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\TrackerSegmente>
     */
    public function getTracker()
    {
        return $this->tracker;
    }

    /**
     * Sets the tracker
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\TrackerSegmente> $tracker
     * @return void
     */
    public function setTracker(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tracker)
    {
        $this->tracker = $tracker;
    }

    /**
     * Adds a ZeiteintraegeSegmente
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $segmente
     * @return void
     */
    public function addSegmente(\DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $segmente)
    {
        $this->segmente->attach($segmente);
    }

    /**
     * Removes a ZeiteintraegeSegmente
     *
     * @param \DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $segmenteToRemove The ZeiteintraegeSegmente to be removed
     * @return void
     */
    public function removeSegmente(\DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente $segmenteToRemove)
    {
        $this->segmente->detach($segmenteToRemove);
    }

    /**
     * Returns the segmente
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente>
     */
    public function getSegmente()
    {
        return $this->segmente;
    }

    /**
     * Sets the segmente
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\ZeiteintraegeSegmente> $segmente
     * @return void
     */
    public function setSegmente(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $segmente)
    {
        $this->segmente = $segmente;
    }
	
	/**
     * Returns the auftraege
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function getAuftraege()
    {
        return $this->auftraege;
    }
	
	  /**
     * Returns the wartungsvertraegeZeitraeume
     *
     * @return \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $wartungsvertraegeZeitraeume
     */
    public function getWartungsvertraegeZeitraeume()
    {
        //return 999;
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $wartungsvertraegeZeitraeumeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeZeitraeumeRepository');
        //if ($this->wartungsvertrag === NULL) {
	
        return $wartungsvertraegeZeitraeumeRepository->findByZeiteintraege($this);
       //}
        return $this->getUid();
        return $this->wartungsvertraegeZeitraeume;
    }
	
	/**
     * Returns the time in seconds
     *
     * @return integer $seconds
     */
    public function getTrackerSeconds()
    {
        //echo "\n<hr>!!!!!!zuid:".$this->getUid();
        $seconds = 0;
        $trackers = $this->getTracker();
        foreach ($trackers as $tracker) {
            //	echo "\n<br>".$tracker->getUid().': '.$tracker->getSeconds();
            $seconds += $tracker->getSeconds();
        }
        //echo "\n<br>gesamt:".$seconds;
        return $seconds;
    }
	
	/*dsl userrights*/
    public function getRights()
    {
        $rights = array(
            'edit' => false,
            'delete' => false
        );
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        /*	if($this->getCruser()==$mitarbeiter) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        			$rights['delete'] = true;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        			$rights['edit'] = true;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        		}*/

        if ($this->getAuftraege()) {
            foreach ($this->getAuftraege()->getMitarbeiter() as $ma) {
                if ($ma == $mitarbeiter) {
                    if ($this->getCruser() == $mitarbeiter) {
                        $rights['delete'] = true;
                        $rights['edit'] = true;
                    }
                }
            }
        } else {
            //wartungsvertraege
            if ($this->getCruser() == $mitarbeiter) {
                $rights['delete'] = true;
                $rights['edit'] = true;
            }
        }
        if ($mitarbeiter->getRechteAdminAuftraege()) {
            $rights['edit'] = true;
            $rights['delete'] = true;
        }
        /*
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $userLoggedIn = $GLOBALS['TSFE']->fe_user->user;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $userCreater = $this->getCruser();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                if ($userLoggedIn['uid'] == $userCreater->getUid()) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $rights['edit'] = true;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                }*/

        return $rights;
    }

}
