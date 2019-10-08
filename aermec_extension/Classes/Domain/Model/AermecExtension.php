<?php
namespace AermecExtension\AermecExtension\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Vedat Yildirim <info@vedyweb.com>, vedyweb
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

/**
 * AermecExtension
 */
class AermecExtension extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';
    
    /**
     * color
     *
     * @var string
     * @validate NotEmpty
     */
    protected $color = '';
    
    /**
     * price
     *
     * @var int
     */
    protected $price = 0;
    
    /**
     * Returns the name
     *
     * @return string $name
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
     * Returns the color
     *
     * @return string $color
     */
    public function getColor()
    {
        return $this->color;
    }
    
    /**
     * Sets the color
     *
     * @param string $color
     * @return void
     */
    public function setColor($color)
    {
        $this->color = $color;
    }
    
    /**
     * Returns the price
     *
     * @return int $price
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Sets the price
     *
     * @param int $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

}