<?php

namespace Emagineurs\ECalameoPublisher\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Ian SEBBAGH <vscharpen@e-magineurs.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Resource\ProcessedFile;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Core\Environment;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\ServerRequestFactory;

class FileSystemUtility
{
	/**
	 * Execute a function for each file located into a directory
	 * @param string $directoryPath
	 * @param callable $callback This function take filename as argument
	 */
	public function readDirFiles($path, $callback, $typeFilter = null)
	{
		if (!is_dir($path)) {
			return;
		}

		$handle = @opendir($path);
		if ($handle === false) {
			return;
		}

		while ($file = readdir($handle)) {
			if ($file == '.' or $file == '..' or $file == '_temp_') {
				continue;
			}

			if (!empty($typeFilter)) {
				$extension = strtolower(pathinfo($path . $file, PATHINFO_EXTENSION) ?? '');
				if (GeneralUtility::inList($typeFilter, $extension)) {
					$callback($file);
				}
			} else {
				$callback($file);
			}
		}

		closedir($handle);
	}


	public function getCurrentDir(?ServerRequestInterface $request = null)
	{
		if ($request === null) {
			$request = ServerRequestFactory::fromGlobals();
		}

		// Get "id" query parameter (replaces _GP)
		$getFile = $request->getQueryParams()['id'] ?? null;

		$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);

		if ($getFile) {
			// Retrieve file or folder from FAL
			$fileOrFolderObject = $resourceFactory->retrieveFileOrFolderObject($getFile);
			
			// Get the storage and build the absolute path
			$storage = $fileOrFolderObject->getStorage();
			$storageConfig = $storage->getConfiguration();
			$basePath = $storageConfig['basePath'] ?? 'fileadmin/';
			
			// Build absolute path
			$absolutePath = Environment::getPublicPath() . '/' . rtrim($basePath, '/') . $fileOrFolderObject->getIdentifier();
			return $absolutePath;
		} else {
			$backendUser = $GLOBALS['BE_USER'] ?? null;
			if ($backendUser) {
				$fileStorages = $backendUser->getFileStorages();
				$fileStorage = reset($fileStorages);
				if ($fileStorage) {
					$storageConfig = $fileStorage->getConfiguration();
					$basePath = $storageConfig['basePath'] ?? 'fileadmin/';
					$identifier = $fileStorage->getRootLevelFolder()->getIdentifier();
					
					// Build absolute path
					$absolutePath = Environment::getPublicPath() . '/' . rtrim($basePath, '/') . $identifier;
					return $absolutePath;
				}
			}
		}

		return false;
	}

	/**
	 * Generate a thumbnail for a given file
	 * @param string $filepath
	 * @return string|false The thumbnail url if generated, false if failed
	 */
	public function generateThumbnail($filepath)
	{
		try {
			/** @var StorageRepository $storageRepository */
			$storageRepository = GeneralUtility::makeInstance(StorageRepository::class);
			$storage = $storageRepository->findByUid(1);

			if (!$storage) {
				return false;
			}

			$publicPath = Environment::getPublicPath() . '/';
			
			if (strpos($filepath, $publicPath) === 0) {
				$filepath = substr($filepath, strlen($publicPath));
			}
			
			$storageConfig = $storage->getConfiguration();
			$basePath = rtrim($storageConfig['basePath'] ?? 'fileadmin/', '/') . '/';
			
			$basePathPos = strpos($filepath, $basePath);
			if ($basePathPos === false) {
				$commonPaths = ['fileadmin/', 'user_upload/', 'uploads/'];
				foreach ($commonPaths as $commonPath) {
					$basePathPos = strpos($filepath, $commonPath);
					if ($basePathPos !== false) {
						$basePath = $commonPath;
						break;
					}
				}
			}
			
			if ($basePathPos === false) {
				return false;
			}
			
			$relativePath = substr($filepath, $basePathPos + strlen($basePath));
			
			$relativePath = $this->sanitizeFilePath($relativePath);
			
			$fileObject = $storage->getFile($relativePath);
			if (!$fileObject) {
				return false;
			}

			if ($fileObject instanceof \TYPO3\CMS\Core\Resource\File) {
				/** @var ProcessedFile $processedFile */
				$processedFile = $fileObject->process(ProcessedFile::CONTEXT_IMAGEPREVIEW, []);
				if ($processedFile) {
					return $processedFile->getPublicUrl();
				}
			}
			
			return $fileObject->getPublicUrl();
		} catch (\Exception $e) {
			return false;
		}
	}

	/**
	 * Sanitize file path to handle special characters and encoding issues
	 * @param string $path
	 * @return string
	 */
	protected function sanitizeFilePath($path)
	{
		// Check if path contains invalid UTF-8 or replacement characters
		if (preg_match('/[\x{FFFD}\x00-\x1F\x7F]/u', $path)) {
			$directory = dirname($path);
			$filename = basename($path);
			
			$publicPath = Environment::getPublicPath() . '/';
			$fullDir = $publicPath . 'fileadmin/' . $directory;
			
			if (!is_dir($fullDir)) {
				$fullDir = $publicPath . 'user_upload/' . $directory;
			}
			
			if (is_dir($fullDir)) {
				$files = scandir($fullDir);
				foreach ($files as $file) {
					if ($file === '.' || $file === '..') {
						continue;
					}
					$normalizedFile = preg_replace('/[^\x20-\x7E]/u', '?', $file);
					$normalizedSearch = preg_replace('/[^\x20-\x7E]/u', '?', $filename);
					
					if ($normalizedFile === $normalizedSearch) {
						return ($directory ? $directory . '/' : '') . $file;
					}
				}
			}
		}
		
		return $path;
	}
}
