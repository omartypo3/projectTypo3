<?php
namespace Emagineurs\ERssaggregator\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Costa «Coco» C. <ccosta@e-magineurs.com>
 *  (c) 2014 Ian SEBBAGH <isebbagh@e-magineurs.com>
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

use Emagineurs\ERssaggregator\Lib\AggregatorParser;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 *
 *
 * @package e_rssaggregator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AggregatorController extends ActionController {

	/**
	 * Initialize current action
	 *
	 * @return void
	 */
	public function initializeAction(): void {
		$this->initSettings();
	}

	/**
	 * action list
	 *
	 * @return ResponseInterface
	 */
	public function listAction(): ResponseInterface {
		$items = [];

		$listFeedUrls = $this->settings['listFeed'] ?? [];
		if(!empty($listFeedUrls) && is_array($listFeedUrls)){
			//We instantiate the parser
			/** @var AggregatorParser $rssParser */
			$rssParser = GeneralUtility::makeInstance(AggregatorParser::class);
			$rssParser->init($this->settings);

			//We build the item array
			foreach($listFeedUrls as $streamUrl){
				$this->parserMix((string)$streamUrl, $rssParser, $items);
			}

			//We sort the items by date
			krsort($items);

            //Inverse if needed
            if(($this->settings['orderDirection'] ?? '') === 'asc') {
                $items = array_reverse($items);
            }

			//We apply the item number limitation
			if(!empty($items) && count($items) > 0){
				$items = array_slice($items, 0, (int)$this->settings['limit2']);
			}
		}

		$this->view->assign('items', $items);
		$listFeed = $this->settings['listFeed'] ?? [];
		$this->view->assign('rssStreamCount', is_array($listFeed) ? count($listFeed) : 0);

		return $this->htmlResponse();
	}

	/**
	 * Parse the information and store it into an array
	 *
	 * @param string $streamUrl The rss url
	 * @param AggregatorParser $rssParser The parser
	 * @param array $items The array that contains the previous values
	 * @return array The parsed informations, the array use timestamp as key
	 */
	public function parserMix(string $streamUrl, AggregatorParser $rssParser, array &$items): array{
		// Skip if URL is empty or invalid
		if (empty($streamUrl) || filter_var($streamUrl, FILTER_VALIDATE_URL) === false) {
			return $items;
		}

		$rss = $rssParser->read($streamUrl);
		
		// Skip if RSS parsing failed
		if (!is_array($rss)) {
			return $items;
		}

		$channel = $rssParser->getInfo($rss);

		if(is_array($rss['items'] ?? null)){
			foreach($rss['items'] as $item){
				$article = $rssParser->getInfoItem($item);
				$article = array_merge($article, $channel);
				
				// Ensure article_link is not empty before adding
				if (empty($article['article_link'])) {
					continue;
				}
				
				$date = $article['article_timestamp'] ?? 0;

				while(isset($items[$date])){
					$date=$date+1;
				}
				$items[$date] = $article;
			}
		}

		return $items;
	}


	/**
	 * Initialize the $this->settings argument with ts and flexform settings
	 *
	 * @return void
	 */
	private function initSettings(): void{
		if(empty($this->settings['limit'])) $this->settings['limit'] = 10;
		if(empty($this->settings['limit2'])) $this->settings['limit2'] = 10;
		if(empty($this->settings['formatDate'])) $this->settings['formatDate'] = '%A %d %B %Y; %Hh%M';
		if(!isset($this->settings['stripHTML'])) $this->settings['stripHTML'] = 1;
		if(!isset($this->settings['cropAdd'])) $this->settings['cropAdd'] = '...';
		if(empty($this->settings['cropTitle'])) $this->settings['cropTitle'] = 100;
		if(empty($this->settings['cropDesc'])) $this->settings['cropDesc'] = 100;
		if(empty($this->settings['cropContent'])) $this->settings['cropContent'] = 500;
		if(empty($this->settings['cropContenu'])) $this->settings['cropContenu'] = 500;
		if(empty($this->settings['target'])) $this->settings['target'] = '_blank';
		if(!isset($this->settings['image'])) $this->settings['image'] = 1;
		if(!isset($this->settings['imageWidth'])) $this->settings['imageWidth'] = 250;
		if(!isset($this->settings['imageHeight'])) $this->settings['imageHeight'] = 250;
		if(!isset($this->settings['cache'])) $this->settings['cache'] = 4;

		if($this->settings['cache']<59){
			$this->settings['cache'] = $this->settings['cache']*60*60;
		}

		$this->settings['formatDate'] = str_replace(';', ',', $this->settings['formatDate']);

		$listFeedSetting = $this->settings['listFeed'] ?? '';
		if (is_string($listFeedSetting)) {
			$listFeed = explode("\n", $listFeedSetting);
		} elseif (is_array($listFeedSetting)) {
			$listFeed = $listFeedSetting;
		} else {
			$listFeed = [];
		}
		// Filter out empty values and validate URLs
		$listFeed = array_filter(array_map('trim', $listFeed), function($url) {
			return !empty($url) && filter_var($url, FILTER_VALIDATE_URL) !== false;
		});
		$this->settings['listFeed'] = array_values($listFeed);
	}
}
?>