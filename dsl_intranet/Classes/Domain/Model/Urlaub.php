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
 * Urlaub
 */
class Urlaub extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
     * @var int
     */
    protected $crdate;

    /**
     * arbeitstageFuerJahr
     * 
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $arbeitstageFuerJahr;

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
     * status
     *
     * @var int
     */
    protected $status;

    /**
     * titel
     *
     * @var string
     */
    protected $titel;

    /**
     * tage
     *
     * @var int
     */
    protected $tage;

    /**
     * tageResturlaub
     *
     * @var int
     */
    protected $tageResturlaub;

    /**
     * oldid
     *
     * @var int
     */
    protected $oldid;

    /**
     * sonstiges
     *
     * @var bool
     */
    protected $sonstiges;

    /**
     * mitarbeiter
     *
     * @var \DslFactory\DslIntranet\Domain\Model\Mitarbeiter
     */
    protected $mitarbeiter;
	
	/**
     * cruser
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $cruser;

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
     * Returns the crdate
     * 
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
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
         $begin->modify('+3 hours');
        //DateFix wenn in der datenbank also im TCA 'dbType' => 'date', genutzt wird in db also
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
        $end->modify('+3 hours');
        //DateFix wenn in der datenbank also im TCA 'dbType' => 'date', genutzt wird in db also
        $this->end = $end;
    }

    /**
     * Returns the status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     *
     * @param int $status
     * @return void
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Returns the titel
     *
     * @return string
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * Sets the titel
     *
     * @param string $titel
     * @return void
     */
    public function setTitel(string $titel)
    {
        $this->titel = $titel;
    }

    /**
     * Returns the tage
     *
     * @return int
     */
    public function getTage()
    {
        return $this->tage;
    }
	
	/**
     * Returns the arbeitstage
     * 
     * @return int $arbeitstage
     */
    public function getArbeitstage()
    {
        //$tage = ceil(($this->getEnd()->getTimestamp()-$this->getBegin()->getTimestamp())/(3600*24)+0.1);
        $tage = 0;
        $feiertage = \DslFactory\DslIntranet\Utility\FeiertageUtility::init();
        $feiertageArr = $feiertage->getFeiertageFuerJahr($this->arbeitstageFuerJahr);
        $datum = clone $this->getBegin();
        while ($datum <= $this->getEnd()) {
            if ($datum->format('Y') == $this->arbeitstageFuerJahr) {
                if (!isset($feiertageArr[$datum->format('Y-m-d')])) {
                    //if($this->getStatus()<30){
                    //echo $datum->format("Y-m-d");die;
                    //if(!$monateArr[$datum->format("n")][$datum->format("W")][$datum->format("w")]["weekendDay"]){
                    if ($datum->format('w') > 0 && $datum->format('w') < 6) {
                        //wochenenden ausnehmen
                        $tage++;
                    }
                }
            }
            date_add($datum, date_interval_create_from_date_string('1 day'));
        }
        return $tage;
        $feiertage = \DslFactory\DslIntranet\Utility\FeiertageUtility::init();
        $jahrBegin = new \DateTime('01.01.' . $this->arbeitstageFuerJahr);
        $jahrEnd = new \DateTime('31.12.' . $this->arbeitstageFuerJahr);
        $dateBegin = new \DateTime($this->getBegin()->format('d.m.Y'));
        $dateEnd = new \DateTime($this->getEnd()->format('d.m.Y'));
        if ($jahrBegin > $dateBegin) {
            $dateBegin = new \DateTime('01.01.' . $this->arbeitstageFuerJahr);
        }
        if ($jahrEnd < $dateEnd) {
            $dateEnd = new \DateTime('31.12.' . $this->arbeitstageFuerJahr);
        }
        for ($date = $dateBegin; $date <= $dateEnd; $date->modify('+1 day')) {
            //			echo "<br>".$date->format('d.m.Y H:i');
            if ($date->format('w') > 0 && $date->format('w') < 6) {
                //$feiertageArr = $feiertage->getFeiertageFuerJahr($date->format('w'));
                if (!$feiertage->isFeiertag($date)) {
                    if ($this->arbeitstageFuerJahr && $date->format('Y') == $this->arbeitstageFuerJahr || !$this->arbeitstageFuerJahr) {
                        $tage++;
                    }
                }
            }
        }
        return $tage;
        //+$this->arbeitstageFuerJahr;
        return ceil(($this->getEnd()->getTimestamp() - $this->getBegin()->getTimestamp()) / (3600 * 24) + 0.1);
        return 92;
        return $this->tage;
    }

    /**
     * Sets the tage
     *
     * @param int $tage
     * @return void
     */
    public function setTage(int $tage)
    {
        $this->tage = $tage;
    }

    /**
     * Returns the tageResturlaub
     *
     * @return int
     */
    public function getTageResturlaub()
    {
        return $this->tageResturlaub;
    }

    /**
     * Sets the tageResturlaub
     *
     * @param int $tageResturlaub
     * @return void
     */
    public function setTageResturlaub(int $tageResturlaub)
    {
        $this->tageResturlaub = $tageResturlaub;
    }
	
	/**
     * Returns the status
     * 
     * @return int $status
     */
    public function getStatuss()
    {
        $statuss = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_urlaub']['columns']['status']['config']['items'] as $status) {
            $statuss[$status[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_urlaub.status.' . $status[1], 'dsl_intranet',[],'de');
        }
        return $statuss;
    }
	
	/**
     * @return bool
     */
    public function getRechteUrlaubsManager()
    {
        $feuser = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($feuser->getRechteUrlaubsManager()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getRechteUrlaubEdit()
    {
        $feuser = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($feuser->getRechteUrlaubsManager()) {
            return true;
        }
        if ($feuser->getUid() == $this->mitarbeiter->getUid()) {
            return true;
        }
        return false;
    }
	
	/**
     * Returns the arbeitstageFuerJahr
     *
     * @return int
     */
    public function getArbeitstageFuerJahr()
    {
        return $this->arbeitstageFuerJahr;
    }

	/**
     * Sets the arbeitstageFuerJahr
     * 
     * @param int $arbeitstageFuerJahr
     * @return void
     */
    public function setArbeitstageFuerJahr(int $arbeitstageFuerJahr)
    {
        $this->arbeitstageFuerJahr = $arbeitstageFuerJahr;
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
     * Returns the sonstiges
     *
     * @return bool
     */
    public function getSonstiges()
    {
        return $this->sonstiges;
    }

    /**
     * Sets the sonstiges
     *
     * @param bool $sonstiges
     * @return void
     */
    public function setSonstiges(bool $sonstiges)
    {
        $this->sonstiges = $sonstiges;
    }

    /**
     * Returns the boolean state of sonstiges
     *
     * @return bool
     */
    public function isSonstiges()
    {
        return $this->sonstiges;
    }

    /**
     * Returns the mitarbeiter
     *
     * @return \DslFactory\DslIntranet\Domain\Model\Mitarbeiter
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
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser cruser
     */
    public function setCruser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $cruser)
    {
        $this->cruser = $cruser;
    }
}
