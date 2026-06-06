<?php
namespace BravoBuero\BbPortfolio\Controller;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\ErrorController;
use BravoBuero\BbPortfolio\Domain\Repository\KundenRepository;
use BravoBuero\BbPortfolio\Domain\Repository\KategorienRepository;
use BravoBuero\BbPortfolio\Domain\Repository\HashtagsRepository;
use BravoBuero\BbPortfolio\Domain\Repository\PortfolioRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use BravoBuero\BbPortfolio\Utility\ViewUtility;
use BravoBuero\BbPortfolio\Domain\Model\Kategorien;
use BravoBuero\BbPortfolio\Domain\Model\Hashtags;
use BravoBuero\BbPortfolio\Domain\Model\Kunden;
use BravoBuero\BbPortfolio\Domain\Model\Portfolio;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException;
use TYPO3\CMS\Extbase\Property\Exception\InvalidSourceException;
use TYPO3\CMS\Core\Error\Http\PageNotFoundException;
use TYPO3\CMS\Extbase\Mvc\Web\Response;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Page\PageRenderer;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 selectedKundenproject is
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
 * \TYPO3\CMS\Extbase\Mvc\Controller\ActionController /// NotfoundBaseController
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * PortfolioController
 */
class PortfolioController extends ActionController
{

    /*error Handling*/
    /**
     * @var string
     */
    protected $entityNotFoundMessage = 'The requested entity could not be found.';
    
    /**
     * @var string
     */
    protected $unknownErrorMessage = 'An unknown error occurred. The wild monkey horde in our basement will try to fix this as soon as possible.';
    
    /**
				 * kundenRepository
				 *
				 * @var \BravoBuero\BbPortfolio\Domain\Repository\KundenRepository
				 */
				protected $kundenRepository = NULL;
    
    /**
				 * kategorienRepository
				 *
				 * @var \BravoBuero\BbPortfolio\Domain\Repository\KategorienRepository
				 */
				protected $kategorienRepository = NULL;
    
    /**
				 * hashtagsRepository
				 *
				 * @var \BravoBuero\BbPortfolio\Domain\Repository\HashtagsRepository
				 */
				protected $hashtagsRepository = NULL;
    
    /**
				 * portfolioRepository
				 *
				 * @var \BravoBuero\BbPortfolio\Domain\Repository\PortfolioRepository
				 */
				protected $portfolioRepository = NULL;
    
    private function setKundenCss()
    {
        $kundens = $this->kundenRepository->findAll();
        //Kundenspezifische CSS Daten im Header Ausgeben
        $cssView = ViewUtility::init()->getView('Kunden/Header.html', 'bb_portfolio');
        $cssView->assignMultiple(array('kundens' => $kundens));
        $GLOBALS['TSFE']->additionalHeaderData['tx_bbportfolio'] = $cssView->render();
    }
    
