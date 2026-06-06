<?php

namespace Emagineurs\EGmap\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use Emagineurs\EGmap\Lib\EExtendedTables;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extensionmanager\Utility\InstallUtility;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * GeolocController
 */
class GeolocController extends ActionController
{

    protected string $siteExtPath;

    protected string $extPath;

    protected array $tsconfig = [];

    protected  array $ext_typoscript = [];

    protected array $typoscript = [];

    protected bool $erreurs = false;


    protected LanguageService $languageService;

    public function __construct(
        protected ConnectionPool $connectionPool,
        protected readonly PageRenderer $pageRenderer,
        protected LanguageServiceFactory $languageServiceFactory,
        protected EExtendedTables $extTables,
        protected InstallUtility $installUtility,
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    ) {}

    /**
     * initialize action
     */
    protected function initializeAction(): void
    {
        $this->languageService = $this->languageServiceFactory->createFromUserPreferences($GLOBALS['BE_USER']);
        $this->extPath = ExtensionManagementUtility::extPath('e_gmap');
        $publicResourcePath = PathUtility::getPublicResourceWebPath('EXT:e_gmap/Resources/Public/JavaScript/egmap.js');
        
        $this->siteExtPath = dirname(dirname(dirname(dirname($publicResourcePath)))) . '/';
        $this->initSettings();
        $this->extTables->setConf($this->extPath, $this->tsconfig, $this->ext_typoscript, $this);
    }

    /**
     * Summary of indexAction
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $this->extTables->check();
        $collection = $this->extTables->getCollection();

        $otherTables = [];
        foreach ($GLOBALS['TCA'] as $table => $conf) {
            if (!isset($collection[$table]) || !$collection[$table]->isOk) {
                $otherTables[] = $table;
            }
        }
        sort($otherTables);

         $this->pageRenderer->addJsFile(
            'EXT:e_gmap/Resources/Public/JavaScript/egmap-localize.js',
            'text/javascript',
            false, // compress
            false, // forceOnTop
            '',    // all
            true   // excludeFromConcatenation
        );

        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);

        $moduleTemplate->assignMultiple(array(
            'otherTables' => $otherTables,
            'extTables' => $collection,
            'request' => $this->request->getArguments()
        ));
       return $moduleTemplate->renderResponse('Geoloc/Index');
        
    }


    /**
     * action validate
     *
     * @return ResponseInterface
     */
    public function validateAction()
    {
        $request = $this->request->getArguments();

        //  form data is namespaced under tx_egmap_tools_egmapgeoloc, we unwrap it
        if (isset($request['tx_egmap_tools_egmapgeoloc']) && is_array($request['tx_egmap_tools_egmapgeoloc'])) {
            $request = array_merge($request, $request['tx_egmap_tools_egmapgeoloc']);
            unset($request['tx_egmap_tools_egmapgeoloc']);
        }

        unset($request['action']);
        unset($request['controller']);
        // Initialize required request parameters with default values if not set
        $requiredParams = ['key' => '', 'model' => '', 'table' => '', 'cat' => ''];


        foreach ($requiredParams as $param => $default) {
            if (!isset($request[$param])) {
                $request[$param] = $default;
            }
        }
        // Process key and model if they have values
        if (!empty($request['key'])) {
            $request['key'] = ucfirst($request['key']);
        }
        if (!empty($request['model']) && str_starts_with($request['model'], '\\')) {
            $request['model'] = substr($request['model'], 1);
        }
        $this->handleErreurs($request);
        if ($this->erreurs) {
           return $this->redirect('index', null, null, $request);
        }
        $key = $request['key'];
        $table = $request['table'];
        $model = $request['model'];
        $cat = $request['cat'];
        $res = $this->extTables->addExtTable($key, $table, $model, $cat);
        if ($res['error']) {
            $this->addMessage('Résultat des opérations:', $res, 'WARNING');
        } else {
            $this->addMessage('Résultat des opérations:', 'Ok.', 'OK');
        }
        return $this->redirect('index', null, null, arguments: $request);
        
    }

    /**
     * handleErreurs
     */
    public function handleErreurs(array $request): void
    {
        $this->erreurs = false;
        $header = 'Error: ' . $this->getLL('error');
        $key = trim($request['key'] ?? '');
        $table = trim($request['table'] ?? '');
        $model = trim($request['model'] ?? '');
        $cat = trim($request['cat'] ?? '');
        if ($key === '') {
            $message = $this->getLL('empty.key');
            $this->addErreur($header, $message);
        }
        if ($table === '') {
            $message = $this->getLL('empty.table');
            $this->addErreur($header, $message);
        }
        if ($model === '') {
            $message = $this->getLL('empty.model');
            $this->addErreur($header, $message);
        } else {
            try {
                GeneralUtility::makeInstance($model);
            } catch (\Exception $e) {
                $message = $this->getLL('error.model') . ' ' . $e->getMessage();
                $this->addErreur($header, $message);
            }
        }
        if (!empty($cat) && !empty($table)) {
            try {
                $connection = $this->connectionPool->getConnectionForTable($table);
                $columns = $connection->createSchemaManager()->listTableColumns($table);
                $listField = array_keys($columns);
                if (!in_array($cat, $listField, true)) {
                    $message = $this->getLL('error.cat');
                    $this->addErreur($header, $message);
                }
            } catch (\Exception $e) {
                $message = $this->getLL('error.cat');
                $this->addErreur($header, $message);
            }
        }
    }
    /**
     * Get label from locallang
     *
     * @param string $label The label key
     * @return string The translated label
     */
    public function getLL($label)
    {
        $locallang = 'LLL:EXT:e_gmap/Resources/Private/Language/locallang.xlf:' . $label;
        return $this->languageService->sL($locallang) ?: $label;
    }
    public function addErreur($header, $message)
    {
        $this->erreurs = true;
        $this->addMessage($header, $message, 'ERROR');
    }
    public function addMessage($header, $message, $level = 'NOTICE')
    {
        if (!is_string($message)) {
            ob_start();
            var_dump($message);
            $message = ob_get_clean();
        }
        switch ($level) {
            case 'OK':
                $level = ContextualFeedbackSeverity::OK;
                break;
            case 'INFO':
                $level = ContextualFeedbackSeverity::INFO;
                break;
            case 'NOTICE':
                $level = ContextualFeedbackSeverity::NOTICE;
                break;
            case 'WARNING':
                $level = ContextualFeedbackSeverity::WARNING;
                break;
            case 'ERROR':
                $level = ContextualFeedbackSeverity::ERROR;
                break;
            default:
                $level = ContextualFeedbackSeverity::NOTICE;
                break;
        }
        $this->addFlashMessage(
            $message,
            $header, // the header is optional
            $level, // the severity is optional as well and defaults to \TYPO3\CMS\Core\Messaging\FlashMessage::OK
            true // optional, whether the message should be stored in the session or only in the \TYPO3\CMS\Core\Messaging\FlashMessageQueue object (default is FALSE)
        );
    }

    public function initSettings()
    {
        $this->typoscript = $this->settings;
        $this->ext_typoscript = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'e_gmap'
        );
        $this->tsconfig = BackendUtility::getPagesTSconfig(0);
    }
    public function getInstallUtility()
    {
        return $this->installUtility;
    }
}
