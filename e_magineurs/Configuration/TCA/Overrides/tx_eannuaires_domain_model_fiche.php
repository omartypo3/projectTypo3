<?php

unset($GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns']['civility']['config']['items'][1]);

$GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns']['grade'] = [
    'exclude' => 0,
    'label' => 'LLL:EXT:e_magineurs/Resources/Extensions/e_annuaires/Language/locallang.xlf:tx_eannuaires_domain_model_fiche.grade',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectMultipleSideBySide',
        'foreign_table' => 'tx_emagineurs_domain_model_grade',
        'foreign_table_where' => 'AND tx_emagineurs_domain_model_grade.pid=###CURRENT_PID### ORDER BY tx_emagineurs_domain_model_grade.title',
        'size' => 5,
        'minitems' => 0,
        'maxitems' => 10,
        'wizards' => array(
            'suggest' => array(
                'type' => 'suggest',
            ),
            '_VERTICAL' => 1,
            '_PADDING' => 4,
        ),
    ]
];

$GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns']['direction'] = [
    'exclude' => 0,
    'label' => 'LLL:EXT:e_magineurs/Resources/Extensions/e_annuaires/Language/locallang.xlf:tx_eannuaires_domain_model_fiche.direction',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectMultipleSideBySide',
        'size' => 5,
        'minitems' => 0,
        'maxitems' => 10,
        'foreign_table' => 'tx_emagineurs_domain_model_direction',
        'foreign_table_where' => 'tx_emagineurs_domain_model_direction.pid=###CURRENT_PID### ORDER BY tx_emagineurs_domain_model_direction.title',
        'wizards' => array(
            'suggest' => array(
                'type' => 'suggest',
            ),
            '_VERTICAL' => 1,
            '_PADDING' => 4,
        ),
    ]
];

$GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns']['cadreemploi'] = [
    'exclude' => 0,
    'label' => 'LLL:EXT:e_magineurs/Resources/Extensions/e_annuaires/Language/locallang.xlf:tx_eannuaires_domain_model_fiche.cadre_emploi',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectMultipleSideBySide',
        'foreign_table' => 'tx_emagineurs_domain_model_cadreemploi',
        'foreign_table_where' => 'tx_emagineurs_domain_model_cadreemploi.pid=###CURRENT_PID### ORDER BY tx_emagineurs_domain_model_cadreemploi.title',
        'size' => 5,
        'minitems' => 0,
        'maxitems' => 10,
        'wizards' => array(
            'suggest' => array(
                'type' => 'suggest',
            ),
            '_VERTICAL' => 1,
            '_PADDING' => 4,
        ),
    ]
];

$GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns']['metier'] = [
    'exclude' => 0,
    'label' => 'LLL:EXT:e_magineurs/Resources/Extensions/e_annuaires/Language/locallang.xlf:tx_eannuaires_domain_model_fiche.metier',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectMultipleSideBySide',
        'foreign_table' => 'tx_emagineurs_domain_model_metier',
        'foreign_table_where' => 'AND tx_emagineurs_domain_model_metier.pid=###CURRENT_PID### ORDER BY tx_emagineurs_domain_model_metier.title',
        'size' => 5,
        'minitems' => 0,
        'maxitems' => 10,
        'wizards' => array(
            'suggest' => array(
                'type' => 'suggest',
            ),
            '_VERTICAL' => 1,
            '_PADDING' => 4,
        ),
    ]
];

if (isset($GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns']['email']['config'])) {
    $GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns']['email']['config']['eval'] = 'trim,required';
}

if (isset($GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns']['endtime']['config'])) {
    $GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns']['endtime']['config']['eval'] = 'datetime,required';
}
?>