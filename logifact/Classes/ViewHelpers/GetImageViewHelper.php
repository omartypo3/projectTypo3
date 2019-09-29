<?php

namespace Logifacttheme\Logifact\ViewHelpers;


use    \TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class GetImageViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('table', 'string', 'The name of table to get image from', true);
        $this->registerArgument('field', 'string', 'The name of field to get the image from', true);
        $this->registerArgument('uid', 'string', 'The element uid to get image from', true);
    }



    /**
     * @return string
     */
    public function render()
    {
        $fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
        $fileObjects = $fileRepository->findByRelation($this->arguments['table'],$this->arguments['field'],$this->arguments['uid']);
        return $fileObjects[0]->getPublicUrl();

    }
}
