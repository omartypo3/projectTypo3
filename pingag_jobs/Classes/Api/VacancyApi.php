<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 19.07.2018
 * Time: 09:31
 */

namespace Pingag\PingagJobs\Api;

class VacancyApi extends PeoplexsApiBase
{
    
    const APPLY_FORM_URL_FORMAT = 'http://api.peoplexs.com/Peoplexs22/CandidatesPortalNoLogin/ApplicationForm.cfm?PortalID=%s&VacatureID=%s';

    protected function getServiceUrl()
    {
        return 'http://api.peoplexs.com//Portalxs/Webservices/v11/vacanciesXS.cfc?wsdl';
    }

    /**
     * @return array
     */
    public function getList()
    {
        // listPublished
        $result = $this->call('listPublished', [
            'PortalID' => (string)$this->portalId,
        ]);

        // set speaking array keys
        $jobs = array_map(function ($job) use ($result) {
            $keyMap = $result->columnList;
            $mappedArray = [];
            foreach ($job as $key => $property) {
                $speakingKey = strtolower($keyMap[$key]);
                $mappedArray[$speakingKey] = $property;
            }
            return $mappedArray;
        }, $result->data);
        return $jobs;
    }
    
    public function getWithLocale($id, $locale, $resolveValues = 1)
    {
        $vacancy = $this->call('getWithLocale', [
            'ID' => $id,
            'ResolveValues' => $resolveValues,
            'Locale' => $locale,
        ]);
        return array_change_key_case($vacancy, CASE_LOWER);
    }
    
    public function findById($id)
    {
        //$this->defaultParameters['SESSIONID'] = $this->sessionId;
        //$this->defaultParameters['SESSIONTYPE'] = 'user';
        
        $vacancy = $this->call('get', [
            'ID' => $id,
            'CRMObject' => 'Vacancies',
            'ResolveValues' => 1
        ]);
        
        $vacancy['applyFormUrl'] = $this->buildApplyFormUrl($vacancy['VacatureID']);
        
        return $vacancy;
    }
    
    protected function buildApplyFormUrl($vacatureId)
    {
        return sprintf(self::APPLY_FORM_URL_FORMAT, $this->portalId, $vacatureId);
    }
    
    public function createApplication($jobId)
    {
        
    }
}