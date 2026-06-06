<?php
namespace Emagineurs\EPackage\Service;

/*
 *  The MIT License (MIT)
 *
 *  Copyright (c) 2014 Benjamin Kott, http://www.bk2k.info
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @author Benjamin Kott <info@bk2k.info>
 */
class InstallService
{

    /**
     * @var string
     */
    protected $extKey = 'e_package';

    /**
     * @var string
     */
    protected $messageQueueByIdentifier = '';

    /**
     * Initializes the install service
     */
    public function __construct()
    {
        $this->messageQueueByIdentifier = 'extbase.flashmessages.tx_extensionmanager_tools_extensionmanagerextensionmanager';
    }

    /**
     * @param string $extension
     */
    public function generateDefaultFiles($extension = null)
    {
        if ($extension == $this->extKey) {
            // realurl_conf.php
            $this->createDefaultRealUrlConf();
            // AdditioncalConf.php
            $this->createDefaultAdditionalFile();
            // .gitignore
            $this->createDefaultGitIgnore();
            // locallang
            $this->createLocallang();
            // Fileadmin recycler
            $this->createFileadminRecycler();
            if (substr($_SERVER['SERVER_SOFTWARE'], 0, 6) === 'Apache') {
                //.htaccess
                $this->createDefaultHtaccessFile();
            } else {
                /**
                 * Add Flashmessage that the system is not running on an apache webserver and the url rewritings must be handled manually
                 */
                $flashMessage = GeneralUtility::makeInstance(
                    'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                    'The Package uses RealUrl to generate SEO friendly URLs by default, please take care of the URLs rewriting settings for your environment yourself.'
                    . 'You can also deactivate RealUrl by changing your TypoScript setup to "config.tx_realurl_enable = 0".',
                    'TYPO3 is not running on an Apache-Webserver',
                    FlashMessage::WARNING,
                    true
                );
                $this->addFlashMessage($flashMessage);
                return;
            }
        }
    }

    /**
     * Creates realurl_conf.php file inside the root directory
     *
     * @return void
     */
    public function createDefaultRealUrlConf()
    {
        $realUrlFile = GeneralUtility::getFileAbsFileName('typo3conf/realurl_conf.php');
        if (file_exists($realUrlFile)) {
            /**
             * Add Flashmessage that there is already an .realurl_conf file and we are not going to override this.
             */
            $flashMessage = GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                'Le fichier realurl_conf.php existe déjà dans le dossier typo3conf. '
                . 'Un exemple est disponible dans EXT:e_package/Initialisation/realurl_conf.php',
                'realurl_conf.php existe déjà',
                FlashMessage::NOTICE,
                true
            );
            $this->addFlashMessage($flashMessage);
            return;
        }
        $realUrlContent = GeneralUtility::getUrl(ExtensionManagementUtility::extPath($this->extKey) . '/Initialisation/realurl_conf.php');
        GeneralUtility::writeFile($realUrlFile, $realUrlContent, true);

