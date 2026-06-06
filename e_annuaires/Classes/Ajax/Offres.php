<?php

declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Ajax;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Offres
{
	public function main($request = null)
	{
		if ($request instanceof ServerRequestInterface) {
			$parsedBody = $request->getParsedBody();
		} else {
			$parsedBody = $_POST;
		}
		
		$this->execControllerAction($parsedBody['action'] ?? '', []);
		$result = $GLOBALS['BE_USER']->getSessionData($parsedBody['action'] ?? '');
		
		if ($request instanceof ServerRequestInterface) {
			return new JsonResponse($result);
		} else {
			return $result;
		}
	}

	public function execControllerAction(string $action, array $args, string $controller = 'Offre'): void
	{
		$conf['vendor'] = 'Emagineurs';
		$conf['extensionName'] = 'EAnnuaires';
		$conf['pluginName'] = 'annuaires';
		$conf['controller'] = $controller;

		$conf['action'] = $action;
		$conf['arguments'] = $args;

		$contentObj = GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Utility\AbstractLib::class);
		$content = $contentObj->callExtbaseAction($conf);
		// return $content;
	}
}