<?php
namespace BravoBuero\BbBildwechsel\Domain\Model;

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
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Service\TypoLinkCodecService;

/**
 * Slides
 */
class Slides extends AbstractEntity
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
     * link
     * 
     * @var string
     */
    protected $link = '';
    
    /**
     * bild
     * 
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $bild = null;
    
    /**
     * farbe
     * 
     * @var string
     */
    protected $farbe = '';
    
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
		
		return  $typolinkConfiguration["title"];
		
		
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
    public function setBild(FileReference $bild)
    {
        $this->bild = $bild;
    }
    
    /**
     * Returns the farbe
     * 
     * @return string $farbe
     */
    public function getFarbe()
    {
        return '#' . trim($this->farbe, '#');
    }
    
    /**
     * Sets the farbe
     * 
     * @param string $farbe
     * @return void
     */
    public function setFarbe($farbe)
    {
        $this->farbe = $farbe;
    }
	
    /**
     * Returns the farbe as rgb array
     * 
     * @return mixed
     */
    public function getFarbeRgb()
    {
        $hex = trim($this->farbe, '#');
        //return $hex;
        if (!$hex) {
            return false;
        }
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        $r = hexdec($hex[0] . $hex[1]);
        $g = hexdec($hex[2] . $hex[3]);
        $b = hexdec($hex[4] . $hex[5]);
        return array('r' => $r, 'g' => $g, 'b' => $b);
    }
}