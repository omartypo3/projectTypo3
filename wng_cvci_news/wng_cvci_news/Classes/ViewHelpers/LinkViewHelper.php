<?php
namespace Wng\WngCvciNews\ViewHelpers;

use TYPO3\CMS\Core\Utility\ArrayUtility;
/**
 * Copyright (c) 2012, ROQUIN B.V. (C), http://www.roquin.nl
 *
 * @author:         Jochem de Groot <jochem@roquin.nl>
 * @file:           EventLinkViewHelper.php
 * @description:    ViewHelper to render proper links for event detail view
 */

class LinkViewHelper extends \GeorgRinger\News\ViewHelpers\LinkViewHelper {

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->overrideArgument('newsItem', \Wng\WngCvciNews\Domain\Model\Event::class, 'news item', true);
    }

    /**
     * Render link to news item or internal/external pages
     *
     * @param string $content optional content which is linked
     * @return string link
     */
    public function render()
    {
        /** @var News $newsItem */
        $newsItem = $this->arguments['newsItem'];
        $settings = $this->arguments['settings'];
        $uriOnly = $this->arguments['uriOnly'];
        $configuration = $this->arguments['configuration'];
        $content = $this->arguments['content'];

        $tsSettings = (array)$this->pluginSettingsService->getSettings();
        ArrayUtility::mergeRecursiveWithOverrule($tsSettings, (array)$settings);

        $this->init();

        if(!$newsItem->getEventIsEvent()) {
            return parent::render();
        }

        $tsSettings = $this->pluginSettingsService->getSettings();

        $this->init();

        $newsType = (int)$newsItem->getType();
        switch ($newsType) {
            // internal news
            case 1:
                $configuration['parameter'] = $newsItem->getInternalurl();
                break;
            // external news
            case 2:
                $configuration['parameter'] = $newsItem->getExternalurl();
                break;
            // normal news record
            default:

                $tsSettings['link']['skipControllerAndAction'] = 1;
                $configuration['additionalParams'] .= '&tx_news_pi1[controller]=Event&tx_news_pi1[action]=eventDetail';

                if($settings['event']['detailPid']) {
                    $tsSettings['defaultDetailPid'] = $settings['event']['detailPid'];
                    $tsSettings['detailPidDetermination'] = 'default';
                }
                $configuration = $this->getLinkToNewsItem($newsItem, $tsSettings, $configuration);
        }
        if (isset($tsSettings['link']['typesOpeningInNewWindow'])) {
            if (\TYPO3\CMS\Core\Utility\GeneralUtility::inList($tsSettings['link']['typesOpeningInNewWindow'], $newsType)) {
                $this->tag->addAttribute('target', '_blank');
            }
        }

        $url = $this->cObj->typoLink_URL($configuration);
        if ($uriOnly) {
            return $url;
        }

        $this->tag->addAttribute('href', $url);
        $this->tag->setContent($this->renderChildren());

        return $this->tag->render();
    }
}