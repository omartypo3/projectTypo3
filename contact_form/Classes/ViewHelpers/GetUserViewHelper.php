<?php

namespace LeadGeneration\ContactForm\ViewHelpers;


use \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;

class GetUserViewHelper extends AbstractWidgetViewHelper
{
    /**
     * @return array|null
     */
    public function render()
    {

        return $GLOBALS['TSFE']->fe_user;
    }
}