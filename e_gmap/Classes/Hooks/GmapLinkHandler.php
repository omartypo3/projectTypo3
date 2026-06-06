<?php

namespace Emagineurs\EGmap\Hooks;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Recordlist\Controller\AbstractLinkBrowserController;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Recordlist\LinkHandler\LinkHandlerInterface;
use TYPO3\CMS\Recordlist\Tree\View\LinkParameterProviderInterface;

class GmapLinkHandler implements LinkHandlerInterface, LinkParameterProviderInterface
{

    /**
     * @var array
     */
    public $configuration;
    /**
     * @var AbstractLinkBrowserController
     */
    protected $linkBrowser;
    /**
     * Parts of the current link
     *
     * @var array
     */
    protected $linkParts = [];

    /**
     * @return array
     */
    public function getLinkAttributes()
    {
        return array();
    }

    /**
     * @param string[] $fieldDefinitions Array of link attribute field definitions
     * @return string[]
     */
    public function modifyLinkAttributes(array $fieldDefinitions)
    {
        return $fieldDefinitions;
    }

    /**
     * Initialize the handler
     *
     * @param AbstractLinkBrowserController $linkBrowser
     * @param string $identifier
     * @param array $configuration Page TSconfig
     *
     * @return void
     */
    public function initialize(AbstractLinkBrowserController $linkBrowser, $identifier, array $configuration)
    {
        $this->linkBrowser = $linkBrowser;
        $this->configuration = $configuration;
    }

    /**
     * Checks if this is the handler for the given link
     *
     * The handler may store this information locally for later usage.
     *
     * @param array $linkParts Link parts as returned from TypoLinkCodecService
     *
     * @return bool
     */
    public function canHandleLink(array $linkParts)
    {
        $this->linkParts = $linkParts;
        return false;
    }

    /**
     * Format the current link for HTML output
     *
     * @return string
     */
    public function formatCurrentUrl()
    {
        return serialize($this->linkParts);
    }

    /**
     * Render the link handler
     *
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    public function render(ServerRequestInterface $request)
    {
        GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class)->loadRequireJsModule('TYPO3/CMS/EGmap/GmapLinkHandler');

        $poiList = GeneralUtility::makeInstance(\Emagineurs\EGmap\Lib\BePoiList::class);
        try {
            $content = $poiList->getContent($this);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $content;
    }

    /**
     * Return TRUE if the handler supports to update a link.
     *
     * This is useful for file or page links, when only attributes are changed.
     *
     * @return bool
     */
    public function isUpdateSupported()
    {
        return true;
    }

    /**
     * @return string[] Array of body-tag attributes
     */
    public function getBodyTagAttributes()
    {
        if (empty($this->linkParts)) {
            return [];
        }
        return [
            'data-current-link' => $this->linkParts['pageId'] . ($this->linkParts['anchor'] !== '' ? '#' . $this->linkParts['anchor'] : '')
        ];
    }

    /**
     * Returns the URL of the current script
     *
     * @return string
     */
    public function getScriptUrl()
    {
        return $this->linkBrowser->getScriptUrl();
    }

    /**
     * @param array $values Array of values to include into the parameters or which might influence the parameters
     *
     * @return string[] Array of parameters which have to be added to URLs
     */
    public function getUrlParameters(array $values)
    {
        $parameters = [
            'expandPage' => isset($values['pid']) ? (int)$values['pid'] : $this->expandPage
        ];
        return array_merge($this->linkBrowser->getUrlParameters($values), $parameters);
    }

    /**
     * @param array $values Values to be checked
     *
     * @return bool Returns TRUE if the given values match the currently selected item
     */
    public function isCurrentlySelectedItem(array $values)
    {
        return !empty($this->linkParts) && (int)$this->linkParts['pageId'] === (int)$values['pid'];
    }

}