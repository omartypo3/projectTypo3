<?php

namespace Emagineurs\EGmap\Controller;


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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use Symfony\Component\HttpFoundation\JsonResponse;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use Emagineurs\EGmap\Domain\Repository\PoiRepository;
use Emagineurs\EGmap\Domain\Repository\KmlRepository;
use Emagineurs\EGmap\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Backend\Routing\UriBuilder as BackendUriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

/**
 * MapController
 */
class MapController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected array $otherRepository = [];
    protected array $confTS = [];

    public static int $uniqId = 0;

    protected string $siteExtPath;

    protected int  $contentUid;

    protected array $allPois = [];

    protected array  $pagination = [];

    protected int $pageId;
    protected array $conf = [];

    protected LanguageService $languageService;
    public function __construct(
        ConfigurationManagerInterface $configurationManager,
        protected readonly ExtensionConfiguration $extensionConfiguration,
        protected readonly PoiRepository $poiRepository,
        protected readonly KmlRepository $kmlRepository,
        protected readonly CategoryRepository $categoryRepository,
        protected readonly ContentObjectRenderer $contentObject,
        protected readonly PageRenderer $pageRenderer,
        protected readonly LanguageServiceFactory $languageServiceFactory,
        protected readonly CacheManager $cacheManager,
        protected readonly UriBuilder $backendUriBuilder,
        protected readonly PersistenceManager $persistenceManager,
        protected readonly ModuleTemplateFactory $moduleTemplateFactory
    ) {
    }

    /**
     * Summary of initializeAction
     * @return void
     */
    protected function initializeAction(): void
    {
        $this->languageService = $this->languageServiceFactory->createFromUserPreferences($GLOBALS['BE_USER']);
        $publicResourcePath = PathUtility::getPublicResourceWebPath('EXT:e_gmap/Resources/Public/JavaScript/egmap.js');
        $this->siteExtPath = dirname(dirname(dirname(dirname($publicResourcePath)))) . '/';

        $this->initSettings();
        $this->contentUid = $this->contentObject->data['uid'] ?? 0;
    }

    /**
     * Summary of mapAction
     * @return ResponseInterface
     */
    public function mapAction(): ResponseInterface
    {
        $this->addJsLibs();
        $this->addMapJs();

        $this->view->assignMultiple(array(
            'settings' => $this->settings,
            'cats' => $this->getAllCats(),
            'pois' => $this->allPois,
            'eGmapPois' => $this->getPois(),
            'eGmapKmls' => $this->getKmls()
        ));
        return $this->htmlResponse();
    }



    /**
     * Summary of placementAction
     * @return ResponseInterface
     */
    public function placementAction(): ResponseInterface
    {
        // Load extension configuration to get API key
        $extConf = $this->extensionConfiguration->get('e_gmap');
        $extConfArray = is_string($extConf) ? @unserialize($extConf) : [];

        // Set up Google Maps API
        $this->settings['includeJs']['gmap'] = true;
        $this->settings['apiKey'] = $extConfArray['googleMapsApiKey'] ?? '';
        $this->settings['map']['recherche']['actif'] = '1';
        $this->settings['map']['itineraire']['actif'] = '0';

        // Add Google Maps API with callback


        $this->addJsLibs(false);
        $this->addMapJs();

        $this->allPois = [];
        $this->pagination = [];

        foreach ($this->otherRepository as $repository) {
            $pois = $repository->findAllOriginal($this->pageId);
            foreach ($pois as $poi) {
                array_push($this->allPois, $poi);
            }
        }
        $pois = $this->poiRepository->findAllOriginal($this->pageId);
        foreach ($pois as $poi) {
            array_push($this->allPois, $poi);
        }
        foreach ($pois as $key => $poi) {
            if (is_int($key / 10)) {
                array_push($this->pagination, ($key / 10) + 1);
            }
        }

        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $menuItems = $this->buildBackendMenu($moduleTemplate);

        $moduleTemplate->assignMultiple(array(
            'settings' => $this->settings,
            'cats' => $this->getAllCats(),
            'pois' => $this->allPois,
            'pageId' => $this->pageId,
            'pagination' => $this->pagination,
            'menus'    => $menuItems
        ));
        $response = $moduleTemplate->renderResponse('Map/Placement');
        $cspHeader = $this->buildContentSecurityPolicyHeader();
        if ($cspHeader !== '') {
            $response = $response->withHeader('Content-Security-Policy', $cspHeader);
        }

        return $response;
    }

    /**
     * Summary of newPoiAction
     * @return JsonResponse
     */
    public function newPoiAction(): JsonResponse
    {
        // Fetch GET/POST parameters
        $pageId = (int)($this->request->getQueryParams()['pageId'] ?? 0);
        $lat = $this->request->getQueryParams()['lat'] ?? '';
        $lng = $this->request->getQueryParams()['lng'] ?? '';
        $address = $this->request->getQueryParams()['address'] ?? '';
        $city = $this->request->getQueryParams()['city'] ?? '';
        $code = $this->request->getQueryParams()['code'] ?? '';
        $country = $this->request->getQueryParams()['country'] ?? '';

        // Build return URL
        $returnUrl = $this->backendUriBuilder->buildUriFromRoute(
            'web_EGmapGmap',
            [
                'tx_egmap_web_egmapgmap' => [
                    'controller' => 'Map',
                    'action' => 'placement'
                ],
                'id' => $pageId
            ]
        );

        // Build edit URL for creating a new record
        $table = 'tx_egmap_domain_model_poi';
        $editUrl = $this->backendUriBuilder->buildUriFromRoute(
            'record_edit',
            [
                'edit' => [
                    $table => [
                        $pageId => 'new'
                    ]
                ],
                'defVals' => [
                    $table => [
                        'lat' => $lat,
                        'lng' => $lng,
                        'adresse' => $address,
                        'ville' => $city,
                        'code' => $code,
                        'pays' => $country
                    ]
                ],
                'returnUrl' => $returnUrl
            ]
        );

        // Generate output URL
        $output = $editUrl;

        $data = [
            'output' => htmlspecialchars($output),
            'text' => $this->getLL('be.button.newPoint')
        ];

        return new JsonResponse($data);
    }

    /**
     * Summary of editPoiAction
     */
    public function editPoiAction(): JsonResponse
    {
        $queryParams = $this->request->getQueryParams();
        $pageId = (int)($queryParams['pageId'] ?? 0);
        $uid = (int)($queryParams['uid'] ?? 0);
        $type = $queryParams['type'] ?? '';
        $table = $queryParams['table'] ?? '';

        $moduleReturnUrl = $this->backendUriBuilder->buildUriFromRoute(
            'web_EGmapGmap',
            [
                'tx_egmap_web_egmapgmap' => [
                    'controller' => 'Map',
                    'action' => 'placement'
                ],
                'id' => $pageId
            ]
        );

        // Build edit URL for editing an existing record
        $editUrl = $this->backendUriBuilder->buildUriFromRoute(
            'record_edit',
            [
                'edit' => [
                    $table => [
                        $uid => 'edit'
                    ]
                ],
                'returnUrl' => $moduleReturnUrl
            ]
        );

        return new JsonResponse([
            'output' => htmlspecialchars($editUrl),
            'text' => $this->getLL('be.button.editPoint')
        ]);
    }

    /**
     * Summary of updatePoiAction
     */
    public function updatePoiAction(): JsonResponse
    {
        $queryParams = $this->request->getQueryParams();
        $uid = (int)($queryParams['uid'] ?? 0);
        $type = $queryParams['type'] ?? '';
        $lat = (float)($queryParams['lat'] ?? 0.0);
        $lng = (float)($queryParams['lng'] ?? 0.0);

        if ($uid <= 0 || $type === '') {
            return new JsonResponse(['error' => 'Invalid parameters'], 400);
        }

        $repository = $this->getRepository($type);
        $localizedObject = $repository->findByUid($uid);
        $localizedObject->setLat($lat);
        $localizedObject->setLng($lng);
        $repository->update($localizedObject);
        $this->persistenceManager->persistAll();

        return new JsonResponse([
            'success' => true,
            'message' => 'POI updated successfully',
            'uid' => $uid,
            'lat' => $lat,
            'lng' => $lng,
        ]);
    }

    /**
     * Summary of infoAction
     */
    public function infoAction()
    {
        $queryParams = $this->request->getQueryParams();

        $uid = (int)($queryParams['uid'] ?? 0);
        $type = ucfirst($queryParams['type'] ?? '');
        $key = (int)($queryParams['key'] ?? 0);

        if ($uid <= 0 || $type === '') {
            return '';
        }

        $movePoint = $this->getLL('be.button.movePoint');
        $savePoint = $this->getLL('be.button.savePoint');
        $editPoint = $this->getLL('be.button.editPoint');

        $detailLink = "";

        if (!empty($this->settings['detail'][$type]) && !empty($this->settings['detail'][$type]['page']) && !empty($this->settings['detail'][$type]['param'])) {

            $contentObjectRenderer = $GLOBALS['TSFE']->cObj ?? null;
            if ($contentObjectRenderer instanceof ContentObjectRenderer) {
                $detailLink = $contentObjectRenderer->typoLink_URL(
                    [
                        'parameter' => $this->settings['detail'][$type]['page'],
                        'additionalParams' => '&' . $this->settings['detail'][$type]['param'] . '=' . $uid,
                    ]
                );
            }
        }

        $repository = $this->getRepository($type);
        $infos = $repository?->findByUid($uid);

        if (!$infos) {
            return '';
        }
        $dataXml = $this->getContentTemplate(
            $this->getTemplatePath($type, 'html'),
            [
                'key' => $key,
                'type' => $type,
                'infos' => $infos,
                'movePoint' => $movePoint,
                'savePoint' => $savePoint,
                'editPoint' => $editPoint,
                'detailLink' => $detailLink,
            ]
        );

        return $dataXml;
    }

    public function initSettings(): void
    {

        if (empty($this->settings)) {
            $this->getConfTs('EGmap', 'choosePoi');
        }


        $this->pageId = (int)($this->request->hasArgument('id') ? $this->request->getArgument('id') : 0);

        if (($this->settings['view'] ?? '') === 'module') {
            $this->settings['pois'] = 'pages_' . $this->pageId;
        }

        $this->getConf('EGmap');


        $this->settings['map']['id'] = $this->pageId;
        $this->settings['map']['mapUniqId'] = ++self::$uniqId;


        $pageTsConfig = BackendUtility::getPagesTSconfig($this->pageId);
        $this->confTS = $pageTsConfig['tx_egmap_conf.'] ?? [];


        $defaultSettings = [
            'apiKey' => 'AIzaSyDQBDmPgddvjaxlOjI-XA-LSm4_Z1je2ik',
            'width' => '100%',
            'height' => '300px',
        ];

        foreach ($defaultSettings as $key => $value) {
            if (empty($this->settings[$key])) {
                $this->settings[$key] = $value;
            }
        }


        foreach (['styles', 'cluster.styles'] as $keyPath) {
            $keys = explode('.', $keyPath);
            $target = &$this->settings;
            foreach ($keys as $key) {
                if (!isset($target[$key])) {
                    continue 2;
                }
                $target = &$target[$key];
            }
            $target = str_replace([" ", "\n", "\r", "\t"], '', (string)$target);
        }


        $allPois = [];
        $args = $this->request->getArguments();
        if (!empty($args['pois'])) {
            $allPois = $this->setListInArray($args['pois'], $allPois, 1);
        }
        if (!empty($this->settings['pois'])) {
            $allPois = $this->setListInArray($this->settings['pois'], $allPois);
        }
        $this->settings['pois'] = $allPois;


        $this->poiRepository->setSettings($this->settings, 'categorie');
        $this->kmlRepository->setSettings($this->settings, 'categorie');


        if (!empty($this->confTS['extensions.']) && is_array($this->confTS['extensions.'])) {
            foreach ($this->confTS['extensions.'] as $key => $conf) {
                $table = strtolower(substr($key, 0, -1));
                $repositoryClass = sprintf('Emagineurs\\EGmap\\Domain\\Repository\\%sRepository', ucfirst($table));

                if (class_exists($repositoryClass)) {
                    /** @var object $repository */
                    $repository = GeneralUtility::makeInstance($repositoryClass);
                    $catField = $conf['cat'] ?? false;
                    if (method_exists($repository, 'setSettings')) {
                        $repository->setSettings($this->settings, $catField);
                    }
                    $this->otherRepository[$table] = $repository;
                }
            }
        }


        $mapCenter = $this->settings['map']['center'] ?? [];
        if (($mapCenter['type'] ?? '') === 'poi' && !empty($mapCenter['poi'])) {
            $poi = $this->getPoiModel((int)$mapCenter['poi']);
            if ($poi && method_exists($poi, 'isPlaceable') && $poi->isPlaceable()) {
                $this->settings['map']['center']['lat'] = $poi->getLat();
                $this->settings['map']['center']['lng'] = $poi->getLng();
            }
        }
    }

    public function addJsLibs(bool $useKml = true): void
    {

        $extConf = $this->extensionConfiguration->get('e_gmap');
        $extConfArray = is_string($extConf) ? @unserialize($extConf) : [];
        $mapEngine = is_array($extConfArray) ? ($extConfArray['mapEngine'] ?? 'gmap') : 'gmap'; // Default to 'gmap' if not set

        // Ensure settings exist
        $includeJs = $this->settings['includeJs'] ?? [];
        $mapSettings = $this->settings['map'] ?? [];
        if ($mapEngine === 'leaflet') {
            // --- Leaflet core ---
            if (!empty($includeJs['gmap'])) {
                $this->pageRenderer->addCssLibrary($this->siteExtPath . 'Resources/Public/Css/leaflet/leaflet.css');
                $this->pageRenderer->addJsLibrary(
                    'Leaflet Api',
                    $this->siteExtPath . 'Resources/Public/JavaScript/Leaflet/Leaflet.js',
                    'text/javascript',
                    false,
                    true,
                    '',
                    true
                );

                if ($useKml) {
                    $this->pageRenderer->addJsLibrary(
                        'Leaflet Api Kml',
                        $this->siteExtPath . 'Resources/Public/JavaScript/Leaflet/Omnivore.js',
                        'text/javascript',
                        false,
                        false,
                        '',
                        true
                    );
                }
            }

            // --- Marker cluster ---
            $clusterActive = $mapSettings['cluster']['actif'] ?? false;
            if ($clusterActive) {
                $this->pageRenderer->addCssLibrary($this->siteExtPath . 'Resources/Public/Css/Leaflet/MarkerCluster.css');
                $this->pageRenderer->addCssLibrary($this->siteExtPath . 'Resources/Public/Css/Leaflet/MarkerCluster.Default.css');
                $this->pageRenderer->addJsLibrary(
                    'Leaflet Api Marker Cluster',
                    $this->siteExtPath . 'Resources/Public/JavaScript/Leaflet/Markercluster.js',
                    'text/javascript',
                    false,
                    false,
                    '',
                    true
                );
            }

            // --- Geocoder / Search / Routing ---
            $searchActive = $mapSettings['recherche']['actif'] ?? false;
            $routeActive = $mapSettings['itineraire']['actif'] ?? false;

            if ($searchActive || $routeActive) {
                $this->pageRenderer->addCssLibrary($this->siteExtPath . 'Resources/Public/Css/Leaflet/Geocoder.css');
                $this->pageRenderer->addJsLibrary(
                    'Leaflet Geocoder API',
                    $this->siteExtPath . 'Resources/Public/JavaScript/Leaflet/Geocoder.js',
                    'text/javascript',
                    false,
                    false,
                    '',
                    true
                );
            }

            if ($routeActive) {
                $this->pageRenderer->addCssFile($this->siteExtPath . 'Resources/Public/Css/Leaflet/leaflet-routing-machine.css');
                $this->pageRenderer->addJsFile($this->siteExtPath . 'Resources/Public/JavaScript/Leaflet/Routing.js');
            }
        } else {
            // --- Google Maps ---
            if (!empty($includeJs['gmap'])) {
                $apiKey = $this->settings['apiKey'];
                $apiUrl = 'https://maps.googleapis.com/maps/api/js?key=' . $apiKey;
                $this->pageRenderer->addJsLibrary('Google Map Api', $apiUrl, 'text/javascript', false, false, '', true);
            }

            // --- Marker Clusterer ---
            $clusterActive = ($mapSettings['cluster']['actif'] ?? 0) == 1;
            $markerClusterInclude = !empty($includeJs['markerclusterer']);

            if ($clusterActive && $markerClusterInclude) {
                $file = $this->siteExtPath . 'Resources/Public/JavaScript/markerclusterer.js';

                if (!empty($includeJs['markerclusterer']['file'])) {
                    $filePath = GeneralUtility::getFileAbsFileName($includeJs['markerclusterer']['file']);
                    $file = str_replace(
                        Environment::getPublicPath() . '/',
                        GeneralUtility::getIndpEnv('TYPO3_SITE_URL'),
                        $filePath
                    );
                }

                $this->pageRenderer->addJsLibrary('Google Map Library - MarkerClusterer', $file);
            }
        }
    }


    public function addMapJs(): void
    {

        $assignsJs = [
            'eGmapSettings' => json_encode($this->settings),
        ];

        $params = $this->request->getParsedBody()['P']
            ?? $this->request->getQueryParams()['P']
            ?? null;

        // Handle wizard view
        if (($this->settings['view'] ?? '') === 'wizard' && is_array($params)) {
            $params['latName'] = str_replace(['lng', '_hr'], ['lat', ''], $params['itemName']);
            $params['lngName'] = str_replace(['lat', '_hr'], ['lng', ''], $params['itemName']);
            $assignsJs['params'] = json_encode($params);
        }


        if (($this->settings['view'] ?? '') !== 'wizard' && !empty($this->settings['pois'])) {
            $assignsJs['eGmapPois'] = $this->getPois();
            $assignsJs['eGmapKmls'] = $this->getKmls();
        }


        if (($this->settings['view'] ?? '') === 'module') {
            $assignsJs['eGmapPois'] = $this->getPois();
        }


        // Render map JS
        $mapJs = $this->getContentTemplate($this->getTemplatePath('map', 'js'), $assignsJs);
        //$this->pageRenderer->addJsInlineCode('Google Map Loader ' . ($this->settings['map']['mapUniqId'] ?? ''), $mapJs);

        // Get the current CSP nonce from TYPO3 (if available)
        /*$nonce = $GLOBALS['TYPO3_REQUEST']?->getAttribute('nonce') ?? '';

        // Add inline JavaScript with nonce and type
        $this->pageRenderer->addJsInlineCode(
            'Google Map Loader ' . ($this->settings['map']['mapUniqId'] ?? ''),
            $mapJs,
            false, // compress
            false, // forceOnTop
            'text/javascript', // script type
            $nonce // CSP nonce
        );*/

        // ✅ Load jQuery manually
        $this->pageRenderer->addJsFile(
            'https://code.jquery.com/jquery-3.7.1.min.js',
            'text/javascript',
            false, // compress
            false, // forceOnTop
            '',    // all
            true   // excludeFromConcatenation
        );

        // ✅ Get CSP nonce
        $nonce = $GLOBALS['TYPO3_REQUEST']?->getAttribute('nonce') ?? '';

        // Your map JS (rendered content)
        $mapJs = $this->getContentTemplate(
            $this->getTemplatePath('map', 'js'),
            $assignsJs
        );

        // ✅ Inline JS using jQuery safely
        $this->pageRenderer->addJsInlineCode(
            'Google Map Loader ' . ($this->settings['map']['mapUniqId'] ?? ''),
            <<<JS
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.jQuery !== 'undefined') {
                const $ = window.jQuery;
                {$mapJs}
            }
        });
        JS,
            false,
            false,
            'text/javascript',
            $nonce
        );


        $extConf = $this->extensionConfiguration->get('e_gmap') ?? [];
        $mapEngine = $extConf['mapEngine'] ?? 'gmap';


        $scriptPath = $mapEngine === 'leaflet'
            ? 'EXT:e_gmap/Resources/Public/JavaScript/Leaflet.js'
            : 'EXT:e_gmap/Resources/Public/JavaScript/egmap.js';


        $this->pageRenderer->addJsFile(
            $scriptPath,
            'text/javascript',
            false, // compress
            true, // concatenate
            '',    // external JS file section
            false   // forceOnTop (adds in HEAD)
        );
    }

    /**
     * Build the Content-Security-Policy header required for Google Maps assets.
     */
    protected function buildContentSecurityPolicyHeader(): string
    {
        $directives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://maps.googleapis.com https://maps.gstatic.com https://code.jquery.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://maps.gstatic.com https://maps.googleapis.com",
            "img-src 'self' data: https://maps.googleapis.com https://maps.gstatic.com https://maps.google.com https://csi.gstatic.com https://lh3.googleusercontent.com",
            "connect-src 'self' https://maps.googleapis.com https://maps.gstatic.com https://maps.google.com",
            "font-src 'self' data: https://fonts.gstatic.com https://maps.gstatic.com",
            "frame-src 'self' https://www.google.com https://maps.google.com",
            "media-src 'self' https://maps.gstatic.com",
            "object-src 'none'"
        ];

        return implode('; ', $directives);
    }

    public function getPois()
    {
        $cacheContent = $this->cacheManager->getCache('egmap');
        $poisFromCache = $cacheContent->get('egmap-pois-' . $this->contentUid);
        // $cache->remove( 'auniqueidentifier' );
        if ($poisFromCache === false) {
            $pois = $this->poiRepository->findAll();
            $poiArgs = array(
                'items' => $pois,
                'table' => 'tx_egmap_domain_model_poi',
                'type' => !empty($this->settings['map']['poiTemplate']) ? $this->settings['map']['poiTemplate'] : 'Poi',
                'site' => GeneralUtility::getIndpEnv('TYPO3_SITE_URL'),
            );
            $this->allPois = array();
            if (!empty($pois) && count($pois) > 0) {
                $this->allPois[] = $poiArgs;
            }
            $poiXml = $this->getContentTemplate($this->getTemplatePath('poi', 'xml'), $poiArgs);
            $allXml = trim($poiXml ?? '');
            if (!empty($this->confTS['extensions.']) && is_array($this->confTS['extensions.'])) {
                foreach ($this->confTS['extensions.'] as $key => $conf) {
                    $table = strtolower(substr($key, 0, -1));
                    $items = $this->otherRepository[$table]->findAll();
                    $itemArgs = array(
                        'items' => $items,
                        'table' => $conf['table'],
                        'type' => $table,
                        'site' => GeneralUtility::getIndpEnv('TYPO3_SITE_URL'),
                    );
                    if (!empty($items) && count($items) > 0) {
                        $this->allPois[] = $itemArgs;
                    }
                    $itemsXml = $this->getContentTemplate($this->getTemplatePath($table, 'xml'), $itemArgs);
                    $allXml .= trim($itemsXml ?? '');
                }
            }
            $allXml = trim($allXml ?? '');
            if (!empty($allXml)) {
                $allXml = '<pois>' . $allXml . '</pois>';
                $allArray = simplexml_load_string($allXml);
            } else {
                $allArray = array();
            }

            $result = json_encode($allArray);

            $cacheContent->set('egmap-pois-' . $this->contentUid, $result);
        } else {
            $result = $poisFromCache;
        }

        return $result;
    }

    public function getContentTemplate($template, $assigns)
    {
        $tmpView = GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $mainTemplate = GeneralUtility::getFileAbsFileName($template);
        $tmpView->setTemplatePathAndFilename($mainTemplate);
        if (is_array($assigns)) {
            $tmpView->assignMultiple($assigns);
        }
        return $tmpView->render();
    }

    public function getTemplatePath($type, $ext)
    {
        $type = ucfirst($type);
        $ext = strtolower($ext);
        $template = $this->getRightTemplatePath('Map/' . $type . '.' . $ext);
        return $template;
    }

    public function getRightTemplatePath($file)
    {
        if (!empty($this->conf['view']['templateRootPath'])) {
            $path = $this->conf['view']['templateRootPath'];
            if (substr($path, -1) !== '/') {
                $path .= '/';
            }
            if ($this->isFile($path . $file)) {
                return $path . $file;
            }
        }

        if (is_array($this->conf['view']['templateRootPaths'])) {
            $paths = \TYPO3\CMS\Core\Utility\ArrayUtility::sortArrayWithIntegerKeys(
                $this->conf['view']['templateRootPaths']
            );
            $paths = array_reverse($paths, true);
            foreach ($paths as $path) {
                if (substr($path, -1) !== '/') {
                    $path .= '/';
                }
                if ($this->isFile($path . $file)) {
                    return $path . $file;
                }
            }
        }
        return false;
    }

    public function isFile($file)
    {
        return file_exists(GeneralUtility::getFileAbsFileName($file));
    }

    public function getKmls()
    {
        $cacheContent = $this->cacheManager->getCache('egmap');
        $kmlsFromCache = $cacheContent->get('egmap-kmls-' . $this->contentUid);

        if ($kmlsFromCache === FALSE) {
            $kmls = $this->kmlRepository->findAll();
            if (!empty($kmls) && count($kmls) > 0) {
                $this->settings['isKmls'] = true;
            }
            $kmlXml = $this->getContentTemplate($this->getTemplatePath('kml', 'xml'), array('kmls' => $kmls));

            $kmlXml = (string)$kmlXml;
            if (!empty($kmlXml)) {
                $kmlsArray = simplexml_load_string($kmlXml);
            } else {
                $kmlsArray = [];
            }

            $result = json_encode($kmlsArray);

            $cacheContent->set('egmap-kmls-' . $this->contentUid, $result);
        } else {
            $result = $kmlsFromCache;
        }

        return $result;
    }

    public function getAllCats()
    {
        if (!empty($this->settings['cat']['cats'])) {
            $cacheContent = $this->cacheManager->getCache('egmap');
            $catsFromCache = $cacheContent->get('egmap-cats-' . $this->contentUid);

            if ($catsFromCache === FALSE) {
                $catsValue = $this->settings['cat']['cats'];
                if (is_array($catsValue)) {
                    $catsValue = implode(',', $catsValue);
                }
                $catsValue = trim((string)$catsValue);
                if (!empty($catsValue)) {
                    $result = $this->categoryRepository->findParents($catsValue);
                    $cacheContent->set('egmap-cats-' . $this->contentUid, serialize($result));
                } else {
                    $result = [];
                }
            } else {
                $result = unserialize($catsFromCache);
            }

            return $result ?? [];
        }
        return [];
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

    public function getRepository($table)
    {
        $table = strtolower($table);
        if (isset($this->otherRepository[$table])) {
            return $this->otherRepository[$table];
        }

        return $this->poiRepository ?? null;
    }

    protected function getConfTs($extension, $plugin)
    {
        $this->settings = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            $extension,
            $plugin
        );
    }

    /**
     * Get configuration
     *
     * @return void
     */

    protected function getConf($extension)
    {
        $this->conf = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            $extension
        );
    }

    public function setListInArray($list, $array, $force = 0)
    {
        $allPoisTmp = explode(',', $list);
        foreach ($allPoisTmp as $poiTmp) {
            $tableTmp = explode('_', $poiTmp);
            $uid = intval(array_pop($tableTmp));
            $table = implode('_', $tableTmp);
            if (!isset($array[$table]) || !is_array($array[$table]) || !in_array($uid, $array[$table])) {
                if ($force == 1 && count($array) < 1) {
                    $this->settings['map']['forcePoi'] = $poiTmp;
                }
                $array[$table][] = $uid;
            }
        }
        return $array;
    }

    public function getPoiModel($poiItentifer)
    {
        $tableTmp = explode('_', $poiItentifer);
        $uid = intval(array_pop($tableTmp));
        $table = implode('_', $tableTmp);

        $repo = null;

        if ($table == 'tx_egmap_domain_model_poi') {
            return $this->poiRepository->findByUid($uid);
        }

        foreach ($this->otherRepository as $key => $repo) {
            if ($repo->tableName == $table) {
                return $repo->findByUid($uid);
            }
        }

        return false;
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

        /*$queryParams = $request ?
            ($request->getQueryParams() + ($request->getParsedBody() ?? [])) : ($GLOBALS['TYPO3_REQUEST'] ?
                ($GLOBALS['TYPO3_REQUEST']->getQueryParams() + ($GLOBALS['TYPO3_REQUEST']->getParsedBody() ?? [])) :
                []);*/

        $pageId = $this->pageId; 
        

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
