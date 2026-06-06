<?php

namespace Emagineurs\EGmap\Task;


/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 SEBBAGH Ian <isebbagh@e-magineurs.com>, E-magineurs
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
use \Emagineurs\EGmap\Lib\ELib;

class LocalizeTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask
{

    /**
     * Function execute from the Scheduler
     *
     * @return boolean TRUE on successful execution, FALSE on error
     */
    public function execute()
    {
        $this->initSettings();
        $this->debug = true;

        $this->tsconfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($this->pid);
        $this->tsconfig = $this->tsconfig['tx_egmap_localize.'];

        $this->recordList = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EGmap\Lib\LocalizeRecordList::class);
        $this->recordList->setConf($this->tsconfig, $this->pid);
        $rows = $this->recordList->getRows($this->table);

        $this->debugMessage = 'Traités : %d, dont %d erreurs.';
        $errors = 0;
        $traite = 0;
        if ($rows && $rows['toLocalize'] > 0) {
            $count = 1;
            foreach ($rows['rows'] as $row) {
                if ($count > $this->nbrec) {
                    return true;
                }

                if (!$row['status']) {
                    $rec = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EGmap\Lib\LocalizeRecord::class);
                    $rec->setConf($row, $this->tsconfig);
                    if (!$rec->setCoord()) {
                        $errors++;
                        $this->addErrorMessage($rec->debugCoord(), ' [ERREUR]');
                    }
                    //$this->debugMessage .= $rec->debugCoord().'<br>'."\n";
                    $count++;
                    sleep(1);
                }
            }
            $traite = $count - 1;
        } else {
            $this->debugMessage = 'Rien a faire.';
        }

        $this->debugMessage = sprintf($this->debugMessage, $traite, $errors);


        if ($errors > 0) {
            $this->debugMessage .= "\n" . 'Enregistrements problématiques :' . "\n" .
                $this->errorContent;
            $this->sendMail();
        }

        if ($this->debug) {
            $this->addMessage($this->debugMessage);
        }

        return true;
    }

    public function initSettings()
    {
        $page = \Emagineurs\EGmap\Lib\ELib::getRecord('pages', $this->pid);
        $pageTitle = '[' . $this->pid . '] ' . $page['title'];
        $tableTitle = $this->table;
        if (!empty($GLOBALS['TCA'][$tableTitle]['ctrl']['title'])) {
            $tableTitle = ELib::getLL($GLOBALS['TCA'][$tableTitle]['ctrl']['title']) . ' (' . $tableTitle . ')';
        }
        $this->name = $pageTitle . ' - ' . $tableTitle;
    }

    public function addErrorMessage($message, $title = '')
    {
        // $this->addMessage($message, $title='', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
        $this->errorContent .= $message . "\n";
    }

    public function sendMail()
    {
        $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
        $mail->setSubject(\Emagineurs\EGmap\Lib\ELib::getLL('LocalizeTask.name') . ' - ' . $this->name)
            ->setFrom(\TYPO3\CMS\Core\Utility\MailUtility::getSystemFrom())
            ->setTo(explode(';', $this->mailReport))
            ->setBody($this->debugMessage)
            ->send();

    }

    public function addMessage($message, $title = '', $severity = \TYPO3\CMS\Core\Messaging\FlashMessage::INFO)
    {
        if (!$this->moduleTemplate) {
            $this->moduleTemplate = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Backend\Template\ModuleTemplate::class);
        }

        $title = \Emagineurs\EGmap\Lib\ELib::getLL('LocalizeTask.name') . ' - ' . $this->name . $title;

        $this->moduleTemplate->addFlashMessage($message, $title, $severity);
    }

    /**
     * Returns some additional information about indexing progress, shown in
     * the scheduler's task overview list.
     *
     * @return    string    Information to display
     */
    public function getAdditionalInformation()
    {
        $this->initSettings();
        $message = $this->name . ' - par pas de ' . $this->nbrec;
        return $message;
    }

}
