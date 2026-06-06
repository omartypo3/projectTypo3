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

class OverwriteFlexForm
{
    /**
     * @var string
     */
    protected $path = 'FILE:EXT:pingag_address/Configuration/FlexForms/FlexformPi1.xml';

    /**
     * @var string
     */
    protected $pathProduct = 'FILE:EXT:pingag_address/Configuration/FlexForms/FlexformProduct.xml';

    /**
     * @return void
     */
    public function overwrite()
    {
        $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds']['powermail_pi1,list']
            = $this->path;
        $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds']['cartproducts_products,list']
            = $this->pathProduct;
    }

}