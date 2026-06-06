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

class GetKantonViewHelper extends AbstractViewHelper {
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
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $eventRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\KantoneRepository');
        $uid = $this->arguments['uid'];


        return  $eventRepository->findByUid((int)$uid);
    }
}

