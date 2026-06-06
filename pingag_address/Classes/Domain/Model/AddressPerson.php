<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Model;


/**
 * This file is part of the "SZB Kommunikationsassistenz" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 
 */

/**
 * AddressPerson
 */
class AddressPerson extends \FriendsOfTYPO3\TtAddress\Domain\Model\Address
{

    /**
     * gehoerlos
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Gehoerlos>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $gehoerlos = null;


    /**
     * placeofuse
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Placeofuse>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $placeofuse = null;


    /**
     * available
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Available>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $available = null;

    /**
     * autoBenoetigt
     *
     * @var bool
     */
    protected $autoBenoetigt = false;

    /**
     * technikenlevel
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Techniqueslevel>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $technikenlevel = null;

    /**
     * spezielle
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Spezielle>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $spezielle = null;

    /**
     * mutterSprache
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Language>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $mutterSprache = null;

    /**
     * weitereSprachenOral
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Languageoral>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $weitereSprachenOral = null;

    /**
     * weitereSprachenWritten
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Languagewritten>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $weitereSprachenWritten = null;

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
        $this->gehoerlos = $this->gehoerlos ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->technikenlevel = $this->technikenlevel ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->placeofuse = $this->placeofuse ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->available = $this->available ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->spezielle = $this->spezielle ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->mutterSprache = $this->mutterSprache ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->weitereSprachenOral = $this->weitereSprachenOral ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->weitereSprachenWritten = $this->weitereSprachenWritten ?: new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

    }


    /**
     * Adds a Gehoerlos
     *
     * @param \Pingag\PingagAddress\Domain\Model\Gehoerlos $gehoerlos
     * @return void
     */
    public function addGehoerlos(\Pingag\PingagAddress\Domain\Model\Gehoerlos $gehoerlos)
    {
        $this->gehoerlos->attach($gehoerlos);
    }

    /**
     * Removes a Gehoerlos
     *
     * @param \Pingag\PingagAddress\Domain\Model\Gehoerlos $gehoerlosToRemove The Gehoerlos to be removed
     * @return void
     */
    public function removeGehoerlos(\Pingag\PingagAddress\Domain\Model\Gehoerlos $gehoerlosToRemove)
    {
        $this->gehoerlos->detach($gehoerlosToRemove);
    }

    /**
     * Returns the gehoerlos
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Gehoerlos> gehoerlos
     */
    public function getGehoerlos()
    {
        return $this->gehoerlos;
    }

    /**
     * Sets the gehoerlos
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Gehoerlos> $gehoerlos
     * @return void
     */
    public function setGehoerlos(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $gehoerlos)
    {
        $this->gehoerlos = $gehoerlos;
    }
    

    /**
     * Returns the autoBenoetigt
     *
     * @return bool autoBenoetigt
     */
    public function getAutoBenoetigt()
    {
        return $this->autoBenoetigt;
    }

    /**
     * Sets the autoBenoetigt
     *
     * @param bool $autoBenoetigt
     * @return void
     */
    public function setAutoBenoetigt(bool $autoBenoetigt)
    {
        $this->autoBenoetigt = $autoBenoetigt;
    }

    /**
     * Returns the boolean state of autoBenoetigt
     *
     * @return bool autoBenoetigt
     */
    public function isAutoBenoetigt()
    {
        return $this->autoBenoetigt;
    }

    /**
     * Adds a Techniqueslevel
     *
     * @param \Pingag\PingagAddress\Domain\Model\Techniqueslevel $technikenlevel
     * @return void
     */
    public function addTechnikenlevel(\Pingag\PingagAddress\Domain\Model\Techniqueslevel $technikenlevel)
    {
        $this->technikenlevel->attach($technikenlevel);
    }

    /**
     * Removes a Techniqueslevel
     *
     * @param \Pingag\PingagAddress\Domain\Model\Techniqueslevel $technikenlevelToRemove The Techniques to be removed
     * @return void
     */
    public function removeTechnikenlevel(\Pingag\PingagAddress\Domain\Model\Techniqueslevel $technikenlevelToRemove)
    {
        $this->technikenlevel->detach($technikenlevelToRemove);
    }

    /**
     * Returns the technikenlevel
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Techniqueslevel> technikenlevel
     */
    public function getTechnikenlevel()
    {
        return $this->technikenlevel;
    }

    /**
     * Sets the technikenlevel
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Techniqueslevel> $technikenlevel
     * @return void
     */
    public function setTechnikenlevel(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $technikenlevel)
    {
        $this->technikenlevel = $technikenlevel;
    }

    /**
     * Adds a Language
     *
     * @param \Pingag\PingagAddress\Domain\Model\Language $mutterSprache
     * @return void
     */
    public function addMutterSprache(\Pingag\PingagAddress\Domain\Model\Language $mutterSprache)
    {
        $this->mutterSprache->attach($mutterSprache);
    }

    /**
     * Removes a Language
     *
     * @param \Pingag\PingagAddress\Domain\Model\Language $mutterSpracheToRemove The Language to be removed
     * @return void
     */
    public function removeMutterSprache(\Pingag\PingagAddress\Domain\Model\Language $mutterSpracheToRemove)
    {
        $this->mutterSprache->detach($mutterSpracheToRemove);
    }

    /**
     * Returns the mutterSprache
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Language> mutterSprache
     */
    public function getMutterSprache()
    {
        return $this->mutterSprache;
    }

    /**
     * Sets the mutterSprache
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Language> $mutterSprache
     * @return void
     */
    public function setMutterSpracheOral(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $mutterSprache)
    {
        $this->mutterSprache = $mutterSprache;
    }

