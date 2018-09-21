<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 12/07/2018
 * Time: 11:02
 */

namespace DLD\Dld\ViewHelpers;


use DLD\Dld\Domain\Model\Event;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class GetApplicationStatusViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * eventRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * @param int $eventpage
     * @return bool
     */
    public function render($eventpage)
    {

        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid , pi_flexform', 'tt_content', "deleted = 0 and pid =".$eventpage);
        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            $flexformService = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Service\FlexFormService');
            $data = $flexformService->convertFlexFormContentToArray($row['pi_flexform']);
            if (stripos(strrev($data['switchableControllerActions']), strrev('header'))==0) {
                if (array_key_exists('application', $data['settings'])) {

                    if ((int)$data['settings']['application'] == 1) {
                        return True;

                    }
                    else
                        return false;
                } else
                    return false;
            }

        }
        return false;
    }

}