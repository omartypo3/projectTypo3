<?php
namespace DslFactory\DslImmo\ViewHelpers;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
/**
 * Puts an image.
 *
 * @package TYPO3
 * @subpackage dsl_immo
 */
class Utf8DecodeViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
 {

    /**

     * Returns the length of a string in user unit. A font must be selected.

     *

     * @param string $string The string whose length is to be computed.

     * @return  integer

     */

    /*public function render($string='') {

        return \utf8_decode($string);

    }*/


    use CompileWithRenderStatic;

    public function initializeArguments()
    {
        $this->registerArgument('string', 'string', 'The email address to resolve the gravatar for', true);
    }
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        return utf8_decode($arguments['string']);
    }

}
?>