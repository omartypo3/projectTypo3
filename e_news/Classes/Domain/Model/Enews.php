<?php
namespace Emagineurs\ENews\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Xavier Ley <xley@e-maginuers.com>, e-magineurs
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

use Emagineurs\ENews\Utility\FileUtility;
use GeorgRinger\News\Domain\Model\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Enews
 * 

 */
class Enews extends \GeorgRinger\News\Domain\Model\News {

	
	/**
	 * placename
	 *
	 * @var string
	 */
	protected $placename = '';

	/**
	 * placeadress
	 *
	 * @var string
	 */
	protected $placeadress = '';
	/**
	 * eventphone
	 *
	 * @var string
	 */
	protected $eventphone = '';

	/**
	 * eventmail
	 *
	 * @var string
	 */
	protected $eventmail = '';

	/**
	 * eventpicture
	 *
	 * @var string
	 */
	protected $eventpicture = '';

	/**
	 * zipcode
	 *
	 * @var string
	 */
	protected $zipcode = '';

	/**
	 * isEvent
	 *
	 * @var boolean
	 */
	protected $isEvent = false;

	/**
	 * feuser
	 *
	 * @var \In2code\Femanager\Domain\Model\User
	 */
	protected $feuser = null;

	/**
	 * User validation
	 *
	 * @var int
	 */
	protected $uservalidation = 1;

    /**
     * Admin validation token
     *
     * @var string
     */
    protected $uservalidationtoken = "";

    /**
     * Admin validation
     *
     * @var int
     */
    protected $adminvalidation = 1;

    /**
     * User validation token
     *
     * @var string
     */
    protected $adminvalidationtoken = "";

	/**
	 * begindate
	 *
	 * @var string
	 */
	protected $begindate = null;

	/**
	 * finishdate
	 *
	 * @var string
	 */
	protected $finishdate = null;

	/**
	 * beginschedule
	 *
	 * @var string
	 */
	protected $beginschedule ='';

	/**
	 * finishschedule
	 *
	 * @var string
	 */
	protected $finishschedule = '';

	/**
	 * schedules
	 *
	 * @var string
	 */
	protected $schedules = '';

	/**
	 * rightpicture
	 *
	 * @var int
	 */
	protected $rightpicture = 0;

	/**
	 * liens
	 *
	 * @var string
	 */
	protected $linklist = '';

	/**
	 * numberpage
	 *
	 * @var integer
	 */
	protected $numberpage = 0;

	/**
	 * price
	 *
	 * @var float
	 */
	protected $price = 0.0;

	/**
	 * iframe
	 *
	 * @var string
	 */
	protected $iframe = '';

	/**
	 * iframetitle
	 *
	 * @var string
	 */
	protected $iframetitle = '';

	/**
	 * dateEdition
	 *
	 * @var \DateTime
	 */
	protected $dateEdition = null;

	/**
	 * authorpublication
	 *
	 * @var string
	 */
	protected $authorpublication = '';

	/**
	 * typeDocument
	 *
	 * @var string
	 */
	protected $typeDocument = '';

	/**
	 * calameoPlugin
	 *
	 * @var string
	 */
	protected $calameoPlugin = '';

	/**
	 * calameoHtml
	 *
	 * @var string
	 */
	protected $calameoHtml = '';

	/**
	 * bloctexte
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Bloctexte>
	 */
	protected $bloctexte = null;

	/**
	 * town
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\ENews\Domain\Model\Commune>
	 */
	protected $town = null;

	/**
	 * commandable
	 *
	 * @var integer
	 */
	protected $commandable = 0;

	/**
	 * relatedAnnuaire
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche>
	 */
	protected $relatedAnnuaire = null;

	/**
	 * relatedProject
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\ENews\Domain\Model\Enews>
	 */
	protected $relatedProject = null;

	/**
	 * relatedTools
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\ENews\Domain\Model\Enews>
	 */
	protected $relatedTools = null;

	/**
	 * related_subject
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\ENews\Domain\Model\Enews>
	 */
	protected $relatedSubject = null;

	/**
	 * related_subject
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\ENews\Domain\Model\Enews>
	 */
	protected $relatedProjectNews = null;

	/**
	 * related_pages
	 *
	 * @var string
	 */
	protected $relatedPages = null;

