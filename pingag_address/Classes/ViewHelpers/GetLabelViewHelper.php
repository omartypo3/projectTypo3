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

class GetLabelViewHelper extends AbstractViewHelper {
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

        $uid = $this->arguments['uid'];

       // \TYPO3\CMS\Core\Utility\DebugUtility::debug($uid);
        
        
        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
       // \TYPO3\CMS\Core\Utility\DebugUtility::debug($sys_language_uid);
        if($sys_language_uid !=0){
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_powermail_domain_model_field');
            $result = $queryBuilder
                ->select('*')
                ->from('tx_powermail_domain_model_field')
                ->where(
                    $queryBuilder->expr()->eq('l10n_parent', $uid)
                )
                ->andWhere(
                    $queryBuilder->expr()->eq('sys_language_uid', $sys_language_uid)
                )
                ->execute();
            $row = $result->fetch();

            $settingsString = $row['settings'] ?? '';
            // split by comma OR linebreak (both possible)
            $items = preg_split('/\r\n|\r|\n|,/', $settingsString);

            $result = [];

            foreach ($items as $item) {
                $item = trim($item);

                if ($item === '') {
                    continue;
                }

                $result[] = [
                    'label' => $item,
                    'value' => $item,
                    'selected' => 0
                ];
            }

            return ['title' => $row['title'] ?? '', 'settings' => $result];

        }else{
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_powermail_domain_model_field');
            $result = $queryBuilder
                ->select('*')
                ->from('tx_powermail_domain_model_field')
                ->where(
                    $queryBuilder->expr()->eq('uid', $uid)
                )
                ->execute();
            $row = $result->fetch();
             $settingsString = $row['settings'] ?? '';
            // split by comma OR linebreak (both possible)
            $items = preg_split('/\r\n|\r|\n|,/', $settingsString);

            $result = [];

            foreach ($items as $item) {
                $item = trim($item);

                if ($item === '') {
                    continue;
                }

                $result[] = [
                    'label' => $item,
                    'value' => $item,
                    'selected' => 0
                ];
            }
           return ['title' => $row['title'] ?? '', 'settings' => $result];
        }


    }
}

