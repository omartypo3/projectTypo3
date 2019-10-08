<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 22.08.2017
 * Time: 14:10
 */

namespace Pingag\PingagThurcom\Domain\Model;


use Pingag\PingagThurcom\Domain\Model\Traits\ManyToManyTrait;

class ServiceOption extends BaseEntity
{

    const DEFAULT_STATE = 0;

    use ManyToManyTrait;

    /**
     * @var \Pingag\PingagThurcom\Domain\Model\Service
     */
    protected $service;

    /**
     * @var string
     */
    protected $state;

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param Service $service
     * @return $this
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
}