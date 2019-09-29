<?php
namespace FRONTAL\FagBesichtigung\Domain\Model;

/***
 *
 * This file is part of the "besichtigung" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019
 *
 ***/

/**
 * Gruppentyp
 */
class Gruppentyp extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * titel
     * 
     * @var string
     */
    protected $titel = '';

    /**
     * untertitel
     * 
     * @var string
     */
    protected $untertitel = '';

    /**
     * text
     * 
     * @var string
     */
    protected $text = '';

    /**
     * bild
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @validate NotEmpty
     * @cascade remove
     */
    protected $bild = null;

    /**
     * kosten
     * 
     * @var string
     */
    protected $kosten = '';

    /**
     * Returns the titel
     * 
     * @return string $titel
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
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }

    /**
     * Returns the untertitel
     * 
     * @return string $untertitel
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
    public function setUntertitel($untertitel)
    {
        $this->untertitel = $untertitel;
    }

    /**
     * Returns the text
     * 
     * @return string $text
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
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Returns the bild
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $bild
     */
    public function getBild()
    {
        return $this->bild;
    }

    /**
     * Sets the bild
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $bild
     * @return void
     */
    public function setBild(\TYPO3\CMS\Extbase\Domain\Model\FileReference $bild)
    {
        $this->bild = $bild;
    }

    /**
     * Returns the kosten
     * 
     * @return string $kosten
     */
    public function getKosten()
    {
        return $this->kosten;
    }

    /**
     * Sets the kosten
     * 
     * @param string $kosten
     * @return void
     */
    public function setKosten($kosten)
    {
        $this->kosten = $kosten;
    }
}
