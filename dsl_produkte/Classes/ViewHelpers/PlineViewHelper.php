<?php

namespace DslFactory\DslProdukte\ViewHelpers;

# oder ein entsprechender Namensraum statt TYPO3
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PlineViewHelper extends AbstractViewHelper
{


    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('rgb', 'mixed', 'rgb color', FALSE);
//		$this->registerArgument('size', 'int', 'font size', FALSE);
        $this->registerArgument('spaceAfter', 'int', 'abstand danach', FALSE);
        $this->registerArgument('spaceBefore', 'int', 'abstand davor', FALSE);
        $this->registerArgument('lineWidth', 'float', 'Linienstärke', FALSE);

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
    public function render($width)
    {//$text, $width, $height

        if ($this->arguments['rgb']) $rgb = $this->arguments['rgb']; else $rgb = array("r" => 0, "g" => 0, "b" => 0);
//			if($this->arguments['size']) $size = $this->arguments['size']; else $size = 30;
        if ($this->arguments['spaceAfter']) $spaceAfter = $this->arguments['spaceAfter']; else $spaceAfter = 0;
        if ($this->arguments['spaceBefore']) $spaceBefore = $this->arguments['spaceBefore']; else $spaceBefore = 0;

        if ($this->arguments['fromX']) $fromX = $this->arguments['fromX'];
        if ($this->arguments['fromY']) $fromY = $this->arguments['fromY'];
        if ($this->arguments['toX']) $toX = $this->arguments['toX'];
        if ($this->arguments['toY']) $toY = $this->arguments['toY'];

        if ($this->arguments['lineWidth']) $lineWidth = $this->arguments['lineWidth']; else $lineWidth = 0.25;


        //	$text = strtoupper($text);
        //$needle = $this->arguments['needle'];
        $pdf = $this->templateVariableContainer->get('fpdf');

//            $pdf->SetFont('Times','I',30);
        //$pdf->SetFont('opensans-regular','',30);
        //$pdf->SetFont('colabthi','',30);
//			$pdf->SetFont($font,$schnitt,$size);

        if ($spaceBefore) $pdf->Ln($spaceBefore);


// Linienfarbe auf Blau einstellen 
        $pdf->SetDrawColor($rgb["r"], $rgb["g"], $rgb["b"]);

// Linienbreite einstellen, 0.5 mm
        $pdf->SetLineWidth($lineWidth);

// Linie zeichnen
//Syntax: 		Line(float x1 , float y1 , float x2 , float y2)
        if (!isset($fromX)) $fromX = $pdf->getX();
        if (!isset($fromY)) $fromY = $pdf->getY();
        if (!isset($toX)) $toX = $fromX + $width;
        if (!isset($toY)) $toY = $fromY;


        $pdf->Line($fromX, $fromY, $toX, $toY);

//            $pdf->SetTextColor($rgb["r"],$rgb["g"],$rgb["b"]);
        if ($spaceAfter) $pdf->Ln($spaceAfter);
//            $pdf->Cell($width, $height, utf8_decode($text), 0, 1, 'L');

        $this->renderChildren();
    }
}

?>