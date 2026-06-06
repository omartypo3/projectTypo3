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
class Languagewritten extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * level
     *
     * @var \Pingag\PingagAddress\Domain\Model\Level
     */
    protected $level = null;

    /**
     * language
     *
     * @var \Pingag\PingagAddress\Domain\Model\Language
     */
    protected $language = null;

    /**
     * Returns the language
     *
     * @return \Pingag\PingagAddress\Domain\Model\Language language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Sets the language
     *
     * @param \Pingag\PingagAddress\Domain\Model\Language $language
     * @return void
     */
    public function setLanguage($language)
    {
        $this->language = $language;
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
