<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 29.01.2018
 * Time: 13:28
 */

namespace Pingag\PingagRealEstate\Util;

class TCAHelper
{
    
    protected $table;
    protected $extKey;
    protected $fields;
    
    /**
     * TCAHelper constructor.
     * @param $table
     */
    public function __construct($table, $extKey, array $fields = array())
    {
        $this->table = $table;
        $this->extKey = $extKey;
        $this->fields = $fields;
    }

    public static function getBaseFields($toArray = false)
    {
        $fields = 'uid,pid,tstamp,crdate,deleted,hidden,sys_language_uid,l10n_parent,l10n_diffsource,access_group,';
        if ($toArray) {
            $fields = explode(',', $fields);
        }
        return $fields;
    }

    public function getIconPath()
    {
        return 'EXT:' . $this->extKey . "/Resources/Public/Icons/{$this->table}.svg";
    }
    
    public function trans($key)
    {
        $fileFormat = 'LLL:EXT:%s/Resources/Private/Language/%s.xlf:%s';
        return sprintf($fileFormat, $this->extKey, $this->table, $key);
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;
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

    public function getInterfaceConfig($additional = '')
    {
        return array(
            'showRecordFieldList' => "cruser_id,pid,sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,fe_group, " . $this->getInterfaceFields(),
        );
    }

    public function getTypesConfig(array $additional = array())
    {
        return array(
            '0' => $additional + array('showitem' => "sys_language_uid, l10n_parent, l10n_diffsource, hidden,--palette--;;1, {$this->getTypesFields()}, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime, fe_group"),
        );
    }
    
    public function getBaseColumns()
    {
        return [
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
                    'foreign_table' => $this->table,
                    'foreign_table_where' => "AND {$this->table}.pid=###CURRENT_PID### AND {$this->table}.sys_language_uid IN (-1,0)",
                    'showIconTable' => false,
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
        ];
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
                'wizards' => [
                    '_PADDING' => 2,
                    'RTE' => [
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        'type' => 'script',
                        'title' => 'Full screen Rich Text Editing',
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_rte.gif',
                        'module' => [
                            'name' => 'wizard_rte',
                        ],
                    ],
                ],
            ],
            'defaultExtras' => 'richtext:rte_transform[mode=ts_css]',
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

    public function getTableSelectColumnsConfig($labelKey, $foreignTable, $minitems = 0, $maxitems = 1, $items = array())
    {
        return [
            'exclude' => 1,
            'label' => $this->trans($labelKey),
            'config' => array(
                'type' => 'select',
                'items' => $items,
                'renderType' => 'selectSingle',
                'foreign_table' => $foreignTable,
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