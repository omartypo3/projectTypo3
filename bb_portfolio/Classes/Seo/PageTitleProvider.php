<?php

declare(strict_types=1);

namespace BravoBuero\BbPortfolio\Seo;


use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;
use BravoBuero\BbPortfolio\Domain\Model\Portfolio;

/**
 * Generate page title based on properties of the portfolio model
 */
class PageTitleProvider extends AbstractPageTitleProvider
{

    /**
     * @param Portfolio $news
     */
    public function setTitleByPortfolio(Portfolio $portfolio): void
    {
        if ($portfolio->getSeoTitle()) {
            $this->title = $portfolio->getSeoTitle();
        } else {
            $this->title = $portfolio->getTitel();
        }
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
