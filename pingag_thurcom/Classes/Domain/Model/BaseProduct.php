<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 11.09.2017
 * Time: 10:06
 */

namespace Pingag\PingagThurcom\Domain\Model;

abstract class BaseProduct extends BaseEntity
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $price;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
}