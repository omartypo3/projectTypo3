<?php

namespace Stratis\StratisElements\Form\Element;

use TYPO3\CMS\Backend\Form\Element\UserElement;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\ResourceFactory;

class ImageMapFormElement
{
    const MAP_HEIGHT = '400px';

    /**
     * @param array $parameters
     * @param UserElement $pObj
     * @return string
     */
    public function render(array &$parameters, &$pObj)
    {
        $reflection = new \ReflectionClass($pObj);
        $property = $reflection->getProperty('data');
        $property->setAccessible(true);
        $data = $property->getValue($pObj);

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile('EXT:stratis_elements/Resources/Public/Leaflet/leaflet.css');
        $pageRenderer->addJsFile('EXT:stratis_elements/Resources/Public/Leaflet/leaflet.js');
        $pageRenderer->addJsFile('EXT:stratis_elements/Resources/Public/Leaflet/main.js');

        $cssPath = GeneralUtility::getFileAbsFileName('EXT:stratis_elements/Resources/Public/Leaflet/leaflet.css');
        $cssUrl = PathUtility::getAbsoluteWebPath($cssPath);

        $jsPath = GeneralUtility::getFileAbsFileName('EXT:stratis_elements/Resources/Public/Leaflet/main.js');
        $jsUrl = PathUtility::getAbsoluteWebPath($jsPath);

        $id = str_replace(['[', ']'], ['_', '_'], $parameters['itemFormElName']);

        $value = $data['parameterArray']['itemFormElValue'] ?? '';
        
        $imageUrl = '';
        $table = $data['tableName'] ?? 'tt_content';
        $uid = $data['databaseRow']['uid'] ?? $data['vanillaUid'] ?? 0;
        
        if ($uid) {
            $imageUrl = $this->getImageUrlFromFal($table, (int)$uid);
        }

        $label = $data['parameterArray']['fieldConf']['label'] ?? '';


        
        $html = '';
        if ($label) {
            $html .= sprintf('<label for="input_%s" class="form-label t3js-formengine-label">%s</label>', $id, htmlspecialchars($label));
        }
        
        $html .= sprintf(
            '<div id="%s" class="leaflet-map-container" style="height: %s;" data-map-id="%s" data-image-url="%s" data-coords="%s"></div>',
            $id,
            self::MAP_HEIGHT,
            $id,
            htmlspecialchars($imageUrl),
            htmlspecialchars($value)
        );
        
        $html .= sprintf('<br /><input type="text" readonly class="form-control t3js-clearable hasDefaultValue" id="input_%s" name="%s" value="%s">', $id, $parameters['itemFormElName'], $value);

        return $html;
    }

    /**
     * Get the image URL from FAL field
     * 
     * @param string $table
     * @param int $uid
     * @return string
     */
    protected function getImageUrlFromFal(string $table, int $uid): string
    {
        if (empty($uid)) {
            return '';
        }

        try {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('sys_file_reference');

            $result = $queryBuilder
                ->select('uid_local')
                ->from('sys_file_reference')
                ->where(
                    $queryBuilder->expr()->eq('tablenames', $queryBuilder->createNamedParameter($table)),
                    $queryBuilder->expr()->eq('uid_foreign', $queryBuilder->createNamedParameter($uid)),
                    $queryBuilder->expr()->eq('fieldname', $queryBuilder->createNamedParameter('image'))
                )
                ->orderBy('sorting_foreign')
                ->setMaxResults(1)
                ->executeQuery()
                ->fetchAssociative();

            if ($result && $result['uid_local']) {
                $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
                $file = $resourceFactory->getFileObject((int)$result['uid_local']);
                return $file->getPublicUrl();
            }
        } catch (\Exception $e) {
        }

        return '';
    }
}