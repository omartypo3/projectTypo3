<?php

/**
 * For API Documentation see https://docs.newsletter2go.com
 */

namespace DslFactory\DslIntranet\Utility;


class Newsletter2Go_REST_Api_Dsl extends \DslFactory\DslIntranet\Utility\Newsletter2Go_REST_Api
{

    private $lid = "";
	
	
		
    
    /**
     * get all lists
     * https://docs.newsletter2go.com/#!/List/getAboUsers
     * @return stdClass
     */
    public function getAboUsers()
    {
		
		if(!$this->lid){
			$lists = $this->getLists();
			$this->lid = $lists->value[0]->id;
		}
		
        $endpoint = "/lists/".$this->getLid()."/recipients";
		
		

        $data = array(
            "_expand" => true,
			"_limit"=>9999
        );

        return $this->curl($endpoint, $data);
    }	
	

	public function getLid()
    {
		
		if(!$this->lid){
			$lists = $this->getLists();
			$this->lid = $lists->value[0]->id;
		}
		return $this->lid;
    }
	
	/**
     * get all lists
     * https://docs.newsletter2go.com/#!/List/getAboUsers
     * @return stdClass
     */
    public function setRecipient($email)
    {
		$endpoint = "/recipients";
		$response = $this->curl($endpoint, array("email" => $email), "POST");
		//print_r($response);
		return $response;
	}
	
		/**
     * get all lists
     * https://docs.newsletter2go.com/#!/List/getAboUsers
     * @return stdClass
     */
    public function getRecipient($email)
    {
		//echo "!!ion getRecipient()!!";
		$users = $this->getAboUsers();
		//print_r($users->value[1]);
		foreach($users->value as $user) {
		//	echo "each:";
			if($user->email==$email) {
			//	echo "gefunden!!!!";
				return $user;
			}
		}
		
		return false;
	}
	
	
    public function removeRecipient($email)
    {
		//echo "!!ion removeRecipient()!!";
		if($user = $this->getRecipient($email)){
			$endpoint = "/lists/".$this->getLid()."/recipients/".$user->id;
			$response = $this->curl($endpoint, array(), "DELETE");
			
		//		curl($endpoint, $data, $type = "GET")
			return true;
		} 
		
		return false;
		
		//$users = $this->getAboUsers();
		//foreach($users->value as $user) if($user->email==$email) return $user;
	}
	public function unsubscribeRecipient($email)
    {
		//echo "!unsubscribeRecipient(".$email.")!";
		if($user = $this->getRecipient($email)){
		//	echo "!if!";
		//	print_r($user);
			$endpoint = "/lists/".$this->getLid()."/recipients/".$user->id;
			$response = $this->curl($endpoint, array("is_unsubscribed"=>true), "PATCH");
			
		//		curl($endpoint, $data, $type = "GET")
			return true;
		} else {
		//	echo "nicht gefunden !!!!!";
		}
	}
	
	public function subscribeRecipient($email)
    {
	//	echo ":ion subscribeRecipient:";
	//	echo ":".$email.":";
		if($user = $this->getRecipient($email)){
			//echo ":if:";
			$endpoint = "/lists/".$this->getLid()."/recipients/".$user->id;
			$response = $this->curl($endpoint, array("is_unsubscribed"=>false), "PATCH");
			
		//		curl($endpoint, $data, $type = "GET")
			return true;
		} else {
	//		echo ":else setRecipient(".$email."):";
			$this->setRecipient($email);
		}
	}
	
	public function isSubscribedRecipient($email)
    {
		if($user = $this->getRecipient($email)){
			//$endpoint = "/lists/".$this->getLid()."/recipients/".$user->id;
			if(!$user->is_unsubscribed) return true;
			//$response = $this->curl($endpoint, array("is_unsubscribed"=>false), "PATCH");
				
		//		curl($endpoint, $data, $type = "GET")
			//return true;
		} 
		return false;
	}
    
}
