<?php
namespace DslFactory\DslProdukte\ViewHelpers;


/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Benjamin Rau <rau@codearts.at>, codearts
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 *
 *
 * @package hcbookings
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class InArrayViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper { 

  public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('array', 'mixed', 'View helper array ', TRUE);
		$this->registerArgument('needle', 'string', 'View helper needle', TRUE);
		$this->registerArgument('then', 'string', 'View helper then ', TRUE);
		$this->registerArgument('else', 'string', 'View helper else', TRUE);
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
		
    	$needle = $this->arguments['needle'];
    	
		$array = $this->arguments['array'];
		//print_r($array);
		//exit;
		$then = $this->arguments['then'];
    	$else = $this->arguments['else'];
    	
		//return 'HAHAHA<pre>'.print_r($array).'</pre>';
    	if(is_string($array)) {
    		$array = strpos($array, ',') ? explode(',',$array) : $array;
    		if(!is_array($array)) return $else;//$this->renderElseChild();
    	} 
    	if(is_array($array)){
			if(in_array($needle, $array)) {
				return $then;//return $this->renderThenChild();
			} 
		}
		return $else;//$this->renderElseChild();
	}
}
/*
<!--
For Example you could use it with multiple checkboxes to check the selected one:

<f:for each="{availabilityRange.possibleWeekdays}" key="key" as="weekday">
		    	<label class="checkbox inline">
				  <f:form.checkbox name="item[availabilityRanges][{availabilityRange.uid}][weekday][]" id="inlineWeekday{key}" value="{weekday}" checked="{hcb:inArray(array:availabilityRange.weekday,needle:weekday,then:'checked',else:'')}" /> {weekday}
				</label>
	    	</f:for>

-->
*/



class IsSetViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper { 

  public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('var', 'string', 'View helper var', TRUE);
		$this->registerArgument('then', 'string', 'View helper then ', TRUE);
		$this->registerArgument('else', 'string', 'View helper else', TRUE);
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
		
    	$var = $this->arguments['var'];
    	
		$then = $this->arguments['then'];
    	$else = $this->arguments['else'];
    	

    	if($var) {
			return $then;//return $this->renderThenChild();
		} else {
			return $else;//$this->renderElseChild();
		} 
	}
}
?>