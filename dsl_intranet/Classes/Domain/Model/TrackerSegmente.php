<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Domain\Model;


/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * TrackerSegmente
 */
class TrackerSegmente extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * begin
     *
     * @var \DateTime
     */
    protected $begin;

    /**
     * end
     *
     * @var \DateTime
     */
    protected $end;

    /**
     * Returns the begin
     *
     * @return \DateTime
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Sets the begin
     *
     * @param \DateTime $begin
     * @return void
     */
    public function setBegin(\DateTime $begin)
    {
        $this->begin = $begin;
    }

    /**
     * Returns the end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Sets the end
     *
     * @param \DateTime $end
     * @return void
     */
    public function setEnd(\DateTime $end)
    {
        $this->end = $end;
    }
	
	/**
     * Returns the boolean state paused
     * 
     * @return bool
     */
    public function isOpened()
    {
        if (!$this->end) {
            return true;
        }
        return false;
    }
	
	/**
     * Returns the time in seconds
     * 
     * @return integer $seconds
     */
    public function getSeconds()
    {
        if ($this->end) {
            $end = $this->end;
        } else {
            $end = new \DateTime(date('Y-m-d H:i:s'));
        }
        return $end->getTimestamp() - $this->begin->getTimestamp();
    }
	
	/**
     * Returns the time in minutes
     * 
     * @return integer minutes
     */
    public function getMinutes()
    {
        return ceil($this->getSeconds() / 60);
    }
}
