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
 * Zusatzleistungen
 */
class Zusatzleistungen extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * titel
     *
     * @var string
     */
    protected $titel;

    /**
     * laufzeit
     *
     * @var int
     */
    protected $laufzeit;

    /**
     * preisMonatlich
     *
     * @var float
     */
    protected $preisMonatlich;

    /**
     * notiz
     *
     * @var string
     */
    protected $notiz;

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
     * Returns the laufzeit
     *
     * @return int
     */
    public function getLaufzeit()
    {
        return $this->laufzeit;
    }

    /**
     * Sets the laufzeit
     *
     * @param int $laufzeit
     * @return void
     */
    public function setLaufzeit(int $laufzeit)
    {
        $this->laufzeit = $laufzeit;
    }

    /**
     * Returns the preisMonatlich
     *
     * @return float
     */
    public function getPreisMonatlich()
    {
        return $this->preisMonatlich;
    }

    /**
     * Sets the preisMonatlich
     *
     * @param float $preisMonatlich
     * @return void
     */
    public function setPreisMonatlich(float $preisMonatlich)
    {
        $this->preisMonatlich = $preisMonatlich;
    }

    /**
     * Returns the notiz
     *
     * @return string
     */
    public function getNotiz()
    {
        return $this->notiz;
    }

    /**
     * Sets the notiz
     *
     * @param string $notiz
     * @return void
     */
    public function setNotiz(string $notiz)
    {
        $this->notiz = $notiz;
    }
}
