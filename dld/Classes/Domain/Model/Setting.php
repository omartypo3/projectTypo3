<?php
namespace DLD\Dld\Domain\Model;

/***
 *
 * This file is part of the "DLD Conference" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * Setting
 */
class Setting extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * field
     * 
     * @var string
     */
    protected $field = '';

    /**
     * value
     * 
     * @var string
     */
    protected $value = '';

    /**
     * Returns the field
     * 
     * @return string $field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Sets the field
     * 
     * @param string $field
     * @return void
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * Returns the value
     * 
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value
     * 
     * @param string $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
