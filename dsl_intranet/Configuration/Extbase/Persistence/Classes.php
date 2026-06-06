<?php

declare(strict_types=1);

return [

    \DslFactory\DslIntranet\Domain\Model\Benutzer::class => [
		'subclasses' => [
          'Tx_DslIntranet_Mitarbeiter' => \DslFactory\DslIntranet\Domain\Model\Mitarbeiter::class,
          'Tx_DslIntranet_Kunden' => \DslFactory\DslIntranet\Domain\Model\Kunden::class,
          'Tx_DslIntranet_Lieferanten' => \DslFactory\DslIntranet\Domain\Model\Lieferanten::class,
        ]
    ],
	
	\TYPO3\CMS\Extbase\Domain\Model\FrontendUser::class => [
        'subclasses' => [
          'Tx_DslIntranet_Benutzer' => \DslFactory\DslIntranet\Domain\Model\Benutzer::class, 
        ],
    ],
      
	\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup::class => [
        'subclasses' => [
          'Tx_DslIntranet_Fegroups' => \DslFactory\DslIntranet\Domain\Model\Fegroups::class,
          'Tx_DslIntranet_KundenFegroups' => \DslFactory\DslIntranet\Domain\Model\KundenFegroups::class,
        ],
    ],
    \DslFactory\DslIntranet\Domain\Model\Mitarbeiter::class => [
		'tableName' => 'fe_users',
		'recordType' => 'Tx_DslIntranet_Mitarbeiter',
    ],
	\DslFactory\DslIntranet\Domain\Model\Kunden::class => [
          'tableName' => 'fe_users',
          'recordType' => 'Tx_DslIntranet_Kunden',
    ],
	\DslFactory\DslIntranet\Domain\Model\Benutzer::class => [
		'tableName' => 'fe_users',
		'recordType' => 'Tx_DslIntranet_Benutzer',
    ],
	\DslFactory\DslIntranet\Domain\Model\Fegroups::class => [
        'tableName' => 'fe_groups',
        'recordType' => 'Tx_DslIntranet_Fegroups',
    ],
	\DslFactory\DslIntranet\Domain\Model\KundenFegroups::class => [
        'tableName' => 'fe_groups',
        'recordType' => 'Tx_DslIntranet_KundenFegroups',
    ],
	\DslFactory\DslIntranet\Domain\Model\KundenAgenturvertraege::class => [
        'tableName' => 'tx_dslintranet_domain_model_agenturvertraege',
        'recordType' => 'Tx_DslIntranet_KundenAgenturvertraege',
    ],
	\DslFactory\DslIntranet\Domain\Model\KundenDateien::class => [
        'tableName' => 'tx_dslintranet_domain_model_dateien',
        'recordType' => 'Tx_DslIntranet_KundenDateien',
    ],
	\DslFactory\DslIntranet\Domain\Model\KundenNews::class => [
        'tableName' => 'tx_dslintranet_domain_model_news',
        'recordType' => 'Tx_DslIntranet_KundenNews',
    ],
	\DslFactory\DslIntranet\Domain\Model\Lieferanten::class => [
		'tableName' => 'fe_users',
		'recordType' => 'Tx_DslIntranet_Lieferanten',
    ],
	\DslFactory\DslIntranet\Domain\Model\KundenStammdaten::class => [
		'tableName' => 'fe_users',
		//'recordType' => 'Tx_DslIntranet_KundenStammdaten',
		'recordType' => 'Tx_DslIntranet_Kunden',
    ],
	\DslFactory\DslIntranet\Domain\Model\FileReference::class => [
        'tableName' => 'sys_file_reference',
        'properties' => [
            'originalFileIdentifier' => [
                'fieldName' => 'uid_local',
            ],
        ],
    ],


];
