<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;

use DslFactory\DslIntranet\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\Processing\FileDeletionAspect;
use DslFactory\DslIntranet\Utility\FileUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 
 */

/**
 * NewsController
 */
class NewsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * newsRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\NewsRepository
     */
    protected $newsRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\NewsRepository $newsRepository
     */
    public function injectNewsRepository(\DslFactory\DslIntranet\Domain\Repository\NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * action toggleSichtbarkeit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\News $news
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function toggleSichtbarkeitAction(\DslFactory\DslIntranet\Domain\Model\News $news): \Psr\Http\Message\ResponseInterface
    {
        $news->toggleSichtbarkeit();
        $this->newsRepository->update($news);
        $this->view->assign('newsItem', $news);
        $this->view->assign('returnString', json_encode(array('editUid' => $news->getUid())));
        return $this->htmlResponse();
    }

    /**
     * action toggleCountdown
     *
     * @param \DslFactory\DslIntranet\Domain\Model\News $news
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function toggleCountdownAction(\DslFactory\DslIntranet\Domain\Model\News $news): \Psr\Http\Message\ResponseInterface
    {
        $news->toggleCountdown();
        $this->newsRepository->update($news);
        $this->view->assign('newsItem', $news);
        $this->view->assign('returnString', json_encode(array('editUid' => $news->getUid())));
        return $this->htmlResponse();
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $news = $this->newsRepository->findAll();
        $this->view->assign('news', $news);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\News $news
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\News $news): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('news', $news);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        $news = new \DslFactory\DslIntranet\Domain\Model\News();
        $this->view->assign('news', $news);
        return $this->htmlResponse();
    }


    /**
     * action create
     *
     * void
     */
    public function createAction()
    {
        /*$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->newsRepository->add($newNews);
        $this->redirect('list');*/


        $news = new \DslFactory\DslIntranet\Domain\Model\News();

        $news = $this->updateNewsFromRequest($news);

        $this->newsRepository->add($news);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //echo json_encode(array('newUid' => $newAgenturvertrag->getUid()));
        $this->view->assign('newsItem', $news);
        $this->view->assign('returnString', json_encode(array('newUid' => $news->getUid())));
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\News $news
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("news")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\News $news): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('news', $news);
        return $this->htmlResponse();
    }


    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\News $news
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\News $news)
    {
        /*$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->newsRepository->update($news);
        $this->redirect('list');*/

        $news = $this->updateNewsFromRequest($news);
        // echo 'die;';
        //die;
        $this->newsRepository->update($news);
        //echo $news->getTitel();
        $this->view->assign('newsItem', $news);
        $this->view->assign('returnString', json_encode(array('editUid' => $news->getUid())));
    }


    /**
     * @param \DslFactory\DslIntranet\Domain\Model\News news
     */
    private function updateNewsFromRequest($news)
    {
        
        if ($this->request->hasArgument('news')) {
            $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            $FileDeletionAspect = GeneralUtility::makeInstance(FileDeletionAspect::class);
            $fileUtility = new FileUtility($resourceFactory, $FileDeletionAspect);

            $uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('news');

            //$uploadedImage = $this->createUserProfileImage($image);
            // Index the image, it will move the file and return the FAL file object
            $indexedFiles = $fileUtility->indexImages($this->request->getArgument('news')['datei'], $uploadSettings['falStorageSubDir'], true);

            if (!empty($indexedFiles)) {
                $falFile = $indexedFiles[0];

                // Now, you can create a FileReference from this FAL file and save it to your model
                $fileReference = $fileUtility->createFileReferenceFromFalFileObject($falFile, 0, 0,'','');

                // Assuming you have an Event model that accepts a FileReference
                $news->setDatei($fileReference);


            }
        }
        if ($this->request->hasArgument('titel')) {
            $news->setTitel($this->request->getArgument('titel'));
        }
        if ($this->request->hasArgument('untertitel')) {
            $news->setUntertitel($this->request->getArgument('untertitel'));
        }
        if ($this->request->hasArgument('text')) {
            $news->setText($this->request->getArgument('text'));
        }
        if ($this->request->hasArgument('angebot1')) {
            $news->setAngebot1($this->request->getArgument('angebot1'));
        }
        if ($this->request->hasArgument('angebot2')) {
            $news->setAngebot2($this->request->getArgument('angebot2'));
        }
        if ($this->request->hasArgument('angebot3')) {
            $news->setAngebot3($this->request->getArgument('angebot3'));
        }
        if ($this->request->hasArgument('linkExtern')) {
            $news->setLinkExtern($this->request->getArgument('linkExtern'));
        }
        if ($this->request->hasArgument('linkExternName')) {
            $news->setLinkExternName($this->request->getArgument('linkExternName'));
        }
        if ($this->request->hasArgument('sichtbarkeit')) {
            if($this->request->getArgument('sichtbarkeit') == 1){
                $news->setSichtbarkeit(TRUE);
            }else{
                $news->setSichtbarkeit(FALSE);
            }
        }
        if ($this->request->hasArgument('countdown')) {
            if($this->request->getArgument('countdown') == 1){
                $news->setSichtbarkeit(TRUE);
            }else{
                $news->setSichtbarkeit(FALSE);
            }
        }
        if ($this->request->hasArgument('gueltigAb')) {
            $news->setGueltigAb(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('gueltigAb'))));
        }
        if ($this->request->hasArgument('gueltigBis')) {
            if ($this->request->getArgument('gueltigBis')) {
                $news->setGueltigBis(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('gueltigBis'))));
            } else {
                $news->clearGueltigBis();
            }
        }
        // / Bild
        /*if ($this->request->hasArgument('preisMonatlich')) {
          $vertrag->setPreisMonatlich($this->request->getArgument('preisMonatlich'));
          }*/

        return $news;
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\News $news
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\News $news)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->newsRepository->remove($news);
        $this->redirect('list');
    }
}
