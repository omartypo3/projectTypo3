<?php

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2019 Stratis, http://www.stratis.fr/
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *
 ***************************************************************/

$EM_CONF[$_EXTKEY] =  [
    'title' => 'Stratis Elements',
    'description' => 'Stratis Flux Content Element',
    'category' => 'misc',
    'author' => 'Sasha LOVIANNIKOV',
    'author_email' => 'oleksandr.loviannikov.stratis@gmail.com',
    'author_company' => 'Stratis',
    'state' => 'alpha',
    'clearCacheOnLoad' => true,
    'version' => '1.0.0',
    'constraints' =>  [
        'depends' =>  [
            'typo3' => '11.5.0-13.4.99',
            'php' => '8.1.0-8.4.0',
        ],
        'conflicts' =>  [
        ],
        'suggests' =>  [
        ],
    ],
];
