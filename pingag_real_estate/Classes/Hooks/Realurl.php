<?php


namespace Pingag\PingagRealEstate\Hooks;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 03.04.2017
 * Time: 10:26
 */
class Realurl
{

    /**
     * Generates additional RealURL configuration and merges it with provided configuration
     *
     * @param array $params Default configuration
     * @param tx_realurl_autoconfgen $pObjParent object
     * @return array Updated configuration
     */
    function addConfig($params, &$pObjParent)
    {
        return array_merge_recursive(
            $params['config'],
            array(
                'postVarSets' => array(
                    '_DEFAULT' => array(
                        'realEstate' => array(
                            [
                                'GETvar' => 'tx_pingagrealestate_show[realEstate]',
                                'lookUpTable' => [
                                    'table' => 'tx_pingag_real_estate',
                                    'id_field' => 'uid',
                                    //'alias_field' => 'object_title',
									'alias_field' => 'CONCAT(object_title, "-", object_city)',
                                    'useUniqueCache' => 1,
                                    'useUniqueCache_conf' => [
                                        'strtolower' => 1,
                                        'spaceCharacter' => '-',
                                    ],
                                ],
                            ],
                            [
                                'GETvar' => 'tx_pingagrealestate_show[controller]',
                                'noMatch' => 'bypass'
                            ],
                            [
                                'GETvar' => 'tx_pingagrealestate_show[action]',
                                'noMatch' => 'bypass'
                            ],
                        ),
                    ),
                ),
            )
        );
    }

}