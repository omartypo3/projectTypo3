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
class BePoiList
{
    public function getContent($pobj)
    {
        $this->init($pobj);
        if ($this->pageId === false) {
            return $this->noConf();
        }

        $tree = $this->getTree();
        $list = $this->getElementList();

        $content = '
		<table border="0" cellpadding="0" cellspacing="0" id="typo3-linkPages">
			<tr>
				<td class="c-wCell" valign="top">
					<h3>' . htmlspecialchars($this->getLL('tree')) . '</h3>'
            . $tree .
            '</td>
				<td class="c-wCell" valign="top">
					<h3>' . htmlspecialchars($this->getLL('list')) . '</h3>' .
            $list .
            '</td>
			</tr>
		</table>
				';
        return $content;
    }

    public function init($pobj)
    {
        $this->pobj = $pobj;
        $this->conf = $pobj->configuration;
        $this->expandPage = intval(GeneralUtility::_GP('expandPage'));
        $this->allowedTables = \Emagineurs\EGmap\Hooks\Flexform::getAllPoisTabs();
        $this->pageId = false;
        if (!empty($this->conf['pageId'])) {
            $this->pageId = intval($this->conf['pageId']);
        }
        $this->gmapLinkBase = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . '?id=' . $this->pageId . '&tx_egmap_gmap[pois]=';
    }

    public function noConf()
    {
        return '<div class="typo3-message message-error">
			<div class="message-body">
				' . $this->getLL('noconf') .
            serialize($this->conf) . '
			</div>
		</div>
		<br>
		<br>';
    }

    public function getLL($label)
    {
        return $GLOBALS['LANG']->sL('LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:linkHandler.' . $label);
    }

    public function getTree()
    {
        $pageTree = GeneralUtility::makeInstance(\Emagineurs\EGmap\Lib\ElementBrowserPageTreeView::class);
        $pageTree->setLinkParameterProvider($this->pobj);
        $pageTree->ext_showPageId = $GLOBALS['BE_USER']->getTSConfigVal('options.pageTree.showPageIdWithTitle');
        $pageTree->ext_showNavTitle = $GLOBALS['BE_USER']->getTSConfigVal('options.pageTree.showNavTitle');
        $pageTree->addField('nav_title');
        return $pageTree->getBrowsableTree();
    }

    public function getElementList()
    {
        $content = $this->getListEntete();
        $dbList = GeneralUtility::makeInstance(\Emagineurs\EGmap\Lib\LinkRecordList::class);
        $dbList->gmapLinkBase = $this->gmapLinkBase;
        $dbList->thumbs = 0;
        $dbList->calcPerms = $GLOBALS['BE_USER']->calcPerms(
            BackendUtility::readPageAccess($this->expandPage,
                $GLOBALS['BE_USER']->getPagePermsClause(1)
            )
        );
        $dbList->noControlPanels = 1;
        $dbList->clickMenuEnabled = 0;
        $dbList->dontShowClipControlPanels = 1;
        $dbList->tableList = implode(',', $this->allowedTables);
        $dbList->start($this->expandPage,
            GeneralUtility::_GP('table'),
            GeneralUtility::_GP('pointer'),
            GeneralUtility::_GP('search_field'),
            GeneralUtility::_GP('search_levels'),
            GeneralUtility::_GP('showLimit')
        );
        $dbList->setDispFields();
        $dbList->generateList();
        $content .= $dbList->HTMLcode;
        $content .= $dbList->getSearchBox();
        return $content;
    }

    public function getListEntete()
    {
        $titleLen = (int)$GLOBALS['BE_USER']->uc['titleLen'];
        $mainPageRec = BackendUtility::getRecordWSOL('pages', $this->expandPage);
        $ATag = $ATag_e = $ATag2 = $picon = '';
        if (is_array($mainPageRec)) {
            $picon = IconUtility::getSpriteIconForRecord('pages', $mainPageRec);
            if (in_array('pages', $this->allowedTables)) {
                $aHref = '<a href="' . $this->gmapLinkBase . '" class="GmapLink" data-identifier="pages_' . $mainPageRec['uid'] . '" >';
                $aClose = '</a>';
            }
        }
        $pText = htmlspecialchars(GeneralUtility::fixed_lgd_cs($mainPageRec['title'], $titleLen));
        return $picon . $aHref . $pText . $aClose . '<br />';
    }
}