<?php
namespace FRONTAL\FagInstitutionManagement\ViewHelpers;

/***************************************************************
* = Examples =
* 
*  {namespace fagsvg=FRONTAL\FagSvg\ViewHelpers}
*  <fag:svgToHtml path="{f:uri.image(src:file.uid, treatIdAsReference:1, absolute:1)}" />
* 
***************************************************************/

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class FormatEmailViewHelper extends AbstractViewHelper {

     /**
     * @var boolean
     */
    protected $escapeOutput = false;

	/**
	 * Return the formated E-Mail
	 *
	 * @param string $email
	 * @return string formated E-Mail
	 */
	public function render($email = '') {
        if(strlen($email) > 23) {
            return str_replace ('@' , '<br>@' , $email);
        } else {
            return $email;
        }
	}
}
