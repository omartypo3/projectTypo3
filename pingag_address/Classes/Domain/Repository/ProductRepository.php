<?php

namespace Pingag\PingagAddress\Domain\Repository;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ProductRepository extends \Extcode\CartProducts\Domain\Repository\Product\ProductRepository
{

    public function findProductAjax($settings, $categoryUid,$pageUid,$pagesid)
    {
        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        $query = $this->createQuery();
        

        if ($categoryUid) {
            if($settings['categoriesList']){
                $query->statement('SELECT * FROM tx_cartproducts_domain_model_product_product,sys_category_record_mm WHERE sys_category_record_mm.uid_local IN('.$settings['categoriesList'].') AND sys_category_record_mm.uid_foreign = tx_cartproducts_domain_model_product_product.uid AND (tx_cartproducts_domain_model_product_product.title LIKE \'%' . $categoryUid . '%\'  OR tx_cartproducts_domain_model_product_product.sku LIKE \'%' . $categoryUid . '%\' OR tx_cartproducts_domain_model_product_product.Verfasser LIKE \'%' . $categoryUid . '%\' ) AND tx_cartproducts_domain_model_product_product.hidden = 0 AND tx_cartproducts_domain_model_product_product.deleted = 0 AND tx_cartproducts_domain_model_product_product.sys_language_uid = '.$sys_language_uid .' AND tx_cartproducts_domain_model_product_product.pid IN('.$pagesid.')');
            }else{

                $query->statement('SELECT * FROM tx_cartproducts_domain_model_product_product WHERE (title LIKE \'%' . $categoryUid . '%\' OR sku LIKE \'%' . $categoryUid . '%\' OR Verfasser LIKE \'%' . $categoryUid . '%\' )  AND tx_cartproducts_domain_model_product_product.hidden = 0 AND tx_cartproducts_domain_model_product_product.deleted = 0 AND tx_cartproducts_domain_model_product_product.sys_language_uid = '.$sys_language_uid .' AND tx_cartproducts_domain_model_product_product.pid IN('.$pagesid.')');
            }

        } else {
            if($pageUid != 123) {
                if ($settings['categoriesList']) {
                    $query->statement('SELECT * FROM tx_cartproducts_domain_model_product_product,sys_category_record_mm WHERE sys_category_record_mm.uid_local IN(' . $settings['categoriesList'] . ') AND sys_category_record_mm.uid_foreign = tx_cartproducts_domain_model_product_product.uid AND tx_cartproducts_domain_model_product_product.hidden = 0 AND tx_cartproducts_domain_model_product_product.deleted = 0 AND tx_cartproducts_domain_model_product_product.sys_language_uid = ' . $sys_language_uid .' AND tx_cartproducts_domain_model_product_product.pid IN('.$pagesid.')');
                } else {
                    $query->statement('SELECT * FROM tx_cartproducts_domain_model_product_product AND tx_cartproducts_domain_model_product_product.hidden = 0 AND tx_cartproducts_domain_model_product_product.deleted = 0  AND tx_cartproducts_domain_model_product_product.sys_language_uid = ' . $sys_language_uid .' AND tx_cartproducts_domain_model_product_product.pid IN('.$pagesid.')');
                }
            }
        }
        return $query->execute();

    }

    public function findProductORAjax($settings, $categoryUid,$pageUid,$pagesid)
    {
        // \TYPO3\CMS\Core\Utility\DebugUtility::debug($pagesid);

        $languageAspect = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class)->getAspect('language');
        $sys_language_uid = $languageAspect->getId();
        $query = $this->createQuery();
        if ($categoryUid) {
            if($settings['categoriesList']){
                $query->statement('SELECT * FROM tx_cartproducts_domain_model_product_product,sys_category_record_mm WHERE sys_category_record_mm.uid_local IN('.$settings['categoriesList'].') AND sys_category_record_mm.uid_foreign = tx_cartproducts_domain_model_product_product.uid AND tx_cartproducts_domain_model_product_product.title LIKE \'%' . $categoryUid . '%\'  AND tx_cartproducts_domain_model_product_product.hidden = 0 AND tx_cartproducts_domain_model_product_product.deleted = 0 AND tx_cartproducts_domain_model_product_product.sys_language_uid = '.$sys_language_uid .' AND tx_cartproducts_domain_model_product_product.pid IN('.$pagesid.')');
            }else{
                $query->statement('SELECT * FROM tx_cartproducts_domain_model_product_product WHERE title LIKE \'%' . $categoryUid . '%\'  AND tx_cartproducts_domain_model_product_product.hidden = 0 AND tx_cartproducts_domain_model_product_product.deleted = 0 AND tx_cartproducts_domain_model_product_product.sys_language_uid = '.$sys_language_uid .' AND tx_cartproducts_domain_model_product_product.pid IN('.$pagesid.')');
            }

        } else {
            if($pageUid != 123) {
                if ($settings['categoriesList']) {
                    $query->statement('SELECT * FROM tx_cartproducts_domain_model_product_product,sys_category_record_mm WHERE sys_category_record_mm.uid_local IN(' . $settings['categoriesList'] . ') AND sys_category_record_mm.uid_foreign = tx_cartproducts_domain_model_product_product.uid AND tx_cartproducts_domain_model_product_product.hidden = 0 AND tx_cartproducts_domain_model_product_product.deleted = 0 AND tx_cartproducts_domain_model_product_product.sys_language_uid = ' . $sys_language_uid .' AND tx_cartproducts_domain_model_product_product.pid IN('.$pagesid.')');
                } else {
                    $query->statement('SELECT * FROM tx_cartproducts_domain_model_product_product AND tx_cartproducts_domain_model_product_product.hidden = 0 AND tx_cartproducts_domain_model_product_product.deleted = 0  AND tx_cartproducts_domain_model_product_product.sys_language_uid = ' . $sys_language_uid .' AND tx_cartproducts_domain_model_product_product.pid IN('.$pagesid.')');
                }
            }
        }
        return $query->execute();

    }
}
