<?php
namespace BravoBuero\BbPortfolio\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
class ChunkViewHelper extends AbstractViewHelper {

    /**
				 *
				 * @return array
				 */
				public function render()
				{
					$input = $this->arguments['input'];
					$size = $this->arguments['size'];
					$size = $size > 6 ? 6 : $size;
					if ( !is_array($input) ) $input = $this->object_to_array($input);
					return array_chunk($input, $size);
				}

    /**
     * @param object $data
     *
     * @return array
     */
    public function object_to_array($data) {

	        $result = [];
	        foreach ($data as $key => $value) {
	            $result[$key] = $value;
	        }
	        return $result;
	}

				public function initializeArguments(): void
				{
					$this->registerArgument('input', 'object', '', true);
					$this->registerArgument('size', 'integer', '', true);
				}


}
