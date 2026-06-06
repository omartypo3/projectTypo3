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
 * WartungsvertraegeRechnungen
 */
class WartungsvertraegeRechnungen extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * zeitraum
     *
     * @var \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume
     */
    protected $zeitraum;

    /**
     * von
     *
     * @var \DateTime
     */
    protected $von;

    /**
     * bis
     *
     * @var \DateTime
     */
    protected $bis;

    /**
     * preis
     *
     * @var float
     */
    protected $preis;

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz;

    /**
     * eckdaten
     *
     * @var string
     */
    protected $eckdaten;

    /**
     * type
     *
     * @var int
     */
    protected $type;

    /**
     * status
     *
     * @var int
     */
    protected $status;

    /**
     * preisMehraufwand
     *
     * @var float
     */
    protected $preisMehraufwand;

    /**
     * Returns the von
     *
     * @return \DateTime
     */
    public function getVon()
    {
        return $this->von;
    }

    /**
     * Sets the von
     *
     * @param \DateTime $von
     * @return void
     */
    public function setVon(\DateTime $von)
    {
        $this->von = $von;
    }

    /**
     * Returns the bis
     *
     * @return \DateTime
     */
    public function getBis()
    {
        return $this->bis;
    }

    /**
     * Sets the bis
     *
     * @param \DateTime $bis
     * @return void
     */
    public function setBis(\DateTime $bis)
    {
        $this->bis = $bis;
    }

    /**
     * Returns the preis
     *
     * @return float
     */
    public function getPreis()
    {
        return $this->preis;
    }

    /**
     * Sets the preis
     *
     * @param float $preis
     * @return void
     */
    public function setPreis(float $preis)
    {
        $this->preis = $preis;
    }

    /**
     * Returns the preis
     *
     * @return float|null $preis Returns the calculated price or null if calculation isn't possible
     */
    public function getPreisBerechnet()
    {
        $zeitraum = $this->getZeitraum();

        // Check if we got a valid Zeitraum object
        if (!$zeitraum || !is_object($zeitraum)) {
            return null;
        }

        $wartungsvertrag = $zeitraum->getWartungsvertrag();

        // Check if we got a valid Wartungsvertrag object
        if (!$wartungsvertrag) {
            return null;
        }

        // Make sure both required values exist
        if ($wartungsvertrag->getReIntervall() !== null && $wartungsvertrag->getPreisMonatlich() !== null) {
            return $wartungsvertrag->getReIntervall() / 10 * $wartungsvertrag->getPreisMonatlich();
        }

        return null;
    }

    /**
     * Returns the mehraufwand
     *
     * @return int $mehraufwand
     */
    public function getMehraufwandMinuten()
    {
        if ($this->type == 20) {
            return $this->getZeitraum()->getMehraufwandMinuten();
        }
        return false;
    }

    /**
     * Returns the zeitraum
     *
     * @return \DslFactory\DslIntranet\Domain\Model\WartungsvertraegeZeitraeume $zeitraum
     */
    public function getZeitraum()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $wartungsvertraegeZeitraeumeRepository = $objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeZeitraeumeRepository');
        if ($this->zeitraum === NULL) {
            $this->zeitraum = $wartungsvertraegeZeitraeumeRepository->findByRechnung($this);
        }

        return $this->zeitraum;
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
     * Returns the eckdaten
     *
     * @return string
     */
    public function getEckdaten()
    {
        return $this->eckdaten;
    }

    /**
     * Sets the eckdaten
     *
     * @param string $eckdaten
     * @return void
     */
    public function setEckdaten(string $eckdaten)
    {
        $this->eckdaten = $eckdaten;
    }

    /**
     * Returns the type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param int $type
     * @return void
     */
    public function setType(int $type)
    {
        $this->type = $type;
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
     * Returns the preisMehraufwand
     *
     * @return float
     */
    public function getPreisMehraufwand()
    {
        return $this->preisMehraufwand;
    }

    /**
     * Sets the preisMehraufwand
     *
     * @param float $preisMehraufwand
     * @return void
     */
    public function setPreisMehraufwand(float $preisMehraufwand)
    {
        $this->preisMehraufwand = $preisMehraufwand;
    }
}
