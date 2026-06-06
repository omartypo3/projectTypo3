<?php
namespace Emagineurs\ENews\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Alex Kellner <alexander.kellner@in2code.de>, in2code
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use GeorgRinger\News\Domain\Model\Category;
use GeorgRinger\News\Domain\Model\DemandInterface;
use GeorgRinger\News\Service\CategoryService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * UserGroup Repository
 *
 * @package femanager
 * @license http://www.gnu.org/licenses/gpl.html
 *          GNU General Public License, version 3 or later
 */
class CategoriesRepository extends \GeorgRinger\News\Domain\Repository\CategoryRepository{
	/**
     * Find category tree
     *
     * @param array $rootIdList list of id s
     * @param string|null $startingPoint
     * @return array
     */
    public function findTree(array $rootIdList, ?string $startingPoint = null): array
    {
        $subCategories = CategoryService::getChildrenCategories(implode(',', $rootIdList));

        $idList = explode(',', $subCategories);
        if (empty($idList)) {
            return [];
        }

        $ordering = ['title' => QueryInterface::ORDER_ASCENDING];
        $categories = $this->findByIdList($idList, $ordering, $startingPoint);
        $flatCategories = [];
        /** @var Category $category */
        foreach ($categories as $category) {
            $flatCategories[$category->getUid()] = [
                'item' => $category,
                'parent' => ($category->getParentcategory()) ? $category->getParentcategory()->getUid() : null
            ];
        }

        $tree = [];

        // If leaves are selected without its parents selected, those are shown as parent
        foreach ($flatCategories as $id => &$flatCategory) {
            if (!isset($flatCategories[$flatCategory['parent']])) {
                $flatCategory['parent'] = null;
            }
        }

        foreach ($flatCategories as $id => &$node) {
            if ($node['parent'] === null) {
                $tree[$id] = &$node;
            } else {
                $flatCategories[$node['parent']]['children'][$id] = &$node;
            }
        }

        return $tree;
    }
}
