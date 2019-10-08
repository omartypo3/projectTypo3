<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 24.08.2017
 * Time: 09:06
 */

namespace Pingag\PingagThurcom\Controller;


use Pingag\PingagThurcom\Domain\Model\InternetPackage;
use Pingag\PingagThurcom\Domain\Model\Product;
use Pingag\PingagThurcom\Domain\Model\ServiceLocation;
use Pingag\PingagThurcom\Domain\Model\SubscriptionOrder;
use Pingag\PingagThurcom\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;

class SubscriptionController extends BaseController
{



    /**
     * @return string
     */
    public function orderAction()
    {
        $order = new SubscriptionOrder();
        $this->view->assign('order', $order);

        $internetPackages = $this->internetPackageRepo->findAll();
        $this->view->assign('packages', $internetPackages);

        $options = $this->subscriptionOptionRepo->findAll();
        $this->view->assign('options', $options);
		
		//$additionalProducts = $this->productRepo->findAll();
		$additionalProducts = $this->productRepo->findByCategory('15');
        $this->view->assign('products', $additionalProducts);

        $countPackages = count($internetPackages) - 1;
		$this->view->assign('packageWidth', 100 / $countPackages);

        return $this->view->render();
    }

    /**
     * action create
     *
     * @param \Pingag\PingagThurcom\Domain\Model\SubscriptionOrder $order
     * @return void
     */
    public function createAction(\Pingag\PingagThurcom\Domain\Model\SubscriptionOrder $order)
    {


        // DebugUtility::debug($this->request->getMethod() );
        //var_dump($order); die;
        if ($this->request->getMethod() === 'POST') {
            //$this->bindOrderForm($order);

            // validation ?
            $order->setPid($this->settings['storagePid']);
            $this->saveOrder($order);
            //DebugUtility::debug($order);
            $this->sendConfirmationMail($order);
        }
//die();
        $this->view->render();
    }
    /**
     * create SubscriptionOrder from form-data
     *
     * @param SubscriptionOrder $order
     */
    protected function bindOrderForm(SubscriptionOrder $order)
    {
        $specialProperties = ['internetPackage', 'options', 'additionalProducts'];
        /* Set values for simple text fields */
        foreach($_POST as $property=>$value){
            if(in_array($property, $specialProperties)){
                continue;
            }
            $setterMethod = 'set'.ucfirst($property);
            if(method_exists($order, $setterMethod) && property_exists(SubscriptionOrder::class, $property)){
                $order->$setterMethod($value);
            }
        }
		//if($_POST['internetPackage'] != '0') {
        $internetPackage = $this->internetPackageRepo->findByUid($_POST['internetPackage']);
        $order->setInternetPackage($internetPackage);
		//}

        $options = $this->subscriptionOptionRepo->findByUids($_POST['options']);
        $order->setOptions($options);
		
		$additionalProducts = $this->productRepo->findByUids($_POST['additionalProducts']);
        $order->setAdditionalProducts($additionalProducts);

        $order->setPid($this->settings['storagePid']);
    }

    /**
     * persist/save SubscriptionOrder
     *
     * @param SubscriptionOrder $order
     * @throws \Exception
     */
    protected function saveOrder(SubscriptionOrder $order)
    {
        try{
            //$this->setTypeConverterConfigurationForImageUpload("order");
            $this->subscriptionOrderRepo->add($order);
            $this->persistenceManager->persistAll();
            $this->persistOrderRelations($order);
        } catch (\Exception $e){
            throw $e;
            var_dump($e->getMessage()); die;
        }
    }

    protected function persistOrderRelations(SubscriptionOrder $order)
    {
		//if($_POST['internetPackage'] != '0') {
			$uidLocal = $order->getUid();
			$this->createRealtionEntry(
				$uidLocal,
				$order->getInternetPackage()->getUid(),
				'tx_pingagthurcom_domain_model_internet_package_mm'
			);
		//}
    }

    protected function createRealtionEntry($uidLocal, $uidForeign, $table){
        $db = $GLOBALS['TYPO3_DB'];
        $query = $db->INSERTquery($table, [
            'uid_local' => $uidLocal,
            'uid_foreign' => $uidForeign,
            'sorting' => time()
        ]);
        $result = $db->sql_query($query);
    }
	


