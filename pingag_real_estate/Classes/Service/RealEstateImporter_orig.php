<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 30.07.2018
 * Time: 08:25
 */

namespace Pingag\PingagRealEstate\Service;

use Pingag\PingagRealEstate\Domain\Model\FileReference;
use Pingag\PingagRealEstate\Domain\Model\RealEstate;
use Pingag\PingagRealEstate\Domain\Repository\RealEstateRepository;
use Pingag\PingagRealEstate\Util\TableUtility;
use TYPO3\CMS\Core\Localization\Exception\FileNotFoundException;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RealEstateImporter
{
    const REAL_ESTATE_IMPORT_DIR = 'real-estate-import';
    
    const IGNORE_PROPERTIES = [
        'volume',
        'gross_premium',
        'swimmingpool'
    ];
    
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * @var \Pingag\PingagRealEstate\Domain\Repository\RealEstateRepository
     * @inject
     */
    protected $realEstateRepository;

    /**
     * @var \Pingag\PingagRealEstate\Service\RealEstateFalFileFactory
     * @inject
     */
    protected $falFileFactory;

    /** @var string */
    protected $importSource;

    /** @var int */
    protected $totalItems = 0;
    /** @var int */
    protected $finishedItems = 0;

    protected function setup()
    {
        $this->objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $this->realEstateRepository = $this->objectManager->get('Pingag\PingagRealEstate\Domain\Repository\RealEstateRepository');
        $this->persistenceManager = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');
        $this->falFileFactory = $this->objectManager->get('Pingag\PingagRealEstate\Service\RealEstateFalFileFactory');
        self::resetProgress();
    }

    /**
     * @param string $importSource
     * @return bool
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function run($importSource)
    {
        $this->setup();
        $this->removeAllRealEstates();

        $sources = explode(',', $importSource);
        $this->setTotalItems($sources);
        
        foreach($sources as $source) {
            $this->importSource = self::REAL_ESTATE_IMPORT_DIR. '/' . $source;

            $importFile = $this->getImportFilePath($source);
            $items = $this->parseCsvFile($importFile);

            foreach ($items as $properties) {
                $this->createRealEstate($properties);
                $this->finishedItems = $this->finishedItems + 1;
                $this->updateProgressFile();
            }
            
            //$this->cleanImportFolder();
        }

        return true;
    }


    ////// main actions

    protected function removeAllRealEstates()
    {
        $realEstateTable = 'tx_pingag_real_estate';
        TableUtility::truncate($realEstateTable);
        TableUtility::delete('sys_file_reference', "tablenames = '{$realEstateTable}'");

        $this->falFileFactory->cleanUpTargetFolder();
    }

    protected function createRealEstate(array $properties)
    {
        $realEstate = new RealEstate();

        // build property array
        $propertyKeys = $this->getIdxArrayKeys();
        $properties = array_slice($properties, 0, count($propertyKeys));
        $properties = array_combine($propertyKeys, $properties);

        // fill simple properties
        $this->fillProperties($realEstate, $properties);
        // calculate and set price
        $realEstate->calculatePrice();
        
        // persists realEstate
        $this->realEstateRepository->add($realEstate);
        $this->persistenceManager->persistAll();

        $this->addFalFiles($realEstate, $properties, 'picture_', 'pictures', 'images');
        $this->addFalFiles($realEstate, $properties, 'document_', 'documents', 'doc');
    }

    protected function fillProperties(RealEstate $realEstate, array &$properties)
    {
        foreach ($properties as $property => $value) {
            if ($this->isFileProperty($property) || $this->ignoreProperty($property)) {
                continue;
            }

            $setterMethod = $this->setterMethod($property);
            if (!empty($value)) {
                // skip picture properties, handle after persistence
                if (method_exists($realEstate, $setterMethod)) {
                    $value = self::formatValue($value);
                    $realEstate->$setterMethod($value);
                } else {
                    $this->missing[] = $property;
                    //throw new \Exception("Missing Property/Setter on RealEstate Entity: '{$property}'");
                }
            }
            unset($properties[$property]);
        }
    }

    protected function addFalFiles(RealEstate $realEstate, array &$properties, $propertyIdentifier, $fieldName, $sourceFolder)
    {
        foreach ($properties as $property => $value) {
            if ($this->isFileTitlePropery($property) || strpos($property, $propertyIdentifier) === false) {
                continue;
            }

            $titleKey = str_replace('_filename', '_title', $property);
            $title = null;
            if (isset($properties[$titleKey])) {
                $title = self::formatValue($properties[$titleKey]);
            }

            $sourcePath = $this->importSource . '/' . $sourceFolder . '/';
            // add fal file
            $this->falFileFactory->addRealEstateFalFile(
                $realEstate,
                $value,
                $sourcePath,
                $title,
                $fieldName
            );
        }

        if ($this->falFileFactory->missingFiles) {
            //var_dump($this->falFileFactory->missingFiles);
            //die;
        }
    }

    protected function ignoreProperty($prop)
    {
        return in_array($prop, self::IGNORE_PROPERTIES);
    }

    public function cleanImportFolder()
    {
        $resourceFactory = ResourceFactory::getInstance();
        $storage = $resourceFactory->getStorageObject(0);

        $importFolder = $storage->getFolder($this->importSource);
        $folders = $importFolder->getSubfolders();
        foreach ($folders as $folder) {
            $name = $folder->getName();
            $folder->delete();
            $importFolder->createFolder($name);
        }
    }


    ////// progress handling

    protected function setTotalItems(array $sources)
    {
        foreach ($sources as $source) {
            $importFile = $this->getImportFilePath($source);
            $items = $this->parseCsvFile($importFile);
            $this->totalItems += count($items);
        }
    }

    public function getTotalItems()
    {
        return $this->totalItems;
    }
    
    protected static function progressFilePath()
    {
        return PATH_site . self::REAL_ESTATE_IMPORT_DIR . '/progress.txt';
    }

    protected function updateProgressFile()
    {
        file_put_contents(self::progressFilePath(), $this->totalItems . ',' . $this->finishedItems);
    }
    
    public static function getProgress()
    {
        if(!is_file(self::progressFilePath())){
            file_put_contents(self::progressFilePath(), '0,0');
        }
        
        $data = file_get_contents(self::progressFilePath());
        $progress = explode(',', $data);
        $onePercent = ($progress[0] / 100);
        if(!$onePercent){
            return 0;
        }
        return $progress[1] / $onePercent;
    }
    
    public static function resetProgress()
    {
        file_put_contents(self::progressFilePath(), '0,0');
    }
    
    
    ////// helper functions

    protected function isFileProperty($prop)
    {
        return strpos($prop, 'picture_') !== false || strpos($prop, 'document_') !== false;
    }

    protected function isFileTitlePropery($prop)
    {
        return $this->isFileProperty($prop) && strpos($prop, '_title');
    }

    protected static function formatValue($value)
    {
        $value = utf8_encode($value);

        // Y/N to boolean
        if (strlen($value) === 1) {
            if (strpos($value, 'Y') === 0) {
                $value = 1;
            } elseif (strpos($value, 'N') === 0) {
                $value = 0;
            }
        }
        return $value;
    }

    protected function getIdxArrayKeys()
    {
        $keyList = 'version,sender_id,object_category,object_type,offer_type,ref_property,ref_house,ref_object,object_street,object_zip,object_city,object_state,object_country,region,object_situation,available_from,object_title,object_description,selling_price,rent_net,rent_extra,price_unit,currency,gross_premium,floor,number_of_rooms,number_of_apartments,surface_living,surface_property,surface_usable,volume,year_built,prop_view,prop_fireplace,prop_cabletv,prop_elevator,prop_child-friendly,prop_parking,prop_garage,prop_balcony,prop_roof_floor,distance_public_transport,distance_shop,distance_kindergarten,distance_school1,distance_school2,picture_1_filename,picture_2_filename,picture_3_filename,picture_4_filename,picture_5_filename,picture_1_title,picture_2_title,picture_3_title,picture_4_title,picture_5_title,picture_1_description,picture_2_description,picture_3_description,picture_4_description,picture_5_description,movie_filename,movie_title,movie_description,document_filename,document_title,document_description,url,agency_id,agency_name,agency_name_2,agency_reference,agency_street,agency_zip,agency_city,agency_country,agency_phone,agency_mobile,agency_fax,agency_email,agency_logo,visit_name,visit_phone,visit_email,visit_remark,publish_until,destination,picture_6_filename,picture_7_filename,picture_8_filename,picture_9_filename,picture_6_title,picture_7_title,picture_8_title,picture_9_title,picture_6_description,picture_7_description,picture_8_description,picture_9_description,picture_1_url,picture_2_url,picture_3_url,picture_4_url,picture_5_url,picture_6_url,picture_7_url,picture_8_url,picture_9_url,distance_motorway,ceiling_height,hall_height,maximal_floor_loading,carrying_capacity_crane,carrying_capacity_elevator,isdn,wheelchair_accessible,animal_allowed,ramp,lifting_platform,railway_terminal,restrooms,water_supply,sewage_supply,power_supply,gas_supply,municipal_info,own_object_url,billing_anrede,billing_first_name,billing_name,billing_company,billing_street,billing_post_box,billing_zip,billing_place_name,billing_land,billing_phone_1,billing_phone_2,billing_mobile,billing_language,publishing_id,delivery_id,picture_10_filename,picture_11_filename,picture_12_filename,picture_13_filename,picture_10_title,picture_11_title,picture_12_title,picture_13_title,picture_10_description,picture_11_description,picture_12_description,picture_13_description,picture_10_url,picture_11_url,picture_12_url,picture_13_url,commission_sharing,commission_own,commission_partner,agency_logo_2,number_of_floors,year_renovated,flat_sharing_community,corner_house,middle_house,building_land_connected,gardenhouse,raised_ground_floor,new_building,old_building,under_building_laws,under_roof,swimmingpool,minergie_general,minergie_certified,last_modified,advertisement_id,sparefield_1,sparefield_2,sparefield_3,sparefield_4';
        return explode(',', $keyList);
    }

    protected function setterMethod($property)
    {
        $property = str_replace('-', '_', $property);
        if (strpos($property, '_') === false) {
            $property = ucfirst($property);
        } else {
            $property = str_replace('_', '', ucwords($property, '_'));
        }
        return 'set' . $property;
    }

    protected function parseCsvFile($path)
    {
        $objects = array();
        $fp = fopen($path, 'rb');
        while (!feof($fp)) {
            if ($object = fgetcsv($fp, 0, '#')) {
                $objects[] = $object;
            }
        }
        fclose($fp);
        return $objects;
    }

    public function getImportFilePath($importSource)
    {
        $lastChar = strlen($importSource) - 1;
        if (strpos($importSource, '/') !== $lastChar) {
            $importSource .= DIRECTORY_SEPARATOR;
        }
        return PATH_site . self:: REAL_ESTATE_IMPORT_DIR . '/' . $importSource . 'data/unload.txt';
    }

    /**
     * @return string
     */
    public function getImportSource()
    {
        return $this->importSource;
    }
}