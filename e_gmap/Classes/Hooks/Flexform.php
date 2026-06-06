<?php

namespace Emagineurs\EGmap\Hooks;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
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

class Flexform
{

    public static function getSingleField_beforeRender($table, $field, $row, &$PA)
    {
        if ($table == 'tt_content' && $field == 'pi_flexform' && $PA['fieldConf']['config']['form_type'] == 'group' && !empty($PA['fieldConf']['config']['allowedProcFunc'])) {
            $myitems = $PA['fieldConf']['config']['allowedProcFunc']();
            $PA['fieldConf']['config']['allowed'] = implode(',', $myitems);
        }
    }

    public static function getAllPoisTabs()
    {
        $res = array();
        $res[] = 'tx_egmap_domain_model_poi';
        $res[] = 'tx_egmap_domain_model_kml';
        $res[] = 'sys_category';
        $res[] = 'pages';

        $listFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('e_gmap') . 'Configuration/ListExt/extlist';
        $liste = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($listFile);
        if (!empty($liste)) {
            $liste = unserialize($liste);
            if (is_array($liste)) {
                foreach ($liste as $table => $value) {
                    if (!in_array($table, $res)) {
                        $res[] = $table;
                    }
                }
            }
        }

        return $res;
    }

    public static function getPoisTabs()
    {
        $res = array();
        $res[] = 'tx_egmap_domain_model_poi';

        $listFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('e_gmap') . 'Configuration/ListExt/extlist';
        $liste = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($listFile);
        if (!empty($liste)) {
            $liste = unserialize($liste);
            if (is_array($liste)) {
                foreach ($liste as $table => $value) {
                    if (!in_array($table, $res)) {
                        $res[] = $table;
                    }
                }
            }
        }

        return $res;
    }
}