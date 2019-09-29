<?php
namespace Silcoplastproduct\SilcoplastProduct\Domain\Repository;


/***
 *
 * This file is part of the "Silcoplast_Product" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 ons <ons.chaari@softtodo.com>, softtodo
 *
 ***/
/**
 * The repository for Categoryproducts
 */
class CategoryproductRepository extends \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
{
    public function initializeObject()
    {
        $defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $defaultQuerySettings->setRespectStoragePage(false);
        $defaultQuerySettings->setIgnoreEnableFields(true);
        $defaultQuerySettings->setEnableFieldsToBeIgnored(array('starttime', 'endtime'));
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }
}
