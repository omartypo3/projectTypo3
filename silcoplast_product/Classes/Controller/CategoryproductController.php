<?php
namespace Silcoplastproduct\SilcoplastProduct\Controller;


/***
 *
 * This file is part of the "Silcoplast_Product" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 ons <taieb.rekik@softtodo.com>, softtodo
 *
 ***/
/**
 * CategoryproductController
 */
class CategoryproductController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * categoryproductRepository
     * 
     * @var \Silcoplastproduct\SilcoplastProduct\Domain\Repository\CategoryproductRepository
     * @inject
     */
    protected $categoryproductRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $categoryproducts = $this->categoryproductRepository->findAll();
        $this->view->assign('categoryproducts', $categoryproducts);
    }

    /**
     * action show
     * 
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct $categoryproduct
     * @return void
     */
    public function showAction(\Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct $categoryproduct)
    {
        $this->view->assign('categoryproduct', $categoryproduct);
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
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct $newCategoryproduct
     * @return void
     */
    public function createAction(\Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct $newCategoryproduct)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->categoryproductRepository->add($newCategoryproduct);
        $this->redirect('list');
    }

    /**
     * action edit
     * 
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct $categoryproduct
     * @ignorevalidation $categoryproduct
     * @return void
     */
    public function editAction(\Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct $categoryproduct)
    {
        $this->view->assign('categoryproduct', $categoryproduct);
    }

    /**
     * action update
     * 
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct $categoryproduct
     * @return void
     */
    public function updateAction(\Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct $categoryproduct)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->categoryproductRepository->update($categoryproduct);
        $this->redirect('list');
    }

    /**
     * action delete
     * 
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct $categoryproduct
     * @return void
     */
    public function deleteAction(\Silcoplastproduct\SilcoplastProduct\Domain\Model\Categoryproduct $categoryproduct)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->categoryproductRepository->remove($categoryproduct);
        $this->redirect('list');
    }
}
