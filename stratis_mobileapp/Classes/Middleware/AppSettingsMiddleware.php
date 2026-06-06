<?php

declare(strict_types=1);

namespace Stratis\StratisMobileapp\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stratis\StratisMobileapp\Service\AppSettingsService;

class AppSettingsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly AppSettingsService $appSettingsService
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->appSettingsService->supports($request)) {
            return $this->appSettingsService->buildResponse($request);
        }

        return $handler->handle($request);
    }
}

