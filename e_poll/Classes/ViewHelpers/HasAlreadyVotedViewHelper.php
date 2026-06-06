<?php
namespace Emagineurs\EPoll\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Le Sommer Léo-Robin <llesommer@e-magineurs.com>
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
 ***************************************************************/

use Emagineurs\EPoll\Domain\Model\Poll;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
| * @package e_poll
| * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
| */
class HasAlreadyVotedViewHelper extends AbstractViewHelper {
    
    /**
     * Initialize arguments
     */
    public function initializeArguments(): void {
        $this->registerArgument('poll', Poll::class, 'The poll object', true);
        $this->registerArgument('settings', 'array', 'The settings array', true);
    }

    /**
     * Check if the current visitor can post to the poll
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return bool
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): bool {
        /** @var Poll $poll */
        $poll = $arguments['poll'];
        $settings = $arguments['settings'];
        
        return $poll->hasAlreadyVoted(
            $settings['verificationType'] ?? 'cookie', 
            (int)($settings['verificationPeriod'] ?? 0)
        );
    }
}