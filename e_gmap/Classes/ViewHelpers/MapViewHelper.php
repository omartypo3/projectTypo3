<?php

namespace Emagineurs\EGmap\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

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

/***
 *
 *
 * Exemple:
 * {namespace egmap=Emagineurs\EGmap\ViewHelpers}
 * <egmap:map pois="{table}_{uid}" property="{map:{recherche:{actif:0}}}"/>
 */

class MapViewHelper extends AbstractViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @var array
     */
    protected $typoScriptSetup;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @return void
     */
    public function injectConfigurationManager(
        \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
    ) {
        $this->configurationManager = $configurationManager;
        $this->typoScriptSetup = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
    }

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('pois', 'string', 'poi ou liste de poi, de la forme table_uid', false, null);
        $this->registerArgument('type', 'string', 'USER ou USER_INT', false, 'USER');
        $this->registerArgument('property', 'array', 'Property array', false, []);
    }

    /**
     * Allow to put a map plugin in other plugin.
     *
     * @return string
     */
    public function render()
    {
        $pois = $this->arguments['pois'];
        $type = $this->arguments['type'];
        $property = $this->arguments['property'];

        if ($pois === null) {
            $pois = $this->renderChildren();
        }

        $contentObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
        $contentObject->start($contentObject->data);

        $settings = $this->typoScriptSetup['plugin.']['tx_egmap.']['settings'];
        $settings['pois'] = $pois;

        $conf = array();
        $conf['userFunc'] = 'TYPO3\CMS\Extbase\Core\Bootstrap->run';
        $conf['vendorName'] = 'Emagineurs';
        $conf['extensionName'] = 'EGmap';
        $conf['pluginName'] = 'Gmap';
        $conf['controllerName'] = 'Map';
        $conf['settings'] = $settings;

        if (is_array($property)) {
            foreach ($property as $key => $value) {
                $conf['settings'][$key] = $value;
            }
        }

        $content = $contentObject->cObjGetSingle($type, $conf);

        return $content;
    }
}