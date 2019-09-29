<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 06.08.2018
 * Time: 13:45
 */

namespace Pingag\PingagJobs\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Property extends AbstractEntity
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var int
     */
    protected $importId;

    public function __toString()
    {
        return (string)$this->getValue();
    }
    
    public function getParentUid()
    {
        return $this->_getProperty('_localizedUid');
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getImportId()
    {
        return $this->importId;
    }

    /**
     * @param int $importId
     * @return $this
     */
    public function setImportId($importId)
    {
        $this->importId = $importId;
        return $this;
    }
}