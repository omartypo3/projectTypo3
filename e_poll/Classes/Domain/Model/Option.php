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
class Option extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\File|null
     */
    protected $image = null;

    /**
     * poll
     *
     * @var \Emagineurs\EPoll\Domain\Model\Poll|null
     */
    protected $poll = null;

    /**
     * votes
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EPoll\Domain\Model\Vote>
     */
    protected $votes;

    /**
     */
    public function __construct()
    {
        $this->votes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getPoll(): ?\Emagineurs\EPoll\Domain\Model\Poll
    {
        return $this->poll;
    }

    public function setPoll(\Emagineurs\EPoll\Domain\Model\Poll $poll): void
    {
        $this->poll = $poll;
    }

    public function getVotes(): \TYPO3\CMS\Extbase\Persistence\ObjectStorage
    {
        if ($this->votes === null) {
            $this->votes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        }
        return $this->votes;
    }

    public function setVotes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $votes): void
    {
        $this->votes = $votes;
    }

    public function getVotesPercent(): float
    {
        $totalVotes = $this->poll->getTotalVotes();
        if ($totalVotes === 0) {
            return 0.0;
        }
        return (float)$this->votes->count() / (float)$totalVotes * 100.0;
    }
}