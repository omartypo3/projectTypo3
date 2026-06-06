<?php
namespace DslFactory\DslJobs\Domain\Model;

/***
 *
 * This file is part of the "Jobs" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * JobLevel
 */
class JobLevel extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * jobLevel
     *
     * @var int
     */
    protected $jobLevel = 0;

    /**
     * bezeichnung
     *
     * @var string
     */
    protected $bezeichnung = '';

    /**
     * Returns the jobLevel
     *
     * @return int $jobLevel
     */
    public function getJobLevel()
    {
        return $this->jobLevel;
    }

    /**
     * Sets the jobLevel
     *
     * @param int $jobLevel
     * @return void
     */
    public function setJobLevel($jobLevel)
    {
        $this->jobLevel = $jobLevel;
    }

    /**
     * Returns the bezeichnung
     *
     * @return string $bezeichnung
     */
    public function getBezeichnung()
    {
        return $this->bezeichnung;
    }

    /**
     * Sets the bezeichnung
     *
     * @param string $bezeichnung
     * @return void
     */
    public function setBezeichnung($bezeichnung)
    {
        $this->bezeichnung = $bezeichnung;
    }
}
