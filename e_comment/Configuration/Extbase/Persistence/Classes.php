<?php

declare(strict_types=1);

return [
    \Emagineurs\EComment\Domain\Model\Message::class => [
        'properties' => [
            'crdate' => [
                'fieldName' => 'crdate'
            ],
        ],
    ],
    \Emagineurs\EComment\Domain\Model\Filereference::class => [
        'tableName' => 'sys_file_reference',
    ],
];

