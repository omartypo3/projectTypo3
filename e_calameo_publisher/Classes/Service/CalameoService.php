<?php

namespace Emagineurs\ECalameoPublisher\Service;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Ian SEBBAGH <vscharpen@e-magineurs.com>
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

class CalameoService
{

	/**
	 * API Configuration  
	 */
	private string $endPointApi;
	private string $endPointUpload;
	private string $apikey;
	private string $secret;
	private string $subscription;
	private int $publishmode;

	/**
	 * PDF Data
	 */
	private array $listePDF;
	protected int $nbPdf = 0;

	public function __construct(protected ExtensionConfiguration $extensionConfiguration)
	{
		$this->initializeConfiguration();
	}

	private function initializeConfiguration()
	{
		$confInit = $this->getConfExtTpl();

		$this->endPointApi = isset($confInit['apimode']) ? $confInit['apimode'] : "http://api.calameo.com/1.0/";
		$this->endPointUpload = isset($confInit['upload']) ? $confInit['upload'] : "http://upload.calameo.com/1.0/";

		if (isset($confInit['apikey']))
			$this->apikey = $confInit['apikey'];


		if (isset($confInit['secret']))
			$this->secret = $confInit['secret'];

		if (isset($confInit['subscription']))
			$this->subscription = $confInit['subscription'];


		$this->publishmode  = 1;
		if (isset($confInit['publishmode']) && $confInit['publishmode'] == 1)
			$this->publishmode  = 2;
	}

	/**
	 * Initialize the service, especialy update the local documents list
	 */
	public function ecpublish()
	{
		$this->listePDF = $this->generateList();
	}

	/*
	 * Get the extension configuration
	 * @return array The configuration array
	 */
	public function getConfExtTpl(): array
	{
		$confExtTpl = $this->extensionConfiguration->get('e_calameo_publisher');

		return $confExtTpl;
	}

	/*
	 * Generate the API signature for the request
	 * @param array $parameters the parameters as array, is directly sent to the API
	 */
	function getSignature($parameters)
	{
		$signature = $this->secret;
		ksort($parameters);

		foreach ($parameters as $key => $value) {
			$signature .= $key . $value;
		}

		return md5($signature);
	}

	/*
	 * Send a request to the server
	 * @param $url the server url
	 * @param $post the post fields of the request
	 * @return mixed the request response
	 */
	function sendRequest($url, $post)
	{
		$ch = curl_init();

		// cURL configuration
		curl_setopt($ch, CURLOPT_URL, $url); // endpoint goes here
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT_MS, 360000);
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

		// cURL request execution
		$result = curl_exec($ch);

		$curl_errno = curl_errno($ch);
		$curl_error = curl_error($ch);
		curl_close($ch);

