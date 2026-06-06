<?php

declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Ian Sebbagh <isebbagh@e-magineurs.com>
 *  (c) 2014 Cyrille Costa <ccosta@e-magineurs.com>
 *  (c) 2014 Vincent Scharpen <xley@e-magineurs.com>
 *  (c) 2014 Xavier Ley <xley@e-magineurs.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Core\Bootstrap;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Utility functions for repositories, content objects, and Extbase bootstrap
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AbstractLib
{
    
    public function getRepository(string $repoName): object
    {
        return GeneralUtility::makeInstance($repoName);
    }

    
    public function getCObj(): ContentObjectRenderer
    {
        $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $contentObject->start($contentObject->data);
        return $contentObject;
    }

   
    public function callExtbaseAction(array $conf): string
    {
        $configuration = [
            'vendorName'    => $conf['vendor'] ?? 'Emagineurs',
            'extensionName' => $conf['extensionName'] ?? 'EAnnuaires',
            'pluginName'    => $conf['pluginName'] ?? 'annuaires',
            'controller'    => $conf['controller'] ?? 'Conf\Conf',
            'action'        => $conf['action'] ?? 'index',
            'arguments'     => $conf['arguments'] ?? [],
        ];

        /** @var Bootstrap $bootstrap */
        $bootstrap = GeneralUtility::makeInstance(Bootstrap::class);

        try {
            $content = $bootstrap->run('', $configuration);
        } catch (\Throwable $e) {
            $content = 'Extbase call failed: ' . $e->getMessage();
        }

        return (string)$content;
    }

    /**
     * Return a localized string from locallang.xlf
     */
    public static function getLL(string $label): string
    {
        return $GLOBALS['LANG']->sL(
            'LLL:EXT:e_annuaires/Resources/Private/Language/locallang.xlf:' . $label
        );
    }
}
