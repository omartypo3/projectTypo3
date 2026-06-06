<?php

namespace DslFactory\DslProdukte\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PpageViewHelper extends AbstractViewHelper
{

    public function render()
    {
        $fpdf = $this->templateVariableContainer->get('fpdf');
        $fpdf->AddPage();
        $fpdf->SetAutoPageBreak(true, 30);
        $this->renderChildren();
    }
}

?>