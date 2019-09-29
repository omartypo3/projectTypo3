<?php

namespace LeadGeneration\ContactForm\Domain\Validator;

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Saltedpasswords\Salt\SaltFactory;

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 20/10/2018
 * Time: 11:36
 */
class ChangePasswordValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
    /**
     * @param array $value
     * @return void
     */
    /**
     * userRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $userRepository = null;


    protected function isValid($value)
    {

        $objectManager = new ObjectManager();
        $minimumLength = 6;
        $success = false;
        if ($value[3] != '') {
            $uid = $value[3];
        } else {
            $uid = $GLOBALS['TSFE']->fe_user->user['uid'];
        }
        $defaultQuerySettings = $objectManager->get(Typo3QuerySettings::class);
        $defaultQuerySettings->setRespectStoragePage(FALSE);
        $this->userRepository->setDefaultQuerySettings($defaultQuerySettings);
        $user = $this->userRepository->findByUid($uid);
        $objSalt = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance($user->getPassword());
        if (is_object($objSalt)) {
            $success = $objSalt->checkPassword($value[0], $user->getPassword());
        }
        if ($success == false && ($value[0] != '')) {


            if (!$success) {
                $this->addError('Your old password entry is not correct', 1221560718);

            }

            // check for password length
            if (strlen($value[1]) < $minimumLength && ($value[1] != '')) {
                $this->addError('The password is to short, minimum length is ' . $minimumLength, 1221560718);
            }

            // check that the passwords are the same
            if (strcmp($value[1], $value[2]) != 0 && ($value[2] != '') && ($value[1] != '')) {
                $this->addError('The password do not match!', 1221560718);
            }
        }
    }
}