<?php

namespace Stratis\StratisElements\Form\Element;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;

class ImageMapFormElementAdapter extends AbstractFormElement
{
    /**
     * Render the image map form element
     *
     * @return array
     */
    public function render(): array
    {
        $result = $this->initializeResultArray();
        
        $legacyElement = new ImageMapFormElement();
        
        $parameters = [
            'itemFormElName' => $this->data['parameterArray']['itemFormElName'] ?? '',
            'itemFormElValue' => $this->data['parameterArray']['itemFormElValue'] ?? '',
        ];
        
        $pObj = new class {
            public $data;
        };
        
        $pObj->data = $this->data;
        
        $html = $legacyElement->render($parameters, $pObj);
        
        $result['html'] = $html;
        
        return $result;
    }
}

