<?php
namespace Emagineurs\ENews\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Xavier LEY <xley@e-magineurs.com>, E-magineurs
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
 * @package e_news_essonne
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
 
class ExplodeViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('list', 'string', 'The list to explode', true);
        $this->registerArgument('separateur', 'string', 'Le separateur pour l\'explode', true);
        $this->registerArgument('item', 'string', 'Item du tableau', false, '');
    }

    /**
     * @return array tableau des element de la liste
     */
    public function render(): array|string
    {
        $list = $this->arguments['list'];
        $separateur = $this->arguments['separateur'];
        $item = $this->arguments['item'] ?? '';
        
		$result = explode($separateur, $list);
	
		if($item){
			$result = $result[$item];
		}
	
		return $result;
    }
	
}

?>