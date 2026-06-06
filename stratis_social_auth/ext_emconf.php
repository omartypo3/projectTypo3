<?php

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2018 Stratis, http://www.stratis.fr/
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

$EM_CONF['stratis_social_auth'] = [
    'title' => 'Stratis Social Auth',
    'description' => 'Authentication in TYPO3 systems using OAuth and OpenID',
    'category' => 'services',
    'author' => 'Dima Nozdrin',
    'author_email' => 'dmytro.nozdrin.stratis@gmail.com',
    'author_company' => 'Stratis',
    'state' => 'stable',
    'uploadFolder' => false,
    'clearCacheOnLoad' => true,
    'version' => '5.2.3',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
            'php' => '8.0.0-8.3.99',
        ],
        'suggests' => [
            'stratis_felogin' => '',
        ],
    ],
];
