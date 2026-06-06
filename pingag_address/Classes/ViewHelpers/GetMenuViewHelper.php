<?php
/**
 * Created by Visual Studio Code.
 * User: markus
 * Date: 26.06.17
 * Time: 15:57
 */

namespace Pingag\PingagAddress\ViewHelpers;

use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\Resource\FileCollector;
use Pingag\PingagClicConnector\Domain\Repository\ServiceRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;

class GetMenuViewHelper extends AbstractViewHelper {
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('uid','int','The record to be matched',true);

    }

    /**
     *
     * @return string
     */
    public function render()
    {
        $langs = [];
        $langs[0] = 0;
        $uid = $this->arguments['uid'];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $result = $queryBuilder
            ->select('*')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('l10n_parent', $uid)
            )
            ->andWhere(
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->andWhere(
                $queryBuilder->expr()->eq('deleted', 0)
            )
            ->executeQuery();
        while ($row = $result->fetchAssociative()) {
            // Do something with that single row
            array_push($langs,$row['sys_language_uid']);
        }


        return $langs;
    }
}

