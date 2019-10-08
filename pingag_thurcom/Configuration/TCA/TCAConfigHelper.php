<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 09.01.2017
 * Time: 13:56
 */

namespace Pingag\PingagThurcom\Configuration\TCA;

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
        $this->localLang = "LLL:EXT:pingag_thurcom/Resources/Private/Language/{$tableName}.xlf";
        $this->fields = $fields;
    }

    public function trans($key)
    {
        return $this->localLang . ':' . $key;
    }

    /* todo: use ExtbaseUtility? */
    public static function getBaseExtPath()
    {
        return 'typo3conf/ext/pingag_thurcom/';
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function setTablename($tablename)
    {
        $this->tablename = $tablename;
    }

    public function getIconPath($icon = null)
    {
        if ($icon) {
            return self::getBaseExtPath() . "Resources/Public/Icons/{$icon}";
        }
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
            '0' => array('showitem' => "sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, {$additional}, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime, fe_group"),
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

    public function getInputColumnsConfig($labelKey, $required = true, $eval = '', $size = 60)
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

    public function getTableSelectColumnsConfig($labelKey, $foreignTable, $minitems = 0, $maxitems = 1)
    {
        return [
            'exclude' => 1,
            'label' => $this->trans($labelKey),
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => $foreignTable,
                'minitems' => $minitems,
                'maxitems' => $maxitems,
            ),
        ];
    }
	
	public function getTableSelectTreeChannelColumnsConfig($labelKey, $foreignTable, $minitems = 0, $maxitems = 1)
    {
        return [
            'exclude' => 1,
            'label' => $this->trans($labelKey),
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
				'size' => 10,
                'foreign_table' => $foreignTable,
				'foreign_table_where' => 'AND '.$foreignTable.'.pid != 60 ORDER BY '.$foreignTable.'.name',
                'minitems' => $minitems,
                'maxitems' => $maxitems,
            ),
        ];
    }
	
	public function getTableSelectTreeColumnsConfig($labelKey, $foreignTable, $minitems = 0, $maxitems = 1)
    {
        return [
            'exclude' => 1,
            'label' => $this->trans($labelKey),
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
				'size' => 10,
                'foreign_table' => $foreignTable,
				'foreign_table_where' => 'AND '.$foreignTable.'.pid != 0 ORDER BY '.$foreignTable.'.zip',
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
                'multiple' => 1,
                /* newconf */
                'fieldControl' => ['editPopup', 'addRecord'],
                'wizards' => array(
                    '_PADDING' => 1,
                    '_VERTICAL' => 1,
                    'edit' => array(
                        'module' => array(
                            'name' => 'wizard_edit',
                        ),
                        'type' => 'popup',
                        'title' => 'Edit',
                        'icon' => 'actions-open',
                        'popup_onlyOpenIfSelected' => 1,
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                    ),
                    'add' => Array(
                        'module' => array(
                            'name' => 'wizard_add',
                        ),
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'actions-add',
                        'params' => array(
                            'table' => $foreignTable,
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ),
                    ),
                )
            )
        ];
    }

    public function getInlineColumnConfig($labelKey, $foreignTable, $max = 10, $min = 1, $foreignField = 'foreign_uid', $foreignTableField = 'foreign_table')
    {
        $config = [
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
                ],
            )
        ];

        return $config;
    }

    public function getFalMediaColumnConfig($labelKey, $fieldName, $allowedFileExtensions = null)
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
                        'tablenames' => $this->tablename,
                        'table_local' => 'sys_file',
                    ],
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the newsPalette and imageoverlayPalette instead of the basicoverlayPalette
                    'foreign_types' => [
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
                    'behaviour' => ['allowLanguageSynchronization' => true]
                ],
                ($allowedFileExtensions !== null) ? $allowedFileExtensions : $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
        ];
    }
	
	public function getMediaColumnConfig($labelKey)
    {
        return [
            'exclude' => false,
            'l10n_mode' => 'prefixLangTitle',
            'label' => $this->trans($labelKey),
            'config' => [
                'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'jpg, jpeg, png, gif, svg',
                'size' => 3,
                'uploadfolder' => 'fileadmin/bilder/Sender/',
        		'max_size' => 2000,
            ]
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
                ]
            ),
            'size' => $max,
            'maxitems' => $max,
            'minitems' => $min,
            'behaviour' => ['allowLanguageSynchronization' => true]
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

    public function getCategoriesColumnConfig($labelKey, $fieldname = 'categories', $min = 0, $max = 99)
    {
        return [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
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
                    'tablenames' => $this->tablename,
                ],
                'MM_opposite_field' => 'items',
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
                'size' => 10,
                'minitems' => $min,
                'maxitems' => $max,
            ]
        ];
    }

    public function getGroupRelationColumnConfig($fieldName, $tableName, $foreignTableWhere = '', $min = 0, $max = 99)
    {
        $ll = 'LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:';
        return [
            'exclude' => true,
            'label' => $this->trans($fieldName),
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => /*'tx_news_domain_model_tag'*/$tableName,
                'MM' => $tableName . '_mm',
                'foreign_table' => $tableName,
                'foreign_table_where' => $foreignTableWhere,
                'size' => 10,
                'minitems' => $min,
                'maxitems' => $max,
                'wizards' => [
                    'edit' => [
                        'type' => 'popup',
                        'title' => $ll . 'tx_news_domain_model_news.tags.edit',
                        'module' => [
                            'name' => 'wizard_edit',
                        ],
                        'popup_onlyOpenIfSelected' => true,
                        'icon' => 'actions-open',
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                    ],
                ],
            ]
        ];
    }
}