    /**
     * https://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/Mail/Index.html#how-to-create-and-send-mails
     * @param SubscriptionOrder $order
     */
    protected function sendConfirmationMail(SubscriptionOrder $order){
        $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
		$mail2 = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');


	    $orderDate = date('Y-m-d H:i:s');
		$orderDate2 = date('Y-m-d, H:i');
		$orderIp = $_SERVER['REMOTE_ADDR'];
		
        $customerEmail = $order->getEmail();
        $customerFullname = $order->getFullname();
		$customerFullname = str_replace("ä", "&auml;", $customerFullname);
        $customerFullname = str_replace("ü", "&uuml;", $customerFullname);
        $customerFullname = str_replace("ö", "&ouml;", $customerFullname);
        $customerFullname = str_replace("Ä", "&Auml;", $customerFullname);
        $customerFullname = str_replace("Ü", "&Uuml;", $customerFullname);
        $customerFullname = str_replace("Ö", "&Ouml;", $customerFullname);
		$customerFullname = str_replace("É", "&Eacute;", $customerFullname);
		$customerFullname = str_replace("é", "&eacute;", $customerFullname);
		$customerFullname = str_replace("È", "&Egrave;", $customerFullname);
		$customerFullname = str_replace("è", "&egrave;", $customerFullname);
        $customerFullname = str_replace("ß", "ss", $customerFullname);
		
		$customerLastname = $order->getFirstname();
		$customerLastname = str_replace("ä", "&auml;", $customerLastname);
        $customerLastname = str_replace("ü", "&uuml;", $customerLastname);
        $customerLastname = str_replace("ö", "&ouml;", $customerLastname);
        $customerLastname = str_replace("Ä", "&Auml;", $customerLastname);
        $customerLastname = str_replace("Ü", "&Uuml;", $customerLastname);
        $customerLastname = str_replace("Ö", "&Ouml;", $customerLastname);
		$customerLastname = str_replace("É", "&Eacute;", $customerLastname);
		$customerLastname = str_replace("é", "&eacute;", $customerLastname);
		$customerLastname = str_replace("È", "&Egrave;", $customerLastname);
		$customerLastname = str_replace("è", "&egrave;", $customerLastname);
        $customerLastname = str_replace("ß", "ss", $customerLastname);
		
		$customerFirmName = $order->getFirmName();
		$customerFirmName = str_replace("ä", "&auml;", $customerFirmName);
        $customerFirmName = str_replace("ü", "&uuml;", $customerFirmName);
        $customerFirmName = str_replace("ö", "&ouml;", $customerFirmName);
        $customerFirmName = str_replace("Ä", "&Auml;", $customerFirmName);
        $customerFirmName = str_replace("Ü", "&Uuml;", $customerFirmName);
        $customerFirmName = str_replace("Ö", "&Ouml;", $customerFirmName);
		$customerFirmName = str_replace("É", "&Eacute;", $customerFirmName);
		$customerFirmName = str_replace("é", "&eacute;", $customerFirmName);
		$customerFirmName = str_replace("È", "&Egrave;", $customerFirmName);
		$customerFirmName = str_replace("è", "&egrave;", $customerFirmName);
        $customerFirmName = str_replace("ß", "ss", $customerFirmName);
		
		$customerStreet = $order->getAddress();
		$customerStreet = str_replace("ä", "&auml;", $customerStreet);
        $customerStreet = str_replace("ü", "&uuml;", $customerStreet);
        $customerStreet = str_replace("ö", "&ouml;", $customerStreet);
        $customerStreet = str_replace("Ä", "&Auml;", $customerStreet);
        $customerStreet = str_replace("Ü", "&Uuml;", $customerStreet);
        $customerStreet = str_replace("Ö", "&Ouml;", $customerStreet);
		$customerStreet = str_replace("É", "&Eacute;", $customerStreet);
		$customerStreet = str_replace("é", "&eacute;", $customerStreet);
		$customerStreet = str_replace("È", "&Egrave;", $customerStreet);
		$customerStreet = str_replace("è", "&egrave;", $customerStreet);
        $customerStreet = str_replace("ß", "ss", $customerStreet);
		
		$customerSalutation = $order->getSalutation();
		$customerCity = $order->getCity();
		$customerCity = str_replace("ä", "&auml;", $customerCity);
        $customerCity = str_replace("ü", "&uuml;", $customerCity);
        $customerCity = str_replace("ö", "&ouml;", $customerCity);
        $customerCity = str_replace("Ä", "&Auml;", $customerCity);
        $customerCity = str_replace("Ü", "&Uuml;", $customerCity);
        $customerCity = str_replace("Ö", "&Ouml;", $customerCity);
		$customerCity = str_replace("É", "&Eacute;", $customerCity);
		$customerCity = str_replace("é", "&eacute;", $customerCity);
		$customerCity = str_replace("È", "&Egrave;", $customerCity);
		$customerCity = str_replace("è", "&egrave;", $customerCity);
        $customerCity = str_replace("ß", "ss", $customerCity);
		
		$customerTelephonePrivate = $order->getTelephonePrivate();
		$customerTelephoneOffice = $order->getTelephoneOffice();
		$customerMobile = $order->getTelephoneMobile();
		$customerBirthday = $order->getBirthday();
		$customerComment = $order->getComment();
		$customerComment = str_replace("ä", "&auml;", $customerComment);
        $customerComment = str_replace("ü", "&uuml;", $customerComment);
        $customerComment = str_replace("ö", "&ouml;", $customerComment);
        $customerComment = str_replace("Ä", "&Auml;", $customerComment);
        $customerComment = str_replace("Ü", "&Uuml;", $customerComment);
        $customerComment = str_replace("Ö", "&Ouml;", $customerComment);
		$customerComment = str_replace("É", "&Eacute;", $customerComment);
		$customerComment = str_replace("é", "&eacute;", $customerComment);
		$customerComment = str_replace("È", "&Egrave;", $customerComment);
		$customerComment = str_replace("è", "&egrave;", $customerComment);
        $customerComment = str_replace("ß", "ss", $customerComment);
		
		
		$customerInternetPackage= $order->getInternetPackage()->getTitle();
		if($customerInternetPackage != 'none') {
				$customerInternetPackage = '<li>'.$customerInternetPackage.'</li>';
		} else {
			$customerInternetPackage= '';
		}
		
		if($customerSalutation == 'Herr') {
			$customerDear = 'Sehr geehrter';
		} else {
			$customerDear = 'Sehr geehrte';
		}
		
		
		if($customerFirmName == '') {
			$customerFirma = '';
		} else {
			$customerFirma = $customerFirmName.'<br>';
		}
		
		if($customerTelephoneOffice == '') {
			$customerTelGeschaeft = '';
		} else {
			$customerTelGeschaeft = '<br>Telefon Gesch&auml;ft: '.$customerTelephoneOffice;
		}
		
		if($customerMobile == '') {
			$customerHandy = '';
		} else {
			$customerHandy = '<br>Mobile: '.$customerMobile;
		}
		
		if($customerComment == '') {
			$customerMessage = '';
		} else {
			$customerMessage = '<br>Bemerkung: '.$customerComment;
		}
			
		foreach($order->getOptions() as $Option) {
			$Optionen .= '<li>'.$Option->getTitle().'</li>';
		}

		$customerZubehoer = $order->getZubehoer();
		$customerExtras = $order->getZusatzoption();
		$customerNumber = $order->getRufnummer();
		
		
		if($Optionen == '') {
			$customerOptionen = '';
		} else {
			$customerOptionen = $Optionen;
		}
		if($customerZubehoer == '') {
			$customerProdukte = '';
		} else {
			$customerProdukte = '<li>'.$customerZubehoer.'</li>';
		}
		if($customerExtras == '') {
			$customerZusatz = '';
		} else {
			$customerZusatz = '<li>'.$customerExtras.'</li>';
		}
		if($customerNumber == '') {
			$customerNummer = '';
		} else {
			$customerNummer = '<li>'.$customerNumber.'</li>';
		}
		
		$customerCostsOnce = $order->getCostsOnce();
		$customerCostsMonth = $order->getCostsMonth();
		
		

        // Setup.txt pingagthurcom_subscription.settings
		// Mail für Thurcom
        $mail
            // Give the message a subject
            ->setSubject('Einfach kombiniert - Bestellung')
            // Set the From address with an associative array
            ->setFrom(array('order@thurcom.ch'))
			//->setFrom(array('test@thurcom.ch'))
            // Set the To addresses with an associative array
            ->setTo(array('info@thurcom.ch'))
			//->setTo(array('saskia.egli@pingag.ch'))
            // Give it a body
            ->setBody('')
            // And optionally an alternative body
			
            ->addPart(
			'Datum: '.$orderDate.'<br><br>'.
			'<b>Eine Bestellung wurde ausgef&uuml;hrt:</b><br><br>'.
			'<b>Adresse:</b><br/><br>'.
			$customerFirma.
			$customerSalutation.' '.$customerFullname.
			'<br>'.$customerStreet.
			'<br>'.$customerCity.
			'<br>Geburtsdatum: '.$customerBirthday.
			'<br>Telefon Privat: '.$customerTelephonePrivate.
			$customerTelGeschaeft.
			$customerHandy.
			'<br>E-Mail-Adresse: <a href="mailto:'.$customerEmail.'">'.$customerEmail.'</a>'.
			$customerMessage.
			'<br><br><br>'.
			'<b>IP-Adresse:</b> '.$orderIp.
			'<br><b>Bestelldatum:</b> '.$orderDate2.
			'<br><br><br>'.
			'<b>Produkte</b><br>'.
			'<ul>'.
			$customerInternetPackage.
			$customerOptionen.
			$customerProdukte.
			$customerZusatz.
			$customerNummer.
			'</ul><br><br>'.
			'<b>Abo-Preis monatlich:</b> CHF '.$customerCostsMonth.
			'<br><b>Preis einmalig:</b> CHF '.$customerCostsOnce, 'text/html')
            // Optionally add any attachments
            //->attach(Swift_Attachment::fromPath('my-document.pdf'))
            // And finally do send it
            ->send()
        ;
		
		// Setup.txt pingagthurcom_subscription.settings
		// Mail für Kunden
        $mail2
            // Give the message a subject
            ->setSubject('Ihre Bestellung bei Thurcom')
            // Set the From address with an associative array
            ->setFrom(array( 'order@thurcom.com'))
            // Set the To addresses with an associative array
            ->setTo(array($customerEmail))
            // Give it a body
            ->setBody('')
            // And optionally an alternative body
			
            ->addPart(
			$customerDear.' '.$customerSalutation.' '.$customerLastname.
			'<br><br>'.
			'<b>Vielen Dank f&uuml;r Ihre Bestellung! Wir werden Ihren Auftrag umgehend bearbeiten.</b><br><br>'.
			'<b>Details Ihrer Abo-Bestellung:</b>'.
			'<ul>'.
			$customerInternetPackage.
			$customerOptionen.
			$customerProdukte.
			$customerZusatz.
			$customerNummer.
			'</ul><br><b>Ihre Kontaktangaben:</b><br><br>'.
			$customerFirma.
			$customerSalutation.' '.$customerFullname.
			'<br>'.$customerStreet.
			'<br>'.$customerCity.
			'<br>Geburtsdatum: '.$customerBirthday.
			'<br>Telefon Privat: '.$customerTelephonePrivate.
			$customerTelGeschaeft.
			$customerHandy.
			'<br>E-Mail-Adresse: '.$customerEmail.
			$customerMessage.
			'<br><br><b>Preis monatlich:</b> CHF '.$customerCostsMonth.
			'<br><b>Preis einmalig:</b> CHF '.$customerCostsOnce.
			'<br><br>'.
			' Bitte &uuml;berpr&uuml;fen Sie noch einmal alle Angaben sorgf&auml;ltig. Falls Sie Fragen dazu haben, sind wir gerne f&uuml;r Sie da: Telefon 071 565 65 65 oder Mail info@thurcom.ch.'.
			'<br><br>Ihre Thurcom.', 'text/html')
            // Optionally add any attachments
            //->attach(Swift_Attachment::fromPath('my-document.pdf'))
            // And finally do send it
            ->send()
        ;
    }

