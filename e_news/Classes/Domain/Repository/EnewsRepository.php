<?php
namespace Emagineurs\ENews\Domain\Repository;

use TYPO3\CMS\Core\Http\ServerRequestFactory;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Xavier Ley <xley@e-maginuers.com>, e-magineurs
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

/**
 * The repository for Enews 
 */
class EnewsRepository extends \GeorgRinger\News\Domain\Repository\NewsRepository {
    
    public $arraySearch = ['Subject','MinimumDate','MaximumDate','SameDate','CatEvent','CatEvent2','CatEvent3','CatEvent4','CatEvent5','CityEvent', 'CatEventMultiple','TagsEvent','YoungaudienceEvent','FreeentranceEvent', 'Section'];

    protected $settings = [];
    
    protected $periode;
    
    protected $agenda;
    
    protected $agendaSearch;

    /**
     * Permet d'accéder aux settings dans le repo si appelé dans le controller.
     * Permet également de définir des variables spécifiques à chaque vue via la variable params
     *
     * @param array $settings
     * @param array $params
     * @return void
     */
    public function setSettings($settings, $params = array()){
        $this->settings = $settings;
        
        if(count($params) > 0){
            foreach($params as $key => $value){
                $this->$key = $value;
            }
        }
    }
    
    /**
     * Returns an array of constraints created from a given demand object.
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param \GeorgRinger\News\Domain\Model\DemandInterface $demand
     * @throws UnexpectedValueException
     * @throws InvalidArgumentException
     * @throws Exception
     * @return array<TYPO3\CMS\Extbase\Persistence\QOM\Constraint>
     */
    protected function createConstraintsFromDemand(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query, \GeorgRinger\News\Domain\Model\DemandInterface $demand): array {
        $constraints = parent::createConstraintsFromDemand($query, $demand);
        
        // Handle storage page extension if needed (replaces deprecated extendPidListByChildren)
        if ($demand->getStoragePage() && !empty($this->settings['recursive'])) {
            $pidList = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $demand->getStoragePage(), true);
            $extendedPidList = \Emagineurs\ENews\Utility\PageUtility::extendPidListByChildren(
                implode(',', $pidList),
                (int)($this->settings['recursive'] ?? 0)
            );
            if ($extendedPidList !== $demand->getStoragePage()) {
                $extendedPids = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(',', $extendedPidList, true);
                $constraints['pid'] = $query->in('pid', $extendedPids);
            }
        }
        
        /*** Filtre sur le jour / la semaine / le mois ***/
        if($this->periode){
            $this->getConstraintFromPeriod($constraints,$query);
        }

