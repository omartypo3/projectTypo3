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
 * News
 */
class News extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * titel
     *
     * @var string
     */
    protected $titel;

    /**
     * untertitel
     *
     * @var string
     */
    protected $untertitel;

    /**
     * text
     *
     * @var string
     */
    protected $text;

    /**
     * angebot1
     *
     * @var string
     */
    protected $angebot1;

    /**
     * angebot2
     *
     * @var string
     */
    protected $angebot2;

    /**
     * angebot3
     *
     * @var string
     */
    protected $angebot3;

    /**
     * linkExtern
     *
     * @var string
     */
    protected $linkExtern;

    /**
     * linkExternName
     *
     * @var string
     */
    protected $linkExternName;

    /**
     * sichtbarkeit
     *
     * @var bool
     */
    protected $sichtbarkeit;

    /**
     * gueltigAb
     *
     * @var \DateTime
     */
    protected $gueltigAb;

    /**
     * gueltigBis
     *
     * @var \DateTime
     */
    protected $gueltigBis;

    /**
     * datei
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $datei;

    /**
     * countdown
     *
     * @var bool
     */
    protected $countdown;

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
     * Returns the untertitel
     *
     * @return string
     */
    public function getUntertitel()
    {
        return $this->untertitel;
    }

    /**
     * Sets the untertitel
     *
     * @param string $untertitel
     * @return void
     */
    public function setUntertitel(string $untertitel)
    {
        $this->untertitel = $untertitel;
    }

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
     * Returns the angebot1
     *
     * @return string
     */
    public function getAngebot1()
    {
        return $this->angebot1;
    }

    /**
     * Sets the angebot1
     *
     * @param string $angebot1
     * @return void
     */
    public function setAngebot1(string $angebot1)
    {
        $this->angebot1 = $angebot1;
    }

    /**
     * Returns the angebot2
     *
     * @return string
     */
    public function getAngebot2()
    {
        return $this->angebot2;
    }

    /**
     * Sets the angebot2
     *
     * @param string $angebot2
     * @return void
     */
    public function setAngebot2(string $angebot2)
    {
        $this->angebot2 = $angebot2;
    }

    /**
     * Returns the angebot3
     *
     * @return string
     */
    public function getAngebot3()
    {
        return $this->angebot3;
    }

    /**
     * Sets the angebot3
     *
     * @param string $angebot3
     * @return void
     */
    public function setAngebot3(string $angebot3)
    {
        $this->angebot3 = $angebot3;
    }

    /**
     * Returns the linkExtern
     *
     * @return string
     */
    public function getLinkExtern()
    {
        return $this->linkExtern;
    }

    /**
     * Sets the linkExtern
     *
     * @param string $linkExtern
     * @return void
     */
    public function setLinkExtern(string $linkExtern)
    {
        $this->linkExtern = $linkExtern;
    }

    /**
     * Returns the linkExternName
     *
     * @return string
     */
    public function getLinkExternName()
    {
        return $this->linkExternName;
    }

    /**
     * Sets the linkExternName
     *
     * @param string $linkExternName
     * @return void
     */
    public function setLinkExternName(string $linkExternName)
    {
        $this->linkExternName = $linkExternName;
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
     * Returns the gueltigAb
     *
     * @return \DateTime
     */
    public function getGueltigAb()
    {
        return $this->gueltigAb;
    }

    /**
     * Sets the gueltigAb
     *
     * @param \DateTime $gueltigAb
     * @return void
     */
    public function setGueltigAb(\DateTime $gueltigAb)
    {
        $this->gueltigAb = $gueltigAb;
    }

    /**
     * Returns the gueltigBis
     *
     * @return \DateTime
     */
    public function getGueltigBis()
    {
        return $this->gueltigBis;
    }

    /**
     * Sets the gueltigBis
     *
     * @param \DateTime $gueltigBis
     * @return void
     */
    public function setGueltigBis(\DateTime $gueltigBis)
    {
        $this->gueltigBis = $gueltigBis;
    }

    /**
     * Returns the datei
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getDatei()
    {
        return $this->datei;
    }

    /**
     * Sets the datei
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $datei
     * @return void
     */
    public function setDatei(\TYPO3\CMS\Extbase\Domain\Model\FileReference $datei)
    {
        $this->datei = $datei;
    }

    /**
     * Returns the countdown
     *
     * @return bool
     */
    public function getCountdown()
    {
        return $this->countdown;
    }

    /**
     * Sets the countdown
     *
     * @param bool $countdown
     * @return void
     */
    public function setCountdown(bool $countdown)
    {
        $this->countdown = $countdown;
    }

    /**
     * Returns the boolean state of countdown
     *
     * @return bool
     */
    public function isCountdown()
    {
        return $this->countdown;
    }

    public function toggleSichtbarkeit()
    {
        if ($this->sichtbarkeit) {
            $this->sichtbarkeit = FALSE;
        } else {
            $this->sichtbarkeit = TRUE;
        }
    }

    public function toggleCountdown()
    {
        if ($this->countdown) {
            $this->countdown = FALSE;
        } else {
            $this->countdown = TRUE;
        }
    }
}
