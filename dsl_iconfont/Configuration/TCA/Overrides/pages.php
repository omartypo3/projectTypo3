<?php



/*

 * This file is part of the package bk2k/bootstrap-package.

 *

 * For the full copyright and license information, please read the

 * LICENSE file that was distributed with this source code.

 */



defined('TYPO3_MODE') || die();



/***************

 * Temporary variables

 */

$extensionKey = 'dsl_iconfont';



/***************

 * Register PageTS

 */

// TtContent Previews

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/TypoScript/pageTSConfig.ts',
    'Dsl Iconfont: Erweiterung der Ion Icons vom Bootstrap Package - DSL'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/TypoScript/pageTSConfigBhs.ts',
    'Dsl Iconfont: Erweiterung der Ion Icons vom Bootstrap Package - BHS'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/TypoScript/pageTSConfigHermes.ts',
    'Dsl Iconfont: Erweiterung der Ion Icons vom Bootstrap Package - Hermes'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/TypoScript/pageTSConfigWewobau.ts',
    'Dsl Iconfont: Erweiterung der Ion Icons vom Bootstrap Package - Wewobau'
);
