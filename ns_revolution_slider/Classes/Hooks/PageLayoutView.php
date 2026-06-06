<?php
namespace NITSAN\NsRevolutionSlider\Hooks;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class PageLayoutView implements \TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface
{
    public function preProcess(\TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row)
    {
        $extKey = 'ns_revolution_slider';
        if ($row['CType'] == 'list' && $row['list_type'] == 'nsrevolutionslider_slider') {
            $drawItem = false;
            $headerContent = '';
            // template
            $view = $this->getFluidTemplate($extKey, 'NsRevolutionSlider');
            if (!empty($row['pi_flexform'])) {

                $flexFormService = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Service\FlexFormService::class);

            }
            $list_rows = [];
            if (!is_null($row['pi_flexform']) || !empty($row['pi_flexform'])) {
                $rows = $flexFormService->convertFlexFormContentToArray($row['pi_flexform']);
                if ($rows['settings']['slider'] != '') {
                    $sliders = explode(',', $rows['settings']['slider']);
                    /** @var array $list_rows */
                    $list_rows = [];
                    $i = 0;
                    foreach ($sliders as $slider) {
                        $slider = str_replace('wp_revslider_sliders_', '', $slider);
                            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('wp_revslider_sliders');
                            $sliderData = $queryBuilder
                             ->select('wp_revslider_sliders.*', 'slides.params', 'slides.layers')
                             ->from('wp_revslider_sliders')
                             ->join(
                                 'wp_revslider_sliders',
                                 'wp_revslider_slides',
                                 'slides',
                                 $queryBuilder->expr()->eq('slides.slider_id', $queryBuilder->quoteIdentifier('wp_revslider_sliders.id'))
                             )
                             ->where(
                                 $queryBuilder->expr()->eq('alias', $queryBuilder->createNamedParameter($slider)),
                                 $queryBuilder->expr()->eq('type', $queryBuilder->createNamedParameter(''))
                             )
                             ->execute()
                             ->fetch();

                        $sliderData['params'] = json_decode($sliderData['params']);
                        $sliderData['layers'] = json_decode($sliderData['layers']);
                        $list_rows[] = $sliderData;
                    }
                    $view->assignMultiple([
                        'sliders' => $list_rows,
                    ]);
                }
            }
            // assign all to view

            // return the preview
            $itemContent = $parentObject->linkEditContent($view->render(), $row);
        }
    }

    /**
     * @param string $extKey
     * @param string $templateName
     * @return string the fluid template
     */
    protected function getFluidTemplate($extKey, $templateName)
    {
        // prepare own template
        $fluidTemplateFile = GeneralUtility::getFileAbsFileName('EXT:' . $extKey . '/Resources/Private/Backend/' . $templateName . '.html');
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename($fluidTemplateFile);
        return $view;
    }
}
