<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 11.09.2017
 * Time: 10:00
 */

namespace Pingag\PingagThurcom\Domain\Model;


interface ProductInterface
{
    /** @var string */
    public function getTitle();
    /** @var int */
    public function getPrice();
}