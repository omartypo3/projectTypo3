<?php

namespace Pingag\PingagAddress\Controller;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */


use Extcode\Cart\Service\SessionHandler;
use Extcode\Cart\Utility\CartUtility;
use Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand;
use Pingag\PingagAddress\Domain\Model\Product;
use Extcode\CartProducts\Domain\Repository\CategoryRepository;
use Pingag\PingagAddress\Domain\Repository\ProductRepository;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Web\RequestBuilder;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Core\Database\ConnectionPool;

class ProductController extends \Extcode\CartProducts\Controller\ProductController
{
    /**
     * @var \Extcode\Cart\Service\SessionHandler
     */
    protected $sessionHandler;

    /**
     * @var \Extcode\Cart\Utility\CartUtility
     */
    protected $cartUtility;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var array
     */
    protected $searchArguments;

    /**
     * @var array
     */
    protected $cartSettings = [];



    protected function initializeAction()
    {
        $this->cartSettings = $this->configurationManager->getConfiguration(
            ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
            'Cart'
        );

        if (!empty($GLOBALS['TSFE']) && is_object($GLOBALS['TSFE'])) {
            static $cacheTagsSet = false;

            /** @var $typoScriptFrontendController \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController */
            $typoScriptFrontendController = $GLOBALS['TSFE'];
            if (!$cacheTagsSet) {
                $typoScriptFrontendController->addCacheTags(['tx_cartproducts']);
                $cacheTagsSet = true;
            }
        }
        $this->productRepository = $this->objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\ProductRepository');
    }

    /**
     * Create the demand object which define which records will get shown
     */
    protected function createDemandObjectFromSettings(array $settings): ProductDemand
    {
        /** @var ProductDemand $demand */
        $demand = GeneralUtility::makeInstance(
            ProductDemand::class
        );

        if ($this->searchArguments['sku']) {
            $demand->setSku($this->searchArguments['sku']);
        }
        if ($this->searchArguments['title']) {
            $demand->setTitle($this->searchArguments['title']);
        }
        if ($settings['orderBy']) {
            $demand->setOrder($settings['orderBy'] . ' ' . $settings['orderDirection']);
        }

        $this->addCategoriesToDemandObjectFromSettings($demand);

        return $demand;
    }

    protected function addCategoriesToDemandObjectFromSettings(ProductDemand $demand): void
    {
        if ($this->settings['categoriesList']) {
            $selectedCategories = GeneralUtility::intExplode(
                ',',
                $this->settings['categoriesList'],
                true
            );

            $categories = [];

            if ($this->settings['listSubcategories']) {
                foreach ($selectedCategories as $selectedCategory) {
                    $category = $this->categoryRepository->findByUid($selectedCategory);
                    $categories = array_merge(
                        $categories,
                        $this->categoryRepository->findSubcategoriesRecursiveAsArray($category)
                    );
                }
            } else {
                $categories = $selectedCategories;
            }

            $demand->setCategories($categories);
        }
    }

