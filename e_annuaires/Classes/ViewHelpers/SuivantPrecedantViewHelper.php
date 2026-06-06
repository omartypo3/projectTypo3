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
 
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
 
/**
 * Next/Previous navigation ViewHelper
 *
 * @package e_annuaires
 * @subpackage ViewHelpers
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SuivantPrecedantViewHelper extends AbstractViewHelper {
    
    /**
     * confirme la présence d'un lien pour palier aux difficulté de fluid
     * 
     * @param uid $uidFicheActuelle
     * 
     * @param int $pid
     * 
     * @param string $link
     * @param string $classNext
     * @param string $classPrev
     * @param int $returnUid
     */

    protected $escapeOutput = false;

	/**
	 * @var string
	 */
	protected $classNext = '';

	/**
	 * @var string
	 */
	protected $classPrev = '';

    public function initializeArguments()
    {
        $this->registerArgument('uidFicheActuelle', 'int', 'Current fiche UID', true);
        $this->registerArgument('pid', 'int', 'Page ID', true);
        $this->registerArgument('link', 'string', 'Link', true);
        $this->registerArgument('classNext', 'string', 'Next class', false, 'btn pleft btn-primary btn-rp-lw');
        $this->registerArgument('classPrev', 'string', 'Prev class', false, 'btn pright btn-primary btn-rp-lw');
        $this->registerArgument('returnUid', 'int', 'Return UID', false, 0);
    }

    public function render()
    {
        $uidFicheActuelle = $this->arguments['uidFicheActuelle'];
        $pid = $this->arguments['pid'];
        $link = $this->arguments['link'];
        $classNext = $this->arguments['classNext'];
        $classPrev = $this->arguments['classPrev'];
        $returnUid = $this->arguments['returnUid'];
        $this->classNext = $classNext;
        $this->classPrev = $classPrev;

        //recup tableau d'uid de la recherche, entré dans un cache depuis fiche Controller
            $context = GeneralUtility::makeInstance(Context::class);
            $frontendUserAspect = $context->getAspect('frontend.user');
            $userId = $frontendUserAspect->get('id');

            $sesId = $userId;
            //$sesID = "e8ff2ab06c6c0af20dd3d63472d50db7";
            $fiches = GeneralUtility::makeInstance(CacheManager::class)->getCache('txeannuaires_search_cache')->get($sesId);
                
        //recup uid actuelle
            $uidFiche = $uidFicheActuelle;
            $pidFiche = $pid;

        //recup type actuel
            $actual = explode('/', $this->getActuallink());
            //url sous la forme http://mondomaine.fr/annuaires/type
            $type = $actual[4];
            //au cas où que l'url ai changée, je sauve l'accès aux élus
            if($type =="les-annuaires" || $type == "fiche") { $type ="les-elus"; }

            //echo '<style>.typo3-debug{position:relative;z-index:1000000;}</style>';
            //\TYPO3\CMS\Core\Utility\DebugUtility::debug($actual, 'actuel');


        //dans tableau de résult pris dans le cache, prendre l'uid suivante, ou précédante
        if (!empty($fiches)){
            $backFiche = '';
            $nextFiche = '';
            $back = '';

            foreach ($fiches as $entree){           
                if($back != '' AND $entree == $uidFiche ){
                    $backFiche = $back;
                }
                if($back != '' AND $back == $uidFiche){
                    $nextFiche = $entree;
                    break;
                }
                $back = $entree;
            }

        //renvoyer une url avec ce changement
            if($link =='back'){
                if($backFiche != ''){
                    $content = $returnUid > 0 ? $backFiche : $this->createURL($backFiche,$type,$link) ;

                    return $content;
                }else {
                    return '';
                }

            }else {
                if($nextFiche != ''){
                    $content = $returnUid > 0 ? $nextFiche : $this->createURL($nextFiche,$type,$link) ;
                    return $content;
                }else {
                    return '';
                }
            }
        }

    }

    public function createURL($uid,$type,$link){
        //l'url est bonne mais realurl créé des problèmes
        /*
        $urlParameters=array(
            'tx_eannuaires_pi1[fiche]'=> $link
        );  
        $url = $this->cObj->getTypoLink_URL('7734', $urlParameters);
        return $url ;
        */
        // $url = $GLOBALS['TSFE']->baseUrl ."les-annuaires/".$type."/?tx_eannuaires_pi1[fiche]=".$uid;
        $url = $this->getActuallink(0, '&tx_eannuaires_pi1[fiche]='.$uid);

        if($link == 'back'){
            $lien = '<a href="'.$url.'" class="'.$this->classPrev.'"> <span>&lt;&lt;</span> Précédent</a>';

        }else {
            $lien = '<a href="'.$url.'" class="'.$this->classNext.'"> Suivant <span>&gt;&gt;</span></a>';
        }

        return $lien;    
        
    }

    
    public function getActuallink($addQueryString = 1, $additionalParams = ''){
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
            // Fallback to query parameters if pageId is still 0
            if ($pageId === 0) {
                $queryParams = $request->getQueryParams();
                $pageId = (int)($queryParams['id'] ?? 0);
            }
        }
        
        $confLink = array();
        $confLink['parameter'] = $pageId;
        $confLink['returnLast'] = 'url';
        $confLink['addQueryString'] = $addQueryString;
        $confLink['additionalParams'] = ($additionalParams != '') ? $additionalParams : '';
        
        $cObjRenderer = new ContentObjectRenderer();
        return $cObjRenderer->typoLink_URL($confLink);
        
    }
}