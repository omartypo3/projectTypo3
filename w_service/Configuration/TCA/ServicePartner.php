<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$TCA['tx_wservice_domain_model_servicepartner'] = array(
    'ctrl' => $TCA['tx_wservice_domain_model_servicepartner']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, company, street, zip, city, country, continent, industry, phone, cell, fax, email, website, additional, notes, lat, lng, category, boost',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, company, street, zip, city, country, continent, industry, phone, cell, fax, email, website, additional, notes, lat, lng, category, boost,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
                ),
            ),
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_wservice_domain_model_servicepartner',
                'foreign_table_where' => 'AND tx_wservice_domain_model_servicepartner.pid=###CURRENT_PID### AND tx_wservice_domain_model_servicepartner.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        't3ver_label' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'starttime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
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
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
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
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.name',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'company' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.company',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'street' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.street',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ),
        ),
        'zip' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.zip',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'city' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.city',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'country' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.country',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'continent' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.continent',
            'config' => array(
				'type' => 'select',
				'items' => array(
					array('', ),
					array('LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.continent.1', 1),
					array('LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.continent.2', 2),
					array('LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.continent.3', 3),
					array('LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.continent.4', 4),
					array('LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.continent.5', 5),
					array('LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.continent.6', 6),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => 'required',
            	'range' => array('lower' => 1,'upper' => 6),
            ),
        ),
        'industry' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.industry',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'phone' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.phone',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'cell' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.cell',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'fax' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.fax',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'email' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.email',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'website' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.website',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'lat' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.lat',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'lng' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.lng',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'additional' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.additional',
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
                        'script' => 'wizard_rte.php',
                        'title' => 'LLL:EXT:cms/locallang_ttc.xml:bodytext.W.RTE',
                        'type' => 'script'
                    )
                )
            ),
            'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts]',
        ),
        'notes' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.notes',
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
                        'script' => 'wizard_rte.php',
                        'title' => 'LLL:EXT:cms/locallang_ttc.xml:bodytext.W.RTE',
                        'type' => 'script'
                    )
                )
            ),
            'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts]',
        ),
        'category' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.category',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_wservice_domain_model_category',
				'minitems' => 0,
				'maxitems' => 1,
				'items' => Array (
					Array("",0),
				),
			),
        ),
        'boost' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:w_service/Resources/Private/Language/locallang_db.xml:tx_wservice_domain_model_servicepartner.boost',
            'config' => array(
                'type' => 'check',
            ),
        ),
    ),
);
?>