<?php

namespace Emagineurs\ERssaggregator\Lib;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Costa «Coco» C. <ccosta@e-magineurs.com>
 *  (c) 2014 Ian SEBBAGH <isebbagh@e-magineurs.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

use IntlDateFormatter;
use Psr\Log\LogLevel as LogLogLevel;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Sv\AbstractAuthenticationService;


/**
 * Plugin 'RSS feeds' for the 'e_rssaggregator' extension.
 *
 * @author    Julia Pardanaud <jpardanaud@e-magineurs.com>
 * @package    TYPO3
 * @subpackage    tx_erssaggregator
 */
class AggregatorParser
{
	/**
	 * The configuration array
	 * @var array
	 */
	private $conf;

	/**
	 * The RSS reader, we use a library
	 * @var ReadRSS
	 */
	private $rss;

	/**
	 * Initialise the class
	 * @param array $conf The configuration, if not set, we will use the TS config from plugin.tx_erssaggregator_parser setup
	 * @return array The final configuration array
	 */
	function init($conf = null)
	{

		if (!extension_loaded('xsl')) {
			$message = '[ e_rssaggregator ] You need to install php xsl & xslt support. -> aptitude install xsltproc php5-xsl ! (no FE render without this)';


			$logger = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Log\LogManager::class)
				->getLogger('auth');
			$logger->log(LogLogLevel::INFO, $message, [
				'pageId' => $GLOBALS['TSFE']->id ?? 0,
			]);
		}

		if (!is_array($conf)) {
			$conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_erssaggregator_parser.'];
		}

		$this->rss = GeneralUtility::makeInstance(ReadRSS::class);

