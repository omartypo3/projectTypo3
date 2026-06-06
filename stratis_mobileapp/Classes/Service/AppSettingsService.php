<?php

declare(strict_types=1);

namespace Stratis\StratisMobileapp\Service;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\JsonResponse;

class AppSettingsService
{
    private const EXTKEY = 'stratis_mobileapp';
    private const TYPE_NUMBER = 1636457683;

    public function __construct(
        private readonly ExtensionConfiguration $extensionConfiguration,
        private readonly AppSettingsStorage $appSettingsStorage
    ) {
    }

    public function supports(ServerRequestInterface $request): bool
    {
        $pageType = $request->getAttribute('frontend.pageType');
        if ($pageType === self::TYPE_NUMBER) {
            return true;
        }

        $routing = $request->getAttribute('routing');
        if (is_array($routing) && isset($routing['pageType']) && (int)$routing['pageType'] === self::TYPE_NUMBER) {
            return true;
        }

        $queryParams = $request->getQueryParams();
        if (isset($queryParams['type']) && (int)$queryParams['type'] === self::TYPE_NUMBER) {
            return true;
        }

        $parsedBody = $request->getParsedBody();
        if (is_array($parsedBody) && isset($parsedBody['type']) && (int)$parsedBody['type'] === self::TYPE_NUMBER) {
            return true;
        }

        return false;
    }

    public function buildResponse(ServerRequestInterface $request): ResponseInterface
    {
        $record = $this->appSettingsStorage->fetch();
        if (!$record) {
            $record = $this->appSettingsStorage->save('1.0.0', null);
        }

        $record = $this->persistSettings($record, $request);

        $requestVersion = $this->resolveRequestValue($request, 'version');

        return new JsonResponse([
            'status' => $requestVersion === '' || $requestVersion === $record['version'],
            'version' => $record['version'],
        ]);
    }

    protected function persistSettings(array $record, ServerRequestInterface $request): array
    {
        $requestedVersion = $this->resolveRequestValue($request, 'version');
        $requestedKey = $this->resolveRequestValue($request, 'key');
        $versionToPersist = null;

        if ($requestedVersion !== '' && preg_match('/^\d{1,2}\.\d{1,2}\.\d{1,2}$/', $requestedVersion)) {
            try {
                $configuration = $this->extensionConfiguration->get(self::EXTKEY);
                $configuredKey = (string)($configuration['key'] ?? '');

                if ($configuredKey !== '' && hash_equals(md5($configuredKey), $requestedKey)) {
                    $versionToPersist = $requestedVersion;
                }
            } catch (\Throwable $throwable) {
            }
        }

        if ($versionToPersist !== null) {
            $record = $this->appSettingsStorage->save($versionToPersist, $record['uid'] ?? null);
        }

        return $record;
    }

    protected function resolveRequestValue(ServerRequestInterface $request, string $parameter): string
    {
        $value = $this->extractValueFromArray($request->getParsedBody(), $parameter);
        if ($value !== null) {
            return (string)$value;
        }

        $value = $this->extractValueFromArray($request->getQueryParams(), $parameter);
        if ($value !== null) {
            return (string)$value;
        }

        return '';
    }

    protected function extractValueFromArray(mixed $source, string $parameter): mixed
    {
        if (is_array($source) && array_key_exists($parameter, $source) && $source[$parameter] !== null) {
            return $source[$parameter];
        }

        return null;
    }
}

