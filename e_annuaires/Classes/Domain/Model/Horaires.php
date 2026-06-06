<?php
namespace Emagineurs\EAnnuaires\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  Xavier Ley xley@e-magineurs.com(c) 2013 
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

if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['ExtendedModel']['Horaires'])) {
	foreach($GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['ExtendedModel']['Horaires'] as $currentPathToAdditionalModel) {
		if (file_exists($currentPathToAdditionalModel)) {
			require_once($currentPathToAdditionalModel);
		}
	}
}

 use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 *
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Horaires extends AbstractModel {

	// Traits to allow third party extension to add element to the model
    use Traits\HorairesExtended;
	
	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;
	
	/**
	 * liens
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Lien>
	 * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
	 */
	protected $liens;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * starttime
	 *
	 * @var string
	 */
	protected $starttime;

	/**
	 * endtime
	 *
	 * @var string
	 */
	protected $endtime;
	
	/**
	 * week
	 *
	 * @var string
	 */
	protected $week;
        
        /**
	 * duration
	 *
	 * @var integer
	 */
	protected $duration = NULL;
        
	/**
	 * openingmonday
	 *
	 * @var string
	 */
	protected $openingmonday;
	
	/**
	 * closuremonday
	 *
	 * @var string
	 */
	protected $closuremonday;
	
	/**
	 * openingtuesday
	 *
	 * @var string
	 */
	protected $openingtuesday;
	
	/**
	 * closuretuesday
	 *
	 * @var string
	 */
	protected $closuretuesday;
	
	/**
	 * openingwednesday
	 *
	 * @var string
	 */
	protected $openingwednesday;
	
	/**
	 * closurewednesday
	 *
	 * @var string
	 */
	protected $closurewednesday;
	
	/**
	 * openingthursday
	 *
	 * @var string
	 */
	protected $openingthursday;
	
	/**
	 * closurethursday
	 *
	 * @var string
	 */
	protected $closurethursday;
	
	/**
	 * openingfriday
	 *
	 * @var string
	 */
	protected $openingfriday;
	
	/**
	 * closurefriday
	 *
	 * @var string
	 */
	protected $closurefriday;
	
	/**
	 * openingsaturday
	 *
	 * @var string
	 */
	protected $openingsaturday;
	
	/**
	 * closuresaturday
	 *
	 * @var string
	 */
	protected $closuresaturday;
	
	/**
	 * openingsunday
	 *
	 * @var string
	 */
	protected $openingsunday;
	
	/**
	 * closuresunday
	 *
	 * @var string
	 */
	protected $closuresunday;

	/**
	 * __construct
	 *
	 * @return Fiche
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->liens = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}
        
	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the liens
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Lien> $liens
	 */
	public function getLiens() {
		return $this->liens;
	}

	/**
	 * Returns the liens
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Lien $liens
	 */
	public function getFirstLiens(){
        $liens = $this->getLiens();
        if (!is_null($liens)) {
			$liens->rewind();
			return $liens->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the liens
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Lien> $liens
	 * @return void
	 */
	public function setLiens(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $liens) {
        $liens->rewind();
        $firstLiens = $liens->current();        
        
        if(empty($firstLiens)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $liensToAttach = $parsedBody['tx_eannuaires_pi1']['horaires']['liens'] ?? null;
            
            if(!empty($liensToAttach)) {
                $liensToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\LienRepository::class)->findByUid($liensToAttach);
                $liens->attach($liensToAttachObj);
            }
        }
		$this->liens = $liens;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the endtime
	 *
	 * @return string $endtime
	 */
	public function getEndtime() {
		if(intval($this->endtime) == '0' ){
			return $this->endtime;
		} else {
			return strftime('%d-%m-%Y',$this->endtime);
		}
	}

	/**
	 * Sets the starttime
	 *
	 * @param string $starttime
	 * @return void
	 */
	public function setEndtime($endtime) {
		if(!is_numeric($endtime)){
			$this->endtime = (strtotime($endtime) === FALSE) ? time() : strtotime($endtime);
		} else {
			$this->endtime = $endtime;
		}
	}

	/**
	 * Returns the starttime
	 *
	 * @return string $starttime
	 */
	public function getStarttime() {
		if(intval($this->starttime) == '0' ){
			return $this->starttime;
		} else {
			return strftime('%d-%m-%Y',$this->starttime);
		}
	}

	/**
	 * Sets the starttime
	 *
	 * @param string $starttime
	 * @return void
	 */
	public function setStarttime($starttime) {
		if(!is_numeric($starttime)){
			$this->starttime = (strtotime($starttime) === FALSE) ? time() : strtotime($starttime);
		} else {
			$this->starttime = $starttime;
		}
	}
        
        
        
	/**
	 * Returns the number of the week
	 *
	 * @return string $week
	 */
	public function getWeek() {
		return $this->week;
	}

	/**
	 * Sets the number of the week
	 *
	 * @param string $week
	 * @return void
	 */
	public function setWeek($week) {
		$this->week = $week;
	}
	
        /**
	 * Returns the duration
	 *
	 * @return int $duration
	 */
	public function getDuration() {
		return $this->duration;
	}

	/**
	 * Sets the duration
	 *
	 * @param int $duration
	 * @return void
	 */
	public function setDuration($duration) {
		$this->duration = $duration;
	}
	
	/**
	 * Returns the hours of opening on mondays
	 *
	 * @return string $openingmonday
	 */
	public function getOpeningmonday() {
		return $this->openingmonday;
	}

	/**
	 * Sets the hours of opening on mondays
	 *
	 * @param string $openingmonday
	 * @return void
	 */
	public function setOpeningmonday($openingmonday) {
		$this->openingmonday = $openingmonday;
	}
	
	/**
	 * Returns the hours of closure on mondays
	 *
	 * @return string $closuremonday
	 */
	public function getClosuremonday() {
		return $this->closuremonday;
	}

	/**
	 * Sets the hours of closure on mondays
	 *
	 * @param string $closuremonday
	 * @return void
	 */
	public function setClosuremonday($closuremonday) {
		$this->closuremonday = $closuremonday;
	}
	
	/**
	 * Returns the hours of opening on tuesdays
	 *
	 * @return string $openingtuesday
	 */
	public function getOpeningtuesday() {
		return $this->openingtuesday;
	}

	/**
	 * Sets the hours of opening on tuesdays
	 *
	 * @param string $openingtuesday
	 * @return void
	 */
	public function setOpeningtuesday($openingtuesday) {
		$this->openingtuesday = $openingtuesday;
	}
	
	/**
	 * Returns the hours of closure on tuesdays
	 *
	 * @return string $closuretuesday
	 */
	public function getClosuretuesday() {
		return $this->closuretuesday;
	}

	/**
	 * Sets the hours of closure on tuesdays
	 *
	 * @param string $closuretuesday
	 * @return void
	 */
	public function setClosuretuesday($closuretuesday) {
		$this->closuretuesday = $closuretuesday;
	}
	
	/**
	 * Returns the hours of opening on wednesdays
	 *
	 * @return string $openingwednesday
	 */
	public function getOpeningwednesday() {
		return $this->openingwednesday;
	}

	/**
	 * Sets the hours of opening on wednesdays
	 *
	 * @param string $openingwednesday
	 * @return void
	 */
	public function setOpeningwednesday($openingwednesday) {
		$this->openingwednesday = $openingwednesday;
	}
	
	/**
	 * Returns the hours of closure on wednesdays
	 *
	 * @return string $closurewednesday
	 */
	public function getClosurewednesday() {
		return $this->closurewednesday;
	}

	/**
	 * Sets the hours of closure on wednesdays
	 *
	 * @param string $closurewednesday
	 * @return void
	 */
	public function setClosurewednesday($closurewednesday) {
		$this->closurewednesday = $closurewednesday;
	}
	
	/**
	 * Returns the hours of opening on thursdays
	 *
	 * @return string $openingthursday
	 */
	public function getOpeningthursday() {
		return $this->openingthursday;
	}

	/**
	 * Sets the hours of opening on thursdays
	 *
	 * @param string $openingthursday
	 * @return void
	 */
	public function setOpeningthursday($openingthursday) {
		$this->openingthursday = $openingthursday;
	}
	
	/**
	 * Returns the hours of closure on thursdays
	 *
	 * @return string $closurethursday
	 */
	public function getClosurethursday() {
		return $this->closurethursday;
	}

	/**
	 * Sets the hours of closure on thursday
	 *
	 * @param string $closurethursday
	 * @return void
	 */
	public function setClosurethursday($closurethursday) {
		$this->closurethursday = $closurethursday;
	}
	
	/**
	 * Returns the hours of opening on fridays
	 *
	 * @return string $openingfriday
	 */
	public function getOpeningfriday() {
		return $this->openingfriday;
	}

	/**
	 * Sets the hours of opening on fridays
	 *
	 * @param string $openingfriday
	 * @return void
	 */
	public function setOpeningfriday($openingfriday) {
		$this->openingfriday = $openingfriday;
	}
	
	/**
	 * Returns the hours of closure on fridays
	 *
	 * @return string $closurefriday
	 */
	public function getClosurefriday() {
		return $this->closurefriday;
	}

	/**
	 * Sets the hours of closure on fridays
	 *
	 * @param string $closurefriday
	 * @return void
	 */
	public function setClosurefriday($closurefriday) {
		$this->closurefriday = $closurefriday;
	}
	
	/**
	 * Returns the hours of opening on saturdays
	 *
	 * @return string $openingsaturday
	 */
	public function getOpeningsaturday() {
		return $this->openingsaturday;
	}

	/**
	 * Sets the hours of opening on saturdays
	 *
	 * @param string $openingsaturday
	 * @return void
	 */
	public function setOpeningsaturday($openingsaturday) {
		$this->openingsaturday = $openingsaturday;
	}
	
	/**
	 * Returns the hours of closure on saturdays
	 *
	 * @return string $closuresaturday
	 */
	public function getClosuresaturday() {
		return $this->closuresaturday;
	}

	/**
	 * Sets the hours of closure on saturdays
	 *
	 * @param string $closuresaturday
	 * @return void
	 */
	public function setClosuresaturday($closuresaturday) {
		$this->closuresaturday = $closuresaturday;
	}
	
	/**
	 * Returns the hours of opening on sundays
	 *
	 * @return string $openingsunday
	 */
	public function getOpeningsunday() {
		return $this->openingsunday;
	}

	/**
	 * Sets the hours of opening on sundays
	 *
	 * @param string $openingsunday
	 * @return void
	 */
	public function setOpeningsunday($openingsunday) {
		$this->openingsunday = $openingsunday;
	}
	
	/**
	 * Returns the hours of closure on sundays
	 *
	 * @return string $closuresunday
	 */
	public function getClosuresunday() {
		return $this->closuresunday;
	}

	/**
	 * Sets the hours of closure on sundays
	 *
	 * @param string $closuresunday
	 * @return void
	 */
	public function setClosuresunday($closuresunday) {
		$this->closuresunday = $closuresunday;
	}
}
?>