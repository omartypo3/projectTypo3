<?php
namespace Emagineurs\EImportExport\Controller;


/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
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
use Emagineurs\EImportExport\Utility;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Emagineurs\EImportExport\Domain\Repository\ConfRepository;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

/**
 * ModuleController
 */
class ModuleController extends ActionController {



	/**
	 * @var string
	 */
	public $prefix = 'tx_eimportexport_tools_eimportexporteimportexportmodule';

	/**
	 * @var string
	 */
	protected $dateFormat;
	
	public function __construct(
		protected ConfRepository $confRepository,
		protected PageRenderer $pageRenderer,
		protected Utility $utility,
		protected readonly ModuleTemplateFactory $moduleTemplateFactory,
	) {
	}

	/**
	 * Main action for export
	 *
	 * @access public
	 * @return ResponseInterface
	 */
	public function indexAction(): ResponseInterface {
		$request = $this->request->getArguments();
		$this->dateFormat = 'd/m/Y';
		
		$exportNum = 0;
		$exportConf = null;
		if(!empty($request['exportNum'])){
			$exportNum = intval($request['exportNum']);
			$exportConf = $this->confRepository->findByUid($exportNum);
		}

		$submit = 0;
		if(!empty($request['submit'])){
			$submit = $request['submit'];
		}
		
		$allConf = $this->confRepository->findAll();
		
		$moduleConf = array();
		$items = [];

		$items[] = [
			'label' => 'Choose your configuration',
			'controller' => 'Module',
			'action' => 'index',
			'arguments' => [
				'exportNum' => 0
			]
		];
		
		foreach($allConf as $conf) {
			if(in_array(0, $conf->getInterface())) {
				$moduleConf[] = $conf;
				$items[] = [
					'label' => $conf->getTitle(),
					'controller' => 'Module',
					'action' => 'index',
					'arguments' => [
						'exportNum' => $conf->getUid()
					]
				];
			}
		}
	
		$this->includeJs();
		
		if(!empty($submit)){
			#Instancie ImportExport
			
			$conf = array();
			$conf['vendor'] = 'Emagineurs';
			$conf['extensionName'] = 'EImportExport';
			$conf['controller'] = 'ImportExport';
			$conf['action'] = 'index';
			$conf['arguments'] = array('confuid' => $exportNum);

			$import = $this->utility->callExtbaseAction($conf);
						
			$import = unserialize($import);
		}
		

		$moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $menuItems = $this->buildBackendMenu($moduleTemplate , $items);

        $moduleTemplate->assignMultiple(array(
            'exportNum' => $exportNum,
			'exportConf' => $exportConf,
			'allConf' => $moduleConf,
			'import' => isset($import) ? $import : null,
			'prefix' => $this->prefix,
			'menus'    => $menuItems
        ));
        return $response = $moduleTemplate->renderResponse('Module/Index');
	}
	
	/**
	 * Do JS files inclusion
	 *
	 * @access protected
	 * @return void
	 */
	protected function includeJs(){

		$pageRenderer = $this->pageRenderer;
		
		$typo3Settings = [
			'datePickerUSmode' => 0,
			'dateFormat' => ['j-n-Y', $this->dateFormat],
			'dateFormatUS' => ['j-n-Y', $this->dateFormat],
		];
		$pageRenderer->addInlineSettingArray('', $typo3Settings);
	}

	protected function buildBackendMenu(ModuleTemplate $moduleTemplate , $items): array
    {
        $menu = $moduleTemplate->getDocHeaderComponent()
            ->getMenuRegistry()
            ->makeMenu();

        $menu->setIdentifier('mapModuleDropdown');

        $moduleName = 'tools_EImportExportModule';
        $backendUriBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Backend\Routing\UriBuilder::class);

        $menuItems = [];
        

        foreach ($items as $item) {

			$params = [
				'M'          => $moduleName,
				'controller' => $item['controller'],
				'action'     => $item['action'],
        	];

			if (!empty($item['arguments'])) {
            	$params = array_merge($params, $item['arguments']);
        	}

            // Build backend module URL
            $uri = (string)$backendUriBuilder->buildUriFromRoute($moduleName, $params);


			$exportNum = $this->request->hasArgument('exportNum')
				? $this->request->getArgument('exportNum')
				: 0;

            // Detect active item
            $active = (
				$this->request->getControllerName() === $item['controller']
				 && $exportNum == ($item['arguments']['exportNum'] ?? 0)
        	);

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