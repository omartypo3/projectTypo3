<?php

namespace Logifacttheme\Logifact\ViewHelpers;


use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class ArrayChunkViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('array', 'array', 'The array to work on', true);
        $this->registerArgument('size', 'int', 'The size of each chunk', true);
    }

    /**
     * @return mixed
     */
    public function render()
    {
        return array_chunk($this->arguments['array'], $this->arguments['size']);
    }
}