<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\UserFunc;

use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * Class UserFunc
 * @package Stratis\StratisSocialAuth\TCA
 */
class TCA
{
    /**
     * @param null|array $parameters
     * @param null $parentObject
     * @return string
     */
    public function getProviderIcon(array $parameters = null, $parentObject = null): string
    {
        $result = BackendUtility::getRecord('tx_stratissocialauth_domain_model_provider', $parameters['row']['provider'], 'type');

        if ($result !== null) {
            return 'stratis-socialauth-' . mb_strtolower($result['type']);
        }

        return 'default';
    }

    /**
     * @param null|array $parameters
     * @param null $parentObject
     */
    public function getProviderTitle(array &$parameters = null, $parentObject = null): void
    {
        $result = BackendUtility::getRecord('tx_stratissocialauth_domain_model_provider', $parameters['row']['provider'], 'title');

        $parameters['title'] = $result['title'];
    }
}
