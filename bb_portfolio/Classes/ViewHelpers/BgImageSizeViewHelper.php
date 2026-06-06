<?php
namespace BravoBuero\BbPortfolio\ViewHelpers;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use T3SBS\T3sbootstrap\ViewHelpers\TYPO3\CMS\Core\Resource\Exception\InvalidFileNameException;
use T3SBS\T3sbootstrap\ViewHelpers\TYPO3\CMS\Core\Resource\Exception\InvalidPathException;
use T3SBS\T3sbootstrap\ViewHelpers\TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException;
use T3SBS\T3sbootstrap\ViewHelpers\TYPO3\CMS\Core\Resource\Exception\InvalidFileException;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\TimeTracker\TimeTracker;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3\CMS\Frontend\Resource\FilePathSanitizer;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 *
 * @package TYPO3
 * @subpackage T3S\T3sbootstrap;
 */
class BgImageSizeViewHelper extends AbstractViewHelper {

	/**
	 * Find FileReference objects by relation to other records
	 *
	 *
	 * @return void
	 */
	public function render()
	{
		$imageService = GeneralUtility::makeInstance(ImageService::class);
		$fileRepository = GeneralUtility::makeInstance(FileRepository::class);
		$uid = $this->arguments['uid'];
		$as = $this->arguments['as'];
		$tableName = $this->arguments['tableName'];
		$fieldName = $this->arguments['fieldName'];
		$data = $this->arguments['data'];
		$settings = $this->arguments['settings'];
		$filesFromRepository = $fileRepository->findByRelation($tableName, $fieldName, $uid);
		if (!isset($filesFromRepository[0])) {
			// fallback
			$filesFromRepository = $fileRepository->findByRelation($tableName, 'flexform_bgImage', $uid);
		}
		$pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
		if ($filesFromRepository) {

			$fileFromRepository = $filesFromRepository[0];
			$image = $this->imageService->getImage($fileFromRepository->getOriginalFile()->getUid(), $fileFromRepository->getOriginalFile(), 1);
			$imageUri_orig = $this->imageService->getImageUri($image, false);

			$processingInstructions = ['crop' => $fileFromRepository instanceof FileReference ? $fileFromRepository->getReferenceProperty('crop') : null];
			if($processingInstructions) {
				$image = $this->imageService->applyProcessingInstructions($image, $processingInstructions);
			}

			$bgImages = [];
			$mediaQueries = [768,992,1200,1920,2560];

			foreach ($mediaQueries as $key=>$querie) {

				$processedImage = $this->imageService->applyProcessingInstructions($image, ['width' => $querie, 'crop' => isset($processingInstructions['crop']) ? $processingInstructions['crop'] : null]);

				$bgImages[$querie] = $this->imageService->getImageUri($processedImage, false);

				if ($key === 0) {
					$imageUri_mobile = $bgImages[$querie];
				}
			}
			$bgImages['orig'] = $imageUri_orig;

			$pageRenderer->addInlineSetting('T3SBS',$data['uid'], json_encode($bgImages));

			$jsFooterFile = 'EXT:t3sbootstrap/Resources/Public/Scripts/bgImageSize.js';
			try {
				$jsFooterFile = GeneralUtility::makeInstance(FilePathSanitizer::class)->sanitize((string) $jsFooterFile);
			} catch (InvalidFileNameException $e) {
				$jsFooterFile = null;
			} catch (InvalidPathException|FileDoesNotExistException|InvalidFileException $e) {
				$jsFooterFile = null;
				if ($GLOBALS['TSFE']->tmpl->tt_track) {
					GeneralUtility::makeInstance(TimeTracker::class)->setTSlogMessage($e->getMessage(), 3);
				}
			}
			$pageRenderer->addJsFooterFile($jsFooterFile);

		} else {
			$imageUri_mobile = '';
		}
		if (isset($settings['wrapper']['minVh'])) {

			$pageRenderer->addInlineSetting('MINVH',$data['uid'], json_encode(1));

			$jsFooterFile = 'EXT:t3sbootstrap/Resources/Public/Scripts/bgImageHeight.js';
			try {
				$jsFooterFile = GeneralUtility::makeInstance(FilePathSanitizer::class)->sanitize((string) $jsFooterFile);
			} catch (InvalidFileNameException $e) {
				$jsFooterFile = null;
			} catch (InvalidPathException|FileDoesNotExistException|InvalidFileException $e) {
				$jsFooterFile = null;
				if ($GLOBALS['TSFE']->tmpl->tt_track) {
					GeneralUtility::makeInstance(TimeTracker::class)->setTSlogMessage($e->getMessage(), 3);
				}
			}
			$pageRenderer->addJsFooterFile($jsFooterFile);
		}
		$this->templateVariableContainer->add($as, $imageUri_mobile);
	}

	public function initializeArguments(): void
	{
		$this->registerArgument('uid', 'int', 'The UID of the related record (needs to be the localized uid, as translated IRRE elements relate to them)', true);
		$this->registerArgument('as', 'string', 'The alias to use for the found files', false, 'objects');
		$this->registerArgument('tableName', 'string', 'Table name of the related record', false, 'tt_content');
		$this->registerArgument('fieldName', 'string', 'Field name of the related record', false, 'assets');
		$this->registerArgument('data', 'array', '', false, []);
		$this->registerArgument('settings', 'mixed', '', false, []);
	}
}
