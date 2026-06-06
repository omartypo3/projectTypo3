<?php
namespace DslFactory\DslImmo\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

use DslFactory\DslImmo\Domain\Repository\ImmobilieRepository;
use DslFactory\DslImmo\Domain\Repository\ImportRepository;	  

class ImportCommand extends Command
{
    protected static $defaultName = 'dsl_immo:import';

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

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
		$this->immobilieRepository= $this->objectManager->get(ImmobilieRepository::class);
		$this->importRepository= $this->objectManager->get(ImportRepository::class);
		$this->flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
		$this->messageQueue = $this->flashMessageService->getMessageQueueByIdentifier();
        $this->addArgument('fileUid', InputArgument::OPTIONAL, 'File UID', 0);

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
        $folder = $storage->getFolder(trim($uploadSettings['falStorageSubDir'], '/') . '/');
        $folderBackup = $storage->getFolder(trim($uploadSettings['falStorageBackupDir'], '/') . '/');
        $folderAnhaenge = $storage->getFolder(trim($uploadSettings['falStorageAnhaengeDir'], '/') . '/');
        $folderTemp = $storage->getFolder(trim($uploadSettings['falStorageTempDir'], '/') . '/');
		
		$files = $storage->getFilesInFolder($folder, 0, 0, true, false, 'modification_date', true);

        $fileUid = (int)$input->getArgument('fileUid');

        if(!$fileUid) {
            //getoldest file to import
            $zipFileToImport = false;
            $sortedFiles = array();
            foreach ($files as $file) {
                $fileProperties = $file->getProperties();
                $sortedFiles[(int)$fileProperties['modification_date']] = $file;
            }
            krsort($sortedFiles);
            $zipFileToImport = false;
            foreach ($sortedFiles as $file) {
                $fileProperties = $file->getProperties();
                if ($fileProperties['mime_type'] == 'application/zip') {
                    $fileUid = $file->getUid();
                    //$zipFileToImport = $file;
                }
            }



        }

