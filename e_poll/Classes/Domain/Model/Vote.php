<?php
namespace Emagineurs\EPoll\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Le Sommer Léo-Robin <llesommer@e-magineurs.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @package e_poll
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Vote extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
    /**
     * options
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EPoll\Domain\Model\Option>
     */
    protected $options;

    /**
     * feuser
     *
     * @var int
     */
    protected $feuser = 0;

    /**
     * ip
     *
     * @var string
     */
    protected $ip = '';

    /**
     * crdate
     *
     * @var integer
     */
    protected $crdate = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    public function getOptions(): \TYPO3\CMS\Extbase\Persistence\ObjectStorage
    {
        if ($this->options === null) {
            $this->options = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        }
        return $this->options;
    }

    public function setOptions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $options): void
    {
        $this->options = $options;
    }

    public function getFeuser(): ?int
    {
        return $this->feuser;
    }

    public function setFeuser(?int $feuser): void
    {
        $this->feuser = $feuser;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    public function getPoll(): ?\Emagineurs\EPoll\Domain\Model\Poll
    {
        $options = $this->options->toArray();
        foreach ($options as $option) {
            if(!empty($option->getPoll())) {
                return $option->getPoll();
            }
        }

        return null;
    }

    public function getCrdate(): int
    {
        return $this->crdate;
    }

    public function setCrdate(int $crdate): void
    {
        $this->crdate = $crdate;
    }
}