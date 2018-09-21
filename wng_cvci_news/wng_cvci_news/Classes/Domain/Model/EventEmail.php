<?php
namespace Wng\WngCvciNews\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014
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
 * EventEmail
 */
class EventEmail extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * firstname
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $firstname = '';

	/**
	 * lastname
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $lastname = '';

	/**
	 * company
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $company = '';

	/**
	 * jobfield
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $jobfield = '';

	/**
	 * address
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $address = '';

	/**
	 * zip
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $zip = '';

	/**
	 * city
	 * 
	 * @var string
	 */
	protected $city = '';

	/**
	 * phone
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $phone = '';

	/**
	 * mobile
	 * 
	 * @var string
	 */
	protected $mobile = '';

	/**
	 * email
	 * 
	 * @var string
	 * @validate NotEmpty
	 * @validate EmailAddress
	 */
	protected $email = '';

	/**
	 * comments
	 * 
	 * @var string
	 */
	protected $comments = '';

	/**
	 * event
	 * 
	 * @var \Wng\WngCvciNews\Domain\Model\Event
	 * @validate NotEmpty
	 */
	protected $event = NULL;

	/**
	 * user
	 * 
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $user = NULL;

	/**
	 * aperitif
	 *
	 * @var boolean
	 */
	protected $aperitif = FALSE;

	/**
	 * apparaitre
	 *
	 * @var boolean
	 */
	protected $apparaitre = FALSE;

	/**
	 * Returns the firstname
	 * 
	 * @return string $firstname
	 */
	public function getFirstname() {
		return $this->firstname;
	}

	/**
	 * Sets the firstname
	 * 
	 * @param string $firstname
	 * @return void
	 */
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}

	/**
	 * Returns the lastname
	 * 
	 * @return string $lastname
	 */
	public function getLastname() {
		return $this->lastname;
	}

	/**
	 * Sets the lastname
	 * 
	 * @param string $lastname
	 * @return void
	 */
	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}

	/**
	 * Returns the company
	 * 
	 * @return string $company
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * Sets the company
	 * 
	 * @param string $company
	 * @return void
	 */
	public function setCompany($company) {
		$this->company = $company;
	}

	/**
	 * Returns the jobfield
	 * 
	 * @return string $jobfield
	 */
	public function getJobfield() {
		return $this->jobfield;
	}

	/**
	 * Sets the jobfield
	 * 
	 * @param string $jobfield
	 * @return void
	 */
	public function setJobfield($jobfield) {
		$this->jobfield = $jobfield;
	}

	/**
	 * Returns the address
	 * 
	 * @return string $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 * 
	 * @param string $address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Returns the zip
	 * 
	 * @return string $zip
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * Sets the zip
	 * 
	 * @param string $zip
	 * @return void
	 */
	public function setZip($zip) {
		$this->zip = $zip;
	}

	/**
	 * Returns the city
	 * 
	 * @return string $city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Sets the city
	 * 
	 * @param string $city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Returns the phone
	 * 
	 * @return string $phone
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Sets the phone
	 * 
	 * @param string $phone
	 * @return void
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * Returns the mobile
	 * 
	 * @return string $mobile
	 */
	public function getMobile() {
		return $this->mobile;
	}

	/**
	 * Sets the mobile
	 * 
	 * @param string $mobile
	 * @return void
	 */
	public function setMobile($mobile) {
		$this->mobile = $mobile;
	}

	/**
	 * Returns the email
	 * 
	 * @return string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the email
	 * 
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the comments
	 * 
	 * @return string $comments
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * Sets the comments
	 * 
	 * @param string $comments
	 * @return void
	 */
	public function setComments($comments) {
		$this->comments = $comments;
	}

	/**
	 * Returns the event
	 * 
	 * @return \Wng\WngCvciNews\Domain\Model\Event $event
	 */
	public function getEvent() {
		return $this->event;
	}

	/**
	 * Sets the event
	 * 
	 * @param \Wng\WngCvciNews\Domain\Model\Event $event
	 * @return void
	 */
	public function setEvent(\Wng\WngCvciNews\Domain\Model\Event $event = NULL) {
		$this->event = $event;
	}

	/**
	 * Returns the user
	 * 
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the user
	 * 
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
	 * @return void
	 */
	public function setUser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user = NULL) {
		$this->user = $user;
	}

	/**
	 * Returns the aperitif
	 *
	 * @return boolean $aperitif
	 */
	public function getAperitif() {
		return $this->aperitif;
	}

	/**
	 * Sets the aperitif
	 *
	 * @param boolean $aperitif
	 * @return void
	 */
	public function setAperitif($aperitif) {
		$this->aperitif = $aperitif;
	}

	/**
	 * Returns the apparaitre
	 *
	 * @return boolean $apparaitre
	 */
	public function getApparaitre() {
		return $this->apparaitre;
	}

	/**
	 * Sets the apparaitre
	 *
	 * @param boolean $apparaitre
	 * @return void
	 */
	public function setApparaitre($apparaitre) {
		$this->apparaitre = $apparaitre;
	}

}