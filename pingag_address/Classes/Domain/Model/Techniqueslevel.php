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
class Techniqueslevel extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * level
     *
     * @var \Pingag\PingagAddress\Domain\Model\Level
     */
    protected $level = null;

    /**
     * techniques
     *
     * @var \Pingag\PingagAddress\Domain\Model\Techniques
     */
    protected $techniques = null;

    /**
     * Returns the techniques
     *
     * @return \Pingag\PingagAddress\Domain\Model\Techniques techniques
     */
    public function getTechniques()
    {
        return $this->techniques;
    }

    /**
     * Sets the techniques
     *
     * @param \Pingag\PingagAddress\Domain\Model\Techniques $techniques
     * @return void
     */
    public function setTechniques($techniques)
    {
        $this->Techniques = $techniques;
    }


    /**
     * Returns the level
     *
     * @return \Pingag\PingagAddress\Domain\Model\Level level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Sets the level
     *
     * @param \Pingag\PingagAddress\Domain\Model\Level $level
     * @return void
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }
}
