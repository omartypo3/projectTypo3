<?php
namespace DslFactory\DslProdukte\ViewHelpers;


class PDF_HTML extends \HeikoHardt\HhdevFpdf\Fpdf
{
    var $B=0;
    var $I=0;
    var $U=0;
    var $HREF='';
    var $ALIGN='';

    function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n", ' ', $html);
        $a=preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF, $e);
                elseif($this->ALIGN == 'center')
                    $this->Cell(0, 5, $e, 0, 1, 'C');
                else
                    $this->Write(5, $e);
            }
            else
            {
                //Tag
                if($e{0}=='/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else
                {
                    //Extract properties
                    $a2=split(' ', $e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                        if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$', $v, $a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    $this->OpenTag($tag, $prop);
                }
            }
        }
    }

    function OpenTag($tag, $prop)
    {
		
        //Opening tag
        if($tag=='B' or $tag=='I' or $tag=='U')
            $this->SetStyle($tag, true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P'){
			$this->Ln(10);
            $this->ALIGN=$prop['ALIGN'];
		}
        if($tag=='HR')
        {
            if( $prop['WIDTH'] != '' )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x, $y, $x+$Width, $y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' or $tag=='I' or $tag=='U')
            $this->SetStyle($tag, false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag, $enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B', 'I', 'U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('', $style);
    }

    function PutLink($URL, $txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }
	//Kopfzeile
	function Header(){

		$this->SetLeftMargin(20);

		$this->SetFont('Times','',6);
		$this->SetTextColor(0,0,0);


//		$dslhome = "/bf_tech";
		$this->Image("typo3conf/ext/dsl_produkte/Resources/Private/Pdf/kopfzeile.jpg" , 0 , 0, 210);

		$tmpX = $this->GetX();
		$tmpY = $this->GetY();
		$this->SetX($this->rMargin);
		$this->SetY(30);
		//Seitenzahl
	//	$this->Cell(0,15, 'Seite '.$this->PageNo().' / {nb}',0,0,'R');
		$this->SetY($tmpY);
		$this->SetX($tmpX);

		$this->Ln(35);
		
	}	
	//Fusszeile
	function Footer(){

//		$dslhome = "/bf_tech";
		$this->Image("typo3conf/ext/dsl_produkte/Resources/Private/Pdf/fusszeile.jpg" , 0 , 271, 210);

	}
}

    # oder ein entsprechender Namensraum statt TYPO3

    class FpdfViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
		


	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerArgument('tstamp', 'int', 'tstamp', FALSE);
/*		$this->registerArgument('needle', 'string', 'View helper needle', TRUE);
		$this->registerArgument('then', 'string', 'View helper then ', TRUE);
		$this->registerArgument('else', 'string', 'View helper else', TRUE);*/
	}
		
		 /**
         *
         * @param string $filename
		 * @param int $tstamp
         */
		 
        public function render($filename) {
			if($this->arguments['tstamp']) $tstamp = $this->arguments['tstamp']; else $tstamp = 0;

	  		$generate = true;
	  		if($filename && file_exists($filename)) {
				//wenn datei nach produktaktualisierung erstellt wurde
				if(filemtime($filename)<$tstamp) unlink($filename);
			}
			if(!file_exists($filename)){
	  
		//			$pdf = new \HeikoHardt\HhdevFpdf\Fpdf();
				$pdf = new PDF_HTML();
				
				$pdf->AliasNbPages('{nb}'); 
			//    $pdf = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('FPDF');
				$this->templateVariableContainer->add('fpdf', $pdf);       
				$this->renderChildren();
		
		
		//            $pdf->Output($filename, 'I'); 
				$pdf->Output($filename, 'F');
				$this->templateVariableContainer->remove('fpdf');
			}
			
			return $filename;
            
           // exit();
        }
    }
	?>