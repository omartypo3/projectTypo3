<?php
namespace DslFactory\DslImmo\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

use DslFactory\DslImmo\Domain\Repository\ImmobilieRepository;
use DslFactory\DslImmo\Domain\Repository\ImportRepository;

class ImportIvmCommand extends Command
{
    protected static $defaultName = 'dsl_immo:importIvm';

    protected $immobilieRepository;


    protected $importRepository;

    protected $configurationManager;

    /**
     * The settings.
     * @var array
     */
    protected $settings = array();

    protected $objectManager;
    protected $persistenceManager;
    protected $flashMessageService;
    protected $messageQueue;

    protected $url;

    protected $geoLageGebietField = "district_city"; // oder district_name
    protected $geoEtageAdd = 1; // bei wewobau 1, bei seeg 0
    protected $ausstattungEnvironmet = array();

    protected $ignoreFlatHousenr = 0;


    protected $json_url = "/modules/json/";
    protected $json_suche = "json_search.php";
    protected $json_wohngebiete = "json_districts.php";
    protected $json_wohnungen = "json_liste.php";
    protected $json_wohnung = "json_details.php";
    protected $json_ausstattungen = "json_environments.php";
    protected $json_data = "json_data.php";
    //var $json_url = "/modules/json/";

//ausstattungEnvironmet.flaechenAnzahlBalkone


    protected $wohnung = false;

    protected $wohngebiete = false;
    protected $searchData = false;
    protected $strassen = false;
    protected $ausstattungen = false;

    public $wohnungen = array();
    protected $wohnungen_gesamt = 0;

    protected $wohnungen_suche = array();
    protected $wohnungen_suche_gesamt = array();

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $this->immobilieRepository= $this->objectManager->get(ImmobilieRepository::class);
        $this->importRepository= $this->objectManager->get(ImportRepository::class);
        $this->flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
        $this->messageQueue = $this->flashMessageService->getMessageQueueByIdentifier();

        $ivmSettings = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('ivm');


