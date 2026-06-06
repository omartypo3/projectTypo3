<?php
defined('TYPO3') or die();

call_user_func(function() {
    /**
     * Plugin: Render social networks login buttons
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'stratis_social_auth',
        'Pi1',
        'LLL:EXT:stratis_social_auth/Resources/Private/Language/locallang_be.xlf:pi1_title',
        'stratis-socialauth-account'
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['stratissocialauth_pi1'] = 'select_key,pages,recursive';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['stratissocialauth_pi1'] = 'pi_flexform';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        'stratissocialauth_pi1',
        'FILE:EXT:' . 'stratis_social_auth' . '/Configuration/FlexForms/flexform_pi1.xml'
    );

    /**
     * Plugin: Render social networks bind buttons
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'stratis_social_auth',
        'Pi2',
        'LLL:EXT:stratis_social_auth/Resources/Private/Language/locallang_be.xlf:pi2_title',
        'stratis-socialauth-account'
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['stratissocialauth_pi2'] = 'select_key,pages,recursive';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['stratissocialauth_pi2'] = 'pi_flexform';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        'stratissocialauth_pi2',
        'FILE:EXT:' . 'stratis_social_auth' . '/Configuration/FlexForms/flexform_pi2.xml'
    );
});
