<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_subscription_order',
    [
        'default' => " --palette--;Anrede;salutation, --palette--;Name;name, --palette--;Adresse;address, --palette--;Kontaktdaten;contact, birthday, comment,image",
        'tabs.cart' => "internet_package, options, additional_products, zubehoer, rufnummer, zusatzoption",
    ]
);

$defaultFields = 'internetPackage';

return array(

    'ctrl' => array(
        'title' => $helper->trans('entity_title'),
        'label' => 'first_name',
        'label_alt' => 'last_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
        ),
        'sortby' => 'sorting',
        'searchFields' => $defaultFields,
        'iconfile' => $helper->getIconPath(),
    ),
    'interface' => \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper::getInterfaceConfig($helper->getInterfaceFields()),
    'types' => \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper::getTypesConfig($helper->getTypesFields()),
    'palettes' => array(
        'salutation' => array('showitem' => 'firm_name, salutation'),
        'name' => array('showitem' => 'first_name, last_name'),
        'address' => array('showitem' => 'address, city'),
        'contact' => array('showitem' => 'telephone_private, telephone_office, telephone_mobile, email'),
        'telephone2' => array('showitem' => 'telephoneMobile', 'email'),
    ),

    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            //'internetPackage' => $helper->getInlineColumnConfig('internet_package', 'tx_pingagthurcom_domain_model_internet_package_mm', 1),
            'internet_package' => $helper->getGroupRelationColumnConfig('internet_package', 'tx_pingagthurcom_domain_model_internet_package'),
            'options' => $helper->getGroupRelationColumnConfig('options', 'tx_pingagthurcom_domain_model_subscription_option'),
            'additional_products' => $helper->getGroupRelationColumnConfig('additional_products', 'tx_pingagthurcom_domain_model_product'),

            'firm_name' => $helper->getInputColumnsConfig('firm_name', false),
            'salutation' => $helper->getInputColumnsConfig('salutation'),
            'first_name' => $helper->getInputColumnsConfig('first_name'),
            'last_name' => $helper->getInputColumnsConfig('last_name'),
            'address' => $helper->getInputColumnsConfig('address'),
            'city' => $helper->getInputColumnsConfig('city'),
            'telephone_private' => $helper->getInputColumnsConfig('telephone_private', false),
            'telephone_office' => $helper->getInputColumnsConfig('telephone_office', false),
            'telephone_mobile' => $helper->getInputColumnsConfig('telephone_mobile', false),
            'email' => $helper->getInputColumnsConfig('email'),
            'birthday' => $helper->getInputColumnsConfig('birthday', false),
            'comment' => $helper->getRTETextColumnsConfig('comment'),
			'zubehoer' => $helper->getRTETextColumnsConfig('zubehoer'),
			'rufnummer' => $helper->getInputColumnsConfig('rufnummer', false),
			'zusatzoption' => $helper->getRTETextColumnsConfig('zusatzoption'),
            'image' => [
                'exclude' => 0,
                'label' => 'LLL:EXT:upload_example/Resources/Private/Language/locallang_db.xlf:tx_uploadexample_domain_model_example.image',
                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('image', [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'maxitems' => 99,
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the imageoverlayPalette instead of the basicoverlayPalette
                    'foreign_match_fields' => [
                        'fieldname' => 'image',
                        'tablenames' => 'tx_pingagthurcom_domain_model_subscription_order',
                        'table_local' => 'sys_file',
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ]
                ], $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'])
            ],
            //'first_name' => $helper->getInputColumnsConfig('first_name'),

            // FIELDS END
        )
    ),

);