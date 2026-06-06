<?php
declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Model;

/**
 * This file is part of the "tt_address" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FriendsOfTYPO3\TtAddress\Utility\PropertyModification;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * The domain model of a Address
 */
class Address extends \FriendsOfTYPO3\TtAddress\Domain\Model\Address
{

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     *
     */
    protected $markerIcon;

    /**
     * dienstleistungen
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Dienstleistungen>
     */
    protected $dienstleistungen = null;
    /**
     * kantone
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Kantone>
     */
    protected $kantone = null;

    /**
     * angebote
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Angebote>
     */
    protected $angebote = null;

    /**
     * lebensalter
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Lebensalter>
     */
    protected $lebensalter = null;

    /**
     * weiterestandorte
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Weiterestandorte>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $weiterestandorte = null;

    /**
     * __construct
     */
    public function __construct()
    {

        // Do not remove the next line: It would break the functionality
        $this->initializeObject();
    }

    /**
     * Initializes all ObjectStorage properties when model is reconstructed from DB (where __construct is not called)
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    public function initializeObject()
    {
        $this->dienstleistungen = $this->dienstleistungen ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->markerIcon = $this->markerIcon ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->kantone = $this->kantone ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->angebote = $this->angebote ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->lebensalter = $this->lebensalter ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->weiterestandorte = $this->weiterestandorte ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

    }
    

    /**
     * @return mixed
     */
    public function getMarkerIcon()
    {
        return $this->markerIcon;
    }

    /**
     * @param mixed $markerIcon
     * @return $this
     */
    public function setMarkerIcon($markerIcon)
    {
        $this->markerIcon = $markerIcon;
        return $this;
    }

    /**
     * Adds a dienstleistungen
     *
     * @param \Pingag\PingagAddress\Domain\Model\Dienstleistungen $dienstleistungen
     * @return void
     */
    public function addDienstleistungen(\Pingag\PingagAddress\Domain\Model\Dienstleistungen $dienstleistungen)
    {
        $this->dienstleistungen->attach($dienstleistungen);
    }
    /**
     * Adds a kantone
     *
     * @param \Pingag\PingagAddress\Domain\Model\Kantone $kantone
     * @return void
     */
    public function addKantone(\Pingag\PingagAddress\Domain\Model\Kantone $kantone)
    {
        $this->kantone->attach($kantone);
    }

    /**
     * Removes a dienstleistungen
     *
     * @param \Pingag\PingagAddress\Domain\Model\Dienstleistungen $dienstleistungenToRemove The dienstleistungen to be removed
     * @return void
     */
    public function removeDienstleistungen(\Pingag\PingagAddress\Domain\Model\Dienstleistungen $dienstleistungenToRemove)
    {
        $this->dienstleistungen->detach($dienstleistungenToRemove);
    }
    /**
     * Removes a kantone
     *
     * @param \Pingag\PingagAddress\Domain\Model\Kantone $kantoneToRemove The kantone to be removed
     * @return void
     */
    public function removeKantone(\Pingag\PingagAddress\Domain\Model\Kantone $kantoneToRemove)
    {
        $this->kantone->detach($kantoneToRemove);
    }

    /**
     * Returns the dienstleistungen
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Dienstleistungen>
     */
    public function getDienstleistungen()
    {
        return $this->dienstleistungen;
    }
    /**
     * Returns the kantone
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Kantone>
     */
    public function getKantone()
    {
        return $this->kantone;
    }

    /**
     * Sets the dienstleistungen
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Dienstleistungen> $dienstleistungen
     * @return void
     */
    public function setDienstleistungen(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $dienstleistungen)
    {
        $this->dienstleistungen = $dienstleistungen;
    }
    /**
     * Sets the kantone
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Kantone> $kantone
     * @return void
     */
    public function setKantone(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $kantone)
    {
        $this->kantone = $kantone;
    }

    /**
     * Sets the angebote
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Angebote> $angebote
     * @return void
     */
    public function setAngebote(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $angebote)
    {
        $this->angebote = $angebote;
    }

    /**
     * Adds a angebote
     *
     * @param \Pingag\PingagAddress\Domain\Model\Angebote $angebote
     * @return void
     */
    public function addAngebote(\Pingag\PingagAddress\Domain\Model\Angebote $angebote)
    {
        $this->angebote->attach($angebote);
    }

    /**
     * Removes a angebote
     *
     * @param \Pingag\PingagAddress\Domain\Model\Angebote $angeboteToRemove The angebote to be removed
     * @return void
     */
    public function removeAngebote(\Pingag\PingagAddress\Domain\Model\Angebote $angeboteToRemove)
    {
        $this->angebote->detach($angeboteToRemove);
    }

    /**
     * Returns the angebote
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Angebote> angebote
     */
    public function getAngebote()
    {
        return $this->angebote;
    }


    /**
     * Sets the lebensalter
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Lebensalter> $lebensalter
     * @return void
     */
    public function setLebensalter(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $lebensalter)
    {
        $this->lebensalter = $lebensalter;
    }

    /**
     * Adds a lebensalter
     *
     * @param \Pingag\PingagAddress\Domain\Model\Lebensalter $lebensalter
     * @return void
     */
    public function addLebensalter(\Pingag\PingagAddress\Domain\Model\Lebensalter $lebensalter)
    {
        $this->lebensalter->attach($lebensalter);
    }

    /**
     * Removes a lebensalter
     *
     * @param \Pingag\PingagAddress\Domain\Model\Lebensalter $lebensalterToRemove The lebensalter to be removed
     * @return void
     */
    public function removeLebensalter(\Pingag\PingagAddress\Domain\Model\Lebensalter $lebensalterToRemove)
    {
        $this->lebensalter->detach($lebensalterToRemove);
    }

    /**
     * Returns the lebensalter
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Lebensalter> lebensalter
     */
    public function getLebensalter()
    {
        return $this->lebensalter;
    }

    /**
     * Adds a weiterestandorte
     *
     * @param \Pingag\PingagAddress\Domain\Model\Weiterestandorte $weiterestandorte
     * @return void
     */
    public function addWeiterestandorte(\Pingag\PingagAddress\Domain\Model\Weiterestandorte $weiterestandorte)
    {
        $this->weiterestandorte->attach($weiterestandorte);
    }

    /**
     * Removes a weiterestandorte
     *
     * @param \Pingag\PingagAddress\Domain\Model\Weiterestandorte $weiterestandorteToRemove The Tag to be removed
     * @return void
     */
    public function removeWeiterestandorte(\Pingag\PingagAddress\Domain\Model\Weiterestandorte $weiterestandorteToRemove)
    {
        $this->weiterestandorte->detach($weiterestandorteToRemove);
    }

    /**
     * Returns the weiterestandorte
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Weiterestandorte> $weiterestandorte
     */
    public function getWeiterestandorte()
    {
        return $this->weiterestandorte;
    }

    /**
     * Sets the weiterestandorte
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Weiterestandorte> $weiterestandorte
     * @return void
     */
    public function setWeiterestandorte(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $weiterestandorte)
    {
        $this->weiterestandorte = $weiterestandorte;
    }

    /**
     * _languageUid
     * @var int
     */
    protected $_languageUid;

    /**
     * @param int $_languageUid
     * @return void
     */
    public function set_languageUid($_languageUid) {
        $this->_languageUid = $_languageUid;
    }

    /**
     * @return int
     */
    public function get_languageUid() {
        return $this->_languageUid;
    }


}
