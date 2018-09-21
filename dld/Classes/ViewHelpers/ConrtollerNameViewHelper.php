<?php
namespace DLD\Dld\ViewHelpers;

class ConrtollerNameViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    public function render() {
       return $this->controllerContext->getRequest()->getControllerName();
    }
}