<?php

namespace Pingag\PingagAddress\Hooks;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;

class MyHook
{


    /**
     * @param string $status The status of the data being saved
     * @param string $table The table name where data is being saved
     * @param array $row The data being saved
     * @param array $fields The fields being saved
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $parentObject Reference to the calling DataHandler object (the "parent" DataHandler)
     * @return void
     */
    public function processDatamap_postProcessFieldArray($status, $table, $row, $fields, &$parentObject)
    {
        if($table == 'tt_address' && $status == 'new'){
            $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
            $configuration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
            $setting = $configuration['plugin.']['tx_pingagaddress_mapshow.']['settings.'];

            $password = 'Password123';
            $hashInstance = GeneralUtility::makeInstance(PasswordHashFactory::class)->getDefaultHashInstance('FE');
            $hashedPassword = $hashInstance->getHashedPassword($password);

            $queryBuilder =  GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_address');
            $queryBuilder->getRestrictions()->removeAll();
            $count = $queryBuilder
                ->count('*')
                ->from('tt_address')
                ->executeQuery()
                ->fetchOne();

            $id = $count + 1 ;



          if($fields['pid'] == (int)$setting['PidNewUser']) {

                $username = $fields['first_name'] . '_' . $fields['last_name'];
                $frontendGroupsRepository = GeneralUtility::makeInstance(FrontendUserGroupRepository::class);

                $object = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

                $object->attach($frontendGroupsRepository->findByUid((int)$setting['FrontendUserGroup']));
                $user = new \Pingag\PingagAddress\Domain\Model\FrontendUser();
                $user->setUsername($username);
                $user->setPassword($hashedPassword);
                $user->setUsergroup($object);
                $user->setEmail($fields['email']);
                $user->setAddressid($id);
                //$user->setEmail($fields['email']);
                $user->setPid((int)$setting['PidFolderNewUser']);


                $frontendUserRepository = GeneralUtility::makeInstance(FrontendUserRepository::class);


                $frontendUserRepository->add($user);
                GeneralUtility::makeInstance(PersistenceManager::class)->persistAll();
            }

        }

    }
}