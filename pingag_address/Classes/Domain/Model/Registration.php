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
class Registration extends \DERHANSEN\SfEventMgt\Domain\Model\Registration
{

    protected string $bill = '';
    protected string $acompany = '';
    protected string $aaddress = '';
    protected string $azip = '';
    protected string $acity = '';
    protected string $aphone = '';
    protected string $aemail = '';
    protected string $ajob = '';
    protected string $documents = '';
    protected string $situation = '';
    protected bool $newsletter = false;
    protected bool $personaldata = false;
    protected bool $hidden = false;



    public function getBill(): string
    {
        return $this->bill;
    }

    public function setBill(string $bill)
    {
        $this->bill = $bill;
    }

    public function getAcompany(): string
    {
        return $this->acompany;
    }

    public function setAcompany(string $acompany)
    {
        $this->acompany = $acompany;
    }

    public function getAaddress(): string
    {
        return $this->aaddress;
    }

    public function setAaddress(string $aaddress)
    {
        $this->aaddress = $aaddress;
    }

    public function getAzip(): string
    {
        return $this->azip;
    }

    public function setAzip(string $azip)
    {
        $this->azip = $azip;
    }

    public function getAcity(): string
    {
        return $this->acity;
    }

    public function setAcity(string $acity)
    {
        $this->acity = $acity;
    }


    public function getAphone(): string
    {
        return $this->aphone;
    }

    public function setAphone(string $aphone)
    {
        $this->aphone = $aphone;
    }

    public function getAemail(): string
    {
        return $this->aemail;
    }

    public function setAemail(string $aemail)
    {
        $this->aemail = trim($aemail);
    }

    public function getAjob(): string
    {
        return $this->ajob;
    }

    public function setAjob(string $ajob)
    {
        $this->ajob = trim($ajob);
    }

    public function getDocuments(): string
    {
        return $this->documents;
    }

    public function setDocuments(string $documents)
    {
        $this->documents = trim($documents);
    }


    public function getSituation(): string
    {
        return $this->situation;
    }

    public function setSituation(string $situation)
    {
        $this->situation = trim($situation);
    }
    public function getNewsletter(): bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(bool $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function getPersonaldata(): bool
    {
        return $this->personaldata;
    }

    public function setPersonaldata(bool $personaldata)
    {
        $this->personaldata = $personaldata;
    }

    public function setHidden($hidden) {
        $this->hidden = $hidden;
    }
}
