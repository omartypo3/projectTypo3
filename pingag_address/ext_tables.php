<?php
defined('TYPO3') || die();
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
$_LLL_db = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_db.xlf:';


(static function() {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_map', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_map.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_map');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_language', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_language.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_language');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_techniques', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_techniques.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_techniques');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_languageoral', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_languageoral.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_languageoral');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_languagewritten', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_languagewritten.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_languagewritten');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_techniqueslevel', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_techniqueslevel.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_techniqueslevel');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_spezielle', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_spezielle.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_spezielle');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_available', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_available.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_available');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_placeofuse', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_placeofuse.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_placeofuse');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_level', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_level.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_level');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_gehoerlos', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_gehoerlos.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_gehoerlos');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_lebensalter', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_lebensalter.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_lebensalter');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_angebote', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_angebote.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_angebote');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_infouser', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_infouser.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_infouser');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pingagaddress_domain_model_weiterestandorte', 'EXT:pingag_address/Resources/Private/Language/locallang_csh_tx_pingagaddress_domain_model_weiterestandorte.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pingagaddress_domain_model_weiterestandorte');
})();


ExtensionManagementUtility::makeCategorizable(
    'cart_products',
    'tx_cartproducts_domain_model_product_product',
    'category',
    array(
        'label' => $_LLL_db . 'tx_cartproducts_domain_model_product_product.category',
        'fieldConfiguration' => array(
            'foreign_table_where' => ' AND sys_category.sys_language_uid '
                . 'IN (0, -1) ORDER BY sys_category.title ASC'
        ),
    ),
    true
);
