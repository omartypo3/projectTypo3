<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 David Ansermot <david.ansermot@wng.ch>
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

// require_once(PATH_tslib . 'class.tslib_pibase.php');

/**
 * Plugin 'Météo Suisse' for the 'mt_meteo' extension.
 *
 * @author	David Ansermot <david.ansermot@wng.ch>
 * @package	TYPO3
 * @subpackage	tx_mtmeteo
 */
class tx_mtmeteo_pi1 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {
	
	/**
	 * @var string Same as class name
	 * @access public
	 */
	public $prefixId      = 'tx_mtmeteo_pi1';		
	
	/**
	 * @var string Path to this script relative to the extension dir.
	 * @access public
	 */	
	public $scriptRelPath = 'pi1/class.tx_mtmeteo_pi1.php';	
	
	/**
	 * @var string  The extension key.
	 * @access public
	 */
	public $extKey        = 'mt_meteo';	
	
	/**
	 * @var bool Flag for cHash chcek
	 * @access public
	 */
	public $pi_checkCHash = true;
	
	/**
	 * @var array Parties du template
	 * @access protected
	 */
	protected $tplParts = array();
	
	/**
	 * @var string Source du template
	 * @access protected
	 */
	protected $templateCode = '';
	
	
	
	/**
	 * The main method of the Plugin.
	 *
	 * @param string $content The Plugin content
	 * @param array $conf The Plugin configuration
	 * @return string The content that is displayed on the website
	 */
	public function main($content, array $conf) {
		
		// Si le cache doit etre désactivé, passage cObj USER => USER_INT
		if (isset($conf['no_cache']) && $conf['no_cache'] == 1 && !$conf['__USER_INT__']) {
			return $this->main_INT($content, $conf);
		}
		
		// Initialisation...
		$this->init($conf);
		
		// Génère la vue
		$content = $this->process();
	
		return $content;
		//return $this->pi_wrapInBaseClass($content);
	}
	
	
	
	/**
	 * Cette méthode configure et renvoi le Plugin en évitant de le mettre en cache (*_INT)
	 *
	 * @param string $content Le contenu du Plugin
	 * @param array $conf La configuration TS du Plugin
	 * @return string Le contenu qui est affiché sur le site, sans utiliser le cache
	 * @access public
	 */
	function main_INT($content, $conf) {
		// Ajout de cette valeur au tableau de configuration pour éviter de réexécuter cette partie
		$conf['__USER_INT__'] = true;

		// On inclut et on charge la classe pour la prochaine exécution
		$conf['includeLibs'] = $GLOBALS['TYPO3_LOADED_EXT'][$this->extKey]['siteRelPath'].'pi/class.'.$this->prefixId.'.php';
		$conf['userFunc'] = $this->prefixId.'->main';
		
		// On rappelle la fonction principale, mais en tant que USER_INT
		return $this->cObj->cObjGetSingle('USER_INT', $conf);
	}
	
	
	
