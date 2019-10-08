<?php

namespace Pingag\PingagThurcom\Domain\Model\Traits;


trait ManyToManyTrait
{
    /**
     * @var string
     */
    protected $foreignTable;

    /**
     * @var int
     */
    protected $foreignUid;

    /**
     * @return string
     */
    public function getForeignTable()
    {
        return $this->foreignTable;
    }

    /**
     * @param string $foreignTable
     * @return $this
     */
    public function setForeignTable($foreignTable)
    {
        $this->foreignTable = $foreignTable;
        return $this;
    }

    /**
     * @return int
     */
    public function getForeignUid()
    {
        return $this->foreignUid;
    }

    /**
     * @param int $foreignUid
     * @return $this
     */
    public function setForeignUid($foreignUid)
    {
        $this->foreignUid = $foreignUid;
        return $this;
    }
}