<?php

namespace Emagineurs\ECalameoPublisher\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Dominique Feyer <dfeyer@ttree.ch>, ttree ltd
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

use Emagineurs\ECalameoPublisher\Utility\FileSystemUtility;
use Emagineurs\ECalameoPublisher\Service\CalameoService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;




class CalameoModuleController extends ActionController
{

    protected ?ModuleTemplate $moduleTemplate = null;

    public function __construct(protected CalameoService $calameoService, protected ModuleTemplateFactory $moduleTemplateFactory, protected FileSystemUtility $fileSystemUtility)
    {}


    public function initializeAction(): void
    {
        $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $this->moduleTemplate->setFlashMessageQueue($this->getFlashMessageQueue());
    }
    public function indexAction(): ResponseInterface
    {
        global $LANG;
        $LANG->includeLLFile('EXT:e_calameo_publisher/Resources/Private/Language/locallang.xlf');

        $this->calameoService->ecpublish();

        $currentPath = $this->fileSystemUtility->getCurrentDir();


        $items = array();
        if ($currentPath) {
            $items = $this->getListePDF($currentPath);
        }

        if (!is_array($items) or empty($items)) {
            $this->addFlashMessage($LANG->sL('noPdf'), '', ContextualFeedbackSeverity::INFO);
        } else {
            $this->moduleTemplate->assign('items', $items);
        }

        $this->addMainMenu($this->moduleTemplate, 'index');
        $this->moduleTemplate->assign('currentAction', 'index');
        return $this->moduleTemplate->renderResponse('CalameoModule/Index');
    }

    protected function getListePDF($path)
    {
        $this->calameoService->ecpublish();

        $content = array();

        $this->fileSystemUtility->readDirFiles($path, function ($file) use ($path, &$content) {
            // Skip files with invalid UTF-8 characters or encoding issues
            if (preg_match('/[\x{FFFD}\x00-\x1F\x7F]/u', $file)) {
                // Log warning about skipped file
                error_log('Skipping file with invalid characters: ' . $file);
                return;
            }

            $fullPath = $path . $file;
            $idIfPublished = $this->calameoService->isPublished(pathinfo($fullPath)["filename"]);
            $thumbnail = $this->fileSystemUtility->generateThumbnail($fullPath);

            $content[] = array(
                'baseName' => pathinfo($fullPath)["basename"],
                'id' => $idIfPublished,
                'ID' => $idIfPublished,
                'thumbnail' => $thumbnail,
                'path' => pathinfo($fullPath)['dirname']
            );
        }, "pdf");

        if (empty($content)) {
            return false;
        }

        return $content;
    }

    public function listAction(): ResponseInterface
    {
        global $LANG;
        $LANG->includeLLFile('EXT:e_calameo_publisher/Resources/Private/Language/locallang.xlf');

        $this->calameoService->ecpublish();
        $items = $this->calameoService->getList();
        if (is_array($items) && count($items) > 0) {
            $this->moduleTemplate->assign('items', $items);
        } else {
            $this->addFlashMessage($LANG->sL('noPdf'), '', ContextualFeedbackSeverity::INFO);
        }
        $this->addMainMenu($this->moduleTemplate, 'list');
        $this->moduleTemplate->assign('currentAction', 'list');
        return $this->moduleTemplate->renderResponse('CalameoModule/List');
    }

    public function publishAction(ServerRequestInterface $request): ResponseInterface
    {
        try {
            // Get file parameter
            $parsedBody = $request->getParsedBody();
            $relativePath = $parsedBody['file'] ?? $_POST['file'] ?? null;

            if (empty($relativePath)) {
                return new JsonResponse(['success' => false, 'error' => 'File parameter is missing'], 400);
            }
            
            // Build absolute path
            $absolutePath = GeneralUtility::getFileAbsFileName('fileadmin/' . $relativePath);

            if (!file_exists($absolutePath)) {
                return new JsonResponse(['success' => false, 'error' => 'File not found'], 404);
            }

            // Publish PDF
            $this->calameoService->ecpublish();
            $result = $this->calameoService->publishPdf($absolutePath, basename($absolutePath), 2, 2);

            if ($result !== false && !empty($result)) {
                return new JsonResponse(['success' => true, 'id' => (string)$result]);
            }
            
            return new JsonResponse(['success' => false, 'error' => 'Failed to publish PDF - no ID returned'], 500);
            
        } catch (CalameoServiceException $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        } catch (\Throwable $e) {
            error_log('Calameo Publisher Error: ' . $e->getMessage());
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteAction(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $idPDF = $request->getParsedBody()['idPDF'] ?? $_POST['idPDF'] ?? null;

            if (empty($idPDF)) {
                return new JsonResponse(['success' => false, 'error' => 'Missing "idPDF" parameter'], 400);
            }

            $this->calameoService->ecpublish();
            $result = $this->calameoService->removePdf($idPDF);

            if ($result === false || $result === null) {
                return new JsonResponse(['success' => false, 'error' => 'Failed to delete PDF from Calameo service'], 500);
            }

            try {
                $xmlResult = $this->calameoService->getResult($result);
                if (isset($xmlResult->error)) {
                    return new JsonResponse(['success' => false, 'error' => (string)$xmlResult->error], 500);
                }
            } catch (\Exception $e) {
            }

            return new JsonResponse(['success' => true, 'message' => 'PDF deleted successfully'], 200);
            
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Add main backend menu similar to <f:be.menus.actionMenu>
     */
    protected function addMainMenu(ModuleTemplate $view, string $currentAction): void
    {

        $menu = $view->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $menu->setIdentifier('CalameoModuleMenu');

        $menuItems = [
            ['label' => 'Liste des PDFs', 'action' => 'index'],
            ['label' => 'PDFs publiés', 'action' => 'list'],
        ];

        foreach ($menuItems as $item) {
            // Use Extbase UriBuilder for proper action URLs
            $uri = $this->uriBuilder->reset()
                ->setRequest($this->request)
                ->uriFor(
                    $item['action'],
                    [],
                    'CalameoModule'
                );

            $menu->addMenuItem(
                $menu->makeMenuItem()
                    ->setTitle($item['label'])
                    ->setHref($uri)
                    ->setActive($currentAction === $item['action'])
            );
        }

        $view->getDocHeaderComponent()->getMenuRegistry()->addMenu($menu);
    }
}
