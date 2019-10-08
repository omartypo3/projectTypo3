<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 27.07.2018
 * Time: 10:16
 */

namespace Pingag\PingagRealEstate\Task;

use Pingag\PingagRealEstate\Service\RealEstateImporter;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\ProgressProviderInterface;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

class ImportIdxFileTask extends AbstractTask implements ProgressProviderInterface
{

    /**
     * @var string
     */
    public $importSource;

    /**
     * @var \Pingag\PingagRealEstate\Service\RealEstateImporter
     */
    protected $importService;
    
    /**
     * @return bool
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function execute()
    {
        $this->importService = new RealEstateImporter();
        $this->importService->run($this->importSource);
        RealEstateImporter::resetProgress();
        return true;
    }
    
    public function stop()
    {
        parent::stop();
        RealEstateImporter::resetProgress();
    }
    
    public function getProgress()
    {
        return RealEstateImporter::getProgress();
    }
    
    
}