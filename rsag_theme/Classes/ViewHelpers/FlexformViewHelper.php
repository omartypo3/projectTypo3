<?php
declare(strict_types=1);

namespace RsagTheme\FluidFlexformViewHelper\ViewHelpers;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Service\FlexFormService;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * Usage example
 *
 * <html data-namespace-typo3-fluid="true" xmlns:ffvh="http://typo3.org/ns/Smichaelsen/FluidFlexformViewHelper/ViewHelpers">
 *  <ffvh:flexform data="{page.tx_fed_page_flexform}"> ..here you will have all flexform variables available.. </ffvh:flexform>
 * </html>
 */
class FlexformViewHelper extends AbstractViewHelper {

    /**
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('data', 'string', 'Flexform XML string', true);
        $this->registerArgument('key', 'string', 'Key', true);
    }

    public function render() {
        $arguments = $this->arguments;
        $dataArray = ArrayUtility::flatten(self::convertFlexFormContentToArray($arguments['data']));
        return $dataArray[$arguments['key']];
    }

    /**
     * @param string $flexFormContent flexForm xml string
     * @return array the processed array
     */
    static protected function convertFlexFormContentToArray(string $flexFormContent): array
    {
        if (empty($flexFormContent)) {
            return [];
        }
        $flexFormService = GeneralUtility::makeInstance(ObjectManager::class)->get(FlexFormService::class);
        return $flexFormService->convertFlexFormContentToArray($flexFormContent);
    }
}