    /**
     * action list
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Kategorien $kategorien
     * @param \BravoBuero\BbPortfolio\Domain\Model\Hashtags $hashtags
     * @param int $offset
     * @return void
     */
    public function listAction(Kategorien $kategorien = NULL, Hashtags $hashtags = NULL, $offset = 0): ResponseInterface
    {
        $limit = 12;
        $this->setKundenCss();
        $offsetBefore = NULL;
        if (isset($_GET['offsetBefore'])) {
            if (isset($_GET['offsetBefore'])) {
                if ($_GET['offsetBefore']) {
                    $offsetBefore = intval($_GET['offsetBefore']);
                    $offset = 0;
                    $limit = $offsetBefore + $limit;
                }
            }
        }
        //echo $offsetBefore;die;
        if ($offsetBefore) {
            $this->view->assign('selectedOffset', $offsetBefore);
        } elseif ($offset) {
            $this->view->assign('selectedOffset', $offset);
        }
        //Bestückung mit Kategorien
        $kategoriens = $this->kategorienRepository->findAll();
        $this->view->assign('kategoriens', $kategoriens);
        //$hashtags = $this->hashtagsRepository->findAllUsed();
        //$this->view->assign('hashtags', $hashtags);
        //Laden der Projekte
        $selectedKategorie = NULL;
        $selectedHashtag = NULL;
        if ($this->request->hasArgument('kategorien')) {
            $selectedKategorie = $this->kategorienRepository->findByUid($this->request->getArgument('kategorien'));
            $this->view->assign('selectedKategorie', $this->request->getArgument('kategorien'));
        }
        if ($this->request->hasArgument('hashtags')) {
            $selectedHashtag = $this->hashtagsRepository->findByUid($this->request->getArgument('hashtags'));
            $this->view->assign('selectedHashtag', $this->request->getArgument('hashtags'));
        }
		
		if($selectedKategorie || $selectedHashtag){
			$keywordArr = array();
			if($selectedKategorie) $keywordArr[] = $selectedKategorie->getName();
			if($selectedHashtag) $keywordArr[] = $selectedHashtag->getName();
            $metaTagManagerRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);
            $metaTagManager = $metaTagManagerRegistry->getManagerForProperty('description');
            $keywords = implode(', ', $keywordArr);
            $description = 'Ausgewählte Projekte zum Thema: ' . $keywords;

            /*$pageRenderer->addAdditionalHeaderData('<meta name="keywords" content="' . implode(", ",$keywordArr) . '"/>');
            $pageRenderer->addAdditionalHeaderData('<meta name="description" content="Ausgewählte Projekte zum Thema: ' . implode(", ",$keywordArr) . '"/>');
		*/

            $metaTagManager->addProperty('keywords', $keywords);
            $metaTagManager->addProperty('description', $description);
         }
		/*
		$this->response->addAdditionalHeaderData('<meta name="keywords" content="' . $keywords . '"/>');
		$this->response->addAdditionalHeaderData('<meta name="description" content="' . $teaser . '"/>');
		*/
        $portfoliosKategorien = $this->portfolioRepository->findByKategorienHashtags($selectedKategorie);
        $hashtags = array();
        foreach ($portfoliosKategorien as $portfolio) {
            foreach ($portfolio->getHashtags() as $hashtag) {
                $hashtags[$hashtag->getUid()] = true;
            }
        }
        $hashtagsSorted = $this->hashtagsRepository->sortHashtags(array_keys($hashtags));
        $this->view->assign('hashtags', $hashtagsSorted);
        $portfoliosAnzahl = count($this->portfolioRepository->findByKategorienHashtags($selectedKategorie, $selectedHashtag));
        //13
        //die;
        $portfolios = $this->portfolioRepository->findByKategorienHashtags($selectedKategorie, $selectedHashtag, $offset, $limit);
        //12
        //echo count($portfolios);
        $rest = ceil(count($portfolios) / 3) * 3 - count($portfolios);
        $restArr = array();
        for ($x = 0; $x < $rest; $x++) {
            $restArr[] = $x + 1;
        }
        $this->view->assign('rest', $restArr);
        $this->view->assign('portfolios', $portfolios);
        //echo $offset.'+'.$limit; //13-1 > 0+12
        //12+12
        //25-1 >
        //if ($portfoliosAnzahl - 1 > $offset + $limit) {
        if ($portfoliosAnzahl > $offset + $limit) {
            $this->view->assign('showMore', true);
            $this->view->assign('offset', $offset + $limit);
        }
        return $this->htmlResponse();
    }
    
    /**
     * action latest
     * 
     * @return void
     */
    public function latestAction(): ResponseInterface
    {
        $this->setKundenCss();
        $portfolios = $this->portfolioRepository->findLatest();
        $this->view->assign('portfolios', $portfolios);
        return $this->htmlResponse();
    }
	
      /**
     * action latest
     * 
     * @return void
     */
    public function latestkategorienAction(): ResponseInterface
    {
		
		if($this->settings["kategorien"]){
			$kategorien = $this->kategorienRepository->findByUid($this->settings['kategorien']);
			$portfolios = $this->portfolioRepository->findByKategorienHashtags( $kategorien );
		} else {
			$portfolios = $this->portfolioRepository->findLatest();
		}
		//
		
		
		
        $this->setKundenCss();
		
        $this->view->assign('kategorien', $kategorien);        
        $this->view->assign('portfolios', $portfolios);
		$this->view->assign('settings', $this->settings);
        return $this->htmlResponse();
    }
	
	
    /**
     * action listkunden
     * 
     * @return void
     */
    public function listkundenAction(): ResponseInterface
    {
        $kundens = $this->kundenRepository->findAll();
        $this->view->assign('kundens', $kundens);
        return $this->htmlResponse();
    }
    
    /**
     * action detailkunden
     * 
     * @param \BravoBuero\BbPortfolio\Domain\Model\Kunden $kunden
     * @return void
     */
    public function detailkundenAction(Kunden $kunden): ResponseInterface
    {
        $metaTagManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('description');
        $metaTagManager->addProperty('description', $kunden->getSeoDescription());

        $this->setKundenCss();
        $this->view->assign('kunden', $kunden);
        //echo $kunden->getUid();
        $portfolios = $this->portfolioRepository->findByKunden($kunden);
        //echo "anzahl:".count($portfolios);die;
        $this->view->assign('portfolios', $portfolios);
         return $this->htmlResponse();
    }
    
    /**
				 * action detail
				 *
				 * @param \BravoBuero\BbPortfolio\Domain\Model\Portfolio $portfolio
				 * @param \BravoBuero\BbPortfolio\Domain\Model\Kategorien $kategorien
				 * @param \BravoBuero\BbPortfolio\Domain\Model\Hashtags $hashtags
				 * @param \BravoBuero\BbPortfolio\Domain\Model\Kunden $kunden
				 * @return void
				 * @Extbase\IgnoreValidation("portfolio")
				 */
				public function detailAction(Portfolio $portfolio, Kategorien $kategorien = NULL, Hashtags $hashtags = NULL, Kunden $kunden = NULL): ResponseInterface
    {

        $this->setKundenCss();
        $this->view->assign('portfolio', $portfolio);
        return $this->htmlResponse();
    }
    
    /**
     * action megamenu
     * 
     * @return void
     */
    public function megamenuAction(): ResponseInterface
    {
        $portfolios = $this->portfolioRepository->findLatest();
        $this->view->assign('portfolios', $portfolios);
        return $this->htmlResponse();
    }
    
    /**
     * action detailnav
     * 
     * @return void
     */
    public function detailnavAction(): ResponseInterface
    {
        $portfolio = NULL;
        $kategorien = NULL;
        $hashtags = NULL;
        $kunden = NULL;
        $offsetBefore = 0;
        if (isset($_GET['tx_bbportfolio_portfolioausgabe'])) {
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['offset'])) {
                if ($_GET['tx_bbportfolio_portfolioausgabe']['offset']) {
                    $offsetBefore = $_GET['tx_bbportfolio_portfolioausgabe']['offset'];
                }
            }
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['kunden'])) {
                if ($_GET['tx_bbportfolio_portfolioausgabe']['kunden']) {
                    $kunden = $this->kundenRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['kunden']);
                }
            }
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['portfolio'])) {
                $portfolio = $this->portfolioRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['portfolio']);
            }
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['kategorien'])) {
                if ($_GET['tx_bbportfolio_portfolioausgabe']['kategorien']) {
                    $kategorien = $this->kategorienRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['kategorien']);
                }
            }
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['hashtags'])) {
                if ($_GET['tx_bbportfolio_portfolioausgabe']['hashtags']) {
                    $hashtags = $this->hashtagsRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['hashtags']);
                }
            }
        }
        if ($kunden) {
            $portfolios = $this->portfolioRepository->findByKunden($kunden);
        } else {
            $portfolios = $this->portfolioRepository->findByKategorienHashtags($kategorien, $hashtags);
        }
        $portfolioPrev = NULL;
        $portfolioNext = NULL;
        $prevKey = NULL;
        $portfolioIndex = 0;
        foreach ($portfolios as $key) {
            if ($prevKey) {
                //wenn es ein vorhergehendes gibt
                if ($key == $portfolio) {
                    $portfolioPrev = $prevKey;
                }
                if ($prevKey == $portfolio) {
                    $portfolioNext = $key;
                }
            }
            if ($portfolioNext) {
                break;
            }
            $portfolioIndex++;
            $prevKey = $key;
        }
        //echo ;
        if ($offsetBefore < ceil($portfolioIndex / 12) - 1) {
            $offsetBefore = (ceil($portfolioIndex / 12) - 1) * 12;
        }
        if ($portfolio) {
            $this->view->assign('portfolio', $portfolio);
        }
        if ($portfolioPrev) {
            $this->view->assign('portfolioPrev', $portfolioPrev);
        }
        if ($portfolioNext) {
            $this->view->assign('portfolioNext', $portfolioNext);
        }
        if ($kunden) {
            $this->view->assign('selectedKunden', $kunden);
        }
        if ($kategorien) {
            $this->view->assign('selectedKategorie', $kategorien);
        }
        if ($hashtags) {
            $this->view->assign('selectedHashtag', $hashtags);
        }
        if ($offsetBefore) {
            $this->view->assign('offsetBefore', $offsetBefore);
        }
        return $this->htmlResponse();
    }
    
    /**
     * action detailkundennav
     * 
     * @return void
     */
    public function detailkundennavAction(): ResponseInterface
    {
        $kunden = NULL;
        if (isset($_GET['tx_bbportfolio_portfolioausgabe'])) {
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['kunden'])) {
                if ($_GET['tx_bbportfolio_portfolioausgabe']['kunden']) {
                    $kunden = $this->kundenRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['kunden']);
                }
            }
        }
        $this->view->assign('kunden', $kunden);
        $kundens = $this->kundenRepository->findAll();
        $kundenPrev = NULL;
        $kundenNext = NULL;
        $prevKey = NULL;
        foreach ($kundens as $key) {
            if ($prevKey) {
                //wenn es ein vorhergehendes gibt
                if ($key == $kunden) {
                    $kundenPrev = $prevKey;
                }
                if ($prevKey == $kunden) {
                    $kundenNext = $key;
                }
            }
            if ($kundenNext) {
                break;
            }
            $prevKey = $key;
        }
        if ($kundenPrev) {
            $this->view->assign('kundenPrev', $kundenPrev);
        }
        if ($kundenNext) {
            $this->view->assign('kundenNext', $kundenNext);
        }
        return $this->htmlResponse();
    }
    
    /**
     * action detailback
     * 
     * @return void
     */
    public function detailbackAction(): ResponseInterface
    {
        $kategorien = NULL;
        $hashtags = NULL;
        $kunden = NULL;
        $portfolio = NULL;
        $offsetBefore = 0;
        if (isset($_GET['tx_bbportfolio_portfolioausgabe'])) {
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['offset'])) {
                if ($_GET['tx_bbportfolio_portfolioausgabe']['offset']) {
                    $offsetBefore = $_GET['tx_bbportfolio_portfolioausgabe']['offset'];
                }
            }
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['portfolio'])) {
                $portfolio = $this->portfolioRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['portfolio']);
            }
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['kunden'])) {
                if ($_GET['tx_bbportfolio_portfolioausgabe']['kunden']) {
                    $kunden = $this->kundenRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['kunden']);
                }
            }
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['kategorien'])) {
                if ($_GET['tx_bbportfolio_portfolioausgabe']['kategorien']) {
                    $kategorien = $this->kategorienRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['kategorien']);
                }
            }
            if (isset($_GET['tx_bbportfolio_portfolioausgabe']['hashtags'])) {
                if ($_GET['tx_bbportfolio_portfolioausgabe']['hashtags']) {
                    $hashtags = $this->hashtagsRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['hashtags']);
                }
            }
        }
        if ($kunden) {
            $portfolios = $this->portfolioRepository->findByKunden($kunden);
        } else {
            $portfolios = $this->portfolioRepository->findByKategorienHashtags($kategorien, $hashtags);
        }
        $portfolioPrev = NULL;
        $portfolioNext = NULL;
        $prevKey = NULL;
        $portfolioIndex = 0;
        foreach ($portfolios as $key) {
            if ($prevKey) {
                //wenn es ein vorhergehendes gibt
                if ($key == $portfolio) {
                    $portfolioPrev = $prevKey;
                }
                if ($prevKey == $portfolio) {
                    $portfolioNext = $key;
                }
            }
            if ($portfolioNext) {
                break;
            }
            $portfolioIndex++;
            $prevKey = $key;
        }
        //echo ;
        if ($offsetBefore < ceil($portfolioIndex / 12) - 1) {
            $offsetBefore = (ceil($portfolioIndex / 12) - 1) * 12;
        }
        if ($portfolio) {
            $this->view->assign('portfolio', $portfolio);
        }
        if ($kunden) {
            $this->view->assign('selectedKunden', $kunden);
        }
        if ($kategorien) {
            $this->view->assign('selectedKategorie', $kategorien);
        }
        if ($hashtags) {
            $this->view->assign('selectedHashtag', $hashtags);
        }
        if ($offsetBefore) {
            $this->view->assign('offsetBefore', $offsetBefore);
        }

        return $this->htmlResponse();
    }
    
   /**
 * @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request
 * @throws \Exception
 * @override \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
 * @return \Psr\Http\Message\ResponseInterface
 */
