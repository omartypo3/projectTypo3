<?php
/***************************************************************
 * Extension Manager/Repository config file for ext "e_poll".
 *
 * Auto generated 05-10-2016 15:18
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'Poll',
    'description' => 'A poll based on the extension jk_poll. A template-file can be used to define the output in the frontend. It is also possible to create a horizontal or vertical display of the percentage of users voted for an answer.',
    'category' => 'plugin',
    'author' => 'Leo Robin Le Sommer',
    'author_email' => 'llesommer@e-magineurs.com',
    'author_company' => 'e-magineurs',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => true,
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.0.0-13.4.99',
            'php' => '8.1.0-8.3.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Emagineurs\\EPoll\\' => 'Classes/'
        ]
    ],
];