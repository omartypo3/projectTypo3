<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Model;


/**
 * This file is part of the "pingag_znews" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 
 */


/**

 * News

 */
class News extends \GeorgRinger\News\Domain\Model\News
{


    /**
     * title2
     *
     * @var string
     */
    protected $title2 = '';

    /**
     * Returns the title2
     *
     * @return string $title2
     */
    public function getTitle2() {
        return $this->title2;
    }

    /**
     * Sets the title2
     *
     * @param string $title2
     * @return void
     */
    public function setTitle2($title2) {
        $this->title2 = $title2;
    }


}