        foreach ($files as $zipFile) {
            if (!$fileUid) {
                break;
            }
            if ($fileUid != $zipFile->getUid()) {
                continue;
            }


            $fileProperties = $zipFile->getProperties();
            //print_r($file->_getPropertyRaw());
            if ($fileProperties['mime_type'] == 'application/zip') {
                $ZipPointer = zip_open($storage->getFileForLocalProcessing($zipFile, false));
                if ($ZipPointer) {
                    while ($GezippteDatei = zip_read($ZipPointer)) {

                        $zipEntryNameArr = explode('/',zip_entry_name($GezippteDatei));

                        $zipEntryName = $zipEntryNameArr[count($zipEntryNameArr)-1];

                        if (preg_match('/\\/$/', $zipEntryName)) {
                        } else {
                            if (zip_entry_open($ZipPointer, $GezippteDatei, 'r')) {
                                $newFile = $storage->createFile($zipEntryName, $folderTemp);
                                $newFile->setContents(zip_entry_read($GezippteDatei, zip_entry_filesize($GezippteDatei)));
                                //$newFileProperties = $newFile->getProperties();
                                //print_r($newFileProperties['mime_type']);
                                $newFileArr[$zipEntryName] = $newFile;
                                zip_entry_close($GezippteDatei);
                            }
                        }
                    }
                    zip_close($ZipPointer);
                }
                $xmlFile = false;
                foreach ($newFileArr as $newFile) {
                    $newFileProperties = $newFile->getProperties();
                    //echo $newFileProperties['mime_type'];
                    if ($newFileProperties['mime_type'] == 'application/xml' || $newFileProperties['mime_type'] == 'text/xml') {
                        $xmlFile = $newFile;
                        //		print_r($newFileProperties);
                        break;
                    }
                }
                if ($xmlFile) {


                    //$this->addFlashMessage('Import von ' . $xmlFile->getIdentifier(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);

                    //echo $xmlFile->getIdentifier();
                    $newImport = new \DslFactory\DslImmo\Domain\Model\Import();
                    $zipFileReference = $this->objectManager->get('DslFactory\\DslImmo\\Domain\\Model\\FileReference');
                    $zipFileReference->setFile($zipFile);
                    $newImport->setDatei($zipFileReference);
                    //auskommentiert um import zu wiederholen
                    $zipFile->moveTo($folderBackup);
                    //echo 'parseXML';

                    $immobilienToDelete = array();

                    $xml = new \SimpleXMLElement($xmlFile->getContents());
                    switch ((string) $xml->uebertragung['umfang']) {
                        case 'TEIL':    $newImport->setType(10);
                            break;
                        case 'VOLL':    $newImport->setType(20);
                            //nicht enthaltene objekte löschen


                            $immobilien = $this->immobilieRepository->findAll();
                            foreach($immobilien as $immobilie){
                                $immobilienToDelete[$immobilie->getOpenimmoobid()] = $immobilie;
                            }

                            break;
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
                    /*
                    foreach ($xml->anbieter->immobilie as $xmlImmobilie) {
                        //var_dump($xmlImmobilie->flaechen);
                    //	$ausstattungXml = $xmlImmobilie->ausstattung;
                        //echo (int)$ausstattungXml->seniorengerecht."-";
                        //var_dump($xmlImmobilie->ausstattung);
                        //echo "durchlauf::".(string)$xmlImmobilie->geo->strasse.":etage:".(string)$xmlImmobilie->geo->etage.":wg:".(string)$xmlImmobilie->austattung->wgGeeignet.":".(int)$ausstattungXml->wg_geeignet.":".$xmlImmobilie->austattung->{"wg_geeignet"}.":g:".(int)$xmlImmobilie->austattung->gartennutzung.":s:".(int)$xmlImmobilie->austattung->seniorengerecht.":anzahlbalkone:".(int)$xmlImmobilie->flaechen->anzahl_balkone."<hr>";
                        echo "durchlauf::".(string)$xmlImmobilie->geo->strasse.":".(int)$xmlImmobilie->ausstattung->wg_geeignet.":s:".(int)$xmlImmobilie->ausstattung->seniorengerecht;
                        /*foreach($xmlImmobilie->austattung as $v){
                            echo "?:".$v;
                        }
                        echo "<hr>";

                    }
                    die;*/



                    foreach ($xml->anbieter->immobilie as $xmlImmobilie) {
                        //	echo "<hr>";
                        //	echo "durchlauf:".(string)$xmlImmobilie->geo->strasse.":w:".(int)$xmlImmobilie->ausstattung->wg_geeignet.":s:".(int)$xmlImmobilie->ausstattung->seniorengerecht;


                        //echo 'foreach xmlimmobilie<br>';
                        if ((string) $xmlImmobilie->verwaltung_techn->openimmo_obid) {
                            $openimmo_obid = (string) $xmlImmobilie->verwaltung_techn->openimmo_obid;
                        } elseif ((string) $xmlImmobilie->verwaltung_techn->objektnr_extern) {
                            $openimmo_obid = (string) $xmlImmobilie->verwaltung_techn->objektnr_extern;
                        } elseif ((string) $xmlImmobilie->verwaltung_techn->objektnr_intern) {
                            $openimmo_obid = (string) $xmlImmobilie->verwaltung_techn->objektnr_intern;
                        }

                        if(isset($immobilienToDelete[$openimmo_obid])) unset($immobilienToDelete[$openimmo_obid]);

                        //$this->addFlashMessage('XML Immobilie wird verarbeitet (' . $openimmo_obid . ')', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                        //  echo '<hr>Imobilie!';
                        if (!($immobilie = $this->immobilieRepository->findByObjektid($openimmo_obid))) {
                            //   echo 'nicht gefunden!!';
                            //echo $immobilie->getUid();
                            $immobilie = new \DslFactory\DslImmo\Domain\Model\Immobilie();
                            $immobilie->setOpenimmoobid($openimmo_obid);
                            //$this->addFlashMessage('XML Immobilie wird neu angelegt (' . $openimmo_obid . ')', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                        } else {
                            //$this->addFlashMessage('XML Immobilie wird bearbeitet (' . $openimmo_obid . ') uid:' . $immobilie->getUid(), '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                        }
                        $immobilie->addImporte($newImport);
                        foreach ($zuordnungArr['tx_dslimmo_domain_model_immobilie']['nutzungs_art'] as $k => $v) {
                            if ((string) $xmlImmobilie->objektkategorie->nutzungsart[$k] == 'true') {
                                $immobilie->setNutzungsart($v);
                            }
                        }
                        //print_r($zuordnungArr['tx_dslimmo_domain_model_immobilie']['vermarktungs_art']);
                        foreach ($zuordnungArr['tx_dslimmo_domain_model_immobilie']['vermarktungs_art'] as $k => $v) {
                            if ((string) $xmlImmobilie->objektkategorie->vermarktungsart[$k] == 'true') {
                                //echo $k."->".$v;
                                $immobilie->setVermarktungsart($v);
                            }
                        }

                        if ((string) $xmlImmobilie->ausstattung->moebliert['moeb']) {
                            $immobilie->setAusstattungMoebliert($zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_moebliert'][(string) $xmlImmobilie->ausstattung->moebliert['moeb']]);
                        } else {
                            $immobilie->setAusstattungMoebliert(0);
                        }
                        if ((string) $xmlImmobilie->ausstattung->ausstatt_kategorie) {
                            $immobilie->setAusstattungKategorie($zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_kategorie'][(string) $xmlImmobilie->ausstattung->ausstatt_kategorie]);
                        } else {
                            $immobilie->setAusstattungKategorie(0);
                        }
                        if ((string) $xmlImmobilie->ausstattung->unterkellert['keller']) {
                            $immobilie->setAusstattungUnterkellert($zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_unterkellert'][(string) $xmlImmobilie->ausstattung->unterkellert['keller']]);
                        } else {
                            $immobilie->setAusstattungUnterkellert(0);
                        }

//echo "<br>durchlauf2:".(string)$xmlImmobilie->geo->strasse.":w:".(int)$xmlImmobilie->ausstattung->wg_geeignet.":s:".(int)$xmlImmobilie->ausstattung->seniorengerecht;
                        /*?><pre><?php print_r($zuordnungArr);?></pre><?php
                          die;*/
                        if ($xmlImmobilie->kontaktperson) {
                            if (!($kontaktperson = $immobilie->getKontaktperson())) {
                                $kontaktperson = new \DslFactory\DslImmo\Domain\Model\Kontaktperson();
                                $immobilie->setKontaktperson($kontaktperson);
                            }
                            //echo $xmlImmobilie->kontaktperson->email_zentrale;die;
                            //                            $kontaktperson = $immobilie->getKontaktperson();
                            $kontaktperson->setEmailzentrale((string) $xmlImmobilie->kontaktperson->email_zentrale);
                            $kontaktperson->setTelzentrale((string) $xmlImmobilie->kontaktperson->tel_zentrale);
                            $kontaktperson->setTelfax((string) $xmlImmobilie->kontaktperson->tel_fax);
                            $kontaktperson->setName((string) $xmlImmobilie->kontaktperson->name);
                            $kontaktperson->setVorname((string) $xmlImmobilie->kontaktperson->vorname);
                            $kontaktperson->setFirma((string) $xmlImmobilie->kontaktperson->firma);
                            $kontaktperson->setStrasse((string) $xmlImmobilie->kontaktperson->strasse);
                            $kontaktperson->setPlz((string) $xmlImmobilie->kontaktperson->plz);
                            $kontaktperson->setOrt((string) $xmlImmobilie->kontaktperson->ort);
                            $kontaktperson->setUrl((string) $xmlImmobilie->kontaktperson->url);
                        } else {
                            if ($immobilie->getKontaktperson()) {
                                $this->kontaktpersonRepository->remove($immobilie->getKontaktperson());
                            }
                        }
                        $immobilie->setGeoPlz((string) $xmlImmobilie->geo->plz);
                        $immobilie->setGeoOrt((string) $xmlImmobilie->geo->ort);

                        //if(!$immobilie->getGeoLageGebiet()) $immobilie->setGeoLageGebiet($immobilie->getGeoOrt());
                        $immobilie->setGeoRegionalerZusatz((string) $xmlImmobilie->geo->regionaler_zusatz);


//echo "<br>durchlauf3:".(string)$xmlImmobilie->geo->strasse.":w:".(int)$xmlImmobilie->ausstattung->wg_geeignet.":s:".(int)$xmlImmobilie->ausstattung->seniorengerecht;
                        $immobilie->setGeoStrasse((string) $xmlImmobilie->geo->strasse);
                        $immobilie->setGeoHausnummer((string) $xmlImmobilie->geo->hausnummer);
                        $immobilie->setGeoEtage((string) $xmlImmobilie->geo->etage);
                        $immobilie->setGeoAnzahlEtagen((string) $xmlImmobilie->geo->anzahletagen);
                        $immobilie->setGeoLand((string) $xmlImmobilie->geo->land['iso_land']);
                        $immobilie->setGeoKoordinatenBreitengrad((double) $xmlImmobilie->geo->geokoordinaten['breitengrad']);
                        $immobilie->setGeoKoordinatenLaengengrad((double) $xmlImmobilie->geo->geokoordinaten['laengengrad']);

                        if((double) $xmlImmobilie->preise->kaltmiete){
                            $immobilie->setPreiseKaltmiete((double) $xmlImmobilie->preise->kaltmiete);
                        } elseif((double)$xmlImmobilie->preise->mietpreis_pro_qm){

                            $immobilie->setPreiseKaltmiete((double) $xmlImmobilie->preise->mietpreis_pro_qm);

                        }



                        $immobilie->setPreiseWarmmiete((double) $xmlImmobilie->preise->warmmiete);


                        $immobilie->setPreiseNebenkosten((double) $xmlImmobilie->preise->nebenkosten);


                        $immobilie->setPreiseKaution((double) $xmlImmobilie->preise->kaution);
                        $immobilie->setFlaechenWohnflaeche((double) $xmlImmobilie->flaechen->wohnflaeche);
                        $immobilie->setFlaechenAnzahlZimmer((double) $xmlImmobilie->flaechen->anzahl_zimmer);
                        $immobilie->setFlaechenAnzahlBalkone((double) $xmlImmobilie->flaechen->anzahl_balkone);
                        $immobilie->setFlaechenAnzahlTerassen((double) $xmlImmobilie->flaechen->anzahl_terassen);
                        $immobilie->setFlaechenAnzahlLogia((double) $xmlImmobilie->flaechen->anzahl_logia);


                        $immobilie->setFlaechenSonstflaeche((double) $xmlImmobilie->flaechen->sonstflaeche);
                        $immobilie->setFlaechenVermietbareFlaeche((double) $xmlImmobilie->flaechen->vermietbare_flaeche);
                        $immobilie->setFlaechenGrundstuecksflaeche((double) $xmlImmobilie->flaechen->grundstuecksflaeche);


                        $immobilie->setFlaechenAnzahlGewerbeeinheiten((int) $xmlImmobilie->flaechen->anzahl_gewerbeeinheiten);

                        $immobilie->setFlaechenNutzflaeche((double) $xmlImmobilie->flaechen->nutzflaeche);
                        $immobilie->setFlaechenGesamtflaeche((double) $xmlImmobilie->flaechen->gesamtflaeche);
                        $immobilie->setFlaechenBueroflaeche((double) $xmlImmobilie->flaechen->bueroflaeche);
                        $immobilie->setFlaechenAnzahlBadezimmer((int) $xmlImmobilie->flaechen->anzahl_badezimmer);
                        $immobilie->setFlaechenAnzahlSchlafzimmer((int) $xmlImmobilie->flaechen->anzahl_schlafzimmer);

//echo "<br>durchlauf4:".(string)$xmlImmobilie->geo->strasse.":w:".(int)$xmlImmobilie->ausstattung->wg_geeignet.":s:".(int)$xmlImmobilie->ausstattung->seniorengerecht;


                        $immobilie->setPreiseKaufpreis((double) $xmlImmobilie->preise->kaufpreis);
                        if ((string) $xmlImmobilie->preise->provisionspflichtig == 'true') {
                            $immobilie->setPreiseProvisionspflichtig(true);
                        } else {
                            $immobilie->setPreiseProvisionspflichtig(false);
                        }
                        //achtung feld noch in string ändern
                        $immobilie->setPreiseAussenCourtage((string) $xmlImmobilie->preise->aussen_courtage);


                        if ((string) $xmlImmobilie->preise->aussen_courtage['mit_mwst'] == 'true') {
                            $immobilie->setPreiseAussenCourtageMitMwst(true);
                        } else {
                            $immobilie->setPreiseAussenCourtageMitMwst(false);
                        }


                        $immobilie->setPreiseWaehrungIsoWaehrung((string) $xmlImmobilie->preise->waehrung['iso_waehrung']);

                        $immobilie->setPreiseMwstSatz((double) $xmlImmobilie->preise->mwst_satz);

                        $immobilie->setPreiseMieteinnahmenIst((double) $xmlImmobilie->preise->mieteinnahmen_ist);

                        $immobilie->setPreiseStpFreiplatzAnzahl((int) $xmlImmobilie->preise->stp_freiplatz['anzahl']);


                        $immobilie->setPreiseStpSonstigePlatzart((string) $xmlImmobilie->preise->stp_sonstige['platzart']);
                        $immobilie->setPreiseStpSonstigeAnzahl((int) $xmlImmobilie->preise->stp_sonstige['anzahl']);




                        $immobilie->setZustandBaujahr((string) $xmlImmobilie->zustand_angaben->baujahr);
                        //echo "gaestewc:";
                        // echo (int)$xmlImmobilie->ausstattung->gaestewc1s;
                        //die;

//echo "<br>durchlauf5:".(string)$xmlImmobilie->geo->strasse.":w:".(int)$xmlImmobilie->ausstattung->wg_geeignet.":s:".(int)$xmlImmobilie->ausstattung->seniorengerecht;

                        $immobilie->setAusstattungWggeeignet((int)$xmlImmobilie->ausstattung->wg_geeignet);
                        $immobilie->setAusstattungRaeumeveraenderbar((int) $xmlImmobilie->ausstattung->raeume_veraenderbar);
                        $immobilie->setAusstattungKamin((int) $xmlImmobilie->ausstattung->kamin);
                        $immobilie->setAusstattungKlimatisiert((int) $xmlImmobilie->ausstattung->klimatisiert);
                        $immobilie->setAusstattungGartennutzung((int) $xmlImmobilie->ausstattung->gartennutzung);
                        $immobilie->setAusstattungRollstuhlgerecht((int) $xmlImmobilie->ausstattung->rollstuhlgerecht);
                        $immobilie->setAusstattungKabelsattv((int) $xmlImmobilie->ausstattung->kabel_sat_tv);
                        $immobilie->setAusstattungDvbt((int) $xmlImmobilie->ausstattung->dvbt);
                        $immobilie->setAusstattungBarrierefrei((int) $xmlImmobilie->ausstattung->barrierefrei);
                        $immobilie->setAusstattungSauna((int) $xmlImmobilie->ausstattung->sauna);
                        $immobilie->setAusstattungSwimmingpool((int) $xmlImmobilie->ausstattung->swimmingpool);
                        $immobilie->setAusstattungWaschtrockenraum((int) $xmlImmobilie->ausstattung->wasch_trockenraum);
                        $immobilie->setAusstattungWintergarten((int) $xmlImmobilie->ausstattung->wintergarten);
                        $immobilie->setAusstattungDvverkabelung((int) $xmlImmobilie->ausstattung->dv_verkabelung);
                        $immobilie->setAusstattungRampe((int) $xmlImmobilie->ausstattung->rampe);
                        $immobilie->setAusstattungHebebuehne((int) $xmlImmobilie->ausstattung->hebebuehne);
                        $immobilie->setAusstattungKran((int) $xmlImmobilie->ausstattung->kran);
                        $immobilie->setAusstattungGastterrasse((int) $xmlImmobilie->ausstattung->gastterrasse);
                        $immobilie->setAusstattungKantinecafeteria((int) $xmlImmobilie->ausstattung->kantine_cafeteria);
                        $immobilie->setAusstattungTeekueche((int) $xmlImmobilie->ausstattung->teekueche);
                        $immobilie->setAusstattungBrauereibindung((int) $xmlImmobilie->ausstattung->brauereibindung);
                        $immobilie->setAusstattungSporteinrichtungen((int) $xmlImmobilie->ausstattung->sporteinrichtungen);
                        $immobilie->setAusstattungWellnessbereich((int) $xmlImmobilie->ausstattung->wellnessbereich);
                        $immobilie->setAusstattungTelefonferienimmobilie((int) $xmlImmobilie->ausstattung->telefon_ferienimmobilie);
                        $immobilie->setAusstattungUmtsempfang((int) $xmlImmobilie->ausstattung->umts_empfang);
                        $immobilie->setAusstattungAbstellraum((int) $xmlImmobilie->ausstattung->abstellraum);
                        $immobilie->setAusstattungBibliothek((int) $xmlImmobilie->ausstattung->bibliothek);
                        $immobilie->setAusstattungDachboden((int) $xmlImmobilie->ausstattung->dachboden);
                        $immobilie->setAusstattungGaestewc((int) $xmlImmobilie->ausstattung->gaestewc);
                        $immobilie->setAusstattungKabelkanaele((int) $xmlImmobilie->ausstattung->kabelkanaele);
                        $immobilie->setAusstattungSeniorengerecht((int)$xmlImmobilie->ausstattung->seniorengerecht);
                        $immobilie->setAusstattungFahrradraum((int) $xmlImmobilie->ausstattung->fahrradraum);
                        $immobilie->setAusstattungRolladen((int) $xmlImmobilie->ausstattung->rolladen);


                        $immobilie->setAusstattungHallenhoehe((string) $xmlImmobilie->ausstattung->hallenhoehe);
                        $immobilie->setAusstattungStromanschlusswert((string) $xmlImmobilie->ausstattung->stromanschlusswert);


                        //echo "---:wgfinal:".$immobilie->getAusstattungWggeeignet();

                        /*?><pre><?php print_r($zuordnungArr);?></pre>pre><?php */
                        //print_r($ausstattungBadZuordnung);


                        //achtung laut verständnis der vsd validierung openimmo sind die gebiete eigentlich fest vorgegeben?
                        $immobilie->setGeoLageGebiet('');
                        if(isset($xmlImmobilie->geo))
                            if(isset($xmlImmobilie->geo->lage_gebiet))
                                if(count($xmlImmobilie->geo->lage_gebiet->attributes()))
                                    foreach ($xmlImmobilie->geo->lage_gebiet->attributes() as $k => $v) {
                                        if((string)$k=='gebiete') $immobilie->setGeoLageGebiet((string)$v);
                                    }



                        $tempArr = array();
                        if(isset($xmlImmobilie->geo))
                            if(isset($xmlImmobilie->geo->lage_im_bau))
                                if(count($xmlImmobilie->geo->lage_im_bau->attributes()))
                                    foreach ($xmlImmobilie->geo->lage_im_bau->attributes() as $k => $v) {
                                        if ($v == 'true') {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['geo_lage_im_bau'][$k];
                                        }
                                    }

                        $immobilie->setGeoLageImBau(implode(',', $tempArr));



                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->bad))
                                if(count($xmlImmobilie->ausstattung->bad->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->bad->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_bad'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungBad(implode(',', $tempArr));
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->kueche))
                                if(count($xmlImmobilie->ausstattung->kueche->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->kueche->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_kueche'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungKueche(implode(',', $tempArr));
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->boden))
                                if(count($xmlImmobilie->ausstattung->boden->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->boden->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_boden'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungBoden(implode(',', $tempArr));
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->heizungsart))
                                if(count($xmlImmobilie->ausstattung->heizungsart->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->heizungsart->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_heizungsart'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungHeizungsart(implode(',', $tempArr));
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->befeuerung))
                                if(count($xmlImmobilie->ausstattung->befeuerung->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->befeuerung->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_befeuerung'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungBefeuerung(implode(',', $tempArr));
                        //start
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->fahrstuhl))
                                if(count($xmlImmobilie->ausstattung->fahrstuhl->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->fahrstuhl->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_fahrstuhl'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungFahrstuhl(implode(',', $tempArr));
                        //start
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->stellplatzart))
                                if(count($xmlImmobilie->ausstattung->stellplatzart->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->stellplatzart->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_stellplatzart'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungStellplatzart(implode(',', $tempArr));
                        //start
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->ausricht_balkon_terrasse))
                                if(count($xmlImmobilie->ausstattung->ausricht_balkon_terrasse->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->ausricht_balkon_terrasse->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_ausricht_balkon_terasse'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungAusrichtBalkonTerasse(implode(',', $tempArr));
                        //start
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->angeschl_gastronomie))
                                if(count($xmlImmobilie->ausstattung->angeschl_gastronomie->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->angeschl_gastronomie->attributes() as $k => $v) {
                                        if ($v == 'true') {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_angeschl_gastronomie'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungAngeschlGastronomie(implode(',', $tempArr));
                        //start
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->serviceleistungen))
                                if(count($xmlImmobilie->ausstattung->serviceleistungen->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->serviceleistungen->attributes() as $k => $v) {
                                        if ($v == 'true') {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_serviceleistungen'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungServiceleistungen(implode(',', $tempArr));
                        //start
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->sicherheitstechnik))
                                if(count($xmlImmobilie->ausstattung->sicherheitstechnik->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->sicherheitstechnik->attributes() as $k => $v) {
                                        if ($v == 'true') {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_sicherheitstechnik'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungSicherheitstechnik(implode(',', $tempArr));
                        //start
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->energietyp))
                                if(count($xmlImmobilie->ausstattung->energietyp->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->energietyp->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_energietyp'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungEnergietyp(implode(',', $tempArr));
                        //start
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->ausbaustufe))
                                if(count($xmlImmobilie->ausstattung->ausbaustufe->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->ausbaustufe->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_ausbaustufe'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungAusbaustufe(implode(',', $tempArr));
                        //start
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->bauweise))
                                if(count($xmlImmobilie->ausstattung->bauweise->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->bauweise->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_bauweise'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungBauweise(implode(',', $tempArr));
                        //start
                        $tempArr = array();
                        if(isset($xmlImmobilie->ausstattung))
                            if(isset($xmlImmobilie->ausstattung->dachform))
                                if(count($xmlImmobilie->ausstattung->dachform->attributes()))
                                    foreach ($xmlImmobilie->ausstattung->dachform->attributes() as $k => $v) {
                                        if ($v == 1) {
                                            $tempArr[] = $zuordnungArr['tx_dslimmo_domain_model_immobilie']['ausstattung_dachform'][$k];
                                        }
                                    }
                        $immobilie->setAusstattungDachform(implode(',', $tempArr));
                        //true / false
                        //ausstattung_angeschl_gastronomie
                        //ausstattung_serviceleistungen
                        //ausstattung_sicherheitstechnik
                        if ($xmlImmobilie->zustand_angaben->zustand) {
                            $immobilie->setZustandart($zuordnungArr['tx_dslimmo_domain_model_immobilie']['zustand_art'][(string) $xmlImmobilie->zustand_angaben->zustand['zustand_art']]);
                        } else {
                            $immobilie->setZustandart(0);
                        }

                        $immobilie->setEnergiepassEpart((string) $xmlImmobilie->zustand_angaben->energiepass->epart);
                        $immobilie->setEnergiepassMitwarmwasser((string) $xmlImmobilie->zustand_angaben->energiepass->mitwarmwasser);

                        $immobilie->setEnergiepassPrimaerenergietraeger((string) $xmlImmobilie->zustand_angaben->energiepass->primaerenergietraeger);



                        $immobilie->setEnergiepassenergieverbrauchkennwert((string) $xmlImmobilie->zustand_angaben->energiepass->energieverbrauchkennwert);
                        $immobilie->setEnergiepassendenergiebedarf((string) $xmlImmobilie->zustand_angaben->energiepass->endenergiebedarf);

                        $immobilie->setEnergiepassgebaeudeart((string) $xmlImmobilie->zustand_angaben->energiepass->gebaeudeart);
                        if ((string) $xmlImmobilie->verwaltung_objekt->objektadresse_freigeben != 'false') {
                            $immobilie->setObjektadressefreigeben(true);
                        } else {
                            $immobilie->setObjektadressefreigeben(false);
                        }
                        if ((string) $xmlImmobilie->verwaltung_objekt->haustiere != 'false') {
                            $immobilie->setHaustiere(true);
                        } else {
                            $immobilie->setHaustiere(false);
                        }

                        if ((string) $xmlImmobilie->verwaltung_objekt->vermietet == 'true') {
                            $immobilie->setVermietet(true);
                        } else {
                            $immobilie->setVermietet(false);
                        }
                        if ((string) $xmlImmobilie->verwaltung_objekt->denkmalgeschuetzt == 'true') {
                            $immobilie->setDenkmalgeschuetzt(true);
                        } else {
                            $immobilie->setDenkmalgeschuetzt(false);
                        }
                        $immobilie->setVerfuegbarab((string) $xmlImmobilie->verwaltung_objekt->verfuegbar_ab);

                        //$immobilie->setVermarktungsart($zuordnungArr['tx_dslimmo_domain_model_immobilie']['vermarktungs_art']['MIETE_PACHT']);

                        $immobilie->setObjektArtWohnungTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_wohnung_typ'][(string) $xmlImmobilie->objektkategorie->objektart->wohnung['wohnungtyp']]);

                        $immobilie->setObjektArtZimmerTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_zimmer_typ'][(string) $xmlImmobilie->objektkategorie->objektart->zimmer['zimmertyp']]);
                        $immobilie->setObjektArtHausTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_haus_typ'][(string) $xmlImmobilie->objektkategorie->objektart->haus['haustyp']]);

                        $immobilie->setObjektArtGrundstueckTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_grundstueck_typ'][(string) $xmlImmobilie->objektkategorie->objektart->grundstueck['grundst_typ']]);
                        $immobilie->setObjektArtBueroPraxenTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_buero_praxen_typ'][(string) $xmlImmobilie->objektkategorie->objektart->buero_praxen['buero_typ']]);
                        $immobilie->setObjektArtEinzelhandelTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_einzelhandel_typ'][(string) $xmlImmobilie->objektkategorie->objektart->einzelhandel['handel_typ']]);


                        $immobilie->setObjektArtGastgewerbeTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_gastgewerbe_typ'][(string) $xmlImmobilie->objektkategorie->objektart->gastgewerbe['gastgew_typ']]);
                        $immobilie->setObjektArtHallenLagerProduktionTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_hallen_lager_produktion_typ'][(string) $xmlImmobilie->objektkategorie->objektart->hallen_lager_prod['hallen_typ']]);
                        $immobilie->setObjektArtLandForstwirtschaftTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_land_forstwirtschaft_typ'][(string) $xmlImmobilie->objektkategorie->objektart->land_und_forstwirtschaft['land_typ']]);
                        $immobilie->setObjektArtParkenTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_parken_typ'][(string) $xmlImmobilie->objektkategorie->objektart->parken['parken_typ']]);
                        $immobilie->setObjektArtSonstigeTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_sonstige_typ'][(string) $xmlImmobilie->objektkategorie->objektart->sonstige['sonstige_typ']]);
                        $immobilie->setObjektArtZinshausRenditeobjektTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_freizeitimmobilie_gewerblich_typ'][(string) $xmlImmobilie->objektkategorie->objektart->freizeitimmobilie_gewerblich['freizeit_typ']]);
                        $immobilie->setObjektArtFreizeitimmobilieGewerblichTyp($zuordnungArr['tx_dslimmo_domain_model_immobilie']['objekt_art_zinshaus_renditeobjekt_typ'][(string) $xmlImmobilie->objektkategorie->objektart->zinshaus_renditeobjekt['zins_typ']]);

                        //$immobilie->setObjektartHausHaustyp((string)$xmlImmobilie->objektkategorie->objektart->haus['haustyp']);
                        //kann wieder raus



                        $immobilie->setObjekttitel((string) $xmlImmobilie->freitexte->objekttitel);
                        $immobilie->setDreizeiler((string) $xmlImmobilie->freitexte->dreizeiler);
                        $immobilie->setLage((string) $xmlImmobilie->freitexte->lage);
                        $immobilie->setAusstattbeschr((string) $xmlImmobilie->freitexte->ausstatt_beschr);
                        $immobilie->setObjektbeschreibung((string) $xmlImmobilie->freitexte->objektbeschreibung);
                        $immobilie->setSonstigeangaben((string) $xmlImmobilie->freitexte->sonstige_angaben);
                        //(string)$xmlImmobilie->freitexte->objekt_text //sprache?
                        //$xmlImmobilie->verwaltung_techn
                        $immobilie->setObjektnrintern((string) $xmlImmobilie->verwaltung_techn->objektnr_intern);
                        $immobilie->setObjektnrextern((string) $xmlImmobilie->verwaltung_techn->objektnr_extern);
                        $immobilie->setStandvom(new \DateTime((string) $xmlImmobilie->verwaltung_techn->stand_vom));
                        if ((string) $xmlImmobilie->verwaltung_techn->aktiv_von) {
                            $immobilie->setStarttime(new \DateTime((string) $xmlImmobilie->verwaltung_techn->aktiv_von));
                        } else {
                            $immobilie->setStarttime();
                        }
                        if ((string) $xmlImmobilie->verwaltung_techn->aktiv_bis) {
                            $immobilie->setEndtime(new \DateTime((string) $xmlImmobilie->verwaltung_techn->aktiv_bis));
                        } else {
                            $immobilie->setEndtime();
                        }

                        //   die;
                        //die;
                        //anhang update funktion fehlt noch !!
                        if ($immobilie->getUid()) {
                            //anhänge bei aktualisierung neu setzen
                            foreach ($immobilie->getAnhaenge() as $anhang) {
                                if ($anhang->getDatei()) {
                                    $resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
                                    $fileReferenceObject = $resourceFactory->getFileReferenceObject($anhang->getDatei()->getUid());
                                    $fileWasDeleted = $fileReferenceObject->getOriginalFile()->delete();
                                }
                                $immobilie->setAnhaenge(new \TYPO3\CMS\Extbase\Persistence\ObjectStorage());
                            }
                        }
                        //if (!$immobilie->getUid()) {
                        //echo '<br><br><br><br><br><br><br><br><br><br><br><br>';
                        if(isset($xmlImmobilie->anhaenge))
                            if(isset($xmlImmobilie->anhaenge->anhang))
                                foreach ($xmlImmobilie->anhaenge->anhang as $xmlAnhang) {
                                    $anhang = new \DslFactory\DslImmo\Domain\Model\Anhang();
                                    //echo (string)$xmlAnhang['gruppe'];
                                    if (isset($zuordnungArr['tx_dslimmo_domain_model_anhang']['type'][(string) $xmlAnhang['gruppe']])) {
                                        //	echo "gefunden";
                                        $anhang->setType($zuordnungArr['tx_dslimmo_domain_model_anhang']['type'][(string) $xmlAnhang['gruppe']]);
                                        if ($anhangDatei = $newFileArr[(string) $xmlAnhang->daten->pfad]) {
                                            $anhangDateiReference = $this->objectManager->get('DslFactory\\DslImmo\\Domain\\Model\\FileReference');
                                            $anhangDateiReference->setFile($anhangDatei);
                                            if ((string) $xmlAnhang->anhangtitel) {
                                                $updateFileReferenceTitle[] = array('obj' => $anhangDateiReference, 'field' => 'title', 'value' => (string) $xmlAnhang->anhangtitel);
                                            }
                                            $anhang->setDatei($anhangDateiReference);
                                            $anhangDatei->moveTo($folderAnhaenge);
                                            //$this->addFlashMessage('Anhang ergänzt ' . (string) $xmlAnhang->daten->pfad, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                                            $immobilie->addAnhaenge($anhang);
                                        } else {
                                            mail ( "mz@dsl-factory.de" , "dsl immo Import Nachricht" , "Bitte prüfen: xmlAnhang->datan->pfad: ".print_r((string)$xmlAnhang->daten->pfad,1)." immobilie->getObjektnrextern(): ".$immobilie->getObjektnrextern()."   ".print_r($_SERVER,1)." newFileArr: ".print_r($newFileArr,1));
                                            //mail an dsl
                                        }
                                    }
                                }
                        //}


                        //echo "<br>".$immobilie->getUid();
                        //echo "<br>".$immobilie->getGeoKoordinatenBreitengrad().":".$immobilie->getGeoKoordinatenLaengengrad();
                        if((!$immobilie->getGeoKoordinatenBreitengrad() || !$immobilie->getGeoKoordinatenLaengengrad())
                            && $immobilie->getStrasseHausnummer() && $immobilie->getGeoPlz() && $immobilie->getGeoOrt() ){
                            //echo "<br>Geocode:".$immobilie->getUid();
                            if($geoCoord = \DslFactory\DslImmo\Utility\GeocodeUtility::init()->geocodeAddress($immobilie->getStrasseHausnummer().", ". $immobilie->getGeoPlz().", ".$immobilie->getGeoOrt())){
                                //echo "<br>coord:".print_r($geoCoord,1);
                                $immobilie->setGeoKoordinatenBreitengrad($geoCoord["breitengrad"]);
                                $immobilie->setGeoKoordinatenLaengengrad($geoCoord["laengengrad"]);

                            }
                        }

                        if((!$immobilie->getGeoAdresseGesperrtKoordinatenBreitengrad() || !$immobilie->getGeoAdresseGesperrtKoordinatenLaengengrad())
                            && $immobilie->getGeoOrt() ){
                            //echo "<br>Geocode:".$immobilie->getUid();
                            $adresseArr = array();
                            if($immobilie->getGeoRegionalerZusatz()) $adresseArr[] = $immobilie->getGeoRegionalerZusatz();
                            if($immobilie->getGeoOrt()) $adresseArr[] = $immobilie->getGeoOrt();
                            if($geoCoord = \DslFactory\DslImmo\Utility\GeocodeUtility::init()->geocodeAddress(implode(",",$adresseArr))){
                                //echo "<br>coord:".print_r($geoCoord,1);
                                $immobilie->setGeoAdresseGesperrtKoordinatenBreitengrad($geoCoord["breitengrad"]);
                                $immobilie->setGeoAdresseGesperrtKoordinatenLaengengrad($geoCoord["laengengrad"]);

                            }
                        }


                        $immobilie->refreshSearchVars();
                        if (!$immobilie->getUid()) {

                            $storageSettings = \DslFactory\DslImmo\Utility\SettingsUtility::init()->getSettingBackendFor('storage');
                            if($storageSettings["storagePid"]){
                                $immobilie->setPid($storageSettings["storagePid"]);
                            }

                            $this->immobilieRepository->add($immobilie);
                        } else {
                            //echo "vart:".$immobilie->getVermarktungsArt();
                            //echo "update/uid:".$immobilie->getUid();
                            //die;

                            $this->immobilieRepository->update($immobilie);
                            \DslFactory\DslImmo\Utility\CacheUtility::init()->resetImmobilie($immobilie->getUid());
                        }
                        switch ((string) $xmlImmobilie->verwaltung_techn->aktion['aktionart']) {
                            case 'DELETE':    //$this->addFlashMessage('Immobilie Gelöscht (' . $immobilie->getOpenimmoobid() . ')', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                                $this->deleteImmobilie($immobilie);
                                break;
                            case 'CHANGE':    break;
                        }
                    }

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
                    $xmlFile->delete();


                    if(count($immobilienToDelete)){
                        foreach($immobilienToDelete as $immobilieToDelete){
                            //$this->addFlashMessage('Immobilie Gelöscht da diese Im VollAbgleich Import nicht mehr vorhanden ist (' . $immobilieToDelete->getOpenimmoobid() . ')', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
                            $this->deleteImmobilie($immobilieToDelete);
                        }
                        /*print_r(array_keys($immobilienToDelete));
                            die;*/
                    }
                }
                break;
            }


            //	echo "FERTIG!!!";

            /*	echo ":ion importCommand übergeben ".$fileUid;
            echo $zipFile->getUid();
                if(!$fileUid) echo ":auf import prüfen!!";
                die;
    */







            //$immobilien = $this->immobilieRepository->findAll();
            /*	echo "anzahl:";
                echo count($immobilien);
                die;*/

        }


        //	 $this->addFlashMessage('tasdkjlkj', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);

        //	asldk()
        //echo "importCommand";die;
        //$this->importService->importData();


        //aufräumen!!
        //test jedoch sucht er hier nach uid_foreign und nicht uid_local
        //$fileObjects = $fileRepository->findByRelation('tx_dslimmo_domain_model_anhang', 'datei', $file->getUid());
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
        $this->immobilieRepository->remove($immobilie);
    }
	
	 /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}