<?php
declare(strict_types=1);

namespace Emagineurs\ECalameoPublisher\Form\Element;

use Emagineurs\ECalameoPublisher\Service\CalameoService;
use Emagineurs\ECalameoPublisher\Utility\TemplateUtility;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;
use TYPO3\CMS\Core\View\ViewFactoryInterface;

/**
 * FormElement for "Select Documents" - displays list of PDFs with checkboxes
 */
class SelectDocumentsElement extends AbstractFormElement
{
    public function render(): array
    {
        $parameterArray = $this->data['parameterArray'];
        $itemFormElName = $parameterArray['itemFormElName'];
        $itemFormElValue = $parameterArray['itemFormElValue'] ?? '';
        
        $fieldInformationResult = $this->renderFieldInformation();
        $fieldInformationHtml = $fieldInformationResult['html'];
        
        $resultArray = $this->mergeChildReturnIntoExistingResult(
            $this->initializeResultArray(),
            $fieldInformationResult,
            false
        );
        
        $fieldId = StringUtility::getUniqueId('formengine-selectdocuments-');
        
        // Get PDF list from CalameoService with proper dependency injection
        /** @var ExtensionConfiguration $extensionConfiguration */
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        /** @var CalameoService $ecpublish */
        $ecpublish = GeneralUtility::makeInstance(CalameoService::class, $extensionConfiguration);
        $ecpublish->ecpublish();
        
        $pdfList = [];
        foreach ($ecpublish->getList() as $id => $pdf) {
            $pdfList[] = [
                'id' => $id,
                'name' => $pdf['Name'],
                'thumbUrl' => $pdf['ThumbUrl'] ?? '',
                'selected' => strpos($itemFormElValue, $id) !== false,
            ];
        }
        
        // Get template utility to render the document selection with proper dependency injection
        /** @var ViewFactoryInterface $viewFactory */
        $viewFactory = GeneralUtility::makeInstance(ViewFactoryInterface::class);
        /** @var TemplateUtility $templateUtility */
        $templateUtility = GeneralUtility::makeInstance(TemplateUtility::class, $viewFactory);
        
        $assignments = [
            'pdfList' => $pdfList,
            'itemFormElValue' => $itemFormElValue,
            'itemFormElName' => $itemFormElName,
            'fieldChangeFunc' => $parameterArray['fieldChangeFunc'][0] ?? '',
        ];
        
        // Render templates
        $script = $templateUtility->getTemplateContents(
            'EXT:e_calameo_publisher/Resources/Private/Templates/Service/SelectDocuments.js',
            $assignments
        );
        $style = $templateUtility->getTemplateContents(
            'EXT:e_calameo_publisher/Resources/Private/Templates/Service/SelectDocuments.css',
            $assignments
        );
        $content = $templateUtility->getTemplateContents(
            'EXT:e_calameo_publisher/Resources/Private/Templates/Service/SelectDocuments.html',
            $assignments
        );
        
        $html = [];
        $html[] = $this->renderLabel($fieldId);
        $html[] = '<div class="formengine-field-item t3js-formengine-field-item">';
        $html[] = $fieldInformationHtml;
        $html[] = '<div class="form-wizards-wrap">';
        $html[] = '<div class="form-wizards-element">';
        $html[] = '<div class="form-control-wrap">';
        
        // Add style and script inline (template already includes them but we need them in the output)
        if (!empty($style)) {
            $html[] = '<style>' . $style . '</style>';
        }
        if (!empty($script)) {
            $html[] = '<script>' . $script . '</script>';
        }
        
        // Add the content (which includes the hidden field and checkboxes)
        $html[] = $content;
        
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';
        
        $resultArray['html'] = implode("\n", $html);
        
        return $resultArray;
    }
}