		$this->conf = $conf;
		return $conf;
	}

	function read($streamUrl)
	{
		if (!empty($this->conf['cache']) && $this->conf['cache'] > 0 && !empty($this->conf['cache_dir'])) {
			$this->rss->cache_dir = $this->conf['cache_dir'];
		}
		$this->rss->cache_time = (int)$this->conf['cache'];

		$charset = 'UTF-8';
		if (isset($GLOBALS['TSFE']) && property_exists($GLOBALS['TSFE'], 'metaCharset') && !empty($GLOBALS['TSFE']->metaCharset)) {
			$charset = $GLOBALS['TSFE']->metaCharset;
		} elseif (!empty($GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'])) {
			$charset = $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'];
		} elseif (ini_get('default_charset')) {
			$charset = ini_get('default_charset');
		}
		$this->rss->cp = $charset;
		$this->rss->items_limit = $this->conf['limit'];
		$this->rss->CDATA = 'content';
		$this->rss->stripHTML = ($this->conf['stripHTML'] == 1) ? true : false;
		$this->rss->stripHTML = false;
		//$this->rss->date_format = $this->conf['date_strftime'];

		$items = $this->rss->get($streamUrl);

		return $items;
	}

	function getInfo($item)
	{

		if (!is_array($item)) {
			return [];
		}

		$channel = array();

		$title = $item['title'] ?? '';
		$description = $item['description'] ?? '';
		$link = $item['link'] ?? '';
		$pubDate = $item['lastBuildDate'] ?? $item['pubDate'] ?? '';
		$generator = $item['generator'] ?? '';
		$language = $item['language'] ?? '';
		$imageUrl = $item['image_url'] ?? '';

		$channel['channel_title']       = strip_tags($this->rss->unhtmlentities(strip_tags($title)));
		$channel['channel_link']        = (string) trim($link);
		$channel['channel_description'] = $this->rss->unhtmlentities($description);
		$channel['channel_pubDate']     = $pubDate;
		$channel['channel_timestamp']   = $pubDate ? strtotime($pubDate) : 0;

		$channel['channel_generator']   = (string) trim($generator);
		$channel['channel_language']    = (string) trim($language);

		$channel['channel_image']       = $imageUrl;

		return $channel;
	}

	/**
	 * Map the information from a ReadRSS item to the wanted item array structure
	 * @param $item
	 * @return array
	 */
	function getInfoItem($item)
	{

		$article = array();
		$article['article_title']             = $item['title'] ?? '';
		$article['article_link']              = $item['link'] ?? '';
		$article['article_comments']          = $item['comments'] ?? '';

		//date with stream format
		$article['article_pubDate']          = $item['pubDate'] ?? '';
		//date with timestamp format
		$article['article_timestamp']        = $article['article_pubDate'] ? strtotime($article['article_pubDate']) : 0;
		//date with user format
		$article['article_strftime']         = $this->formatDate($article['article_timestamp']);

		$article['article_description']      = $this->rss->unhtmlentities($item['description'] ?? '');

		// $article['article_isPermaLink']     = $item['guid']['isPermaLink'];
		$article['article_creator']          = $item['creator'] ?? '';
		$article['article_author']           = $item['author'] ?? '';
		$article['article_category']         = $item['category'] ?? '';
		$article['article_content']          = $this->rss->unhtmlentities($item['content'] ?? '');

		$article['article_bodytext']         = $article['article_description'];
		if (!empty($article['article_content']))
			$article['article_bodytext'] = $article['article_content'];

		if (isset($item['enclosure']['prop']['url'])) {
			$article['article_enclosure']         = $item['enclosure']['prop']['url'];
		}

		if (!empty($article['article_bodytext']) && strpos($article['article_bodytext'], '<img') !== false) {
			$imageLink = explode('<img', $article['article_bodytext']);
			$imageLink = explode('>', $imageLink[1]);
			$imageLink = explode('src="', $imageLink[0]);
			$imageLink = explode('"', $imageLink[1]);
			$article['article_image'] = $imageLink[0];
		} else if (!empty($article['article_enclosure']) && !empty($item['enclosure']['prop']['type']) && strpos($item['enclosure']['prop']['type'], 'image') !== false) {
			$article['article_image'] = $article['article_enclosure'];
		}


		return $article;
	}

	/**
	 * Map the information from all ReadRSS items to the wanted items array structure
	 * @param $items
	 * @return array
	 */
	function getAllInfos($items)
	{
		$allInfos = array();
		$channel = $this->getInfo($items);

		if (empty($items['items']) || !is_array($items['items'])) {
			return $allInfos;
		}

		foreach ($items['items'] as $item) {
			$article = $this->getInfoItem($item);
			$article = array_merge($article, $channel);
			$allInfos[$article['article_timestamp']] = $article;
		}

		return $allInfos;
	}

	/**
	 * Parse a rss stream
	 * @param $streamUrl
	 * @param null $conf
	 * @return array
	 */
	function getStream($streamUrl, $conf = null)
	{
		$this->init($conf);
		$rss = $this->read($streamUrl);
		return $this->getAllInfos($rss);
	}

	private function formatDate(int $timestamp): string
	{
		if ($timestamp <= 0) {
			return '';
		}

		$format = $this->conf['formatDate'] ?? '';
		if ($format === '') {
			return (new \DateTimeImmutable('@' . $timestamp))->format(\DateTimeInterface::RFC3339);
		}

		$icuPattern = $this->convertStrftimeToIcu($format);

		if (class_exists(IntlDateFormatter::class)) {
			$locale = \Locale::getDefault();
			if (isset($GLOBALS['TSFE']) && !empty($GLOBALS['TSFE']->config['config']['locale_all'])) {
				$locale = $GLOBALS['TSFE']->config['config']['locale_all'];
			}
			$formatter = new IntlDateFormatter(
				$locale,
				IntlDateFormatter::NONE,
				IntlDateFormatter::NONE,
				date_default_timezone_get(),
				null,
				$icuPattern
			);
			if ($formatter !== false) {
				$value = $formatter->format($timestamp);
				if ($value !== false) {
					return $value;
				}
			}
		}

		$phpDateFormat = $this->convertStrftimeToPhpDate($format);
		return (new \DateTimeImmutable('@' . $timestamp))
			->setTimezone(new \DateTimeZone(date_default_timezone_get()))
			->format($phpDateFormat);
	}

	private function convertStrftimeToIcu(string $format): string
	{
		$map = [
			'%a' => 'EEE',
			'%A' => 'EEEE',
			'%b' => 'MMM',
			'%B' => 'MMMM',
			'%d' => 'dd',
			'%e' => 'd',
			'%H' => 'HH',
			'%I' => 'hh',
			'%m' => 'MM',
			'%M' => 'mm',
			'%p' => 'a',
			'%S' => 'ss',
			'%y' => 'yy',
			'%Y' => 'yyyy',
			'%z' => 'Z',
			'%Z' => 'z',
		];

		return strtr($format, $map);
	}

	private function convertStrftimeToPhpDate(string $format): string
	{
		$map = [
			'%a' => 'D',
			'%A' => 'l',
			'%b' => 'M',
			'%B' => 'F',
			'%d' => 'd',
			'%e' => 'j',
			'%H' => 'H',
			'%I' => 'h',
			'%m' => 'm',
			'%M' => 'i',
			'%p' => 'A',
			'%S' => 's',
			'%y' => 'y',
			'%Y' => 'Y',
			'%z' => 'O',
			'%Z' => 'T',
		];

		return strtr($format, $map);
	}
}
