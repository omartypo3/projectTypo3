<?php

namespace sitetheme\site\ViewHelpers;


use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class RenderContentViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('contentUid', 'int', 'The id of content to display', true);
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $conf =  array('tables' => 'tt_content', 'source' =>  (int)$this->arguments['contentUid'], 'dontCheckPid' => 1);
        $cObj = new ContentObjectRenderer();
        $renderedContent = $cObj->cObjGetSingle('RECORDS', $conf);
        return $renderedContent;
    }
}