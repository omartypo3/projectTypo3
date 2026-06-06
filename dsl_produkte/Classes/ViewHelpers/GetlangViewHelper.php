<?php
namespace DslFactory\DslProdukte\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
class GetlangViewHelper extends AbstractViewHelper{
	public function render() {
		$languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
		$sys_language_uid = $languageAspect->getId();
		return $sys_language_uid;
	}
}
?>