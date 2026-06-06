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

class GetFieldViewHelper extends AbstractViewHelper {
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('uid','int','The record to be matched',true);
        $this->registerArgument('lang','int','The record to be matched',true);

    }

    /**
     *
     * @return string
     */
    public function render()
    {

        $uid = $this->arguments['uid'];
        $lang = $this->arguments['lang'];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable("tx_powermail_domain_model_field");
        $result = $queryBuilder
            ->select('uid')
            ->from("tx_powermail_domain_model_field")
            ->where(
                $queryBuilder->expr()->eq('l10n_parent', $uid)
            )
            ->andWhere(
                $queryBuilder->expr()->eq('sys_language_uid', $lang)
            )
            ->executeQuery();
        $row = $result->fetch();

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $FieldRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\FieldRepository');


        return $FieldRepository->findByUid($row['uid']);


    }
}

