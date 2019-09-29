<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 18.07.2018
 * Time: 16:50
 */

namespace Pingag\PingagJobs\Api;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

abstract class PeoplexsApiBase
{

    const SERVICE_URL_FORMAT = "https://escada.proinfirmis.ch/webservices/%s/service.asmx?WSDL";
    
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    protected $client;
    protected $settings;
    protected $sessionId;
    protected $defaultParameters;
    protected $portalId;

    /**
     * PeoplexsApiBase constructor.
     * @param null $portalId
     */
    public function __construct($portalId = null)
    {
        $this->portalId = $portalId;
        if(!$portalId){
            $this->portalId = self::getPortalId();
        }

        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');
        $settings = $configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
            'tx_pingag_jobs'
        );
        $this->settings = $settings['plugin.']['tx_pingagjobs.']['settings.']['peoplexsApi.'];

        $this->sessionId = $this->createSessionId();
        $this->defaultParameters = $this->getDefaultParameters();

        $this->client = new \SoapClient($this->getServiceUrl(), $this->getSoapOptions());
    }

    abstract protected function getServiceUrl();

    protected function call($method, array $arguments = [], array $options = [])
    {
        $arguments = $arguments + $this->defaultParameters;
        $result = $this->client->__soapCall($method, $arguments);

        return $result;
    }

    protected function getSoapOptions()
    {
        return [
            "soap_version" => SOAP_1_1,
            "trace" => 1
        ];
    }

    protected function getDefaultParameters()
    {
        return [
            'SessionID' => $this->sessionId,
            'SessionType' => 'user',
        ];
    }

    protected static function getPortalId()
    {
        switch ($_GET['L']){
            // fr
            case 1:
                $portalId = 15807;
                break;
            // de
            default:
                $portalId = 13597;
        }
        return $portalId;
    }

    protected function createSessionId()
    {
        $client = new \SoapClient(
            'https://ssl1.peoplexs.com/Portalxs/Webservices/v11/loginXS.cfc?wsdl',
            $this->getSoapOptions()
        );

        return $client->__soapCall('login', [
            'CompanyCode' => $this->settings['companyCode'],
            'Username' => $this->settings['username'],
            'Password' => $this->settings['password'],
            'UserType' => $this->settings['userType'],
        ]);
    }
}