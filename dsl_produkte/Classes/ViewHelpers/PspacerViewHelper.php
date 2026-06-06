<?php

namespace DslFactory\DslProdukte\ViewHelpers;

# oder ein entsprechender Namensraum statt TYPO3
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PspacerViewHelper extends AbstractViewHelper
{


    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('height', 'float', 'Zeilenhöhe', FALSE);

        /*		$this->registerArgument('needle', 'string', 'View helper needle', TRUE);
                $this->registerArgument('then', 'string', 'View helper then ', TRUE);
                $this->registerArgument('else', 'string', 'View helper else', TRUE);*/
    }

    /**
     *
     * @param string $text
     * @param int $width
     * @param int $height
     * @param string $font
     * @param string $schnitt
     * @param int $size
     */
    public function render()
    {


        if ($this->arguments['height']) $height = $this->arguments['height']; else $height = 0;

        $pdf = $this->templateVariableContainer->get('fpdf');


        $pdf->Ln($height);

        $this->renderChildren();
    }
}

?>