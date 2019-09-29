<?php
namespace FRONTAL\FagInstitutionManagement\ViewHelpers;

/***************************************************************
* = Examples =
* 
*  {namespace inst=FRONTAL\FagInstitutionManagement\ViewHelpers}
*  <inst:formatWww www="{institution.www}" />
* 
***************************************************************/

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class FormatWwwViewHelper extends AbstractViewHelper {

     /**
     * @var boolean
     */
    protected $escapeOutput = false;

	/**
	 * Return the formated www
	 *
	 * @param string $www
	 * @return string formated www
	 */
	public function render($www = '') {

        // remove http or https
        $www = preg_replace('#^https?://#', '', $www);

        // return clean www
        if(substr_count($www,'/') > 0) {
            return substr($www, 0, stripos($www,'/'));
        } else {
            return $www;
        }
	}
}
