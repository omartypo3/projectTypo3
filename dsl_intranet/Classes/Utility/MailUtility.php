<?php

namespace DslFactory\DslIntranet\Utility;

use Symfony\Component\Mime\Address;
/**
 * Utility class for Mail
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class MailUtility 
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
     * @param string $subject
     * @param string $body	 
     * @param string $toMail	 
     * @param string $toName	 	 	 
     * @param array $attachments	 	 	 	 
     * @param string $fromMail	 
     * @param string $fromName	 	 	 
     * @param string $toMailCC
     * @param string $toNameCC	 	 	 
     * @return boolean
     */
	public function sendMail($subject,$body,$toMail = false,$toName = false,$bodyHtml = false, $attachments = array(),$fromMail = false,$fromName = false,$toMailCC = false,$toNameCC = false,$replyName = false,$replyMail = false, $priority = false,$archivMail = false,$archivName = false)
	{
		
		
		$subject=html_entity_decode($subject);
		
		//$toMail='kuhschnappel@gmail.com';
		//$toName='Mike Zimmer';
		
		
		$configurationManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
		$settings = $extbaseFrameworkConfiguration['plugin.']['tx_dslintranet.']['settings.'];


		
			
			
		
		if(!$toMail) $toMail = $settings['absenderEmail'];
	//	unset($settings['mailUtilityDebugEmpfaenger']);
		
		$ccArr = array();
		
		if($settings['mailUtilityDebugEmpfaenger']) {
			
	//		$body="*** Eigentlicher Empfänger: ".$toMail." ***\n\n".$body;
	//		$bodyHtml="*** Eigentlicher Empfänger: ".$toMail." ***<br><br>".$bodyHtml;
			
			$subject.=" *** DEBUG1 / ".$toMail;
			$toMail = $settings['mailUtilityDebugEmpfaenger'];
			
			
			if($toMailCC) $toMailCC = $settings['mailUtilityDebugEmpfaenger'];
			
		} else {
			
			$archivMailSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('archivMail');
			if($archivMailSettings["active"]){
				
				if(!$archivMail) $archivMail = $archivMailSettings["email"];
				if(!$archivName) $archivName = $archivMailSettings["name"];
			
			}
			if($archivMail && $archivName) $ccArr[$archivMail] = $archivName;
			
		}
	//echo $toMail;

	//die;
		
		if(!$fromName) $fromName = $settings['absenderName'];
		if(!$fromMail) $fromMail = $settings['absenderEmail'];
		
		if(!$toName) $toName = $settings['absenderName'];
		
		$message = new \TYPO3\CMS\Core\Mail\MailMessage();
		$message->from(new Address($fromMail,$fromName));
		$message->to(new Address($toMail,$toName));//$this->request->getArgument('empfaenger')
		if($toMailCC){
			if(!$toNameCC) $toNameCC = $toMailCC;
			$ccArr[$toMailCC] = $toNameCC;
			//$message->setCC(array($toMailCC => $toNameCC));//$this->request->getArgument('empfaenger')
			
		} else {
			
		}
		if(count($ccArr)){
			$message->setCC($ccArr);
			
		}
		if($replyMail){
			if(!$replyName) $replyName = $replyMail;
			
			$message->setReplyTo(array($replyMail => $replyName));//$this->request->getArgument('empfaenger')
			
		}
		
		$message->subject($subject);
		$message->html($body);
		//if($bodyHtml) $message->addPart($body.'<br>und hier <strong>noch etwas</strong> html <q>Here is the message itself</q>'.$bodyHtml, 'text/html');
		if($bodyHtml) $message->html($bodyHtml);
		
		
		//$message->attach(Swift_Attachment::fromPath('test.pdf'));
		
		// Possible attachments here
		if (count($attachments)) {
			foreach ($attachments as $file => $name) {
				if (file_exists($file)) {
					if (trim($name)) {
						$message->attachFromPath(\Swift_Attachment::fromPath($file)->setFilename($name));
					} else {
						$message->attachFromPath(Swift_Attachment::fromPath($file));
					}
				}
			}
		}
		
		if($priority){
			
			$priorityLabel = array(1 => "High", 2 => "High", 3 => "Normal", 4 => "Low", 5 => "Low"); 
			$message->getHeaders()->addTextHeader('X-Priority', $priority);
			$message->getHeaders()->addTextHeader('X-MSMail-Priority', $priorityLabel[$priority]);
		}
		
		$message->send();
		if (!$message->isSent()) {
			return false;
			//echo "FEHLER!! MAIL NICHT VERSENDET";
			
			//die;
		}
		return true;
		
	}
	


}