    public function listAction(int $currentPage = 1): void
    {

        //die();
        $demand = $this->createDemandObjectFromSettings($this->settings);
        $demand->setActionAndClass(__METHOD__, __CLASS__);

        $itemsPerPage = $this->settings['itemsPerPage'] ?? 20;

        if($this->request->hasArgument('type')){
            $xmlString = $this->getFlexform($this->request->getArgument('record'));
            $flexFormData = GeneralUtility::xml2array($xmlString['pi_flexform']);
            $templateLayout = $flexFormData['data']['sDEF']['lDEF']['settings.templateLayout']['vDEF'];
            $showPageUids  = $flexFormData['data']['sDEF']['lDEF']['settings.showPageUids']['vDEF'];
            $categoriesList = $flexFormData['data']['sDEF']['lDEF']['settings.categoriesList']['vDEF'];

            $listSubcategories = $flexFormData['data']['sDEF']['lDEF']['settings.listSubcategories']['vDEF'];
            $productUids = $flexFormData['data']['sDEF']['lDEF']['settings.productUids']['vDEF'];
            $orderBy  = $flexFormData['data']['sDEF']['lDEF']['settings.orderBy']['vDEF'];
            $orderDirection = $flexFormData['data']['sDEF']['lDEF']['settings.orderDirection']['vDEF'];
            $settings = $this->settings;
            $settings['templateLayout'] = $templateLayout;
            $settings['showPageUids'] = $showPageUids;
            $settings['categoriesList'] = $categoriesList;
            $settings['listSubcategories'] = $listSubcategories;
            $settings['productUids'] = $productUids;
            $settings['orderBy'] = $orderBy;
            $settings['orderDirection'] = $orderDirection;
            $contentObj = $this->configurationManager->getContentObject();
            $pageId = $contentObj->data['uid'];
            $products = $this->productRepository->findProductAjax($settings,$this->request->getArgument('type'),$pageId ,$xmlString['pagesid']);
            $this->view->assign('settings', $settings);
            $this->view->assign('nbr', count($products));

        }else{
            //\TYPO3\CMS\Core\Utility\DebugUtility::debug($demand);
            //$demand->setOrder('Jahr desc') ;
            $products = $this->productRepository->findDemanded($demand);
        }


        //$products = $this->productRepository->findDemanded($demand);
        $arrayPaginator = new QueryResultPaginator(
            $products,
            $currentPage,
            $itemsPerPage
        );
        $pagination = new SimplePagination($arrayPaginator);
        $this->view->assignMultiple(
            [
                'products' => $products,
                'paginator' => $arrayPaginator,
                'pagination' => $pagination,
                'pages' => range(1, $pagination->getLastPageNumber()),
            ]
        );
        $this->view->assign('searchArguments', $this->searchArguments);
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags($products);
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("product")
     */
    public function showAction(Product $product = null): void
    {
        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($product);
        if (!$product) {
            $product = $this->getProduct();
        }
        if (!$product) {
            $this->forward('list');
        }

        $this->view->assign('user', $GLOBALS['TSFE']->fe_user->user);
        $this->view->assign('product', $product);
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags([$product]);
    }

    public function showFormAction(Product $product = null): void
    {
        if (!$product) {
            $product = $this->getProduct();
        }

        $this->view->assign('product', $product);
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->assignCurrencyTranslationData();
    }

    public function teaserAction(): void
    {
        $products = $this->productRepository->findByUids($this->settings['productUids']);

        $this->view->assign('products', $products);
        $this->view->assign('cartSettings', $this->cartSettings);

        $this->assignCurrencyTranslationData();

        $this->addCacheTags($products);
    }

    public function flexformAction(): void
    {
        $contentObj = $this->configurationManager->getContentObject();
        $contentId = $contentObj->data['uid'];

        $this->view->assign('contentId', $contentId);
    }

    protected function getProduct(): ?Product
    {
        $productUid = 0;

        if ((int)$GLOBALS['TSFE']->page['doktype'] === 183) {
            $productUid = (int)$GLOBALS['TSFE']->page['cart_products_product'];
        } else {
            if ($this->request->getPluginName() === 'ProductPartial') {
                if ($productUid === 0) {
                    $configurationManager = GeneralUtility::makeInstance(
                        ConfigurationManager::class
                    );
                    $configuration = $configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK);

                    $typoscriptService = GeneralUtility::makeInstance(
                        TypoScriptService::class
                    );
                    $configuration = $typoscriptService->convertPlainArrayToTypoScriptArray($configuration);
                    $productUid = (int)$configurationManager->getContentObject()->cObjGetSingle($configuration['product'], $configuration['product.']);
                }
                if ($productUid === 0) {
                    $requestBuilder = GeneralUtility::makeInstance(
                        RequestBuilder::class
                    );
                    $configurationManager = GeneralUtility::makeInstance(
                        ConfigurationManager::class
                    );
                    $configurationManager->setConfiguration([
                        'vendorName' => 'Extcode',
                        'extensionName' => 'CartProducts',
                        'pluginName' => 'Products',
                    ]);
                    $requestBuilder->injectConfigurationManager($configurationManager);

                    /**
                     * @var \TYPO3\CMS\Extbase\Mvc\Request $cartProductRequest
                     */
                    $cartProductRequest = $requestBuilder->build($this->request);

                    if ($cartProductRequest->hasArgument('product')) {
                        $productUid = (int)$cartProductRequest->getArgument('product');
                    }
                }
            }
        }

        if ($productUid > 0) {
            $productRepository = GeneralUtility::makeInstance(
                ProductRepository::class
            );

            $product =  $productRepository->findByUid($productUid);
        }

        return $product;
    }

    /**
     * assigns currency translation array to view
     */
    protected function assignCurrencyTranslationData()
    {
        if (TYPO3_MODE === 'FE') {
            $currencyTranslationData = [];

            $cart = $this->sessionHandler->restore($this->settings['cart']['pid']);

            if ($cart) {
                $currencyTranslationData['currencyCode'] = $cart->getCurrencyCode();
                $currencyTranslationData['currencySign'] = $cart->getCurrencySign();
                $currencyTranslationData['currencyTranslation'] = $cart->getCurrencyTranslation();
            }

            $this->view->assign('currencyTranslationData', $currencyTranslationData);
        }
    }

    protected function addCacheTags(iterable $products): void
    {
        $cacheTags = [];

        foreach ($products as $product) {
            // cache tag for each product record
            $cacheTags[] = 'tx_cartproducts_product_' . $product->getUid();
        }
        if (count($cacheTags) > 0) {
            $GLOBALS['TSFE']->addCacheTags($cacheTags);
        }
    }


    public function getFlexform($uid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable("tt_content");
        $result = $queryBuilder
            ->select('pi_flexform','pages')
            ->from("tt_content")
            ->where(
                $queryBuilder->expr()->eq('uid', $uid)
            )
            ->executeQuery();
        $row = $result->fetchAssociative();
        return array('pi_flexform'=>$row['pi_flexform'] , 'pagesid'=> $row['pages']);
    }

}