    protected function DUMMYsampleFunctions(SubscriptionOrder $order)
    {
        $this->subscriptionOptionRepo->add($order);

        $products = $this->productRepo->findAll();
        $this->view->assign('products', $products);


        $this->getFlexformSetting('mapCenter');
        // persist SubscriptionOrder

        // send confirmation mails
    }
	
	public function listPackagesAction()
    {

        $internetPackages = $this->internetPackageRepo->findAll();
        $this->view->assign('packages', $internetPackages);
		
		$countPackages = count($internetPackages) - 1;
		$this->view->assign('packageWidth', 100 / $countPackages);

        return $this->view->render();
    }
    /**
     *
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName)
    {
        $uploadConfiguration = [
            UploadedFileReferenceConverter::CONFIGURATION_ALLOWED_FILE_EXTENSIONS => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER => '1:/user_upload/',
        ];

        /** @var PropertyMappingConfiguration $newExampleConfiguration */

        $newImageConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();


        $newImageConfiguration->forProperty('image')->allowAllProperties();
        $newImageConfiguration->allowCreationForSubProperty('image');
        $newImageConfiguration->allowModificationForSubProperty('image');
        $newImageConfiguration->forProperty('image')
            ->setTypeConverterOptions(
                'Pingag\\PingagThurcom\\Property\\TypeConverter\\UploadedFileReferenceConverter',
                $uploadConfiguration
            );
    }
    public function initializeCreateAction()
    {
        $this->setTypeConverterConfigurationForImageUpload("order");
    }
    public function initializeSaveOrder()
    {
        $this->setTypeConverterConfigurationForImageUpload("order");
    }
}