<?php

declare(strict_types=1);



return [

    \DslFactory\DslImmo\Domain\Model\FileReference::class => [

        'tableName' => 'sys_file_reference',
        'properties' => [
            'originalFileIdentifier' => [
                'fieldName' => 'uid_local',
            ],
        ],
    ],

];





