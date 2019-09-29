<?php
namespace FRONTAL\FagInstitutionManagement\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Roland Kneubühler <rk@afrontal.ch>, Agentur Frontal AG
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

use FRONTAL\FagInstitutionManagement\Domain\Model\User;
use FRONTAL\FagInstitutionManagement\Domain\Model\Role;
use PhpParser\Node\Stmt\Foreach_;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;
use FRONTAL\FagInstitutionManagement\Property\TypeConverter\UploadedFileReferenceConverter;
use Doctrine\DBAL\Portability\Statement;

/**
 *
 *
 * @package fag_institution_management
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class InstitutionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * eventRepository
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository;

    /**
     * userRepository
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\UserRepository
     * @inject
     */
    protected $userRepository;

    /**
     * roleRepository
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\RoleRepository
     * @inject
     */
    protected $roleRepository;

    /**
     * categoryRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * linkRepository
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\LinkRepository
     * @inject
     */
    protected $linkRepository;

    /**
     * sessionStorageService
     *
     * @var \FRONTAL\FagExtbase\Service\SessionStorageService
     * @inject
     */
    protected $sessionStorageService;

    /**
     * institutionRepository
     *
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\InstitutionRepository
     * @inject
     */
    protected $institutionRepository;

    /**
     * listPersonService
     *
     * @var \FRONTAL\FagInstitutionManagement\Service\ListPersonService
     * @inject
     */
    protected $listPersonService;

    /**
     * action roleUpdate
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Role|null $role
     */
    public function roleUpdateAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Role $role = null)
    {
        //
        //DebugUtility::debug($this->request);die;


        if (empty($this->request->getArgument('roleid'))) {
            $updatedrole = new Role();
        } else {
            $updatedrole = $this->roleRepository->findByUid((int)$this->request->getArgument('roleid'));

        }
        $institution = $this->institutionRepository->findByUid((int)$this->request->getArgument('instid'));

        //DebugUtility::debug($this->request);
        // die();
        $updatedrole->setUser($role->getUser());
        $updatedrole->setInstitution($institution);
        if ($this->request->hasArgument('show')) {
            $updatedrole->setShowInRegister($this->request->getArgument('show'));
        } else {
            $updatedrole->setShowInRegister(0);
        }
        $updatedrole->setTitle($this->request->getArgument('title'));
        $updatedrole->setEmail($this->request->getArgument('email'));
        $updatedrole->setPhone($this->request->getArgument('phone'));
        $updatedrole->setMobile($this->request->getArgument('mobile'));
        $updatedrole->setAddress($this->request->getArgument('address'));
        $updatedrole->setZip($this->request->getArgument('zip'));
        $updatedrole->setCity($this->request->getArgument('city'));

        if ($this->request->hasArgument('hideEmail')) {
            $updatedrole->setHideEmail(true);
           // $updatedrole->setEmail($this->request->getArgument('user-mail'));
        } else {
            $updatedrole->setHideEmail(false);
        }
        if ($this->request->hasArgument('hidePhone')) {
            $updatedrole->setHidePhone(true);
        } else {
            $updatedrole->setHidePhone(false);
        }
        if ($this->request->hasArgument('hideMobile')) {
            $updatedrole->setHideMobile(true);
        } else {
            $updatedrole->setHideMobile(false);
        }
        if ($this->request->hasArgument('hideAddress')) {
            $updatedrole->setHideAddress(true);
        } else {
            $updatedrole->setHideAddress(false);
        }
        if ($this->request->hasArgument('hideZip')) {
            $updatedrole->setHideZip(true);
        } else {
            $updatedrole->setHideZip(false);
        }
        if ($this->request->hasArgument('hideCity')) {
            $updatedrole->setHideCity(true);
        } else {
            $updatedrole->setHideCity(false);
        }
        //DebugUtility::debug($updatedrole);die;
        if (empty($this->request->getArgument('roleid'))) {
            $this->roleRepository->add($updatedrole);
        } else {
            $this->roleRepository->update($updatedrole);
        }

        $assignedValues = [
            'institution' => $institution->getUid()
        ];
        $this->redirect('nextStep', $this->controllerName, $this->extensionName, $assignedValues, $this->settings['meinedatenverwalten']);

    }

    /**
     * action list
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\InstitutionFilter $institutionFilter
     * @param boolean institutionFilterReset
     * @return void
     * @dontverifyrequesthash
     */
    public function listAction($institutionFilter = NULL, $institutionFilterReset = NULL)
    {

        // check if a single institution is selected
        if ($this->settings['singleInstitution']) {
            $this->redirect('show', NULL, NULL, array('institutionUids' => $this->settings['singleInstitution']));
        }

        // prepare institution filter
        $institutionFilter = $this->prepareFilter($institutionFilter, $institutionFilterReset, 'institutionFilter');
        // limit
        if ((int)$this->settings['listInstitution']['limit']) {
            $institutionFilter->setLimit((int)$this->settings['listInstitution']['limit']);
        }

        if ($institutionFilter->getSearchCategory1()) {
            $this->view->assign('searchCategorie', $this->categoryRepository->findByUid($institutionFilter->getSearchCategory1())->getTitle());
        }

        $this->view->assign('institutions', $this->institutionRepository->findByFilter($institutionFilter));
        $this->view->assign('institutionFilter', $institutionFilter);

        // categories
        $this->categoryRepository->setDefaultOrderings(array(
            'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
        ));

        // actual date
        $this->view->assign('actualDate', new \DateTime());

        $this->view->assign('categories1', $this->categoryRepository->findByParent(max(0, $this->settings['categories1']['parentCategory'])));
        $this->view->assign('categories2', $this->categoryRepository->findByParent(max(0, $this->settings['categories2']['parentCategory'])));
        $this->view->assign('categories3', $this->categoryRepository->findByParent(max(0, $this->settings['categories3']['parentCategory'])));
    }

    /**
     * action show
     *
     * @param string $institutionUids
     * @return void
     */
    public function showAction($institutionUids = '')
    {

        if (empty($institutionUids) && $this->settings['singleInstitution']) {
            $institutionUids = $this->settings['singleInstitution'];
        }

        $institutions = [];

        if (preg_match('/^\d/', $institutionUids)) {

            // only institutions are available
            // no content elements
            foreach (explode(',', $institutionUids) as $institution) {
                $institutions[] = $this->institutionRepository->findByUid($institution);
            }
        } else {

            // if an institution is available over the get param
            // links are shown in personsregister
            if (array_key_exists('institution', $this->request->getArguments()) && $institutionUids == '') {
                unset($institutions);
                $institutions = [$this->institutionRepository->findByUid($this->request->getArgument('institution'))];
            } else {

                // no institution is get over the get param
                // content elements are selected in the plugin
                $flexformContentArray = explode(',', $institutionUids);

                foreach ($flexformContentArray as $flexformContent) {
                    if (preg_match('(tx_faginstitutionmanagement_domain_model_institution_)', $flexformContent)) {
                        $institutions[] = $this->institutionRepository->findByUid(substr($flexformContent, 53));
                    } else {
                        $conf = [
                            'tables' => 'tt_content',
                            'source' => substr($flexformContent, 11),
                            'dontCheckPid' => 1
                        ];
                        $institutions[] = $GLOBALS['TSFE']->cObj->cObjGetSingle('RECORDS', $conf);
                    }
                }
            }
        }

        // actual date
        $this->view->assign('actualDate', new \DateTime());

        $this->view->assign('institutions', $institutions);
        $this->view->assign('institutionCount', count($institutions));
    }

    /**
     * action specialShow
     * @param string $institutionUid
     * @return void
     */
    public function specialShowAction($institutionUid = '')
    {

        $institutions = [];

        if ($this->settings['singleInstitution']) {
            $flexformContentArray = explode(',', $this->settings['singleInstitution']);

            foreach ($flexformContentArray as $flexformContent) {
                if (preg_match('(tx_faginstitutionmanagement_domain_model_institution_)', $flexformContent)) {
                    $institutions[] = $this->institutionRepository->findByUid(substr($flexformContent, 53));
                } else {
                    $conf = [
                        'tables' => 'tt_content',
                        'source' => substr($flexformContent, 11),
                        'dontCheckPid' => 1
                    ];
                    $institutions[] = $GLOBALS['TSFE']->cObj->cObjGetSingle('RECORDS', $conf);
                }
            }
        }

        $this->view->assign('institutions', $institutions);
        $this->view->assign('institutionCount', count($institutions));
        $this->view->assign('actionMethodName', $this->actionMethodName);
    }

    /**
     * action listPeople
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\InstitutionFilter $peopleFilter
     * @param boolean institutionFilterReset
     * @return void
     * @dontverifyrequesthash
     */
    public function listPeopleAction($peopleFilter = NULL, $peopleFilterReset = NULL)
    {
        // prepare people filter
        $peopleFilter = $this->prepareFilter($peopleFilter, $peopleFilterReset, 'peopleFilter');

        if ($peopleFilter->getSearchInstitution()) {
            $this->view->assign('searchInstitution', $this->institutionRepository->findByUid($peopleFilter->getSearchInstitution())->getTitle());
        }

        $this->view->assign('peoples', $this->listPersonService->clearList($this->userRepository->findByFilter($peopleFilter)));
        $this->view->assign('peopleFilter', $peopleFilter);
        $this->view->assign('institutions', $this->institutionRepository->findAll());
    }

    public function updateSortingAction()
    {

        $i = 1;

        foreach ($this->request->getArgument('users') as $user) {
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_faginstitutionmanagement_fe_users_institution_mm', 'uid_foreign=' . (int)$user . ' and uid_local =' . (int)$GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid"), array(
                'sorting' => $i,
                'sorting_foreign' => $i,

            ));
            $i++;
        }
    }

    /**
     * action listCitycouncil
     *
     * @return void
     * @dontverifyrequesthash
     *
     */
    public function listCitycouncilAction()
    {
        if ($GLOBALS["TSFE"]->id == $this->settings['listPeople']['deputyUid']) {
            $this->view->assign('peoples', $this->userRepository->findCityCouncil($this->settings['showCityCouncil']['pid'], $this->settings['showCityCouncil']['respectStoragePage'], TRUE));
        } else {
            $this->view->assign('peoples', $this->userRepository->findCityCouncil($this->settings['showCityCouncil']['pid'], $this->settings['showCityCouncil']['respectStoragePage']));
        }
    }

    /**
     * action listLinks
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\InstitutionFilter $linksFilter
     * @param boolean $linksFilterReset
     * @return void
     * @dontverifyrequesthash
     */
    public function listLinksAction($linksFilter = NULL, $linksFilterReset = NULL)
    {
        //$allAvailableCategories = $this->categoryRespoitory->findByPid(56);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($allAvailableCategories);

        //$this->view->assign('institutions', $this->institutionRepository->findByLinks());

        // prepare links filter
        $linksFilter = $this->prepareFilter($linksFilter, $linksFilterReset, 'linksFilter');

        $this->view->assign('institutions', $this->institutionRepository->findByLinks($linksFilter));
        $this->view->assign('institutionFilter', $linksFilter);


    }

    /**
     * Prepare Filter
     *
     * @param  \FRONTAL\FagInstitutionManagement\Domain\Model\InstitutionFilter $institutionFilter
     * @param  boolean $institutionFilterReset should filter be reseted
     * @param  string $sessionName
     * @return \FRONTAL\FagInstitutionManagement\Domain\Model\InstitutionFilter
     */
    protected function prepareFilter($institutionFilter = NULL, $institutionFilterReset = FALSE, $sessionName)
    {

        $sessionName = $sessionName;

        if (($this->settings['appendContentUidToFilterSessionName'])) {
            $this->contentObj = $this->configurationManager->getContentObject();
            $sessionName .= $this->contentObj->data['uid'];
        }

        // get/set filter from/to session
        if ($institutionFilterReset) {
            $this->sessionStorageService->set($sessionName, NULL);
            $institutionFilter = $this->sessionStorageService->getAndSet($sessionName, 'FRONTAL\\FagInstitutionManagement\\Domain\\Model\\InstitutionFilter');
        } else {
            $institutionFilter = $this->sessionStorageService->getAndSet($sessionName, 'FRONTAL\\FagInstitutionManagement\\Domain\\Model\\InstitutionFilter', $institutionFilter);
        }

        // Allowed categories
        if (!empty($this->settings['allowedCategories'])) {
            $allowedCategories = explode(',', $this->settings['allowedCategories']);
            $institutionFilter->setAllowedCategories($allowedCategories);
        }

        // Set fulltext-searchfields from settings (if set)
        if (!empty($this->settings['searchFields'])) {
            $searchFields = explode(",", $this->settings['searchFields']);
            $searchFields = array_map('trim', $searchFields); // trim fieldnames
            $institutionFilter->setSearchFields($searchFields);
        }

        return $institutionFilter;
    }

    /**
     * action NextStep
     *
     */
    public function nextStepAction()
    {
        $all = [];
        $admin = [];
        $allrole = [];
        $alluser = [];
        $alluserrole = [];
        $alluserroleisadmin = [];
        $userDetails = [];
        $events = [];
        $eventPassed = [];
        $user = $GLOBALS['TSFE']->fe_user->user;
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid_local', 'tx_faginstitutionmanagement_fe_users_institution_mm', 'uid_foreign=' . $user['uid']);
        /* all users with role*/
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faginstitutionmanagement_domain_model_role');
        $rows = $queryBuilder
            ->select('institution')
            ->from('tx_faginstitutionmanagement_domain_model_role')
            ->Where(
                "tx_faginstitutionmanagement_domain_model_role.user = " . $user['uid']
            )
            ->andWhere(
                "tx_faginstitutionmanagement_domain_model_role.deleted = 0"
            )
            ->andWhere(
                "tx_faginstitutionmanagement_domain_model_role.hidden = 0"
            )
            ->execute();

        while ($r = $rows->fetch()) {
            array_push($alluserrole, $r['institution']);
        }
        /* all users with role is admin*/
        $queryBuilderisAdmin = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faginstitutionmanagement_domain_model_role');
        $rowsisadmin = $queryBuilderisAdmin
            ->select('institution')
            ->from('tx_faginstitutionmanagement_domain_model_role')
            ->Where(
                "tx_faginstitutionmanagement_domain_model_role.user = " . $user['uid']
            )
            ->andWhere(
                "tx_faginstitutionmanagement_domain_model_role.deleted = 0"
            )
            ->andWhere(
                "tx_faginstitutionmanagement_domain_model_role.isadmin = 1"
            )
            ->andWhere(
                "tx_faginstitutionmanagement_domain_model_role.hidden = 0"
            )
            ->execute();

        while ($r = $rowsisadmin->fetch()) {
            array_push($alluserroleisadmin, $r['institution']);
        }
        foreach ($res as $argument) {
            $uid_local = $argument['uid_local'];
            array_push($alluserrole, (int)$uid_local);
            array_push($alluserroleisadmin, (int)$uid_local);
        }
        $alluserrole = array_unique($alluserrole);
        $alluserroleadmin = array_unique($alluserroleisadmin);
        foreach ($alluserrole as $all1) {
            array_push($all, $this->institutionRepository->findByUid($all1));
        }
        foreach ($alluserroleadmin as $alladmin) {
            array_push($admin, $this->institutionRepository->findByUid($alladmin));
        }
        if (empty($all) || empty($admin) || (int)$user['no_frontend_login'] == 1) {
            $GLOBALS['TSFE']->fe_user->logoff();
            header('Location: ' . $this->request->getBaseUri() . 'login/');
        }

        $currentPid = $GLOBALS['TSFE']->id;
        if ($currentPid == $this->settings['start'] || $currentPid == $this->settings['personen'] || $currentPid == $this->settings['termine'] || $currentPid == $this->settings['Suchmaske'] || $currentPid == $this->settings['NeuePerson']) {
            $idinstitution = (int)$GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid");
            $allUsers = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid_foreign', 'tx_faginstitutionmanagement_fe_users_institution_mm', 'uid_local=' . $idinstitution, '', 'sorting');
            foreach ($allUsers as $al) {
                array_push($userDetails, $this->userRepository->findByUid($al['uid_foreign']));
            }
            $event = $this->eventRepository->findByInstitution($idinstitution);

            if ($this->institutionRepository->findByUid($GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid"))) {
                $institution = $this->institutionRepository->findByUid($GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid"));
                $event = $this->eventRepository->findByInstitution($institution);

            }
            if ($event->count() == 0) {
                $event = $institution->getEvents();
            }

            $now = strtotime("now");
            foreach ($event as $even) {
//                $dates = $even->getDates();
//                if ($dates) {
//                    foreach ($dates as $date) {
//                    DebugUtility::debug($date->getStartdate());
//                    DebugUtility::debug($date->getEnddate());
//                    DebugUtility::debug($even->getStart());
                $dateTime = new \DateTime();
//                        $dateTime->setTimestamp((int)strtotime($even->getStart()));
                if ($even->getStart()) {
                    $start = $even->getStart()->format('Y-m-d');
                }
                else{
                    $start = strtotime('-1 day', $now);
                }
                $dateTime->setTimestamp($now);
                $dnow = $dateTime->format('Y-m-d');
                if ($dnow > $start) {
                    array_push($eventPassed, $even);
                } else {
                    array_push($events, $even);
                }
//                    }
//                }
                //die;
//                $events = array_unique($events);
//                $eventPassed = array_unique($eventPassed);
//                // if(!$even->isOneDay()){
//                $end = $even->getEnd();
//                if ($now->getTimestamp() > $start->getTimestamp()) {
//                    array_push($eventPassed, $even);
//                } else {
//                    array_push($events, $even);
//                }
            }
        }
        // DebugUtility::debug($events);
        // DebugUtility::debug($eventPassed);die;


        $detailsInst = $this->institutionRepository->findByUid($idinstitution);
        $user = $this->userRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);

        $this->view->assignMultiple(['institution' => $all, 'institutionAdmin' => $admin, 'user' => $user, 'detailsInstitution' => $detailsInst, 'id_url' => $idinstitution, 'userDetails' => $userDetails, 'events' => $events, 'eventPassed' => $eventPassed]);
    }

    /**
     * action edit
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Institution $institution
     * @ignorevalidation $institution
     * @return void
     */
    public function editAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Institution $institution)
    {
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'institutionUid', $institution->getUid());
        $this->view->assignMultiple(['institution' => $institution, 'id_url' => $institution->getUid()]);
    }

    /**
     * Set TypeConverter option for image upload
     */
    public function initializeupdateAction()
    {
//        DebugUtility::debug($this->request->getArguments());die;
        $this->setTypeConverterConfigurationForImageUpload('institution');
    }

    /**
     * action update
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Institution $institution
     */

    public function updateAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Institution $institution)
    {
//        $oldinst = $this->institutionRepository->findByUid(292);
////        foreach ($institution->getDocument() as $docu) {
////            $oldinst->addDocument($docu);
////        }
////        $institution->setDocument($oldinst->getDocument());
//        DebugUtility::debug($oldinst->getDocument());
//        DebugUtility::debug($oldinst);
//        DebugUtility::debug($institution);
//        die;
//        if ($this->request->hasArgument('docid')) {
//            foreach ($this->request->getArgument('docid') as $docu) {
//                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('sys_file_reference', 'uid=' . $docu, array(
//                    'fieldname' => 'document',
//                    'tablenames' => 'tx_faginstitutionmanagement_domain_model_institution',
//                    'table_local' => 'sys_file',
//                    'uid_foreign' => $institution->getUid()
//                ));
//            }
//        }


        $oldinst = $this->institutionRepository->findByUid($institution->getUid());
        //if ($institution->getLogo() != $oldinst->getLogo())
        $this->institutionRepository->removeFileRefrence($institution->getUid(), 'logo', 0);
        $i = 0;
        $persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");

        $this->institutionRepository->update($institution);
        $persistenceManager->persistAll();
        if ($this->request->hasArgument('deleted')) {
            foreach ($this->request->getArgument('deleted') as $j => $delet) {
                if ($delet == 1) {
                    $this->institutionRepository->removeFileRefrence($institution->getUid(), 'document', $j);
                }

            }
        }
        if ($this->request->hasArgument('docstitle')) {


            foreach ($institution->getDocument() as $docu) {
//            DebugUtility::debug($docu);
                $desc = "";
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('sys_file_reference', 'uid=' . $docu->getUid(), array(
                    'description' => $this->request->getArgument('docstitle')[$i],
                    'fieldname' => 'document',
                    'tablenames' => 'tx_faginstitutionmanagement_domain_model_institution',
                    'table_local' => 'sys_file',
                    'uid_foreign' => $institution->getUid()
                ));
                $i++;
            }
        } else {
            foreach ($institution->getDocument() as $docu) {
//            DebugUtility::debug($docu);
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('sys_file_reference', 'uid=' . $docu->getUid(), array(
                    'deleted' => 1,

                ));
                $i++;
            }
        }
        $assignedValues = [
            'institution' => $institution->getUid()
        ];

        $this->redirect('edit', $this->controllerName, $this->extensionName, $assignedValues, $this->settings['start']);
    }

    /**
     * action updatePersonen
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Role $role
     */
    public function updatePersonenAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Role $role = null)
    {
        if (empty($this->request->getArgument('roleid'))) {
            $updatedrole = new Role();
        } else {
            $updatedrole = $this->roleRepository->findByUid((int)$this->request->getArgument('roleid'));

        }
        $institution = $this->institutionRepository->findByUid($GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid"));
        $updatedrole->setInstitution($institution);

        if ($this->request->hasArgument('isadmin')) {
            $updatedrole->setIsadmin(true);
            $alreadyadmin = $this->institutionRepository->findByAdmin($role->getUser()->toArray()[0]->getUid());
            if ($alreadyadmin->count() == 0) {
                $institution->addAdmin($role->getUser()->toArray()[0]);
                $this->institutionRepository->update($institution);
            }
        } else {
            $updatedrole->setIsadmin(false);

            $alreadyadmin = $this->institutionRepository->findByAdmin($role->getUser()->toArray()[0]->getUid());
            if ($alreadyadmin->count() > 0) {
                $institution->removeAdmin($role->getUser()->toArray()[0]);
                $this->institutionRepository->update($institution);
            }
        }


        $updatedrole->setUser($role->getUser());

        $updatedrole->setTitle($this->request->getArgument('title'));
        $updatedrole->setEmail($this->request->getArgument('email'));
        $updatedrole->setPhone($this->request->getArgument('phone'));
        $updatedrole->setMobile($this->request->getArgument('mobile'));
        $updatedrole->setAddress($this->request->getArgument('address'));
        $updatedrole->setZip($this->request->getArgument('zip'));
        $updatedrole->setCity($this->request->getArgument('city'));

        if ($this->request->hasArgument('hideEmail')) {
            $updatedrole->setHideEmail(true);
        } else {
            $updatedrole->setHideEmail(false);
        }
        if ($this->request->hasArgument('hidePhone')) {
            $updatedrole->setHidePhone(true);
        } else {
            $updatedrole->setHidePhone(false);
        }
        if ($this->request->hasArgument('hideMobile')) {
            $updatedrole->setHideMobile(true);
        } else {
            $updatedrole->setHideMobile(false);
        }
        if ($this->request->hasArgument('hideAddress')) {
            $updatedrole->setHideAddress(true);
        } else {
            $updatedrole->setHideAddress(false);
        }
        if ($this->request->hasArgument('hideZip')) {
            $updatedrole->setHideZip(true);
        } else {
            $updatedrole->setHideZip(false);
        }
        if ($this->request->hasArgument('hideCity')) {
            $updatedrole->setHideCity(true);
        } else {
            $updatedrole->setHideCity(false);
        }

        if (empty($this->request->getArgument('roleid'))) {
            $this->roleRepository->add($updatedrole);
        } else {
            $this->roleRepository->update($updatedrole);
        }

        $this->redirect('personen', $this->controllerName, $this->extensionName, ['idPerson' => $role->getUser()->getArray()[0]], $this->setting['Personbearbeiten']);
    }

    /**
     * action editUser
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\User $user
     * @ignorevalidation $user
     * @return void
     */
    public function editUserAction(\FRONTAL\FagInstitutionManagement\Domain\Model\User $user = null)
    {
        $user_id = $_GET['tx_faginstitutionmanagement_nextsteplogin']['user'];
//         DebugUtility::debug($user_id);
        // DebugUtility::debug($this->userRepository->findByUid($user_id));
        if ($user_id > 0) {
            $user = $this->userRepository->findByUid($user_id);
        }
        $this->view->assignMultiple(['user' => $user]);
    }


    /**
     * Set TypeConverter option for image upload
     */
    public function initializeuserUpdateAction()
    {

        // $this->setTypeConverterConfigurationForImageUpload('user');
    }

    /**
     * action userUpdate
     *
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\User $user
     */
    public function userUpdateAction(\FRONTAL\FagInstitutionManagement\Domain\Model\User $user)
    {
//       DebugUtility::debug($user);die;
        $institution = $this->institutionRepository->findByUid($GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid"));
        $updateItem = $this->userRepository->findByUid($user->getUid());
        $updateItem->setFirstName($user->getFirstName());
        $updateItem->setLastName($user->getLastName());
        $updateItem->setImage($user->getImage());
        $updateItem->setEmail($user->getEmail());
        $updateItem->setTelephone($user->getTelephone());
        $updateItem->setMobilephone($user->getMobilephone());
        $updateItem->setAddress($user->getAddress());
        $updateItem->setZip($user->getZip());
        $updateItem->setCity($user->getCity());
        $this->userRepository->update($updateItem);
        $assignedValues = [
            'institution' => $institution,
            'user' => $user,
        ];
        $this->redirect('editUser', $this->controllerName, $this->extensionName, $assignedValues);

    }


    /**
     * action personen
     *
     */
    public function personenAction()
    {
//        DebugUtility::debug($this->request->getArguments());die;
        $idPerson = $this->request->getArgument('idPerson');
        $idUser = $GLOBALS['TSFE']->fe_user->user;
        $person = $this->userRepository->findByUid($idPerson);
        $role = $this->roleRepository->findByUserAndInstitution((int)$idPerson, (int)$GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid"));
        $this->view->assignMultiple(['person' => $person, 'role' => $role]);
    }


    public function linkUserAction()
    {
        $institution = $GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid");
        $searchuserinst = $this->institutionRepository->findByUser((int)$institution, $this->request->getArgument('user'));
        if (!$searchuserinst) {
            $queryBuilder2 = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faginstitutionmanagement_fe_users_institution_mm');
            $queryBuilder2
                ->insert('tx_faginstitutionmanagement_fe_users_institution_mm')
                ->values([
                    'uid_local' => $institution,
                    'uid_foreign' => $this->request->getArgument('user'),
                ])
                ->execute();
            $assignedValues = [
                'institution' => $institution
            ];
        }


        $this->redirect('nextStep', $this->controllerName, $this->extensionName, $assignedValues, $this->settings['personen']);

    }

    /**
     * addUser
     *
     *
     */
    public function addUserAction()
    {

//        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->request->getArguments());
//        die;
        $currentPid = $GLOBALS['TSFE']->id;
        $institution = $GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid");

        if ($currentPid == $this->settings['NeuePerson']) {
            if ($this->request->getMethod() === 'POST') {

                $newinstitution = $this->request->getArgument('newuser');
                $first_name = $newinstitution['first_name'];
                $last_name = $newinstitution['last_name'];
                $email = $newinstitution['email'];
                $institution = $newinstitution['institution'];
                $searchuser = $this->userRepository->findUsers($email, null, null);
                $institutionName = $this->institutionRepository->findByUid($institution);
                if (sizeof($searchuser) > 0) {

                    $assignedValues = [
                        'institution' => $institution,
                        'user' => $searchuser[0],
                        'showbutton' => true,
                        'institutionName' => $institutionName->getTitle()
                    ];
                    $this->view->assignMultiple($assignedValues);

                } else {

                    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');

                    $date = new \DateTime();
                    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                    $pass = array(); //remember to declare $pass as an array
                    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                    for ($i = 0; $i < 15; $i++) {
                        $n = rand(0, $alphaLength);
                        $pass[] = $alphabet[$n];
                    }
                    $password = implode($pass); //turn the array into a string
                    $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
                    $mail->setSubject('Sie wurden als Ansprechperson auf www.willisauch erfasst');
                    $mail->setFrom(array('stadtkanzlei@willisau.ch' => 'www.willisau.ch'));
                    $mail->setTo(array($email => $first_name));
                    $mail->setBody('Grüezi
                    Ihre Person wurde als Ansprechpartner mit der E-Mailadresse «' . $email . '» auf der Gemeindewebsite willisau.ch der Institution «' . $institutionName->getTitle() . '» zugewiesen. Dieser Eintrag ist bereits auf der Website publiziert.
                    Sie habe die Möglichkeit, Ihre publizierten Daten selber anzupassen. Dazu wurde für Sie ein Login für die Gemeindewebsite willisau.ch erstellt. Sie können sich einloggen und Ihre Daten online anpassen.
                    Damit Sie sich anmelden können, müssen Sie als Erstes ein neues Passwort setzen. Klicken Sie dazu auf nachfolgenden Link:
                    «http://willisaudev.frontalprojects.ch/login/felogin/forgot/»
                    Wir bedanken uns für die Mitarbeit bei der Datenpflege auf unserer Gemeindewebsite.
                    Stadt Willisau
                    www.willisau.ch');
                    $mail->addPart('Grüezi<br>
                    Ihre Person wurde als Ansprechpartner mit der E-Mailadresse «' . $email . '» auf der Gemeindewebsite willisau.ch der Institution «' . $institutionName->getTitle() . '» zugewiesen. Dieser Eintrag ist bereits auf der Website publiziert.<br>
                    Sie habe die Möglichkeit, Ihre publizierten Daten selber anzupassen. Dazu wurde für Sie ein Login für die Gemeindewebsite willisau.ch erstellt. Sie können sich einloggen und Ihre Daten online anpassen.<br>
                    Damit Sie sich anmelden können, müssen Sie als Erstes ein neues Passwort setzen. Klicken Sie dazu auf nachfolgenden Link:
                    «<a href="' . $this->request->getBaseUri() . '/login/felogin/forgot/">Neues Passwort anfordern</a>»<br>Wir bedanken uns für die Mitarbeit bei der Datenpflege auf unserer Gemeindewebsite.<br><br>Stadt Willisau<br>
                    <a href="' . $this->request->getBaseUri() . '"> www.willisau.ch</a>', 'text/html');
                    $mail->send();
//                    $password = '123456789'; //turn the array into a string
                    $saltFactory = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance('', 'BE');
                    $hashedPassword = $saltFactory->getHashedPassword($password);
                    $affectedRows = $queryBuilder
                        ->insert('fe_users')
                        ->values([
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'email' => $email,
                            'password' => $hashedPassword,
                            'username' => $email,
                            'pid' => $this->settings['userfolder'],
                            'tstamp' => $date->getTimestamp(),
                            'usergroup' => 1,
                        ])
                        ->execute();

                    $queryBuilder1 = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
                    $statement = $queryBuilder1
                        ->select('uid')
                        ->from('fe_users')
                        ->where($queryBuilder1->expr()->eq('email', $queryBuilder1->createNamedParameter($email)))
                        ->execute()
                        ->fetch();
                    $queryBuilder2 = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faginstitutionmanagement_fe_users_institution_mm');
                    $affectedRows2 = $queryBuilder2
                        ->insert('tx_faginstitutionmanagement_fe_users_institution_mm')
                        ->values([
                            'uid_local' => $institution,
                            'uid_foreign' => $statement['uid'],
                        ])
                        ->execute();
                    $assignedValues = [
                        'institution' => $institution
                    ];

                    $this->redirect('nextStep', $this->controllerName, $this->extensionName, $assignedValues, $this->settings['personen']);
                }
            }
        }

        if ($currentPid == $this->settings['suchresultate']) {
            // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->request->getArguments());
            $institution = $GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid");
            $UsersIns = [];
            $allUsers = [];
            if ($results = $this->request->hasArgument('results')) {
                $results = $this->request->getArgument('results');
                if ($results) {
                    foreach ($results as $res) {
                        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
                        $statement = $queryBuilder
                            ->select('*')
                            ->from('fe_users')
                            ->where(
                                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int)$res, \PDO::PARAM_INT))

                            )
                            ->execute()
                            ->fetch();
                        if ($statement) {
                            array_push($allUsers, $statement);
                            foreach ($allUsers as $i => $users) {
                                $userinst = $this->institutionRepository->findByUser((int)$institution, $users['uid']);
                                if ($userinst) {

                                    $allUsers[$i]['linked'] = true;
                                } else {
                                    $allUsers[$i]['linked'] = false;

                                }
                            }
                        }
                    }

                }
            }
            $institutionName = $this->institutionRepository->findByUid($institution);
            $this->view->assignMultiple(['institution' => $institution, 'institutionName' => $institutionName->getTitle(), 'results' => $results, 'allUsers' => $allUsers]);
        }


        if ($currentPid == $this->settings['Suchmaske']) {

            $institution = $GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid");

            if ($this->request->hasArgument('searchPersonen')) {

                $searchPersonen = $this->request->getArgument('searchPersonen');
                $first_name = $searchPersonen['vorname'];
                $last_name = $searchPersonen['name'];
                $email = $searchPersonen['email'];
                $institution = $searchPersonen['institution'];

                if (strlen($first_name) == 0 && strlen($email) == 0 && strlen($last_name) == 0) {
                    $results = null;
                } else {
                    $results = $this->userRepository->findUsers($email, $first_name, $last_name);
                }


                $assignedValues = [
                    'institution' => $institution,
                    'results' => $results,
                ];


                $this->redirect('addUser', $this->controllerName, $this->extensionName, $assignedValues, $this->settings['suchresultate']);
            }
        }
        $this->view->assign('id_url', $institution);
    }


    public function termineAction()
    {
        $eventDetails = [];
        $eventuid = $this->request->getArgument('eventuid');
        $idinst = $GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid");
        $currentPid = $GLOBALS['TSFE']->id;
        if ($currentPid == $this->settings['Neuetermine']) {

            $this->view->assign('institution', $idinst);
        }
        if ($currentPid == $this->settings['terminBearbeiten']) {
            // $event = $this->eventRepository->findByUid($eventuid);
            // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($eventuid);

            $event = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_fagcalendar_domain_model_event', 'uid=' . $eventuid);
            foreach ($event as $eve) {
                array_push($eventDetails, $eve);
            }
            $this->view->assign('eventDetails', $eventDetails);
        }
    }

    /**
     *
     */
    protected function setTypeConverterConfigurationForImageUpload($argumentName)
    {
        $uploadConfiguration = [
            UploadedFileReferenceConverter::CONFIGURATION_ALLOWED_FILE_EXTENSIONS => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            UploadedFileReferenceConverter::CONFIGURATION_UPLOAD_FOLDER => 'files/',
        ];
        /** @var PropertyMappingConfiguration $newExampleConfiguration */
        $newImageConfiguration = $this->arguments[$argumentName]->getPropertyMappingConfiguration();
        $newImageConfiguration->allowAllProperties();

        $newImageConfiguration->forProperty('document')->allowAllProperties();
        $newImageConfiguration->allowCreationForSubProperty('document');
        $newImageConfiguration->allowModificationForSubProperty('document');
        $newImageConfiguration->forProperty('document')
            ->setTypeConverterOptions(
                'FRONTAL\\FagInstitutionManagement\\Property\\TypeConverter\\UploadedFileReferenceConverter',
                $uploadConfiguration
            );

    }


    public function deleteUserAction()
    {
        $institution = $GLOBALS["TSFE"]->fe_user->getKey("ses", "institutionUid");
        $idpersonne = $this->request->getArgument('idPerson');
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_faginstitutionmanagement_fe_users_institution_mm');
        $affectedRows = $queryBuilder
            ->delete('tx_faginstitutionmanagement_fe_users_institution_mm')
            ->where(
                $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($idpersonne))
            )
            ->execute();
        $assignedValues = [
            'institution' => $institution
        ];

        $this->redirect('nextStep', $this->controllerName, $this->extensionName, $assignedValues, $this->settings['personen']);
    }
}

?>
