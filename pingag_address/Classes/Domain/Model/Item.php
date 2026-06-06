<?php

namespace Pingag\PingagAddress\Domain\Model;

/*
 * This file is part of the package extcode/cart.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Property\Exception\ResetPropertyException;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Item extends \Extcode\Cart\Domain\Model\Order\Item
{
    /**
     * @var bool
     */
    protected $donation = false;

    /**
     * @var string
     */
    protected $entendu = '';

    /**
     * @return bool
     */
    public function getDonation(): bool
    {
        return $this->donation;
    }

    /**
     * @param bool $donation
     */
    public function setDonation(bool $donation)
    {
        $this->donation = $donation;
    }

    /**
     * @return string
     */
    public function getEntendu(): string
    {
        return $this->entendu;
    }

    /**
     * @param string $entendu
     */
    public function setEntendu(string $entendu)
    {
        $this->entendu = $entendu;
    }

}