public function processRequest(RequestInterface $request): \Psr\Http\Message\ResponseInterface
{
    if ($request->hasArgument('kunden') && $request->getArgument('kunden')) {
        if (!$this->kundenRepository->findByUid($request->getArgument('kunden'))) {
            $response = GeneralUtility::makeInstance(ErrorController::class)
                ->pageNotFoundAction($GLOBALS['TYPO3_REQUEST'], $this->entityNotFoundMessage);
            throw new \TYPO3\CMS\Core\Http\ImmediateResponseException($response);
        }
    }

    if ($request->hasArgument('portfolio') && $request->getArgument('portfolio')) {
        if (!$this->portfolioRepository->findByUid($request->getArgument('portfolio'))) {
            $response = GeneralUtility::makeInstance(ErrorController::class)
                ->pageNotFoundAction($GLOBALS['TYPO3_REQUEST'], $this->entityNotFoundMessage);
            throw new \TYPO3\CMS\Core\Http\ImmediateResponseException($response);
        }
    }

    try {
        return parent::processRequest($request);
    } catch (\Exception $exception) {
        $previousException = $exception->getPrevious();
        if ($exception instanceof \TYPO3\CMS\Extbase\Property\Exception
            && ($previousException instanceof TargetNotFoundException || $previousException instanceof InvalidSourceException)) {
            $response = GeneralUtility::makeInstance(ErrorController::class)
                ->pageNotFoundAction($GLOBALS['TYPO3_REQUEST'], $this->entityNotFoundMessage);
            throw new \TYPO3\CMS\Core\Http\ImmediateResponseException($response);
        }
        throw $exception;
    }
}

    
    // /**
    //  * @override \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
    //  * @return void
    //  */
    // protected function callActionMethod()
    // {
    //     try {    parent::callActionMethod();
    //     } catch (\Exception $exception) {    // This enables you to trigger the call of TYPO3s page-not-found handler by throwing \TYPO3\CMS\Core\Error\Http\PageNotFoundException
    //         if ($exception instanceof PageNotFoundException) {
	// 												$response = GeneralUtility::makeInstance(ErrorController::class)->pageNotFoundAction($GLOBALS['TYPO3_REQUEST'], $this->entityNotFoundMessage);
	// 												throw new TYPO3\CMS\Core\Http\ImmediateResponseException($response);
	// 											}
    //         // $GLOBALS['TSFE']->pageNotFoundAndExit has not been called, so the exception is of unknown type.
    //         //            \VendorName\ExtensionName\Logger\ExceptionLogger::log($exception, $this->request->getControllerExtensionKey(), \VendorName\ExtensionName\Logger\ExceptionLogger::SEVERITY_FATAL_ERROR);
    //         // If the plugin is configured to do so, we call the page-unavailable handler.
    //         if (isset($this->settings['usePageUnavailableHandler']) && $this->settings['usePageUnavailableHandler']) {
	// 												$response = GeneralUtility::makeInstance(ErrorController::class)->unavailableAction($GLOBALS['TYPO3_REQUEST'], $this->unknownErrorMessage);
	// 												throw new TYPO3\CMS\Core\Http\ImmediateResponseException($response);
	// 											}
    //         // Else we append the error message to the response. This causes the error message to be displayed inside the normal page layout. WARNING: the plugins output may gets cached.
    //         if ($this->response instanceof Response) {
    //             $this->response->setStatus(500);
    //         }
    //         $this->response->appendContent($this->unknownErrorMessage);
    //     }
    // }
    
    /**
     * action detailrelated
     * 
     * @return void
     */
    public function detailrelatedAction(): ResponseInterface
    {
        if ($_GET['tx_bbportfolio_portfolioausgabe']['portfolio']) {
            $portfolio = $this->portfolioRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['portfolio']);
            if ($portfolio) {
                if (isset($_GET['tx_bbportfolio_portfolioausgabe']['hashtags'])) {
                    if ($_GET['tx_bbportfolio_portfolioausgabe']['hashtags']) {
                        $hashtags = $this->hashtagsRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['hashtags']);
                    }
                }
                if (isset($_GET['tx_bbportfolio_portfolioausgabe']['kategorien'])) {
                    if ($_GET['tx_bbportfolio_portfolioausgabe']['kategorien']) {
                        $kategorien = $this->kategorienRepository->findByUid($_GET['tx_bbportfolio_portfolioausgabe']['kategorien']);
                    }
                }
                if (!$hashtags) {
                    $hashtags = NULL;
                }
                if (!$kategorien) {
                    $kategorien = NULL;
                }
                $relatedArr = array();
                foreach ($portfolio->getRelated() as $related) {
                    if($related->getUid()) $relatedArr[$related->getUid()] = $related;
                }
                $max = 2;
                if (count($relatedArr) < $max) {
                    $otherRelated = $this->portfolioRepository->findByKategorienOrHashtags($portfolio, $kategorien, $hashtags);
                    $otherRelatedArr = array();
                    foreach ($otherRelated as $related) {
						if($related->getUid()){
							if (!isset($relatedArr[$related->getUid()])) {
								$otherRelatedArr[$related->getUid()] = $related;
							}
						}
                    }
                    shuffle($otherRelatedArr);
                    foreach ($otherRelatedArr as $related) {
                        $relatedArr[$related->getUid()] = $related;
                        if ($max <= count($relatedArr)) {
                            break;
                        }
                    }
                }
                /*				echo "<hr>";
                				foreach($relatedArr as $rel) echo $rel->getUid().":";
                				
                				echo "<hr>";*/
                
                $this->view->assign('relateds', $relatedArr);
            }
        }
        return $this->htmlResponse();
    }

				public function injectKundenRepository(KundenRepository $kundenRepository): void
				{
					$this->kundenRepository = $kundenRepository;
				}

				public function injectKategorienRepository(KategorienRepository $kategorienRepository): void
				{
					$this->kategorienRepository = $kategorienRepository;
				}

				public function injectHashtagsRepository(HashtagsRepository $hashtagsRepository): void
				{
					$this->hashtagsRepository = $hashtagsRepository;
				}

				public function injectPortfolioRepository(PortfolioRepository $portfolioRepository): void
				{
					$this->portfolioRepository = $portfolioRepository;
				}

}