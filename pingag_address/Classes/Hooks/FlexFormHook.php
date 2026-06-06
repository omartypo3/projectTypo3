<?php

namespace Pingag\PingagAddress\Hooks;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FlexFormHook
{
    /**
     * @param array $dataStructure
     * @param array $identifier
     * @return array
     */
    public function parseDataStructureByIdentifierPostProcess(array $dataStructure, array $identifier): array
    {
        if ($identifier['type'] === 'tca' && $identifier['tableName'] === 'tt_content' && $identifier['dataStructureKey'] === 'sfeventmgt_pieventregistration,list') {
            $file = Environment::getPublicPath() . '/typo3conf/ext/pingag_address/Configuration/FlexForms/newFields.xml';
            $content = file_get_contents($file);
            if ($content) {
                $dataStructure['sheets']['extraEntry'] = GeneralUtility::xml2array($content);
            }
        }
        return $dataStructure;
    }
}