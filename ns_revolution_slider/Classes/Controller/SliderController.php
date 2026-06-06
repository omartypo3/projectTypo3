<?php
namespace NITSAN\NsRevolutionSlider\Controller;

// Turn off all error reporting
@error_reporting(0);
@ini_set('display_errors', 0);

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;

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
class SliderController extends ActionController
{

    /**
     * Init
     *
     * @return void
     */
    public function initializeAction()
    {
        //Fetch current record information
        $this->pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        parent::initializeAction();
    }


    /**
     * action show
     *
     * @return ResponseInterface
     */
    public function showAction(): ResponseInterface
    {
        $sliders = explode(',', $this->settings['slider']);
        $content = '';

        if (count($sliders) > 0) {
            foreach ($sliders as $slider) {
                $content .= $this->getEmbeddedSliderSource($slider);
            }
        }

        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($slider);

        $content = $this
            ->filterDoubleJqueryErrorFunctions($content)
            ->moveCSS($content)
            ->moveJS($content)
            ->moveInlinJavaScript($content)
            ->sanitize_output($content);

        return new HtmlResponse($content); // ✅ PSR-7 compatible response
    }


    /**
     * @param string $content
     * @return $this
     */
    protected function moveInlinJavaScript(&$content)
    {
        $jsToAdd = '';
        preg_match_all('/<script((?:(?!src=).)*?)>(.*?)<\\/script>/smix', $content, $dataJs);
        if (count($dataJs[0]) > 0) {
            foreach ($dataJs[0] as $jsInline) {
                $jsToAdd.= $jsInline;
                $content = str_replace($jsInline, '', $content);
            }
        }
        $GLOBALS['TSFE']->additionalFooterData[md5($jsToAdd)] = $jsToAdd;
        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    protected function moveJS(&$content)
    {
        $contentParts = explode('<rs-module-wrap', $content);

        preg_match_all("/<script.+?src=[\"']?[^'\"]+['\"]?[^>+]*><\\/script>/", $contentParts[0], $dataJs);
        if (count($dataJs[0]) > 0) {
            foreach ($dataJs[0] as $key => $jsFile) {
                $GLOBALS['TSFE']->addAdditionalHeaderData['rsjs' . $key] = $jsFile;
                $content = str_replace($jsFile, '', $content);
            }
        }

        preg_match_all("/<script.+?src=[\"']?[^'\"]+['\"]?[^>+]*><\\/script>/", $contentParts[1], $dataJs);
        if (count($dataJs[0]) > 0) {
            foreach ($dataJs[0] as $key => $jsFile) {
                $GLOBALS['TSFE']->additionalFooterData['rsjs' . $key] = $jsFile;
                $content = str_replace($jsFile, '', $content);
            }
        }
        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    protected function moveCSS(&$content)
    {
        $contentParts = explode('<rs-module-wrap', $content);
        $uniqueKey = 0;

        preg_match_all("/<link.+?href=[\"']?[^'\"]+['\"]?[^>+]*>/", $contentParts[0], $dataCss);
        if (count($dataCss[0]) > 0) {
            foreach ($dataCss[0] as $key => $cssFile) {
                $uniqueKey++;
                $GLOBALS['TSFE']->addAdditionalHeaderData['rscss'. $uniqueKey . $key] = $cssFile;
                $content = str_replace($cssFile, '', $content);
            }
        }
        preg_match_all('/<style(.*?)<\\/style>/smix', $contentParts[0], $dataCss);
        if (count($dataCss[0]) > 0) {
            foreach ($dataCss[0] as $key => $cssFile) {
                $uniqueKey++;
                $GLOBALS['TSFE']->addAdditionalHeaderData['rscss'. $uniqueKey . $key] = $cssFile;
                $content = str_replace($cssFile, '', $content);
            }
        }

        preg_match_all("/<link.+?href=[\"']?[^'\"]+['\"]?[^>+]*>/", $contentParts[1], $dataCss);
        if (count($dataCss[0]) > 0) {
            foreach ($dataCss[0] as $key => $cssFile) {
                if (strpos($cssFile, 'family') === false) {
                    $uniqueKey++;
                    $GLOBALS['TSFE']->additionalFooterData['rscss'. $uniqueKey . $key] = $cssFile;
                    $content = str_replace($cssFile, '', $content);
                }
            }
        }
        preg_match_all('/<style(.*?)<\\/style>/smix', $contentParts[1], $dataCss);
        if (count($dataCss[0]) > 0) {
            foreach ($dataCss[0] as $key => $cssFile) {
                $uniqueKey++;
                $GLOBALS['TSFE']->additionalFooterData['rscss'. $uniqueKey . $key] = $cssFile;
                $content = str_replace($cssFile, '', $content);
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function getEmbeddedSliderSource($slider)
    {
        $slider = str_replace('wp_revslider_sliders_', '', $slider);
        //include_once GeneralUtility::getFileAbsFileName('EXT:ns_revolution_slider/vendor/wp/wp-config.php');
        //include_once GeneralUtility::getFileAbsFileName('wdpr/wp/wp-config.php');
        include_once GeneralUtility::getFileAbsFileName('wp/wp-config.php');

        ob_start();
        wp_head();
        echo do_shortcode('[rev_slider alias="' . $slider . '"][/rev_slider]');
        wp_footer();
        $content = ob_get_contents();
        ob_clean();
        ob_end_clean();

        return $content;
    }

    /**
     * @param string $content
     * @return $this
     */
    protected function sanitize_output($content)
    {
        $search = [
            '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
            '/[^\S ]+\</s',  // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        ];

        $replace = [
            '>',
            '<',
            '\\1'
        ];
        $content = preg_replace($search, $replace, $content);
        $content = preg_replace("/<meta[^>]+\>/i", '', $content);
        $content = str_replace(PHP_EOL, ' ', $content);

        return $content;
    }

    /**
     * @param string $content
     * @return $this
     */
    protected function sanitize_JSoutput($content)
    {
        $search = [
            '/\/\*[\s\S]*?\*\/|([^:|\"]|^)\/\/.*$/m',
        ];
        $replace = [
            '',
        ];
        $content = preg_replace($search, $replace, $content);
        return $content;
    }

    protected function filterDoubleJqueryErrorFunctions(&$content)
    {
        //preg_match_all('/<script type="text\\javascript">[\\s]*function.*?revslider_showDoubleJqueryError.*?script>/ms', $content, $doubleFunctions);
        preg_match_all('/<script type="text\\\\javascript">[\\s]*function.*?revslider_showDoubleJqueryError.*?script>/ms', $content, $doubleFunctions);
        if (isset($doubleFunctions[0]) && count($doubleFunctions[0]) > 0) {
            foreach ($doubleFunctions[0] as $jsFile) {
                $content = str_replace($jsFile, '', $content);
            }
        }
        return $this;
    }
}
