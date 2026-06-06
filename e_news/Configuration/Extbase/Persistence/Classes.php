<?php

declare(strict_types=1);

return [
    \GeorgRinger\News\Domain\Model\News::class => [
        'subclasses' => [
            3 => \Emagineurs\ENews\Domain\Model\Enews::class,
        ],
    ],
    \Emagineurs\ENews\Domain\Model\Category::class => [
        'tableName' => 'sys_category',
    ],
    \Emagineurs\ENews\Domain\Model\Categories::class => [
        'tableName' => 'sys_category',
    ],
    \Emagineurs\ENews\Domain\Model\Enews::class => [
        'tableName' => 'tx_news_domain_model_news',
    ],
    \GeorgRinger\News\Domain\Model\Dto\Search::class => [
        'subclasses' => [
            0 => \Emagineurs\ENews\Domain\Model\Dto\SearchEnews::class,
        ],
    ],
    \GeorgRinger\News\Domain\Model\Tag::class => [
        'subclasses' => [
            0 => \Emagineurs\ENews\Domain\Model\Tag::class,
        ],
    ],
    \Emagineurs\ENews\Domain\Model\EFileReference::class => [
        'tableName' => 'sys_file_reference',
    ],
    \Emagineurs\ENews\Domain\Model\Tag::class => [
        'tableName' => 'tx_news_domain_model_tag',
    ],
];

