<?php
namespace DslFactory\DslImmo\Utility;
/*use TYPO3\CMS\Core\Database\DatabaseConnection;*/
/**
 * Utility class for Geocode
 *
 * @package TYPO3
 * @subpackage tx_dslimmo
 */
class GeocodeUtility 
{
	public static $instance;
    public function __construct() {
        self::$instance = $this;
    }
	public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	
    /**
     * 
     * @return mixed
     */
	public function geocodeAddress($address)
	{
//echo "function geocodeAddress ";
		$apikey = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getGlobalSettingFor('mapsApiKey');
		if(!$apikey) {
			echo "FEHLER Api Key fehlt";die;
		}
		//echo $apikey;
		//die;
		$address = urlencode($address);
		// google map geocode api url
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=".$apikey;

		// get the json response
		//$resp_json = file_get_contents($url);
		//
		$resp_json = $this->getUrlContent($url);
//		echo $resp_json;
//print_r($resp_json);

		// decode the json
		$resp = json_decode($resp_json, true);

		// response status will be 'OK', if able to geocode given address 
		if($resp['status']=='OK'){

			// get the important data
			$lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
			$longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
			$formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";

			// verify if data is complete
			if($lati && $longi && $formatted_address){

				// put the data in the array
				$data_arr = array(
					"breitengrad"=>$lati,
					"laengengrad"=>$longi,
					"formatted_address"=>$formatted_address
				);            

				

				return($data_arr);

			} else{
				//echo $url;
				//print_r($resp_json);
				//die;
				return false;
			}

		} else{
			return false;
			//echo "<strong>ERROR: {$resp['status']}</strong>";
			//return false;
		}
		//return 'geocodeAddress:'.$address;

		
		
	}
	
	/**
     * @param $url
     */
    private function getUrlContent($url)
    {
		
		
		/*
		Host: services.mobile.de
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:58.0) Gecko/20100101 Firefox/58.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*//*;q=0.8
Accept-Language: de,en-US;q=0.7,en;q=0.3
Accept-Encoding: gzip, deflate, br
Connection: keep-alive
Upgrade-Insecure-Requests: 1
Pragma: no-cache
Cache-Control: no-cache
		
		
		*/
		
		$header = array(
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
			"Accept-Language: de,en-US;q=0.7,en;q=0.3",
			"Connection: keep-alive",
			"Upgrade-Insecure-Requests: 1",
			"Pragma: no-cache",
			"Cache-Control: no-cache",
		);
  	
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:58.0) Gecko/20100101 Firefox/58.0');
curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode >= 200 && $httpcode < 300 ? $data : false;
    }
	
   
}