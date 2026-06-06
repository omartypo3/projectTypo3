<?php

namespace Emagineurs\EImportExport\ViewHelper;

class ArViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	
	/**
	* @param string $string
	* @return mixed
	*/
	public function render($string) {
		$array = explode(',', $string);
		$newArray = [];
		foreach($array as $tab) {
			$nums = explode('-/',$tab);
			if($nums[0] !== null && $nums[1] !== null) {
				$newArray[$nums[0]] = $nums[1];
			}
		}
        $this->templateVariableContainer->add('newArray', $newArray);
		$output = $this->renderChildren();
		$this->templateVariableContainer->remove('newArray');
		
		return $output;
	}
}