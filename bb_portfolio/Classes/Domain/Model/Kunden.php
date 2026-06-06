<?php
namespace BravoBuero\BbPortfolio\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Kunden
 */
class Kunden extends AbstractEntity
{

    /**
     * alias
     * 
     * @var string
     */
    protected $alias = '';
    
    /**
     * name
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $name = '';
    
    /**
     * Beschreibung
     * 
     * @var string
     */
    protected $beschreibung = '';
    
    /**
     * logo
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $logo = null;
    
    /**
     * ort
     * 
     * @var string
     */
    protected $ort = '';
    
    /**
     * betreuung
     * 
     * @var string
     */
    protected $betreuung = '';
    
    /**
     * Unternehmensgröße
     * 
     * @var int
     */
    protected $unternehmenGroesse = '';
    
    /**
     * Webseite Link
     * 
     * @var string
     */
    protected $linkWebseite = '';
    
    /**
     * Facebook Link
     * 
     * @var string
     */
    protected $linkFacebook = '';
    
    /**
     * Kundenspezifische Farbe für z.B. Hover Effekte
     * 
     * @var string
     */
    protected $primaerFarbe = '';
    
    /**
     * seoTitle
     * 
     * @var string
     */
    protected $seoTitle = '';

    /**
     * seoKeywords
     * 
     * @var string
     */
    protected $seoKeywords = '';
    
    /**
     * seoDescription
     * 
     * @var string
     */
    protected $seoDescription = '';
    
    /**
     * branche
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Branchen>
     */
    protected $branche = null;
    
    /**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns the beschreibung
     * 
     * @return string $beschreibung
     */
    public function getBeschreibung()
    {
        return $this->beschreibung;
    }
    
    /**
     * Sets the beschreibung
     * 
     * @param string $beschreibung
     * @return void
     */
    public function setBeschreibung($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }
    
    /**
     * Returns the logo
     * 
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     */
    public function getLogo()
    {
        return $this->logo;
    }
    
    /**
     * Sets the logo
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     * @return void
     */
    public function setLogo(FileReference $logo)
    {
        $this->logo = $logo;
    }
    
    /**
     * Returns the ort
     * 
     * @return string $ort
     */
    public function getOrt()
    {
        return $this->ort;
    }
    
    /**
     * Sets the ort
     * 
     * @param string $ort
     * @return void
     */
    public function setOrt($ort)
    {
        $this->ort = $ort;
    }
    
    /**
     * Returns the linkWebseite
     * 
     * @return string $linkWebseite
     */
    public function getLinkWebseite()
    {
        return $this->linkWebseite;
    }
    
    /**
     * Sets the linkWebseite
     * 
     * @param string $linkWebseite
     * @return void
     */
    public function setLinkWebseite($linkWebseite)
    {
        $this->linkWebseite = $linkWebseite;
    }
    
    /**
     * Returns the linkFacebook
     * 
     * @return string $linkFacebook
     */
    public function getLinkFacebook()
    {
        return $this->linkFacebook;
    }
    
    /**
     * Sets the linkFacebook
     * 
     * @param string $linkFacebook
     * @return void
     */
    public function setLinkFacebook($linkFacebook)
    {
        $this->linkFacebook = $linkFacebook;
    }
    
    /**
     * Returns the unternehmenGroesse
     * 
     * @return int unternehmenGroesse
     */
    public function getUnternehmenGroesse()
    {
        return $this->unternehmenGroesse;
    }
    
    /**
     * Sets the unternehmenGroesse
     * 
     * @param string $unternehmenGroesse
     * @return void
     */
    public function setUnternehmenGroesse($unternehmenGroesse)
    {
        $this->unternehmenGroesse = $unternehmenGroesse;
    }
    
    /**
     * Returns the primaerFarbe
     * 
     * @return string $primaerFarbe
     */
    public function getPrimaerFarbe()
    {
        return '#' . trim($this->primaerFarbe, '#');
    }
    
    /**
     * Returns the primaerFarbe as rgb array
     * 
     * @return mixed
     */
    public function getPrimaerFarbeRgb()
    {
        $default = array(0 => 0, 1 => 0, 2 => 0);
        $color = trim($this->primaerFarbe, '#');

        if (ctype_xdigit($color) && strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] .$color[5] );
        } elseif (ctype_xdigit($color) && strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }
        
        return array_map('hexdec', $hex);
    }
    
    /**
     * Sets the primaerFarbe
     * 
     * @param string $primaerFarbe
     * @return void
     */
    public function setPrimaerFarbe($primaerFarbe)
    {
        $this->primaerFarbe = $primaerFarbe;
    }
    
    /**
     * Returns the alias
     * 
     * @return string $alias
     */
    public function getAlias()
    {
        return $this->alias;
    }
    
    /**
     * Sets the alias
     * 
     * @param string $alias
     * @return void
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }
    
    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }
    
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->branche = new ObjectStorage();
    }
    
    /**
     * Adds a Branchen
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Branchen $branche
     * @return void
     */
    public function addBranche(Branchen $branche)
    {
        $this->branche->attach($branche);
    }
    
    /**
     * Removes a Branchen
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Branchen $brancheToRemove The Branchen to be removed
     * @return void
     */
    public function removeBranche(Branchen $brancheToRemove)
    {
        $this->branche->detach($brancheToRemove);
    }
    
    /**
     * Returns the branche
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Branchen> $branche
     */
    public function getBranche()
    {
        return $this->branche;
    }
    
    /**
     * Sets the branche
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Branchen> $branche
     * @return void
     */
    public function setBranche(ObjectStorage $branche)
    {
        $this->branche = $branche;
    }
    
    /**
     * Returns the betreuung
     * 
     * @return string $betreuung
     */
    public function getBetreuung()
    {
        return $this->betreuung;
    }
    
    /**
     * Sets the betreuung
     * 
     * @param string $betreuung
     * @return void
     */
    public function setBetreuung($betreuung)
    {
        $this->betreuung = $betreuung;
    }
    

    /**
     * Returns the seoTitle
     * 
     * @return string $seoTitle
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }
    
    /**
     * Returns the seoKeywords
     * 
     * @return string $seoKeywords
     */
    public function getSeoKeywords()
    {
        return $this->seoKeywords;
    }
    
    /**
     * Sets the seoKeywords
     * 
     * @param string $seoKeywords
     * @return void
     */
    public function setSeoKeywords($seoKeywords)
    {
        $this->seoKeywords = $seoKeywords;
    }
    
    /**
     * Returns the seoDescription
     * 
     * @return string $seoDescription
     */
    public function getSeoDescription()
    {
        return $this->seoDescription;
    }
    
    /**
     * Sets the seoDescription
     * 
     * @param string $seoDescription
     * @return void
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seoDescription = $seoDescription;
    }

}