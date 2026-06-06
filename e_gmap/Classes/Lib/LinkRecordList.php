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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\Utility\IconUtility;

/**
 *
 *
 * @package e_gmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class LinkRecordList extends \TYPO3\CMS\Recordlist\RecordList\DatabaseRecordList
{

    public function listURL($altId = '', $table = '-1', $exclList = '')
    {
        return BackendUtility::getModuleUrl(GeneralUtility::_GP('M'), GeneralUtility::_GET());
    }

    public function linkWrapItems($table, $uid, $code, $row)
    {
        if (!$code) {
            $code = '<i>[' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xlf:labels.no_title', true) . ']</i>';
        } else {
            $code = BackendUtility::getRecordTitlePrep($code, $this->fixedL);
        }
        $aHref = '<a href="' . $this->gmapLinkBase . '" class="GmapLink" data-identifier="' . $table . '_' . $uid . '" >';
        $aClose = '</a>';

        return $aHref . $code . $aClose;
    }

}
