<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Configuration du site par E-magineurs',
    'description' => '',
    'category' => 'distribution',
    'version' => '4.1.3',
    'state' => 'beta',
    'clearcacheonload' => 1,
    'author' => 'Thomas Beck, Sophie Dambreville, Mickael Chapusot',
    'author_email' => 'tbeck@e-magineurs.com,sdambreville@e-magineurs.com,mchapusot@e-magineurs.com',
    'author_company' => 'E-magineurs',
    'constraints' => array(
        'depends' => array(
            'typo3' => '11.5.0-13.4.99',
            'php' => '8.1.0-8.4.0',
        ),
        
        'suggests' => array(

        ),
        'conflicts' => array(
            'templavoila' => ''
        ),
    ),
    'autoload' => array(
        'psr-4' => array(
            'Emagineurs\\EMagineurs\\' => 'Classes'
        )
    )
);