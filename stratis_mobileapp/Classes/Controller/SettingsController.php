<?php

declare(strict_types=1);

namespace Stratis\StratisMobileapp\Controller;

use Psr\Http\Message\ResponseInterface;
use Stratis\StratisMobileapp\Service\AppSettingsService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SettingsController extends ActionController
{
    public function __construct(
        private readonly AppSettingsService $appSettingsService
    ) {
    }

    public function indexAction(): ResponseInterface
    {
        return $this->appSettingsService->buildResponse($this->request->getHttpRequest());
    }
}
