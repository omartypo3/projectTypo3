<?php
namespace Emagineurs\ENews\Domain\Validator;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Xavier Ley <xley@e-magineurs.com>, e-magineurs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

use Emagineurs\ENews\Domain\Model\Enews;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class NewsValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {
    /**
     * Check if $value is valid. If it is not valid, needs to add an error
     * to result.
     *
     * @param mixed $value
     */
    public function isValid(mixed $value): void
    {
        if (!$value instanceof Enews) {
            $this->addError(
                LocalizationUtility::translate('LLL:EXT:e_news/Resources/Private/Language/locallang.xlf:tx_enews_domain_model_news.validator.wrongObjectType', 'e_news'),
                564645
            );
            return;
        }

        if (empty($value->getTitle())) {
            $this->addError(
                LocalizationUtility::translate('LLL:EXT:e_news/Resources/Private/Language/locallang.xlf:tx_enews_domain_model_news.validator.emptyTitle', 'e_news'),
                8414
            );
        }

        $correctDates = true;

        if ($value->getBegindate() === false) {
            $this->addError(
                LocalizationUtility::translate('LLL:EXT:e_news/Resources/Private/Language/locallang.xlf:tx_enews_domain_model_news.validator.dateBeginFormat', 'e_news'),
                871
            );
            $correctDates = false;
        }

        if ($value->getFinishdate() === false) {
            $this->addError(
                LocalizationUtility::translate('LLL:EXT:e_news/Resources/Private/Language/locallang.xlf:tx_enews_domain_model_news.validator.dateFinishFormat', 'e_news'),
                19871
            );
            $correctDates = false;
        }

        if ($correctDates && !empty($value->getFinishdate()) && (empty($value->getBegindate()) || $value->getBegindate() > $value->getFinishdate())) {
            $this->addError(
                LocalizationUtility::translate('LLL:EXT:e_news/Resources/Private/Language/locallang.xlf:tx_enews_domain_model_news.validator.dateOrder', 'e_news'),
                90879
            );
        }
    }
}