        $this->url = $ivmSettings["url"];
        $this->geoLageGebietField = $ivmSettings["geoLageGebietField"];
        $this->geoEtageAdd = $ivmSettings["geoEtageAdd"];
        $this->ausstattungEnvironmet = $ivmSettings["ausstattungEnvironmet."];
        $this->ignoreFlatHousenr = $ivmSettings["ignoreFlatHousenr"];

    }

    protected function configure()
    {
        $this->setDescription('Import command for YourExtension')
            ->setHelp('This command imports data for YourExtension');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $uploadSettings = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('storage');
        //$this->addFlashMessage(print_r($uploadSettings, 1), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');

        $storage = $resourceFactory->getStorageObject($uploadSettings['falStorage']);
        //$folder = $storage->getFolder(trim($uploadSettings['falStorageSubDir'], '/') . '/');
        //$folderBackup = $storage->getFolder(trim($uploadSettings['falStorageBackupDir'], '/') . '/');
        $folderAnhaenge = $storage->getFolder(trim($uploadSettings['falStorageAnhaengeDir'], '/') . '/');
        //$folderTemp = $storage->getFolder(trim($uploadSettings['falStorageTempDir'], '/') . '/');


        $this->wohnungen = $this->getWohnungen();

        $newImport = new \DslFactory\DslImmo\Domain\Model\Import();
        $immobilienToDelete = array();

        $immobilien = $this->immobilieRepository->findAll();
        foreach($immobilien as $immobilie){
            $immobilienToDelete[$immobilie->getOpenimmoobid()] = $immobilie;
        }

        /*Zuordnungen laden*/
        $zuordnungArr = array();
        $zuordnungGetArr = array(
            'tx_dslimmo_domain_model_immobilie' => array('ausstattung_bad', 'ausstattung_kueche', 'ausstattung_boden', 'nutzungs_art', 'vermarktungs_art', 'objekt_art_wohnung_typ', 'zustand_art', 'ausstattung_heizungsart', 'ausstattung_befeuerung', 'ausstattung_fahrstuhl', 'ausstattung_stellplatzart', 'ausstattung_ausricht_balkon_terasse', 'ausstattung_angeschl_gastronomie', 'ausstattung_serviceleistungen', 'ausstattung_sicherheitstechnik', 'ausstattung_moebliert', 'ausstattung_kategorie', 'ausstattung_energietyp', 'ausstattung_ausbaustufe', 'ausstattung_bauweise', 'ausstattung_dachform', 'ausstattung_unterkellert', 'geo_lage_im_bau', 'objekt_art_zimmer_typ', 'objekt_art_haus_typ', 'objekt_art_grundstueck_typ', 'objekt_art_buero_praxen_typ', 'objekt_art_einzelhandel_typ', 'objekt_art_gastgewerbe_typ', 'objekt_art_hallen_lager_produktion_typ', 'objekt_art_land_forstwirtschaft_typ', 'objekt_art_parken_typ', 'objekt_art_sonstige_typ', 'objekt_art_freizeitimmobilie_gewerblich_typ', 'objekt_art_zinshaus_renditeobjekt_typ'),
            'tx_dslimmo_domain_model_anhang' => array('type')
        );


        foreach ($zuordnungGetArr as $model => $columns) {
            foreach ($columns as $column) {
                if ($itemArr = $GLOBALS['TCA'][$model]['columns'][$column]['config']['items']) {
                    if (!isset($zuordnungArr[$model])) {
                        $zuordnungArr[$model] = array();
                    }
                    if (!isset($zuordnungArr[$model][$column])) {
                        $zuordnungArr[$model][$column] = array();
                    }
                    foreach ($itemArr as $item) {
                        $zuordnungArr[$model][$column][$item[0]] = $item[1];
                    }
                }
            }
        }

        /*Zuordnungen ende*/
        $updateFileReferenceTitle = array();


        $ausstattungenArray = $this->getAusstattungen();

        foreach ($this->wohnungen->flats as $wohnung) {//xmlImmobilie

            if ((string) $wohnung->flat_id) {
                $objektid = (string) $wohnung->flat_id;
            } elseif ((string) $wohnung->flat_keynumber) {
                $objektid = (string) $wohnung->flat_keynumber;
            }

            if(isset($immobilienToDelete[$objektid])) {
                unset($immobilienToDelete[$objektid]);
            }

            if (!($immobilie = $this->immobilieRepository->findByObjektid($objektid))) {
                //   echo 'nicht gefunden!!';
                //echo $immobilie->getUid();
                $immobilie = new \DslFactory\DslImmo\Domain\Model\Immobilie();
                $immobilie->setOpenimmoobid($objektid);
                //$this->addFlashMessage('XML Immobilie wird neu angelegt (' . $openimmo_obid . ')', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
            }



            $immobilie->addImporte($newImport);

            $immobilie->setObjektnrintern((string) $wohnung->flat_id);
            $immobilie->setObjektnrextern((string) $wohnung->flat_keynumber);






            $immobilie->setGeoPlz((string) $wohnung->flat_zip);
            $immobilie->setGeoOrt((string) $wohnung->flat_city);



            $immobilie->setFlaechenAnzahlZimmer((double) $wohnung->flat_rooms);




            //print_r(unserialize($wohnung->environmet));

            $immobilie->setFlaechenAnzahlBalkone(0);
            $immobilie->setFlaechenAnzahlTerassen(0);
            $immobilie->setFlaechenAnzahlLogia(0);
            $immobilie->setAusstattungBad('');
            $immobilie->setAusstattungMoebliert(0);
            $immobilie->setAusstattungFahrstuhl('');
            $immobilie->setAusstattungKueche('');

            $immobilie->setAusstattungSeniorengerecht(0);
            $immobilie->setModernerGrundriss(0);
            $immobilie->setObjektArtWohnungTyp(10);	//keine Angabe
            /*echo "bla";
            print_r(explode(",",$this->ausstattungEnvironmet["flaechenAnzahlBalkone"]));
            echo $this->ausstattungEnvironmet["flaechenAnzahlBalkone"];
            die;
            */

            if(isset($wohnung->floor)){
                switch((string)$wohnung->floor){
                    case 'EG':
                        $immobilie->setObjektArtWohnungTyp(80);
                        break;
                    case 'DG':
                        $immobilie->setObjektArtWohnungTyp(20);
                        break;
                }

            }


            if(isset($wohnung->environment_detail_1)){

                //balkon / logia
                foreach(explode(",",$this->ausstattungEnvironmet["flaechenAnzahlBalkone"]) as $var){
                    if(property_exists($wohnung->environment_detail_1,$var)) {
                        $immobilie->setFlaechenAnzahlBalkone(1);
                    }
                }

                $ausstattungBadArray = array();
                foreach(explode(",",$this->ausstattungEnvironmet["ausstattungBadMitWanne"]) as $var){
                    if(property_exists($wohnung->environment_detail_1,$var)) {
                        $ausstattungBadArray[20]=1;
                    }
                }
                foreach(explode(",",$this->ausstattungEnvironmet["ausstattungBadMitDusche"]) as $var){
                    if(property_exists($wohnung->environment_detail_1,$var)) {
                        $ausstattungBadArray[10]=1;
                    }
                }
                $immobilie->setAusstattungBad(implode(',', array_keys($ausstattungBadArray))); // ausstattung Bad


                //moebliert
                foreach(explode(",",$this->ausstattungEnvironmet["ausstattungMoebliert"]) as $var){
                    if(property_exists($wohnung->environment_detail_1,$var)) {
                        $immobilie->setAusstattungMoebliert(1);
                    }
                }

                //fahrstuhl
                foreach(explode(",",$this->ausstattungEnvironmet["ausstattungFahrstuhl"]) as $var){
                    if(property_exists($wohnung->environment_detail_1,$var)) {
                        $immobilie->setAusstattungFahrstuhl('10');
                    }
                }

                //einbaukeche
                foreach(explode(",",$this->ausstattungEnvironmet["ausstattungEinbaukueche"]) as $var){
                    if(property_exists($wohnung->environment_detail_1,$var)) {
                        $immobilie->setAusstattungKueche('10');
                    }
                }

                //seniorengerecht
                foreach(explode(",",$this->ausstattungEnvironmet["ausstattungSeniorengerecht"]) as $var){
                    if(property_exists($wohnung->environment_detail_1,$var)) {
                        $immobilie->setAusstattungSeniorengerecht(1);
                    }
                }

                //veraenderterGrundriss
                foreach(explode(",",$this->ausstattungEnvironmet["ausstattungVeraenderterGrundriss"]) as $var){
                    if(property_exists($wohnung->environment_detail_1,$var)) {
                        $immobilie->setModernerGrundriss(1);
                    }
                }


                //Maisonette
                foreach(explode(",",$this->ausstattungEnvironmet["ausstattungMaisonette"]) as $var){
                    if(property_exists($wohnung->environment_detail_1,$var)) {
                        $immobilie->setObjektArtWohnungTyp(30);
                    }
                }
                //Penthouse
                foreach(explode(",",$this->ausstattungEnvironmet["ausstattungPenthouse"]) as $var){
                    if(property_exists($wohnung->environment_detail_1,$var)) {
                        $immobilie->setObjektArtWohnungTyp(50);
                    }
                }

            }



            $tempArr = array();

            $portal_heatingType = (string)$wohnung->portal_heatingType;
            if($portal_heatingType == "CENTRAL_HEATING"){
                $tempArr[]=30;
            }
            $immobilie->setAusstattungHeizungsart(implode(',', $tempArr));

            $floor = (string) $wohnung->flat_floor;
            if($floor) {

                $immobilie->setGeoEtage((string) (intval($wohnung->flat_floor)+$this->geoEtageAdd));
            } else $immobilie->setGeoEtage('');
            $immobilie->setGeoAnzahlEtagen((string) $wohnung->flat_floorscount);
            //$wohnung->flat_floorscount


            if(!$this->ignoreFlatHousenr){
                if((string)$wohnung->housenr != '0') $immobilie->setGeoHausnummer((string)$wohnung->housenr); else $immobilie->setGeoHausnummer('');
            } else $immobilie->setGeoHausnummer('');


            switch($this->geoLageGebietField){
                case 'district_city':
                    $immobilie->setGeoLageGebiet((string)$wohnung->district_city);
                    break;
                case 'district_name':
                default:
                    $immobilie->setGeoLageGebiet((string)$wohnung->district_name);
                    break;

            }



            $immobilie->setGeoLageImBau((string)$wohnung->flat_direction);

            $immobilie->setPreiseKaltmiete((double) $wohnung->rent_plain);

            $immobilie->setPreiseWarmmiete((double) str_replace(",",'.',str_replace(".",'',$wohnung->rent_all)));


            $immobilie->setPreiseNebenkosten($immobilie->getPreiseWarmmiete()-$immobilie->getPreiseKaltmiete());

            $immobilie->setPreiseKaution((double) $wohnung->flat_deposit);

            if((string) $wohnung->flat_rentdate!='00.00.0000') {
                if($wohnung->flat_rent_date<=date("Y-m-d")) {//vergangene datums quasi ab sofort setzen
                    $immobilie->setVerfuegbarab('ab sofort');
                    $immobilie->setHighlight(1);
                } else {
                    $immobilie->setVerfuegbarab((string) $wohnung->flat_rentdate);
                }
            } else {
                $immobilie->setVerfuegbarab("verfügbar nach Absprache");
            }


            $immobilie->setObjekttitel((string) $wohnung->flat_exposetitle);
            $immobilie->setLage((string) $wohnung->district_description);

            $immobilie->setObjektbeschreibung((string) $wohnung->objectdescription);

            $ausstattbeschrArr = array();
            if($wohnung->environment_detail_1) {
                $environment_detail_1Arr = (array)$wohnung->environment_detail_1;
                if(is_array($environment_detail_1Arr)) {
                    foreach($environment_detail_1Arr as $ausstattungKey => $ausstattungDetailValue){

                        if($ausstattungDetailValue) $zusatz = " (".$ausstattungDetailValue.")"; else $zusatz = "";
                        $ausstattbeschrArr[] = $ausstattungenArray[$ausstattungKey].$zusatz;

                    }
                }

            }
            $immobilie->setAusstattbeschr(implode('\r\n',$ausstattbeschrArr));

            //Baujahr bei der Wewobau
            $immobilie->setZustandBaujahr((string) $wohnung->flat_enev_year_anlage);
            //Baujahr bei der Seeg für energieausweis
            if((string)$wohnung->flat_year){
                $immobilie->setZustandBaujahr((string)$wohnung->flat_year);
            }


            if ($wohnung->portal_denkmalschutz) {
                $immobilie->setDenkmalgeschuetzt(true);
            } else {
                $immobilie->setDenkmalgeschuetzt(false);
            }

            //neu 25092019
            if($wohnung->energyconsumption){
                $immobilie->setEnergiepassWertklasse($wohnung->energyconsumption);
            } else {
                $immobilie->setEnergiepassWertklasse('');
            }


            if($wohnung->flat_enev_ausweisart){
                if($wohnung->flat_enev_ausweisart=='Energieverbrauchsausweis'){//verbrauch
                    $immobilie->setEnergiepassEpart("VERBRAUCH");
                } else { //bedarf
                    $immobilie->setEnergiepassEpart("BEDARF");
                }
            }
            if($wohnung->flat_enev_warmwasserenthalten=='j' || $wohnung->flat_enev_warmwasserenthalten=='n'){
                if($wohnung->flat_enev_warmwasserenthalten=='j') $immobilie->setEnergiepassMitwarmwasser('1'); else $immobilie->setEnergiepassMitwarmwasser('0');
            }

            if($wohnung->enev_verbrauchswert) $immobilie->setEnergiepassenergieverbrauchkennwert((string) $wohnung->enev_verbrauchswert);
            if($wohnung->flat_enev_bedarfswert) $immobilie->setEnergiepassendenergiebedarf((string) $wohnung->flat_enev_bedarfswert);

            $immobilie->setEnergiepassPrimaerenergietraeger((string) $wohnung->lights);


            if((string)$wohnung->flat_energie) {
                $immobilie->setEnergieAusweisLinkExtern($this->url."/_img/energiepass/".(string)$wohnung->flat_energie);
            } else {
                $immobilie->setEnergieAusweisLinkExtern('');
            }


            //keine wohnung
            $immobilie->setZustandart(0);

            $immobilie->setGeoStrasse(trim(str_replace($immobilie->getGeoHausnummer(),"", (string)$wohnung->flat_street )));

            if((double)$wohnung->marker_lat &&  (double)$wohnung->marker_lng){

                $immobilie->setGeoKoordinatenBreitengrad((double)$wohnung->marker_lat);
                $immobilie->setGeoKoordinatenLaengengrad((double)$wohnung->marker_lng);
            } else {
                if($immobilie->getStrasseHausnummer() && $immobilie->getGeoPlz() && $immobilie->getGeoOrt() ){
                    if($geoCoord = \DslFactory\DslImmo\Utility\GeocodeUtility::init()->geocodeAddress($immobilie->getStrasseHausnummer().", ". $immobilie->getGeoPlz().", ".$immobilie->getGeoOrt())){
                        $immobilie->setGeoKoordinatenBreitengrad($geoCoord["breitengrad"]);
                        $immobilie->setGeoKoordinatenLaengengrad($geoCoord["laengengrad"]);
                    }
                }
            }
            $immobilie->setVermarktungsArt(20);//bei dieser schnittstelle immer miete
            switch((string)$wohnung->flat_usenr){
                case 'Stellplatz':
                    $immobilie->setNutzungsArt(0);
                    $immobilie->setObjektArtParkenTyp(true);
                    break;
                case 'Wohngemeinschaft':
                    $immobilie->setNutzungsArt(10);
                    $immobilie->setAusstattungWggeeignet(true);
                    break;
                case 'Gewerbe':
                    $immobilie->setNutzungsArt(20);
                    $immobilie->setFlaechenNutzflaeche((double) $wohnung->flat_space);

                    break;
                case 'Wohnung':
                default:
                    $immobilie->setNutzungsArt(10);//bei dieser schnittstelle immer miete
                    $immobilie->setFlaechenWohnflaeche((double) $wohnung->flat_space);
                    break;
            }
            $immobilie->refreshSearchVars();

            $immobilie->setAnhaenge(new \TYPO3\CMS\Extbase\Persistence\ObjectStorage());
            $bildUrl =  $this->getImage($wohnung,"image");
            if($bildUrl){
                $bildName = $wohnung->flat_image;
                $bild = $this->getImageResponseFromCurl($bildUrl);


                $anhangDatei = $storage->createFile($bildName, $folderAnhaenge);
                $anhangDatei->setContents($bild);


                $anhang = new \DslFactory\DslImmo\Domain\Model\Anhang();
                $anhang->setType(10);//Titelbild

                $anhangDateiReference = $this->objectManager->get('DslFactory\\DslImmo\\Domain\\Model\\FileReference');
                $anhangDateiReference->setFile($anhangDatei);
                /*
                if ((string) $xmlAnhang->anhangtitel) {
                                        $updateFileReferenceTitle[] = array('obj' => $anhangDateiReference, 'field' => 'title', 'value' => (string) $xmlAnhang->anhangtitel);
                                    }
                */
                $anhang->setDatei($anhangDateiReference);
                $immobilie->addAnhaenge($anhang);
            }
            //Grundriss
            $bildUrl =  $this->getImage($wohnung,"plot");
            if($bildUrl){
                $bildName = $wohnung->flat_plot;
                $bild = $this->getImageResponseFromCurl($bildUrl);
                if($bild){
                    $anhangDatei = $storage->createFile($bildName, $folderAnhaenge);
                    $anhangDatei->setContents($bild);


                    $anhang = new \DslFactory\DslImmo\Domain\Model\Anhang();
                    $anhang->setType(40);//Titelbild

                    $anhangDateiReference = $this->objectManager->get('DslFactory\\DslImmo\\Domain\\Model\\FileReference');
                    $anhangDateiReference->setFile($anhangDatei);
                    /*
                    if ((string) $xmlAnhang->anhangtitel) {
                                            $updateFileReferenceTitle[] = array('obj' => $anhangDateiReference, 'field' => 'title', 'value' => (string) $xmlAnhang->anhangtitel);
                                        }
                    */
                    $anhang->setDatei($anhangDateiReference);
                    $immobilie->addAnhaenge($anhang);
                }
            }





            $this->wohnung = $this->getWohnung($wohnung->flat_id);
            //weitere bilder
            $bilder = $this->getGallerieBilder($wohnung);
            if(count($bilder)) foreach($bilder as $bildUrl => $bildTitel){
                $pi = pathinfo($bildUrl);
                $bildName = $pi["basename"];
                $bild = $this->getImageResponseFromCurl($bildUrl);
                $anhangDatei = $storage->createFile($bildName, $folderAnhaenge);
                $anhangDatei->setContents($bild);
                $anhang = new \DslFactory\DslImmo\Domain\Model\Anhang();
                $anhang->setType(70);//bild
                $anhangDateiReference = $this->objectManager->get('DslFactory\\DslImmo\\Domain\\Model\\FileReference');
                $anhangDateiReference->setFile($anhangDatei);

                if ($bildTitel) {
                    $updateFileReferenceTitle[] = array('obj' => $anhangDateiReference, 'field' => 'title', 'value' => $bildTitel);
                }

                $anhang->setDatei($anhangDateiReference);
                $immobilie->addAnhaenge($anhang);
            }



            $titelBilder = $immobilie->getTitelBilder();
            if(isset($titelBilder[0])) $immobilie->setTitelBild($titelBilder[0]); else $immobilie->setTitelBild(NULL);


            //print_r($this->getGallerieBilder($wohnung));
            //echo "</pre>";

            if (!$immobilie->getUid()) {
                //$immobilie->setPid(13);

                //$storageSettings = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('storage');
                if($uploadSettings["storagePid"]){
                    $immobilie->setPid($uploadSettings["storagePid"]);
                }



                $this->immobilieRepository->add($immobilie);
            } else {
                //echo "vart:".$immobilie->getVermarktungsArt();
                //echo "update/uid:".$immobilie->getUid();
                //die;

                $this->immobilieRepository->update($immobilie);
                \DslFactory\DslImmo\Utility\CacheUtility::init()->resetImmobilie($immobilie->getUid());
            }



        }
//die;
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        if (count($updateFileReferenceTitle)) {
            $updateData = array('sys_file_reference' => array());
            foreach ($updateFileReferenceTitle as $item) {
                //echo "<div>???????".$item["obj"]->getUid().":".$item["title"]."</div>";
                $updateData['sys_file_reference'][$item['obj']->getUid()] = array($item['field'] => $item['value']);
            }
            /** @var \TYPO3\CMS\Core\DataHandling\DataHandler $tce */
            $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
            // create TCE
            $tce->start($updateData, array());
            $tce->process_datamap();
        }
        $this->importRepository->add($newImport);

        if(count($immobilienToDelete)){

            foreach($immobilienToDelete as $immobilieToDelete){
                //$this->addFlashMessage('Immobilie Gelöscht da diese Im VollAbgleich Import nicht mehr vorhanden ist (' . $immobilieToDelete->getOpenimmoobid() . ')', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                $this->deleteImmobilie($immobilieToDelete);
            }
            /*print_r(array_keys($immobilienToDelete));
                die;*/
        }

        /*?><pre><?php print_r($this->wohnungen);?></pre><?php*/
        //die;



        $files = $storage->getFilesInFolder($folderAnhaenge, 0, 0, true, false, 'modification_date', false);
        foreach ($files as $file) {
            $fileObjects = $this->getDatabaseConnection()->exec_SELECTgetRows('uid', 'sys_file_reference', 'tablenames=' . $this->getDatabaseConnection()->fullQuoteStr('tx_dslimmo_domain_model_anhang', 'sys_file_reference') . ' AND uid_local=' . (int) $file->getUid() . ' AND fieldname=' . $this->getDatabaseConnection()->fullQuoteStr('datei', 'sys_file_reference'), '', 'sorting_foreign', '', 'uid');
            if (!count($fileObjects)) {
                //$this->addFlashMessage((string) $file->getUid() . ' // ' . $file->getIdentifier() . ' wird gelöscht (' . count($fileObjects) . ')', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                $file->delete();
            }
        }


        return Command::SUCCESS;
    }

    function getImage($wohnung,$type){


        switch($type){
            case "image":
                if(!$wohnung->image) return false;
                if($wohnung->flat_image) return $this->url."/_lib/phpthumb/phpThumb.php?src=".rawurlencode("/_img/flats/".$wohnung->flat_image);
                break;
            case "plot":
                if($wohnung->flat_plot) return $this->url."/_lib/phpthumb/phpThumb.php?src=".rawurlencode("/_img/plots/".$wohnung->flat_plot);
                break;
        }
        return false;
//		/_img/gallery/[wohnungsid]/th_[bildname]
    }



    function getGallerieBilder($wohnung){
        $galleryImgArr = unserialize(urldecode($this->wohnung->gallery_img));
        $returnArr = array();
        if(is_array($galleryImgArr)) foreach($galleryImgArr as $image){
            if(!$image["versteckt"]) $returnArr[$this->url."/_img/gallery/".$wohnung->flat_id."/img_".$image["name"]] = $image["info_text"];
        }
        return $returnArr;
    }


    function getAusstattungen(){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.'/modules/json/json_environments.php');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        if($response) return unserialize(json_decode($response));
        return array();


    }


    function getWohnung($flat_id){
//		flat_id =>
        $postFields = array(
            'flat_id'=>$flat_id
        );
        //echo $flat_id;
        //exit;

        $result = $this->getResponseFromCurl($this->json_wohnung,$postFields);

        /*?><pre><?php print_r($result); ?></pre><?php*/
        //die;
        if($result->flat_prices) $result->flat_prices = json_decode(json_encode(unserialize($result->flat_prices)), FALSE);
//		$result->->nof_results
//		$result->->pages
//		$result->->page
//		$this->wohnungen_suche = $result->flats;
//		$this->wohnungen_suche_gesamt = count($result->flats);


        return $result;

    }

    private function getResponseFromCurl($json, $postFields = array()){



        //echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>".$this->url.$this->json_url . $json;
        //die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.$this->json_url . $json);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);

    }



    function getImageResponseFromCurl($url){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

    }


    private function getWohnungen(){


        $postFields = array(
            'search_page'=>0,
            'limit'=>'all',
            'search_sort'=>'flat_rent,ASC'
        );

        $response = $this->getResponseFromCurl($this->json_suche,$postFields);

        /* if($_GET["gba"]){
             ?><pre><?php
             print_r(array("postfields"=>$postFields,"response"=>json_decode($response,true)));
             ?></pre><?php
         }*/

        $this->wohnungen_suche = $this->filterWohnungenSuche($response->flats);

        $this->wohnungen_suche_gesamt = count($this->wohnungen_suche);


        return $response;

    }

    /**
     * delete Import
     *
     * @param \DslFactory\DslImmo\Domain\Model\Import $import
     * @return void
     */
    private function deleteImport(\DslFactory\DslImmo\Domain\Model\Import $import)
    {
        //$file = $import->getDatei();
        if ($import->getDatei()) {
            $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
            $fileReferenceObject = $resourceFactory->getFileReferenceObject($import->getDatei()->getUid());
            $fileWasDeleted = $fileReferenceObject->getOriginalFile()->delete();
        }
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->importRepository->remove($import);
        //$this->redirect('list');
        //https://docs.typo3.org/typo3cms/CoreApiReference/ApiOverview/FlashMessages/Index.html
    }

    /**
     * delete an immobilie
     *
     * @param \DslFactory\DslImmo\Domain\Model\Immobilie $immobilie
     * @return void
     */
    public function deleteImmobilie(\DslFactory\DslImmo\Domain\Model\Immobilie $immobilie)
    {
        //echo $immobilieUid;
        //if($immobilie = $this->immobilieRepository->findByUidBackend($immobilieUid)){
        //echo $immobilie->getUid();
        //die;
        if ($immobilie->getAnhaenge()) {
            foreach ($immobilie->getAnhaenge() as $anhang) {
                if ($anhang->getDatei()) {
                    $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
                    //echo ""
                    //	$storage->getFilesInFolder($folder, 0, 0, true, false, 'modification_date', false);
                    if ($anhang->getDatei()->getUid()) {
                        //wenn die datei schon gespeichert wurde
                        $fileReferenceObject = $resourceFactory->getFileReferenceObject($anhang->getDatei()->getUid());
                        $fileWasDeleted = $fileReferenceObject->getOriginalFile()->delete();
                    } else {
                    }
                }
            }
        }


        //$this->immobilieRepository->remove($immobilie);
        $this->removeImmo($immobilie->getUid());
    }

    function filterWohnungenSuche($wohnungen){

        $wohnungenFiltered = array();
        foreach($wohnungen as $wohnung){
            $valid = true;
            if(isset($this->filter["frei"])){
                if(!$this->isFree($wohnung)) $valid=false;
            }
            if($valid) $wohnungenFiltered[] = $wohnung;
        }


        return $wohnungenFiltered;
    }


    function isFree($wohnung = false){
        //wenn 0000 00 00 dann nach absprache
        if($wohnung){
            if($wohnung->flat_rent_date<=date("Y-m-d")) return true;
        } else {
            if($this->wohnung->flat_rent_date<=date("Y-m-d")) return true;
        }
        return false;

    }

    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }


    public function removeImmo($uid){
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dslimmo_domain_model_immobilie');
        $queryBuilder
            ->update('tx_dslimmo_domain_model_immobilie')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
            )
            ->set('deleted', 1)
            ->executeStatement();
    }





}