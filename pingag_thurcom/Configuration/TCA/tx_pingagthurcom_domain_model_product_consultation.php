<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_product_consultation',
    [
        'default' => "title, abo, television, telephone, group, image",
    ]
);

$defaultFields = 'title, abo';

return array(

    'ctrl' => array(
        'title' => $helper->trans('entity_title'),
        'label' => 'title',
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
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ),
        'sortby' => 'sorting',
        'searchFields' => $defaultFields,
        'iconfile' => $helper->getIconPath(),
    ),
    'interface' => \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper::getInterfaceConfig($helper->getInterfaceFields()),
    'types' => \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper::getTypesConfig($helper->getTypesFields()),
    'palettes' => array(
    ),

    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            'title' => $helper->getInputColumnsConfig('title'),
			'abo' => $helper->getTableSelectColumnsConfig('abo', 'tx_pingagthurcom_domain_model_internet_package', 0, 1),
			'television' => [
                'exclude' => false,
                'l10n_mode' => 'prefixLangTitle',
                'label' => 'TV',
                'config' => [
                    'type' => 'select',
                    'size' => 1,
                    'minitems' => 1,
                    'maxitems' => 1,
                    'default' => 0,
                    'items' => array(
                        ['TV LIGHT', 0],
						['TV 4.0', 1],
                    )
                ]
            ],
			'telephone' => [
                'exclude' => false,
                'l10n_mode' => 'prefixLangTitle',
                'label' => 'Telefon',
                'config' => [
                    'type' => 'select',
                    'size' => 1,
                    'minitems' => 1,
                    'maxitems' => 1,
                    'default' => 0,
                    'items' => array(
                        ['kein Festnetz', 0],
						['Festnetz', 1],
                    )
                ]
            ],
            'image' => $helper->getFalMediaColumnConfig('image', 'image', 'png, svg, jpg, jpeg'),
			'group' => [
                'exclude' => false,
                'l10n_mode' => 'prefixLangTitle',
                'label' => 'Abschnitt',
                'config' => [
                    'type' => 'select',
                    'size' => 1,
                    'minitems' => 1,
                    'maxitems' => 1,
                    'default' => 0,
                    'items' => array(
                        ['Über Sie', 2],
						['Internet', 3],
						['TV', 4],
						['Festnetz', 5],
                    )
                ]
            ],
            // FIELDS END
        )
    ),

);
