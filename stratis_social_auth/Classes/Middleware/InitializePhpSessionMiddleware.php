<?php

declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class InitializePhpSessionMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uriPath = $request->getUri()->getPath();

        if (!str_ends_with($uriPath, '/pdf') && session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $handler->handle($request);
    }
}
