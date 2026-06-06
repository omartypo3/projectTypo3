<?php

namespace NITSAN\NsRevolutionSlider\Plugins;

/***************************************************************
 *  Copyright notice
 *
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

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Resource\ResourcePathResolver;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Page\AssetCollector;

class Slider extends AbstractFormElement
{
    public function render()
    {
        // Custom TCA properties and other data can be found in $this->data, for example the above
        // parameters are available in $this->data['parameterArray']['fieldConf']['config']['parameters']
        $PA = $this->data['parameterArray'];
        $PA['row']['uid'] = $this->data['vanillaUid'];

        $publicJsUrl = '/wp/backend-slider';

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addRequireJsConfiguration([
            'paths' => [
                'RevSliderBackend' => $publicJsUrl,
            ],
        ]);
        $pageRenderer->loadRequireJsModule('RevSliderBackend');

       // $pageRenderer->loadRequireJsModule('RevSliderBackend');
        $result = $this->initializeResultArray();
        $result['html'] = $this->plugin($PA);


        return $result;
    }

    /**
     * @param $PA
     * @return string
     */
    public function plugin($PA)
    {

        $pluginView = GeneralUtility::makeInstance(StandaloneView::class);

        /** @var string $templateRootPath */
        $templateRootPath = GeneralUtility::getFileAbsFileName('EXT:ns_revolution_slider/Resources/Private/Templates/');

        /** @var string $templatePathAndFilename */
        $templatePathAndFilename = $templateRootPath . 'Plugin/Slider.html';

        $pluginView->setTemplatePathAndFilename($templatePathAndFilename);

        // Load required JS file to fix CSP issue

        /** @var array|bool $rows */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('wp_revslider_sliders');
        $rows = $queryBuilder
            ->select('*')
            ->from('wp_revslider_sliders')
            ->where(
                $queryBuilder->expr()->eq('type', $queryBuilder->createNamedParameter(''))
            )
            ->execute()
            ->fetchAll();

        /** @var array $list_rows */
        $list_rows = [];
        if (count($rows) > 0) {
            /** @var array $list_rows */
            $list_rows = [];
            $i = 0;
            foreach ($rows as $row) {
                $list_rows[$i]['slider'] = $row;
                $list_rows[$i]['slider']['decodedParams'] = json_decode($row['params']);
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('wp_revslider_slides');
                $slides = $queryBuilder
                    ->select('*')
                    ->from('wp_revslider_slides')
                    ->where(
                        $queryBuilder->expr()->eq('slider_id', $queryBuilder->createNamedParameter($row['id'], \PDO::PARAM_INT))
                    )
                    ->execute()
                    ->fetch();

                if ($PA['itemFormElValue'] == 'wp_revslider_sliders_' . $row['alias'] || $PA['itemFormElValue'] == $row['alias']) {
                    $list_rows[$i]['checked'] = 'checked="checked"';
                }
                if (count($slides) > 0) {
                    $list_slides = $slides;
                    $list_slides['decodedParams'] = json_decode($slides['params'], true);
                    $list_slides['decodedLayers'] = json_decode($slides['layers'], true);
                    $list_rows[$i]['slides'] = $list_slides;
                }
                $i++;
            }
        }
        $pluginView->assignMultiple(['rows' => $list_rows, 'PA' => $PA]);
        $pluginView = $pluginView->render();

        return $pluginView;
    }

    protected function cmp($a, $b)
    {
        return strcmp($a['slide_order'], $b['slide_order']);
    }



}
