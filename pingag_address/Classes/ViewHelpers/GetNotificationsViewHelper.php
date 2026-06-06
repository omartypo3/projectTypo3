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

class GetNotificationsViewHelper extends AbstractViewHelper
{
    const PINGAG_IP = '196.179.244.127';
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('page', 'mixed', 'The record to be matched', true);
        $this->registerArgument('marker', 'string', 'markername', true);
    }

    /**
     *
     * @return string
     */
    public function render()
    {
        $pages = $this->arguments['page'];
        $table = $this->arguments['marker'];

        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();


        if($sys_language_uid !=0){

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_powermail_domain_model_field');
            $result = $queryBuilder
                ->select('*')
                ->from('tx_powermail_domain_model_field')
                ->where(
                    $queryBuilder->expr()->eq('marker', $queryBuilder->createNamedParameter($table))
                )
                ->execute();
            $row = $result->fetch();

            $queryBuilderFR = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_powermail_domain_model_field');
            $resultFR = $queryBuilderFR
                ->select('*')
                ->from('tx_powermail_domain_model_field')
                ->where(
                    $queryBuilder->expr()->eq('l10n_parent', $row['uid'])
                )
                ->andWhere(
                    $queryBuilder->expr()->eq('sys_language_uid', $sys_language_uid)
                )
                ->execute();
            $rowFR = $resultFR->fetch();

            return $rowFR['title'] ?? $row['title'];
            
        }else{
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_powermail_domain_model_field');
            $result = $queryBuilder
                ->select('*')
                ->from('tx_powermail_domain_model_field')
                ->where(
                    $queryBuilder->expr()->eq('marker', $queryBuilder->createNamedParameter($table))
                )
                ->execute();
            $row = $result->fetch();
            return $row['title'];
        }

        /*if($debug){
            \TYPO3\CMS\Core\Utility\DebugUtility::debug($row['title']);
            \TYPO3\CMS\Core\Utility\DebugUtility::debug($table);
        }*/
        

        /* foreach ($pages as $page) {
             $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_powermail_domain_model_page');
             $result = $queryBuilder
                 ->select('*')
                 ->from('tx_powermail_domain_model_page')
                 ->where(
                     $queryBuilder->expr()->eq('l10n_parent', $page->getUid())
                 )
                 ->andWhere(
                     $queryBuilder->expr()->eq('sys_language_uid', $sys_language_uid)
                 )
                 ->execute();
             $row = $result->fetch();
             $info = [];
             if($row['uid']) {

                 $queryBuilder01 = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_powermail_domain_model_field');
                 $result01 = $queryBuilder01
                     ->select('*')
                     ->from('tx_powermail_domain_model_field')
                     ->where(
                         $queryBuilder01->expr()->eq('page', $row['uid'])
                     )
                     ->andWhere(
                         $queryBuilder01->expr()->eq('sys_language_uid', $sys_language_uid)
                     )

                     ->execute();
                 $row01 = $result01->fetch();
                 while ($row01 = $result01->fetch()) {
                     // Do something with that single row
                      if($row01['marker'] == $table){
                         return $row01['title'];
                     }
                 }
             }else{
                 return;
             }
         }*/

        //  return ;
    }
}

