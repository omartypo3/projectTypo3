<?php

namespace Stratis\StratisElements\ViewHelpers\Uri;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class ParamViewHelper
 * @package Stratis\StratisElements\ViewHelpers\Uri
 */
class ParamViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('get', 'string', 'The GET parameter to fetch', false, null);
    }

    /**
     * Return get param
     * @return mixed
     */
    public function render()
    {
        parse_str($this->arguments['get'], $path);
        $param = current(array_keys($path));

        if ($param) {
            $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
            if ($request) {
                $queryParams = $request->getQueryParams();
                return $queryParams[$param] ?? null;
            }
            return $_GET[$param] ?? null;
        }
        
        return null;
    }
}
