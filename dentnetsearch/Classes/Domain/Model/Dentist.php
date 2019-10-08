<?php
namespace DentNetSearch\Dentnetsearch\Domain\Model;


/***
 *
 * This file is part of the "DentNetSearch" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 ons <ons.chaari@softtodo.com>, softtodo
 *
 ***/
/**
 * Dentist
 */
class Dentist extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * id
     * 
     * @var int
     */
    protected $id = 0;

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * pagedetailid
     *
     * @var int
     */
    protected $pagedetailid = 0;

    /**
     * Returns the id
     * 
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

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
     * Returns the pagedetailid
     *
     * @return int $pagedetailid
     */
    public function getPagedetailid()
    {
        return $this->id;
    }

    /**
     * Sets the pagedetailid
     *
     * @param int $pagedetailid
     * @return void
     */
    public function setPagedetailid($pagedetailid)
    {
        $this->pagedetailid = $pagedetailid;
    }
}
