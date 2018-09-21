<?php

namespace Wng\WngCvciNews\Hooks;

class FlexFormHook
{
    /**
     * @param array $dataStructArray
     * @param array $conf
     * @param array $row
     * @param string $table
     */
    public function getFlexFormDS_postProcessDS(&$dataStructArray, $conf, $row, $table)
    {
        if ($table === 'tt_content' && $row['CType'] === 'list' && $row['list_type'] === 'news_pi1') {
            $dataStructArray['sheets']['extraEntry'] = 'typo3conf/ext/wng_cvci_news/Configuration/FlexForms/flexform_wng_cvci_news.xml';
        }
    }
}