<?php
namespace FRONTAL\FagInstitutionManagement\Domain\Model;



/**
 * Dates
 */
class Dates extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * startdate
     * 
     * @var string
     */
    protected $startdate = null;

    /**
     * enddate
     * 
     * @var string
     */
    protected $enddate = null;

    /**
     * Returns the startdate
     * 
     * @return string $startdate
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Sets the startdate
     * 
     * @param string $startdate
     * @return void
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
    }

    /**
     * Returns the enddate
     * 
     * @return string $enddate
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Sets the enddate
     * 
     * @param string $enddate
     * @return void
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;
    }
}
