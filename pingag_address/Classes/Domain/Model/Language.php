<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Model;


/**
 * This file is part of the "Kommunikation" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 
 */

/**
 * Language
 */
class Language extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * orderOtherLanguages
     *
     * @var int
     */
    protected $orderOtherLanguages;

    /**
     * Returns the name
     *
     * @return string
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
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns the orderOtherLanguages
     *
     * @return int
     */
    public function getOrderOtherLanguages()
    {
        return $this->orderOtherLanguages;
    }

    /**
     * Sets the orderOtherLanguages
     *
     * @param int $orderOtherLanguages
     * @return void
     */
    public function setOrderOtherLanguages(int $orderOtherLanguages)
    {
        $this->orderOtherLanguages = $orderOtherLanguages;
    }
}
