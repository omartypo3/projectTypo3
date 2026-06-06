<?php

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_kml',
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
        'searchFields' => 'name,picto,file,url,note,category,',
        'iconfile' => 'EXT:e_gmap/Resources/Public/Icons/tx_egmap_domain_model_kml.gif'
    ),
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, picto, file, url, note, category',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, picto, file, url, note;;;richtext:rte_transform[mode=ts_links], category, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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
                'foreign_table' => 'tx_egmap_domain_model_kml',
                'foreign_table_where' => 'AND tx_egmap_domain_model_kml.pid=###CURRENT_PID### AND tx_egmap_domain_model_kml.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_kml.name',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'picto' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_kml.picto',
            'config' => array(
                'type' => 'file',
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'maxitems' => 1,
            ),
        ),
        'file' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_kml.file',
            'config' => array(
                'type' => 'file',
                'allowed' => 'php',
                'maxitems' => 1,
            ),
        ),
        'url' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_kml.url',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'note' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_kml.note',
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
        'category' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:e_gmap/Resources/Private/Language/locallang_db.xlf:tx_egmap_domain_model_poi.category',
            'config' => array(
                'type' => 'select',
                'renderType' => 'tree',
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
                    'tablenames' => 'tx_egmap_domain_model_kml',
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
