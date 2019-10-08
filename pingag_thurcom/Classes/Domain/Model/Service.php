<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 22.08.2017
 * Time: 14:51
 */

namespace Pingag\PingagThurcom\Domain\Model;


use Pingag\PingagThurcom\Domain\Model\Traits\ManyToManyTrait;

class Service extends BaseProduct implements ProductInterface
{
    use ManyToManyTrait;

    public function __toString()
    {
        return (string)$this->getTitle();
    }
}