        /**
         * Add Flashmessage that the example htaccess ile was placed in the root directory
         */
        $flashMessage = GeneralUtility::makeInstance(
            'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
            'Le fichier realurl_conf.php du package est en place dans le dossier typo3conf.'
            . ' En cas de bug, vérifiez la présence du fichier .htaccess dans le répertoire racine. ',
            'realurl_conf.php copié dans typo3conf/',
            FlashMessage::OK,
            true
        );
        $this->addFlashMessage($flashMessage);
    }

    /**
     * Creates .htaccess file inside the root directory
     *
     * @return void
     */
    public function createDefaultHtaccessFile()
    {
        $htaccessFile = GeneralUtility::getFileAbsFileName('.htaccess');
        if (file_exists($htaccessFile)) {
            /**
             * Add Flashmessage that there is already an .htaccess file and we are not going to override this.
             */
            $flashMessage = GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                'Le fichier .htaccess existe déjà dans le dossier racine. Pensez à vérifier la variable d\'environnement.'
                . 'Un exemple est disponible dans EXT:e_package/Initialisation/.htaccess',
                '.htaccess existe déjà',
                FlashMessage::NOTICE,
                true
            );
            $this->addFlashMessage($flashMessage);
            return;
        }
        $htaccessContent = GeneralUtility::getUrl(ExtensionManagementUtility::extPath($this->extKey) . '/Initialisation/.htaccess');
        GeneralUtility::writeFile($htaccessFile, $htaccessContent, true);

        /**
         * Add Flashmessage that the example htaccess file was placed in the root directory
         */
        $flashMessage = GeneralUtility::makeInstance(
            'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
            'Le fichier .htaccess du package est en place dans le dossier racine.'
            . '  ',
            '.htaccess copié dans le dossier racine.',
            FlashMessage::OK,
            true
        );
        $this->addFlashMessage($flashMessage);
    }

    /**
     * Creates AdditionalConfiguration.php file inside the root directory
     *
     * @return void
     */
    public function createDefaultAdditionalFile()
    {
        $additionalFile = GeneralUtility::getFileAbsFileName('typo3conf/AdditionalConfiguration.php');
        if (file_exists($additionalFile)) {
            /**
             * Add Flashmessage that there is already an AdditionalConfiguration.php file and we are not going to override this.
             */
            $flashMessage = GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                'Le fichier AdditionalConfiguration.php existe déjà dans le dossier typo3conf.'
                . '',
                'AdditionalConfiguration.php existe déjà',
                FlashMessage::NOTICE,
                true
            );
            $this->addFlashMessage($flashMessage);
            return;
        }
        $additionalContent = GeneralUtility::getUrl(ExtensionManagementUtility::extPath($this->extKey) . '/Initialisation/AdditionalConfiguration.php');
        GeneralUtility::writeFile($additionalFile, $additionalContent, true);

        /**
         * Add Flashmessage that the example AdditionalConfiguration.php file was placed in the root directory
         */
        $flashMessage = GeneralUtility::makeInstance(
            'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
            'Le fichier AdditionalConfiguration.php du package est en place dans le dossier typo3conf.'
            . ' ',
            'AdditionalConfiguration.php copié dans typo3conf/',
            FlashMessage::OK,
            true
        );
        $this->addFlashMessage($flashMessage);
    }
    /**
     * Creates .gitignore file inside the root directory
     *
     * @return void
     */
    public function createDefaultGitIgnore()     {
        $additionalFile = GeneralUtility::getFileAbsFileName('typo3conf/.gitignore');
        if (file_exists($additionalFile)) {
            /**
             * Add Flashmessage that there is already an gitignore file and we are not going to override this.
             */
            $flashMessage = GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                'Le fichier .gitignore existe déjà dans le dossier typo3conf.'
                . '',
                '.gitignore existe déjà',
                FlashMessage::NOTICE,
                true
            );
            $this->addFlashMessage($flashMessage);
            return;
        }
        $additionalContent = GeneralUtility::getUrl(ExtensionManagementUtility::extPath($this->extKey) . '/Initialisation/.gitignore');
        GeneralUtility::writeFile($additionalFile, $additionalContent, true);

        /**
         * Add Flashmessage that the example gitignore file was placed in the root directory
         */
        $flashMessage = GeneralUtility::makeInstance(
            'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
            'Le fichier .gitignore du package est en place dans le dossier typo3conf.'
            . ' ',
            '.gitignore copié dans typo3conf/',
            FlashMessage::OK,
            true
        );
        $this->addFlashMessage($flashMessage);
    }
    /**
     * Creates fr.locallang.xlf file inside the l10n directory
     *
     * @return void
     */
    public function createLocallang()     {
        $additionalFile = GeneralUtility::getFileAbsFileName('typo3conf/l10n/fr/e_package/Resources/Private/Language/fr.locallang.xlf');
        if (file_exists($additionalFile)) {
            /**
             * Add Flashmessage that there is already an fr.locallang.xlf file and we are not going to override this.
             */
            $flashMessage = GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                'Le fichier fr.locallang.xlf existe déjà dans le dossier typo3conf/l10n/fr/e_package/Resources/Private/Language.'
                . '',
                'fr.locallang.xlf existe déjà',
                FlashMessage::NOTICE,
                true
            );
            $this->addFlashMessage($flashMessage);
            return;
        }
        
        $filePathArray = ['typo3conf','l10n','fr','e_package','Resources','Private','Language'];
        $parentDir = '';
        foreach($filePathArray as $currentDir){
            $parentDir = $parentDir.$currentDir.'/'; 
            if(!is_dir($parentDir)) {
                mkdir($parentDir, 0775, true);
            }
        }

        $additionalContent = GeneralUtility::getUrl(ExtensionManagementUtility::extPath($this->extKey) . '/Initialisation/fr.locallang.xlf');
        GeneralUtility::writeFile($additionalFile, $additionalContent, true);

        /**
         * Add Flashmessage that the example fr.locallang.xlf file was placed in the l10n directory
         */
        $flashMessage = GeneralUtility::makeInstance(
            'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
            'Le fichier fr.locallang.xlf du package est en place dans le dossier typo3conf/l10n/fr/e_package/Resources/Private/Language.'
            . ' ',
            'fr.locallang.xlf copié dans typo3conf/l10n/fr/e_package/Resources/Private/Language/',
            FlashMessage::OK,
            true
        );
        $this->addFlashMessage($flashMessage);
    }
    /**
     * Creates fileadmin recycler
     *
     * @return void
     */
    public function createFileadminRecycler()     {
        $storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\StorageRepository::class);
        $storage = $storageRepository->findByUid(1);

        $identifier = '_recycler_';
        $absoluteIdentiferPath = $storage->getConfiguration()['basePath'].$identifier;

        // if (!is_dir('fileadmin/_recycler_')) {
        if(!file_exists($absoluteIdentiferPath)) {
            // mkdir('fileadmin/_recycler_', 0777, true);
            $folder = $storage->createFolder($identifier);

            /**
             * Add Flashmessage that the example _recycler_ folder was placed in the fileadmin directory
             */
            $flashMessage = GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                'Le dossier _recycler_ a été ajouté dans le fileadmin.'
                . ' ',
                '_recycler_ créé dans le fileadmin',
                FlashMessage::OK,
                true
            );
            $this->addFlashMessage($flashMessage);
        } else {
            /**
             * Add Flashmessage that there is already an _recycler_ folder and we are not going to override this.
             */
            $flashMessage = GeneralUtility::makeInstance(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                'Le dossier _recycler_ existe déjà dans le fileadmin.'
                . '',
                '_recycler_ existe déjà',
                FlashMessage::NOTICE,
                true
            );
            $this->addFlashMessage($flashMessage);
        }
    }

    /**
     * Adds a Flash Message to the Flash Message Queue
     *
     * @param FlashMessage $flashMessage
     */
    public function addFlashMessage(FlashMessage $flashMessage)
    {
        if ($flashMessage) {
            /** @var $flashMessageService \TYPO3\CMS\Core\Messaging\FlashMessageService */
            $flashMessageService = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessageService');
            /** @var $flashMessageQueue \TYPO3\CMS\Core\Messaging\FlashMessageQueue */
            $flashMessageQueue = $flashMessageService->getMessageQueueByIdentifier($this->messageQueueByIdentifier);
            $flashMessageQueue->enqueue($flashMessage);
        }
    }

    /**
     * Update extension list
     *
     * @TODO: Adapt to multiple repositories if the Helper can handle this
     * @return void
     * @throws \TYPO3\CMS\Extensionmanager\Exception\ExtensionManagerException
     */
    public function updateExtensionList()
    {
        /** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);

        /** @var $repositoryHelper \TYPO3\CMS\Extensionmanager\Utility\Repository\Helper */
        $repositoryHelper = $objectManager->get(\TYPO3\CMS\Extensionmanager\Utility\Repository\Helper::class);
        $repositoryHelper->updateExtList();

        /** @var $persistenceManager \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
        $persistenceManager = $objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $persistenceManager->persistAll();
        $GLOBALS["BE_USER"]->simplelog (
            'Mise à jour des extensions OK',
            'e_package'
        ); 
    }
}