	/**
	 * Initialisation du Plugin
	 *
	 * @param array $conf: Tableau de configuration TS
	 * @return void
	 * @access protected
	 */
	protected function init($conf) {
		
		// Sauve la config
		$this->conf = $conf;
		
		// Charge les variables de pi
		$this->pi_setPiVarDefaults();
		
		// Charge les langues
		$this->pi_loadLL();
		
		// Charge le model
		//$this->model = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tx_mtwoodform_model_commands');
		//$this->model->injectConf($this->conf);
		//$this->model->injectFieldsHashtable($this->fieldsHashtable);
		
		// Chargement du FlexForm 
		//$this->pi_initPIflexForm();
		//$this->checkFlexFormConf();
		
		// Javascript inline (dynamique)
		//$js = 'var market_covers_shop_magazine = '.$this->conf['prices.']['magazine'].';'."\n";
		//$js .= 'var market_covers_shop_swiss = '.$this->conf['prices.']['shipping.']['switzerland'].';'."\n";
		//$js .= 'var market_covers_shop_others = '.$this->conf['prices.']['shipping.']['others'].';'."\n";
		
		// Ajoute les en-tete requis
		/*$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId.'_formjs'] = '<script type="text/javascript" src="typo3conf/ext/'.$this->extKey.'/Resources/Public/Javascript/form.js"></script>';*/
		/*$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId.'_js_pi2'] = '<script type="text/javascript" src="typo3conf/ext/'.$this->extKey.'/res/js/lightbox/jquery-ui-1.8.18.custom.min.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId.'_js_pi2'] = '<script type="text/javascript" src="typo3conf/ext/'.$this->extKey.'/res/js/lightbox/jquery.smooth-scroll.min.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId.'_js_pi2'] = '<script type="text/javascript" src="typo3conf/ext/'.$this->extKey.'/res/js/lightbox/lightbox.js"></script>';
		*/
		//$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId.'_css_pi1'] = '<link type="text/css" rel="stylesheet" href="typo3conf/ext/'.$this->extKey.'/Resources/Public/Css/poll.css"/>';
		/*$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId.'_css_pi2'] = '<link type="text/css" rel="stylesheet" href="typo3conf/ext/'.$this->extKey.'/res/css/lightbox.css"/>';*/
		
		// Charge le template
		//$this->templateCode = $GLOBALS['TSFE']->tmpl->getFileName($this->conf['templateFile']);
        $this->templateCode = file_get_contents($GLOBALS['TSFE']->tmpl->getFileName($this->conf['templateFile']), true);
		$this->processTemplate();
		
	}
	
	
	
	
	/**
	 * Affichage de la meteo
	 *
	 *
	 */
	protected function process() {

		// Vérification de la config
		if ($this->conf['meteoFolderPath'] == '' || $this->conf['meteoParseFile'] == '') {
			return '<em>Module Météo mal configuré. Vérifier le ".meteoFolderPath" et ".meteoParseFile".</em>';
		}
		
		$folder = rtrim($this->conf['meteoFolderPath'], '/').'/';
		$path = $folder.$this->conf['meteoParseFile'];
		
		$data = $this->parseOfficialData($path);
    
    $date = date('j');
    $dateTomorrow = date('j', time () + 86400);
    $dateAfterTomorrow = date('j', time () + 86400 + 86400);
		
		$markers = array(
			'###IMAGE###' => $folder.'images/big/'.$data['code_image'].'.png',
      '###DATE###' => $date,
			'###V_TEMPERATURE###' => $data['temperature'],
      '###V_TEMPERATURE_MIN###' => $data['temperature_min'],
      '###V_TEMPERATURE_MAX###' => $data['temperature_max'],
      '###V_TEMPERATURE_DELIM###' => $data['txt_temp_delim'],
			'###LL_TEMPERATURE###' => $data['txt_temperature'],
      '###DAY_SHORT###' => $data['txt_temp_day_short'],
      
      '###IMAGE_1###' => $folder.'images/big/'.$data['code_image_1'].'.png',
      '###DATE_1###' => $dateTomorrow,
			'###V_TEMPERATURE_1###' => $data['temperature_1'],
      '###V_TEMPERATURE_MIN_1###' => $data['temperature_min_1'],
      '###V_TEMPERATURE_MAX_1###' => $data['temperature_max_1'],
      '###V_TEMPERATURE_DELIM_1###' => $data['txt_temp_delim_1'],
			'###LL_TEMPERATURE_1###' => $data['txt_temperature_1'],
      '###DAY_SHORT_1###' => $data['txt_temp_day_short_1'],
      
      '###IMAGE_2###' => $folder.'images/big/'.$data['code_image_2'].'.png',
      '###DATE_2###' => $dateAfterTomorrow,
			'###V_TEMPERATURE_2###' => $data['temperature_2'],
      '###V_TEMPERATURE_MIN_2###' => $data['temperature_min_2'],
      '###V_TEMPERATURE_MAX_2###' => $data['temperature_max_2'],
      '###V_TEMPERATURE_DELIM_2###' => $data['txt_temp_delim_2'],
			'###LL_TEMPERATURE_2###' => $data['txt_temperature_2'],
      '###DAY_SHORT_2###' => $data['txt_temp_day_short_2'],
		);
		$html = $this->templateService->substituteMarkerArray($this->tplParts['meteo'], $markers);
		
		return $this->templateService->substituteSubpart($html, '###PART_METEO###', $this->tplParts['meteo']);
	}
	
	
	
