<?php
namespace FRONTAL\FagInstitutionManagement\Controller;


/**
 * DatesController
 */
class DatesController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * datesRepository
     * 
     * @var \FRONTAL\FagInstitutionManagement\Domain\Repository\DatesRepository
     * @inject
     */
    protected $datesRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $dates = $this->datesRepository->findAll();
        $this->view->assign('dates', $dates);
    }

    /**
     * action show
     * 
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Dates $dates
     * @return void
     */
    public function showAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Dates $dates)
    {
        $this->view->assign('dates', $dates);
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
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Dates $newDates
     * @return void
     */
    public function createAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Dates $newDates)
    {
        \TYPO3\CMS\Core\Utility\DebugUtility::debug($newDates);die;
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->datesRepository->add($newDates);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Dates $dates
     * @ignorevalidation $dates
     * @return void
     */
    public function editAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Dates $dates)
    {
        $this->view->assign('dates', $dates);
    }

    /**
     * action update
     * 
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Dates $dates
     * @return void
     */
    public function updateAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Dates $dates)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->datesRepository->update($dates);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \FRONTAL\FagInstitutionManagement\Domain\Model\Dates $dates
     * @return void
     */
    public function deleteAction(\FRONTAL\FagInstitutionManagement\Domain\Model\Dates $dates)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->datesRepository->remove($dates);
        $this->redirect('list');
    }
}
