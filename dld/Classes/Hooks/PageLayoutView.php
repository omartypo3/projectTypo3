<?php

namespace DLD\Dld\Hooks;

class PageLayoutView implements \TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface
{

    public function preProcess(\TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row)
    {
        if ($row['CType'] == 'list' && $row['list_type'] == 'dld_dldevent') {

            $drawItem = false;

            $linkStart = '<a href="#" onclick="window.location.href=\'../../../alt_doc.php?returnUrl=%2Ftypo3%2Fsysext%2Fcms%2Flayout%2Fdb_layout.php%3Fid%3D' . $row['pid'] . '&amp;edit[tt_content][' . $row['uid'] . ']=edit\'; return false;" title="Edit">';
            $linkEnd = '</a>';


            $headerContent =
                $linkStart .
                "<strong>" . str_replace('dld_', '', $row['list_type']) . "</strong><br/>" .
                $linkEnd;


            $ffXml = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($row['pi_flexform']);

            $action = $ffXml['data']['sDEF']['lDEF']['switchableControllerActions']['vDEF'];

            $file = file_get_contents(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dld/Configuration/FlexForms/flexform_dldEvent.xml'));
            $flexarray = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($file);
            $flexitems = $flexarray['sheets']['sDEF']['ROOT']['el']['switchableControllerActions']['TCEforms']['config']['items'];

            foreach ($flexitems as $value) {
                if ($value[1] == $action) {
                    $action = $value[0];
                    break;
                }

            }
            $itemContent =
                $linkStart .
                $action .
                $linkEnd;
        }

        if ($row['CType'] == 'list' && $row['list_type'] == 'dld_dldfront') {

            $drawItem = false;

            $linkStart = '<a href="#" onclick="window.location.href=\'../../../alt_doc.php?returnUrl=%2Ftypo3%2Fsysext%2Fcms%2Flayout%2Fdb_layout.php%3Fid%3D' . $row['pid'] . '&amp;edit[tt_content][' . $row['uid'] . ']=edit\'; return false;" title="Edit">';
            $linkEnd = '</a>';


            $headerContent =
                $linkStart .
                "<strong>" . str_replace('dld_', '', $row['list_type']) . "</strong><br/>" .
                $linkEnd;


            $ffXml = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($row['pi_flexform']);

            $action = $ffXml['data']['sDEF']['lDEF']['switchableControllerActions']['vDEF'];

            $file = file_get_contents(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:dld/Configuration/FlexForms/flexform_dldfront.xml'));
            $flexarray = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($file);
            $flexitems = $flexarray['sheets']['sDEF']['ROOT']['el']['switchableControllerActions']['TCEforms']['config']['items'];

            foreach ($flexitems as $value) {
                if ($value[1] == $action) {
                    $action = $value[0];
                    break;
                }

            }
            $itemContent =
                $linkStart .
                $action .
                $linkEnd;
        }
    }

}