	/**
	 *	Récupération des prévisions actuelles depuis un fichier xhtml météosuisse
	 *
	 *	@param	string	$file		chemin complet du fichier avec nom du fichier
	 *	
	 *	@return	array	$return		contient 3 clés
	 *								int|null 	$return['code_image']		: code de l'image ou null
	 *								int|null 	$return['temperature']		: temperature en °C
	 *								string|null $return['txt_temperature']	: texte de la prévision
	 */
	protected function parseOfficialData($file) {
		
		$return 		= null;
		$code_image 	= null;
		$temperature 	= null;
    $txt_temp_tab 	= null; 
    $temperature_min 	= null; 
		$temperature_max 	= null; 
		$txt_temp_delim 	= null; 
		$txt_temp_day_short_tab 	= null;
    
    $code_image_1 	= null;
		$temperature_1 	= null;
    $txt_temp_tab_1 	= null; 
    $temperature_min_1 	= null; 
		$temperature_max_1 	= null; 
		$txt_temp_delim_1 	= null; 
		$txt_temp_day_short_tab_1 	= null;
    
    $code_image_2 	= null;
		$temperature_2 	= null;
    $txt_temp_tab_2 	= null; 
    $temperature_min_2 	= null; 
		$temperature_max_2 	= null; 
		$txt_temp_delim_2 	= null; 
		$txt_temp_day_short_tab_2 	= null;
		
		// Récupération des données du fichier
		if ($document = file_get_contents($file)){
		
			if(preg_match('~<div id="hpw_0">(.*?)</div>~is',$document,$matches)){
				
				// information trouvée
				$data=$matches[1];
				
				// Récupération du code de l'image : ce dernier est un entier
				if(preg_match('~<span id="hpw_img_0" class="hpw_img_code_(\d+)"></span>~is',$data,$img_code)){
					$code_image = $img_code[1];
				}
				
				// Récupération du texte de temps
				if(preg_match('~<span class="hpw_txt">(.*?)</span>~is',$data,$txt_temp_tab)){
					$txt_temp = $txt_temp_tab[1];
				}
        
        // Récupération du jour en version short
				if(preg_match('~<span class="hpw_date_short">(.*?)</span>~is',$data,$txt_temp_day_short_tab)){
					$txt_temp_day_short = $txt_temp_day_short_tab[1];
				}
				
				// Récupération de la température
				if(preg_match('~<span class="hpw_temp_0">(.*?)</span>~is',$data,$temp_tab)){
					$temperature = $temp_tab[1];
				}
        
        // Récupération de la température min
				if(preg_match('~<span class="hpw_temp_min">(.*?)</span>~is',$data,$temp_min_tab)){
					$temperature_min = $temp_min_tab[1];
				}
        
        // Récupération de la température max
				if(preg_match('~<span class="hpw_temp_max">(.*?)</span>~is',$data,$temp_max_tab)){
					$temperature_max = $temp_max_tab[1];     
				}
        
        // Récupération du séparateur des temp min et max
				if(preg_match('~<span class="hpw_temp_delim">(.*?)</span>~is',$data,$txt_temp_delim_tab)){
					$txt_temp_delim = $txt_temp_delim_tab[1];
				}
			}
      
      if(preg_match('~<div id="hpw_1">(.*?)</div>~is',$document,$matches)){
				
				// information trouvée
				$data=$matches[1];
				
				// Récupération du code de l'image : ce dernier est un entier
				if(preg_match('~<span id="hpw_img_1" class="hpw_img_code_(\d+)"></span>~is',$data,$img_code_1)){
					$code_image_1 = $img_code_1[1];
				}
				
				// Récupération du texte de temps
				if(preg_match('~<span class="hpw_txt">(.*?)</span>~is',$data,$txt_temp_tab_1)){
					$txt_temp_1 = $txt_temp_tab_1[1];
				}
        
        // Récupération du jour en version short
				if(preg_match('~<span class="hpw_date_short">(.*?)</span>~is',$data,$txt_temp_day_short_tab_1)){
					$txt_temp_day_short_1 = $txt_temp_day_short_tab_1[1];
				}
				
				// Récupération de la température : ce dernier est un entier
				if(preg_match('~<span class="hpw_temp_0">(-?\d+)&deg;</span>~is',$data,$temp_tab_1)){
					$temperature_1 = $temp_tab_1[1];
				}
        
        // Récupération de la température min
				if(preg_match('~<span class="hpw_temp_min">(.*?)</span>~is',$data,$temp_min_tab_1)){
					$temperature_min_1 = $temp_min_tab_1[1];
				}
        
        // Récupération de la température max
				if(preg_match('~<span class="hpw_temp_max">(.*?)</span>~is',$data,$temp_max_tab_1)){
					$temperature_max_1 = $temp_max_tab_1[1];     
				}
        
        // Récupération du séparateur des temp min et max
				if(preg_match('~<span class="hpw_temp_delim">(.*?)</span>~is',$data,$txt_temp_delim_tab_1)){
					$txt_temp_delim_1 = $txt_temp_delim_tab_1[1];
				}
			}
      
      if(preg_match('~<div id="hpw_2">(.*?)</div>~is',$document,$matches)){
				
				// information trouvée
				$data=$matches[1];
				
				// Récupération du code de l'image : ce dernier est un entier
				if(preg_match('~<span id="hpw_img_2" class="hpw_img_code_(\d+)"></span>~is',$data,$img_code_2)){
					$code_image_2 = $img_code_2[1];
				}
				
				// Récupération du texte de temps
				if(preg_match('~<span class="hpw_txt">(.*?)</span>~is',$data,$txt_temp_tab_2)){
					$txt_temp_2 = $txt_temp_tab_2[1];
				}
        
        // Récupération du jour en version short
				if(preg_match('~<span class="hpw_date_short">(.*?)</span>~is',$data,$txt_temp_day_short_tab_2)){
					$txt_temp_day_short_2 = $txt_temp_day_short_tab_2[1];
				}
				
				// Récupération de la température : ce dernier est un entier
				if(preg_match('~<span class="hpw_temp_0">(-?\d+)&deg;</span>~is',$data,$temp_tab_2)){
					$temperature_2 = $temp_tab_2[1];
				}
        
        // Récupération de la température min
				if(preg_match('~<span class="hpw_temp_min">(.*?)</span>~is',$data,$temp_min_tab_2)){
					$temperature_min_2 = $temp_min_tab_2[1];
				}
        
        // Récupération de la température max
				if(preg_match('~<span class="hpw_temp_max">(.*?)</span>~is',$data,$temp_max_tab_2)){
					$temperature_max_2 = $temp_max_tab_2[1];     
				}
        
        // Récupération du séparateur des temp min et max
				if(preg_match('~<span class="hpw_temp_delim">(.*?)</span>~is',$data,$txt_temp_delim_tab_2)){
					$txt_temp_delim_2 = $txt_temp_delim_tab_2[1];
				}
			}
		
		}
	
		$return['code_image'] 		= $code_image;
		$return['temperature'] 		= $temperature;
    $return['temperature_min'] 	= $temperature_min;
    $return['temperature_max'] 	= $temperature_max;
		$return['txt_temperature'] 	= $txt_temp;
    $return['txt_temp_delim'] 	= $txt_temp_delim;
    $return['txt_temp_day_short'] 	= $txt_temp_day_short;
    
    $return['code_image_1'] 		= $code_image_1;
		$return['temperature_1'] 		= $temperature_1;
    $return['temperature_min_1'] 	= $temperature_min_1;
    $return['temperature_max_1'] 	= $temperature_max_1;
		$return['txt_temperature_1'] 	= $txt_temp_1;
    $return['txt_temp_delim_1'] 	= $txt_temp_delim_1;
    $return['txt_temp_day_short_1'] 	= $txt_temp_day_short_1;
    
    $return['code_image_2'] 		= $code_image_2;
		$return['temperature_2'] 		= $temperature_2;
    $return['temperature_min_2'] 	= $temperature_min_2;
    $return['temperature_max_2'] 	= $temperature_max_2;
		$return['txt_temperature_2'] 	= $txt_temp_2;
    $return['txt_temp_delim_2'] 	= $txt_temp_delim_2;
    $return['txt_temp_day_short_2'] 	= $txt_temp_day_short_2;
		
		return $return;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 *
	 *			TEMPLATES
	 *
	 *********************************************************************************/	
	
	
	/**
	 * Charge les parties du template
	 *
	 * @param void
	 * @return void
	 * @access protected
	 */
	protected function processTemplate() {

		// Code complet
		$this->tplParts['main'] = $this->templateService->getSubpart($this->templateCode, '###TEMPLATE###');

		$this->tplParts['meteo'] = $this->templateService->getSubpart($this->tplParts['main'], '###PART_METEO###');
	}
	
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 *
	 *			MISC
	 *
	 *********************************************************************************/	
	
	
	/**
	 * Vérifie quelles valeurs doivent être écrasée dans 
	 * la config grâce au flexform de config
	 *
	 * @param void
	 * @return void
	 * @access protected
	 */
	protected function checkFlexFormConf() {
		
		// Récupération du FlexForm
		$flexData = $this->cObj->data['pi_flexform'];
	
		// Récupération des données
		$ffTemplate = $flexData['data']['sDef']['lDEF']['templateFile']['vDEF'];
		$ffStoragePid = $flexData['data']['sDef']['lDEF']['storagePid']['vDEF'];
		$ffPoll = $flexData['data']['sDef']['lDEF']['poll']['vDEF'];
		$ffCookie = $flexData['data']['sDef']['lDEF']['disableCookies']['vDEF'];
		
		// Altération de la config du pi
		$this->conf['templateFile'] = (isset($ffTemplate) && !empty($ffTemplate)) ? $ffTemplate : $this->conf['templateFile'];
		$this->conf['storagePid'] = (isset($ffStoragePid) && !empty($ffStoragePid)) ? $ffStoragePid : $this->conf['storagePid'];
		$this->conf['poll'] = (isset($ffPoll) && !empty($ffPoll)) ? $ffPoll : $this->conf['poll'];
		$this->conf['disableCookie'] = (isset($ffCookie) && !empty($ffCookie)) ? $ffCookie : $this->conf['disableCookie'];
		
	}
	
	
	
	
	
	/**
	 * Renvoi une variable du plugin
	 *
	 * @param string $key: L'identifiant de la variable
	 * @param	mixed	$default['']: La valeur par défaut si pas trouvé (optionel)
	 * @return mixed
	 * @access protected
	 */
	protected function getPV($key, $default = '') {
		if (isset($this->piVars[$key]) && !empty($this->piVars[$key])) {
			return $this->piVars[$key];
		} 
		return $default;
	}
	




	/**
	 * Alias de getPV mais pour les entiers
	 *
	 * @param string $key: L'identifiant de la variable
	 * @param	mixed	$default[-1]: La valeur par défaut si pas trouvé
	 * @return int
	 * @access protected
	 */
	protected function getInt($key, $default = -1) {
		return (int)$this->getPV($key, $default);
	}
	
	
	
	
	
	/**
	 * Crée un typolink
	 *
	 * @param 	int			$id: L'id de la page
	 * @param		string	$params: Les parametres eventuels
	 * @return 	string
	 * @access 	protected
	 */
	protected function TL($id, $params = null) {
		$tlConf = array('parameter' => $id);
		if ($params !== null) {
			$tlConf['additionalParams'] = $params;
		}
		
		return $this->cObj->typolink_URL($tlConf);
	}
	
	
	
	
	
	/**
	 * Vérifie le format de l'email
	 *
	 * @param	string		$email: l'email
	 * @return	true/false
	 */
	protected function hasValidEmail($email) {
		$email = trim($email);
		if (empty($email)) {
			return false;
		}
		
		if (preg_match("^[a-zA-Z0-9\-_]+[a-zA-Z0-9\.\-_]*@[a-zA-Z0-9\-_]+\.[a-zA-Z\.\-_]{1,}[a-zA-Z\-_]+^" , $email)) {
			list($username,$domain) = split('@',$email);
			/*if (!checkdnsrr($domain,'MX')) {
				return false;
			}*/
			return true;
		}
		return false;
	}
}



/*if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mt_meteo/pi1/class.tx_mtmeteo_pi1.php'])) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mt_meteo/pi1/class.tx_mtmeteo_pi1.php']);
}*/

?>