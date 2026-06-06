<?php

namespace Emagineurs\EGmap\Hooks;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2018 Xavier LEY <xley@e-magineurs.com>, E-magineurs
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

class Tca
{

    public function includeGmapFields($tca) {		
        /** Ajout surcharges tables **/
        $listFile = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('e_gmap') . 'Configuration/ListExt/extlist';
        $liste = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($listFile);
        if (!empty($liste)) {
            $liste = unserialize($liste);
            if (is_array($liste)) {
                foreach ($liste as $table => $key) {
                    // $this->addTcaToTable($table);
					$egmapFields = $this->addTcaToTable($table);
                    $oldConf = $tca[$table]['columns'];			
					
					$newConf = array_merge_recursive($egmapFields, $oldConf);
					
					$tca[$table]['columns'] = $newConf;
					
					$typeArray = $tca[$table]['types'];
					foreach($typeArray as $key => $currentType) {
						$tca[$table]['types'][$key]['showitem'] = $currentType['showitem'].',--div--;LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:surcharge.tab,poi,lat,lng,picto';
					}
                }
            }
        }
			
		return [$tca];
    }

    public function addTcaToTable($table)
    {
        $tempColumns = Array(
            'poi' => array(
                'exclude' => 1,
                'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:surcharge.poi',
                'config' => array(
                    'type' => 'group',
                    'internal_type' => 'db',
                    'allowed' => 'tx_egmap_domain_model_poi',
                    'foreign_table' => 'tx_egmap_domain_model_poi',
                    'size' => 5,
                    'minitems' => 0,
                    'maxitems' => 100,
                    'wizards' => array(
                        'suggest' => array(
                            'type' => 'suggest',
                        ),
                    ),
                )
            ),
            'lat' => array(
                'exclude' => 1,
                'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:surcharge.lat',
                'config' => array(
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                    'wizards' => array(
                        '_PADDING' => 2,
                        'map' => array(
                            'type' => 'popup',
                            'title' => 'Choisir centre',
                            'icon' => 'EXT:e_gmap/Resources/Public/Icons/localize.png',
                            'module' => array(
                                'name' => 'choosePoi'
                            ),
                            'JSopenParams' => 'width=800,height=600,status=0,menubar=0,scrollbars=0'
                        )
                    )
                ),
            ),
            'lng' => array(
                'exclude' => 1,
                'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:surcharge.lng',
                'config' => array(
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                    'wizards' => array(
                        '_PADDING' => 2,
                        'map' => array(
                            'type' => 'popup',
                            'title' => 'Choisir centre',
                            'icon' => 'EXT:e_gmap/Resources/Public/Icons/localize.png',
                            'module' => array(
                                'name' => 'choosePoi'
                            ),
                            'JSopenParams' => 'width=800,height=600,status=0,menubar=0,scrollbars=0'
                        )
                    )
                ),
            ),
            'picto' => array(
                'exclude' => 1,
                'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:surcharge.picto',
                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                    'picto',
                    array('maxitems' => 1),
                    $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
                ),
            ),
        );

		return $tempColumns;
        // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns($table, $tempColumns);
    }
}