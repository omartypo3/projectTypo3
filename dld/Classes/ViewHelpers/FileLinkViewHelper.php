<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 12/07/2018
 * Time: 11:02
 */

namespace DLD\Dld\ViewHelpers;


use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class FileLinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * eventRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * @param int $fileid
     * @return string
     */
    public function render($fileid)
    {

        $select_fields ='sys_file.identifier';
        $from_table    ='sys_file_reference  JOIN sys_file  ON sys_file_reference.uid_local = sys_file.uid';
        $where_clause  ='sys_file_reference.uid = '.$fileid;
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields, $from_table, $where_clause);

        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
            $siteUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
            return htmlspecialchars($siteUrl .'fileadmin'. $row['identifier']);
        }
        return '#';
    }

}