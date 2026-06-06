<?php
declare(strict_types = 1);

/*
 * This file is part of the package bk2k/iconset-typo3.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace DslFactory\DslImmo\Icons;

use BK2K\BootstrapPackage\Icons\IconList;
use BK2K\BootstrapPackage\Icons\IconProviderInterface;
use BK2K\BootstrapPackage\Icons\SvgIcon;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class IconProvider implements IconProviderInterface
{
    public function getIdentifier(): string
    {
        return 'WewobauIonicons';
    }

    public function getName(): string
    {
        return 'WewobauIonicons';
    }

    public function supports(string $identifier): bool
    {
        return 'WewobauIonicons' === $identifier;
    }

    public function getIconList(): IconList
    {
        $icons = new IconList();
        $categories = [
            'actions',
            'apps',
            'content',
            'form',
            'mimetypes',
        ];

        /*$iconsBaseDirectory = 'EXT:dsl_iconfont/Resources/Public/Ionicons/';
        $iconsDefinitionFile = 'EXT:dsl_iconfont/Resources/Public/Contrib/typo3-icons/icons.json';
        $data = json_decode((string) GeneralUtility::getUrl(GeneralUtility::getFileAbsFileName($iconsDefinitionFile)), true, 512, JSON_THROW_ON_ERROR);
        foreach ($data['icons'] as $icon) {
            if (!in_array($icon['category'], $categories, true)) {
                continue;
            }
            $icons->addIcon(
                (new SvgIcon())
                    ->setSrc($iconsBaseDirectory . $icon['svg'])
                    ->setIdentifier($icon['identifier'])
                    ->setName($icon['identifier'])
                    ->setPreviewImage($iconsBaseDirectory . $icon['svg'])
            );
        }*/

        $directory = 'EXT:dsl_iconfont/Resources/Public/WewobauIonicons/';
        $path = GeneralUtility::getFileAbsFileName($directory);
        $files = iterator_to_array(new \FilesystemIterator($path, \FilesystemIterator::KEY_AS_PATHNAME));


        ksort($files);

        foreach ($files as $key => $fileinfo) {
            if ($fileinfo instanceof \SplFileInfo
                && $fileinfo->isFile()
                //&& strtolower($fileinfo->getExtension()) === 'svg'
            ) {
                $icons->addIcon(
                    (new SvgIcon())
                        ->setSrc($directory . $fileinfo->getFilename())
                        ->setIdentifier($directory . $fileinfo->getFilename())
                        ->setName($fileinfo->getBasename('.' . $fileinfo->getExtension()))
                        ->setPreviewImage($directory . $fileinfo->getFilename())
                );
            }
        }


        return $icons;
    }
}
