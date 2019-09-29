<?php

namespace Pingag\PingagJobs\Hooks;
use Pingag\PingagJobs\Api\VacancyApi;
use Pingag\PingagJobs\ViewHelpers\FormatForUrlViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 03.04.2017
 * Time: 10:26
 */
class Realurl
{

    protected static function table($name)
    {
        return 'tx_pingag_clic_connector_' . $name;
    }

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
                    '_DEFAULT' => [
                        'show' => [
                            [
                                'GETvar' => 'tx_pingagjobs_show[vacancy]',
                                'lookUpTable' => [
                                    'table' => 'tx_pingag_jobs_domain_model_vacancy',
                                    'id_field' => 'uid',
                                    'alias_field' => "CONCAT(title, ' ', uid)",
                                    'useUniqueCache' => 1,
                                    'useUniqueCache_conf' => [
                                        'strtolower' => 1,
                                        'spaceCharacter' => '-',
                                    ],
                                ],
                            ],
                            [
                                'GETvar' => 'tx_pingagjobs_show[action]',
                                'valueMap' => array(
                                    'detail' => '',
                                ),
                                'noMatch' => 'bypass'
                            ],
                            [
                                'GETvar' => 'tx_pingagjobs_show[controller]',
                                'valueMap' => array(
                                    'detail' => '',
                                ),
                                'noMatch' => 'bypass'
                            ],
                        ],
                    ],
                )
            )
        );
    }
    
    protected function encodeTitle_userProc()
    {
        
    }

}