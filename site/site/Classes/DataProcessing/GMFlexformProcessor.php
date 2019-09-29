<?php
namespace sitetheme\site\DataProcessing;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Class FlexFormProcessor
 */
class GMFlexformProcessor implements DataProcessorInterface
{

    /**
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {

        $processedData['flexform'] = null;

        // set flexform
        if (isset($processedData['data']['pi_flexform']) && $processedData['data']['pi_flexform'] != '') {
            $processedData['flexform'] = self::convertFlexFormContentToArray($processedData['data']['pi_flexform']);
        }

        return $processedData;
    }

    /**
     * Convert XML to FlexForm
     *      Note: flexFormService->convertFlexFormContentToArray() seems to be broken for xml of facultymenu
     *
     * @param string $xml
     * @return array
     */
    public static function convertFlexFormContentToArray($xml)
    {
        $array = null;

        if (is_array($xml) === false) {
            $array = GeneralUtility::xml2array($xml);
        } else {
            $array = $xml;
        }

        $flexForm = [];

        if (isset($array['data'] )) {
            foreach ((array) $array['data'] as $sheetTitle => $sheet) {
                foreach ((array) $sheet['lDEF'] as $fieldTitle => $field) {

                    // simple
                    if (empty($field['el']) && !empty($field['vDEF'])) {
                        $flexForm[str_replace('settings.', '', $fieldTitle)] = $field['vDEF'];

                        // advanced
                    } elseif (!empty($field['el'])) {
                        foreach ((array) $field['el'] as $number => $fieldConfiguration) {
                            foreach ((array) array_keys($fieldConfiguration) as $key) {
                                if ($key[0] === '_') {
                                    continue;
                                }
                                foreach ((array) $fieldConfiguration[$key]['el'] as $fieldTitle2 => $field2) {
                                    $flexForm[str_replace('settings.', '', $fieldTitle)][$number][$key][$fieldTitle2] = $field2['vDEF'];
                                }
                            }
                        }
                    }
                }
            }
        }

		return $flexForm;
    }
}