    /**
     * Adds a Language
     *
     * @param \Pingag\PingagAddress\Domain\Model\Languageoral $weitereSprachenOral
     * @return void
     */
    public function addWeitereSprachenOral(\Pingag\PingagAddress\Domain\Model\Languageoral $weitereSprachenOral)
    {
        $this->weitereSprachenOral->attach($weitereSprachenOral);
    }

    /**
     * Removes a Language
     *
     * @param \Pingag\PingagAddress\Domain\Model\Languageoral $weitereSprachenOralToRemove The Language to be removed
     * @return void
     */
    public function removeWeitereSprachenOral(\Pingag\PingagAddress\Domain\Model\Languageoral $weitereSprachenOralToRemove)
    {
        $this->weitereSprachenOral->detach($weitereSprachenOralToRemove);
    }

    /**
     * Returns the weitereSprachenOral
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Languageoral> weitereSprachenOral
     */
    public function getWeitereSprachenOral()
    {
        return $this->weitereSprachenOral;
    }

  

    /**
     * Adds a weitereSprachenWritten
     *
     * @param \Pingag\PingagAddress\Domain\Model\Languagewritten $weitereSprachenWritten
     * @return void
     */
    public function addWeitereSprachenWritten(\Pingag\PingagAddress\Domain\Model\Languagewritten $weitereSprachenWritten)
    {
        $this->weitereSprachenWritten->attach($weitereSprachenWritten);
    }

    /**
     * Removes a weitereSprachenOral
     *
     * @param \Pingag\PingagAddress\Domain\Model\Languagewritten $weitereSprachenWrittenToRemove The Language to be removed
     * @return void
     */
    public function removeWeitereSprachenWritten(\Pingag\PingagAddress\Domain\Model\Languagewritten $weitereSprachenWrittenToRemove)
    {
        $this->weitereSprachenWritten->detach($weitereSprachenWrittenToRemove);
    }

    /**
     * Returns the weitereSprachenWritten
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Languagewritten> weitereSprachenWritten
     */
    public function getWeitereSprachenWritten()
    {
        return $this->weitereSprachenWritten;
    }

    /**
     * Sets the weitereSprachenWritten
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Languagewritten> $weitereSprachenWritten
     * @return void
     */
    public function setWeitereSprachenWritten(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $weitereSprachenWritten)
    {
        $this->weitereSprachenWritten = $weitereSprachenWritten;
    }
    


    /**
     * Sets the spezielle
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Spezielle> $spezielle
     * @return void
     */
    public function setSpezielle(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $spezielle)
    {
        $this->spezielle = $spezielle;
    }

    /**
     * Adds a spezielle
     *
     * @param \Pingag\PingagAddress\Domain\Model\Spezielle $spezielle
     * @return void
     */
    public function addSpezielle(\Pingag\PingagAddress\Domain\Model\Spezielle $spezielle)
    {
        $this->spezielle->attach($spezielle);
    }

    /**
     * Removes a spezielle
     *
     * @param \Pingag\PingagAddress\Domain\Model\Spezielle $spezielleToRemove The Language to be removed
     * @return void
     */
    public function removeSpezielle(\Pingag\PingagAddress\Domain\Model\Spezielle $spezielleToRemove)
    {
        $this->spezielle->detach($spezielleToRemove);
    }

    /**
     * Returns the spezielle
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Spezielle> spezielle
     */
    public function getSpezielle()
    {
        return $this->spezielle;
    }


    /**
     * Sets the placeofuse
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Placeofuse> $placeofuse
     * @return void
     */
    public function setPlaceofuse(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $placeofuse)
    {
        $this->placeofuse = $placeofuse;
    }

    /**
     * Adds a placeofuse
     *
     * @param \Pingag\PingagAddress\Domain\Model\Placeofuse $placeofuse
     * @return void
     */
    public function addPlaceofuse(\Pingag\PingagAddress\Domain\Model\Placeofuse $placeofuse)
    {
        $this->placeofuse->attach($placeofuse);
    }

    /**
     * Removes a placeofuse
     *
     * @param \Pingag\PingagAddress\Domain\Model\Placeofuse $placeofuseToRemove The Language to be removed
     * @return void
     */
    public function removePlaceofuse(\Pingag\PingagAddress\Domain\Model\Placeofuse $placeofuseToRemove)
    {
        $this->placeofuse->detach($placeofuseToRemove);
    }

    /**
     * Returns the placeofuse
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Placeofuse> placeofuse
     */
    public function getPlaceofuse()
    {
        return $this->placeofuse;
    }

    /**
     * Sets the available
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Available> $available
     * @return void
     */
    public function setAvailable(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $available)
    {
        $this->available = $available;
    }

    /**
     * Adds a available
     *
     * @param \Pingag\PingagAddress\Domain\Model\Available $available
     * @return void
     */
    public function addAvailable(\Pingag\PingagAddress\Domain\Model\Available $available)
    {
        $this->available->attach($available);
    }

    /**
     * Removes a available
     *
     * @param \Pingag\PingagAddress\Domain\Model\Available $availableToRemove The Language to be removed
     * @return void
     */
    public function removeAvailable(\Pingag\PingagAddress\Domain\Model\Available $availableToRemove)
    {
        $this->available->detach($availableToRemove);
    }

    /**
     * Returns the available
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pingag\PingagAddress\Domain\Model\Available> available
     */
    public function getAvailable()
    {
        return $this->available;
    }






}
