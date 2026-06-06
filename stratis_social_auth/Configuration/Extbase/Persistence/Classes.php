<?php
declare(strict_types = 1);

return [
    \Stratis\StratisSocialAuth\Domain\Model\User::class => [
        'tableName' => 'fe_users',
    ],
    \Stratis\StratisSocialAuth\Domain\Model\SocialAccount::class => [
        'tableName' => 'tx_stratissocialauth_domain_model_social_account',
    ]
];
