<?php
namespace Emagineurs\ENews\Utility;

use TYPO3\CMS\Fluid\View\StandaloneView;

class FluidUtility {
    /**
     * Render a template from a file
     *
     * @param $path
     * @param $assigns
     * @return string
     */
    public static function renderFileTemplate($path, $assigns) {
        /** @var StandaloneView $view */
        $view = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($path));
        $view->assignMultiple($assigns);

        return $view->render();
    }

    /**
     * Render a template from a string
     *
     * @param $str
     * @param $assigns
     * @return string
     */
    public static function renderStringTemplate($str, $assigns){
        /** @var StandaloneView $view */
        $view = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplateSource($str);
        $view->assignMultiple($assigns);

        return $view->render();
    }
}