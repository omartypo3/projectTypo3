<?php
namespace Cundd\CustomRest\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
/***
 *
 * This file is part of the "Custom REST extensions" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Daniel Corn <info@cundd.net>
 *
 ***/

/**
 * Email
 */
class Email extends AbstractEntity
{
    /**
     * address
     *
     * @var string
     */
    protected $address = '';

    /**
     * subject
     *
     * @var string
     */
    protected $subject = '';

    /**
     * email
     *
     * @var string
     */
    protected $email = '';


    /**
     * text
     *
     * @var string
     */
    protected $text = '';

    /**
     * Returns the address
     *
     * @return string address
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
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Returns the subject
     *
     * @return string $subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the subject
     *
     * @param string $subject
     * @return void
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
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
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the text
     *
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }



    /**
     * Sets the text
     *
     * @param string $text
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }
}
