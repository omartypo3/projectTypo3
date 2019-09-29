<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 06.08.2018
 * Time: 13:34
 */

namespace Pingag\PingagJobs\Service;

use Pingag\PingagJobs\Api\PicklistApi;
use Pingag\PingagJobs\Api\VacancyApi;
use Pingag\PingagJobs\Domain\Model\Property;
use Pingag\PingagJobs\Domain\Model\Vacancy;
use Pingag\PingagJobs\Domain\Repository\PropertyRepository;
use Pingag\PingagJobs\Domain\Repository\VacancyRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class PeopleXsConnectorService
{

    const APPLY_FORM_URL_FORMAT = 'https://ssl1.peoplexs.com/Peoplexs22/CandidatesPortalNoLogin/ApplicationForm.cfm?PortalID=%s&VacatureID=%s';

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @var \Pingag\PingagJobs\Domain\Repository\VacancyRepository
     */
    protected $vacancyRepository;

    /**
     * @var \Pingag\PingagJobs\Domain\Repository\PropertyRepository
     */
    protected $propertyRepository;

    protected $portals = [
        0 => 13597,
        1 => 15807,
    ];

    protected $portalId;
    protected $languageUid;

    protected $vacancyMapping = [
        'title' => 'naam',
        'validFrom' => 'datumstart',
        'intro' => 'einleitung1',
        'tasks' => 'hauptaufgaben2',
        'profile' => 'ihrprofil2',
        'offer' => 'unserangebot',
        'location' => 'standplaats',
        'contact' => 'contactinformation',
        'importId' => 'vacatureid',
        'section' => 'stellentyp',
        'city' => 'location',
        'type' => 'vacancytype',
    ];
    
    

    protected $propertyMapping = [
        'section' => 'Stellentyp',
        'type' => 'Vacancytype',
        'city' => 'Arbeitsort'
    ];

    protected $propertyCache = [];

    public function update()
    {
        
        // truncate vacancy+property table
        $this->truncate('tx_pingag_jobs_domain_model_vacancy');
        $this->truncate('tx_pingag_jobs_domain_model_property');
        //$this->markAllEntriesDeleted('tx_pingag_jobs_domain_model_vacancy');
        //$this->markAllEntriesDeleted('tx_pingag_jobs_domain_model_property');

        // update vacancies + properties from all registered portals
        foreach ($this->portals as $languageUid => $portalId){
            $this->portalId = $portalId;
            $this->languageUid = $languageUid;

            $this->updateProperties();
            $this->updateVacancies();
            
            $this->propertyCache = [];
        }

        //$this->removeDeletedEntries('tx_pingag_jobs_domain_model_vacancy');
        //$this->removeDeletedEntries('tx_pingag_jobs_domain_model_property');

        return true;
    }

    /**
     * PeopleXsConnectorService constructor.
     */
    public function __construct()
    {
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $this->persistenceManager = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface');

        $this->vacancyRepository = $this->objectManager->get(VacancyRepository::class);
        $this->propertyRepository = $this->objectManager->get(PropertyRepository::class);
    }

    public function updateVacancies()
    {
        /** @var VacancyApi $jobApi */
        $vacancyApi = GeneralUtility::makeInstance('Pingag\\PingagJobs\\Api\\VacancyApi', $this->portalId);
       /* \TYPO3\CMS\Core\Utility\DebugUtility::debug("old ");
            \TYPO3\CMS\Core\Utility\DebugUtility::debug($vacancyApi->getList() );*/
        foreach ($vacancyApi->getList() as $key=>$vacancy) {
          
            $id = $vacancy['vacatureid'];
            $vacancy = $vacancyApi->getWithLocale(
                $id,
                $this->getLocale(),
                false
            );
            $vacancyObject = $this->convertVacancy($vacancy);
            $this->vacancyRepository->add($vacancyObject);
            $this->persistenceManager->persistAll();
        }

    }

    /**
     * @param array $vacancy
     * @return Vacancy
     * @throws \Exception
     */
    protected function convertVacancy(array $vacancy)
    {
        $vacancyObject = new Vacancy();
        // convert string properties
        foreach ($this->vacancyMapping as $propertyLocal => $propertyOriginal){
            $setter = 'set' . $propertyLocal;
            if(method_exists($vacancyObject, $setter)){
                if(isset($vacancy[$propertyOriginal])){
                    $value = $vacancy[$propertyOriginal];
                    $vacancyObject->$setter($value);
                    
                }
            } else{
                throw new \Exception("The following property and/or it's setter method does not exists: {$propertyLocal}");
            }
        }
        
        if($vacancy['vacancytype'] == '103961') {
            $val =14;
        }
        elseif($vacancy['vacancytype'] == '103962'){
            $val =15;
        }
        elseif($vacancy['vacancytype'] == '118664'){ 
            $val=16;
        }
        // convert relation properties
        
        $vacancyObject->setType($val);
        $vacancyObject->setSection($this->propertyCache['section'][$vacancy['stellentyp']]);
        $vacancyObject->setCity($this->propertyCache['city'][$vacancy['location']]);

        // set language uid
        $vacancyObject->_setProperty('_languageUid', $this->languageUid);
        $vacancyObject->setApplyFormUrl($this->buildApplyFormUrl($vacancy['vacatureid']));
        $vacancyObject->setValidFrom($vacancy['datumstart']);

        return $vacancyObject;
    }

    protected function buildApplyFormUrl($vacatureId)
    {
        return sprintf(self::APPLY_FORM_URL_FORMAT, $this->portalId, $vacatureId);
    }


    /**
     * @return bool
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function updateProperties()
    {
        /** @var PicklistApi $jobApi */
        $picklistApi = GeneralUtility::makeInstance('Pingag\\PingagJobs\\Api\\PicklistApi', $this->portalId);

        foreach ($this->propertyMapping as $propertyType => $pickListName) {
            
            $options = $picklistApi->getListOptions($pickListName, $this->getLocale());
        
            foreach ($options as $id=>$option){
                if(empty($option)){
                    continue;
                }
               
                $property = new Property();
                $property->setType($propertyType);
                $property->setValue($option);
                $property->setImportId($id);
                $property->_setProperty('_languageUid', $this->languageUid);

                $this->propertyRepository->add($property);
                $this->persistenceManager->persistAll();
                
                // set l10n_parent if necessary
                $this->handleLanguageParent($property, $id, 'tx_pingag_jobs_domain_model_property');
               
                // create property cache for vacancies
                $this->propertyCache[$propertyType][$option] = $property->getUid();
            }
        }
        
        return true;
    }

    /**
     * Static map of languageUids and locales
     * @return string
     */
    protected function getLocale()
    {
        switch ($this->languageUid){
            case 0: $locale = 'de';
                break;

            case 1: $locale = 'fr';
                break;

            case 2: $locale = 'en';
                break;

            default: $locale = 'de';
                break;
        }
        return $locale;
    }

    /**
     * @param AbstractEntity $object
     * @param $importId
     * @param $table
     * @throws \Exception
     */
    protected function handleLanguageParent(AbstractEntity $object, $importId, $table)
    {
        if($this->languageUid !== 0){
            $parent = $this->propertyRepository->findByImportId($importId);
            if($parent->count() > 1){
                throw new \Exception("More than one parent found with import_id: {$importId}");
            }
            if($parent->count() == 0){
                throw new \Exception("No parent found with import_id: {$importId}");
            }
            
            $this->setL10nParent(
                $table,
                $object->getUid(),
                $parent->getFirst()->getUid()
            );
        }
    }

    protected function setL10nParent($table, $uid, $parentUid)
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable($table)
            ->update($table, ['l10n_parent' => $parentUid], ['uid' => $uid]);
    }


    protected function markAllEntriesDeleted($table)
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable($table)
            ->update($table, ['deleted' => 1], ['deleted' => 0]);
    }

    protected function removeDeletedEntries($table)
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable($table)
            ->delete($table, ['deleted' => 1]);
    }

    /**
     * @param $table
     * @return int
     */
    protected function truncate($table)
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable($table)
            ->truncate($table);
    }
}