        if(!empty($this->settings['displayNextNews'])){
            // On récupère la date du jour à minuit
            $todayBegin = date ('d-m-Y');

            // On la transforme en timestamp en ajoutant 86399 soit le nombre de seconde dans une journée -1.
            // On a ainsi la date du jour a 23h59
            $today = strtotime($todayBegin)-1;
        
            $constraints[] = $query->logicalOr($query->greaterThanOrEqual('finishdate', $today), $query->logicalAnd($query->greaterThanOrEqual('begindate', $today), $query->equals('finishdate', '')));
        }
        $context = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class);
     
        if(!empty($this->settings['filterByCurrentUser'])){
            $frontendUserAspect = $context->getAspect('frontend.user');
            $userId = $frontendUserAspect->get('id');
            $constraints["feuser"] = $query->equals('feuser',  $userId );
            $query->getQuerySettings()->setIgnoreEnableFields(TRUE);
        }
        
        if(!empty($this->settings['activeValidation'])){
             $constraints[] = $query->equals('validation', 1);
        }
        
        if(!empty($this->settings['pastCurrentOrFuture'])){         
            switch ($this->settings['pastCurrentOrFuture']) {
                case 'past':
                    $this->getPastNews($constraints,$query);
                    break;
                case 'current':
                    $this->getCurrentNews($constraints,$query);
                    break;
                case 'future':
                    $this->getFutureNews($constraints,$query);
                    break;
            }
        }
                
        // Selection manuelle des news
        if(!empty($this->settings['selectNews'])){
            $newsToDisplay = $this->getNewsUidFromSettings();
            
            $constraints = $query->in('uid',$newsToDisplay);
        }
        
        // Clean not used constraints
        foreach ($constraints as $key => $value) {
            if (is_null($value)) {
                unset($constraints[$key]);
            }
        }
    
        return $constraints;
    }
    
    /**
     * Define the constraint so that it get only news that are finished
     *
     * @param array<TYPO3\CMS\Extbase\Persistence\QOM\Constraint> $constraints
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return void 
     */
    public function getPastNews(&$constraints,$query){           
        // On récupère la date du jour à minuit
        $todayBegin = date ('d-m-Y');

        $today = strtotime($todayBegin);
    
        // On récupère toutes les news dont la date de fin est inférieur a la date courante - autrement dit toutes les news terminées
        $constraints[] = $query->lessThanOrEqual('finishdate', $today);
    }
    
    /**
     * Define the constraint so that it get only news that are currently occurring
     *
     * @param array<TYPO3\CMS\Extbase\Persistence\QOM\Constraint> $constraints
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return void 
     */
    public function getCurrentNews(&$constraints,$query){
        // On récupère la date du jour à minuit
        $todayBegin = date ('d-m-Y');

        $today = strtotime($todayBegin);
        
        // On récupère toutes les news dont la date de fin est supérieur a la date courante - autrement dit toutes les news pas terminées
        $constraints[] = $query->logicalAnd(
            $query->logicalOr(
                $query->greaterThanOrEqual('finishdate', $today),
                $query->equals('finishdate', 0)
            )
        );
    
        // On récupère toutes les news dont la date de début est supérieur a la date courante - autrement dit toutes les news pas encore commencées
        $constraints[] = $query->logicalAnd(
            $query->logicalOr(
                $query->lessThanOrEqual('begindate', $today),
                $query->equals('begindate', 0)
            )
        );
    }
    
    /**
     * Define the constraint so that it get only news that not yet begin
     *
     * @param array<TYPO3\CMS\Extbase\Persistence\QOM\Constraint> $constraints
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return void 
     */
    public function getFutureNews(&$constraints,$query){
        // On récupère la date du jour à minuit
        $todayBegin = date ('d-m-Y');

        $today = strtotime($todayBegin)-1;
    
        // On récupère toutes les news dont la date de début est supérieur a la date courante - autrement dit toutes les news pas encore commencées
        $constraints[] = $query->greaterThanOrEqual('begindate', $today);        
    }
    
    /**
     * get a list of news uid from the settings and push them into an array
     *
     * @return array 
     */
    function getNewsUidFromSettings(){
        $newsToDisplay = explode(',', $this->settings['selectNews'] ?? '');
        
        $tempArray = array();
        foreach($newsToDisplay as $newsUid){
            if(!is_int($newsUid)){
                $uidArray = explode('_',$newsUid);
                $tempArray[] = end($uidArray);
            } else {
                $tempArray[] = $newsUid;
            }
        }
                
        return $tempArray;
    }
    
    /**
     * Add a filter by period to the constraint, the period is determined in the controller and is stored in $this->period 
     *
     * @param array<TYPO3\CMS\Extbase\Persistence\QOM\Constraint> $constraints
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return void 
     */
    function getConstraintFromPeriod(&$constraints, $query){
        switch($this->periode) {
            case 'day':
                // We get the news taking place today
                $constraints[] = $this->getTimestampToday($query);  
                break;
            case 'tomorrow':
                // We get the news taking place tomorrow
                $constraints[] = $this->getTimestampTomorrow($query);
                break;
            case 'week-end':
                // We get the news taking place during the next week-end
                $constraints[] = $this->getTimestampWeekend($query);
                break;
            case 'week':
                // We get the news taking place during the current week
                $constraints[] = $this->getTimestampWeek($query);
                break;
            case 'month':
                // We get the news taking place during the current month or a month determined by a GET parameter
                /** @var \Psr\Http\Message\ServerRequestInterface $request */

                $request = ServerRequestFactory::fromGlobals();
                $getVars = $request->getQueryParams()['tx_enews_pi1'] ?? [];
                $filtreMoisProchains = null;
                if(isset($getVars['filtreMois'])){
                    $filtreMoisProchains = intval($getVars['filtreMois']);
                }

                if($filtreMoisProchains){           
                    // Case where we get the news of a specific month
                    $constraints[] = $this->getMonthWithFilter($query,$filtreMoisProchains);                        
                } else {                            
                    // Case where we get the news of the current month
                    $constraints[] = $this->getCurrentMonth($query);    
                }
                break;
        }
    }

    /**
     * Set a constraint for news that happens today
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return \TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function getTimestampToday($query){
        // We get the current date at midnight
        $beginningOfToday = strtotime(date ('d-m-Y'));

        // We change it to a timestamp and add it 86399, the number of seconds in a day -1.
        // That gives us the current date at 23:59
        $today = $beginningOfToday+86399;

        $constraintsArray = $this->compareDates($beginningOfToday, $today, $query);
        $constraints = $query->logicalAnd(...$constraintsArray);
        return $constraints;
    }

    /**
     * Set a constraint for news that happens today
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return \TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function getTimestampTomorrow($query){
        // We get the date of tomorrow at midnight
        $beginningOfTomorrow = strtotime('tomorrow');

        // We change it to a timestamp and add it 86399, the number of seconds in a day -1.
        // That gives us the date of tomorrow at 23:59
        $endOfTomorrow = strtotime($beginningOfTomorrow)+86399;

        $constraintsArray = $this->compareDates($beginningOfTomorrow, $endOfTomorrow, $query);
        $constraints = $query->logicalAnd(...$constraintsArray);
        return $constraints;
    }

    /**
     * Set a constraint for news that happens today
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return \TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function getTimestampWeekend($query){
        // We get the date of the next monday and then remove 1 second in order to have the sunday of the current week at 23:59
        $endOfWeek = strtotime('next Monday') - 1;
        
        // We get the timestamp of the last saturday
        $beginningOfWeekend = strtotime('last Saturday', $endOfWeek);
        
        $constraintsArray = $this->compareDates($beginningOfWeekend, $endOfWeek, $query);
        $constraints = $query->logicalAnd(...$constraintsArray);   
        
        return $constraints;
    }

    /**
     * Set a constraint for news that happens today
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return \TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function getTimestampWeek($query){
        // We get the "number" of the current day in the week (monday 1, tuesday 2, etc...)
        $numberDay = intval(date('N'));

        // We get the current date at midnight
        $today = strtotime(date('d-m-Y'));
 
        // We get the timestamp corresponding to the current day + the number of days necessary to reach monday (8 - number of the day) 
        // 8 because 7 leads to sunday at 00:00 and we want sunday 23:59, which means we want "monday-1"
        // Then we remove 1 second in order to have sunday at 23:59.
        $endOfWeek = $today+((8-$numberDay)*86400)-1;
        
        // Same principle to get monday
        $beginningOfWeek = $today-(($numberDay-1)*86400);
        
        $constraintsArray = $this->compareDates($beginningOfWeek, $endOfWeek, $query);
        $constraints = $query->logicalAnd(...$constraintsArray);   
        
        return $constraints;
    }

    /**
     * Set a constraint for news that happens today
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param integer $filterNextMonths
     * @return \TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function getMonthWithFilter($query, $filterNextMonths){
        // We get the current month, increased by the value given through the url
        $dateNextMonth = date('m')+$filterNextMonths;

        // We get the timestamp of the first day of the current month
        $tstampNextMonth = mktime(0, 0, 0, $dateNextMonth,1);

        // On récupère le nombre de jour de ce mois -> correspond également au numéro du dernier jour du mois
        // We get the number of days in the current month because it corresponds to the number of the last day
        $numberDaysInMonth = date('t',$tstampNextMonth);

        // We get the timestamp of the last day of the month at 23:59
        $endOfMonth = mktime(0, 0, 0, $dateNextMonth, $numberDaysInMonth)+86399;

        $constantMonth = $this->compareDates($tstampNextMonth, $endOfMonth, $query);
        $constraints = $query->logicalAnd(...$constantMonth);  

        return $constraints;
    }

    /**
     * Set a constraint for news that happens today
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return \TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function getCurrentMonth($query){
        // We get the "number" of the current day in the month (between 1 and 31)
        $numberDay = intval(date('j'));

        // We get the number of days in the current month
        $numberDaysInCurrentMonth = date('t')+1;

        // We get the current date at midnight
        $today = strtotime(date('d-m-Y'));

        // We get the timestamp corresponding to the current date + the number of days necessary to reach the first day of the next month (number of day in the month - number of the current day) 
        // We add 1 to the number of days in the month because we want the first day of the next month at 00:00
        // Then we remove 1 second in order to have the last day of the month at 23:59
        $endOfMonth = $today+(($numberDaysInCurrentMonth-$numberDay)*86400)-1;
        
        // Same principle for the first day of the current month
        $beginningOfMonth = $today-(($numberDay-1)*86400);
                 
        $constraintsArray = $this->compareDates($beginningOfMonth, $endOfMonth, $query);
        $constraints = $query->logicalAnd(...$constraintsArray);   
        
        return $constraints;
    }

    /**
     * Get the search constraints
     *
     * @param integer $beginning
     * @param integer $end
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return array<TYPO3\CMS\Extbase\Persistence\QOM\Constraint>
     */
    public function compareDates($beginning, $end, $query) {
        $dateComparison = [
            $query->logicalOr(
                $query->greaterThanOrEqual('finishdate', $beginning),
                $query->equals('finishdate', 0)
            ),
            $query->logicalOr(
                $query->lessThanOrEqual('begindate', $end),
                $query->equals('begindate', 0)
            ),
            $query->logicalNot(
                $query->logicalAnd(
                    $query->equals('finishdate', 0),
                    $query->equals('begindate', 0)
                )
            )
        ];
        
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($dateComparison, 'TEST $dateComparison');
        return $dateComparison;
    }

    /**
     * Get the search constraints
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param \GeorgRinger\News\Domain\Model\DemandInterface $demand
     * @return array
     * @throws UnexpectedValueException
     */
    protected function getSearchConstraints(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query, \GeorgRinger\News\Domain\Model\DemandInterface $demand): array {

        $constraints = array();
        if ($demand->getSearch() === NULL) {
            return $constraints;
        }

        /* @var $searchObject Emagineurs\ENews\Domain\Model\Dto\Search */
        $searchObject = $demand->getSearch();
        foreach($this->arraySearch as $searchField){
            $getMethod = 'get'.$searchField;
                
            if($searchObject->$getMethod()){
                $this->handleCurrentConstraint($constraints, $searchField, $query, $searchObject);
            }
        }
        
        return $constraints;
    }

    /**
     * Call the right handler for the current search parameter
     *
     * @param array $constraints
     * @param string $searchField
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     *
     * @return void
     */
    public function handleCurrentConstraint(&$constraints, $searchField, $query, $searchObject) {
        $searchMethod = 'handle'.$searchField.'Search';
        $constraintField = $this->$searchMethod($searchObject, $query);
        if($constraintField){
            $constraints[] = $constraintField;
        }
    }

    /**
     * Implement the search by keyword
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     * @throws UnexpectedValueException
     */
    function handleSubjectSearch($searchObject,$query){        
        $searchSubject = $searchObject->getSubject();
        if (!empty($searchSubject)) {
            $searchFields = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $searchObject->getFields(), TRUE);
            $searchConstraints = array();

            if (count($searchFields) === 0) {
                throw new UnexpectedValueException('No search fields defined', 1318497755);
            }

            foreach ($searchFields as $field) {
                if (!empty($searchSubject)) {
                    $searchConstraints[] = $query->like($field, '%' . $searchSubject . '%');
                }
            }

            if (count($searchConstraints)) {
                $constraints = $query->logicalOr(...$searchConstraints);
            }
        }
        return $constraints;
    }

    /**
     * Implement the search by minimum date
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     * @throws UnexpectedValueException
     */
    function handleMinimumDateSearch($searchObject,$query){
        $testSlash = explode('/',$searchObject->getMinimumDate());
        
        if(count($testSlash) > 1){
            $minimumDate = str_replace('/','-',$searchObject->getMinimumDate());
        } else {
            $minimumDate = $searchObject->getMinimumDate();
        }
        
        $miniDate = strtotime($minimumDate);
                
        if ($miniDate) {
            $field = (!empty($this->settings['minDateFieldAlt'])) ? $this->settings['minDateFieldAlt'] : 'finishdate';  
            if (empty($field)) {
                throw new UnexpectedValueException('No date field is defined', 1396348732);
            }
            $constraints = $query->greaterThanOrEqual($field, $miniDate);
        }
        return $constraints;
    }

    /**
     * Implement the search by maximum date
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     * @throws UnexpectedValueException
     */
    function handleMaximumDateSearch($searchObject,$query){
        $testSlash = explode('/',$searchObject->getMaximumDate());
        if(count($testSlash) > 1){
            $maximumDate = str_replace('/','-',$searchObject->getMaximumDate());
        } else {
            $maximumDate = $searchObject->getMaximumDate();
        }
        $maxDate = strtotime($maximumDate);
        if ($maxDate) {
            $field = (!empty($this->settings['maxDateFieldAlt'])) ? $this->settings['maxDateFieldAlt'] : 'begindate';
            if (empty($field)) {
                throw new UnexpectedValueException('No date field is defined', 1396348733);
            }
            $constraints = $query->lessThanOrEqual($field, ($maxDate+60*60*24));
        }
        return $constraints;
    }


    /**
     * Implement the search by maximum date
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     * @throws UnexpectedValueException
     */
    function handleSameDateSearch($searchObject,$query){



        $testSlash = explode('/',$searchObject->getSameDate());
        if(count($testSlash) > 1){
            $sameDate = str_replace('/','-',$searchObject->getSameDate());
        } else {
            $sameDate = $searchObject->getSameDate();
        }
        $sameDateTime = strtotime($sameDate);
        if ($sameDateTime) {
            $fieldBegin = (!empty($this->settings['minDateFieldAlt'])) ? $this->settings['minDateFieldAlt'] : 'begindate';
            $fieldFinish = (!empty($this->settings['maxDateFieldAlt'])) ? $this->settings['maxDateFieldAlt'] : 'finishdate';
            if (empty($fieldBegin)) {
                throw new UnexpectedValueException('No date field is defined', 1396348733);
            }
            if (empty($fieldFinish)) {
                throw new UnexpectedValueException('No date field is defined', 1396348733);
            }

            $constraints = $query->logicalOr(
                $query->logicalAnd(
                    $query->lessThanOrEqual($fieldBegin, ($sameDateTime+(60*60*24))),
                    $query->greaterThanOrEqual($fieldFinish, ($sameDateTime))
                ),
                $query->logicalAnd(
                    $query->equals($fieldFinish, 0),
                    $query->logicalAnd(
                        $query->lessThanOrEqual($fieldBegin, ($sameDateTime+(59*60*24))),
                        $query->greaterThanOrEqual($fieldBegin, ($sameDateTime))
                    )
                )
            );
        }
        return $constraints;
    }



    /**
     * Implement the search by one category
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleCatEventSearch($searchObject,$query){
        $searchCat = $searchObject->getCatEvent();

        // We use the method of news extension to filter by categories
        $searchConstraintsStep = $this->createCategoryConstraint(
            $query,
            $searchCat,
            'and',
            TRUE
        );
        
        return $searchConstraintsStep;
    }

    /**
     * Implement the search by several categories
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleCatEventMultipleSearch($searchObject,$query){
        $searchCatArray = $searchObject->getCatEventMultiple();
        $currentConstraintArray = array();

        // We use the method of news extension to filter by categories
        foreach($searchCatArray as $searchCat){   
            $searchConstraintsStep = $this->createCategoryConstraint(
                $query,
                $searchCat,
                'and',
                TRUE
            );
            $currentConstraintArray[] = $searchConstraintsStep;
        }
        
        $currentConstraint = $query->logicalOr(...$currentConstraintArray);        

        return $currentConstraint;
    }

    /**
     * Implement another search by one category
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleCatEvent2Search($searchObject,$query){
        $searchCat = $searchObject->getCatEvent2();

        // We use the method of news extension to filter by categories
        $searchConstraintsStep = $this->createCategoryConstraint(
            $query,
            $searchCat,
            'and',
            TRUE
        );
        
        return $searchConstraintsStep;
    }

    /**
     * Implement another search by one category
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleCatEvent3Search($searchObject,$query){
        $searchCat = $searchObject->getCatEvent3();

        // We use the method of news extension to filter by categories
        $searchConstraintsStep = $this->createCategoryConstraint(
            $query,
            $searchCat,
            'and',
            TRUE
        );
        
        return $searchConstraintsStep;
    }

    /**
     * Implement another search by one category
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleCatEvent4Search($searchObject,$query){
        $searchCat = $searchObject->getCatEvent4();

        // We use the method of news extension to filter by categories
        $searchConstraintsStep = $this->createCategoryConstraint(
            $query,
            $searchCat,
            'and',
            TRUE
        );
        
        return $searchConstraintsStep;
    }

    /**
     * Implement another search by one category
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleCatEvent5Search($searchObject,$query){
        $searchCat = $searchObject->getCatEvent5();

        // We use the method of news extension to filter by categories
        $searchConstraintsStep = $this->createCategoryConstraint(
            $query,
            $searchCat,
            'and',
            TRUE
        );
        
        return $searchConstraintsStep;
    }

    /**
     * Implement the search by city
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleCityEventSearch($searchObject,$query){
        $searchCity = $searchObject->getCityEvent();
        if($searchCity){
            $searchConstraintsStep = $query->contains('ville',$searchCity);
        }
        
        return $searchConstraintsStep;
    }

    /**
     * Implement the search by tag
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleTagsEventSearch($searchObject,$query){
        $searchTag = $searchObject->getTagsEvent();
        // On utilise la fonction de news de filtre par catégorie (se trouve dans le repository des news)
        if($searchTag){
            $searchConstraintsStep = $query->contains('tags',$searchTag);
        }
        
        return $searchConstraintsStep;
    }

    /**
     * Implement the search by free entrance
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleFreeentranceEventSearch($searchObject,$query){
        $searchFree = $searchObject->getFreeentranceEvent();
        if($searchFree){
            $searchConstraintsStep = $query->equals('freeentrance',$searchFree);
        }
        
        return $searchConstraintsStep;
    }

    /**
     * Implement the search by young audience
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleYoungaudienceEventSearch($searchObject,$query){
        $searchYoung = $searchObject->getYoungaudienceEvent();
        if($searchYoung){
            $searchConstraintsStep = $query->equals('youngaudience',$searchYoung);
        }
        return $searchConstraintsStep;
    }

    /**
     * Implement the search by young audience
     *
     * @param \Emagineurs\ENews\Domain\Model\Dto\Search $searchObject
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return \TYPO3\CMS\Extbase\Persistence\QOM\Constraint
     */
    function handleSectionSearch($searchObject, $query) {
        $section = $searchObject->getSection();
        if ($section) {
            $searchConstraints = $query->equals('section', (int)$section);
        }
        return $searchConstraints;
    }

    /**
     * Find FileReference objects by relation to other records
     *
     * @param int $uid The UID of the related record (needs to be the localized uid, as translated IRRE elements relate to them)
     * @return \Emagineurs\ENews\Domain\Model\Enews
     */
    public function findHiddenByUid($uid) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(TRUE);
        $query->getQuerySettings()->setEnableFieldsToBeIgnored(array('disabled'));
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->matching($query->equals('uid', $uid));
        return $query->execute()->getFirst();
    }
    
}