<?php
namespace Emagineurs\EAnnuaires\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Xavier Ley <xley@e-magineurs.com>, E-magineurs
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
 
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
 
/**
 * String replacement ViewHelper
 *
 * @package e_annuaires
 * @subpackage ViewHelpers
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class StrReplaceViewHelper extends AbstractViewHelper {

    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('stringToReplace', 'string', 'String to replace', true);
        $this->registerArgument('stringToAdd', 'string', 'String to add', true);
        $this->registerArgument('stringToParse', 'string', 'String to parse', false, '');
    }

    public function render()
    {
        $stringToReplace = $this->arguments['stringToReplace'];
        $stringToAdd = $this->arguments['stringToAdd'];
        $stringToParse = $this->arguments['stringToParse'];
        if($stringToParse){
            return str_replace($stringToReplace, $stringToAdd, $stringToParse);
        } else {
            return str_replace($stringToReplace, $stringToAdd, $this->renderChildren());
        }
    }
    
}

?>