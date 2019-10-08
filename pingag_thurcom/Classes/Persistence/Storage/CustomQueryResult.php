<?php

namespace Pingag\PingagClicConnector\Persistence\Storage;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 12.09.2017
 * Time: 10:47
 */
class CustomQueryResult extends \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult {

    /**
     * @var \Pingag\Pingag\Persistence\Storage\CustomDataMapper
     * @inject
     */
    protected $dataMapper;
}