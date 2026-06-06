<?php

namespace Stratis\StratisElements\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;

class FileDumpController
{
    /**
     * Main method to dump a file
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface|null
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws FileDoesNotExistException
     * @throws \UnexpectedValueException
     */
    public function dumpAction(ServerRequestInterface $request, ResponseInterface $response): ?ResponseInterface
    {
        $fileUid = (int)$this->getGetOrPost($request, 'f');

        if (!$fileUid) {
            $body = fopen('php://temp', 'r+');
            fwrite($body, 'Error: No file UID provided');
            rewind($body);
            return $response->withBody(new Stream($body))->withStatus(400);
        }

        try {
            $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            $file = $resourceFactory->getFileObject($fileUid);

            if ($file->isDeleted() || $file->isMissing()) {
                $body = fopen('php://temp', 'r+');
                fwrite($body, 'Error: File deleted or missing');
                rewind($body);
                return $response->withBody(new Stream($body))->withStatus(404);
            }

            // Get the public URL of the file
            $publicUrl = $file->getPublicUrl();
            
            // Return just the URL path
            $body = fopen('php://temp', 'r+');
            fwrite($body, $publicUrl);
            rewind($body);

            return $response
                ->withBody(new Stream($body))
                ->withHeader('Content-Type', 'text/plain')
                ->withStatus(200);
        } catch (\Exception $e) {
            // Return error message for debugging
            $body = fopen('php://temp', 'r+');
            fwrite($body, 'Error: ' . $e->getMessage());
            rewind($body);
            return $response->withBody(new Stream($body))->withStatus(500);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param string $parameter
     * @return string
     */
    protected function getGetOrPost(ServerRequestInterface $request, string $parameter): string
    {
        $value = $request->getParsedBody()[$parameter] ?? ($request->getQueryParams()[$parameter] ?? '');
        return (string)$value;
    }
}