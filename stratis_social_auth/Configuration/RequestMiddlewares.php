<?php

return [
    'frontend' => [
        'stratis/stratis-social-auth/initialize-php-session' => [
            'target' => \Stratis\StratisSocialAuth\Middleware\InitializePhpSessionMiddleware::class,
            'after' => [
                'typo3/cms-frontend/site',
            ],
        ],
    ],
];
