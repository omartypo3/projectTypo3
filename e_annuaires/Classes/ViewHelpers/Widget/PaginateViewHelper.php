<?php
namespace Emagineurs\EAnnuaires\ViewHelpers\Widget;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Daniel Dorndorf <dorndorf@featdd.de>
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

class PaginateViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('objects', 'mixed', 'Objects to paginate', true);
        $this->registerArgument('as', 'string', 'Objects passed as fluid variable with this name', true);
        $this->registerArgument('field', 'string', 'Field name of the property in the domain model', false, 'name');
    }

    public function render()
    {
        $objects = $this->arguments['objects'];
        $as = $this->arguments['as'];
        
        $variableProvider = $this->renderingContext->getVariableProvider();
        $variableProvider->add($as, $objects);
        $output = $this->renderChildren();
        $variableProvider->remove($as);
        
        return $output;
    }
}
