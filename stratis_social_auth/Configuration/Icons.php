<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

$iconsSource = [
    'stratis-socialauth-account' => 'Account.svg',
    'stratis-socialauth-config' => 'Config.svg',
    'stratis-socialauth-page' => 'Page.svg',
    'stratis-socialauth-popup' => 'Popup.svg',
    'stratis-socialauth-provider' => 'Provider.svg',
    'stratis-socialauth-facebook' => 'Facebook.svg',
    'stratis-socialauth-google' => 'Google.svg',
    'stratis-socialauth-franceconnect' => 'FranceConnect.svg',
    'stratis-socialauth-publik' => 'Publik.svg',
];

$iconsConfig = [];

foreach ($iconsSource as $identifier => $path) {
    $iconsConfig[$identifier] = [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:stratis_social_auth/Resources/Public/Icons/' . $path,
    ];
}


return $iconsConfig;
