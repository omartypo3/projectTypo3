<?php



namespace DslFactory\DslImmo\Utility;

/*use TYPO3\CMS\Core\Database\DatabaseConnection;*/

/**
 * Utility class for Settings
 *
 * @package TYPO3
 * @subpackage tx_dslimmo
 */
class SearchUtility 
{

	public static $instance;
    public function __construct() {
        self::$instance = $this;
    }

	public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 
     * @return mixed
     */
	public function getSearchEnvironment()
	{


		return 'getSearchEnvironment';



/** @var \TYPO3\CMS\Core\DataHandling\DataHandler $tce */
                      /*  $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
                        // create TCE
                        $tce->start($updateData, array());
                        $tce->process_datamap();
*/
		/*if(self::$settings===null){
			$configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
			$extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
			self::$settings = $extbaseFrameworkConfiguration['plugin.']['tx_dslimmo_immoout.']['settings.'];
		}

		if(isset(self::$settings[$section])) {
			return self::$settings[$section];
		} elseif(isset(self::$settings[$section."."])){
			print_r($settings[$section."."]);
			return self::$settings[$section."."];
		}
		*/
		return false;

	}
  

}