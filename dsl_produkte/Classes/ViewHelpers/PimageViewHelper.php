<?php

namespace DslFactory\DslProdukte\ViewHelpers;


# oder ein entsprechender Namensraum statt TYPO3


use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;


class PimageViewHelper extends AbstractViewHelper
{


    public function initializeArguments()
    {

        parent::initializeArguments();


        $this->registerArgument('heightMax', 'int', 'heightMax', FALSE);

        $this->registerArgument('pageWidth', 'int', 'pageWidth', FALSE);

        $this->registerArgument('nr', 'int', 'left nr', FALSE);

        $this->registerArgument('total', 'int', 'gesamt', FALSE);


        $this->registerArgument('spacer', 'int', 'abstand zwischen den bildern', FALSE);


        /*		$this->registerArgument('needle', 'string', 'View helper needle', TRUE);

                $this->registerArgument('then', 'string', 'View helper then ', TRUE);

                $this->registerArgument('else', 'string', 'View helper else', TRUE);*/

    }


    /**
     *
     * @param string $url
     * @param int $width
     * @param int $height
     * @param string $font
     * @param string $schnitt
     * @param int $size
     */

    public function render($url)
    {


        if ($this->arguments['heightMax']) $heightMax = $this->arguments['heightMax']; else $heightMax = false;

        if ($this->arguments['pageWidth']) $pageWidth = $this->arguments['pageWidth']; else $pageWidth = 170;

        if ($this->arguments['nr']) $nr = $this->arguments['nr']; else $nr = 0;

        if ($this->arguments['total']) $total = $this->arguments['total']; else $total = 0;

        if ($this->arguments['spacer']) $spacer = $this->arguments['spacer']; else $spacer = 0;


        $umrechnungFaktorPixelJeMM = 11.81;


        $imgwidth = ($pageWidth - (($total - 1) * $spacer)) / $total;

        $imgheight = $imgwidth / 3 * 2;


        if ($imgheight > $heightMax) {

            $faktor = $imgheight / $heightMax;

            $imgheight = $imgheight / $faktor;

            $imgwidth = $imgwidth / $faktor;

        }


        $pdf = $this->templateVariableContainer->get('fpdf');


        $this->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('\\TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');


        $ts1['img'] = 'IMAGE';

//					$ts1['img.']['file']=$this->cObj->IMG_RESOURCE($ts['img.']);

        $ts1['img.']['file'] = $url;

        //$ts1['img.']['file.']['params'] = "-draw 'image Over 0,0 40,40 fileadmin/template/img_web/layout/icon_lupe.png'";

        $ts1['img.']['file.']['width'] = ($umrechnungFaktorPixelJeMM * $imgwidth) . "c";

        $ts1['img.']['file.']['height'] = ($umrechnungFaktorPixelJeMM * $imgheight) . "c";

        $ts1['img.']['file.']['qualitiy'] = 80;

        $ts1['img.']['file.']['ext'] = "jpg";


        //$image = $this->cObj->IMAGE($ts1['img.']);

        $url = $this->cObj->IMG_RESOURCE($ts1['img.']);


        $pdf->Image($url, $pdf->GetX() + ($nr * $imgwidth) + ($nr * $spacer), $pdf->GetY(), $imgwidth);


        if ($nr + 1 == $total) {

            $pdf->Ln($imgheight);

        }


        $this->renderChildren();

    }


}

?>