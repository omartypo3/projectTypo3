<?php
namespace Emagineurs\EGestiondocs\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Claus Due <claus@namelesscoder.net>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Check if a document was newly created
 */
class IsNewDocumentViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('date', 'int', 'The document creation date timestamp', true);
        $this->registerArgument('newPeriod', 'int', 'Number of days to consider as new', true);
    }

    /**
     * Check if a document was newly created
     *
     * @return bool
     */
    public function render(): bool
    {
        $date = $this->arguments['date'];
        $newPeriod = $this->arguments['newPeriod'];
        
        return $date >= ((new \DateTime('now'))->getTimestamp() - ($newPeriod * 86400));
    }
}
