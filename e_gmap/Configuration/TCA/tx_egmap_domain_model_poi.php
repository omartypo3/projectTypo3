<?php

$ll = 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf';
return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,

        'versioningWS' => 2,
        'versioning_followPages' => true,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'name,title,society,picto,note,link,address,zip,city,country,phone,cellphone,fax,website,mail,image,file,html,lat,lng,category,',
        'iconfile' => 'EXT:e_gmap/Resources/Public/Icons/tx_egmap_domain_model_poi.gif'
    ),
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, title, society, picto, note, link, address, zip, city, country, phone, cellphone, fax, website, mail, image, file, html, lat, lng, category',
    ),
    'types' => array(
        '1' => array(
            'showitem' => 'name, title, picto, lat, lng, category, '
                . '--div--;' . $ll . ':tab.conf,'
                . ' sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, starttime, endtime, society, note;;;richtext:rte_transform[mode=ts_links], link, '
                . '--div--;' . $ll . ':tab.loc,'
                . 'address, zip, city, country, phone, cellphone, fax, website, mail, '
                . '--div--;' . $ll . ':tab.media,'
                . 'image, file, html, '
        ),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(

        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
                ),
            ),
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_egmap_domain_model_poi',
                'foreign_table_where' => 'AND tx_egmap_domain_model_poi.pid=###CURRENT_PID### AND tx_egmap_domain_model_poi.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),

        't3ver_label' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),

        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'starttime' => array(
            'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'endtime' => array(
            'exclude' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),

        'name' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.name',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required'
            ),
        ),
        'title' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'society' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.society',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'picto' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.picto',
            'config' => array(
                'type' => 'file',
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'maxitems' => 1,
            ),
        ),
        'note' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.note',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'wizards' => array(
                    'RTE' => array(
                        'icon' => 'wizard_rte2.gif',
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        //'script' => 'wizard_rte.php',
                        'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext.W.RTE',
                        'type' => 'script',
                        'module' => array(
                            'name' => 'wizard_rte'
                        )
                    )
                )
            ),
        ),
        'link' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.link',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'wizards' => array(
                    '_PADDING' => 2,
                    'link' => array(
                        'type' => 'popup',
                        'title' => 'Link',
                        'icon' => 'link_popup.gif',
                        'module' => array(
                            'name' => 'wizard_element_browser',
                            'urlParameters' => array(
                                'mode' => 'wizard'
                            )
                        ),
                        'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
                    )
                )
            ),
        ),
        'address' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.address',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim'
            )
        ),
        'zip' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.zip',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'city' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.city',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'country' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.country',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'phone' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.phone',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'cellphone' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.cellphone',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'fax' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.fax',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'website' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.website',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'mail' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.mail',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'image' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.image',
            'config' => array(
                'type' => 'file',
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'maxitems' => 1,
            ),
        ),
        'file' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.file',
            'config' => array(
                'type' => 'file',
                'allowed' => 'php',
                'maxitems' => 1,
            ),
        ),
        'html' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.html',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            )
        ),
        'lat' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.lat',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'wizards' => array(
                    '_PADDING' => 2,
                    'map' => array(
                        'type' => 'popup',
                        'title' => 'Choisir centre',
                        'icon' => 'EXT:e_gmap/Resources/Public/Icons/localize.png',
                        'module' => array(
                            'name' => 'choosePoi'
                        ),
                        'JSopenParams' => 'width=800,height=600,status=0,menubar=0,scrollbars=0'
                    )
                )
            ),
        ),
        'lng' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.lng',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'wizards' => array(
                    '_PADDING' => 2,
                    'map' => array(
                        'type' => 'popup',
                        'title' => 'Choisir centre',
                        'icon' => 'EXT:e_gmap/Resources/Public/Icons/localize.png',
                        'module' => array(
                            'name' => 'choosePoi'
                        ),
                        'JSopenParams' => 'width=800,height=600,status=0,menubar=0,scrollbars=0'
                    )
                )
            ),
        ),
        'category' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.category',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectTree',
                'treeConfig' => array(
                    'parentField' => 'parent',
                    'appearance' => array(
                        'showHeader' => true,
                        'allowRecursiveMode' => true,
                        'expandAll' => true,
                        'maxLevels' => 99,
                    ),
                ),
                'MM' => 'sys_category_record_mm',
                'MM_match_fields' => array(
                    'fieldname' => 'categorys',
                    'tablenames' => 'tx_egmap_domain_model_poi',
                ),
                'MM_opposite_field' => 'items',
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
                'minitems' => 0,
                'maxitems' => 99,
                'size' => 10,
                'autoSizeMax' => 20,
                'appearance' => array(
                    'showHeader' => true,
                    'allowRecursiveMode' => true,
                    'expandAll' => true,
                    'maxLevels' => 99,
                ),
                'wizards' => array(
                    '_PADDING' => 10,
                    '_VERTICAL' => 15,
                    /*
                    'add' => array(
                            'type' => 'script',
                            'title' => 'LLL:EXT:lang/locallang_tca.xlf:file_mountpoints_add_title',
                            'icon' => 'add.gif',
                            'params' => array(
                                    'table' => 'sys_category',
                                    'pid' => '###CURRENT_PID###'
                            ),
                            'script' => 'wizard_add.php'
                    )*/
                    'RTE' => array(
                        'icon' => 'wizard_rte2.gif',
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        //'script' => 'wizard_rte.php',
                        'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext.W.RTE',
                        'module' => array(
                            'name' => 'wizard_rte'
                        ),
                        'type' => 'script'
                    )
                )
            ),
        ),

    ),
);
