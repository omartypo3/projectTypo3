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

class GetOrginalViewHelper extends AbstractViewHelper {
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('uid','int','The record to be matched',true);
        $this->registerArgument('table','string','The record to be matched',true);

    }

    /**
     *
     * @return string
     */
    public function render()
    {
        $uid = $this->arguments['uid'];
        $table = $this->arguments['table'];

        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        $array = [];

        if($sys_language_uid != 0){
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
            $result = $queryBuilder
                ->select('*')
                ->from($table)
                ->where(
                    $queryBuilder->expr()->eq('l10n_parent', $uid)
                )
                ->andWhere(
                    $queryBuilder->expr()->eq('hidden', 0)
                )
                ->andWhere(
                    $queryBuilder->expr()->eq('deleted', 0)
                )
                ->andWhere(
                    $queryBuilder->expr()->eq('sys_language_uid', $sys_language_uid)
                )
                ->executeQuery();
            $rowtranslate = $result->fetchAssociative();

            if(!$rowtranslate){

                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
                $result = $queryBuilder
                    ->select('*')
                    ->from($table)
                    ->where(
                        $queryBuilder->expr()->eq('uid', $uid)
                    )
                    ->andWhere(
                        $queryBuilder->expr()->eq('hidden', 0)
                    )
                    ->andWhere(
                        $queryBuilder->expr()->eq('deleted', 0)
                    )
                    ->executeQuery();
                $row = $result->fetchAssociative();

                $queryBuilderlangug = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_pingagaddress_domain_model_language');
                $resultlangug = $queryBuilderlangug
                    ->select('*')
                    ->from('tx_pingagaddress_domain_model_language')
                    ->where(
                        $queryBuilder->expr()->eq('uid', $row['language'])
                    )
                    ->andWhere(
                        $queryBuilder->expr()->eq('hidden', 0)
                    )
                    ->andWhere(
                        $queryBuilder->expr()->eq('deleted', 0)
                    )
                    ->executeQuery();
                $rowlangug = $resultlangug->fetchAssociative();

                $queryBuilderlevel = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_pingagaddress_domain_model_level');
                $resultlevel = $queryBuilderlevel
                    ->select('*')
                    ->from('tx_pingagaddress_domain_model_level')
                    ->where(
                        $queryBuilder->expr()->eq('uid', $row['level'])
                    )
                    ->andWhere(
                        $queryBuilder->expr()->eq('hidden', 0)
                    )
                    ->andWhere(
                        $queryBuilder->expr()->eq('deleted', 0)
                    )
                    ->executeQuery();
                $rowlevel = $resultlevel->fetchAssociative();
                array_push($array,array('exist'=>0,'langugeOrgin'=>$rowlangug['name'],'levelOrgin'=>$rowlevel['name']));

            }else{
                array_push($array,array('exist'=>1));
            }

        }



        return $array[0];
    }
}

