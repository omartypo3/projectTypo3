<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Domain\Model;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 
 */

/**
 * KundenStammdaten
 */
class KundenStammdaten extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * qbbaddr
     * 
     * @var string
     */
    protected $qbbaddr;

    /**
     * email
     * 
     * @var string
     */
    protected $email;

    /**
     * qbEmail
     * 
     * @var string
     */
    protected $qbEmail;

    /**
     * emailRechnungen
     * 
     * @var string
     */
    protected $emailRechnungen;

    /**
     * emailAngebote
     * 
     * @var string
     */
    protected $emailAngebote;

    /**
     * qbBank
     * 
     * @var string
     */
    protected $qbBank;

    /**
     * qbIban
     * 
     * @var string
     */
    protected $qbIban;

    /**
     * qbBic
     * 
     * @var string
     */
    protected $qbBic;

    /**
     * qbKtoInh
     * 
     * @var string
     */
    protected $qbKtoInh;

    /**
     * emailNewsletter
     * 
     * @var string
     */
    protected $emailNewsletter;

    /**
     * nummer
     * 
     * @var string
     */
    protected $nummer;

    /**
     * company
     * 
     * @var string
     */
    protected $company;

    /**
     * firstName
     * 
     * @var string
     */
    protected $firstName;

    /**
     * lastName
     * 
     * @var string
     */
    protected $lastName;

    /**
     * zip
     * 
     * @var string
     */
    protected $zip;

    /**
     * city
     * 
     * @var string
     */
    protected $city;

    /**
     * title
     * 
     * @var string
     */
    protected $title;

    /**
     * telephone
     * 
     * @var string
     */
    protected $telephone;

    /**
     * fax
     * 
     * @var string
     */
    protected $fax;

    /**
     * address
     * 
     * @var string
     */
    protected $address;

    /**
     * qbCont2
     * 
     * @var string
     */
    protected $qbCont2;

    /**
     * qbPhone2
     * 
     * @var string
     */
    protected $qbPhone2;

    /**
     * settingsKunde
     * 
     * @var string
     */
    protected $settingsKunde;

    /**
     * newsletter
     * 
     * @var bool
     */
    protected $newsletter;

    /**
     * Returns the company
     * 
     * @return string $company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Sets the company
     * 
     * @param string $company
     * @return void
     */
    public function setCompany(string $company)
    {
        $this->company = $company;
    }

    /**
     * Returns the firstName
     * 
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the firstName
     * 
     * @param string $firstName
     * @return void
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Returns the lastName
     * 
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Sets the lastName
     * 
     * @param string $lastName
     * @return void
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Returns the zip
     * 
     * @return string $zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     * 
     * @param string $zip
     * @return void
     */
    public function setZip(string $zip)
    {
        $this->zip = $zip;
    }

    /**
     * Returns the city
     * 
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     * 
     * @param string $city
     * @return void
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle(string  $title)
    {
        $this->title = $title;
    }

    /**
     * Returns the telephone
     * 
     * @return string $telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Sets the telephone
     * 
     * @param string $telephone
     * @return void
     */
    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * Returns the fax
     * 
     * @return string $fax
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Sets the fax
     * 
     * @param string $fax
     * @return void
     */
    public function setFax(string $fax)
    {
        $this->fax = $fax;
    }

    /**
     * Returns the address
     * 
     * @return string $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the address
     * 
     * @param string $address
     * @return void
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * Returns the settingsKunde
     * 
     * @return string $settingsKunde
     */
    public function getSettingsKunde()
    {
        $filterArr = array();
        if ($this->settingsKunde) {
            $filterArr = unserialize($this->settingsKunde);
        }
        if (!isset($filterArr['becomeInfoGlobal'])) {
            $filterArr['becomeInfoGlobal'] = 1;
        }
        if (!isset($filterArr['becomeInfoStatuschange'])) {
            $filterArr['becomeInfoStatuschange'] = 1;
        }
        if (!isset($filterArr['becomeInfoDownloads'])) {
            $filterArr['becomeInfoDownloads'] = 1;
        }
        if (!isset($filterArr['becomeInfoAngebote'])) {
            $filterArr['becomeInfoAngebote'] = 1;
        }
        if (!isset($filterArr['becomeInfoRechnungen'])) {
            $filterArr['becomeInfoRechnungen'] = 1;
        }
        return $filterArr;
    }

    /**
     * Sets the settingsKunde
     * 
     * @param string $settingsKunde
     * @return void
     */
    public function setSettingsKunde(string $settingsKunde)
    {
        if ($settingsKunde) {
            $this->settingsKunde = serialize($settingsKunde);
        } else {
            $this->settingsKunde = '';
        }
    }

    /**
     * Returns the newsletter
     * 
     * @return bool $newsletter
     */
    public function getNewsletter()
    {
		
		
		if(\DslFactory\DslIntranet\Utility\NewsletterUtility::init()->getApi()){
			if ($this->getEmailNewsletter()) {
				return \DslFactory\DslIntranet\Utility\NewsletterUtility::init()->getApi()->isSubscribedRecipient($this->getEmailNewsletter());
			} else return false;
		}
		
        return $this->newsletter;
    }

    /**
     * Sets the newsletter
     * 
     * @param bool $newsletter
     * @return void
     */
    public function setNewsletter(bool $newsletter)
    {
        //echo ":".$newsletter.":";
		
		if(\DslFactory\DslIntranet\Utility\NewsletterUtility::init()->getApi()){
		
			if ($newsletter) {//wenn eine email gesetzt wird
				if ($this->getEmailNewsletter()) {
					\DslFactory\DslIntranet\Utility\NewsletterUtility::init()->getApi()->subscribeRecipient($this->getEmailNewsletter());
				}
			} else {
				\DslFactory\DslIntranet\Utility\NewsletterUtility::init()->getApi()->unsubscribeRecipient($this->getEmailNewsletter());
			}
		}
        $this->newsletter = $newsletter;
    }

    /**
     * Returns the boolean state of newsletter
     * 
     * @return bool
     */
    public function isNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Returns the qbbaddr
     *
     * @return string
     */
    public function getQbbaddr()
    {
        // Return empty string if qbbaddr is null
        if ($this->qbbaddr === null) {
            return '';
        }

        $arr = explode(chr(10), trim($this->qbbaddr));
        $resArr = array();

        foreach ($arr as $value) {
            $trimmed = trim($value);
            if ($trimmed !== '') {
                $resArr[] = $trimmed;
            }
        }

        return implode(chr(10), $resArr);
    }

    /**
     * Returns the fulladdr
     * 
     * @return string $fulladdr
     */
    public function getFullAddr()
    {
        $resArr = array();
        if ($this->getCompany()) {
            $resArr[] = $this->getCompany();
        }
        if ($this->getTitle() || $this->getFirstName() || $this->getLastName()) {
            $tmpArr = array();
            if ($this->getTitle()) {
                $tmpArr[] = $this->getTitle();
            }
            if ($this->getFirstName()) {
                $tmpArr[] = $this->getFirstName();
            }
            if ($this->getLastName()) {
                $tmpArr[] = $this->getLastName();
            }
            $resArr[] = implode(' ', $tmpArr);
        }
        if ($this->getAddress()) {
            $resArr[] = $this->getAddress();
        }
        if ($this->getZip() || $this->getCity()) {
            $tmpArr = array();
            if ($this->getZip()) {
                $tmpArr[] = $this->getZip();
            }
            if ($this->getCity()) {
                $tmpArr[] = $this->getCity();
            }
            $resArr[] = implode(' ', $tmpArr);
        }
        if (!count($resArr)) {
            return $this->getQbbaddr();
        }
        /*//$arr = trim($this->qbbaddr);
          $arr = explode(chr(10), trim($this->qbbaddr));
          $resArr = array();
          foreach ($arr as $value) {
          if (trim($value)) {
          $resArr[] = trim($value);
          }
          }*/

        //implode()
        return implode(chr(10), $resArr);
    }

    /**
     * Returns the email
     * 
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     * 
     * @param string $email
     * @return void
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Returns the emailRechnungen
     * 
     * @return string $emailRechnungen
     */
    public function getEmailRechnungen()
    {
        return $this->emailRechnungen;
    }

    /**
     * Returns the emailAngebote
     * 
     * @return string $emailAngebote
     */
    public function getEmailAngebote()
    {
        return $this->emailAngebote;
    }

    /**
     * Sets the emailRechnungen
     * 
     * @param string $emailRechnungen
     * @return void
     */
    public function setEmailRechnungen(string $emailRechnungen)
    {
        $this->emailRechnungen = $emailRechnungen;
    }

    /**
     * Sets the emailAngebote
     * 
     * @param string $emailAngebote
     * @return void
     */
    public function setEmailAngebote(string $emailAngebote)
    {
        $this->emailAngebote = $emailAngebote;
    }

    /**
     * Returns the emailAngeboteAusgabe
     * 
     * @return string $emailAngeboteAusgabe
     */
    public function getEmailAngeboteAusgabe()
    {
        if ($this->emailAngebote) {
            return $this->emailAngebote;
        }
        if ($this->getQbEmail()) {
            return $this->getQbEmail();
        }
        if ($this->getEmail()) {
            return $this->getEmail();
        }
        return '';
    }

    /**
     * Returns the emailRechnungenAusgabe
     * 
     * @return string $emailRechnungenAusgabe
     */
    public function getEmailRechnungenAusgabe()
    {
        if ($this->emailRechnungen) {
            return $this->emailRechnungen;
        }
        if ($this->getQbEmail()) {
            return $this->getQbEmail();
        }
        if ($this->getEmail()) {
            return $this->getEmail();
        }
        return '';
    }

    /**
     * Returns the qbBank
     * 
     * @return string $qbBank
     */
    public function getQbBank()
    {
        return $this->qbBank;
    }

    /**
     * Sets the qbBank
     * 
     * @param string $qbBank
     * @return void
     */
    public function setQbBank(string $qbBank)
    {
        $this->qbBank = $qbBank;
    }

    /**
     * Returns the qbIban
     * 
     * @return string $qbIban
     */
    public function getQbIban()
    {
        return $this->qbIban;
    }

    /**
     * Sets the qbIban
     * 
     * @param string $qbIban
     * @return void
     */
    public function setQbIban(string $qbIban)
    {
        $this->qbIban = $qbIban;
    }

    /**
     * Returns the qbBic
     * 
     * @return string $qbBic
     */
    public function getQbBic()
    {
        return $this->qbBic;
    }

    /**
     * Sets the qbBic
     * 
     * @param string $qbBic
     * @return void
     */
    public function setQbBic(string $qbBic)
    {
        $this->qbBic = $qbBic;
    }

    /**
     * Returns the qbKtoInh
     * 
     * @return string $qbKtoInh
     */
    public function getQbKtoInh()
    {
        return $this->qbKtoInh;
    }

    /**
     * Sets the qbKtoInh
     * 
     * @param string $qbKtoInh
     * @return void
     */
    public function setQbKtoInh(string $qbKtoInh)
    {
        $this->qbKtoInh = $qbKtoInh;
    }

    /**
     * Returns the qbEmail
     * 
     * @return string $qbEmail
     */
    public function getQbEmail()
    {
        return $this->qbEmail;
    }

    /**
     * Returns the emailNewsletter
     * 
     * @return string $emailNewsletter
     */
    public function getEmailNewsletter()
    {
        if (!$this->emailNewsletter) {
            if ($this->getEmail()) {
                return $this->getEmail();
            }
        }
        return $this->emailNewsletter;
    }

    /**
     * Sets the emailNewsletter
     * 
     * @param string $emailNewsletter
     * @return void
     */
    public function setEmailNewsletter(string $emailNewsletter)
    {
		if(\DslFactory\DslIntranet\Utility\NewsletterUtility::init()->getApi()){
			if ($this->getEmailNewsletter()) {
				if (\DslFactory\DslIntranet\Utility\NewsletterUtility::init()->getApi()->isSubscribedRecipient($this->getEmailNewsletter())) {
					\DslFactory\DslIntranet\Utility\NewsletterUtility::init()->getApi()->unsubscribeRecipient($this->getEmailNewsletter());
				}
			}
			if ($emailNewsletter) {
				\DslFactory\DslIntranet\Utility\NewsletterUtility::init()->getApi()->subscribeRecipient($emailNewsletter);
			}
		}
        $this->emailNewsletter = $emailNewsletter;
    }

    /**
     * Returns the qbCont2
     * 
     * @return string $qbCont2
     */
    public function getQbCont2()
    {
        return $this->qbCont2;
    }

    /**
     * Sets the qbCont2
     * 
     * @param string $qbCont2
     * @return void
     */
    public function setQbCont2(string $qbCont2)
    {
        $this->qbCont2 = $qbCont2;
    }

    /**
     * Returns the qbPhone2
     * 
     * @return string $qbPhone2
     */
    public function getQbPhone2()
    {
        return $this->qbPhone2;
    }

    /**
     * Sets the qbPhone2
     * 
     * @param string $qbPhone2
     * @return void
     */
    public function setQbPhone2(string $qbPhone2)
    {
        $this->qbPhone2 = $qbPhone2;
    }
}
