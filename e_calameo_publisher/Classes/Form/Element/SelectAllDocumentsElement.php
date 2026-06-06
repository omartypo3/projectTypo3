<?php
declare(strict_types=1);

namespace Emagineurs\ECalameoPublisher\Form\Element;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * FormElement for "Select All Documents" checkbox
 */
class SelectAllDocumentsElement extends AbstractFormElement
{
    public function render(): array
    {
        $parameterArray = $this->data['parameterArray'];
        
        $fieldInformationResult = $this->renderFieldInformation();
        $fieldInformationHtml = $fieldInformationResult['html'];
        
        $resultArray = $this->mergeChildReturnIntoExistingResult(
            $this->initializeResultArray(),
            $fieldInformationResult,
            false
        );
        
        $fieldId = StringUtility::getUniqueId('formengine-selectall-');
        
        $html = [];
        $html[] = $this->renderLabel($fieldId);
        $html[] = '<div class="formengine-field-item t3js-formengine-field-item">';
        $html[] = $fieldInformationHtml;
        $html[] = '<div class="form-wizards-wrap">';
        $html[] = '<div class="form-wizards-element">';
        $html[] = '<div class="form-control-wrap">';
        $html[] = '<input type="checkbox" value="" id="' . htmlspecialchars($fieldId) . '" onchange="javascript: return selectAllPdf(this.checked);" />';
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';
        
        $resultArray['html'] = implode("\n", $html);
        
        return $resultArray;
    }
}

