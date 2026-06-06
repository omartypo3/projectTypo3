<?php

declare(strict_types=1);

return [
    \Emagineurs\EGmap\Domain\Model\Category::class => [
        'tableName' => 'sys_category',
        'properties' => [
            'parentcategory' => [
                'fieldName' => 'parent'
            ],
        ],
    ],
    \Emagineurs\EGmap\Domain\Model\News::class => [
        'tableName' => 'tx_news_domain_model_news',
    ],
];