	/**
	 * countview
	 *
	 * @var integer
	 */
	protected $countview = null;

	

	/**
	 * dates
	 *
	 * @var  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\ENews\Domain\Model\Dates>
	 */
	#[Lazy]
	protected $dates;

	/**
	 * currentdate
	 *
	 * @var  string
	 */
	protected $currentdate;

	/**
	 * toptitle
	 *
	 * @var  string
	 */
	protected $toptitle;

	/**
	 * topteaser
	 *
	 * @var  string
	 */
	protected $topteaser;

	/**
	 * Youngaudience
	 *
	 * @var boolean
	 */
	protected $youngaudience = false;

	/**
	 * freeentrance
	 *
	 * @var boolean
	 */
	protected $freeentrance = false;

	/**
     * @var int
     */
    protected $dialognumber;
    /**
     * @var int
     */
    protected $dialogsubnumber;

    /**
     * @var int
     */
    protected $asknews;
    /**
     * @var int
     */
    protected $askcompany;


    /**
     * @var string
     */
    protected $contenttitle1;

    /**
     * @var string
     */
    protected $contenttext1;


    /**
     * @var string
     */
    protected $contenttitle2;
    /**
     * @var string
     */
    protected $contenttext2;

    /**
     * @var string
     */
    protected $contenttitle3;
    /**
     * @var string
     */
    protected $contenttext3;

    /**
     * @var string
     */
    protected $contenttitle4;
    /**
     * @var string
     */
    protected $contenttext4;

    /**
     * @var string
     */
    protected $contenttitle5;
    /**
     * @var string
     */
    protected $contenttext5;

	/**
	 * parent_pid
	 *
	 * @var integer
	 */
	protected $parentPid = null;

    /**
     * relatedfileinstancier > will allow to set the media from $_FILES
     *
     * @var array
     */
    protected $relatedfileinstancier;

