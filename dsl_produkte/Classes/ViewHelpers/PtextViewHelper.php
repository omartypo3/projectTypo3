<?php

namespace DslFactory\DslProdukte\ViewHelpers;

# oder ein entsprechender Namensraum statt TYPO3
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PtextViewHelper extends AbstractViewHelper
{


    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('rgb', 'mixed', 'rgb color', FALSE);
        $this->registerArgument('font', 'string', 'font name', FALSE);
        $this->registerArgument('schnitt', 'string', 'font schnitt', FALSE);
        $this->registerArgument('size', 'int', 'font size', FALSE);
        $this->registerArgument('height', 'float', 'Zeilenhöhe', FALSE);
        $this->registerArgument('width', 'float', 'feste Breite', FALSE);
        $this->registerArgument('spaceAfter', 'int', 'abstand danach', FALSE);
        $this->registerArgument('spaceBefore', 'int', 'abstand davor', FALSE);
        $this->registerArgument('transform', 'array', 'Text Transformierung', FALSE);
        $this->registerArgument('align', 'string', 'Textausrichtung', FALSE);
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
    public function render($text)
    {


        if ($this->arguments['rgb']) $rgb = $this->arguments['rgb']; else $rgb = array("r" => 0, "g" => 0, "b" => 0);
        if ($this->arguments['font']) $font = $this->arguments['font']; else $font = "Times";
        if ($this->arguments['schnitt']) $schnitt = $this->arguments['schnitt']; else $schnitt = "";
        if ($this->arguments['size']) $size = $this->arguments['size']; else $size = 30;
        if ($this->arguments['spaceAfter']) $spaceAfter = $this->arguments['spaceAfter']; else $spaceAfter = 0;
        if ($this->arguments['spaceBefore']) $spaceBefore = $this->arguments['spaceBefore']; else $spaceBefore = 0;
        if ($this->arguments['align']) $align = $this->arguments['align']; else $align = "L";

        if ($this->arguments['height']) $height = $this->arguments['height']; else $height = false;
        if ($this->arguments['width']) $width = $this->arguments['width']; else $width = false;
        if ($this->arguments['transform']) {
            foreach ($this->arguments['transform'] as $value)
                switch ($value) {
                    case "upper":
                        $text = strtoupper($text);
                        //						$transform = $this->arguments['transform']; else $transform = 0;
                        break;
                }
        }

        /*$text = str_replace(array("<br />","<br/>","<br>"),"\n",$text);
        $text = str_replace("</p>","\n\n",$text);
        $text = str_replace("<br />","\n",$text);	*/
        $text = strip_tags($text);
        $text = utf8_decode($text);

        //	$text = strtoupper($text);
        //$needle = $this->arguments['needle'];
        $pdf = $this->templateVariableContainer->get('fpdf');

//            $pdf->SetFont('Times','I',30);
        //$pdf->SetFont('opensans-regular','',30);
        //$pdf->SetFont('colabthi','',30);
        $pdf->SetFont($font, $schnitt, $size);

        if ($spaceBefore) $pdf->Ln($spaceBefore);
        $pdf->SetTextColor($rgb["r"], $rgb["g"], $rgb["b"]);

        if ($width) {
            $pdf->Cell($width, $height, $text, 0, 0, $align);
        } else {
            $pdf->Write($height, $text);
        }

        if ($spaceAfter) $pdf->Ln($spaceAfter);

        $this->renderChildren();
    }
}

?>