<?php
namespace Emagineurs\EMagineurs\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Marvin Marchand <mmarchand@e-magineurs.com>
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

/**
 *
 *
 * @package e_magineurs
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use Emagineurs\ENews\Utility\MailUtility;

class Enews extends \Emagineurs\ENews\Controller\EnewsController{

	//Function to send a mail to user after the validation of his news
	public function sendUserMailAfterValidation(\Emagineurs\ENews\Domain\Model\Enews $news, $validate, $validationType){

		MailUtility::sendMail(
            array($news->getFeuser()->getEmail() => $news->getFeuser()->getLastName()),
            array($this->settings['validation']['admin']['senderEmail'] => $this->settings['validation']['admin']['senderName']),
            ($validate) ? $this->settings['validation']['admin']['subjectValidate'] :$this->settings['validation']['admin']['subjectRefused'],
            $this->settings['validation']['admin']['userValidationTemplate'],
            array(
                'news' => $news,
                'validate' => $validate,
                'settings' => $this->settings,
            )
        );

	}

}