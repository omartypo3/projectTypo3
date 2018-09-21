<?php
namespace DLD\Dld\Controller;

/***
 *
 * This file is part of the "DLD Conference" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * SettingController
 */
class SettingController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * settingRepository
     * 
     * @var \DLD\Dld\Domain\Repository\SettingRepository
     * @inject
     */
    protected $settingRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $settings = $this->settingRepository->findAll();
        $this->view->assign('settings', $settings);
    }

    /**
     * action show
     * 
     * @param \DLD\Dld\Domain\Model\Setting $setting
     * @return void
     */
    public function showAction(\DLD\Dld\Domain\Model\Setting $setting)
    {
        $this->view->assign('setting', $setting);
    }

    /**
     * action new
     * 
     * @return void
     */
    public function newAction()
    {

    }

    /**
     * action create
     * 
     * @param \DLD\Dld\Domain\Model\Setting $newSetting
     * @return void
     */
    public function createAction(\DLD\Dld\Domain\Model\Setting $newSetting)
    {
        //$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->settingRepository->add($newSetting);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \DLD\Dld\Domain\Model\Setting $setting
     * @ignorevalidation $setting
     * @return void
     */
    public function editAction(\DLD\Dld\Domain\Model\Setting $setting)
    {
        $this->view->assign('setting', $setting);
    }

    /**
     * action update
     * 
     * @param \DLD\Dld\Domain\Model\Setting $setting
     * @return void
     */
    public function updateAction(\DLD\Dld\Domain\Model\Setting $setting)
    {
        //$this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->settingRepository->update($setting);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \DLD\Dld\Domain\Model\Setting $setting
     * @return void
     */
    public function deleteAction(\DLD\Dld\Domain\Model\Setting $setting)
    {
        //$this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->settingRepository->remove($setting);
        $this->redirect('list');
    }
}
