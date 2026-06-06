<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'skt',
    'description' => '',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'bootstrap_package' => '15.0.0-15.99.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Freelance\\Skt\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'omar jmal',
    'author_email' => 'omar.jmal91@gmail.com',
    'author_company' => 'freelance',
    'version' => '1.0.0',
];