		if ($curl_errno > 0) {
			return $curl_error;
		} else {
			return $result;
		}
	}

	/*
	 * Send a PDF
	 * @param string $file Document to be uploaded, it is the contents, not the path
	 * @param string $name Title of the publication. If not present, the filename will be used.
	 * @param integer $download Download behaviour. Either 0 (disabled), 1 - DEPRECATED (only contacts) or 2 (everyone)
	 * @param integer $print Print behaviour. Either 0 (disabled), 1 - DEPRECATED (only contacts) or 2 (everyone).
	 * @throws CalameoServiceException If there was a problem with the request
	 * @return integer The PDF id
	 */
	public function publishPdf(string $file, string $name, int $download, int $print)
	{
		// Check configuration
		if (empty($this->apikey) || empty($this->secret) || empty($this->subscription)) {
			throw new CalameoServiceException('Calameo API is not configured. Please check extension settings.');
		}

		// Normalize UTF-8
		$name = mb_convert_encoding($name, 'UTF-8', 'UTF-8');

		// Build parameters
		$parameters = [
			'apikey' => $this->apikey,
			'action' => 'publish',
			'output' => 'XML',
			'expires' => time() + 3600,
			'category' => 'NEWS',
			'format' => 'ALBUMS',
			'subscription_id' => $this->subscription,
			'dialect' => 'fr',
			'name' => $name,
			'is_published' => 1,
			'publishing_mode' => $this->publishmode,
			'private_url' => 1,
			'view' => 'book',
			'subscribe' => 0,
			'comment' => 0,
			'download' => $download,
			'print' => $print,
			'annotation_view' => 0,
			'annotation_add' => 0,
			'mini' => 1,
		];

		// Generate signature
		$signature = $this->getSignature($parameters);



		// Add signature first
		$parameters['signature'] = $signature;



		// Add file (correct PHP 8 way)
		if (!file_exists($file)) {
			throw new \RuntimeException('File not found: ' . $file);
		}
		$parameters['file'] = new \CURLFile($file, 'application/pdf', basename($file));


		// Send upload request (multipart/form-data)
		$response = $this->sendRequest($this->endPointUpload, $parameters);

		// Check if response is an error string from cURL
		if (is_string($response) && !preg_match('/^<\?xml|^<response|^<error/i', $response)) {
			throw new CalameoServiceException('cURL error: ' . substr($response, 0, 200));
		}

		// Check if response is empty
		if (empty($response)) {
			throw new CalameoServiceException('Empty response from Calameo API');
		}

		// Parse XML
		$xml = $this->getResult($response);

		if ($xml === false) {
			$errorMsg = 'Failed to parse XML response';
			if (is_string($response)) {
				$errorMsg .= ': ' . substr($response, 0, 500);
			}
			throw new CalameoServiceException($errorMsg);
		}

		if (isset($xml->status) && (string)$xml->status == 'ok') {
			$this->nbPdf++;
			if (isset($xml->content->ID)) {
				return (string)$xml->content->ID;
			}
			throw new CalameoServiceException('Calameo API returned success but no ID');
		}
		
		// Extract error message
		$errorMsg = 'Unknown error from Calameo API';
		if (isset($xml->error->message)) {
			$errorMsg = (string)$xml->error->message;
		} elseif (isset($xml->status)) {
			$errorMsg = 'Status: ' . (string)$xml->status;
		}
		
		throw new CalameoServiceException($errorMsg);
	}


	/*
	 * Get some informations about a PDF document from calameo online service.
	 * @param integer $idFile The document identifier
	 * @throws CalameoServiceException If there was a problem with the request
	 */
	function getDocumentInformations($idFile)
	{
		$parameters = array();
		$parameters['apikey'] = $this->apikey;
		$parameters['action'] = "getBookInfos";
		$parameters['output'] = "XML";
		$parameters['expires'] = time() + 60;
		$parameters['book_id'] = $idFile;


		$signature = $this->getSignature($parameters);

		$parameters['signature'] = $signature;


		$reponse = $this->sendRequest($this->endPointApi, $parameters);

		$xml = $this->getResult($reponse);

		if ($xml->status == 'ok') {
			return $xml->content;
		} else {
			throw new CalameoServiceException($xml->error->message);
		}
	}

	/*
	 * Get a specific information about a PDF document
	 * @param integer $idFile The file identifier
	 * @param string $key The information key, you can choose between : Name,Description,Status,IsPublished,IsPrivate,AllowMini,Date,Pages,Width,Height,Views,Downloads,Comments,Favorites,Creation,Modification,PictureUrl,ThumbUrl,PublicUrl,ViewUrl
	 * @return mixed The information value
	 */
	function getInfo($idFile, $key)
	{
		return $this->listePDF[$idFile][$key];
	}

	/*
	 * Get all informations about a PDF document
	 * @param integer $idFile The file identifier
	 * @param string $key The information key, you can choose between : Name,Description,Status,IsPublished,IsPrivate,AllowMini,Date,Pages,Width,Height,Views,Downloads,Comments,Favorites,Creation,Modification,PictureUrl,ThumbUrl,PublicUrl,ViewUrl
	 * @return array The information values array
	 */
	function getInfos($idFile)
	{
		return $this->listePDF[$idFile];
	}

	/*
	 * L'api ne permet que récupéré les infos d'un certain nombre de pdf seulement à la fois. (50max)
	 * The calemeo API doesn't allow to get every datas, only a given PDF number per request (max : 50), This functions get these informations with the limitation
	 * @param integer $start The beginning index
	 * @param integer $step The maximum number of document informations you want to get
	 * @return array The list of the gotten documents
	 */
	function getListePart($start, $step)
	{
		$parameters = array();
		$parameters['apikey'] = $this->apikey;
		$parameters['action'] = "fetchSubscriptionBooks";
		$parameters['output'] = "XML";
		$parameters['expires'] = time() + 60;
		$parameters['subscription_id'] = $this->subscription;
		$parameters['order'] = "Name";
		$parameters['way'] = "UP";
		$parameters['start'] = $start;
		$parameters['step'] = $step;

		$signature = $this->getSignature($parameters);

		$parameters['signature'] = $signature;
		$rseponse = $this->sendRequest($this->endPointApi, $parameters);

		return $this->getResult($rseponse);
	}

	/*
	 * Generate the published pdf list
	 * @return array The list of document formated as $array[$id][$informationKey]
	 */
	function generateList()
	{
		$step = 50;
		$reponse = $this->getListePart(0, $step);
		$total = (int)$reponse->content->total;
		$this->nbPdf = $total;
		$documents = array();

		for ($i = 0; $i < $total; $i++) {
			if ($total > $step && $i % $step == 0) {
				$reponse = $this->getListePart($i, $step);
			}
			$ID = '' . $reponse->content->items->item[$i % $step]->ID . '';
			$documents[$ID]['ID'] = $ID;
			$documents[$ID]['Name'] = '' . $reponse->content->items->item[$i % $step]->Name . '';
			if (strpos($documents[$ID]['Name'], '?') !== FALSE) {
				iconv(mb_detect_encoding($documents[$ID]['Name'], mb_detect_order(), true), "UTF-8", $documents[$ID]['Name']);
			}
			$documents[$ID]['Description'] = '' . $reponse->content->items->item[$i % $step]->Description . '';
			$documents[$ID]['Status'] = '' . $reponse->content->items->item[$i % $step]->Status . '';
			$documents[$ID]['IsPublished'] = '' . $reponse->content->items->item[$i % $step]->IsPublished . '';
			$documents[$ID]['IsPrivate'] = '' . $reponse->content->items->item[$i % $step]->IsPrivate . '';
			$documents[$ID]['AllowMini'] = '' . $reponse->content->items->item[$i % $step]->AllowMini . '';
			$documents[$ID]['Date'] = '' . $reponse->content->items->item[$i % $step]->Date . '';
			$documents[$ID]['Pages'] = '' . $reponse->content->items->item[$i % $step]->Pages . '';
			$documents[$ID]['Width'] = '' . $reponse->content->items->item[$i % $step]->Width . '';
			$documents[$ID]['Height'] = '' . $reponse->content->items->item[$i % $step]->Height . '';
			$documents[$ID]['Views'] = '' . $reponse->content->items->item[$i % $step]->Views . '';
			$documents[$ID]['Downloads'] = '' . $reponse->content->items->item[$i % $step]->Downloads . '';
			$documents[$ID]['Comments'] = '' . $reponse->content->items->item[$i % $step]->Comments . '';
			$documents[$ID]['Favorites'] = '' . $reponse->content->items->item[$i % $step]->Favorites . '';
			$documents[$ID]['Creation'] = '' . $reponse->content->items->item[$i % $step]->Creation . '';
			$documents[$ID]['Modification'] = '' . $reponse->content->items->item[$i % $step]->Modification . '';
			$documents[$ID]['PictureUrl'] = '' . $reponse->content->items->item[$i % $step]->PictureUrl . '';
			$documents[$ID]['ThumbUrl'] = '' . $reponse->content->items->item[$i % $step]->ThumbUrl . '';
			$documents[$ID]['PublicUrl'] = '' . $reponse->content->items->item[$i % $step]->PublicUrl . '';
			$documents[$ID]['ViewUrl'] = '' . $reponse->content->items->item[$i % $step]->ViewUrl . '';
		}

		return $documents;
	}

	/*
	 * Refresh the published PDF list
	 */
	function refreshList()
	{
		$this->listePDF = $this->generateList();
	}

	/**
	 * Get the already published documents
	 * @return array PDF list, an array that contains $array[ids][informations_key]
	 */
	function getList()
	{
		return $this->listePDF;
	}

	/*
	 * En fonction d'un nom de fichier, voir si il a déja été publier. Renvoie l'id, -1 si pas trouvé.
	 * Check if a file has aldready been published
	 * @param string $fileName The file name
	 * @return integer The file id, -1 if not found
	 */
	function isPublished($fileName)
	{
		foreach ($this->listePDF as $ID => $pdf) {
			if ($this->filenameEqualsPdfEntry($pdf, $fileName . ".pdf") || $this->filenameEqualsPdfEntry($pdf, $fileName)) {
				return $ID;
			}
		}
		return -1;
	}

	/**
	 * Check if a filename equals a pdf file name, takes care of special characters, spaces ...
	 * @param array $pdf The pdf used for comparaison, contains a ['Name'] entry
	 * @param string $fileName the fileName
	 * @return boolean
	 */
	protected function filenameEqualsPdfEntry($pdf, $fileName)
	{
		if ($pdf['Name'] === $fileName) {
			//classic case
			return true;
		} else if ($pdf['Name'] === ($name_ascii = preg_replace('#(?:á|à|â|ä|ã|å|ç|é|è|ê|ë|í|ì|î|ï|ñ|ó|ò|ô|ö|õ|ú|ù|û|ü|ý|ÿ|Á|À|Â|Ä|Ã|Å|Ç|É|È|Ê|Ë|Í|Ï|Î|Ì|Ñ|Ó|Ò|Ô|Ö|Õ|Ú|Ù|Û|Ü|Ý)#', '?', $fileName))) {
			//sometimes, accents can cuase troubles
			return true;
		} else if ($pdf['Name'] === preg_replace('` {2,}`', ' ', trim(ucwords(preg_replace("/[\^~¨#!¡\?¿\.,;\*<>@\/\-\_()[\]{}\"'\+\|&]/", " ", $fileName))))) {
			//sometimes, too much spaces can cause troubles
			return true;
		} else if ($pdf['Name'] === preg_replace('` {2,}`', ' ', trim(ucwords(preg_replace("/[\^~¨#!¡\?¿\.,;\*<>@\/\-\_()[\]{}\"'\+\|&]/", " ", $name_ascii))))) {
			//and sometimes i is both
			return true;
		} else {
			return false;
		}
	}

	/*
	 * Convert calameo response from xml to array
	 * @param string $response The xml contents
	 * @return array The parsed datas
	 */
	function getResult($response)
	{
		return simplexml_load_string($response);
	}

	/*
	 * Remove a PDF
	 * @param integer $idFile The document identifier into the calameo service
	 * @return mixed the request response
	 */
	function removePdf($idFile)
	{
		$parameters = array();
		$parameters['apikey'] = $this->apikey;
		$parameters['action'] = "deleteBook";
		$parameters['output'] = "XML";
		$parameters['expires'] = time() + 60;
		$parameters['book_id'] = $idFile;


		$signature = $this->getSignature($parameters);
		$parameters['signature'] = $signature;

		return $this->sendRequest($this->endPointApi, $parameters);
	}
}
