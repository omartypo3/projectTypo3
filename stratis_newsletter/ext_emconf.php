<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Stratis Newsletter',
    'description' => 'Add newsletter for project',
    'category' => 'misc',
    'version' => '1.1.5',
    'state' => 'stable',
    'uploadFolder' => false,
    'clearCacheOnLoad' => true,
    'author' => 'Denis Ivanov, Igor Bondarenko',
    'author_email' => 'denisivanov@o-s-i.org, igorbondarenko@o-s-i.org',
    'author_company' => 'Stratis',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-13.4.99',
            'php' => '8.1.0-8.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
