<?php
namespace Emagineurs\ENews\Domain\Model\Dto;

/***************************************************************
 *  Copyright notice
 *  (c) 2011 Georg Ringer <typo3@ringerge.org>
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
 
/**
 * News Demand object which holds all information to get the correct
 * news records.
 *
 * 
 */
 
class SearchEnews extends \GeorgRinger\News\Domain\Model\Dto\Search {
	
	/**
	 * Category of the event
	 *
	 * @var string
	 */
	protected $catEvent;

	/**
	 * Categories of the event
	 *
	 * @var array
	 */
	protected $catEventMultiple;
	
	/**
	 * Category of the event
	 *
	 * @var string
	 */
	protected $catEvent2;
	
	/**
	 * Category of the event
	 *
	 * @var string
	 */
	protected $catEvent3;
	
	/**
	 * Category of the event
	 *
	 * @var string
	 */
	protected $catEvent4;
	
	/**
	 * Category of the event
	 *
	 * @var string
	 */
	protected $catEvent5;

	/**
	 * City of the event
	 *
	 * @var string
	 */
	protected $cityEvent;

	/**
	 * City of the event
	 *
	 * @var string
	 */
	protected $tagsEvent;

	/**
	 * City of the event
	 *
	 * @var string
	 */
	protected $youngaudienceEvent;

	/**
	 * City of the event
	 *
	 * @var string
	 */
	protected $freeentranceEvent;
    
	/**
     * Minimum date
     *
     * @var string
     */
    protected $sameDate;

    /**
     * @var string
     */
    protected $section = '';

	/**
	 * Get the category
	 *
	 * @return string
	 */
	public function getCatEvent() {
		return $this->catEvent;
	}

	/**
	 * Set category of the event
	 *
	 * @param string $catEvent
	 * @return void
	 */
	public function setCatEvent($catEvent) {
		$this->catEvent = $catEvent;
	}
	/**
	 * Get the categories
	 *
	 * @return string
	 */
	public function getCatEventMultiple() {
		return $this->catEventMultiple;
	}

	/**
	 * Set categories of the event
	 *
	 * @param string $catEventMultiple
	 * @return void
	 */
	public function setCatEventMultiple($catEventMultiple) {
		$this->catEventMultiple = $catEventMultiple;
	}
    
	/**
	 * Get the category
	 *
	 * @return string
	 */
	public function getCatEvent2() {
		return $this->catEvent2;
	}

	/**
	 * Set category of the event
	 *
	 * @param string $catEvent2
	 * @return void
	 */
	public function setCatEvent2($catEvent2) {
		$this->catEvent2 = $catEvent2;
	}
    
	/**
	 * Get the category
	 *
	 * @return string
	 */
	public function getCatEvent3() {
		return $this->catEvent3;
	}

	/**
	 * Set category of the event
	 *
	 * @param string $catEvent3
	 * @return void
	 */
	public function setCatEvent3($catEvent3) {
		$this->catEvent3 = $catEvent3;
	}
    
	/**
	 * Get the category
	 *
	 * @return string
	 */
	public function getCatEvent4() {
		return $this->catEvent4;
	}

	/**
	 * Set category of the event
	 *
	 * @param string $catEvent4
	 * @return void
	 */
	public function setCatEvent4($catEvent4) {
		$this->catEvent4 = $catEvent4;
	}
    
	/**
	 * Get the category
	 *
	 * @return string
	 */
	public function getCatEvent5() {
		return $this->catEvent5;
	}

	/**
	 * Set category of the event
	 *
	 * @param string $catEvent5
	 * @return void
	 */
	public function setCatEvent5($catEvent5) {
		$this->catEvent5 = $catEvent5;
	}
	
	/**
	 * Get the city
	 *
	 * @return string
	 */
	public function getCityEvent() {
		return $this->cityEvent;
	}

	/**
	 * Set city of the event
	 *
	 * @param string $cityEvent
	 * @return void
	 */
	public function setCityEvent($cityEvent) {
		$this->cityEvent = $cityEvent;
	}


	//Ajout Alexandre

	/**
	 * Get the city
	 *
	 * @return string
	 */
	public function getTagsEvent() {
		return $this->tagsEvent;
	}

	/**
	 * Set city of the event
	 *
	 * @param string $cityEvent
	 * @return void
	 */
	public function setTagsEvent($tagsEvent) {
		$this->tagsEvent = $tagsEvent;
	}

	/**
	 * Get the city
	 *
	 * @return string
	 */
	public function getYoungaudienceEvent() {
		return $this->youngaudienceEvent;
	}

	/**
	 * Set city of the event
	 *
	 * @param string $cityEvent
	 * @return void
	 */
	public function setYoungaudienceEvent($youngaudienceEvent) {
		$this->youngaudienceEvent = $youngaudienceEvent;
	}

	/**
	 * Get the city
	 *
	 * @return string
	 */
	public function getFreeentranceEvent() {
		return $this->freeentranceEvent;
	}

	/**
	 * Set city of the event
	 *
	 * @param string $cityEvent
	 * @return void
	 */
	public function setFreeentranceEvent($freeentranceEvent) {
		$this->freeentranceEvent = $freeentranceEvent;
	}

/**
     * @param string $sameDate
     */
    public function setSameDate($sameDate)
    {
        $this->sameDate = $sameDate;
    }

    /**
     * @return string
     */
    public function getSameDate()
    {
        return $this->sameDate;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $section
     * @return void
     */
    public function setSection($section)
    {
        $this->section = $section;
    }
}
