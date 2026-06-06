<?php

namespace Emagineurs\EGmap\ViewHelpers;


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

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/***
 *
 *
 * Exemple:
 * {namespace egmap=Emagineurs\EGmap\ViewHelpers}
 * <egmap:displayMap pois="{table}_{uid}" property="{map:{recherche:{actif:0}}}"/>
 */

class DisplayMapViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'div';

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('settings',  'array' , 'Settings', true);
        $this->registerArgument('eGmapPois', 'string', 'Formated pois string', false);
        $this->registerArgument('eGmapKmls', 'string', 'Formated kmls string', false);
        $this->registerArgument('width', 'string', 'Width', false);
        $this->registerArgument('height', 'string', 'Height', false);
    }

    /**
     * Display a map element
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public function render()
    {
        $width = (!empty($this->arguments['width'])) ? $this->arguments['width'] : $this->arguments['settings']['width'];
        $height = (!empty($this->arguments['height'])) ? $this->arguments['height'] : $this->arguments['settings']['height'];
        $this->tag->addAttribute('id', "eGmapMap__" . $this->arguments['settings']['map']['mapUniqId']);
        $this->tag->addAttribute('style', 'width: ' . $width . '; height: ' . $height . ';');
        $this->tag->forceClosingTag(true);

        return $this->tag->render();
    }
}