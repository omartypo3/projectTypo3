<?php

declare(strict_types=1);

return [
    'frontend' => [
        'stratis-mobileapp/app-settings' => [
            'target' => \Stratis\StratisMobileapp\Middleware\AppSettingsMiddleware::class,
            'before' => [
                'typo3/cms-frontend/prepare-tsfe-rendering',
            ],
        ],
    ],
];

