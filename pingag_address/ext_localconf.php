<?php
defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['FriendsOfTYPO3\\TtAddress\\Domain\\Repository\\AddressRepository'] = array(
    'className' => 'Pingag\\PingagAddress\\Domain\\Repository\\AddressRepository'
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['FriendsOfTYPO3\\TtAddress\\Domain\\Repository\\AddressRepository'] = array(
    'className' => 'Pingag\\PingagAddress\\Domain\\Repository\\AddressPersonRepository'
);


$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository'] = array(
    'className' => 'Pingag\\PingagAddress\\Domain\\Repository\\FrontendUserRepository'
);


$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['DERHANSEN\\SfEventMgt\\Controller\\EventController'] = array(
    'className' => 'Pingag\\PingagAddress\\Controller\\EventController'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['DERHANSEN\\SfEventMgt\\Domain\\Repository\\RegistrationRepository'] = array(
    'className' => 'Pingag\\PingagAddress\\Domain\\Repository\\RegistrationRepository'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['DERHANSEN\\SfEventMgt\\Domain\\Repository\\EventRepository'] = array(
    'className' => 'Pingag\\PingagAddress\\Domain\\Repository\\EventRepository'
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['WapplerSystems\\Cleverreach\\Powermail\\Finisher\\CleverReach'] = array(
    'className' => 'Pingag\\PingagAddress\\Powermail\\Finisher\\CleverReach'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Extcode\\Cart\\Service\\MailHandler'] = array(
    'className' => 'Pingag\\PingagAddress\\Service\\MailHandler'
);
#$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Extcode\\Cart\\Controller\\Cart\\OrderController'] = array(
    #'className' => 'Pingag\\PingagAddress\\Controller\\OrderController'
#);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['In2code\\Powermail\\Controller\\FormController'] = array(
    'className' => 'Pingag\\PingagAddress\\Controller\\FormController'
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['In2code\\Powermail\\\Domain\\Repository\\FormRepository'] = array(
    'className' => 'Pingag\\PingagAddress\\\Domain\\Repository\\FormRepository'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['In2code\\Powermail\\\Domain\\Repository\\FieldRepository'] = array(
    'className' => 'Pingag\\PingagAddress\\\Domain\\Repository\\FieldRepository'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['In2code\\Powermail\\\Domain\\Repository\\PageRepository'] = array(
    'className' => 'Pingag\\PingagAddress\\\Domain\\Repository\\PageRepository'
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Extcode\\CartProducts\\Controller\\ProductController'] = array(
    'className' => 'Pingag\\PingagAddress\\Controller\\ProductController'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Extcode\\CartProducts\\Controller\\ProductController'] = array(
    'className' => 'Pingag\\PingagAddress\\Controller\\ProductController'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Tpwd\\KeSearch\\Indexer\\Types\\Page'] = array(
    'className' => 'Pingag\\PingagAddress\\Indexer\\Types\\Page'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['In2code\\Powermail\\Domain\\Service\\Mail\\SendOptinConfirmationMailPreflight'] = array(
    'className' => 'Pingag\\PingagAddress\\Domain\\Service\\Mail\\SendOptinConfirmationMailPreflight'
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['In2code\\Powermail\\Domain\\Service\\Mail\\SendMailService'] = array(
    'className' => 'Pingag\\PingagAddress\\Domain\\Service\\Mail\\SendMailService'
);
// Translation parent not set correctly. Probably should be fixed in TCA configuration.
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['GeorgRinger\\News\\Controller\\NewsController'] = array(
    'className' => 'Pingag\\PingagAddress\\Controller\\NewsController'
);
// Translation parent not set correctly. Probably should be fixed in TCA configuration.
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['GeorgRinger\\News\\Domain\\Repository\\NewsRepository'] = array(
    'className' => 'Pingag\\PingagAddress\\Domain\\Repository\\NewsRepository'
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Extcode\\Cart\\Controller\\Cart\\OrderController'] = array(
    'className' => 'Pingag\\PingagAddress\\Controller\\OrderController'
);



$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Evoweb\\SfRegister\\Controller\\FeuserPasswordController'] = array(
    'className' => 'Pingag\\PingagAddress\\Controller\\FeuserPasswordController'
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Evoweb\\SfRegister\\Controller\\FeuserController'] = array(
    'className' => 'Pingag\\PingagAddress\\Controller\\FeuserController'
);


$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Evoweb\\SfRegister\\Controller\\FeuserCreateController'] = array(
    'className' => 'Pingag\\PingagAddress\\Controller\\FeuserCreateController'
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['Evoweb\\SfRegister\\Controller\\FeuserEditController'] = array(
    'className' => 'Pingag\\PingagAddress\\Controller\\FeuserEditController'
);

(static function() {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'PingagAddress',
        'Mapshow',
        [
            \Pingag\PingagAddress\Controller\MapController::class => 'list,show,confirm'
        ],
        // non-cacheable actions
        [
            \Pingag\PingagAddress\Controller\MapController::class => 'list,confirm'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'PingagAddress',
        'AddressCommunication',
        [
            \Pingag\PingagAddress\Controller\AddressPersonController::class => 'list,show'
        ],
        // non-cacheable actions
        [
            \Pingag\PingagAddress\Controller\AddressPersonController::class => 'list'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    mapshow {
                        iconIdentifier = pingag_address-plugin-mapshow
                        title = LLL:EXT:pingag_address/Resources/Private/Language/locallang_db.xlf:tx_pingag_address_mapshow.name
                        description = LLL:EXT:pingag_address/Resources/Private/Language/locallang_db.xlf:tx_pingag_address_mapshow.description
                        tt_content_defValues {
                            CType = list
                            list_type = pingagaddress_mapshow
                        }
                    }
                    addresscommunication {
                        iconIdentifier = pingag_address-plugin-mapshow
                        title = Address Communication
                        description = Address Communication
                        tt_content_defValues {
                            CType = list
                            list_type = pingagaddress_addresscommunication
                        }
                    }
                }
                show = *
            }
       }'
    );
})();


$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['de']['EXT:sf_event_mgt/Resources/Private/Language/locallang.xlf'][] = 'EXT:pingag_address/Resources/Private/Language/de.event_locallang.xlf';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools::class]['flexParsing'][]
    = \Pingag\PingagAddress\Hooks\FlexFormHook::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['postUserLookUp'][] =
    \Pingag\PingagAddress\Hooks\OverwriteFlexForm::class . '->overwrite';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
    \Pingag\PingagAddress\Hooks\MyHook::class;
/*$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
    \Pingag\PingagAddress\Hooks\DataHandlerHook::class;*/


