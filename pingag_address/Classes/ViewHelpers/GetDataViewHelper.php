<?php
/**
 * Created by Visual Studio Code.
 * User: markus
 * Date: 26.06.17
 * Time: 15:57
 */

namespace Pingag\PingagAddress\ViewHelpers;

use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\Resource\FileCollector;
use Pingag\PingagClicConnector\Domain\Repository\ServiceRepository;

class GetDataViewHelper extends AbstractViewHelper {
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('uid','int','The record to be matched',true);

    }

    /**
     *
     * @return string
     */
    public function render()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $eventRepository = $objectManager->get('Pingag\\PingagAddress\\Domain\\Repository\\EventRepository');

        $record = $this->arguments['uid'];
        $eventByUid = $eventRepository->findByUid($record);
        $veranstaltungall = "";
        $veranstaltungalltitle = "";
        $veranstaltungId  = "";
        $veranstaltungIdtitle  = "";

        if($eventByUid->getVeranstaltung()) {
            foreach ($eventByUid->getVeranstaltung() as $veranstaltung) {
                $veranstaltungId .= $veranstaltung->getUid() . ", ";
                $veranstaltungall = rtrim($veranstaltungId, ",");

                $veranstaltungIdtitle .= $veranstaltung->getVeranstaltung() . ", ";
                $veranstaltungalltitle = rtrim($veranstaltungIdtitle, ", ");
            }
        }

        $zielgruppeall = "";
        $zielgruppealltitle = "";
        $zielgruppeId  = "";
        $zielgruppeIdtitle = "";
        if($eventByUid->getZielgruppe()) {
            foreach ($eventByUid->getZielgruppe() as $zielgruppe) {
                $zielgruppeId .= $zielgruppe->getUid() . ", ";
                $zielgruppeall = rtrim($zielgruppeId, ", ");

                $zielgruppeIdtitle .= $zielgruppe->getZielgruppe() . ", ";
                $zielgruppealltitle = rtrim($zielgruppeIdtitle, ", ");
            }
        }

        $kursthemenall = "";
        $kursthemenalltitle = "";
        $kursthemenId  = "";
        $kursthemenIdtitle  = "";
        if($eventByUid->getKursthemen()) {
            foreach ($eventByUid->getKursthemen() as $kursthemen) {
                $kursthemenId .= $kursthemen->getUid() . ", ";
                $kursthemenall = rtrim($kursthemenId, ", ");

                $kursthemenIdtitle .= $kursthemen->getKursthemen() . ", ";
                $kursthemenalltitle = rtrim($kursthemenIdtitle, ", ");
            }
        }

        $spracheall = "";
        $sprachealltitle = "";
        $spracheId  = "";
        $spracheIdtitle  = "";
        if($eventByUid->getSprache()) {
            foreach ($eventByUid->getSprache() as $sprache) {
                $spracheId .= $sprache->getUid() . ", ";
                $spracheall = rtrim($spracheId, ", ");

                $spracheIdtitle .= $sprache->getSprache() . ", ";
                $sprachealltitle = rtrim($spracheIdtitle, ", ");
            }
        }



        return array("veranstaltung"=>$veranstaltungall,"zielgruppe"=>$zielgruppeall,"kursthemen"=>$kursthemenall,"sprache"=>$spracheall,"veranstaltungtitle"=>$veranstaltungalltitle,"zielgruppetitle"=>$zielgruppealltitle,"kursthementitle"=>$kursthemenalltitle,"sprachetitle"=>$sprachealltitle);
    }
}

