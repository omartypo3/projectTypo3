<?php
 
namespace DslFactory\DslProdukte\ViewHelpers;
 
/***************************************************************
*  Copyright notice
*
*  (c) 2013 Paul Beck <pb@teamgeist-medien.de>, Armin Ruediger Vieweg <info@professorweb.de>
*
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
 
/**
 * This widget is a copy of the fluid paginate widget. Now it's possible to
 * use arrays with paginate, not only query results.
 *
 * @author     Paul Beck <pb@teamgeist-medien.de>
 * @author     Armin Ruediger Vieweg <info@professorweb.de>
 * @copyright  2011 Copyright belongs to the respective authors
 * @license    http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class LinkDetailViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper {
 
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('arguments', 'mixed', 'View helper array', TRUE);
		$this->registerArgument('zubehoer', 'string', 'Page', FALSE);
		$this->registerArgument('produkte', 'string', 'Page', FALSE);
	}
    /**
     * Check if value is in array
     *
     *
     * @param string  $needle
     * @param array	  $array
     *
     * @return boolean 
     * @api
     */
    public function render() {	
		$arguments = $this->arguments['arguments'];
		/*if($this->arguments['zubehoer']) {
			
			if(isset($arguments["produkte"])) unset($arguments["produkte"]);
			if(isset($arguments["tx_dslprodukte_produktsuche"]["produkte"])) unset($arguments["tx_dslprodukte_produktsuche"]["produkte"]);
		}
		if($this->arguments['produkte']) {
			if(isset($arguments["zubehoer"])) unset($arguments["zubehoer"]);
			if(isset($arguments["tx_dslprodukte_produktsuche"]["zubehoer"])) unset($arguments["tx_dslprodukte_produktsuche"]["zubehoer"]);
		}*/
		if(isset($arguments["tx_dslprodukte_produktsuche"])){
			$arguments = array_merge($arguments,$arguments["tx_dslprodukte_produktsuche"]);
			unset($arguments["tx_dslprodukte_produktsuche"]);
		}
		
		if($this->arguments['zubehoer']) {
			$arguments["zubehoer"] = $this->arguments['zubehoer'];
			if(isset($arguments["produkte"])) unset($arguments["produkte"]);
		//	$arguments['zubehoerfoo2']=$this->arguments['zubehoer'];
		}
		if($this->arguments['produkte']) {
			if(isset($arguments["zubehoer"])) unset($arguments["zubehoer"]);
			$arguments["produkte"] = $this->arguments['produkte'];
		}
		
		
		
		
		
		/*if($this->arguments['zubehoer']) {
			?><pre><?php print_r($arguments); ?></pre><?php 
			exit;
		}*/
/*		if($this->arguments['zubehoer']) {
		$arguments["zubehoer"] = $this->arguments['zubehoer'];
		}
		$arguments['foo']='bar1';*/
	//	var_dump($arguments);
		
		//print_r($arguments);die;
		
		//if($GLOBALS['TSFE']->sys_language_uid) $arguments["L"] = $GLOBALS['TSFE']->sys_language_uid;
		//echo $arguments["L"];
		//echo "blai";die;
		return $arguments;
		
    	$arguments = $this->arguments['arguments'];//[array_shift(array_keys($this->arguments['arguments']))];
		
		$pluginKey = array_shift(array_keys($arguments));
		
		
		if($this->arguments['page']) $arguments[$pluginKey]["@widget_0"]["currentPage"] = $this->arguments['page'];
		
		?><pre><?php print_r($arguments); ?></pre><?php 
exit;
	return array();
		return $arguments;
	}
	
}
 
?>