<?php

namespace DLD\Dld\ViewHelpers;



class PageUidViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{
    /**
     * @param string $page
     *
     */
    public function render($page)
    {
        return str_replace("t3://page?uid=","",$page);

    }
}