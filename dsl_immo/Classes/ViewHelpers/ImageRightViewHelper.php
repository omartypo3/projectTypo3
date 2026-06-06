<?php

namespace DslFactory\DslImmo\ViewHelpers;



/**
 * Puts an image.
 *
 * @package TYPO3
 * @subpackage dsl_immo
 */
class ImageRightViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
 {

	/**
	 * Puts an image.
	 *
	 * @param   string $filename Path or URL of the image.
	 * @param   float $x Abscissa of the upper-left corner. If not specified or equal to null, the current abscissa is used.
	 * @param   float $y Ordinate of the upper-left corner. If not specified or equal to null, the current ordinate is used; moreover, a page break is triggered first if necessary (in case automatic page breaking is enabled) and, after the call, the current ordinate is moved to the bottom of the image.
	 * @param   float $width Width of the image in the page.
	 * @param   float $height  Height of the image in the page.
	 * @param   float $maxHeight  MaxHeight of the image in the page.	 
	 * @param   float $maxWidth  MaxWidth of the image in the page.	 
	 * @param   string $type Image format. Possible values are (case insensitive): JPG, JPEG, PNG and GIF. If not specified, the type is inferred from the file extension.
	 * @param   mixed $link URL or identifier returned by AddLink(). .
	 * @return  void
	 */

	public function render($filename='', $x=NULL, $y=NULL, $width=0.0, $height=0.0, $maxHeight=0.0, $maxWidth=0.0, $type=NULL, $link='') {
//		$filename =trim($filename,'/');
		//echo "<hr>";
		$filename = str_replace($GLOBALS['TSFE']->tmpl->setup['config.']['baseURL'],'',$filename);
		//echo "base:".$GLOBALS['TSFE']->tmpl->setup['config.']['baseURL'];
		//echo "<hr>";
		
		 $fullFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($filename);
		
		//echo "<hr>";
		// If file not found, search in default imagepath
		
		
		if(!file_exists($fullFilename)) {
		
			$fullFilename = FPDF_IMAGEPATH.'/'.$filename;
		}
		
		
		// File not found exception
		if(!file_exists($fullFilename)) {
			throw new \Exception('Image \''.$fullFilename.'/'.$filename.'\' not found');
		}
		//echo $fullFilename;
		//print_r(getimagesize($fullFilename));
		//die;
		$imgSize = getimagesize($fullFilename);
		//width $imgSize[0]
		//height $imgSize[1]
		if($height && !$width){
			$width = $height/$imgSize[1]*$imgSize[0];
		}
		if($width && !$height){
			$height = $width/$imgSize[0]*$imgSize[1];
		}

		if($maxWidth<$width){
			$faktor = $width/$height;
			$width=$maxWidth;
			$height=$width/$faktor;
		}
		
		if($maxHeight<$height){
			$faktor = $height/$width;
			$height=$maxHeight;
			$width=$height/$faktor;
		}
		
		
	//$width = NULL;
		$fpdf = $this->templateVariableContainer->get('fpdf');
		$x=$fpdf->GetX()-$width;
		$fpdf->Image($fullFilename, $x, $y, $width, $height, $type, $link);
		$this->renderChildren();
	}
}

?>