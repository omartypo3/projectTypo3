<?php
declare(strict_types = 1);
namespace DslFactory\DslProdukte\ViewHelpers;
 
/***************************************************************
*  Copyright notice
*
*  (c) 2013 Paul Beck <pb@teamgeist-medien.de>, Armin Ruediger Vieweg <info@professorweb.de>
*
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * This widget is a copy of the fluid paginate widget. Now it's possible to
 * use arrays with paginate, not only query results.
 *
 * @author     Paul Beck <pb@teamgeist-medien.de>
 * @author     Armin Ruediger Vieweg <info@professorweb.de>
 * @copyright  2011 Copyright belongs to the respective authors
 * @license    http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
 
class GettitleViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('uid', 'int', 'font size', FALSE);
    }
    public function render(){

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dslprodukte_domain_model_produkte');
        $statement = $queryBuilder
            ->select('titel')
            ->from('tx_dslprodukte_domain_model_produkte')
            ->where($queryBuilder->expr()->eq('l10n_parent', $this->arguments['uid']))
            ->execute();

        $rows = $statement->fetchAll();
        return $rows[0]['titel'];
    }


}