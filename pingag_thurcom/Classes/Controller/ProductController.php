<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 11.09.2017
 * Time: 10:55
 */

namespace Pingag\PingagThurcom\Controller;

use Pingag\PingagThurcom\Domain\Model\Product;

class ProductController extends BaseController
{

    /**
     * @return string
     */
    public function listAction()
    {
        $categories = explode(',', $this->getFlexformSetting('categories'));
        $products = $this->productRepo->findByCategories($categories);
        $productCategories = $this->getProductsByCategory($products->toArray());

        $this->view->assign('productCategories', $productCategories);
        return $this->view->render();
    }

    /**
     * @param Product $object
     * @return string
     */
    public function showAction(Product $object)
    {
        $this->view->assign('product', $object);
        return $this->view->render();
    }

    /**
     * @param array $products
     * @return array
     */
    protected function getProductsByCategory(array $products)
    {
        $productsByCategory = [];

        foreach ($products as $product) {
            foreach ($product->getCategories() as $category) {
                $productsByCategory[$category->getTitle()][] = $product;
            }
        }

        return $productsByCategory;
    }
}