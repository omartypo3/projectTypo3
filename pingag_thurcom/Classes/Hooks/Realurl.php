<?php


namespace Pingag\PingagThurcom\Hooks;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 03.04.2017
 * Time: 10:26
 */
class Realurl
{

    protected function tablename($name)
    {
        return 'tx_pingagthurcom_domain_model_' . $name;
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
                'fixedPostVars' => array(
                    //Product Detail
                    'productDetailConfig' => array(
                        self::getTableLookup('product', 'object', 'product'),
                        self::disableController('product'),
                        self::disableAction('product'),
                    ),
                    '55' => 'productDetailConfig',

                    'serviceLocationConfig' => array(
                        self::disableController('product'),
                    ),
                ),
                'preVars' =>
                    array(
                        0 =>
                            array(
                                'GETvar' => 'L',
                                'valueMap' =>
                                    array(
                                        'fr' => '1',
                                    ),
                                'noMatch' => 'bypass',
                            ),
                    ),
            )
        );
    }

    /**
     * @param $plugin
     * @param $var
     * @param $tableSuffix
     * @param string $fieldName
     * @param bool $required
     * @return array
     */
    protected static function getTableLookup($plugin, $var, $tableSuffix, $fieldName = 'title', $required = true)
    {
        $array = [
            'GETvar' => self::getVar($plugin, $var),
            'lookUpTable' => array(
                'table' => self::table($tableSuffix),
                'id_field' => 'uid',
                'alias_field' => $fieldName,
                'addWhereClause' => ' AND NOT deleted',
                'useUniqueCache' => 1,
                'useUniqueCache_conf' => array(
                    'strtolower' => 1,
                ),
            )
        ];

        if (!$required): $array['noMatch'] = 'bypass'; endif;

        return $array;
    }

    protected function disableController($plugin)
    {
        return [
            'GETvar' => self::getVar($plugin, 'controller'),
            'valueMap' => array(),
            'noMatch' => 'bypass'
        ];
    }

    protected function disableAction($plugin)
    {
        return [
            'GETvar' => self::getVar($plugin, 'action'),
            'valueMap' => array(),
            'noMatch' => 'bypass'
        ];
    }

    protected static function getVar($plugin, $var)
    {
        return sprintf('tx_pingagthurcom_%s[%s]', $plugin, $var);
    }

    protected static function table($name)
    {
        return 'tx_pingagthurcom_domain_model_' . $name;
    }

}