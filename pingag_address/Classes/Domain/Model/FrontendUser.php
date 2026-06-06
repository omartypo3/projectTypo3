<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Pingag\PingagAddress\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * A Frontend User
 *
 * @deprecated since v11, will be removed in v12. Do not use or extend this model.
 */
class FrontendUser extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{
    /**
     * @var string
     */
    protected $addressid = '';

    /**
     * Sets the addressid value
     *
     * @param string $addressid
     */
    public function setAddressid($addressid)
    {
        $this->addressid = $addressid;
    }

    /**
     * Returns the addressid value
     *
     * @return string
     */
    public function getAddressid()
    {
        return $this->addressid;
    }


}
