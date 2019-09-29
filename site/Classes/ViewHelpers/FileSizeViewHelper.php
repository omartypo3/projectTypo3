<?php

namespace sitetheme\site\ViewHelpers;


use    \TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class FileSizeViewHelper extends AbstractViewHelper
{
    protected $units = array('B', 'K', 'M', 'G', 'T', 'E', 'Z', 'Y');
    public function initializeArguments()
    {
        $this->registerArgument('path', 'string', 'File Path', true);

    }


    public function render() {

        $unit = NULL; // The SI unit suffix to use
        $threshold = 0; // The threshold of the final filesize used to force the next SI unit
        $decimals = 1; // The maximum number of decimal places to show
        $size = filesize($this->arguments['path']);
        # determine the quotient for the calculation
        # decimal system only, as KiB is not understood by users
        $quotient = 1000;
        # determine the valid threshold
        $threshold = min(max(0, $threshold), $quotient);
        # reset the units
        reset($this->units);
        # determine the unit and calculate the final size
        while(
            ($size >= $quotient && is_null($unit)) || # if size is still greater than the quotient
            (current($this->units) != strtolower($unit) && !is_null($unit)) || # or the SI unit is manually defined and reached
            ($threshold > 0 && $size > $threshold && is_null($unit)) # or the threshold forces to use the next unit
        ) {
            $size /= $quotient;
            next($this->units);
        }
        # get the SI unit
        $unit = current($this->units);
        $unit = strtoupper($unit) . ($unit != 'B' ? 'B' : '');
        # format the final size
        $size = round($size, $decimals);

        # append the unit to the final size
        return implode(' ', array($size, $unit));
    }

}
