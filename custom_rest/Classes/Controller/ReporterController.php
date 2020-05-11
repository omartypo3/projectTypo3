<?php

namespace Cundd\CustomRest\Controller;

use Cundd\CustomRest\Domain\Model\Person;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfiguration;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfigurationBuilder;
use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\File\BasicFileUtility;
/**
 * An example Extbase controller that will be called through REST
 */
class ReporterController extends ActionController
{
    /**
     * @var \TYPO3\CMS\Extbase\Mvc\View\JsonView
     */
    protected $view;

    /**
     * @var string
     */
    protected $defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;

    /**
     * Person Repository
     *
     * @var \Cundd\CustomRest\Domain\Repository\PersonRepository
     * @inject
     */
    protected $personRepository;


    /* ----------------- POST -------------*/
    /**
     * initialize action create
     */
    public function initializeCreateAction()
    {
        // If the request does not come from a fluid form the properties which are allowed to map must be set manually
        if (!$this->request->getInternalArgument('__trustedProperties')) {
            $this->addPropertyMappingConfiguration();
        }
    }

    /**
     * action create
     *
     * @param \Cundd\CustomRest\Domain\Model\Person $person
     */
    public function createAction(Person $person)
    {
        $errors =[];
        $basicFileFunctions = GeneralUtility::makeInstance(BasicFileUtility::class);
        $target_dir = "fileadmin/imag_app/";

         if($_FILES['bild']['name'] == ""){
             $nameImage = $target_dir;
         }else{
             if($_FILES['bild']['name'] == 'uploadedMediaFile'){
                 $uri1 = explode("file://",$_FILES['bild']['uri']);
                 $uri2 = explode("/",$uri1[1]);
                 $uri3 = count($uri2);
                 $name0 = $uri2[$uri3-1];
                 $name = $basicFileFunctions->cleanFileName($name0);
                 $uniqueFileName = $basicFileFunctions->getUniqueName($name, $target_dir);
                 move_uploaded_file($_FILES['bild']['tmp_name'], $uniqueFileName);
                 $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
                 $storage = $resourceFactory->getDefaultStorage();
                 $saveFolder = $storage->getFolder('/imag_app/');
                 $saveFolderUid =$storage->addFile($uniqueFileName, $saveFolder, $name);
                 $image = $this->Image($saveFolderUid->getUid());
                 $nameImage = $target_dir.$image;
             }else{
                 $name = $basicFileFunctions->cleanFileName($_FILES['bild']['name']);
                 $uniqueFileName = $basicFileFunctions->getUniqueName($name, $target_dir);
                 move_uploaded_file($_FILES['bild']['tmp_name'], $uniqueFileName);
                 $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
                 $storage = $resourceFactory->getDefaultStorage();
                 $saveFolder = $storage->getFolder('/imag_app/');
                 $saveFolderUid =$storage->addFile($uniqueFileName, $saveFolder, $name);
                 $image = $this->Image($saveFolderUid->getUid());
                 $nameImage = $target_dir.$image;
             }

         }




        // if((filter_var($person->getEmail(),FILTER_VALIDATE_EMAIL)) && ($person->getName()!="" ) ){
         if(($person->getName()!="" ) ){


             if($nameImage == "fileadmin/imag_app/"){
                 $person->setPid("1184");
                 $person->setBild($nameImage);
             }else{
                 $data = getimagesize($nameImage);
                 $width = $data[0];
                 $height = $data[1];
                 $person->setPid("1184");
                 $person->setBild($nameImage);

                 $images = "https://www.toponline.ch/".$person->getBild();
                 $fp   = fopen($images, 'rb');   // le b c'est pour les windowsiens
                 $attachment = fread($fp, filesize($images));
                 fclose($fp);
                 $attachment = chunk_split(base64_encode($attachment));
             }

            $this->personRepository->add($person);

            if($_FILES['bild']['name']!=''){
                if(stristr($_FILES['bild']['type'], "video")){
                    $MailMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                    $MailMessage->setSubject('');
                    //$MailMessage->setfrom(array("omar.jmal@softtodo.com" => 'TOP Reporter'));
                    $MailMessage->setfrom(array("topreporter@toponline.ch" => 'TOP Reporter'));
                    $MailMessage->setSubject("TOP Reporter");
                    //$MailMessage->setTo("omar.jmal@softtodo.com");
                    $MailMessage->setTo("topreporter@toponline.ch");
                    $MailMessage->setBody('Here is the message itself');

                    $MailMessage->addPart('<p><b>Vorname/Name</b> ' . $person->getName() . '</p><p><b>PLZ/Ort</b> ' . $person->getPlz() . '</p><p><b>Telefon</b> ' . $person->getTelefon() . '</p><p><b>Email</b> '
                        . $person->getEmail() . '</p><p><b>Was ist passiert?</b> ' . $person->getText() . '</p><p><b>Foto/Video</b><br/><video width="'.$width.'" height="'.$height.'" controls><source src="'.$images.'" type="'.$_FILES['bild']['type'].'"></video></p>'.$attachment, 'text/html');

                    $MailMessage->send();
                }else{
                    $MailMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                    $MailMessage->setSubject('');
                    //$MailMessage->setfrom(array("omar.jmal@softtodo.com" => 'TOP Reporter'));
                    $MailMessage->setfrom(array("topreporter@toponline.ch" => 'TOP Reporter'));
                    $MailMessage->setSubject("TOP Reporter");
                    //$MailMessage->setTo("omar.jmal@softtodo.com");
                    $MailMessage->setTo("topreporter@toponline.ch");
                    $MailMessage->setBody('Here is the message itself');

                    $MailMessage->addPart('<p><b>Vorname/Name</b> ' . $person->getName() . '</p><p><b>PLZ/Ort</b> ' . $person->getPlz() . '</p><p><b>Telefon</b> ' . $person->getTelefon() . '</p><p><b>Email</b> '
                        . $person->getEmail() . '</p><p><b>Was ist passiert?</b> ' . $person->getText() . '</p><p><b>Foto/Video</b><br/><img src="'.$images.'" height="'.$height.'" width="'.$width.'"/></p>'.$attachment, 'text/html');

                    $MailMessage->send();
                }

                if((filter_var($person->getEmail(),FILTER_VALIDATE_EMAIL))){
                    $MailMessage1 = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                    $MailMessage1->setSubject('');
                    $MailMessage1->setfrom(array($person->getEmail() => 'TOP Reporter'));
                    $MailMessage1->setSubject("TOP Reporter");
                    $MailMessage1->setTo($person->getEmail());
                    $MailMessage1->setBody('Here is the message itself');

                    $MailMessage1->addPart('<p>Sehr geehrte Damen und Herren</p><br/><p>Vielen Dank für Ihr E-Mail. Wir werden uns bei Interesse mit Ihnen in Verbindung setzen. Bitte haben Sie Verständnis, dass </br> wir nicht auf alle E-Mails reagieren können.</p><p></p><p>Medienmitteilungen, Einladungen, Inputs etc. richten Sie bitte an news@teletop.ch, Veranstaltungshinweise an </br> toptipps@teletop.ch. Besten Dank.</p><p></p><p>Freundliche Grüsse</p> <br/> <p> TELE TOP <br/> Redaktion <br/> Bürglistrasse 31a <br/> Postfach 2475 <br/> 8401 Winterthur</p><br/><p>Telefon: +41 52 264 80 00</p><br/><p><img src="https://www.toponline.ch/fileadmin/imag_app/emailImage.png"/></p><p><a target="_blank" href="https://www.toponline.ch/service/detail/news/folge-uns-auf-social-media-00106268/" rel="noopener">www.toponline.ch</a></p>', 'text/html');

                    $MailMessage1->send();
                }

            }else{
                $MailMessage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                $MailMessage->setSubject('');
                //$MailMessage->setfrom(array("omar.jmal@softtodo.com" => 'TOP Reporter'));
                $MailMessage->setfrom(array("topreporter@toponline.ch" => 'TOP Reporter'));
                $MailMessage->setSubject("TOP Reporter");
                //$MailMessage->setTo("omar.jmal@softtodo.com");
                $MailMessage->setTo("topreporter@toponline.ch");
                $MailMessage->setBody('Here is the message itself');
                $MailMessage->addPart('<p><b>Vorname/Name</b> ' . $person->getName() . '</p><p><b>PLZ/Ort</b> ' . $person->getPlz() . '</p><p><b>Telefon</b> ' . $person->getTelefon() . '</p><p><b>Email</b> '
                    . $person->getEmail() . '</p><p><b>Was ist passiert?</b> ' . $person->getText() . '</p>', 'text/html');

                $MailMessage->send();


                if((filter_var($person->getEmail(),FILTER_VALIDATE_EMAIL))){
                    $MailMessage1 = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                    $MailMessage1->setSubject('');
                    $MailMessage1->setfrom(array($person->getEmail() => 'TOP Reporter'));
                    $MailMessage1->setSubject("TOP Reporter");
                    $MailMessage1->setTo($person->getEmail());
                    $MailMessage1->setBody('Here is the message itself');

                    $MailMessage1->addPart('<p>Sehr geehrte Damen und Herren</p><br/><p>Vielen Dank für Ihr E-Mail. Wir werden uns bei Interesse mit Ihnen in Verbindung setzen. Bitte haben Sie Verständnis, dass </br> wir nicht auf alle E-Mails reagieren können.</p><p></p><p>Medienmitteilungen, Einladungen, Inputs etc. richten Sie bitte an news@teletop.ch, Veranstaltungshinweise an </br> toptipps@teletop.ch. Besten Dank.</p><p></p><p>Freundliche Grüsse</p> <br/> <p> TELE TOP <br/> Redaktion <br/> Bürglistrasse 31a <br/> Postfach 2475 <br/> 8401 Winterthur</p><br/><p>Telefon: +41 52 264 80 00</p><br/><p><img src="https://www.toponline.ch/fileadmin/imag_app/emailImage.png"/></p><p><a target="_blank" href="https://www.toponline.ch/service/detail/news/folge-uns-auf-social-media-00106268/" rel="noopener">www.toponline.ch</a></p>', 'text/html');

                    $MailMessage1->send();
                }
            }

            $this->view->assign('value', ['success' => 1]);

        }else{

            if($person->getName() == ""){
                array_push($errors , "Vorname/Name is not valid");
            }
            $this->view->assign('value', ['success' => 0, 'errors' => $errors]);
        }

    }

