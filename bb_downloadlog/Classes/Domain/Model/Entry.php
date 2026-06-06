<?php
namespace BravoBuero\BbDownloadlog\Domain\Model;

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
 * Entry
 */
class Entry extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Zeitpunkt des Downloads
     * 
     * @var \DateTime
     */
    protected $zeitpunkt = null;
    
    /**
     * Frontend Nutzer welcher die Datei heruntergeladen hat
     * 
     * @var string
     */
    protected $feuser = '';
    
    /**
     * welcherbenutzergruppe der Nutzer angehörte
     * 
     * @var string
     */
    protected $feusergroups = '';
    
    /**
     * file
     * 
     * @var \TYPO3\CMS\Core\Resource\File
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $file = null;
    
    /**
     * Returns the zeitpunkt
     * 
     * @return \DateTime $zeitpunkt
     */
    public function getZeitpunkt()
    {
        return $this->zeitpunkt;
    }
    
    /**
     * Sets the zeitpunkt
     * 
     * @param \DateTime $zeitpunkt
     * @return void
     */
    public function setZeitpunkt(\DateTime $zeitpunkt)
    {
        $this->zeitpunkt = $zeitpunkt;
    }
    
    /**
     * Returns the feuser
     * 
     * @return string $feuser
     */
    public function getFeuser()
    {
        return $this->feuser;
    }
    
    /**
     * Sets the feuser
     * 
     * @param string $feuser
     * @return void
     */
    public function setFeuser($feuser)
    {
        $this->feuser = $feuser;
    }
    
    /**
     * Returns the file
     * 
     * @return \TYPO3\CMS\Core\Resource\File file
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Sets the file
     * 
     * @param \TYPO3\CMS\Core\Resource\File $file
     * @return void
     */
    public function setFile(\TYPO3\CMS\Core\Resource\File $file)
    {
        $this->file = (int) $file->getUid();
    }
    
    /**
     * Returns the feusergroups
     * 
     * @return string $feusergroups
     */
    public function getFeusergroups()
    {
        return $this->feusergroups;
    }
    
    /**
     * Sets the feusergroups
     * 
     * @param string $feusergroups
     * @return void
     */
    public function setFeusergroups($feusergroups)
    {
        $this->feusergroups = $feusergroups;
    }

}