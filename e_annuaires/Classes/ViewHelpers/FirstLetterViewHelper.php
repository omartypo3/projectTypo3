<?php
namespace Emagineurs\EAnnuaires\ViewHelpers;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Ian SEBBAGH <isebbagh@e-magineurs.com>, E-magineurs
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
 * @package e_pdl_patrimoine
 * @subpackage ViewHelpers
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
 
class FirstLetterViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper{

	/**
	* @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	*/
	protected $configurationManager;

	/**
	* @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
	* @return void
	*/
	public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
	}

	/**
	* @return void
	*/
	protected function getConfTs() {
		$frameworkConfiguration[0] = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
		$frameworkConfiguration[1] = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

		return $frameworkConfiguration;
	}
    /**
     * @param mixed $fiche
     * @param string $lettre
	 * @param mixed $fieldToTest
	 * @param string $complete
     *      
     * @return boolean isFirstLetter
     */
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('fiche', 'mixed', 'Fiche object', true);
        $this->registerArgument('lettre', 'string', 'Letter', true);
        $this->registerArgument('fieldToTest', 'mixed', 'Field to test', false, 'getTitle');
        $this->registerArgument('complete', 'int', 'Complete flag', false, 0);
    }

    public function render()
    {
        $fiche = $this->arguments['fiche'];
        $lettre = $this->arguments['lettre'];
        $fieldToTest = $this->arguments['fieldToTest'];
        $complete = $this->arguments['complete'];   
        $confTs = $this->getConfTs();
        $settings = $confTs[0];   
        
        if(is_array($fieldToTest)){
            $valueToTest = $fieldToTest[0];
            $actualField = $fieldToTest[1];

            $field = $fiche->$valueToTest()->current()->$actualField();

        } else {
            $field = $fiche->$fieldToTest();
        }
                
        if($complete == 1){
            $firstLetter = strtoupper(mb_substr($field,0,1, mb_detect_encoding($field)));
        } else {
            $firstLetter = strtoupper($field);
        }
        if($firstLetter == $lettre){
            return true;
        } else {
            return false;
        }
    }
}

?>