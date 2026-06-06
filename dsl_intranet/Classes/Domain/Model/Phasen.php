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
 * Phasen
 */
class Phasen extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * titel
     *
     * @var string
     */
    protected $titel;

    /**
     * color
     *
     * @var string
     */
    protected $color;

    /**
     * highlightcolor
     *
     * @var string
     */
    protected $highlightcolor;

    /**
     * icon
     *
     * @var string
     */
    protected $icon;

    /**
     * titelKurz
     *
     * @var string
     */
    protected $titelKurz;

    /**
     * Returns the titel
     *
     * @return string
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * Sets the titel
     *
     * @param string $titel
     * @return void
     */
    public function setTitel(string $titel)
    {
        $this->titel = $titel;
    }

    /**
     * Returns the color
     *
     * @return string
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
    public function setColor(string $color)
    {
        $this->color = $color;
    }

    /**
     * Returns the highlightcolor
     *
     * @return string
     */
    public function getHighlightcolor()
    {
        return $this->highlightcolor;
    }

    /**
     * Sets the highlightcolor
     *
     * @param string $highlightcolor
     * @return void
     */
    public function setHighlightcolor(string $highlightcolor)
    {
        $this->highlightcolor = $highlightcolor;
    }

    /**
     * Returns the icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Sets the icon
     *
     * @param string $icon
     * @return void
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;
    }

    /**
     * Returns the titelKurz
     *
     * @return string
     */
    public function getTitelKurz()
    {
        return $this->titelKurz;
    }

    /**
     * Sets the titelKurz
     *
     * @param string $titelKurz
     * @return void
     */
    public function setTitelKurz(string $titelKurz)
    {
        $this->titelKurz = $titelKurz;
    }
}
