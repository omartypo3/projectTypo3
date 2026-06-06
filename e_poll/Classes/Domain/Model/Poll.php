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
class Poll extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * fegroup
     *
     * @var int
     */
    protected $fegroup = 0;

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\File|null
     */
    protected $image = null;

    /**
     * question
     *
     * @var string
     */
    protected $question = '';

    /**
     * explanation
     *
     * @var string
     */
    protected $explanation = '';

    /**
     * options
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Emagineurs\EPoll\Domain\Model\Option>
     */
    protected $options;

    /**
     * categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories;

    /**
     * multiplechoice
     *
     * @var boolean
     */
    protected $multiplechoice = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getFegroup(): ?int
    {
        return $this->fegroup;
    }

    public function setFegroup(?int $fegroup): void
    {
        $this->fegroup = $fegroup;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getQuestion(): ?string
    {
        return $this->question ?? '';
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation ?? '';
    }

    public function setExplanation(string $explanation): void
    {
        $this->explanation = $explanation;
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

    public function isMultiplechoice(): bool
    {
        return $this->multiplechoice;
    }

    public function setMultiplechoice(bool $multiplechoice): void
    {
        $this->multiplechoice = $multiplechoice;
    }

    public function getTotalVotes(): int
    {
        $total = 0;

        foreach($this->options->toArray() as $option) {
            $total += $option->getVotes()->count();
        }

        return $total;
    }

    public function hasAlreadyVoted(string $verificationType, int $verificationPeriod): bool
    {
        if($verificationType == 'cookie') {
            return isset($_COOKIE['t3_tx_epoll_' . $this->getUid()]);
        } else {
            foreach($this->getOptions()->toArray() as $option) {
                foreach($option->getVotes()->toArray() as $vote) {
                    if($vote->getIp() == ($_SERVER['REMOTE_ADDR'] ?? '') && $vote->getCrdate() + $verificationPeriod > time()) {
                        return true;
                    }
                }
            }

            return false;
        }
    }
    
    public function getCategories(): \TYPO3\CMS\Extbase\Persistence\ObjectStorage
    {
        if ($this->categories === null) {
            $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        }
        return $this->categories;
    }

    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }
}