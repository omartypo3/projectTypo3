<?php

namespace Emagineurs\EAnnuaires\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

class ConfService
{

    public function getCantonItems(): array
    {

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tx_eannuaires_domain_model_typeannuaire');

        $items = $queryBuilder
            ->select('t.*', 'c.*')
            ->from('tx_eannuaires_domain_model_typeannuaire', 't')
            ->join(
                't',
                'tx_eannuaires_domain_model_champbdd',
                'c',
                $queryBuilder->expr()->eq('c.typeannuaire', $queryBuilder->quoteIdentifier('t.uid'))
            )

            ->executeQuery()
            ->fetchAllAssociative();

        foreach ($items as $item) {

            $config['items'][] = [$item['title'], $item['uid']];
        }

        return $config;
    }
}
