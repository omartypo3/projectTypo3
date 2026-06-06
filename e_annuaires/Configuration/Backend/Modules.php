<?php

declare(strict_types=1);

use Emagineurs\EAnnuaires\Controller\Conf\ConfController;
use Emagineurs\EAnnuaires\Controller\Conf\FormController;
use Emagineurs\EAnnuaires\Controller\OffreController;

return [
    'web_EAnnuairesAnnuaires' => [
        'parent' => 'web',
        'position' => ['after' => 'web_list'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/web/EAnnuairesAnnuaires',
        'labels' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_annuaires.xlf',
        'iconIdentifier' => 'eannuaires-module-icon',
        'extensionName' => 'EAnnuaires',
        'controllerActions' => [
            ConfController::class => [
                'index', 'export', 'import', 'convert', 'createType'
            ],
            FormController::class => [
                'manageForm'
            ],
        ],
    ],
    'web_EAnnuairesAnnuaireoffre' => [
        'parent' => 'web',
        'position' => ['after' => 'web_EAnnuairesAnnuaires'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/web/EAnnuairesAnnuaireoffre',
        'labels' => 'LLL:EXT:e_annuaires/Resources/Private/Language/locallang_annuaires_offre.xlf',
        'iconIdentifier' => 'eannuaires-offre-module-icon',
        'extensionName' => 'EAnnuaires',
        'controllerActions' => [
            OffreController::class => [
                'candidatures', 'show', 'export'
            ],
        ],
    ],
];

