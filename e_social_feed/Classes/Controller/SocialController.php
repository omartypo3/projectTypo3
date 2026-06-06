<?php
namespace Emagineurs\ESocialFeed\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 xley <xley@e-magineurs.com>
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
 
 use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
 
/**
 *
 *
 * @package e_social_feed
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class SocialController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	
	/**
	 * initialize create action
	 * allow creation of submodel company
	 */
	public  function initializeAction () {
        $this->useTsIfFlexIsEmpty();
	}
    
    public function useTsIfFlexIsEmpty(){
        /*$confTsComplete = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

		$confTSWithDots = $confTsComplete['plugin.']['tx_esocialfeed.']['settings.'];
        
        $confTS = self::removeDotsInConf($confTSWithDots);

        foreach($confTS as $conf => $value){
            if(!array_key_exists($conf,$this->settings) || empty($this->settings[$conf])){
                if(!empty($value)){
					$this->settings[$conf] = $value;
                }
            }
        }*/
    }

    public static function removeDotsInConf($array){
        foreach($array as $key => $setting){
            if(strpos($key,'.') !== false){
                $newKey = substr($key,0,-1);    
                $array[$newKey] = self::removeDotsInConf($setting);
                unset($array[$key]);
            }
        }
        
        return $array;
    }
    
	/**
	 * action handleFacebook
	 *
	 * @return void
	 */
	public function handleFacebookAction() {
        // $feed = file_get_contents('https://graph.facebook.com/Versailles.officiel/posts?access_token=1687142881602622|ff2e08e87a962d5b8431b1e86ffbb219&fields=message,link,full_picture,created_time,caption,name&count='.$this->settings['nbElement']);
        
        $fields = 'id,admin_creator,application,call_to_action,caption,created_time,description,feed_targeting,from,icon,full_picture,instagram_eligibility,is_hidden,is_instagram_eligible,is_published,link,message,message_tags,name,object_id,parent_id,permalink_url,picture,place,privacy,properties,shares,source,status_type,story,story_tags,targeting,to,type,updated_time,with_tags';
        
        $feed = file_get_contents('https://graph.facebook.com/'.$this->settings['fbVariable'].'/posts?access_token=1687142881602622|ff2e08e87a962d5b8431b1e86ffbb219&fields='.$fields.'&count='.$this->settings['nbElement']);
                
        $allContent = json_decode($feed);
        
        $lastContent = $allContent->data[0];
        $message = $lastContent->message;
        
        $this->view->assign('contentFromFb', $lastContent);        
	}
    
	/**
	 * action handleTwitter
	 *
	 * @return void
	 */
	public function handleTwitterAction() {
		$path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('e_social_feed');
		require_once $path . 'Resources/Private/Php/twitteroauth/autoload.php';
		
        $token = '785767569172992000-VrYLp7cOiChkPxNbZ1BiEyvsRA9nm1a';
        $token_secret = 'Ps2YlQ36hCL0HJTpP57nRrb9VqT3Dhzl2aNOBdee8oQil';
        $consumer_key = 'f2rOJcF1rD7ecwYM3AmN1S6Xq';
        $consumer_secret = '8AqlES4bfmoio3HYX5EUb46mfa3y41NRJPRQZFST7xvUYkYjFB';
        
        $connection = new \Abraham\TwitterOAuth\TwitterOAuth($consumer_key, $consumer_secret, $token, $token_secret );

        $connection->host = "https://api.twitter.com/1.1/"; // change the default
        $connection->ssl_verifypeer = TRUE;
        $connection->content_type = 'application/x-www-form-urlencoded';

		$query = array(
			"screen_name" => $this->settings['twVariable'],
			"tweet_mode" => 'extended',
			"count" => $this->settings['nbElement']
		);
		
		$results = $connection->get('statuses/user_timeline', $query);
		$this->view->assign('contentFromTw',$results);
	}
    
	/**
	 * action handleInstagram
	 *
	 * @return void
	 */
	public function handleInstagramAction() {

        $client_id = '580c8e690fd04fc8b0a148c2e18a262a';
        $client_secret = 'fee2f208444d47bda27278eef94a6ed6';
        $redirect_uri = 'http://localhost/labo76/index.php';
        $scope = 'basic+likes+comments+relationships+public_content';

        // $hashtag = 'villedeversailles';
        $id = $this->settings['insVariable'];
         
		// On instancie un sys_registry
		$registry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Registry');
        $dateReqInstagram = $registry->get('tx_esocialfeed','dateReqInstagram');
			
		// DebuggerUtility::var_dump($id, 'TEST $id');
			
        if(intval($dateReqInstagram) + 60 < time()){
            //Query need client_id or access_token
            $query = array(
                'client_id' => $client_id,
                'access_token' => '4131434951.580c8e6.34fdee2ae77742be93b6d80b66c4d25b',
                'count'		=> $this->settings['nbElement']
            );
            // $url = 'https://api.instagram.com/v1/tags/'.$hashtag.'/media/recent?'.http_build_query($query);
            $url = 'https://api.instagram.com/v1/users/'.$id.'/media/recent?'.http_build_query($query);
            try {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                
                //Data are stored in $data
                $data = json_decode(curl_exec($curl_connection), true);
                curl_close($curl_connection);
            } catch(Exception $e) {
                return $e->getMessage();
            }
			
			// DebuggerUtility::var_dump($data, 'TEST $data');
			// DebuggerUtility::var_dump($data, 'TEST $data');
            
            $this->view->assign('contentFromIns',reset($data['data']));
            
            $registry->set('tx_esocialfeed','dateReqInstagram',time());
            $registry->set('tx_esocialfeed','jsonReqInstagram',$data['data']);
        } else {
            $cachedData = $registry->get('tx_esocialfeed','jsonReqInstagram');
            $this->view->assign('contentFromIns',reset($cachedData));
        }
	}

    /**
     * action handleVimeo
     *
     * @return void
     */
    public function handleVimeoAction() {
        $path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('e_social_feed');
        require_once $path . 'Resources/Private/Php/vimeophp/autoload.php';
        
        //Récuperation des données importantes pour les échanges avec API
        //On cherche les données dans le flexform autrement on prend ceux des gabarits
        if(!empty($this->settings['vmId'])){
            $client_id = $this->settings['vmId'];
        }
        else{
            $client_id = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_esocialfeed.']['identifiant.']["vimeoclientid"];
        }

        if(!empty($this->settings['vmSecret'])){
            $client_secret = $this->settings['vmSecret'];
        }
        else{
            $client_secret = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_esocialfeed.']['identifiant.']["vimeoclientsecret"];
        }

        if(!empty($this->settings['vmUser'])){
            $client_name = $this->settings['vmUser'];
        }
        else{
            $client_name = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_esocialfeed.']['identifiant.']["vimeoclientuser"];
        }

        //Contient les variables fixes pour Vimeo
        $vimeo_authorize = 'https://api.vimeo.com/oauth/authorize';
        $vimeo_token = 'https://api.vimeo.com/oauth/access_token';
        $scope = "public";

        $libVimeo = new \Vimeo\Vimeo($client_id, $client_secret);
        $token = $libVimeo->clientCredentials($scope);
        $libVimeo->setToken($token['body']['access_token']);

        $Vimeolist = array();
        $totalAfficher = intval($this->settings['nbElement']);

        //Pour cherche une vidéo précise, on a pas besoin de s'identifier pour trouver une vidéo précise. ça marche même si l'autentification n'est pas reussi
        if(!empty($this->settings['vmLink'])){
            $theVideo = $libVimeo->request("/videos/".$this->settings['vmLink']);
            if( $theVideo["status"] = 200){
                $arrayVideo =  array();
                $arrayVideo["vimeolink"] = $this->settings['vmLink'];
                $arrayVideo["vimeorelease"] = $theVideo['body']['release_time'];
                $arrayVideo["vimeouser"] = $theVideo['body']['user']['name'];
                $arrayVideo["vimeoname"] = $theVideo['body']['name'];
                $arrayVideo["vimeodescription"] = $theVideo['body']['description'];
                $arrayVideo["vimeoembed"] = $theVideo['body']["embed"]["html"];
                array_push($Vimeolist, $arrayVideo);
                $totalAfficher = $totalAfficher - 1;
            }
            
        }
        if(!empty($client_id) && !empty($client_secret) && !empty($client_name)){
            if($totalAfficher > 0){
                $videos = $libVimeo->request("/users/".$client_name."/videos", ['per_page' => $totalAfficher]);
                if( $videos["status"] = 200){
                    foreach($videos['body']['data'] as $video) {
                        $uidLink = str_replace("https://vimeo.com/","", $video['link']);
                        if($uidLink != $this->settings['videoLink']){
                            $arrayVideo =  array();
                            $arrayVideo["vimeolink"] = $uidLink;
                            $arrayVideo["vimeorelease"] = $video['release_time'];
                            $arrayVideo["vimeouser"] = $video['user']['name'];
                            $arrayVideo["vimeoname"] = $video['name'];
                            $arrayVideo["vimeodescription"] = $video['description'];
                            $arrayVideo["vimeoembed"] = $video["embed"]["html"];
                            array_push($Vimeolist, $arrayVideo);
                        }
                       
                    }
                }
            }
        }
        if(count($Vimeolist) < 1){
            $messageAlert = 1;
            $this->view->assign('messageAlert',$messageAlert);
        }
        $this->view->assign('Vimeolist',$Vimeolist);
        
    }
}
?>