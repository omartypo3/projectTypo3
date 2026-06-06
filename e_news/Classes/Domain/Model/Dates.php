<?php
namespace Emagineurs\ENews\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Xavier LEY <xley@e-magineurs.com>
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
 * Dates 
 */
class Dates extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	
    /**
     * Date de debut
     *
     * @var string 
     */
    protected $begindate;
    
    /**
     * Date de fin
     *
     * @var string 
     */
    protected $finishdate;
    
    /**
     * Heure de debut
     *
     * @var string 
     */
    protected $beginhour;
    
    /**
     * Heure de fin
     *
     * @var string 
     */
    protected $finishhour;
    
    /**
     * Lieu
     *
     * @var string 
     */
    protected $place;
    
    /**
     * Adresse
     *
     * @var string 
     */
    protected $address;
    
    /**
     * Commplement d'adresse
     *
     * @var string 
     */
    protected $addressmore;
    
    /**
     * Ville
     *
     * @var string 
     */
    protected $city;

    
    /**
     * datedebut
     *
     * @return string
     */
    public function getBegindate()
    {
        return $this->begindate;
    }

    /**
     * Set datedebut
     *
     * @param string $datedebut
     * @return void
     */
    public function setBegindate($begindate)
    {
        $this->begindate = $begindate;
    }
    
    /**
     * finishdate
     *
     * @return string
     */
    public function getFinishdate()
    {
        return $this->finishdate;
    }

    /**
     * Set finishdate
     *
     * @param string $finishdate
     * @return void
     */
    public function setFinishdate($finishdate)
    {
        $this->finishdate = $finishdate;
    }
    
    /**
     * heuredebut
     *
     * @return string
     */
    public function getBeginhour()
    {
        return $this->beginhour;
    }

    /**
     * Set heuredebut
     *
     * @param string $heuredebut
     * @return void
     */
    public function setBeginhour($beginhour)
    {
        $this->beginhour = $beginhour;
    }
    
    /**
     * heurefin
     *
     * @return string
     */
    public function getFinishhour()
    {
        return $this->finishhour;
    }

    /**
     * Set heurefin
     *
     * @param string $heurefin
     * @return void
     */
    public function setFinishhour($finishhour)
    {
        $this->finishhour = $finishhour;
    }
    
    /**
     * place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return void
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }
    
    /**
     * address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
    
    /**
     * addressmore
     *
     * @return string
     */
    public function getAddressmore()
    {
        return $this->addressmore;
    }

    /**
     * Set addressmore
     *
     * @param string $addressmore
     * @return void
     */
    public function setAddressmore($addressmore)
    {
        $this->addressmore = $addressmore;
    }
    
    /**
     * city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }    
}
