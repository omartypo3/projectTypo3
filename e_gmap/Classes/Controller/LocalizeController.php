<?php

namespace Emagineurs\EGmap\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\CMS\Core\FormProtection\FormProtectionInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use Psr\Http\Message\ResponseInterface;
use Emagineurs\EGmap\Lib\LocalizeRecordList;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Routing\UriBuilder as BackendUriBuilder;

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
 * LocalizeController
 */
class LocalizeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected int $id;
    protected array $tsconfig = [];
    protected string $siteExtPath = '';
    protected string $extPath = '';
    protected bool $erreurs = false;

    protected LanguageService $languageService;

    public function __construct(
        protected  readonly FormProtectionFactory $formProtectionFactory,
        protected readonly LocalizeRecordList $recordList,
        protected readonly PageRenderer $pageRenderer,
        protected readonly ConnectionPool $connectionPool,
        protected readonly LanguageServiceFactory $languageServiceFactory,
        protected readonly ModuleTemplateFactory $moduleTemplateFactory
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
    }
    /**
     * action index
     *
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $tables = $this->recordList->getTableList();
        $table = isset($this->request->getParsedBody()['tx_egmap_web_egmapgmap']['table']) ? $this->request->getParsedBody()['tx_egmap_web_egmapgmap']['table'] : false;
        $rows = $this->recordList->getRows($table);
        $formProtection = $this->formProtectionFactory->createForType('backend');
        $urlToken = '&updateLocalize=' . $formProtection->generateToken('updateLocalize');

        $this->pageRenderer->addJsFile(
            'EXT:e_gmap/Resources/Public/JavaScript/egmap-localize.js',
            'text/javascript',
            false, // compress
            false, // forceOnTop
            '',    // all
            true   // excludeFromConcatenation
        );

        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $menus = $this->buildBackendMenu($moduleTemplate);
        
        $moduleTemplate->assignMultiple(array(
            'tables' => $tables,
            'request' => $table,
            'rows' => $rows,
            'pageid' => $this->id,
            'confok' => (is_array($this->tsconfig) && count($this->tsconfig) > 0),
            'urlUpdate' => 'index.php?ajaxID=EGmapLocalizeUpdate&ajaxCall=1' . $urlToken,
            'menus' => $menus
        ));
       return $moduleTemplate->renderResponse('Localize/Index');


    }
    public function updateAction(ServerRequestInterface $request): bool
    {
        $formProtection = $this->formProtectionFactory->createForType('backend');
        $queryParams = ($request->getParsedBody() ?? []) + $request->getQueryParams();
        // Validate form token
        if ($formProtection->validateToken($queryParams['updateLocalize'] ?? '', 'updateLocalize')) {
            $id  = $queryParams['egmap_id'] ?? 0;
            $key = $queryParams['egmap_key'] ?? '';
            $lat = $queryParams['egmap_lat'] ?? '';
            $lng = $queryParams['egmap_lng'] ?? '';
            // Extract table and UID
            $parts = explode('_', $key);
            $uid = (int)array_pop($parts);
            $table = implode('_', $parts);
            // Get TSconfig for table
            $conf = BackendUtility::getPagesTSconfig((int)$id);
            $conf = $conf['tx_egmap_localize.'][$table . '.'] ?? [];
            $fieldLat = $conf['lat'] ?? 'latitude';
            $fieldLng = $conf['lng'] ?? 'longitude';
            $fields = [
                $fieldLat => $lat,
                $fieldLng => $lng,
            ];

            $connection = $this->connectionPool->getConnectionForTable($table);
            $connection->update(
                $table,
                $fields,
                ['uid' => $uid]
            );
            return true;
        }
        return false;
    }

    protected function initSettings(?ServerRequestInterface $request = null): void
    {
        // Get the page ID from the request
        $queryParams = $request ?
            ($request->getQueryParams() + ($request->getParsedBody() ?? [])) : ($GLOBALS['TYPO3_REQUEST'] ?
                ($GLOBALS['TYPO3_REQUEST']->getQueryParams() + ($GLOBALS['TYPO3_REQUEST']->getParsedBody() ?? [])) :
                []);
        $this->id = (int)($queryParams['id'] ?? 0);
        if ($this->id > 0) {
            $this->tsconfig = BackendUtility::getPagesTSconfig($this->id);
            $this->tsconfig = $this->tsconfig['tx_egmap_localize.'] ?? [];
            $this->recordList->setConf($this->tsconfig, $this->id);
        } else {
            $this->tsconfig = [];
        }
    }
    /**
     * Get label from locallang
     *
     * @return void
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
                $level = ContextualFeedbackSeverity::INFO;
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
        $this->addFlashMessage($message, $header, $level, true);
    }

    protected function buildBackendMenu(ModuleTemplate $moduleTemplate): array
    {
        $menu = $moduleTemplate->getDocHeaderComponent()
            ->getMenuRegistry()
            ->makeMenu();

        $menu->setIdentifier('mapModuleDropdown');

        $items = [
            ['label' => 'Géolocalisation',     'controller' => 'Localize', 'action' => 'index'],
            ['label' => 'Placement de points', 'controller' => 'Map',      'action' => 'placement'],
        ];

        $moduleName = 'web_EGmapGmap';
        $backendUriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Backend\Routing\UriBuilder::class);

        $menuItems = [];
        $pageId = $this->id; 

        foreach ($items as $item) {
            // Build backend module URL
            $uri = (string)$backendUriBuilder->buildUriFromRoute(
                $moduleName,
                [
                    'M'          => $moduleName,
                    'controller' => $item['controller'],
                    'action'     => $item['action'],
                    'id' => $pageId
                ]
            );

            // Detect active item
            $active = ($this->request->getControllerName() === $item['controller']);

            // Add menu item to TYPO3 menu
            $menu->addMenuItem(
                $menu->makeMenuItem()
                    ->setTitle($item['label'])
                    ->setHref($uri)
                    ->setActive($active)
            );

            // Also build array for Fluid
            $menuItems[] = [
                'title'  => $item['label'],
                'href'   => $uri,
                'active' => $active
            ];
        }

        // Register the menu in TYPO3
        $moduleTemplate->getDocHeaderComponent()
            ->getMenuRegistry()
            ->addMenu($menu);

        // Return array for Fluid template
        return $menuItems;
    }



}
