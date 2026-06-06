<?php

declare(strict_types=1);



return [

    \Pingag\PingagAddress\Domain\Model\Address::class => [

        'tableName' => 'tt_address',
        'properties' => [
            'markerIcon'=> [
                'fieldName' => 'marker_icon'
            ],
        ],
    ],

    \Pingag\PingagAddress\Domain\Model\AddressPerson::class => [
        'tableName' => 'tt_address',
    ],

    \Pingag\PingagAddress\Domain\Model\FrontendUser::class => [
        'tableName' => 'fe_users',
    ],

    \Pingag\PingagAddress\Domain\Model\Product::class => [
        'tableName' => 'tx_cartproducts_domain_model_product_product',
        'properties' => [
            'Szblindnummer' => [
                'fieldName' => 'Szblindnummer'
            ],
            'Verfasser' => [
                'fieldName' => 'Verfasser'
            ],
            'Verlag' => [
                'fieldName' => 'Verlag'
            ],
            'Jahr' => [
                'fieldName' => 'Jahr'
            ],
            'Seitenanzahl' => [
                'fieldName' => 'Seitenanzahl'
            ],
        ],
    ],
    \Pingag\PingagAddress\Domain\Model\Event::class => [
        'tableName' => 'tx_sfeventmgt_domain_model_event',
        'properties' => [
            'goal' => [
                'fieldName' => 'goal'
            ],
            'requirements' => [
                'fieldName' => 'requirements'
            ],
            'zgroup' => [
                'fieldName' => 'zgroup'
            ],
            'leader' => [
                'fieldName' => 'leader'
            ],
            'leitung' => [
                'fieldName' => 'leitung'
            ],
            'comment' => [
                'fieldName' => 'comment'
            ],
            'infos' => [
                'fieldName' => 'infos'
            ],
            'dateextra' => [
                'fieldName' => 'dateextra'
            ],
            'otherdates' => [
                'fieldName' => 'otherdates'
            ],
            'pricetext' => [
                'fieldName' => 'pricetext'
            ],
        ],
    ],
    \Pingag\PingagAddress\Domain\Model\Registration::class => [
        'tableName' => 'tx_sfeventmgt_domain_model_registration',
        'properties' => [
            'bill' => [
                'fieldName' => 'bill'
            ],
            'acompany' => [
                'fieldName' => 'acompany'
            ],
            'aaddress' => [
                'fieldName' => 'aaddress'
            ],
            'azip' => [
                'fieldName' => 'azip'
            ],
            'acity' => [
                'fieldName' => 'acity'
            ],
            'aphone' => [
                'fieldName' => 'aphone'
            ],
            'aemail' => [
                'fieldName' => 'aemail'
            ],
            'ajob' => [
                'fieldName' => 'ajob'
            ],
            'documents' => [
                'fieldName' => 'documents'
            ],
            'situation' => [
                'fieldName' => 'situation'
            ],
            'newsletter' => [
                'fieldName' => 'newsletter'
            ],
        ],
    ],
    \Pingag\PingagAddress\Domain\Model\Form::class => [

        'tableName' => 'tx_powermail_domain_model_form',
    ],
    \Pingag\PingagAddress\Domain\Model\Form::class => [

        'tableName' => 'tx_powermail_domain_model_page',
    ],
    \Pingag\PingagAddress\Domain\Model\Field::class => [

        'tableName' => 'tx_powermail_domain_model_field',
    ],
    \Pingag\PingagAddress\Domain\Model\News::class => [
        'tableName' => 'tx_news_domain_model_news',
    ],

    \Pingag\PingagAddress\Domain\Model\Item::class => [

        'tableName' => 'tx_cart_domain_model_order_item',
        'properties' => [
            'entendu'=> [
                'fieldName' => 'entendu'
            ],
            'donation'=> [
                'fieldName' => 'donation'
            ],
        ],
    ],
];





