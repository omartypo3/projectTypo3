<?php

$_LLL = 'LLL:EXT:cart/Resources/Private/Language/locallang_db.xlf';

$desc = [
    'entendu' => [
        'exclude' => 0,
        'label' => 'Wie haben Sie von uns erfahren ? ',
        'config' => [
            'type' => 'text',
            'readOnly' => 1,
            'cols' => 48,
            'rows' => 15,
            'appearance' => [
                'enabledControls' => [
                    'info' => false,
                    'new' => false,
                    'dragdrop' => false,
                    'sort' => false,
                    'hide' => false,
                    'delete' => false,
                    'localize' => false,
                ],
            ],
        ],
    ],
    'donation' => [
        'exclude' => true,
        'label' => 'Spende',
        'config' => [
            'type' => 'check',
            'default' => 0,
        ],
    ],

];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_cart_domain_model_order_item',$desc);

$GLOBALS['TCA']['tx_cart_domain_model_order_item']['types'] =[
    '1' => [
        'showitem' =>
            'pid, fe_user,
                --palette--;' . $_LLL . ':tx_cart_domain_model_order_item.palettes.numbers;numbers,
                --palette--;' . $_LLL . ':tx_cart_domain_model_order_item.palettes.addresses;addresses,
                --palette--;' . $_LLL . ':tx_cart_domain_model_order_item.palettes.price;price,
                --palette--;' . $_LLL . ':tx_cart_domain_model_order_item.palettes.total_price;total_price,
                comment,
                entendu,
                donation,
                additional,
                additional_data,
                tax_class,
                products,
                discounts,
                payment,
                shipping,
                --palette--;' . $_LLL . ':tx_cart_domain_model_order_item.palettes.documents;pdfs'
    ]
];
