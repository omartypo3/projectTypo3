<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Intranet',
    'description' => 'Intranet.',
    'category' => 'plugin',
    'author' => 'Mike Zimmer',
    'author_email' => 'mz@dsl-factory.de',
    'state' => 'alpha',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
