<?php
declare(strict_types=1);

namespace Stratis\StratisSocialAuth\Utility;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class RequestUtility
 */
class RequestUtility
{
    /**
     * @return ServerRequestInterface|null
     */
    public static function getRequest(): ?ServerRequestInterface
    {
        if (($GLOBALS['TYPO3_REQUEST'] ?? null) instanceof ServerRequestInterface) {
            return $GLOBALS['TYPO3_REQUEST'];
        }

        return null;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public static function fromRequest(string $var): mixed
    {
        $request = self::getRequest();
        if ($request !== null) {
            return $request->getParsedBody()[$var] ?? $request->getQueryParams()[$var] ?? null;
        }

        return null;
    }
}
