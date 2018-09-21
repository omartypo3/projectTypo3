<?php
use TYPO3\CMS\Core\Utility\GeneralUtility;
class user_pageNotFound {
    /**
     * Detect language and redirect to 404 error page
     *
     * @param array $params "currentUrl", "reasonText" and "pageAccessFailureReasons"
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $tsfeObj
     */
    public function pageNotFound($params, $tsfeObj) {
        /*
         * If a non-existing page with a RealURL path was requested (www.mydomain.tld/foobar), a fe_group value for an empty
         * key is set:
         * $params['pageAccessFailureReasons']['fe_group'][null] = 0;
         * This is the reason why the second check was implemented.
         */
            // handle default language
            $tsfeObj->pageErrorHandler('/index.php?id=475');

    }
    /**
     * Initializes a TypoScript Frontend necessary for using TypoScript and TypoLink functions
     *
     * @param int $id
     * @param int $typeNum
     */
    protected function initTSFE($id = 1, $typeNum = 0) {
        \TYPO3\CMS\Frontend\Utility\EidUtility::initTCA();
        if (!is_object($GLOBALS['TT'])) {
            $GLOBALS['TT'] = new \TYPO3\CMS\Core\TimeTracker\NullTimeTracker;
            $GLOBALS['TT']->start();
        }
        $GLOBALS['TSFE'] = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController',  $GLOBALS['TYPO3_CONF_VARS'], $id, $typeNum);
        $GLOBALS['TSFE']->sys_page = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
        $GLOBALS['TSFE']->sys_page->init(TRUE);
        $GLOBALS['TSFE']->connectToDB();
        $GLOBALS['TSFE']->initFEuser();
        $GLOBALS['TSFE']->determineId();
        $GLOBALS['TSFE']->initTemplate();
        $GLOBALS['TSFE']->rootLine = $GLOBALS['TSFE']->sys_page->getRootLine($id, '');
        $GLOBALS['TSFE']->getConfigArray();
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
            $rootline = \TYPO3\CMS\Backend\Utility\BackendUtility::BEgetRootLine($id);
            $host = \TYPO3\CMS\Backend\Utility\BackendUtility::firstDomainRecord($rootline);
            $_SERVER['HTTP_HOST'] = $host;
        }
    }
}