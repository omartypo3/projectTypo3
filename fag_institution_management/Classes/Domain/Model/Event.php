<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Model;

/***
 *
 * This file is part of the "FRONTAL / Institutionen" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Roland Kneubühler <rk@frontal.ch>, Agentur Frontal AG
 *
 ***/
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Event
 */
class Event extends \FRONTAL\FagCalendar\Domain\Model\Event
{
    /**
     * Image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image;
    /**
     * institution
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Model\Institution
     */
    protected $institution = null;

    /**
     * images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $images = null;

    /**
     * docs
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Docs>
     * @cascade remove
     */
    protected $docs = null;

    /**
     * links
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Linkev>
     */
    protected $links = null;

    /**
     * Returns the institution
     *
     * @return \FRONTAL\FagInstitutionManagement\Domain\Model\Institution $institution
     */

    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Sets the institution
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Institution $institution
     * @return void
     */
    public function setInstitution(\FRONTAL\FagInstitutionManagement\Domain\Model\Institution $institution)
    {
        $this->institution = $institution;
    }

    /**
     * dates
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Dates>
     */
    protected $dates = null;

    /**
     * Returns the dates
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Dates>$dates
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * Sets the dates
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Dates>$dates
     * @return void
     */
    public function setDates(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $dates)
    {
        $this->dates = $dates;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    public function __construct()
    {
        $this->image = new ObjectStorage();
        $this->dates = new ObjectStorage();
        $this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->docs = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->links = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function addImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->images->attach($image);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove The FileReference to be removed
     * @return void
     */
    public function removeImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove)
    {
        $this->images->detach($imageToRemove);
    }

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the images
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     * @return void
     */
    public function setImages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images)
    {
        $this->images = $images;
    }

    /**
     * Adds a FileReference
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Docs $doc
     * @return void
     */
    public function addDoc(\FRONTAL\FagInstitutionManagement\Domain\Model\Docs $doc)
    {
        $this->docs->attach($doc);
    }

    /**
     * Removes a FileReference
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Docs $docToRemove The FileReference to be removed
     * @return void
     */
    public function removeDoc(\FRONTAL\FagInstitutionManagement\Domain\Model\Docs $docToRemove)
    {
        $this->docs->detach($docToRemove);
    }

    /**
     * Returns the docs
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Docs> $docs
     */
    public function getDocs()
    {
        return $this->docs;
    }

    /**
     * Sets the docs
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Docs> $docs
     * @return void
     */
    public function setDocs(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $docs)
    {
        $this->docs = $docs;
    }
    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $documentToRemove The FileReference to be removed
     * @return void
     */
    public function removeDocument(\TYPO3\CMS\Extbase\Domain\Model\FileReference $documentToRemove)
    {
        $this->document->detach($documentToRemove);
    }

    /**
     * Adds a Linkev
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Linkev $link
     * @return void
     */
    public function addLink(\FRONTAL\FagInstitutionManagement\Domain\Model\Linkev $link)
    {
        $this->links->attach($link);
    }

    /**
     * Removes a Linkev
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Linkev $linkToRemove The Linkev to be removed
     * @return void
     */
    public function removeLink(\FRONTAL\FagInstitutionManagement\Domain\Model\Linkev $linkToRemove)
    {
        $this->links->detach($linkToRemove);
    }

    /**
     * Returns the links
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Linkev> $links
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Sets the links
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\FRONTAL\FagInstitutionManagement\Domain\Model\Linkev> $links
     * @return void
     */
    public function setLinks(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $links)
    {
        $this->links = $links;
    }
}
