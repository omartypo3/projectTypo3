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
 
class AbecedaireViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper{

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

    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('list', 'mixed', 'List of items', true);
        $this->registerArgument('fieldToTest', 'mixed', 'Field to test', false, 'title');
    }

    protected function getConfTs() {
        $frameworkConfiguration[0] = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
        $frameworkConfiguration[1] = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        return $frameworkConfiguration;
    }

    public function render()
    {
        $list = $this->arguments['list'];
        $fieldToTest = $this->arguments['fieldToTest'];
        $confTs = $this->getConfTs();
        $settings = $confTs[0];
        
        $alphabet = array(
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
            'E' => 'E',
            'F' => 'F',
            'G' => 'G',
            'H' => 'H',
            'I' => 'I',
            'J' => 'J',
            'K' => 'K',
            'L' => 'L',
            'M' => 'M',
            'N' => 'N',
            'O' => 'O',
            'P' => 'P',
            'Q' => 'Q',
            'R' => 'R',
            'S' => 'S',
            'T' => 'T',
            'U' => 'U',
            'V' => 'V',
            'W' => 'W',
            'X' => 'X',
            'Y' => 'Y',
            'Z' => 'Z'
        );
        $linkAlphabet = array(); 
        
        $cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class);

//By Cco
//Redmine #16921
        $fichesLettersTmp = $list->toArray();
        $fichesLetters = array();

        if(is_array($fieldToTest)){
            $valueToTest = $fieldToTest[0];
            $actualField = $fieldToTest[1];
            foreach($fichesLettersTmp as $fichesLetterTmp){
                $value = $fichesLetterTmp->$valueToTest()->current()->$actualField();
                $fichesLetters[] = substr(strtoupper($value), 0, 1);
            }
        } else {
            foreach($fichesLettersTmp as $fichesLetterTmp){
                $value = $fichesLetterTmp->$fieldToTest();
                $fichesLetters[] = substr(strtoupper($value), 0, 1);
            }
        }
//------

        foreach($alphabet as $letter){
            if(in_array($letter, $fichesLetters)){
                $conf = array();
                $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
                $pageId = 0;
                if ($request instanceof \Psr\Http\Message\ServerRequestInterface) {
                    $routing = $request->getAttribute('routing');
                    if ($routing !== null && method_exists($routing, 'getPageId')) {
                        $pageId = $routing->getPageId();
                    } else {
                        $frontendController = $request->getAttribute('frontend.controller');
                        if ($frontendController !== null && property_exists($frontendController, 'id')) {
                            $pageId = $frontendController->id;
                        }
                    }
                    // Last resort: try to get from query parameters
                    if ($pageId === 0) {
                        $queryParams = $request->getQueryParams();
                        $pageId = (int)($queryParams['id'] ?? 0);
                    }
                }
                // If still no page ID, use 0 (will link to current page in most cases)
                $conf['parameter'] = $pageId ?: 0;
                
                $confArray = $_GET;
                if($settings['one_letter'] && $settings['one_letter'] == '1'){
                    $confArray['char'] = $letter;
                }
                unset($confArray['id']);
                $confArray['char'] = $letter;

                if(!$settings['one_letter'] || $settings['one_letter'] != '1'){
                    $conf['section'] = $letter;
                } else {
                    $conf['additionalParams'] = \TYPO3\CMS\Core\Utility\GeneralUtility::implodeArrayForUrl('', $confArray, '', TRUE);
                }

                $conf['useCacheHash'] = true;
                
                $url = $cObj->typolink($letter,$conf);

                $linkAlphabet[$letter] = $url;
            } else {
                $linkAlphabet[] = $letter;
            }

        }       
        return $linkAlphabet;
    }    
}

?>