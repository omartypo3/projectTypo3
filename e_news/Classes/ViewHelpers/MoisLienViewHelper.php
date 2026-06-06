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
 
class MoisLienViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('label', 'string', 'Texte du lien', true);
        $this->registerArgument('sens', 'string', 'Suivant/precedent', true);
        $this->registerArgument('target', 'string', 'Attribut target', false, '');
        $this->registerArgument('mois', 'string', 'Si = a 1, on affiche le nom des mois, pas le label', false, 0);
    }
	
    /**
     * @return string Mois selon les parametres de l'url
     */
    public function render(): string
    {
        $label = $this->arguments['label'];
        $sens = $this->arguments['sens'];
        $target = $this->arguments['target'] ?? '';
        $mois = $this->arguments['mois'] ?? 0;
		$getVars = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('tx_enews_pi1');		
        $parameter = $GLOBALS['TSFE']->id;
        
        if($getVars['filtreMois']){
            if($sens == 'suivant'){
                $content = $getVars['filtreMois']+1;
            } else {
                $content = $getVars['filtreMois']-1;
            }
        } else {
            if($sens == 'suivant'){
                $content = 1;
            } else {
                $content = -1;
            }
        }        
        $additionalParams = array(
            'tx_enews_pi1' => array(
                'filtreMois' => $content
            ),
            'no_cache' => 1
        );

        if($mois == '1'){
            $numMois = date('m')+intval($content);
            
            // Les 31, le mktime prend le mois suivant, on prend donc une autre date que la date courante a ces occasions
            $not31st = (date('j') == 31) ? 1 : date('j');
            
            $dateMois = mktime(date("H"), date("i"), date("s"), $numMois, $not31st);

            $label = strftime("%B", $dateMois);
        }
        
		$contentRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');        
        $link = $contentRenderer->getTypoLink($label,$parameter,$additionalParams,$target);
        
		return $link;
    }
	
}

?>