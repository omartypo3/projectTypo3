<?php
declare(strict_types=1);

namespace Emagineurs\EMagineurs\Domain\Validator;

use In2code\Powermail\Domain\Validator\AbstractValidator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Core\Http\ServerRequestFactory;
/**
 * This validator prevent possibility to send one form twice.
 *
 * Class SecurityValidator
 *
 * @author Vladimir Cherednichenko <vovacherednichenko@o-s-i.org>
 */
class SecurityValidator extends AbstractValidator
{
	const EXPIRE = 5;

	const FILE_LOCK_FOLDER = 'typo3temp/var/locks/';

	/**
	 * @inheritDoc
	 */
	public function isValid(mixed $value): void
	{
		$mail = $value;
		
		/** @var TypoScriptFrontendController|null $tsfe */
		$tsfe = $GLOBALS['TSFE'] ?? null;

		if (!$tsfe instanceof TypoScriptFrontendController) {
			return;
		}

		$pageUid = $tsfe->id ?? 0;

		/** @var FrontendUserAuthentication|null $session */
		$session = $tsfe->fe_user ?? null;

		if (!$session instanceof FrontendUserAuthentication) {
			return;
		}

		$formPageACL = $session->getSessionData('formPageACL') ?: [];

		if ($this->shouldValidate()) {
			$path = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/' . self::FILE_LOCK_FOLDER . 'form_' . $mail->getForm()->getUid() . '_sess_' . $session->id;

			// It is create action after confirmation page
			// So we check ACL for current pageUid
			if (!in_array($pageUid, $formPageACL)) {
				$this->redirectToFormPage($pageUid);
			}

			if (file_exists($path)) {
				$lastSubmit = (int)file_get_contents($path);
				if (time() - $lastSubmit <= self::EXPIRE) {
					$this->redirectToFormPage($pageUid);
				}
			}

			// After successful validation we need to remove current pageUid from ACL
			$index = array_search($pageUid, $formPageACL);
			unset($formPageACL[$index]);
			$session->setSessionData('formPageACL', $formPageACL);

			file_put_contents($path, time());
		} else {
			if (!in_array($pageUid, $formPageACL)) {
				$formPageACL[] = $pageUid;
			}

			$session->setSessionData('formPageACL', $formPageACL);
		}
	}

	/**
	 * Validate only if form contains confirmation page and it is create action called.
	 *
	 * @return bool
	 */
	protected function shouldValidate(): bool
	{
		if (!$this->isConfirmationActivated()) {
			return false;
		}
		
       	$request = ServerRequestFactory::fromGlobals();
		$arguments =  $request->getQueryParams()[$this->variablesPrefix];

		return $arguments['action'] === 'create';
	}

	/**
	 * @param int $pageUid
	 */
	protected function redirectToFormPage(int $pageUid): void
	{
		$uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
		$uri = $uriBuilder
			->reset()
			->setTargetPageUid($pageUid)
			->build();

		header('Location: ' . $uri);
		exit();
	}
}
