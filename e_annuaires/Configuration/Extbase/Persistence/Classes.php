<?php

declare(strict_types=1);

return [
    \Emagineurs\EAnnuaires\Domain\Model\Categorie::class => [
        'tableName' => 'sys_category',
        'properties' => [
            'parentcategory' => [
                'fieldName' => 'parent'
            ],
        ],
    ],
    \Emagineurs\EAnnuaires\Domain\Model\Filereference::class => [
        'tableName' => 'sys_file_reference',
    ],
    \Emagineurs\EAnnuaires\Domain\Model\Conf\Typeannuaire::class => [
        'tableName' => 'tx_eannuaires_domain_model_typeannuaire',
    ],
    \Emagineurs\EAnnuaires\Domain\Model\Conf\Champbdd::class => [
        'tableName' => 'tx_eannuaires_domain_model_champbdd',
    ],
    \Emagineurs\EAnnuaires\Domain\Model\City::class => [
        'tableName' => 'tx_enews_domain_model_commune',
    ],
];

