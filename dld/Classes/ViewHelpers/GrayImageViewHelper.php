<?php

namespace DLD\Dld\ViewHelpers;


use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\AbstractFileFolder;
use TYPO3\CMS\Fluid\Core\ViewHelper\Exception;
use TYPO3\CMS\Frontend\Imaging\GifBuilder;

class GrayImageViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{
    /**
     * @param string $src a path to a file, a combined FAL identifier or an uid (int). If $treatIdAsReference is set, the integer is considered the uid of the sys_file_reference record. If you already got a FAL object, consider using the $image parameter instead

     *
     * @throws Exception
     * @throws \UnexpectedValueException
     * @return string Rendered tag
     */
    public function render($src = null)
    {


        $conf = [
            1 => 'IMAGE',
            '1.' => [
                'file' => 'fileadmin/'.$src
            ],
            20 => 'EFFECT',
            '20.' => [
                'value' => 'gray'
            ]
        ];
        $conf['XY'] = '[1.w],[1.h]';
        $conf['transparentBackground'] = true;
        /** @var GifBuilder $gifCreator */
        $gifCreator = GeneralUtility::makeInstance(GifBuilder::class);
        $gifCreator->init();
        $gifCreator->start($conf, []);
        $imageUri = $gifCreator->gifBuild();

        return $imageUri;

    }
}