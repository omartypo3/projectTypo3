<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Model;

/***
 *
 * This file is part of the "aaaaa" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 aaaaaa <chaari.ons93@gmail.com>
 *
 ***/

/**
 * Link
 */
class Linkev extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * text
     * 
     * @var string
     */
    protected $text = '';

    /**
     * url
     * 
     * @var string
     */
    protected $url = '';

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

    /**
     * Returns the url
     * 
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     * 
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
