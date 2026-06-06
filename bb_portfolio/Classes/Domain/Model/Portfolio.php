<?php
namespace BravoBuero\BbPortfolio\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Service\TypoLinkCodecService;
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
 * Portfolio
 */
class Portfolio extends AbstractEntity
{

    /**
     * Projektdatum
     * 
     * @var \DateTime
     */
    protected $datum = null;
    
    /**
     * alias
     * 
     * @var string
     */
    protected $alias = '';
    
    /**
				 * titel
				 *
				 * @var string
				 * @Extbase\Validate("NotEmpty")
				 */
				protected $titel = '';
    
    /**
     * untertitel
     * 
     * @var string
     */
    protected $untertitel = '';
    
    /**
     * beschreibung
     * 
     * @var string
     */
    protected $beschreibung = '';
    
    /**
     * link
     * 
     * @var string
     */
    protected $link = '';
    
    /**
     * zeitraum
     * 
     * @var string
     */
    protected $zeitraum = '';
    
    /**
     * system
     * 
     * @var string
     */
    protected $system = '';
    
    /**
				 * teaserBild
				 *
				 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
				 * @Extbase\ORM\Cascade("remove")
				 */
				protected $teaserBild = null;
    
    /**
     * youtube
     * 
     * @var string
     */
    protected $youtube = '';
    
    /**
				 * bilder
				 *
				 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
				 * @Extbase\ORM\Cascade("remove")
				 */
				protected $bilder = null;
    


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
     * kundenname
     * 
     * @var string
     */
    protected $kundenname = '';
    
    /**
     * kundennamecheck
     * 
     * @var int
     */
    protected $kundennamecheck = 0;
    
    /**
     * kunde
     * 
     * @var \BravoBuero\BbPortfolio\Domain\Model\Kunden
     */
    protected $kunde = null;
    
    /**
     * kategorie
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Kategorien>
     */
    protected $kategorie = null;
    
    /**
     * hashtags
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Hashtags>
     */
    protected $hashtags = null;
    