    /*-----------------------------------------------------------------*/

    /**
     * error action
     */
    protected function errorAction()
    {
        $flattenedValidationErrors = $this->arguments->getValidationResults()->getFlattenedErrors();

        $response = [
            'success' => 0,
            'errors' => $flattenedValidationErrors['person'],
        ];

        $this->view->assign('value', $response);
    }

    /**
     * addPropertyMappingConfiguration
     */
    protected function addPropertyMappingConfiguration()
    {
        if ($this->request->hasArgument('person')) {
            /** @var MvcPropertyMappingConfiguration $propertyMappingConfiguration */
            $propertyMappingConfiguration = (new PropertyMappingConfigurationBuilder())->build(
                MvcPropertyMappingConfiguration::class
            );
            $propertyMappingConfiguration->setTypeConverterOption(
                PersistentObjectConverter::class,
                PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
                true
            );

            /** @noinspection PhpUnhandledExceptionInspection */
            foreach ((array)$this->request->getArgument('person') as $propertyName => $value) {
                $propertyMappingConfiguration->allowProperties($propertyName);
            }

            /** @noinspection PhpUnhandledExceptionInspection */
            $this->arguments->getArgument('person')->injectPropertyMappingConfiguration($propertyMappingConfiguration);
        }
    }

    public function Image($pid)
    {
        /******************category*********************/
        $fields = '*';
        $table = 'sys_file';
        $where = $pid .'= sys_file.uid';
        $groupBy = '';
        $orderBy = '';
        $limit = '';
        $rescategory = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $table, $where, $groupBy, $orderBy, $limit);
        $ttContentcategory = array();
        while (($recordcategory = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($rescategory))) {
            array_push($ttContentcategory,$recordcategory['name']);
        }
        return $ttContentcategory[0];

    }

}