	/**
	 * __construct
	 */
	public function __construct() {
	    parent::__construct();
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
	protected function initStorageObjects() {
		$this->bloctexte = new ObjectStorage();
		$this->town = new ObjectStorage();
		$this->relatedAnnuaire = new ObjectStorage();
		$this->relatedProject = new ObjectStorage();
		$this->relatedTools = new ObjectStorage();
		$this->relatedSubject = new ObjectStorage();
		$this->relatedProjectNews = new ObjectStorage();
	}

   

	/**
	 * Returns the placename
	 *
	 * @return string $placename
	 */
	public function getPlacename() {
		return $this->placename;
	}

	/**
	 * Sets the placename
	 *
	 * @param string $placename
	 * @return void
	 */
	public function setPlacename($placename) {
		$this->placename = $placename;
	}

	/**
	 * Returns the placeadress
	 *
	 * @return string $placeadress
	 */
	public function getPlaceadress() {
		return $this->placeadress;
	}

	/**
	 * Sets the placeadress
	 *
	 * @param string $placeadress
	 * @return void
	 */
	public function setPlaceadress($placeadress) {
		$this->placeadress = $placeadress;
	}

	/**
	 * Returns the begindate
	 *
	 * @return string $begindate
	 */
	public function getBegindate() {
		return $this->begindate;
	}

	/**
	 * Sets the begindate
	 *
	 * @param string $begindate
	 * @return void
	 */
	public function setBegindate($begindate) {
		if (is_string($begindate)) {
			$date = \DateTime::createFromFormat('d/m/Y', $begindate);
			$this->begindate = $date ?: new \DateTime($begindate);
		} else if ($begindate instanceof \DateTime) {
			$this->begindate = $begindate;
		}
}

	/**
	 * Returns the finishdate
	 *
	 * @return string $finishdate
	 */
	public function getFinishdate() {
		return $this->finishdate;
	}

	/**
	 * Sets the finishdate
	 *
	 * @param string $finishdate
	 * @return void
	 */
	public function setFinishdate($finishdate) {
        if(!empty($finishdate) AND !ctype_digit($finishdate)) {
            $this->finishdate = \DateTime::createFromFormat("d/m/Y", $finishdate);
            if($this->finishdate) {
                $this->finishdate = $this->finishdate->getTimestamp();
            } else {
                $this->finishdate = strtotime($finishdate);
            }
        }
	}

	/**
	 * Returns the linklist
	 *
	 * @return string $linklist
	 */
	public function getLinklist() {
		return $this->linklist;
	}

	/**
	 * Sets the linklist
	 *
	 * @param string $linklist
	 * @return void
	 */
	public function setLinklist($linklist) {
		$this->linklist = $linklist;
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
	 * Sets the string
	 *
	 * @param integer $string
	 * @return void
	 */
	public function setZipcode($zipcode) {
		$this->zipcode = $zipcode;
	}

	/**
	 * Returns the isEvent
	 *
	 * @return boolean $isEvent
	 */
	public function getIsEvent() {
		return $this->isEvent;
	}

	/**
	 * Sets the isEvent
	 *
	 * @param boolean $isEvent
	 * @return void
	 */
	public function setIsEvent($isEvent) {
		$this->isEvent = $isEvent;
	}

    /**
     * @return \In2code\Femanager\Domain\Model\User

     */
    public function getFeuser()
    {
        return $this->feuser;
    }

    /**
     * @param \In2code\Femanager\Domain\Model\User $feuser
     */
    public function setFeuser($feuser)
    {
        $this->feuser = $feuser;
    }

    /**
     * @return int
     */
    public function getUservalidation()
    {
        return $this->uservalidation;
    }

    /**
     * @param int $uservalidation
     */
    public function setUservalidation($uservalidation)
    {
        $this->uservalidation = $uservalidation;
    }

    /**
     * @return string
     */
    public function getUservalidationtoken()
    {
        return $this->uservalidationtoken;
    }

    /**
     * @param string $uservalidationtoken
     */
    public function setUservalidationtoken($uservalidationtoken)
    {
        $this->uservalidationtoken = $uservalidationtoken;
    }

    /**
     * @return int
     */
    public function getAdminvalidation()
    {
        return $this->adminvalidation;
    }

    /**
     * @param int $adminvalidation
     */
    public function setAdminvalidation($adminvalidation)
    {
        $this->adminvalidation = $adminvalidation;
    }

    /**
     * @return string
     */
    public function getAdminvalidationtoken()
    {
        return $this->adminvalidationtoken;
    }

    /**
     * @param string $adminvalidationtoken
     */
    public function setAdminvalidationtoken($adminvalidationtoken)
    {
        $this->adminvalidationtoken = $adminvalidationtoken;
    }

	/**
	 * Returns the beginschedule
	 *
	 * @return integer $beginschedule
	 */
	public function getBeginschedule() {
		return $this->beginschedule;
	}

	/**
	 * Sets the beginschedule
	 *
	 * @param integer $beginschedule
	 * @return void
	 */
	public function setBeginschedule($beginschedule) {
		$this->beginschedule = $beginschedule;
	}

	/**
	 * Returns the finishschedule
	 *
	 * @return integer $finishschedule
	 */
	public function getFinishschedule() {
		return $this->finishschedule;
	}

	/**
	 * Sets the finishschedule
	 *
	 * @param integer $finishschedule
	 * @return void
	 */
	public function setFinishschedule($finishschedule) {
		$this->finishschedule = $finishschedule;
	}

	/**
	 * Returns the rightpicture
	 *
	 * @return integer $rightpicture
	 */
	public function getRightpicture() {
		return $this->rightpicture;
	}

	/**
	 * Sets the rightpicture
	 *
	 * @param integer $rightpicture
	 * @return void
	 */
	public function setRightpicture($rightpicture) {
		$this->rightpicture = $rightpicture;
	}

	/**
	 * Returns the schedules
	 *
	 * @return string $schedules
	 */
	public function getSchedules() {
		return $this->schedules;
	}

	/**
	 * Sets the schedules
	 *
	 * @param string $schedules
	 * @return void
	 */
	public function setSchedules($schedules) {
		$this->schedules = $schedules;
	}

	/**
	 * Returns the eventphone
	 *
	 * @return string $eventphone
	 */
	public function getEventphone() {
		return $this->eventphone;
	}

	/**
	 * Sets the eventphone
	 *
	 * @param string $eventphone
	 * @return void
	 */
	public function setEventphone($eventphone) {
		$this->eventphone = $eventphone;
	}


	/**
	 * Returns the eventmail
	 *
	 * @return string $eventmail
	 */
	public function getEventmail() {
		return $this->eventmail;
	}

	/**
	 * Sets the eventmail
	 *
	 * @param string $eventmail
	 * @return void
	 */
	public function setEventmail($eventmail) {
		$this->eventmail = $eventmail;
	}

	/**
	 * Returns the town
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\ENews\Domain\Model\Commune> $town
	 */
	public function getTown() {
		return $this->town;
	}

	/**
	 * Sets the town
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\ENews\Domain\Model\Commune> $town
	 * @return void
	 */
	public function setTown(ObjectStorage $town) {
		$this->town = $town;
	}

	/**
	 * Returns the numberpage
	 *
	 * @return integer $numberpage
	 */
	public function getNumberPage() {
		return $this->numberpage;
	}

	/**
	 * Sets the numberpage
	 *
	 * @param integer $numberpage
	 * @return void
	 */
	public function setnumberpage($numberpage) {
		$this->numberpage = $numberpage;
	}

	/**
	 * Returns the price
	 *
	 * @return float $price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * Sets the price
	 *
	 * @param float $price
	 * @return void
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	 * Returns the iframe
	 *
	 * @return string $iframe
	 */
	public function getIframe() {
		return $this->iframe;
	}

	/**
	 * Sets the iframe
	 *
	 * @param string $iframe
	 * @return void
	 */
	public function setIframe($iframe) {
		$this->iframe = $iframe;
	}

	/**
	 * Returns the iframetitle
	 *
	 * @return string $iframetitle
	 */
	public function getIframetitle() {
		return $this->iframetitle;
	}

	/**
	 * Sets the iframetitle
	 *
	 * @param string $iframetitle
	 * @return void
	 */
	public function setIframetitle($iframetitle) {
		$this->iframetitle = $iframetitle;
	}

	/**
	 * Returns the dateEdition
	 *
	 * @return \DateTime $dateEdition
	 */
	public function getDateEdition() {
		return $this->dateEdition;
	}

	/**
	 * Sets the dateEdition
	 *
	 * @param \DateTime $dateEdition
	 * @return void
	 */
	public function setDateEdition(\DateTime $dateEdition) {
		$this->dateEdition = $dateEdition;
	}

	/**
	 * Returns the authorpublication
	 *
	 * @return string $authorpublication
	 */
	public function getAuthorpublication() {
		return $this->authorpublication;
	}

	/**
	 * Sets the authorpublication
	 *
	 * @param string $authorpublication
	 * @return void
	 */
	public function setAuthorpublication($authorpublication) {
		$this->authorpublication = $authorpublication;
	}

	/**
	 * Returns the typeDocument
	 *
	 * @return string $typeDocument
	 */
	public function getTypeDocument() {
		return $this->typeDocument;
	}

	/**
	 * Sets the typeDocument
	 *
	 * @param string $typeDocument
	 * @return void
	 */
	public function setTypeDocument($typeDocument) {
		$this->typeDocument = $typeDocument;
	}

	/**
	 * Returns the calameoPlugin
	 *
	 * @return string $calameoPlugin
	 */
	public function getCalameoPlugin() {
		return $this->calameoPlugin;
	}

	/**
	 * Sets the calameoPlugin
	 *
	 * @param string $calameoPlugin
	 * @return void
	 */
	public function setCalameoPlugin($calameoPlugin) {
		$this->calameoPlugin = $calameoPlugin;
	}

	/**
	 * Returns the calameoHtml
	 *
	 * @return string $calameoHtml
	 */
	public function getCalameoHtml() {
		return $this->calameoHtml;
	}

	/**
	 * Sets the calameoHtml
	 *
	 * @param string $calameoHtml
	 * @return void
	 */
	public function setCalameoHtml($calameoHtml) {
		$this->calameoHtml = $calameoHtml;
	}

	/**
	 * Returns the bloctexte
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Bloctexte> $bloctexte
	 */
	public function getBloctexte() {
		return $this->bloctexte;
	}

	/**
	 * Sets the bloctexte
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Bloctexte $bloctexte>
	 * @return void
	 */
	public function setBloctexte(ObjectStorage $bloctexte) {
		$this->bloctexte = $bloctexte;
	}

	/**
	 * Returns the commandable
	 *
	 * @return integer $commandable
	 */
	public function getCommandable() {
		return $this->commandable;
	}

	/**
	 * Sets the commandable
	 *
	 * @param integer $commandable
	 * @return void
	 */
	public function setCommandable($commandable) {
		$this->commandable = $commandable;
	}

	/**
	 * Returns the relatedAnnuaire
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche> $relatedAnnuaire
	 */
	public function getRelatedAnnuaire() {
		return $this->relatedAnnuaire;
	}

	/**
	 * Sets the relatedAnnuaire
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EAnnuaires\Domain\Model\Fiche> $relatedAnnuaire
	 * @return void
	 */
	public function setRelatedAnnuaire(ObjectStorage $relatedAnnuaire) {
		$this->relatedAnnuaire = $relatedAnnuaire;
	}

	/**
	 * Returns the relatedProject
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Emagineurs\ENews\Domain\Model\Enews> $relatedProject
	 */
	public function getRelatedProject() {
		return $this->relatedProject;
	}

	/**
	 * Sets the relatedProject
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Emagineurs\ENews\Domain\Model\Enews> $relatedProject
	 * @return void
	 */
	public function setRelatedProject(ObjectStorage $relatedProject) {
		$this->relatedProject = $relatedProject;
	}

	/**
	 * Returns the relatedTools
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Emagineurs\ENews\Domain\Model\Enews> $relatedTools
	 */
	public function getRelatedTools() {
		return $this->relatedTools;
	}

	/**
	 * Sets the relatedTools
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Emagineurs\ENews\Domain\Model\Enews> $relatedTools
	 * @return void
	 */
	public function setRelatedTools(ObjectStorage $relatedTools) {
		$this->relatedTools = $relatedTools;
	}

	/**
	 * Returns the relatedSubject
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Emagineurs\ENews\Domain\Model\Enews> $relatedSubject
	 */
	public function getRelatedSubject() {
		return $this->relatedSubject;
	}

	/**
	 * Sets the relatedTools
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Emagineurs\ENews\Domain\Model\Enews> $relatedSubject
	 * @return void
	 */
	public function setRelatedSubject(ObjectStorage $relatedSubject) {
		$this->relatedSubject = $relatedSubject;
	}

	/**
	 * Returns the relatedPages
	 *
	 * @return string $relatedPages
	 */
	public function getRelatedPages() {
		return $this->relatedPages;
	}

	/**
	 * Sets the relatedPages
	 *
	 * @param string $relatedPages
	 * @return void
	 */
	public function setRelatedPages($relatedPages) {
		$this->relatedPages = $relatedPages;
	}

	/**
	 * Returns the relatedPages as an array of page IDs
	 *
	 * @return array $relatedPages
	 */
	public function getRelatedPagesArray() {
		return explode(',',$this->relatedPages);
	}

	/**
	* Returns the relatedProjectNews
	*
	* @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Emagineurs\ENews\Domain\Model\Enews> $relatedProjectNews
	*/
	public function getRelatedProjectNews() {
		return $this->relatedProjectNews;
	}

	/**
	* Sets the relatedProjectNews
	*
	* @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Emagineurs\ENews\Domain\Model\Enews> $relatedProjectNews
	* @return void
	*/
	public function setRelatedProjectNews(ObjectStorage $relatedProjectNews) {
		$this->relatedProjectNews = $relatedProjectNews;
	}

    /**
     * Get Dates
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Dates> $dates
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * Set dates
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Dates> $dates
     * @return void
     */
    public function setDates($dates)
    {
        $this->dates = $dates;
    }

	/**
	* Returns the currentdate
	*
	* @return string $currentdate
	*/
	public function getCurrentdate() {
		return $this->currentdate;
	}

	/**
	* Sets the currentdate
	*
	* @param string $currentdate
	* @return void
	*/
	public function setCurrentdate($currentdate) {
		$this->currentdate = $currentdate;
	}

	/**
	* Returns the toptitle
	*
	* @return string $toptitle
	*/
	public function getToptitle() {
		return $this->toptitle;
	}

	/**
	* Sets the toptitle
	*
	* @param string $toptitle
	* @return void
	*/
	public function setToptitle($toptitle) {
		$this->toptitle = $toptitle;
	}

	/**
	* Returns the topteaser
	*
	* @return string $topteaser
	*/
	public function getTopteaser() {
		return $this->topteaser;
	}

	/**
	* Sets the topteaser
	*
	* @param string $topteaser
	* @return void
	*/
	public function setTopteaser($topteaser) {
		$this->topteaser = $topteaser;
	}

	/**
	* Returns the countview
	*
	* @return integer $countview
	*/
	public function getCountview() {
		return $this->countview;
	}

	/**
	* Sets the countview
	*
	* @param integer $countview
	* @return void
	*/
	public function setCountview($countview) {
		$this->countview = $countview;
	}

	/**
	* Returns the parentPid
	*
	* @return integer $parentPid
	*/
	public function getParentPid() {
		return $this->parentPid;
	}

	/**
	* Sets the parentPid
	*
	* @param integer $parentPid
	* @return void
	*/
	public function setParentPid($parentPid) {
		$this->parentPid = $parentPid;
	}

	/**
	 * Condition pour la gestion des agenda, date debut, date de fin, VS news.
	 *
	 * @return boolean $isEvent
	 */
	public function getIsVisible(){
		if(!$this->getIsEvent())
			return true;

		$dateDebut = $this->getBegindate();
		$dateFin = $this->getFinishdate();
		$now = time();

		if($dateDebut && $dateDebut->getTimestamp() > $now)
			return false;

		if($dateFin && $dateFin->getTimestamp() < $now)
			return false;

		return true;
	}

	/**
	 * Returns the Freeentrance
	 *
	 * @return boolean $Freeentrance
	 */
	public function getFreeentrance() {
		return $this->freeentrance;
	}

	/**
	 * Sets the Freeentrance
	 *
	 * @param boolean $Freeentrance
	 * @return void
	 */
	public function setFreeentrance($freeentrance) {
		$this->freeentrance = $freeentrance;
	}

	/**
	 * Returns the boolean state of Freeentrance
	 *
	 * @return boolean
	 */
	public function isFreeentrance() {
		return $this->freeentrance;
	}


	/**
	 * Returns the isEvent
	 *
	 * @return boolean $isEvent
	 */
	public function getYoungaudience() {
		return $this->youngaudience;
	}

	/**
	 * Sets the isEvent
	 *
	 * @param boolean $isEvent
	 * @return void
	 */
	public function setYoungaudience($youngaudience) {
		$this->youngaudience = $youngaudience;
	}

	/**
	 * Returns the boolean state of isEvent
	 *
	 * @return boolean
	 */
	public function isYoungaudience() {
		return $this->youngaudience;
	}

	/**
     * Get top asknews flag
     *
     * @return int
     */
    public function getAsknews()
    {
        return $this->asknews;
    }

    /**
     * Set Sender
     *
     * @param int $donnees
     * @return void
     */
    public function setAsknews($asknews){
        $this->asknews = $asknews;
    }

     /**
     * Get top askcompany flag
     *
     * @return int
     */
    public function getAskcompany(){
        return $this->askcompany;
    }

    /**
     * Set Sender
     *
     * @param int $donnees
     * @return void
     */
    public function setAskcompany($askcompany){
        $this->askcompany = $askcompany;
    }


    /**
     * Get top dialognumber flag
     *
     * @return int
     */
    public function getDialognumber(){
        return $this->dialognumber;
    }

    /**
     * Set Sender
     *
     * @param int $donnees
     * @return void
     */
    public function setDialognumber($dialognumber){
        $this->dialognumber = $dialognumber;
    }

     /**
     * Get top askcompany flag
     *
     * @return int
     */
    public function getDialogsubnumber(){
        return $this->dialogsubnumber;
    }

    /**
     * Set Sender
     *
     * @param int $donnees
     * @return void
     */
    public function setDialogsubnumber($dialogsubnumber) {
        $this->dialogsubnumber = $dialogsubnumber;
    }

    /**
     * Get contenttitle1
     *
     * @return string
     */
    public function getContenttitle1(){
        return $this->contenttitle1;
    }
    /**
     * Set contenttitle1
     *
     * @param string $contenttitle1 main content
     */
    public function setContenttilte1($contenttitle1){
        $this->contenttitle1 = $contenttitle1;
    }


    /**
     * Get contenttitle2
     *
     * @return string
     */
    public function getContenttitle2(){
        return $this->contenttitle2;
    }
    /**
     * Set contenttitle2
     *
     * @param string $contenttitle2 main content
     */
    public function setContenttilte2($contenttitle2){
        $this->contenttitle2 = $contenttitle2;
    }


    /**
     * Get contenttitle3
     *
     * @return string
     */
    public function getContenttitle3(){
        return $this->contenttitle3;
    }
    /**
     * Set contenttitle3
     *
     * @param string $contenttitle3 main content
     */
    public function setContenttilte3($contenttitle3){
        $this->contenttitle3 = $contenttitle3;
    }


	/**
     * Get contenutitle4
     *
     * @return string
     */
    public function getContenttitle4(){
        return $this->contenttitle4;
    }
    /**
     * Set contenutitle4
     *
     * @param string $contenutitle4 main content
     */
	public function setContenttilte4($contenutitle4){
		$this->contenttitle4 = $contenutitle4;
    }

    /**
     * Get contenutitle5
     *
     * @return string
     */
    public function getContenttitle5(){
        return $this->contenttitle5;
    }
    /**
     * Set contenutitle5
     *
     * @param string $contenutitle5 main content
     */
    public function setContenttilte5($contenutitle5){
        $this->contenttitle5 = $contenutitle5;
    }


    /**
     * Get contenutitle5
     *
     * @return string
     */
    public function getContenttext1(){
        return $this->contenttext1;
    }
    /**
     * Set contenttext1
     *
     * @param string $contenttext1 main content
     */
    public function setContenttext1($contenttext1){
        $this->contenttext1 = $contenttext1;
    }

    /**
     * Get contenttext2
     *
     * @return string
     */
    public function getContenttext2(){
        return $this->contenttext2;
    }
    /**
     * Set contenttext2
     *
     * @param string $contenttext2 main content
     */
    public function setContenttext2($contenttext2){
        $this->contenttext2 = $contenttext2;
    }

    /**
     * Get contenttext3
     *
     * @return string
     */
    public function getContenttext3(){
        return $this->contenttext3;
    }
    /**
     * Set contenttext3
     *
     * @param string $contenttext3 main content
     */
    public function setContenttext3($contenttext3){
        $this->contenttext3 = $contenttext3;
    }

    /**
     * Get contenttext4
     *
     * @return string
     */
    public function getContenttext4(){
        return $this->contenttext4;
    }
    /**
     * Set contenttext4
     *
     * @param string $contenttext4 main content
     */
    public function setContenttext4($contenttext4){
        $this->contenttext4 = $contenttext4;
    }


    /**
     * Get contenutitle5
     *
     * @return string
     */
    public function getContenttext5(){
        return $this->contenttext5;
    }
    /**
     * Set contenutitle5
     *
     * @param string $contenutitle5 main content
     */
    public function setContenttext5($contenttext5){
        $this->contenttext5 = $contenttext5;
    }



    /**
     * Returns nothing > created because probably called if property mediainstancier used in a form
     *
     * @return void
     */
    public function getRelatedfileinstancier()
    {
        //empty
    }

    /**
     * Sets the media from $_FILES
     *
     * @param array $files
     * @return void
     */
    public function setRelatedfileinstancier($files) {
        foreach($files as $currentFile) {
            if(is_array($currentFile)){
                if (!empty($currentFile['name'])) {
                    $file = FileUtility::generateFile($currentFile);

                    /** @var Filereference $fileRef */
                    $fileRef = GeneralUtility::makeInstance(Filereference::class);

                    if(!empty($currentFile['additional']) AND is_array($currentFile['additional'])) {
                        foreach($currentFile['additional'] as $fileProperty => $propertyValue) {
                            if ($fileProperty != 'identifier') {
                                $setter = 'set' . ucFirst($fileProperty);
                                $fileRef->$setter($propertyValue);
                            }
                        }
                    }

                    $originalResource = FileUtility::createFileReference($file);
                    $fileRef->setOriginalResource($originalResource);
                    $fileRef->setShowinpreview(TRUE);

                    $this->addFalRelatedFile($fileRef);
                }
            }
        }
    }
}