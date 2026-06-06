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

if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['ExtendedModel']['Fiche'])) {
	foreach($GLOBALS['TYPO3_CONF_VARS']['EXT']['e_annuaires']['ExtendedModel']['Fiche'] as $currentPathToAdditionalModel) {
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
class Fiche extends AbstractModel {
	
	// Traits to allow third party extension to add element to the model
    use Traits\FicheExtended;
	
	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * firstname
	 *
	 * @var string
	 */
	protected $firstname;

	/**
	 * intituleaddress
	 *
	 * @var string
	 */
	protected $intituleaddress;

	/**
	 * address
	 *
	 * @var string
	 */
	protected $address;

	/**
	 * address2
	 *
	 * @var string
	 */
	protected $address2;

	/**
	 * zipcode
	 *
	 * @var string
	 */
	protected $zipcode;

	/**
	 * country
	 *
	 * @var string
	 */
	protected $country;

	/**
	 * bp
	 *
	 * @var string
	 */
	protected $bp;

	/**
	 * cedex
	 *
	 * @var string
	 */
	protected $cedex;

	/**
	 * cell
	 *
	 * @var string
	 */
	protected $cell;

	/**
	 * phone
	 *
	 * @var string
	 */
	protected $phone;

	/**
	 * phonesecondaire
	 *
	 * @var string
	 */
	protected $phonesecondaire;

	/**
	 * fax
	 *
	 * @var string
	 */
	protected $fax;

	/**
	 * faxsecondaire
	 *
	 * @var string
	 */
	protected $faxsecondaire;

	/**
	 * typeelement
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Conf\Typeannuaire>
	 */
	protected $typeelement;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * image
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Filereference>
	 */
	protected $image;

	/**
	 * imageinstancier > will allow to set the image from $_FILES
	 *
	 * @var array
	 */
	protected $imageinstancier;

	/**
	 * media
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Filereference>
	 */
	protected $media;

	/**
	 * mediainstancier > will allow to set the media from $_FILES
	 *
	 * @var array
	 */
	protected $mediainstancier;

	/**
	 * www
	 *
	 * @var string
	 */
	protected $www;

	/**
	 * email
	 *
	 * @var string
	 */
	protected $email;

	/**
	 * mail
	 *
	 * @var string
	 */
	protected $mail;

	/**
	 * feuser  
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser>
	 */
	protected $feuser;

	/**
	 * civility
	 *
	 * @var int
	 */
	protected $civility;

	/**
	 * office
	 *
	 * @var string
	 */
	protected $office;

	/**
	 * categories
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Categorie>
	 */
	protected $categories;

	/**
	 * city
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\City>
	 */
	protected $city;

	/**
	 * citylinked
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\City>
	 */
	protected $citylinked;

	/**
	 * district
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\District>
	 */
	protected $district;

	/**
	 * documents
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Documents>
	 */
	protected $documents;

	/**
	 * liens
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Lien>
	 */
	protected $liens;

	/**
	 * horaires
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Horaires>
	 */
	protected $horaires;

	/**
	 * canton
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche>
	 */
	protected $canton;

	/**
	 * commission
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Commission>
	 */
	protected $commission;

	/**
	 * actions
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Actions>
	 */
	protected $actions;

	/**
	 * production
	 *
	 * @var string
	 */
	protected $production;

	/**
	 * ouvert
	 *
	 * @var int
	 */
	protected $ouvert;

	/**
	 * ouvertcomment
	 *
	 * @var string
	 */
	protected $ouvertcomment;

	/**
	 * ouvertComment (alias for ouvertcomment)
	 *
	 * @var string
	 */
	protected $ouvertComment;

	/**
	 * beneficiaire
	 *
	 * @var string
	 */
	protected $beneficiaire;

	/**
	 * objet
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Objet>
	 */
	protected $objet;

	/**
	 * enjeux
	 *
	 * @var string
	 */
	protected $enjeux;

	/**
	 * uploadimage
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Image>
	 */
	protected $uploadimage;

	/**
	 * contacts
	 *
	 * @var string
	 */
	protected $contacts;

	/**
	 * linkcontact
	 *
	 * @var string
	 */
	protected $linkcontact;

	/**
	 * hebergementtemp
	 *
	 * @var bool
	 */
	protected $hebergementtemp;

	/**
	 * accueiljour
	 *
	 * @var bool
	 */
	protected $accueiljour;

	/**
	 * uniteterritoriale
	 *
	 * @var string
	 */
	protected $uniteterritoriale;

	/**
	 * cantonstexte
	 *
	 * @var string
	 */
	protected $cantonstexte;

	/**
	 * intercommunalite
	 *
	 * @var string
	 */
	protected $intercommunalite;

	/**
	 * datefiche
	 *
	 * @var string
	 */
	protected $datefiche;

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
	 * tstamp
	 *
	 * @var string
	 */
	protected $tstamp;

	/**
	 * tstamp
	 *
	 * @var string
	 */
	protected $crdate;

	/**
	 * hidden
	 *
	 * @var string
	 */
	protected $hidden;
        
    /**
	 * typeepci
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche>
	 */
	protected $typeepci;
	
	/**
	 * mandats
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Mandat>
	 */
	protected $mandats;

	/**
	 * typehandicap
	 *
	 * @var string
	 */
	protected $typehandicap;

	/**
	 * contrat
	 *
	 * @var string
	 */
	protected $contrat;

	/**
	 * population
	 *
	 * @var string
	 */
	protected $population;

    /**
	 * mds
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche>
	 */
	protected $mds;

    /**
	 * cdps
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche>
	 */
	protected $cdps;

    /**
	 * pack
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Pack>
	 */
	protected $pack;

	/**
	 * partipolitique
	 *
	 * @var string
	 */
	protected $partipolitique;

	/**
	 * latsecondaire
	 *
	 * @var string
	 */
	protected $latsecondaire;

	/**
	 * lngsecondaire
	 *
	 * @var string
	 */
	protected $lngsecondaire;

	/**
	 * firstletter
	 *
	 * @var string
	 */
	protected $firstletter;

	/**
	 * config
	 *
	 * @var string
	 */
	protected $config;

	/**
	 * deleted
	 *
	 * @var int
	 */
	protected $deleted;


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
		$this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();		
		$this->documents = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->liens = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->commission = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->actions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->objet = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->uploadimage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->image = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->media = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->city = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->citylinked = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->mandats = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->pack = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

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
	 * Returns the intituleaddress
	 *
	 * @return string $intituleaddress
	 */
	public function getIntituleaddress() {
		return $this->intituleaddress;
	}

	/**
	 * Sets the intituleaddress
	 *
	 * @param string $intituleaddress
	 * @return void
	 */
	public function setIntituleaddress($intituleaddress) {
		$this->intituleaddress = $intituleaddress;
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
	 * Returns the address2
	 *
	 * @return string $address2
	 */
	public function getAddress2() {
		return $this->address2;
	}

	/**
	 * Sets the address
	 *
	 * @param string $address2
	 * @return void
	 */
	public function setAddress2($address2) {
		$this->address2 = $address2;
	}

	/**
	 * Returns the zipcode
	 *
	 * @return string $zipcode
	 */
	public function getZipcode() {
		return $this->zipcode;
	}

	/**
	 * Sets the zipcode
	 *
	 * @param string $zipcode
	 * @return void
	 */
	public function setZipcode($zipcode) {
		$this->zipcode = $zipcode;
	}

	/**
	 * Returns the country
	 *
	 * @return string $country
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Sets the country
	 *
	 * @param string $country
	 * @return void
	 */
	public function setCountry($country) {
		$this->country = $country;
	}
	
	/* que fait-il là?*/
	public function setNewLettre($NewLettre) {
		$this->NewLettre = $NewLettre;
	}

	/**
	 * Returns the bp
	 *
	 * @return string $bp
	 */
	public function getBp() {
		return $this->bp;
	}

	/**
	 * Sets the bp
	 *
	 * @param string $bp
	 * @return void
	 */
	public function setBp($bp) {
		$this->bp = $bp;
	}

	/**
	 * Returns the cedex
	 *
	 * @return string $cedex
	 */
	public function getCedex() {
		return $this->cedex;
	}

	/**
	 * Sets the $cedex
	 *
	 * @param string $cedex
	 * @return void
	 */
	public function setCedex($cedex) {
		$this->cedex = $cedex;
	}

	/**
	 * Returns the cell
	 *
	 * @return string $cell
	 */
	public function getCell() {
		return $this->cell;
	}

	/**
	 * Sets the cell
	 *
	 * @param string $cell
	 * @return void
	 */
	public function setCell($cell) {
		$this->cell = $cell;
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
	 * Returns the phonesecondaire
	 *
	 * @return string $phonesecondaire
	 */
	public function getPhonesecondaire() {
		return $this->phonesecondaire;
	}

	/**
	 * Sets the phonesecondaire
	 *
	 * @param string $phonesecondaire
	 * @return void
	 */
	public function setPhonesecondaire($phonesecondaire) {
		$this->phonesecondaire = $phonesecondaire;
	}

	/**
	 * Returns the fax
	 *
	 * @return string $fax
	 */
	public function getFax() {
		return $this->fax;
	}

	/**
	 * Sets the fax
	 *
	 * @param string $fax
	 * @return void
	 */
	public function setFax($fax) {
		$this->fax = $fax;
	}

	/**
	 * Returns the faxsecondaire
	 *
	 * @return string $faxsecondaire
	 */
	public function getFaxsecondaire() {
		return $this->faxsecondaire;
	}

	/**
	 * Sets the faxsecondaire
	 *
	 * @param string $faxsecondaire
	 * @return void
	 */
	public function setFaxsecondaire($faxsecondaire) {
		$this->faxsecondaire = $faxsecondaire;
	}

	/**
	 * Returns the config
	 *
	 * @return string $config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * Sets the config
	 *
	 * @param string $config
	 * @return void
	 */
	public function setConfig($config) {
		$this->config = $config;
	}

	/**
	 * Returns the typeelement
	 *
	 * @return int $typeelement
	 */
	public function getTypeelement() {
		return $this->typeelement;
	}

	/**
	 * Sets the typeelement
	 *
	 * @param int $typeelement
	 * @return void
	 */
	public function setTypeelement($typeelement) {
		$this->typeelement = $typeelement;
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
	 * Returns the image
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Filereference> $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Returns the image
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Filereference $image
	 */
	public function getFirstImage() {
        $image = $this->getImage();
        if (!is_null($image)) {
			$image->rewind();
			return $image->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the image
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Filereference> $image
	 * @return void
	 */
	public function setImage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $image) {		
		if($this->image->count() < 1 || $image->count() > 0) {
			$this->image = $image;
		}
	}

	/**
	 * Returns nothing > created because probably called if property imageinstancier used in a form
	 *
	 * @return void
	 */
	public function getImageinstancier() {}
	
	/**
	 * Sets the image from $_FILES
	 *
	 * @param array $files
	 * @return void
	 */
	public function setImageinstancier($files) {
		$this->setFileInstancier($files, $this, 'image');
	}

	/**
	 * Returns the media
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Filereference> $media
	 */
	public function getMedia() {
		return $this->media;
	}

	/**
	 * Returns the media
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Filereference $media
	 */
	public function getFirstMedia() {
        $media = $this->getMedia();
        if (!is_null($media)) {
			$media->rewind();
			return $media->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the media
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Filereference> $media
	 * @return void
	 */
	public function setMedia(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $media) {
		if($this->media->count() < 1 || $media->count() > 0) {
			$this->media = $media;
		}
	}

	/**
	 * Returns nothing > created because probably called if property mediainstancier used in a form
	 *
	 * @return void
	 */
	public function getMediainstancier() {}
	
	/**
	 * Sets the media from $_FILES
	 *
	 * @param array $files
	 * @return void
	 */
	public function setMediainstancier($files) {
		$this->setFileInstancier($files, $this, 'media');
	}

	/**
	 * Returns the www
	 *
	 * @return string $www
	 */
	public function getWww() {
		return $this->www;
	}

	/**
	 * Sets the www
	 *
	 * @param string $www
	 * @return void
	 */
	public function setWww($www) {
		$this->www = $www;
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
	 * Returns the mail
	 *
	 * @return string $mail
	 */
	public function getMail() {
		return $this->mail;
	}

	/**
	 * Sets the mail
	 *
	 * @param string $mail
	 * @return void
	 */
	public function setMail($mail) {
		$this->mail = $mail;
	}

	/**
	 * Returns the feuser
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser> $feuser
	 */
	public function getFeuser() {
		return $this->feuser;
	}

	/**
	 * Returns the feuser
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feuser
	 */
	public function getFirstFeuser() {
        $feuser = $this->getFeuser();
        if (!is_null($feuser)) {
			$feuser->rewind();
			return $feuser->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the feuser
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser> $feuser
	 * @return void
	 */
	public function setFeuser($feuser) {
		$this->feuser = $feuser;
	}

	/**
	 * Returns the civility
	 *
	 * @return int $civility
	 */
	public function getCivility() {
		return $this->civility;
	}

	/**
	 * Sets the civility
	 *
	 * @param int $civility
	 * @return void
	 */
	public function setCivility($civility) {
		$this->civility = $civility;
	}

	/**
	 * Returns the office
	 *
	 * @return string $office
	 */
	public function getOffice() {
		return $this->office;
	}

	/**
	 * Sets the office
	 *
	 * @param string $office
	 * @return void
	 */
	public function setOffice($office) {
		$this->office = $office;
	}

	/**
	 * Adds a Categorie
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Categorie $category
	 * @return void
	 */
	public function addCategory(\Emagineurs\EAnnuaires\Domain\Model\Categorie $category) {
		$this->categories->attach($category);
	}

	/**
	 * Removes a Categorie
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Categorie $categoryToRemove The Categorie to be removed
	 * @return void
	 */
	public function removeCategory(\Emagineurs\EAnnuaires\Domain\Model\Categorie $categoryToRemove) {
		$this->categories->detach($categoryToRemove);
	}
	
	/**
	 * Returns the categories
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Categorie> $categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Returns the categories
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Categorie $categories
	 */
	public function getFirstCategory() {
        $categories = $this->getCategories();
        if (!is_null($categories)) {
			$categories->rewind();
			return $categories->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the categories
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Categorie> $categories
	 * @return void
	 */
	public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories) {
		$categories->rewind();
        $firstCategory = $categories->current();
        
        if(empty($firstCategory)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $categoryToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['categories'] ?? null;
            
            if(!empty($categoryToAttach)) {
                $categoryToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\CategorieRepository::class)->findByUid($categoryToAttach);
                $categories->attach($categoryToAttachObj);
             }
        }
        $this->categories = $categories;
	}

	/**
	 * Returns the city
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\City> $city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Returns the City
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\City $city
	 */
	public function getFirstCity() {
        $city = $this->getCity();
        if (!is_null($city)) {
			$city->rewind();
			return $city->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the city
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\City> $city
	 * @return void
	 */
	public function setCity(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $city) {
        $city->rewind();
        $firstCity = $city->current();
        
        if(empty($firstCity)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $cityToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['city'] ?? null;
            
            if(!empty($cityToAttach)) {
                $cityToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\CityRepository::class)->findByUid($cityToAttach);
                $city->attach($cityToAttachObj);
            }
        }
		$this->city = $city;
	}

	/**
	 * Returns the citylinked
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\City> $citylinked
	 */
	public function getCitylinked() {
		return $this->citylinked;
	}

	/**
	 * Returns the citylinked
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\City $citylinked
	 */
	public function getFirstCitylinked(){
        $citylinked = $this->getCitylinked();
        if (!is_null($citylinked)) {
			$citylinked->rewind();
			return $citylinked->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the citylinked
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\City> $citylinked
	 * @return void
	 */
	public function setCitylinked(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $citylinked) {
        $citylinked->rewind();
        $firstCitylinked = $citylinked->current();
        
        if(empty($firstCitylinked)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $citylinkedToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['citylinked'] ?? null;
            
            if(!empty($citylinkedToAttach)) {
                $citylinkedToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\CityRepository::class)->findByUid($citylinkedToAttach);
                $citylinked->attach($citylinkedToAttachObj);
            }
        }
		$this->citylinked = $citylinked;
	}


	/**
	 * Returns the district
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\District> $district
	 */
	public function getDistrict() {
		return $this->district;
	}

	/**
	 * Returns the district
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\District $district
	 */
	public function getFirstDistrict(){
        $district = $this->getDistrict();
		if (!is_null($district)) {
			$district->rewind();
			return $district->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the district
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\District> $district
	 * @return void
	 */
	public function setDistrict(\TYPO3\CMS\Extbase\Persistence\ObjectStorage  $district) {
        $district->rewind();
        $firstDistrict = $district->current();
        
        if(empty($firstDistrict)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $districtToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['district'] ?? null;
            
            if(!empty($districtToAttach)) {
                $districtToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\DistrictRepository::class)->findByUid($districtToAttach);
                $district->attach($districtToAttachObj);
            }
        }
		$this->district = $district;
	}

	/**
	 * Adds a Documents
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Documents $document
	 * @return void
	 */
	public function addDocument(\Emagineurs\EAnnuaires\Domain\Model\Documents $document) {
		$this->documents->attach($document);
	}

	/**
	 * Removes a Documents
	 *
	 * @param \Emagineurs\EAnnuaires\Domain\Model\Documents $documentToRemove The Documents to be removed
	 * @return void
	 */
	public function removeDocument(\Emagineurs\EAnnuaires\Domain\Model\Documents $documentToRemove) {
		$this->documents->detach($documentToRemove);
	}

	/**
	 * Returns the documents
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Documents> $documents
	 */
	public function getDocuments() {
		return $this->documents;
	}

	/**
	 * Returns the documents
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Documents $documents
	 */
	public function getFirstDocuments(){
        $documents = $this->getDocuments();
        if (!is_null($documents)) {
			$documents->rewind();
			return $documents->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the documents
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Documents> $documents
	 * @return void
	 */
	public function setDocuments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $documents) {
        $documents->rewind();
        $firstDocuments = $documents->current();
        
        if(empty($firstDocuments)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $documentsToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['documents'] ?? null;
            
            if(!empty($documentsToAttach)) {
                $documentsToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\LienRepository::class)->findByUid($documentsToAttach);
                $documents->attach($documentsToAttachObj);
            }
        }
		$this->documents = $documents;
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
            $liensToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['liens'] ?? null;
            
            if(!empty($liensToAttach)) {
                $liensToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\LienRepository::class)->findByUid($liensToAttach);
                $liens->attach($liensToAttachObj);
            }
        }
		$this->liens = $liens;
	}

	/**
	 * Returns the horaires
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Horaires> $horaires
	 */
	public function getHoraires() {
		return $this->horaires;
	}

	/**
	 * Returns the horaires
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Horaires $horaires
	 */
	public function getFirstHoraires(){
        $horaires = $this->getHoraires();
        if (!is_null($horaires)) {
			$horaires->rewind();
			return $horaires->current();
        } else {
            return null;
        }
	}

	/**
	 * Returns the horaire corresponding to the current date
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Horaires $horaires
	 */
	public function getLastHoraires(){
		// We will reorder the horaires in order to sort them by starttime and return only the wanted horaire
        $horaires = $this->getHoraires()->toArray();
		
        if (!empty($horaires)) {
			$lastHoraire = reset($horaires);
			$maxStartDate = '0';
			
			// We check every horaire and keep the one with the highest starttime (extbase only gives us those who are supposed to be currently occurring)
			foreach($horaires as $horaire){
				if(strtotime($horaire->getStarttime()) > $maxStartDate){
					$maxStartDate = intval($horaire->getStarttime());
					$lastHoraire = $horaire;
				}
			}
			
			// We return the wanted horaire
			return $lastHoraire;
        } else {
            return null;
        }
	}

	/**
	 * Sets the horaires
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Horaires> $horaires
	 * @return void
	 */
	public function setHoraires(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $horaires) {
        $horaires->rewind();
        $firstHoraires = $horaires->current();        
        
        if(empty($firstHoraires)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $horairesToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['horaires'] ?? null;
            
            if(!empty($horairesToAttach)) {
                $horairesToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\HorairesRepository::class)->findByUid($horairesToAttach);
                $horaires->attach($horairesToAttachObj);
            }
        }
		$this->horaires = $horaires;
	}

	/**
	 * Returns the canton
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche> $canton
	 */
	public function getCanton() {
		return $this->canton;
	}

	/**
	 * Returns the canton
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Fiche $canton
	 */
	public function getFirstCanton(){
        $canton = $this->getFeuser();
        if (!is_null($canton)) {
			$canton->rewind();
			return $canton->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the canton
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche> $canton
	 * @return void
	 */
	public function setCanton(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $canton) {
        $canton->rewind();
        $firstCanton = $canton->current();
        
        if(empty($firstCanton)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $cantonToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['canton'] ?? null;
            
            if(!empty($cantonToAttach)) {
                $cantonToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\FicheRepository::class)->findByUid($cantonToAttach);
                $canton->attach($cantonToAttachObj);
            }
        }
		$this->canton = $canton;
	}

	/**
	 * Returns the commission
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Commission> $commission
	 */
	public function getCommission() {
		return $this->commission;
	}

	/**
	 * Returns the commission
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Commission $commission
	 */
	public function getFirstCommission(){
        $commission = $this->getCommission();
        if (!is_null($commission)) {
			$commission->rewind();
			return $commission->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the commission
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Commission> $commission
	 * @return void
	 */
	public function setCommission(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $commission) {
        $commission->rewind();
        $firstCommission = $commission->current();
        
        if(empty($firstCommission)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $commissionToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['commission'] ?? null;
            
            if(!empty($commissionToAttach)) {
                $commissionToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\CommissionRepository::class)->findByUid($commissionToAttach);
                $commission->attach($commissionToAttachObj);
            }
        }
		$this->commission = $commission;
	}

	/**
	 * Returns the actions
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Actions> $actions
	 */
	public function getActions() {
		return $this->actions;
	}

	/**
	 * Returns the commission
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Actions $actions
	 */
	public function getFirstActions(){
        $actions = $this->getActions();
        if (!is_null($actions)) {
			$actions->rewind();
			return $actions->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the actions
	 *
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Actions> $actions
	 * @return void
	 */
	public function setActions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $actions) {
        $actions->rewind();
        $firstAction = $actions->current();
        
        if(empty($firstAction)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $actionToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['actions'] ?? null;
            
            if(!empty($actionToAttach)) {
                $actionToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\ActionsRepository::class)->findByUid($actionToAttach);
                $actions->attach($actionToAttachObj);
            }
        }
        
        $this->actions = $actions;
	}

	/**
	 * Returns the production
	 *
	 * @return string $production
	 */
	public function getProduction() {
		return $this->production;
	}

	/**
	 * Sets the production
	 *
	 * @param string $production
	 * @return void
	 */
	public function setProduction($production) {
		$this->production = $production;
	}

	/**
	 * Returns the ouvert
	 *
	 * @return int $ouvert
	 */
	public function getOuvert() {
		return $this->ouvert;
	}

	/**
	 * Sets the ouvert
	 *
	 * @param int $ouvert
	 * @return void
	 */
	public function setOuvert($ouvert) {
		$this->ouvert = $ouvert;
	}

	/**
	 * Returns the ouvertComment
	 *
	 * @return string $ouvertComment
	 */
	public function getOuvertComment() {
		return $this->ouvertComment;
	}

	/**
	 * Sets the ouvertComment
	 *
	 * @param string $ouvertComment
	 * @return void
	 */
	public function setOuvertComment($ouvertComment) {
		$this->ouvertComment = $ouvertComment;
	}

	/**
	 * Returns the ouvertcommentSorted
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Commission> $ouvertcommentSorted
	 */
	public function getCommissionSorted() {
		$ficheRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\FicheRepository::class);
		$query = $ficheRepository->createQuery();

		// create sql statement
		$sql = 'select commission';
		$sql .= ' from tx_eannuaires_domain_model_fiche';
		$sql .= ' where uid = ' . intval($this->getUid());
		$sql .= ' limit 1';

		$result = $query->statement($sql)->execute(TRUE);

		$listOrdered = $result[0]['commission'];
		if($listOrdered != '' AND $listOrdered != NULL)
		{

			// if elementbrowser instead of IRRE (sorting workarround)
			$commissionArrayUnsort = $this->commission->toArray();
			$formSorting = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $listOrdered, TRUE);
			$formSorting = array_flip($formSorting);
			$ouvertcommentArray = array();
			foreach ($commissionArrayUnsort as $commission) {
				$commissionArray[$formSorting[$commission->getUid()]] = $commission;
			}
			ksort($commissionArray);
			return $commissionArray;
		}
	}


	/**
	 * Returns the beneficiaire
	 *
	 * @return string $beneficiaire
	 */
	public function getBeneficiaire() {
		return $this->beneficiaire;
	}

	/**
	 * Sets the beneficiaire
	 *
	 * @param string $beneficiaire
	 * @return void
	 */
	public function setBeneficiaire($beneficiaire) {
		$this->beneficiaire = $beneficiaire;
	}

	/**
	 * Returns the enjeux
	 *
	 * @return string $enjeux
	 */
	public function getEnjeux() {
		return $this->enjeux;
	}

	/**
	 * Sets the enjeux
	 *
	 * @param string $enjeux
	 * @return void
	 */
	public function setEnjeux($enjeux) {
		$this->enjeux= $enjeux;
	}

	/**
	 * Returns the objet
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Objet> $objet
	 */
	public function getObjet() {
		return $this->objet;
	}

	/**
	 * Returns the commission
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Objet $objet
	 */
	public function getFirstObjet(){
        $objet = $this->getObjet();
        if (!is_null($objet)) {
			$objet->rewind();
			return $objet->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the objet
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Objet> $objet
	 * @return void
	 */
	public function setObjet(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $objet) {
        $objet->rewind();
        $firstObjet = $objet->current();
        
        if(empty($firstObjet)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $objetToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['objet'] ?? null;
            
            if(!empty($objetToAttach)) {
                $objetToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\ObjetRepository::class)->findByUid($objetToAttach);
                $objet->attach($objetToAttachObj);
            }
        }
		$this->objet = $objet;
	}

	/**
	 * Returns the uploadimage
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Image> $uploadimage
	 */
	public function getUploadimage() {
		return $this->uploadimage;
	}

	/**
	 * Returns the commission
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Image $uploadimage
	 */
	public function getFirstUploadimage(){
        $uploadimage = $this->getUploadimage();
        if (!is_null($uploadimage)) {
			$uploadimage->rewind();
			return $uploadimage->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the uploadimage
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Image> $uploadimage
	 * @return void
	 */
	public function setUploadimage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $uploadimage) {
		$this->uploadimage = $uploadimage;
	}

	/**
	 * Returns the contacts
	 *
	 * @return string $contacts
	 */
	public function getContacts() {
		return $this->contacts;
	}

	/**
	 * Sets the contacts
	 *
	 * @param string $contacts
	 * @return void
	 */
	public function setContacts($contacts) {
		$this->contacts = $contacts;
	}

	/**
	 * Returns the linkcontact
	 *
	 * @return int $linkcontact
	 */
	public function getLinkcontact() {
		return $this->linkcontact;
	}

	/**
	 * Sets the linkcontact
	 *
	 * @param int $linkcontact
	 * @return void
	 */
	public function setLinkcontact($linkcontact) {
		$this->linkcontact = $linkcontact;
	}

	/**
	 * Returns the hebergementtemp
	 *
	 * @return int $hebergementtemp
	 */
	public function getHebergementtemp() {
		return $this->hebergementtemp;
	}

	/**
	 * Sets the hebergementtemp
	 *
	 * @param int $hebergementtemp
	 * @return void
	 */
	public function setHebergementtemp($hebergementtemp) {
		$this->hebergementtemp = $hebergementtemp;
	}

	/**
	 * Returns the accueiljour
	 *
	 * @return int $accueiljour
	 */
	public function getAccueiljour() {
		return $this->accueiljour;
	}

	/**
	 * Sets the accueiljour
	 *
	 * @param int $accueiljour
	 * @return void
	 */
	public function setAccueiljour($accueiljour) {
		$this->accueiljour = $accueiljour;
	}

	/**
	 * Returns the datefiche
	 *
	 * @return string $datefiche
	 */
	public function getDatefiche() {
		if(intval($this->datefiche) == '0' ){
			return $this->datefiche;
		} else {
			return strftime('%d-%m-%Y',$this->datefiche);
		}
	}

	/**
	 * Sets the datefiche
	 *
	 * @param string $datefiche
	 * @return void
	 */
	public function setDatefiche($datefiche) {
		if(!is_numeric($datefiche)){
			$this->datefiche = (strtotime($datefiche) === FALSE) ? time() : strtotime($datefiche);
		} else {
			$this->datefiche = $datefiche;
		}
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
	 * Returns the tstamp
	 *
	 * @return string $tstamp
	 */
	public function getTstamp() {
		if(intval($this->tstamp) == '0' ){
			return $this->tstamp;
		} else {
			return strftime('%d-%m-%Y',$this->tstamp);
		}
	}

	/**
	 * Sets the tstamp
	 *
	 * @param string $tstamp
	 * @return void
	 */
	public function setTstamp($tstamp) {
		if(!is_numeric($tstamp)){
			$this->tstamp = (strtotime($tstamp) === FALSE) ? time() : strtotime($tstamp);
		} else {
			$this->tstamp = $tstamp;
		}
	}

	/**
	 * Returns the crdate
	 *
	 * @return string $crdate
	 */
	public function getCrdate() {
        return $this->crdate;
	}

	/**
	 * Sets the crdate
	 *
	 * @param string $crdate
	 * @return void
	 */
	public function setCrdate($crdate) {
        $this->crdate = $crdate;
	}

	/**
	 * Returns the hidden
	 *
	 * @return string $hidden
	 */
	public function getHidden() {
        return $this->hidden;
	}

	/**
	 * Sets the hidden
	 *
	 * @param string $hidden
	 * @return void
	 */
	public function setHidden($hidden) {
        $this->hidden = $hidden;
	}

	/**
	 * Returns the uniteterritoriale
	 *
	 * @return string $uniteterritoriale
	 */
	public function getUniteterritoriale() {
		return $this->uniteterritoriale;
	}

	/**
	 * Sets the uniteterritoriale
	 *
	 * @param string $uniteterritoriale
	 * @return void
	 */
	public function setUniteterritoriale($uniteterritoriale) {
		$this->uniteterritoriale = $uniteterritoriale;
	}

	/**
	 * Returns the cantonsTexte
	 *
	 * @return string $cantonsTexte
	 */
	public function getCantonstexte() {
		return $this->cantonstexte;
	}

	/**
	 * Sets the cantonsTexte
	 *
	 * @param string $cantonstexte
	 * @return void
	 */
	public function setCantonstexte($cantonstexte) {
		$this->cantonstexte = $cantonstexte;
	}

	/**
	 * Returns the intercommunalite
	 *
	 * @return string $intercommunalite
	 */
	public function getIntercommunalite() {
		return $this->intercommunalite;
	}

	/**
	 * Sets the intercommunalite
	 *
	 * @param string $intercommunalite
	 * @return void
	 */
	public function setIntercommunalite($intercommunalite) {
		$this->intercommunalite = $intercommunalite;
	}

	/**
	 * Returns the typeepci
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche> $typeepci
	 */
	public function getTypeepci() {
		return $this->typeepci;
	}

	/**
	 * Returns the typeepci
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Fiche $typeepci
	 */
	public function getFirstTypeepci(){
        $typeepci = $this->getTypeepci();
        if (!is_null($typeepci)) {
			$typeepci->rewind();
			return $typeepci->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the typeepci
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche> $typeepci
	 * @return void
	 */
	public function setTypeepci($typeepci) {
		$this->typeepci = $typeepci;
	}

	/**
	 * Returns the mandats
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Mandat> $mandats
	 */
	public function getMandats() {
		return $this->mandats;
	}

	/**
	 * Returns the mandats
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Mandat $mandats
	 */
	public function getFirstMandats(){
        $mandats = $this->getMandats();
        if (!is_null($mandats)) {
			$mandats->rewind();
			return $mandats->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the mandats
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Mandat> $mandats
	 * @return void
	 */
	public function setMandats($mandats) {
		$this->mandats = $mandats;
	}

	/**
	 * Returns the mandatsSorted
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Mandat> $mandatsSorted
	 */
	public function getMandatsSorted() {
		$ficheRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\FicheRepository::class);
		$query = $ficheRepository->createQuery();

		// create sql statement
		$sql = 'select mandats';
		$sql .= ' from tx_eannuaires_domain_model_fiche';
		$sql .= ' where uid = ' . intval($this->getUid());
		$sql .= ' limit 1';

		$result = $query->statement($sql)->execute(TRUE);

		$listOrdered = $result[0]['mandats'];

		// if elementbrowser instead of IRRE (sorting workarround)
		$mandatsArrayUnsort = $this->mandats->toArray();
		$formSorting = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $listOrdered, TRUE);
		$formSorting = array_flip($formSorting);
		$mandatsArray = array();
		foreach ($mandatsArrayUnsort as $mandats) {
			$mandatsArray[$formSorting[$mandats->getUid()]] = $mandats;
		}
		ksort($mandatsArray);
		return $mandatsArray;
	}

	/**
	 * Returns the typehandicap
	 *
	 * @return string $typehandicap
	 */
	public function getTypehandicap() {
		return $this->typehandicap;
	}

	/**
	 * Sets the typehandicap
	 *
	 * @param string $typehandicap
	 * @return void
	 */
	public function setTypehandicap($typehandicap) {
		$this->typehandicap = $typehandicap;
	}

	/**
	 * Returns the contrat
	 *
	 * @return string $contrat
	 */
	public function getContrat() {
		return $this->contrat;
	}

	/**
	 * Sets the contrat
	 *
	 * @param string $contrat
	 * @return void
	 */
	public function setContrat($contrat) {
		$this->contrat = $contrat;
	}

	/**
	 * Returns the population
	 *
	 * @return string $population
	 */
	public function getPopulation() {
		return $this->population;
	}

	/**
	 * Sets the population
	 *
	 * @param string $population
	 * @return void
	 */
	public function setPopulation($population) {
		$this->population = $population;
	}

	/**
	 * Returns the mds
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche> $mds
	 */
	public function getMds() {
		return $this->mds;
	}

	/**
	 * Returns the mds
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Fiche $mds
	 */
	public function getFirstMds(){
        $mds = $this->getMds();
        if (!is_null($mds)) {
			$mds->rewind();
			return $mds->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the mds
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche> $mds
	 * @return void
	 */
	public function setMds($mds) {
		$this->mds = $mds;
	}

	/**
	 * Returns the cdps
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche> $cdps
	 */
	public function getCdps() {
		return $this->cdps;
	}

	/**
	 * Returns the mds
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Fiche $cdps
	 */
	public function getFirstCdps(){
        $cdps = $this->getCdps();
        if (!is_null($cdps)) {
			$cdps->rewind();
			return $cdps->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the cdps
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche> $cdps
	 * @return void
	 */
	public function setCdps($cdps) {
		$this->cdps = $cdps;
	}

	/**
	 * Returns the pack
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Pack> $pack
	 */
	public function getPack() {
		return $this->pack;
	}

	/**
	 * Returns the mds
	 *
	 * @return \Emagineurs\EAnnuaires\Domain\Model\Pack $pack
	 */
	public function getFirstPack(){
        $pack = $this->getPack();
        if (!is_null($pack)) {
			$pack->rewind();
			return $pack->current();
        } else {
            return null;
        }
	}

	/**
	 * Sets the pack
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Pack> $pack
	 * @return void
	 */
	public function setPack($pack) {
		$pack->rewind();
        $firstPack = $pack->current();
        
        if(empty($firstPack)){
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            $parsedBody = $request ? $request->getParsedBody() : [];
            $packToAttach = $parsedBody['tx_eannuaires_pi1']['fiche']['pack'] ?? null;
            
            if(!empty($packToAttach)) {
                $packToAttachObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\PackRepository::class)->findByUid($packToAttach);
                $pack->attach($packToAttachObj);
             }
        }
        $this->pack = $pack;
	}

	/**
	 * Returns the partipolitique
	 *
	 * @return string $partipolitique
	 */
	public function getPartipolitique() {
		return $this->partipolitique;
	}

	/**
	 * Sets the partipolitique
	 *
	 * @param string $partipolitique
	 * @return void
	 */
	public function setPartipolitique($partipolitique) {
		$this->partipolitique = $partipolitique;
	}

	/**
	 * Returns the latsecondaire
	 *
	 * @return string $latsecondaire
	 */
	public function getLatsecondaire() {
		return $this->latsecondaire;
	}

	/**
	 * Sets the latsecondaire
	 *
	 * @param string $latsecondaire
	 * @return void
	 */
	public function setLatsecondaire($latsecondaire) {
		$this->latsecondaire = $latsecondaire;
	}

	/**
	 * Returns the lngsecondaire
	 *
	 * @return string $lngsecondaire
	 */
	public function getLngsecondaire() {
		return $this->lngsecondaire;
	}

	/**
	 * Sets the lngsecondaire
	 *
	 * @param string $lngsecondaire
	 * @return void
	 */
	public function setLngsecondaire($lngsecondaire) {
		$this->lngsecondaire = $lngsecondaire;
	}

	/**
	 * Returns the deleted
	 *
	 * @return string $deleted
	 */
	public function getDeleted() {
		return $this->deleted;
	}    
}
?>