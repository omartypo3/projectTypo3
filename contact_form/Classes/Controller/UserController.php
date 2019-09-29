<?php

namespace LeadGeneration\ContactForm\Controller;

/***
 *
 * This file is part of the "Lead Generation contact form" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

use function GuzzleHttp\is_host_in_noproxy;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Saltedpasswords\Salt\SaltFactory;

/**
 * UserController
 */
class UserController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * userRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $userRepository = null;

    /**
     * userGroupRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $userGroupRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $defaultQuerySettings->setRespectStoragePage(FALSE);
        $this->userRepository->setDefaultQuerySettings($defaultQuerySettings);
        $users = $this->userRepository->findAll();
        $this->view->assign('users', $users);
    }

    /**
     * action show
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
     * @return void
     */
    public function showAction(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user)
    {
        $this->view->assign('user', $user);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $defaultQuerySettings->setRespectStoragePage(FALSE);
        $this->userGroupRepository->setDefaultQuerySettings($defaultQuerySettings);
        $groups = $this->userGroupRepository->findAll();
        $this->view->assign('groups', $groups);
    }

    /**
     * action create
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $newUser
     * @param array $password
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @validate $password \LeadGeneration\ContactForm\Domain\Validator\PassWordValidator
     *
     */
    public function createAction(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $newUser , $password)
    {

        $this->addFlashMessage('User Successfully Created', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $newUser->setUsername($newUser->getEmail());
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $setting = $extbaseFrameworkConfiguration['plugin.']['tx_contactform_fecontactform.']['settings.']['UsersStoragePageUid'];
        $newUser->setPid((int)$setting);
        $newUser->setPassword($password[1]);

        $hashInstance = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance(NULL);
        $hashedPassword = $hashInstance->getHashedPassword($newUser->getPassword());
        $newUser->setPassword($hashedPassword);
        $this->userRepository->add($newUser);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
     * @ignorevalidation $user
     * @return void
     */
    public function editAction(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user = Null)
    {

        if (!$user) {
            $user = $this->userRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
        }
        $defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $defaultQuerySettings->setRespectStoragePage(FALSE);
        $this->userGroupRepository->setDefaultQuerySettings($defaultQuerySettings);
        $groups = $this->userGroupRepository->findAll();

        $this->view->assignMultiple(array('user' => $user, 'groups' => $groups));
    }


    /**
     * action update
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
     * @param array $password
     * @validate $password \LeadGeneration\ContactForm\Domain\Validator\ChangePasswordValidator
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function updateAction(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user , $password)
    {


        $this->addFlashMessage('User Successfully Updated', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $user->setUsername($user->getEmail());
        if ($password[1] != '') {
            $user->setPassword($password[1]);
            $hashInstance = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance(NULL);
            $hashedPassword = $hashInstance->getHashedPassword($user->getPassword());
            $user->setPassword($hashedPassword);
        }
        $this->userRepository->update($user);
        $group = $this->userGroupRepository->findByUid($GLOBALS['TSFE']->fe_user->user['usergroup']);
        if ((strtolower($group->getTitle()) == 'admin') && ($user->getUid() != (int)($GLOBALS['TSFE']->fe_user->user['uid']))) {
            $this->redirect('list');
        } else {
            $this->redirect('edit');
        }

    }

    /**
     * action delete
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
     * @return void
     */
    public function deleteAction(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user)
    {
        $this->addFlashMessage('User Successfully Deleted', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->userRepository->remove($user);
        $this->redirect('list');
    }
}