    /**
     * Ähnliche Projekte
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Portfolio>
     */
    protected $related = null;
    
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
        $this->teaserBild = new ObjectStorage();
        $this->bilder = new ObjectStorage();
        $this->kategorie = new ObjectStorage();
        $this->hashtags = new ObjectStorage();
        $this->related = new ObjectStorage();
    }
    
    /**
     * Adds a FileReference
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserBild
     * @return void
     */
    public function addTeaserBild(FileReference $teaserBild)
    {
        $this->teaserBild->attach($teaserBild);
    }
    
    /**
     * Removes a FileReference
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserBildToRemove The FileReference to be removed
     * @return void
     */
    public function removeTeaserBild(FileReference $teaserBildToRemove)
    {
        $this->teaserBild->detach($teaserBildToRemove);
    }
    
    /**
     * Returns the teaserBild
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $teaserBild
     */
    public function getTeaserBild()
    {
        return $this->teaserBild;
    }
    
    /**
     * Sets the teaserBild
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $teaserBild
     * @return void
     */
    public function setTeaserBild(ObjectStorage $teaserBild)
    {
        $this->teaserBild = $teaserBild;
    }
    
    /**
     * Returns the datum
     * 
     * @return \DateTime $datum
     */
    public function getDatum()
    {
        return $this->datum;
    }
    
    /**
     * Sets the datum
     * 
     * @param \DateTime $datum
     * @return void
     */
    public function setDatum(\DateTime $datum)
    {
        $this->datum = $datum;
    }
    
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
     * Returns the link
     * 
     * @return string $link
     */
    public function getLink()
    {
        return $this->link;
    }
    
    /**
     * Returns the linkTitel
     * 
     * @return string
     */
    public function getLinkTitel()
    {
        $typoLinkCodec = GeneralUtility::makeInstance(TypoLinkCodecService::class);
        $typolinkConfiguration = $typoLinkCodec->decode($this->link);
        return $typolinkConfiguration['title'];
    }
    
    /**
     * Sets the link
     * 
     * @param string $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }
    
    /**
     * Returns the kunde
     * 
     * @return \BravoBuero\BbPortfolio\Domain\Model\Kunden $kunde
     */
    public function getKunde()
    {
        return $this->kunde;
    }
    
    /**
     * Sets the kunde
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Kunden $kunde
     * @return void
     */
    public function setKunde(Kunden $kunde)
    {
        $this->kunde = $kunde;
    }
    
    /**
     * Adds a Hashtags
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Hashtags $hashtag
     * @return void
     */
    public function addHashtag(Hashtags $hashtag)
    {
        $this->hashtags->attach($hashtag);
    }
    
    /**
     * Removes a Hashtags
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Hashtags $hashtagToRemove The Hashtags to be removed
     * @return void
     */
    public function removeHashtag(Hashtags $hashtagToRemove)
    {
        $this->hashtags->detach($hashtagToRemove);
    }
    
    /**
     * Returns the hashtags
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Hashtags> $hashtags
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }
    
    /**
     * Sets the hashtags
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Hashtags> $hashtags
     * @return void
     */
    public function setHashtags(ObjectStorage $hashtags)
    {
        $this->hashtags = $hashtags;
    }
    
    /**
     * Returns the zeitraum
     * 
     * @return string $zeitraum
     */
    public function getZeitraum()
    {
        return $this->zeitraum;
    }
    
    /**
     * Sets the zeitraum
     * 
     * @param string $zeitraum
     * @return void
     */
    public function setZeitraum($zeitraum)
    {
        $this->zeitraum = $zeitraum;
    }
    
    /**
     * Returns the system
     * 
     * @return string $system
     */
    public function getSystem()
    {
        return $this->system;
    }
    
    /**
     * Sets the system
     * 
     * @param string $system
     * @return void
     */
    public function setSystem($system)
    {
        $this->system = $system;
    }
    
    /**
     * Adds a FileReference
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $bilder
     * @return void
     */
    public function addBilder(FileReference $bilder)
    {
        $this->bilder->attach($bilder);
    }
    
    /**
     * Removes a FileReference
     * 
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $bilderToRemove The FileReference to be removed
     * @return void
     */
    public function removeBilder(FileReference $bilderToRemove)
    {
        $this->bilder->detach($bilderToRemove);
    }
    
    /**
     * Returns the bilder
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $bilder
     */
    public function getBilder()
    {
        return $this->bilder;
    }
    
    /**
     * Sets the bilder
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $bilder
     * @return void
     */
    public function setBilder(ObjectStorage $bilder)
    {
        $this->bilder = $bilder;
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
     * Returns the youtube
     * 
     * @return string $youtube
     */
    public function getYoutube()
    {
        return $this->youtube;
    }
    
    /**
     * Sets the youtube
     * 
     * @param string $youtube
     * @return void
     */
    public function setYoutube($youtube)
    {
        $this->youtube = $youtube;
    }
    
    /**
     * Adds a Portfolio
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Portfolio $related
     * @return void
     */
    public function addRelated(\BravoBuero\BbPortfolio\Domain\Model\Portfolio $related)
    {
        $this->related->attach($related);
    }
    
    /**
     * Removes a Portfolio
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Portfolio $relatedToRemove The Portfolio to be removed
     * @return void
     */
    public function removeRelated(\BravoBuero\BbPortfolio\Domain\Model\Portfolio $relatedToRemove)
    {
        $this->related->detach($relatedToRemove);
    }
    
    /**
     * Returns the related
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Portfolio> $related
     */
    public function getRelated()
    {
		
        return $this->related;
    }
	
	/**
     * Returns the related
     * 
     * @return mixed
     */
    public function getRelatedActive()
    {
		$arr = array();
		foreach($this->related as $related) $arr[]=$related;
        return $arr;
    }
	
    
    /**
     * Sets the related
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Portfolio> $related
     * @return void
     */
    public function setRelated(ObjectStorage $related)
    {
        $this->related = $related;
    }
    
    /**
     * Adds a Kategorien
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Kategorien $kategorie
     * @return void
     */
    public function addKategorie(Kategorien $kategorie)
    {
        $this->kategorie->attach($kategorie);
    }
    
    /**
     * Removes a Kategorien
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Kategorien $kategorieToRemove The Kategorien to be removed
     * @return void
     */
    public function removeKategorie(Kategorien $kategorieToRemove)
    {
        $this->kategorie->detach($kategorieToRemove);
    }
    
    /**
     * Returns the kategorie
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Kategorien> $kategorie
     */
    public function getKategorie()
    {
        return $this->kategorie;
    }
    
    /**
     * Sets the kategorie
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BravoBuero\BbPortfolio\Domain\Model\Kategorien> $kategorie
     * @return void
     */
    public function setKategorie(ObjectStorage $kategorie)
    {
        $this->kategorie = $kategorie;
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
        if ($this->seoDescription) {
            return $this->seoDescription;
        }
        if ($this->untertitel) {
            return $this->untertitel;
        }
        if ($this->beschreibung) {
            return strip_tags(nl2br($this->beschreibung));
        }
        return $this->titel;
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
    
    /**
     * Returns the kundenname
     * 
     * @return string $kundenname
     */
    public function getKundenname()
    {
        if ($this->kundennamecheck) {
            return $this->kundenname;
        } else {
            if ($this->getKunde()) {
                return $this->getKunde()->getName();
            }
        }
    }
    
    /**
     * Sets the kundenname
     * 
     * @param string $kundenname
     * @return void
     */
    public function setKundenname($kundenname)
    {
        $this->kundenname = $kundenname;
    }
    
    /**
     * Returns the kundennamecheck
     * 
     * @return int kundennamecheck
     */
    public function getKundennamecheck()
    {
        return $this->kundennamecheck;
    }
    
    /**
     * Sets the kundennamecheck
     * 
     * @param int $kundennamecheck
     * @return void
     */
    public function setKundennamecheck($kundennamecheck)
    {
        $this->kundennamecheck = $kundennamecheck;
    }

}