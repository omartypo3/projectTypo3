<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 09.01.2017
 * Time: 13:56
 */

namespace Pingag\PingagJobs\Configuration\TCA;

class TCAConfigHelper
{

    protected $localLang;

    protected $fields;

    public $tablename;

    /**
     * TCAConfigHelper constructor.
     * @param array $fields
     * @param $localLangFile
     */
    public function __construct($tableName, array $fields = array())
    {
        $this->tablename = $tableName;
        $this->localLang = "LLL:EXT:pingag_jobs/Resources/Private/Language/{$tableName}.xlf";
        $this->fields = $fields;
    }

    public function trans($key)
    {
        return $this->localLang . ':' . $key;
    }

    public static function getBaseExtPath()
    {
        return 'typo3conf/ext/pingag_jobs/';
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function setTablename($tablename)
    {
        $this->tablename = $tablename;
    }

    public function getIconPath()
    {
        return self::getBaseExtPath() . "Resources/Public/Icons/{$this->tablename}.svg";
    }

    public function getInterfaceFields()
    {
        $fields = '';
        foreach ($this->fields as $field) {
            $fields .= ',' . $field;
        }
        return trim($fields, ', ');
    }

    public function getTypesFields()
    {
        $fields = '';
        $tabFormat = ' , --div--;%s,%s';
        foreach ($this->fields as $tab => $field) {
            if (strtolower($tab) != 'default') {
                $fields .= sprintf($tabFormat, $this->trans($tab), $field);
            } else {
                $fields .= ', ' . $field;
            }
        }
        return trim($fields, ', ');
    }

    public static function getInterfaceConfig($additional = '')
    {
        return array(
            'showRecordFieldList' => "cruser_id,pid,sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,fe_group, " . $additional,
        );
    }

    public static function getTypesConfig($additional = '')
    {
        return array(
            '0' => array('showitem' => "sys_language_uid, l10n_parent, l10n_diffsource, hidden,--palette--;;1, {$additional}, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime, fe_group"),
        );
        return array(
            '1' => array('showitem' => "sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, {$additional}, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime, fe_group"),
        );
    }

    public function getDefaultColumnsConfig(array $additional = array())
    {
        return array_merge($additional, array(

            'sys_language_uid' => [
                'exclude' => true,
                'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'special' => 'languages',
                    'items' => [
                        [
                            'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                            -1,
                            'flags-multiple'
                        ],
                    ],
                    'default' => 0,
                ]
            ],
            'l10n_parent' => [
                'displayCond' => 'FIELD:sys_language_uid:>:0',
                'exclude' => true,
                'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['', 0],
                    ],
                    'foreign_table' => $this->tablename,
                    'foreign_table_where' => "AND {$this->tablename}.pid=###CURRENT_PID### AND {$this->tablename}.sys_language_uid IN (-1,0)",
                    'default' => 0,
                ]
            ],
            'l10n_diffsource' => [
                'config' => [
                    'type' => 'passthrough',
                    'default' => ''
                ]
            ],
            'hidden' => [
                'exclude' => true,
                'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
                'config' => [
                    'type' => 'check',
                    'default' => 0
                ]
            ],
            'cruser_id' => [
                'label' => 'cruser_id',
                'config' => [
                    'type' => 'passthrough'
                ]
            ],
            'pid' => [
                'label' => 'pid',
                'config' => [
                    'type' => 'passthrough'
                ]
            ],
            'crdate' => [
                'label' => 'crdate',
                'config' => [
                    'type' => 'passthrough',
                ]
            ],
            'tstamp' => [
                'label' => 'tstamp',
                'config' => [
                    'type' => 'passthrough',
                ]
            ],
            'sorting' => [
                'label' => 'sorting',
                'config' => [
                    'type' => 'passthrough',
                ]
            ],
            'starttime' => [
                'exclude' => true,
                'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel',
                'config' => [
                    'type' => 'input',
                    'size' => 16,
                    'eval' => 'datetime',
                    'default' => 0,
                    'behaviour' => ['allowLanguageSynchronization' => true],
                    'renderType' => 'inputDateTime'
                ]
            ],
            'endtime' => [
                'exclude' => true,
                'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel',
                'config' => [
                    'type' => 'input',
                    'size' => 16,
                    'eval' => 'datetime',
                    'default' => 0,
                    'behaviour' => ['allowLanguageSynchronization' => true],
                    'renderType' => 'inputDateTime'
                ]
            ],
            'fe_group' => [
                'exclude' => true,
                'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.fe_group',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectMultipleSideBySide',
                    'size' => 5,
                    'maxitems' => 20,
                    'items' => [
                        [
                            'LLL:EXT:lang/locallang_general.xlf:LGL.hide_at_login',
                            -1,
                        ],
                        [
                            'LLL:EXT:lang/locallang_general.xlf:LGL.any_login',
                            -2,
                        ],
                        [
                            'LLL:EXT:lang/locallang_general.xlf:LGL.usergroups',
                            '--div--',
                        ],
                    ],
                    'exclusiveKeys' => '-1,-2',
                    'foreign_table' => 'fe_groups',
                    'foreign_table_where' => 'ORDER BY fe_groups.title',
                ],
            ]
        ));
    }

    // ***** Custom Columns Configurations: ****** //

    public function getInputColumnsConfig($labelKey, $required = false, $eval = '', $size = 60)
    {
        return [
            'exclude' => false,
            'l10n_mode' => 'prefixLangTitle',
            'label' => $this->trans($labelKey),
            'config' => [
                'type' => 'input',
                'size' => $size,
                'eval' => ($required) ? "required {$eval}" : $eval,
            ]
        ];
    }

    public function getRTETextColumnsConfig($labelKey, $cols = 30, $rows = 5)
    {
        return [
            'exclude' => false,
            'label' => $this->trans($labelKey),
            'config' => [
                'type' => 'text',
                'cols' => $cols,
                'rows' => $rows,
                'softref' => 'rtehtmlarea_images,typolink_tag,images,email[subst],url',
                'enableRichtext' => true,
                /*newconf*///'fieldControl' => ['fullScreenRichtext'],
                /*'wizards' => [
                    'RTE' => [
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        'type' => 'script',
                        'title' => 'Full screen Rich Text Editing',
                        'icon' => 'actions-wizard-rte',
                        'module' => [
                            'name' => 'wizard_rte',
                        ],
                    ],
                ],*/
            ],
            //'defaultExtras' => 'richtext:rte_transform[mode=ts_css]',
            //'defaultExtras' => 'richtext:rte_transform'
        ];
    }

    public function getTextColumnsConfig($labelKey, $cols = 60, $rows = 5)
    {
        return [
            'exclude' => true,
            'label' => $this->trans($labelKey),
            'config' => [
                'type' => 'text',
                'cols' => $cols,
                'rows' => $rows,
            ]
        ];
    }

    public function getSelectColumnsConfig($labelKey, array $items)
    {
        return [
            'exclude' => true,
            'label' => $this->trans($labelKey),
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => $items,
                'default' => 0,
            ]
        ];
    }

    public function getTableSelectColumnsConfig($labelKey, $foreignTable, $minitems = 0, $maxitems = 1, $foreignTableWhere = '', $items = array())
    {
        return [
            'exclude' => 1,
            'label' => $this->trans($labelKey),
            'config' => array(
                'type' => 'select',
                'items' => $items,
                'renderType' => 'selectSingle',
                'foreign_table' => $foreignTable,
                'foreign_table_where' => $foreignTableWhere,
                'minitems' => $minitems,
                'maxitems' => $maxitems,
            ),
        ];
    }

    public function getMultiSelectColumnsConfig($labelKey, $foreignTable, $mmTable, $max = 20, $min = 1, $foreignTableWhere = null, $sortBy = null)
    {
        return [
            'exclude' => 1,
            'label' => $this->trans($labelKey),
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => $foreignTable,
                'foreign_table_where' => $foreignTableWhere,
                'MM' => $mmTable,
                'size' => $max,
                'autoSizeMax' => $max,
                'maxitems' => $max,
                'minitems' => $min,
                'sorting' => $sortBy,
                'multiple' => 0,
                /*'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Ausgewählten Eintrag bearbeiten.',
                        ],
                    ],
                    'addRecord' => ['disabled' => false],
                ],*/
            )
        ];
    }

    public function getInlineColumnConfig($labelKey, $foreignTable, $max = 10, $min = 1, $foreignField = 'foreign_uid', $foreignTableField = 'foreign_table')
    {
        $config = [
            'exclude' => true,
            'label' => $this->trans($labelKey),
            'config' => array(
                'type' => 'inline',
                'foreign_table' => $foreignTable,
                'foreign_field' => $foreignField,
                'foreign_table_field' => $foreignTableField,
                'minitems' => $min,
                'maxitems' => $max,
                'appearance' => [
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                    'localize' => true,
                    //'showPossibleLocalizationRecords' => true,
                    //'showRemovedLocalizationRecords' => true,
                    //'showAllLocalizationLink' => true,
                    //'showSynchronizationLink' => true
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                    'localizeChildrenAtParentLocalization' => true,
                ]
            )
        ];

        return $config;
    }

    public function getFalMediaColumnConfig($labelKey, $foreignTable, $fieldName, $allowedFileExtensions = null)
    {
        return [
            'exclude' => true,
            'label' => $this->trans($labelKey),
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'fal_media',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => $this->trans('falMedia.add'),
                        'showPossibleLocalizationRecords' => true,
                        'showRemovedLocalizationRecords' => true,
                        'showAllLocalizationLink' => true,
                        'showSynchronizationLink' => true
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => $fieldName,
                        'tablenames' => $foreignTable,
                        'table_local' => 'sys_file',
                    ],
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the newsPalette and imageoverlayPalette instead of the basicoverlayPalette
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
						--palette--;;imageoverlayPalette,
						--palette--;;filePalettetc'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
						--palette--;;imageoverlayPalette,
						--palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                'showitem' => '
						--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
						--palette--;;imageoverlayPalette,
						--palette--;;filePalette'
                            ],
                        ],
                    ],
                    
                    'behaviour' => ['allowLanguageSynchronization' => true]
                ],
                ($allowedFileExtensions !== null) ? $allowedFileExtensions : $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
        ];
    }

    public function getFalFilesColumnConfig($labelKey, $foreignTable, $fieldName, $max = 5, $min = 0)
    {
        return [
            'exclude' => true,
            'label' => $this->trans($labelKey),
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                $fieldName,
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => $this->trans('falMedia.add'),
                        'showPossibleLocalizationRecords' => true,
                        'showRemovedLocalizationRecords' => true,
                        'showAllLocalizationLink' => true,
                        'showSynchronizationLink' => true
                    ],
                    'inline' => [
                        'inlineOnlineMediaAddButtonStyle' => 'display:none'
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => $fieldName,
                        'tablenames' => $foreignTable,
                        'table_local' => 'sys_file',
                    ],
                    'behaviour' => ['allowLanguageSynchronization' => true]
                ]
            ),
            'size' => $max,
            'maxitems' => $max,
            'minitems' => $min,
        ];
    }

    public function getCheckboxColumnConfig($labelKey, $default = 0)
    {
        return [
            'label' => $this->trans($labelKey),
            'config' => [
                'type' => 'check',
                'default' => $default
            ],
        ];
    }

    public function getCategoriesColumnConfig($labelKey, $tablenames, $fieldname = 'categories')
    {
        return [
            'exclude' => true,
            'label' => $this->trans($labelKey),
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'treeConfig' => [
                    'dataProvider' => \GeorgRinger\News\TreeProvider\DatabaseTreeDataProvider::class,
                    'parentField' => 'parent',
                    'appearance' => [
                        'showHeader' => true,
                        'expandAll' => true,
                        'maxLevels' => 99,
                    ],
                ],
                'MM' => 'sys_category_record_mm',
                'MM_match_fields' => [
                    'fieldname' => 'categories',
                    'tablenames' => $tablenames,
                ],
                'MM_opposite_field' => 'items',
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
                'size' => 10,
                'minitems' => 0,
                'maxitems' => 99,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ]
        ];
    }
}