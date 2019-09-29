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

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
/**
 * ProductController
 */
class ProductController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * productRepository
     *
     * @var \Silcoplastproduct\SilcoplastProduct\Domain\Repository\ProductRepository
     * @inject
     */
    protected $productRepository = null;

    /**
     * categoryRepository
     *
     * @var  \Silcoplastproduct\SilcoplastProduct\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = null;

    /**
     * action list
     *
     * @return void
     */


    /*public function listAction()
    {
        if ($this->request->hasArgument('catid')) {
            $catid = $this->request->getArgument('catid');
            $categorie = $this->categoryRepository->findByUid($catid);
            if ($GLOBALS['TSFE']->sys_language_uid != 0) {
                $products = $this->productRepository->findByCategorie($categorie->_getProperty('_localizedUid'));
            } else {
                $products = $this->productRepository->findByCategorie($catid);
            }
        }

        $branchen = 'branchen';
        $tech = 'technologie';
        $catBranch = $this->categoryRepository->findUidparent($branchen);
        $catTech = $this->categoryRepository->findUidparent($tech);
        $this->view->assign("sysLanguageUid", $GLOBALS['TSFE']->sys_language_uid);
        //$categories=$this->categoryRepository->findAll();
        $this->view->assignMultiple(['products' => $products, 'categorie' => $categorie, 'cattech' => $catTech, 'catbranch' => $catBranch]);
    }*/


    public function listAction()
    {
        if ($this->request->hasArgument('catid')) {
            $catid = $this->request->getArgument('catid');
            $categorie = $this->categoryRepository->findByUid($catid);
            $products = array();
            foreach ($this->productRepository->findAll() as $product) {
                if ($GLOBALS['TSFE']->sys_language_uid != 0) {
                    $productsUid = $product->_getProperty('_localizedUid');
                } else {
                    $productsUid = $product->getUid();
                }
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category_record_mm');
                $rows = $queryBuilder
                    ->select('uid_foreign')
                    ->from('sys_category_record_mm')
                    ->Where(
                        "uid_local = " .$productsUid
                    )
                    ->execute();

                while ($r=$rows->fetch()){

                    if($r['uid_foreign'] == $catid){
                        array_push($products,$product);
                    }
                }
            }

        }else {

            $products = $this->productRepository->findAll();
        }

        $branchen = (int)$this->settings['branchenDE'];
        $tech = (int)$this->settings['techDE'];
        $catBranch = $this->categoryRepository->findChildren($branchen);
        $catTech = $this->categoryRepository->findChildren($tech);
        $this->view->assign("sysLanguageUid", $GLOBALS['TSFE']->sys_language_uid);
        //$categories=$this->categoryRepository->findAll();
        $this->view->assignMultiple(['products' => $products, 'categorie' => $categorie, 'cattech' => $catTech, 'catbranch' => $catBranch]);
    }

    /**
     * action show
     *
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Product $product
     *
     * @return void
     */
    public function showAction(\Silcoplastproduct\SilcoplastProduct\Domain\Model\Product $product)
    {
        /* make next and prev functionality Typo  */
        $checkvalue = $_GET['all'];
        $currentUID = $product->getUid();
        if ($checkvalue == null) {
            $cat = $product->getCategorie()->getUid();
            $products = $this->productRepository->findByCategorie($cat);
            $all = 0;
        } else {
            $products = $this->productRepository->findall();
            $all = 1;
        }
        $listproduid = [];
        for ($i = 0; $i < count($products); $i++) {
            array_push($listproduid, $products[$i]->getUid());
        }
        $posUid = array_search($currentUID, $listproduid);
        while (key($listproduid) < $posUid) {
            next($listproduid);
        }
        if ($posUid == (count($listproduid) - 1)) {
            $last = prev($listproduid);
            $firstlemnt = reset($listproduid);
            $nextproduct = $this->productRepository->findByUid($firstlemnt);
            $prevproduct = $this->productRepository->findByUid($last);
        } else if ($posUid == 0) {
            $next = next($listproduid);
            $lastelemnt = end($listproduid);
            $nextproduct = $this->productRepository->findByUid($next);
            $prevproduct = $this->productRepository->findByUid($lastelemnt);
        } else {
            $posnext = next($listproduid);
            prev($listproduid);
            $posprev = prev($listproduid);
            $nextproduct = $this->productRepository->findByUid($posnext);
            $prevproduct = $this->productRepository->findByUid($posprev);
        }
        // \TYPO3\CMS\Core\Utility\DebugUtility::debug(end($listproduid));
        $assignedValues = [
            'product' => $product,
            'nextproduct' => $nextproduct,
            'prevproduct' => $prevproduct,
            'categoryid' => $cat,
            'all' => $all,

        ];
        $this->view->assignMultiple($assignedValues);
        //  $this->view->assign('product', $product);
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
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Product $newProduct
     * @return void
     */
    public function createAction(\Silcoplastproduct\SilcoplastProduct\Domain\Model\Product $newProduct)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->productRepository->add($newProduct);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Product $product
     * @ignorevalidation $product
     * @return void
     */
    public function editAction(\Silcoplastproduct\SilcoplastProduct\Domain\Model\Product $product)
    {
        $this->view->assign('product', $product);
    }

    /**
     * action update
     *
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Product $product
     * @return void
     */
    public function updateAction(\Silcoplastproduct\SilcoplastProduct\Domain\Model\Product $product)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->productRepository->update($product);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \Silcoplastproduct\SilcoplastProduct\Domain\Model\Product $product
     * @return void
     */
    public function deleteAction(\Silcoplastproduct\SilcoplastProduct\Domain\Model\Product $product)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->productRepository->remove($product);
        $this->redirect('list');
    }

    /**
     * action slider
     *
     * @return void
     */
    public function sliderAction()
    {
        $branchen = (int)$this->settings['branchenDE'];
        $tech = (int)$this->settings['techDE'];
        $catBranch = $this->categoryRepository->findChildren($branchen);
        $catTech = $this->categoryRepository->findChildren($tech);

        $products = [];
        $ids = mbsplit(',', $this->settings['productslider']);

        foreach ($ids as $id) {
            $product = $this->productRepository->findByUid((int)$id);
            if(count($product) != 0){
                array_push($products,$product);
            }
        }
        $this->view->assignMultiple(['products' => $products, 'cattech' => $catTech, 'catbranch' => $catBranch]);
        $this->view->assign("sysLanguageUid", $GLOBALS['TSFE']->sys_language_uid);
    }

    /**
     * find children
     *
     * @param  int $lang
     * @param  int $parent
     *
     * @return void
     */

    public function findByChildrenAndLang($parent , $lang)
    {

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_category');
        $statement = $queryBuilder
            ->select('sys_category.*')
            ->from('sys_category')

            ->Where(
                "sys_language_uid = 1"
            )
            ->andWhere(
                "deleted = 0"
            )
            ->andWhere(
                "hidden = 0"
            )
            ->andWhere(
                "hidden = 0"
            )
            ->andWhere(
                "parent = 17"
            )

            ->execute();
        while ($row = $statement->fetch()) {
            return $row;
        }
    }
}
