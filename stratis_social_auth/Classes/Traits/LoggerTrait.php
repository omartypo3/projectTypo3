<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Traits;

use Psr\Log\LoggerInterface;
use Stratis\StratisSocialAuth\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

trait LoggerTrait
{
    /**
     * @param string $message
     */
    public function writeErrorToLog(string $message): void
    {
        if ((bool) ConfigurationUtility::getConfigurationValue('logErrors') === true) {
            /** @var LoggerInterface $logger */
            $logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
            $logger->log(LogLevel::ERROR, $message);
        }
    }
}
