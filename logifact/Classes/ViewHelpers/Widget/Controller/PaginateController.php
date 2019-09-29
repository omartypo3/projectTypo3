<?php

namespace Logifacttheme\Logifact\ViewHelpers\Widget\Controller;

/**
 * This file is part of the "news" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Paginate controller to create the pagination.
 * Extended version from fluid core
 *
 */
class PaginateController extends \GeorgRinger\News\ViewHelpers\Widget\Controller\PaginateController
{



    /**
     * Main action
     *
     * @param int $currentPage
     * @param int $nbitems
     */
    public function indexAction($currentPage = 1, $nbitems = 0)
    {
        if ($nbitems) {
            $this->settings['list']['paginate']['itemsPerPage'] = strval($nbitems);
            $this->configuration['itemsPerPage'] = $nbitems;
        }
            // set current page
        $this->currentPage = (integer)$currentPage;
        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        }

        if ($this->currentPage > $this->numberOfPages) {
            // set $modifiedObjects to NULL if the page does not exist
            $modifiedObjects = null;
        } else {
            // modify query

            $itemsPerPage = (integer)$this->configuration['itemsPerPage'];

            $query = $this->objects->getQuery();
            $this->numberOfPages = (int)ceil((count($this->objects) - (int)$this->initialOffset) / $itemsPerPage);
            if ($this->currentPage === $this->numberOfPages && $this->initialLimit > 0) {
                $difference = $this->initialLimit - ((integer)($itemsPerPage * ($this->currentPage - 1)));
                if ($difference > 0) {
                    $query->setLimit($difference);
                } else {
                    $query->setLimit($itemsPerPage);
                }
            } else {
                $query->setLimit($itemsPerPage);
            }

            if ($this->currentPage > 1) {
                $offset = (integer)($itemsPerPage * ($this->currentPage - 1));
                $offset += $this->initialOffset;
                $query->setOffset($offset);
            } elseif ($this->initialOffset > 0) {
                $query->setOffset($this->initialOffset);
            }
            $modifiedObjects = $query->execute();
        }

        if ($this->currentPage > 1) {
            $pageLabel = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('paginate_overall', 'news', [$this->currentPage, $this->numberOfPages]);
            $GLOBALS['TSFE']->page['title'] = $GLOBALS['TSFE']->page['title'] . ' - ' . trim($pageLabel, '.');
        }

        $this->view->assign('contentArguments', [
            $this->widgetConfiguration['as'] => $modifiedObjects
        ]);
        $this->view->assign('configuration', $this->configuration);
        $this->view->assign('recordId', $this->recordId);
        $this->view->assign('pageId', $this->getCurrentPageId());
        $this->view->assign('pagination', $this->buildPagination());
        $this->templatePath = 'typo3conf/ext/logifact/Resources/Ext/News/Private/Templates/ViewHelpers/Widget/Paginate/Index.html';
        if (!empty($this->templatePath)) {
            $this->view->setTemplatePathAndFilename($this->templatePath);
        }
    }
}
