<?php

namespace Emagineurs\EGmap\Lib;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Ian SEBBAGH <isebbagh@e-magineurs.com>, E-magineurs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Emagineurs\EGmap\Domain\Repository\PoiRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;

/**
 *
 *
 * @package e_gmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ELib
{
    public static function initAjax($id = null)
    {
        #INIT TSFE
        if (!$id) {
            $id = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id');
        }
        $id = intval($id);
        $GLOBALS['TSFE'] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            'TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController',
            $GLOBALS['TYPO3_CONF_VARS'],
            $id,
            0
        );
        \TYPO3\CMS\Frontend\Utility\EidUtility::initLanguage();
        \TYPO3\CMS\Frontend\Utility\EidUtility::initTCA();
        $GLOBALS['TSFE']->initFEuser();
        $GLOBALS['TSFE']->set_no_cache();
        $GLOBALS['TSFE']->checkAlternativeIdMethods();
        $GLOBALS['TSFE']->determineId();
        $GLOBALS['TSFE']->initTemplate();
        $GLOBALS['TSFE']->getConfigArray();
        $GLOBALS['TSFE']->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
        $GLOBALS['TSFE']->settingLanguage();
        $GLOBALS['TSFE']->settingLocale();
        \TYPO3\CMS\Frontend\Page\PageGenerator::pagegenInit();
        return $GLOBALS['TSFE'];
    }

    public static function callExtbaseAction($conf)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $request = $objectManager->get('TYPO3\CMS\Extbase\Mvc\Web\Request');
        $request->setcontrollerExtensionName($conf['extensionName']);
        if (!empty($conf['pluginName'])) {
            $request->setPluginName($conf['pluginName']);
        }
        $request->setControllerVendorName($conf['vendor']);
        $request->setControllerName($conf['controller']);
        $request->setControllerActionName($conf['action']);
        $request->setArguments($conf['arguments']);

        $response = $objectManager->get('TYPO3\CMS\Extbase\Mvc\ResponseInterface');
        $dispatcher = $objectManager->get('TYPO3\CMS\Extbase\Mvc\Dispatcher');
        $dispatcher->dispatch($request, $response);
        $content = $response->getContent();
        return $content;
    }

    public static function getRecord($table, $uid, $where = '', $order = '')
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder->select('*');
        
        if ($uid > 0 && empty($where)) {
            $queryBuilder->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int)$uid, Connection::PARAM_INT))
            );
        } elseif (!empty($where)) {
            $queryBuilder->where($where);
        }
        
        if (!empty($order)) {
            $orderParts = explode(' ', trim($order));
            $orderField = $orderParts[0];
            $orderDirection = isset($orderParts[1]) && strtoupper($orderParts[1]) === 'DESC' 
                ? \TYPO3\CMS\Core\Database\Query\QueryBuilder::ORDER_DESCENDING 
                : \TYPO3\CMS\Core\Database\Query\QueryBuilder::ORDER_ASCENDING;
            $queryBuilder->orderBy($orderField, $orderDirection);
        }
        
        $queryBuilder->setMaxResults(1);
        $statement = $queryBuilder->executeQuery();
        $res = $statement->fetchAssociative();

        if ($res !== false) {
            return $res;
        }
        return false;
    }

    public static function getListTables()
    {
        $listFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('e_gmap') . 'Configuration/ListExt/extlist';
        $content = self::readAFile($listFile);
        return unserialize($content);
    }

    public static function readAFile($file)
    {
        return \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($file);
    }

    public static function getRepositoryForTable($table, $id = 0)
    {
        if ($table == 'tx_egmap_domain_model_poi') {
            return GeneralUtility::makeInstance(PoiRepository::class);
        }

        if ($id == 0) {
            $id = $GLOBALS['TSFE']->id;
        }

        $confTS = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($id);
        $confTS = $confTS['tx_egmap_conf.'];
       
      

        if (is_array($confTS['extensions.'])) {
            
            foreach ($confTS['extensions.'] as $key => $conf) {
                if ($conf['table'] == $table) {
                    $keyUCF = ucfirst(strtolower(substr($key, 0, -1)));
                    $otherRepository = GeneralUtility::makeInstance('Emagineurs\EGmap\Domain\Repository\\' . $keyUCF . 'Repository');
                    $catField = (!empty($conf['cat'])) ? $conf['cat'] : false;
                    $otherRepository->setSettings(array(), $catField);
                    return $otherRepository;
                }
            }
        }
    }

    public static function getLL($label)
    {
        if (substr($label, 0, 7) != 'LLL:EXT') {
            $label = 'LLL:EXT:e_gmap/Resources/Private/Language/locallang.xlf:' . $label;
        }
        return $GLOBALS['LANG']->sL($label);
    }
}
