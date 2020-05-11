<?php

namespace Cundd\CustomRest\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Person
 */
class Person extends AbstractEntity
{
    /**
     * name
     *
     * @var string
     */
    protected $name = '';
    /**
     * plz
     *
     * @var string
     */
    protected $plz = '';

    /**
     * telefon
     *
     * @var string
     */
    protected $telefon = '';

    /**
     * email
     *
     * @var string
     */
    protected $email = '';

    /**
     * bild
     *
     * @var string
     */
    protected $bild = null;

    /**
     * text
     *
     * @var string
     */
    protected $text = '';

    /**
     * Returns the name
     *
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the plz
     *
     * @return string $plz
     */
    public function getPlz()
    {
        return $this->plz;
    }

    /**
     * Sets the plz
     *
     * @param string $plz
     * @return void
     */
    public function setPlz($plz)
    {
        $this->plz = $plz;
    }

    /**
     * Returns the telefon
     *
     * @return string $telefon
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * Sets the telefon
     *
     * @param string $telefon
     * @return void
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;
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
     * Returns the bild
     *
     * @return string $bild
     */
    public function getBild()
    {
        return $this->bild;
    }

    /**
     * Sets the bild
     *
     * @param string $bild
     * @return void
     */
    public function setBild($bild)
    {
        $this->bild = $bild;
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
