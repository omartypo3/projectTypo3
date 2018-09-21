<?php

/**
 * Class that adds the wizard icon.
 *
 */
class tx_wservice_wizicon {


	function proc($wizardItems)	{
		global $LANG;

		$LL = $this->includeLocalLang();

		$wizardItems['plugins_tx_wservice_pi'] = array(
			'icon'=>t3lib_extMgm::extRelPath('w_service').'tt_content_avonis.png',
			'title'=>$LANG->getLLL('service.title',$LL),
			'description'=>$LANG->getLLL('service.description',$LL),
			'params'=>'&defVals[tt_content][CType]=wservice_pi1'
		);

		return $wizardItems;
	}

	/**
	 * Includes the locallang file for the 'w_service' extension
	 *
	 * @return	array		The LOCAL_LANG array
	 */
	function includeLocalLang()	{
		$llFile = t3lib_extMgm::extPath('w_service').'locallang.xml';

		$object = t3lib_div::makeInstance('t3lib_l10n_parser_Llxml');
		$LOCAL_LANG =  $object->getParsedData($llFile, $GLOBALS['LANG']->lang);

		return $LOCAL_LANG;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/w_service/Classes/class.tx_wservice_wizicon.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/w_service/Classes/class.tx_wservice_wizicon.php']);
}

?>