<?php

declare(strict_types=1);

namespace DslFactory\DslIntranet\Controller;

use DslFactory\DslIntranet\Property\TypeConverter\UploadedFileReferenceConverter;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Property\PropertyMappingConfiguration;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\Processing\FileDeletionAspect;
use DslFactory\DslIntranet\Utility\FileUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2024 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 */

/**
 * AuftraegeController
 */
class AuftraegeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * auftraegeRepository
     *
     * @var \DslFactory\DslIntranet\Domain\Repository\AuftraegeRepository
     */
    protected $auftraegeRepository;

    /**
     * @param \DslFactory\DslIntranet\Domain\Repository\AuftraegeRepository $auftraegeRepository
     */
    public function injectAuftraegeRepository(\DslFactory\DslIntranet\Domain\Repository\AuftraegeRepository $auftraegeRepository)
    {
        $this->auftraegeRepository = $auftraegeRepository;
    }

	/**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->agenturvertraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AgenturvertraegeRepository');
        $this->aufgabenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AufgabenRepository');
        $this->protokollePendingRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokollePendingRepository');
        $this->wartungsvertraegeZeitraeumeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeZeitraeumeRepository');
        $this->wartungsvertraegeRechnungenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRechnungenRepository');
        $this->wartungsvertraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRepository');
        $this->fegroupsRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\FegroupsRepository');
        $this->dateienRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\DateienRepository');
        $this->auftragsartenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftragsartenRepository');
        $this->zeiteintraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ZeiteintraegeRepository');
        $this->trackerSegmenteRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\TrackerSegmenteRepository');
        $this->auftraegeRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeRepository');
        $this->auftraegeTexteRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\AuftraegeTexteRepository');
        $this->mitarbeiterRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\MitarbeiterRepository');
        $this->projekteRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProjekteRepository');
        $this->kundenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\KundenRepository');
        $this->lieferantenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\LieferantenRepository');
        $this->frontendUserRepository  = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
        $this->phasenRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\PhasenRepository');
        $this->protokolleRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');
        $this->notificationRepository  = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\NotificationRepository');

	}

    /**
     * action statistik
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function statistikAction(): \Psr\Http\Message\ResponseInterface
    {

        $rangeGesamt = $this->zeiteintraegeRepository->getAktivitaetenRange();
		
		
		if($rangeGesamt[1]){
        //var_dump($rangeGesamt);
			$datum = new \DateTime($rangeGesamt[1]);
			while ($datum->format('N') != 1) {
				$datum->sub(new \DateInterval('P1D'));
			}
			$filterZeitraum = array(
				'type' => 'Woche',
				'date' => $datum->format('d.m.Y')
			);
			//new \DateTime($this->request->getArgument('date')."-01-01")
			$this->view->assign('filterZeitraum', $filterZeitraum);
			$rangeGesamt = $this->zeiteintraegeRepository->getAktivitaetenRange();
//			print_r($filterZeitraum);
//			die;
			$aktivitaetenArr = $this->getStatistikDaten($filterZeitraum);
			/*?><pre><?php print_r($aktivitaetenArr);*/
			//die;/**/


			//print_r($rangeGesamt);
			//das ende auf ende des monats setzen
			$end = new \DateTime($rangeGesamt[1]);
			$end->modify('last day of this month');
			$rangeGesamt[1] = $end->format('Y-m-d H:i:s');
			//print_r($aktivitaetenArr);die;

			$this->view->assign('rangeGesamt', $rangeGesamt);
			$this->view->assign('statistikDaten', $aktivitaetenArr);

		}

        return $this->htmlResponse();
    }

    /**
     * @param $filterZeitraum
     */
    private function getStatistikDaten($filterZeitraum)
    {
        switch ($filterZeitraum['type']) {
            case 'Jahr':    $filterZeitraum['datevar'] = new \DateTime($filterZeitraum['date'] . '-01-01');
                $titel = 'Diagramm für ' . $filterZeitraum['date'];
                break;
            case 'MonatJahr':    $dateArr = explode(' ', $filterZeitraum['date']);
                $monat = str_replace(array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'), array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'), $dateArr[0]);
                $filterZeitraum['datevar'] = new \DateTime($dateArr[1] . '-' . $monat . '-01');
                $titel = 'Diagramm für ' . $filterZeitraum['date'];
                break;
            case 'Woche':
                /*
                $dateArr = explode(' ',$filterZeitraum["date"]);
                $monat = str_replace(array("Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag","Sonntag","August","September","Oktober","November","Dezember"),array("01","02","03","04","05","06","07","08","09","10","11","12"),$dateArr[0]);
                */
                $filterZeitraum['datevar'] = new \DateTime($filterZeitraum['date']);
                $bis = clone $filterZeitraum['datevar'];
                $bis->add(new \DateInterval('P6D'));

                //print_r($filterZeitraum);die;
                $titel = 'Diagramm für KW ' . ((strftime('%U', $filterZeitraum['datevar']->getTimestamp()))+1).' / '.$filterZeitraum['datevar']->format("d.m.").' - '.$bis->format("d.m.Y");

                break;
        }
        $aktivitaetenArr = array(
            'diagrammMax' => 1080,
            'max' => 862,
            'avg' => 420.0833333333333,
            'titel' => $titel,
            'diagrammStepSize' => 50
        );
        //	var_dump($aktivitaetenArr);
        //die;
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        $aktivitaetenArr['data'] = (object) array(
            'range' => array(),
            'labels' => array(),
            'datasets' => array(

            )
        );

        $feiertage = \DslFactory\DslIntranet\Utility\FeiertageUtility::init();
		
        //setHeaderLabel
        switch ($filterZeitraum['type']) {
            case 'Jahr':    $feiertageArr = $feiertage->getFeiertageFuerJahr($filterZeitraum['datevar']->format('Y'));
                //	print_r($feiertageArr );
                for ($x = 1; $x <= 12; $x++) {
                    $kontingent = 0;
                    //echo "monat:";
                    $start = new \DateTime($filterZeitraum['datevar']->format('Y') . '-' . str_pad((string)$x, 2, '0', STR_PAD_LEFT) . '-01 00:00:00');
                    $end = clone $start;
                    $end->add(new \DateInterval('P1M'));
                    $startTag = clone $start;
                    while ($end > $startTag) {
                        //N
                        if ($startTag->format('N') < 6) {
                            //wochentag
                            if (!isset($feiertageArr[$startTag->format('Y-m-d')])) {
                                //summieren
                                $kontingent += 480;
                            } else {

                            }
                        }
                        $startTag->add(new \DateInterval('P1D'));
                    }
                    //die;
                    $maxLineArr['50'][] = $kontingent / 2;
                    $maxLineArr['100'][] = $kontingent;
                    /*
                    					$maxLineArr = [
                    						"50" => [4800,4800,4800,4800,4800,4800,4800,4800,4800,4800,4800,4800],
                    						"100" => [9600,9600,9600,9600,9600,9600,9600,9600,9600,9600,9600,9600]
                    					];*/

                    $aktivitaetenArr['data']->range[] = array($start, $end);
                    $aktivitaetenArr['data']->labels[] = strftime('%B', $start->getTimestamp());
                }


                $balkenMax = 25 * 8 * 60;
                $aktivitaetenArr['diagrammStepSize'] = ceil($balkenMax / 5);
                $aktivitaetenArr['diagrammMax'] = $balkenMax;
                break;
            case 'Woche':    $start = clone $filterZeitraum['datevar'];
                $end = clone $start;
                $end->add(new \DateInterval('P1W'));
                $maxLineArr = array();
                $englishToGermanDays = [
                    'Monday'    => 'Montag',
                    'Tuesday'   => 'Dienstag',
                    'Wednesday' => 'Mittwoch',
                    'Thursday'  => 'Donnerstag',
                    'Friday'    => 'Freitag',
                    'Saturday'  => 'Samstag',
                    'Sunday'    => 'Sonntag'
                ];
                while ($end > $start) {
                    $jahr = $start->format('Y');

					if (isset($maxLineArr['50']) && is_array($maxLineArr['50']) && count($maxLineArr['50']) < 5) {
						if (!isset($feiertageArr[$jahr])) {
                            $feiertageArr[$jahr] = $feiertage->getFeiertageFuerJahr($jahr);
                        }
                        if (!isset($feiertageArr[$jahr][$start->format('Y-m-d')])) {
                            $kontingent += 480;
                            $maxLineArr['50'][] = 240;
                            $maxLineArr['100'][] = 480;
                        } else {
                            $maxLineArr['50'][] = 0;
                            $maxLineArr['100'][] = 0;
                        }
					} elseif (is_null($maxLineArr['50'])) {
						if (!isset($feiertageArr[$jahr])) {
                            $feiertageArr[$jahr] = $feiertage->getFeiertageFuerJahr($jahr);
                        }
                        if (!isset($feiertageArr[$jahr][$start->format('Y-m-d')])) {
                            $kontingent += 480;
                            $maxLineArr['50'][] = 240;
                            $maxLineArr['100'][] = 480;
                        } else {
                            $maxLineArr['50'][] = 0;
                            $maxLineArr['100'][] = 0;
                        }
					}
                    $englishDay = $start->format('l'); // Full English day name (e.g., "Monday")
                    $germanDay = $englishToGermanDays[$englishDay];
                   // setlocale(LC_TIME, 'de_DE.UTF-8', 'de_DE', 'de', 'german');
                    //echo "ist nochgrößer"	;
                    $aktivitaetenArr['data']->range[] = array(new \DateTime($start->format('Y-m-d 00:00:00')), new \DateTime($start->format('Y-m-d 23:59:59')));
                    $aktivitaetenArr['data']->labels[] = $germanDay . ' - ' . $start->format('d.m.');
//                    print_r($aktivitaetenArr['data']);
//                    die;
                    $start->add(new \DateInterval('P1D'));
                }
                $balkenMax = 540;
                $aktivitaetenArr['diagrammStepSize'] = ceil($balkenMax / 9);
                $aktivitaetenArr['diagrammMax'] = $balkenMax;
                //die;
                break;
            case 'MonatJahr':    //echo "monatJahr";
                //echo "start:".$filterZeitraum['datevar']->format('d.m.Y');
                $start = clone $filterZeitraum['datevar'];

                $weekDay = intval($start->format("w"));
                if($weekDay==0){
                    $start->sub(new \DateInterval('P6D'));
                } elseif($weekDay>1){
                    $start->sub(new \DateInterval('P'.($weekDay-1).'D'));
                }
                $end = clone $start;
                $end->add(new \DateInterval('P14D'));
                $end->modify('last day of this month');
                $lastDayOfMonth = clone $end;
                $weekDay = intval($end->format("w"));
                if($weekDay>0){
                    $end->add(new \DateInterval('P'.(7-$weekDay).'D'));
                }

                $startWoche = false;
                $endWoche = false;
                $kontingent = 0;
                while ($end >= $start) {
                    //echo "ist nochgrößer"	;
                    //echo $start->format('d.m.Y');

                    $weekDay = intval($start->format("w"));
                    if($weekDay==1){
                        $startWoche = clone $start;
                    }
                    if($weekDay==0){
                        $endWoche = clone $start;
                    }

                    if($start<=$lastDayOfMonth && $start>=$filterZeitraum['datevar']){

                        if($weekDay>0 && $weekDay<6){
                            $jahr = $start->format('Y');
                            if(!isset($feiertageArr[$jahr])) {
                                $feiertageArr[$jahr] = $feiertage->getFeiertageFuerJahr($jahr);
                            }
                            if (!isset($feiertageArr[$jahr][$start->format('Y-m-d')])) {
                                $kontingent += 480;
                            }
                        }
                    }




                    if($startWoche && $endWoche){

                        $rangeStart = new \DateTime($startWoche->format('Y-m-d 00:00:00'));
                        if($rangeStart<$filterZeitraum['datevar']) $rangeStart = $filterZeitraum['datevar'];

                        $rangeEnd = new \DateTime($endWoche->format('Y-m-d 23:59:59'));
                        if($rangeEnd>$lastDayOfMonth) $rangeEnd=$lastDayOfMonth;
                        //if($filterZeitraum['datevar']>)

                        $aktivitaetenArr['data']->range[] = array($rangeStart,$rangeEnd );
                        // $aktivitaetenArr['data']->range[] = array(new \DateTime($startWoche->format('Y-m-d 00:00:00')), new \DateTime($endWoche->format('Y-m-d 23:59:59')));
                        $aktivitaetenArr['data']->labels[] = 'KW '.$startWoche->format('W').' / '.$rangeStart->format('d.m.') . ' - '.$rangeEnd->format('d.m.y');
                        $maxLineArr['50'][] = $kontingent/2;
                        $maxLineArr['100'][] = $kontingent;

                        $startWoche = false;
                        $endWoche = false;
                        $kontingent = 0;

                    }

                    //$aktivitaetenArr['data']->range[] = array(new \DateTime($start->format('Y-m-d 00:00:00')), new \DateTime($start->format('Y-m-d 23:59:59')));
                    //$aktivitaetenArr['data']->labels[] = $start->format('j') . '.';
                    $start->add(new \DateInterval('P1D'));
                }



                $balkenMax = 2700;
                $aktivitaetenArr['diagrammStepSize'] = ceil($balkenMax / 9);
                $aktivitaetenArr['diagrammMax'] = $balkenMax;

                break;
        }
        $aktivitaetenArr["titel"].=" (max: ".(array_sum($maxLineArr['100'])/60)."h)";

        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        foreach ($mitarbeiters as $mitarbeiter) {
            /*$aktivitaeten = $this->zeiteintraegeRepository->findAktivitaetenInRange(new \DateTime('2019-10-01'),new \DateTime('2019-10-31'), $mitarbeiter);*/
            //$aktivitaetArr = array();
            /*
            foreach($aktivitaeten as $aktivitaet){
            	$aktivitaetArr[] = $aktivitaet->getUid();
            }
            */

            //$aktivitaetenArr[$mitarbeiter->getUid()] = array("aktivitaet"=>$aktivitaetArr,"anzahl"=>count($aktivitaeten));
            $dataArr = array();
            foreach ($aktivitaetenArr['data']->range as $rangeKey => $range) {
                $dataArr[$rangeKey] = $this->zeiteintraegeRepository->findAktivitaetenInRange($range[0], $range[1], $mitarbeiter);
            }
            //			$dataArr = [10,20,130,40,50,60,70,80,90,100,110,120];
            if (!array_sum($dataArr)) {
                continue;
            }
            if ($filterZeitraum['type'] == 'Woche') {
                if (!$dataArr[5] && !$dataArr[5]) {
                    unset($dataArr[5]);
                    unset($dataArr[6]);
                    unset($aktivitaetenArr['data']->labels[5]);
                    unset($aktivitaetenArr['data']->labels[6]);
                }
            }
            //$aktivitaetenArr['data']->labels[]
            //$aktivitaetenArr['data']->datasets[]
            $aktivitaetenArr['data']->datasets[] = (object) array(
                'type' => 'bar',
                'label' => $mitarbeiter->getInitialien(),//$mitarbeiter->getName().
                'backgroundColor' => '' . $mitarbeiter->getFarbe(),
                'borderColor' => '' . $mitarbeiter->getFarbe(),
                'borderWidth' => 1,
                'order' => 19,
                'data' => $dataArr
            );
        }
        $aktivitaetenArr['data']->datasets[] = (object) array(
            'type' => 'line',
            'label' => '50%',
            'backgroundColor' => 'orange',
            'borderColor' => 'orange',
            'borderWidth' => 1,
            'fill' => false,
            'cubicInterpolationMode' => 'monotone',
            'order' => 10,
            'data' => $maxLineArr['50']

        );
        $aktivitaetenArr['data']->datasets[] = (object) array(
            'type' => 'line',
            'label' => '100%',
            'backgroundColor' => 'red',
            'borderColor' => 'red',
            'borderWidth' => 1,
            'fill' => false,
            'cubicInterpolationMode' => 'monotone',
            'order' => 10,
            'data' => $maxLineArr['100']
        );
        /*
        		{
        				type: 'line',
        				label: 'Maximal',
        				backgroundColor: color('rgb(255, 255, 255)').alpha(0.8).rgbString(),//red
        				borderColor: 'rgb(255, 0, 0)',//red
        				borderWidth: 1,
        				fill: false,
        				cubicInterpolationMode: 'monotone',
        				data: [
        					diagramm.monat[1].kontingentJeMonat,diagramm.monat[2].kontingentJeMonat,diagramm.monat[3].kontingentJeMonat,diagramm.monat[4].kontingentJeMonat,diagramm.monat[5].kontingentJeMonat,diagramm.monat[6].kontingentJeMonat,diagramm.monat[7].kontingentJeMonat,diagramm.monat[8].kontingentJeMonat,diagramm.monat[9].kontingentJeMonat,diagramm.monat[10].kontingentJeMonat,diagramm.monat[11].kontingentJeMonat,diagramm.monat[12].kontingentJeMonat

        				],
        				yAxisID: 'y-axis-2'
        			}*/

        /*	?><pre><?php 	print_r($aktivitaetenArr);*/
        $balken = count($aktivitaetenArr['data']->labels);
        $balkenArr = array();
        $balkenMax = 0;
        for ($x = 0; $x < $balken; $x++) {
            $balkenArr[$x] = array();
            foreach ($aktivitaetenArr['data']->datasets as $dataset) {
				if(isset($dataset->data[$x])){
					$balkenArr[$x][] = $dataset->data[$x];
				}
            }
            //	echo $x;
            $balkenArr[$x] = array_sum($balkenArr[$x]);
            if ($balkenMax < $balkenArr[$x]) {
                $balkenMax = $balkenArr[$x];
            }
        }
        /*

        ?><pre><?php print_r($balkenArr);
        */

        //$balkenMax = ceil($balkenMax/60)*60;
        /*		$balkenMax = 540;
        		$aktivitaetenArr["diagrammStepSize"] = ceil($balkenMax/9);
        		$aktivitaetenArr["diagrammMax"]=$balkenMax;*/

        //$aktivitaetenArr["diagrammStepSize"]=$balkenMax/9;
        //echo "maximal: ".$balkenMax;
        //echo count($aktivitaetenArr['data']->labels);
        //die;
        /*
        foreach($aktivitaetenArr['data']['datasets'] as $dataset){

        	$dataSumme = array_sum($dataset->data);
        }
        */

        /*
        {
        		type: 'bar',
        		label: 'Mitarbeiter 1',
        		backgroundColor: color('rgb(201, 203, 207)').alpha(0.8).rgbString(),//grey
        		borderColor: 'rgb(201, 203, 207)',//red
        		borderWidth: 1,
        		stack: 1,
        		data: [

        			10,20,30,40,50,60,70,80,90,100,110,1120
        		],
        	}
        */

        // entweder 1 komplettes jahr / monat 1-12
        // oder ein monat / 1 - 31
        // oder eine kalenderwoche / mo - so
        return $aktivitaetenArr;
    }

    /**
     * action ajax
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $newDateien
     * @return void
     */
    public function ajaxAction(\DslFactory\DslIntranet\Domain\Model\Dateien $newDateien = NULL)
    {
        if ($this->request->hasArgument('switch')) {
            switch ($this->request->getArgument('switch')) {
                case 'statistik':    $filterZeitraum = array(
                    'type' => $this->request->getArgument('type'),
                    'date' => $this->request->getArgument('date')
                );
                    $aktivitaetenArr = $this->getStatistikDaten($filterZeitraum);
                    echo json_encode($aktivitaetenArr);
                    die;
                    break;
                case 'toggleSichtbarkeitDateien':    if ($this->request->hasArgument('uid')) {
                    if ($datei = $this->dateienRepository->findByUid($this->request->getArgument('uid'))) {
                        $datei->toggleSichtbarkeit();
                        $this->dateienRepository->update($datei);
                        echo $datei->getSichtbarkeit();
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        die;
                        break;
                    }
                }
                    break;
                case 'toggleSichtbarkeitText':    if ($this->request->hasArgument('uid')) {
                    if ($text = $this->auftraegeTexteRepository->findByUid($this->request->getArgument('uid'))) {
                        $text->toggleSichtbarkeit();
                        $this->auftraegeTexteRepository->update($text);
                        echo $text->getSichtbarkeit();
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        die;
                        break;
                    }
                }
                    break;
                case 'toggleSichtbarkeit':    if ($this->request->hasArgument('uid')) {
                    if ($auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('uid'))) {
                        $auftraege->toggleSichtbarkeit();
                        $this->auftraegeRepository->update($auftraege);
                        echo $auftraege->getSichtbarkeit();
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        die;
                        break;
                    }
                }
                    break;
                case 'setGeoeffneterAuftrag':    if ($this->request->hasArgument('uid')) {
                    $user = $GLOBALS['TSFE']->fe_user->user;
                    $mitarbeiter = $this->mitarbeiterRepository->findByUid($user['uid']);
                    $mitarbeiter->setGeoeffneterAuftrag((int)$this->request->getArgument('uid'));
                    $this->mitarbeiterRepository->update($mitarbeiter);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                }
                    die;
                    break;

                case 'auftraegeList':

					$retarray = $this->listJSONDataTable(false);
					echo json_encode($retarray);

                    die;
                    break;

                case 'statusChange':    if ($this->request->hasArgument('uid')) {
                    if ($auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('uid'))) {
                        if ($this->request->hasArgument('status')) {
                            $newStatus = intval($this->request->getArgument('status'));
                            $oldStatusText = $auftraege->getStatusText();
                            //echo $auftrag
                            //die;
                            $oldStatus = $auftraege->getStatus();
                            if ($oldStatus != $newStatus) {
                                //prüfung nur weiter wenn z.B. ein anderer Bearbeiter den status nicht bereits gesetzt hat
                                $auftraege->setStatus($newStatus);
                                if ($auftraege->getAnsprechpartner() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                                    $auftraege->getAnsprechpartner()->_loadRealInstance();
                                }
                                if ($auftraege->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                                    $auftraege->getMitarbeiter()->_loadRealInstance();
                                }
                                /*Notification Versenden Anfgang*/
                                $notificationAnsprechpartner = new \DslFactory\DslIntranet\Domain\Model\Notification();
                                $notificationAnsprechpartner->setAuftrag($auftraege);
                                $notificationAnsprechpartner->setArt(20, $oldStatusText, $auftraege->getStatusText());
                                $notificationAnsprechpartner->setMitarbeiter($auftraege->getAnsprechpartner());
                                if ($notificationAnsprechpartner->forOtherUser()) {
                                    $this->notificationRepository->add($notificationAnsprechpartner);
                                }
                                foreach ($auftraege->getMitarbeiter() as $mitarbeiter) {
                                    if ($auftraege->getAnsprechpartner() != $mitarbeiter) {
                                        $notificationMitarbeiter = clone $notificationAnsprechpartner;
                                        $notificationMitarbeiter->resetUid();
                                        //$notificationMitarbeiter->setMitarbeiter($mitarbeiter);
                                        if ($notificationMitarbeiter->forOtherUser()) {
                                            $this->notificationRepository->add($notificationMitarbeiter);
                                        }
                                    }
                                }
                                /*Notification Versenden Ende*/
                                $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                                $protokolle->setPid((int)$this->settings['protokollePid']);
                                $protokolle->setAuftrag($auftraege);
                                $protokolle->setAktion(10);
                                $protokolle->setAuftragStatusAlt($oldStatus);
                                $protokolle->setZeitpunkt(new \DateTime());
                                $protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                                if ($auftraege->getSichtbarkeit()) {
                                    $statusSumme = $oldStatus + $newStatus;
                                    //echo "statusSumme:".$statusSumme;
                                    //echo "(".$oldStatus." + ".$newStatus.")";
                                    if ($statusSumme != 30 && $statusSumme != 130 && !(($oldStatus == 10 || $oldStatus == 20) && $newStatus == 30)) {
                                        //$protokolle->sendKundeninfoMail();
                                        $mailSettings = $protokolle->getMailSettings();
                                        //print_r($mailSettings);
                                        if ($mailSettings['mailReadyToSend']) {
                                            //	print_r($mailSettings);
                                            //	die;
                                            $newProtokollePending = $this->initProtokollPending($protokolle);
                                        }
                                    }
                                }
                                //auftraegeStatusChange
                                $this->protokolleRepository->add($protokolle);
                                $this->auftraegeRepository->update($auftraege);
                                $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                            }
                        }
                    }
					//return true;
                }
                    echo json_encode(array(
                        'uid' => $auftraege->getUid(),
                        'statusPercent' => $auftraege->getStatusPercent(),
                        'protokollePendingUid' => (isset($newProtokollePending) && $newProtokollePending) ? $newProtokollePending->getUid() : false
                    ));
                    die;
                    break;
                case 'delete':    if ($this->request->hasArgument('uid')) {
                    if ($auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('uid'))) {
                        $this->deleteAction($auftraege);
                        return true;
                    }
                }
                    break;
                case 'filterSet':    $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    if ($this->request->hasArgument('settings')) {
                        $stringRepresentation= json_encode($this->request->getArgument('settings'));
                        $benutzer->setSettings($stringRepresentation);
                    } else {
                        $benutzer->setSettings('');
                    }
                    $this->frontendUserRepository->update($benutzer);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    $settings = $benutzer->getSettings();
                    if(isset($settings['favoriten'])){
                        unset($settings['favoriten']);
                    }
                    $auftraegeGefiltert = $this->auftraegeRepository->findByFilter($settings);
                    $found = count($auftraegeGefiltert);
                    $auftraegeGefiltertFavoriten = $this->auftraegeRepository->findByFilter(array('favoriten' => true));

                    if($auftraegeGefiltertFavoriten == NULL){
                        $foundFavoriten = 0;
                    }else{
                        $foundFavoriten = count($auftraegeGefiltertFavoriten);

                    }
                    echo json_encode(array('found' => $found, 'foundFavoriten' => $foundFavoriten));
                    die;
                    break;
                case 'show':    if (!$this->request->hasArgument('uid')) {
                    break;
                }
                    //					echo asd":".22""
                    $uid = $this->request->getArgument('uid');
                    $tmpArr = explode('-', $uid);
                    if (count($tmpArr) > 1) {
                        $uid = $tmpArr[count($tmpArr) - 1];
                    }
                    //$auftraege = $this->auftraegeRepository->findByUid($uid);
                    //echo "bla";
                    //die;
                    $auftraege = $this->auftraegeRepository->findByUidCheckMitarbeiterGroup($uid);
                    if (!$auftraege) {
                        echo 'error';



                    } else return $this->showAction($auftraege, true);

                    break;
                case 'loadAktivitaet':    if (!$this->request->hasArgument('uid')) {
                    break;
                }
                    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('uid'));
                    $datumArr = explode('.', $this->request->getArgument('datum'));
                    $aktivitaetDate = new \DateTime($datumArr[2] . '-' . $datumArr[1] . '-' . $datumArr[0]);
                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Aktivitaet/PartialList.html', $this->request->getControllerExtensionName());
                    $tracker = $this->getTracker($auftraege->getUid());
                    //if($tracker) $auftraege->setMitarbeiterTracker($tracker);
                    $dbView->assign('auftraege', $auftraege);
                    $dbView->assignMultiple($this->getVarsForAktivitaeten($aktivitaetDate, $auftraege));
                    echo json_encode(array('datum' => $this->request->getArgument('datum'), 'uid' => $this->request->getArgument('uid'), 'content' => $dbView->render()));
                    die;
                    break;
                case 'update':    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
                    $auftraege = $this->updateAuftragFromRequest($auftraege);
                    $this->auftraegeRepository->update($auftraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    if ($auftraege->getAnsprechpartner() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                        $auftraege->getAnsprechpartner()->_loadRealInstance();
                    }
                    //echo "test3:time:".time();
                    if ($auftraege->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                        $auftraege->getMitarbeiter()->_loadRealInstance();
                    }
                    /*Notification Versenden Anfgang*/
                    $notificationAnsprechpartner = new \DslFactory\DslIntranet\Domain\Model\Notification();
                    $notificationAnsprechpartner->setAuftrag($auftraege);
                    $notificationAnsprechpartner->setArt(40, $auftraege->getStatusText());
                    $notificationAnsprechpartner->setMitarbeiter($auftraege->getAnsprechpartner());
                    if ($notificationAnsprechpartner->forOtherUser()) {
                        $this->notificationRepository->add($notificationAnsprechpartner);
                    }
                    foreach ($auftraege->getMitarbeiter() as $mitarbeiter) {
                        if ($auftraege->getAnsprechpartner() != $mitarbeiter) {
                            $notificationMitarbeiter = clone $notificationAnsprechpartner;
                            $notificationMitarbeiter->resetUid();
                            //$notificationMitarbeiter->setMitarbeiter($mitarbeiter);
                            if ($notificationMitarbeiter->forOtherUser()) {
                                $this->notificationRepository->add($notificationMitarbeiter);
                            }
                        }
                    }
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    /*Notification Versenden Ende*/
                    echo json_encode(array('uid' => $auftraege->getUid(), 'contentShow' => $this->showAction($auftraege, false)));
                    //echo json_encode(array('uid' => $auftraege->getUid(), 'contentShow' => $this->showAction($auftraege, false)));
                    die;
                    break;
                case 'updateProduktionsdatum':    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
                    $auftraege = $this->updateAuftragFromRequest($auftraege);
                    $this->auftraegeRepository->update($auftraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('uid' => $auftraege->getUid(), 'updateProduktionsdatum' => 'jaaa'));
                    die;
                    break;
                case 'updateTexte':    $texte = $this->auftraegeTexteRepository->findByUid($this->request->getArgument('texte'));
                    $texte = $this->updateAuftragTextFromRequest($texte);
                    $this->auftraegeTexteRepository->update($texte);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('uid' => $texte->getUid()));
                    die;
                    break;
                case 'updateNotizenIntern':    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
                    if ($this->request->hasArgument('textNotizenIntern')) {
                        $auftraege->setNotizenIntern($this->request->getArgument('textNotizenIntern'));
                    }
                    //$auftraege->setNotizenIntern('blaaa');
                    //$texte = $this->updateAuftragTextFromRequest($texte);
                    $this->auftraegeRepository->update($auftraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    echo json_encode(array('uid' => $auftraege->getUid()));
                    die;
                    break;
                case 'addTexte':    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
                    //$texte = $this->auftraegeTexteRepository->findByUid($this->request->getArgument('texte'));
                    $texte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();
                    $texte->setPid((int)$this->settings['auftraegeTextePid']);
                    $texte = $this->updateAuftragTextFromRequest($texte);
                    $this->auftraegeTexteRepository->add($texte);
                    $auftraege->addTexte($texte);
                    $this->auftraegeRepository->update($auftraege);
                    //$this->auftraegeTexteRepository->update($texte);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

                    $texte->setAuftraege($auftraege);

                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Auftraege/PropertiesBeschreibungText.html', $this->request->getControllerExtensionName());
                    $dbView->assign('text', $texte);
                    $dbView->render();
                    echo json_encode(array('uid' => $texte->getUid(), 'auftraegeUid' => $auftraege->getUid(), 'contentShow' => $dbView->render()));
                    die;
                    break;
                case 'deleteTexte':    if ($this->request->hasArgument('uid')) {
                    if ($texte = $this->auftraegeTexteRepository->findByUid($this->request->getArgument('uid'))) {
                        $this->auftraegeTexteRepository->remove($texte);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        die;
                    }
                }
                    break;
                case 'updateMitarbeiter':    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('uid'));
                    if ($this->request->hasArgument('mitarbeiter')) {
                        $mitarbeiterBackup = $auftraege->getMitarbeiter();
                        $mitarbeiterArr = explode(',', $this->request->getArgument('mitarbeiter'));
                        $auftraege->setMitarbeiter($this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
                        if (is_array($mitarbeiterArr)) {
                            foreach ($mitarbeiterArr as $mitarbeiterUid) {
                                $mitarbeiter = $this->mitarbeiterRepository->findByUid($mitarbeiterUid);
                                if (!$mitarbeiterBackup->offsetExists($mitarbeiter)) {
                                    /*Notification Versenden Anfgang*/
                                    $notification = new \DslFactory\DslIntranet\Domain\Model\Notification();
                                    $notification->setAuftrag($auftraege);
                                    $notification->setMitarbeiter($mitarbeiter);
                                    $notification->setArt(10, $auftraege->getStatusText());
                                    if ($notification->forOtherUser()) {
                                        $this->notificationRepository->add($notification);
                                    }
                                }
                                $auftraege->addMitarbeiter($mitarbeiter);
                            }
                        }
                    }
                    $this->auftraegeRepository->update($auftraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //echo "blaas1u1r";
                    //die;
                    echo json_encode(array('uid' => $auftraege->getUid()));
                    die;
                    break;
                case 'updateAnsprechpartner':    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('uid'));
                    if ($this->request->hasArgument('ansprechpartner')) {
                        $auftraege->setAnsprechpartner($this->mitarbeiterRepository->findByUid($this->request->getArgument('ansprechpartner')));
                    }
                    $this->auftraegeRepository->update($auftraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    /*Notification Versenden Anfgang*/
                    $notificationAnsprechpartner = new \DslFactory\DslIntranet\Domain\Model\Notification();
                    $notificationAnsprechpartner->setAuftrag($auftraege);
                    $notificationAnsprechpartner->setArt(50, $auftraege->getStatusText());
                    $notificationAnsprechpartner->setMitarbeiter($auftraege->getAnsprechpartner());
                    if ($notificationAnsprechpartner->forOtherUser()) {
                        $this->notificationRepository->add($notificationAnsprechpartner);
                    }
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    /*Notification Versenden Anfgang*/
                    echo json_encode(array('uid' => $auftraege->getUid()));
                    die;
                    break;
                case 'updateDateiTitel':    if ($this->request->hasArgument('uid')) {
                    if ($datei = $this->dateienRepository->findByUid($this->request->getArgument('uid'))) {
                        $datei->setTitel($this->request->getArgument('titel'));
                        $this->dateienRepository->update($datei);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        echo json_encode(array('uid' => $datei->getUid()));
                    }
                }
                    die;
                    break;
                case 'create':  
				
					$auftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();
                    $auftraege->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    $auftraege = $this->updateAuftragFromRequest($auftraege);
                    if ($this->request->hasArgument('textBeschreibung')) {
                        $texte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();
                        $texte->setPid((int)$this->settings['auftraegeTextePid']);
                        $texte->setTitel('Auftragsbeschreibung');
                        $texte = $this->updateAuftragTextFromRequest($texte);
                        if ($this->request->hasArgument('sichtbarkeitBeschreibung')) {
                            if ($this->request->getArgument('sichtbarkeitBeschreibung')) {
                                $texte->setSichtbarkeit(true);
                            }
                        }
                        $this->auftraegeTexteRepository->add($texte);
                        $auftraege->addTexte($texte);
                    }
                    /*
                                                                                if ($this->request->hasArgument('textBeschreibungIntern')) {
                                                                                    if ($this->request->getArgument('textBeschreibungIntern')) {
                                                                                    $texte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();
                                                                                    $texte->setPid($this->settings['auftraegeTextePid']);
                                                                                    $texte->setTitel('Interne Notizen');
                                                                                    //$texte = $this->updateAuftragTextFromRequest($texte);
                                                                                    $texte->setBeschreibung($this->request->getArgument('textBeschreibungIntern'));
                                                                                    $this->auftraegeTexteRepository->add($texte);
                                                                                    $auftraege->addTexte($texte);
                                                                                    }
                                                                                }*/

                    if ($newDateien) {
                        $dateien = $newDateien;
                        $dateien->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                        //                    $dateien = $this->updateDateiFromRequest($dateien);
                        $dateien->setType(20);
						if ($this->request->hasArgument('newDateien')) {
							$resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
							$FileDeletionAspect = GeneralUtility::makeInstance(FileDeletionAspect::class);
							$fileUtility = new FileUtility($resourceFactory, $FileDeletionAspect);

							$uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('auftraegeAngeboteRechnungen');

							//$uploadedImage = $this->createUserProfileImage($image);
							// Index the image, it will move the file and return the FAL file object
							$indexedFiles = $fileUtility->indexImages($this->request->getArgument('newDateien')['datei'], $uploadSettings['falStorageSubDir'], true);

							if (!empty($indexedFiles)) {
								$falFile = $indexedFiles[0];

								// Now, you can create a FileReference from this FAL file and save it to your model
								$fileReference = $fileUtility->createFileReferenceFromFalFileObject($falFile, 0, 0,'','');

								// Assuming you have an Event model that accepts a FileReference
								$newDateien->setDatei($fileReference);


							}
						}
                        //angebot
                        $this->dateienRepository->add($dateien);
                        $auftraege->addDateien($dateien);
                        $protokolleDateiErstellt = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                        $protokolleDateiErstellt->setPid($this->settings['protokollePid']);
                        $protokolleDateiErstellt->setAuftrag($auftraege);
                        $protokolleDateiErstellt->setDatei($newDateien);
                        //		echo "b";
                        $protokolleDateiErstellt->setAktion(90);
                        $protokolleDateiErstellt->setZeitpunkt(new \DateTime());
                        $protokolleDateiErstellt->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                        //		echo "c";
                        $this->protokolleRepository->add($protokolleDateiErstellt);
                        $newProtokollePending = $this->initProtokollPending($protokolleDateiErstellt);
                    }
                    $this->auftraegeRepository->add($auftraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                    $protokolle->setPid((int)$this->settings['protokollePid']);
                    $protokolle->setAuftrag($auftraege);
                    $protokolle->setAktion(5);
                    $protokolle->setZeitpunkt(new \DateTime());
                    $protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                    if (!isset($newProtokollePending)) {
                        //falls nicht parallel ein angebot hochgeladen wurde
                        if ($auftraege->getSichtbarkeit()) {
                            $newProtokollePending = $this->initProtokollPending($protokolle);
                        }
                    }
                    $this->protokolleRepository->add($protokolle);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    /*Notification Versenden Anfgang*/
                    $notificationAnsprechpartner = new \DslFactory\DslIntranet\Domain\Model\Notification();
                    $notificationAnsprechpartner->setAuftrag($auftraege);
                    $notificationAnsprechpartner->setArt(30, $auftraege->getStatusText());
                    $notificationAnsprechpartner->setMitarbeiter($auftraege->getAnsprechpartner());
                    if ($notificationAnsprechpartner->forOtherUser()) {
                        $this->notificationRepository->add($notificationAnsprechpartner);
                    }
                    foreach ($auftraege->getMitarbeiter() as $mitarbeiter) {
                        if ($auftraege->getAnsprechpartner() != $mitarbeiter) {
                            $notificationMitarbeiter = clone $notificationAnsprechpartner;
                            $notificationMitarbeiter->resetUid();
                            //$notificationMitarbeiter->setMitarbeiter($mitarbeiter);
                            if ($notificationMitarbeiter->forOtherUser()) {
                                $this->notificationRepository->add($notificationMitarbeiter);
                            }
                        }
                    }
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    /*Notification Versenden Ende*/
                    echo json_encode(array('newUid' => $auftraege->getUid(), 'protokollePendingUid' => $newProtokollePending ? $newProtokollePending->getUid() : false));
                    die;
                    //$newAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege $this->request->getArgument('titel');
                    break;
                case 'sendKundeninfoMailDatei':    if ($this->request->hasArgument('uid')) {
                    if ($datei = $this->dateienRepository->findByUid($this->request->getArgument('uid'))) {
                        /*

                        Core: Exception handler (WEB): Uncaught TYPO3 Exception: Call to a member function getPending() on null | Error thrown in file /kunden/525187_08371/rp-hosting/3000/1/intranet.dsl-factory.de/typo3conf/ext/dsl_intranet/Classes/Controller/AuftraegeController.php in line 624. Requested URL: https://intranet.dsl-factory.de/index.php?id=12&no_cache=1&tx_dslintranet_auftragsliste%%5Buid%%5D=1061&tx_dslintranet_auftragsliste%%5Bswitch%%5D=sendKundeninfoMailDatei&tx_dslintranet_auftragsliste%%5Baction%%5D=ajax&tx_dslintranet_auftragsliste%%5Bcontroller%%5D=Auftraege&cHash=03c074441f8fcb4c0815fd8c9bd62cb3
                        */

                        //$datei->getTest()->getUid(); Fehler hervorufen
                        //    if ($datei->getAuftraege()->getSichtbarkeit()) {
                        //findByDateien
                        $datei->setSichtbarkeit(TRUE);
                        $this->dateienRepository->update($datei);
                        //	$protokoll = $datei->getProtokoll();
                        //echo "a";
                        if (!$datei->getProtokoll()) {
                            //Falls das Protokoll nicht existiert anlegen // sollte eigentlich nicht mehr auftreten
                            $auftrag = $datei->getAuftraege();
                            $protokolleDateiErstellt = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
                            $protokolleDateiErstellt->setPid($this->settings['protokollePid']);
                            $protokolleDateiErstellt->setAuftrag($auftrag);
                            $protokolleDateiErstellt->setDatei($datei);
                            //		echo "b";
                            $protokolleDateiErstellt->setAktion(90);
                            $protokolleDateiErstellt->setZeitpunkt(new \DateTime());
                            $protokolleDateiErstellt->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
                            //		echo "c";
                            $this->protokolleRepository->add($protokolleDateiErstellt);
                            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        }
                        $newProtokollePending = $this->initProtokollPending($datei->getProtokoll());
                        //$this->protokolleRepository->update($datei->getProtokoll());
                        //echo "b";
                        //updateprotokolle?!
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        echo json_encode(array('protokollePendingUid' => $newProtokollePending ? $newProtokollePending->getUid() : false));
                    }
                }
                    //     echo 'bla';
                    die;
                    break;
                /*Zeiteintragshandling*/
                case 'deleteZeiteintrag':    if ($this->request->hasArgument('uid')) {
                    if ($zeiteintraege = $this->zeiteintraegeRepository->findByUid($this->request->getArgument('uid'))) {
                        $this->deleteAction($zeiteintraege);
                        return true;
                    }
                }
                    break;
                case 'deleteDatei':    if ($this->request->hasArgument('uid')) {
                    //echo $this->request->getArgument('uid');
                    if ($datei = $this->dateienRepository->findByUid($this->request->getArgument('uid'))) {
                        //echo "datei:".$datei->getUid();
                        $auftrag = $datei->getAuftraege();
                        //echo "auftrag:".$auftrag->getUid();
                        $auftrag->removeDateien($datei);
                        //echo "afterrem";
                        //$this->auftraegeRepository->update($auftrag); //nicht nötig gewesne
                        //echo "afterupd";
                        /*                            $storageCfg = $datei->getDatei()->getOriginalResource()->getOriginalFile()->getStorage()->getConfiguration();
                                                      //	print_r($storageCfg);
                                                      if ($storageCfg['basePath'] && $datei->getDatei()->getOriginalResource()->getOriginalFile()->getIdentifier()) {
                                                      //					echo "unlink";
                                                      unlink(rtrim($storageCfg['basePath'], '/') . $datei->getDatei()->getOriginalResource()->getOriginalFile()->getIdentifier());
                                                      }*/

                        //$datei->getDatei()->detach();
                        //				echo "removeDAtei";
                        $this->dateienRepository->remove($datei);
                        $datei->getDatei()->getOriginalResource()->getOriginalFile()->getStorage()->deleteFile($datei->getDatei()->getOriginalResource()->getOriginalFile());
                        //				echo "ready";
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    }
                }
                    return true;
                    /*

                    				  if ($this->request->hasArgument('uid')) {
                                            if ($zeiteintraege = $this->zeiteintraegeRepository->findByUid($this->request->getArgument('uid'))) {
                                                $this->deleteAction($zeiteintraege);
                                                return true;
                                            }
                                        }
                    */

                    break;
                case 'startZeiteintrag':
                    if ($this->request->hasArgument('uid')) {
                    $retArr = array(
                        'request' => $this->request->getArguments(),
                        'auftraegeUid' => $this->request->getArgument('uid')
                    );
                    /*geändert */
                    $auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('uid'));
                    //andere Zeiteinträge stoppen
                    $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    $otherTrackers = $this->zeiteintraegeRepository->findOtherRunning($mitarbeiter, $auftraege);


                    foreach ($otherTrackers as $otherTracker) {
                        $this->stopTracker($otherTracker);
                    }
                    //Zeiteintrag starten
                    $tracker = $this->getTracker($this->request->getArgument('uid'));
					
					if(!$tracker){
					
					$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dslintranet_domain_model_zeiteintraege');
					$result = $queryBuilder
						->select('uid')
						->from('tx_dslintranet_domain_model_zeiteintraege')
						->where(
							$queryBuilder->expr()->eq(
								'auftraege', 
								$queryBuilder->createNamedParameter((int)$this->request->getArgument('uid'), Connection::PARAM_INT)
							)
						)
						->andWhere(
							$queryBuilder->expr()->eq(
								'end', 
								$queryBuilder->createNamedParameter(0, Connection::PARAM_INT)
							)
						)
						->executeQuery()
						->fetchAssociative();


						
						$tracker = $this->zeiteintraegeRepository->findByUid($result['uid']);
					}

                    if (!$tracker) {

                        $tracker = $this->getNewTracker($this->request->getArgument('uid'));
                        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Auftraege/PropertiesToolbarCounterBtn.html', $this->request->getControllerExtensionName());
                        $dbView->assign('auftraege', $auftraege);
                        //$dbView->assign('tracker', $this->getTracker($auftraege->getUid()));
                        $dbView->assign('tracker', $tracker);
                        $retArr['PropertiesToolbarCounterBtn'] = $dbView->render();
                        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Auftraege/PartialTabTitel.html', $this->request->getControllerExtensionName());
                        $auftraege->setMitarbeiterTracker($tracker);
                        $dbView->assign('auftrag', $auftraege);
                        $retArr['PartialTabTitel'] = $dbView->render();
                    }
                    if ($tracker->isValidToTrack()) {
                        $trackerSegmente = new \DslFactory\DslIntranet\Domain\Model\TrackerSegmente();
                        $trackerSegmente->setBegin(new \DateTime(date('Y-m-d H:i:s')));
                        $trackerSegmente->setPid((int)$this->settings['zeiteintraegePid']);
                        $this->trackerSegmenteRepository->add($trackerSegmente);
                        $tracker->addTracker($trackerSegmente);
                        $tracker->setZeitnahme(1);
                        $this->zeiteintraegeRepository->update($tracker);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    }

                    //Kontingent neu zusammenrechnen
                    $auftraege->setKontingentUsedCached(0); $auftraege->getKontingentUsed();
                    $this->auftraegeRepository->update($auftraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

                    //checkTracker

                    $retArr['zeitnahmeAutoStopped'] = $tracker->getZeitnahmeAutoStopped();
                    $retArr['isValidToTrack'] = $tracker->isValidToTrack();
                    $retArr['zeiteintragUid'] = $tracker->getUid();
                    $retArr['kontingent'] = $tracker->getTrackerSeconds();
                    echo json_encode($retArr);
                }
                    die;
                    break;
                case 'stopZeiteintrag':    if ($this->request->hasArgument('uid')) {
                    //$tracker = $this->getTracker($this->request->getArgument('uid'));
					
					// use TYPO3\CMS\Core\Database\Connection;

					$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dslintranet_domain_model_zeiteintraege');
					$result = $queryBuilder
						->select('uid')
						->from('tx_dslintranet_domain_model_zeiteintraege')
						->where(
							$queryBuilder->expr()->eq(
								'auftraege', 
								$queryBuilder->createNamedParameter((int)$this->request->getArgument('uid'), Connection::PARAM_INT)
							)
						)
						->andWhere(
							$queryBuilder->expr()->eq(
								'end', 
								$queryBuilder->createNamedParameter(0, Connection::PARAM_INT)
							)
						)
						->executeQuery()
						->fetchAssociative();


						
				$tracker = $this->zeiteintraegeRepository->findByUid($result['uid']);
                    if (!$tracker->getZeitnahmeAutoStopped()) {
                        $this->stopTracker($tracker);
                    }
                    echo json_encode(array($this->request->getArguments(), 'zeiteintragUid' => $tracker->getUid(), 'kontingent' => $tracker->getTrackerSeconds(), 'auftraegeUid' => $tracker->getAuftraege()->getUid(), 'zeitnahmeAutoStopped' => $tracker->getZeitnahmeAutoStopped(), 'isValidToTrack' => $tracker->isValidToTrack()));

                    //Kontingent neu zusammenrechnen
                    $auftraege = $tracker->getAuftraege();
                    $auftraege->setKontingentUsedCached(0);
                    $auftraege->getKontingentUsed();

                    $this->auftraegeRepository->update($auftraege);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();

                }
                    die;
                    break;
                /*kundenlogin ACHTUNG Nutzerrechte*/
                case 'auftraegeKundenlist':    //$kunde = $this->kundenRepository->findByName("pro haar");
                    //echo $kunde->getUid();
                    $retarray = $this->listJSONDataTable(true);
                    echo json_encode($retarray);
                    die;
                    break;
                case 'getDefaultStundensatzAgenturvertrag':    if ($this->request->hasArgument('kunde')) {
                    if ($this->request->getArgument('kunde')) {
                        $kunde = $this->kundenRepository->findByUid($this->request->getArgument('kunde'));
                        $datum = new \DateTime($this->request->getArgument('datumAbschluss'));
                        $stundensatz = $this->agenturvertraegeRepository->findAgenturvertragByKundeDatum($kunde, $datum->format('Y-m-d'));
                    }
                }
                    if (!$stundensatz) {
                        $stundensatz = floatval(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('defaultStundensatz'));
                    }
                    /*if ($this->request->hasArgument('uid')) {
                      $tracker = $this->getTracker($this->request->getArgument('uid'));
                      if (!$tracker->getZeitnahmeAutoStopped()) {
                      $this->stopTracker($tracker);
                      }
                      echo json_encode(array($this->request->getArguments(), 'zeiteintragUid' => $tracker->getUid(), 'kontingent' => $tracker->getTrackerSeconds(), 'auftraegeUid' => $tracker->getAuftraege()->getUid(), 'zeitnahmeAutoStopped' => $tracker->getZeitnahmeAutoStopped(), 'isValidToTrack' => $tracker->isValidToTrack()));
                      }*/

                    echo json_encode(array($this->request->getArguments(), 'stundensatz' => $stundensatz));
                    die;
                    break;
                case 'getProjektListeKunde':    $projektArr = array();
                    if ($this->request->hasArgument('kunde')) {
                        if ($this->request->getArgument('kunde')) {
                            if ($kunde = $this->kundenRepository->findByUid($this->request->getArgument('kunde'))) {
                                $projekte = $this->projekteRepository->findByKunde($kunde);
                                foreach ($projekte as $projekt) {
                                    $projektArr[] = array($projekt->getUid(), $projekt->getNr() . ': ' . $projekt->getTitel());
                                }
                            }
                        }
                    }
                    echo json_encode(array($this->request->getArguments(), 'projekte' => $projektArr));
                    die;
                    break;
            }
        }
        header('HTTP/1.1 400 Bad Request');
        return json_encode(array('error' => 'Bad request!'));
        //return $this->htmlResponse();
    }


    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege tracker
     */
    private function stopTracker($tracker)
    {
        $lastTrackerSegmente = $tracker->getLastTrackerSegmente();
		
        if ($lastTrackerSegmente->isOpened()) {
            $lastTrackerSegmente->setEnd(new \DateTime(date('Y-m-d H:i:s')));
            $this->trackerSegmenteRepository->update($lastTrackerSegmente);
        }
        $tracker->setZeitnahme(0);
        $this->zeiteintraegeRepository->update($tracker);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
    }

    /**
     * @param $uid
     * @return \DslFactory\DslIntranet\Domain\Model\Zeiteintraege
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */

    private function getNewTracker($uid)
    {

        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();

        $auftraege = $this->auftraegeRepository->findByUid($uid);
        $tracker = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
        $tracker->setBegin(new \DateTime(date('Y-m-d H:i:s')));
        $tracker->setCruser($mitarbeiter);
        $tracker->setPid((int)$this->settings['zeiteintraegePid']);
        $tracker->setText('');
        $this->zeiteintraegeRepository->add($tracker);
        $auftraege->addZeiten($tracker);
        $this->auftraegeRepository->update($auftraege);
        $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $persistenceManager->persistAll();

        return $tracker;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Zeiteintraege tracker
     */
    private function checkTracker($tracker)
    {
        //echo "<br>checkTracker:".$tracker->getUid()." (".$tracker->getAuftraege()->getUid().")";
        if (!$tracker->getEnd()) {
            //  echo "keinende";
            if (date('Ymd') > $tracker->getBegin()->format('Ymd')) {
                //    echo "hmmmm";
                // wenn der tracker an einem vorangegangenen Tag gestartet wurde
                //if(!$tracker->getZeitnahmeAutoStopped()){//wenn der tracker / die zeitnahme noch aktiv ist && die zeitnahme noch nicht gestoppt wurde
                //echo "checked";
                if (!$tracker->getLastTrackerSegmente()->getEnd()) {
                    $tracker->setZeitnahmeAutoStopped(1);
                    $tracker->setZeitnahme(0);
                    $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    //$arbeitsendeTimstamp = new \DateTime('@' . $mitarbeiter->getArbeitsende());
                    $autostopTimstamp = new \DateTime('@' . $mitarbeiter->getAutostop());
                    $lastTrackerSegmente = $tracker->getLastTrackerSegmente();
                    if ($lastTrackerSegmente->getBegin()->format('Hi') < $autostopTimstamp->format('Hi')) {
                        $newEnd = new \DateTime($tracker->getBegin()->format('Y-m-d') . ' ' . $autostopTimstamp->format('H:i') . ':00');
                    } else {
                        $newEnd = new \DateTime($tracker->getBegin()->format('Y-m-d') . ' 23:59:59');
                    }
                    $lastTrackerSegmente->setEnd($newEnd);
                    $this->trackerSegmenteRepository->update($lastTrackerSegmente);
                    $this->zeiteintraegeRepository->update($tracker);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                }
            }
        }




        return $tracker;
    }

    /**
     * @param $uid
     */
    private function getTracker($uid)
    {
        //	echo "getTracker!";
        /*geändert getZeiteintragCounter*/
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $auftraege = $this->auftraegeRepository->findByUid($uid);
		
		
		//die();
        $tracker = $this->zeiteintraegeRepository->findOpened($mitarbeiter, $auftraege);
		//\TYPO3\CMS\Core\Utility\DebugUtility::debug($tracker);
        //echo $tracker->getBegin()->format('Ymd');
        //echo "isopened:".$tracker->getLastTrackerSegmente()->isOpened();
        //echo $tracker->getLastTrackerSegmente()->getEnd()->format('Ymd');
        //echo date('Ymd');
        if ($tracker) {
            $tracker = $this->checkTracker($tracker);
        }
        return $tracker;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte texte
     */
    private function updateAuftragTextFromRequest($texte)
    {
        if ($this->request->hasArgument('textBeschreibung')) {
            $texte->setBeschreibung($this->request->getArgument('textBeschreibung'));
        }
        if ($this->request->hasArgument('textTitel')) {
            $texte->setTitel($this->request->getArgument('textTitel'));
        }
        if ($this->request->hasArgument('textSichtbarkeit') || $this->request->hasArgument('sichtbarkeit')) {
			if($this->request->getArgument('sichtbarkeit') == '1'){
                $texte->setSichtbarkeit(TRUE);
            }else{
                $texte->setSichtbarkeit(FALSE);
            }
        }
        //else $texte->setSichtbarkeit(0);
        return $texte;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    private function updateAuftragFromRequest($auftraege)
    {
		
		 if ($this->request->hasArgument('datei')) {
            $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            $FileDeletionAspect = GeneralUtility::makeInstance(FileDeletionAspect::class);
            $fileUtility = new FileUtility($resourceFactory, $FileDeletionAspect);

            $uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('auftraegeAngeboteRechnungen');

            //$uploadedImage = $this->createUserProfileImage($image);
            // Index the image, it will move the file and return the FAL file object
            $indexedFiles = $fileUtility->indexImages($this->request->getArgument('datei'), $uploadSettings['falStorageSubDir'], true);

            if (!empty($indexedFiles)) {
                $falFile = $indexedFiles[0];

                // Now, you can create a FileReference from this FAL file and save it to your model
                $fileReference = $fileUtility->createFileReferenceFromFalFileObject($falFile, 0, 0,'','');

                // Assuming you have an Event model that accepts a FileReference
                $auftraege->setDatei($fileReference);


            }
        }
		
		/*\TYPO3\CMS\Core\Utility\DebugUtility::debug($auftraege);
		
		die();*/

        if ($this->request->hasArgument('kunde')) {
            if (is_array($this->request->getArgument('kunde'))) {
                foreach ($this->request->getArgument('kunde') as $kunde) {
                    $auftraege->setKunde($this->kundenRepository->findByUid($kunde));
                }
            } else {
                $auftraege->setKunde($this->kundenRepository->findByUid($this->request->getArgument('kunde')));
            }
        }
        if ($this->request->hasArgument('auftragsart')) {
            if (is_array($this->request->getArgument('auftragsart'))) {
                foreach ($this->request->getArgument('auftragsart') as $auftragsart) {
                    $auftraege->setAuftragsart($this->auftragsartenRepository->findByUid($auftragsart));
                }
            } else {
                $auftraege->setAuftragsart($this->auftragsartenRepository->findByUid($this->request->getArgument('auftragsart')));
            }
        }
        if ($this->request->hasArgument('titel')) {
            $auftraege->setTitel($this->request->getArgument('titel'));
        }
        if ($this->request->hasArgument('durch')) {
            $auftraege->setDurch($this->request->getArgument('durch'));
        }
        if ($this->request->hasArgument('sichtbarkeit')) {
            if($this->request->getArgument('sichtbarkeit') == '1'){
                $auftraege->setSichtbarkeit(TRUE);
            }else{
                $auftraege->setSichtbarkeit(FALSE);
            }
        }
        if ($this->request->hasArgument('nutzungsFaktorNurEntwurfKreativleistung')) {
            $auftraege->setNutzungsFaktorNurEntwurfKreativleistung((bool) $this->request->getArgument('nutzungsFaktorNurEntwurfKreativleistung'));
        }
        if ($this->request->hasArgument('nutzungsFaktoren')) {
            $auftraege->setNutzungsFaktoren($this->request->getArgument('nutzungsFaktoren'));
        }
        if ($this->request->hasArgument('verechnungAgenturvertragNutzungsfaktorInklusive')) {
            $auftraege->setVerechnungAgenturvertragNutzungsfaktorInklusive($this->request->getArgument('verechnungAgenturvertragNutzungsfaktorInklusive'));
        }
        if ($this->request->hasArgument('verechnungAgenturvertragFremdkostenInklusive')) {
            $auftraege->setVerechnungAgenturvertragFremdkostenInklusive($this->request->getArgument('verechnungAgenturvertragFremdkostenInklusive'));
        }
        //if ($this->request->hasArgument('lieferungAnKunde')) {
        //   $auftraege->setLieferungAnKunde($this->request->getArgument('lieferungAnKunde'));
        //}
        if ($this->request->hasArgument('lieferungAnKunde')) {
            if ($this->request->getArgument('lieferungAnKunde')) {
                $auftraege->setLieferungAnKunde(true);
            } else {
                $auftraege->setLieferungAnKunde(false);
            }
        }
        //$auftraege->setNutzungsFaktorNurEntwurfKreativleistung(true);
        if ($this->request->hasArgument('prioritaet')) {
            if (is_array($this->request->getArgument('prioritaet'))) {
                foreach ($this->request->getArgument('prioritaet') as $prioritaet) {
                    $auftraege->setPrioritaet((int)$prioritaet);
                }
            } else {
                $prioritaet = $this->request->getArgument('prioritaet');
                if ($prioritaet) {
                    $auftraege->setPrioritaet((int)$prioritaet);
                }
            }
        }
        if ($this->request->hasArgument('per')) {
            if (is_array($this->request->getArgument('per'))) {
                foreach ($this->request->getArgument('per') as $per) {
                    $auftraege->setPer((int)$per);
                }
            } else {
                $per = $this->request->getArgument('per');
                if ($per) {
                    $auftraege->setPer((int)$per);
                }
            }
        }
        if ($this->request->hasArgument('status')) {
            if (is_array($this->request->getArgument('status'))) {
                foreach ($this->request->getArgument('status') as $status) {
                    $auftraege->setStatus((int)$status);
                }
            } else {
                $status = $this->request->getArgument('status');
                if ($status) {
                    $auftraege->setStatus((int)$status);
                }
            }
        }
        if ($this->request->hasArgument('datum')) {
            if ($this->request->hasArgument('datumTime')) {
                $timeString = ' ' . $this->request->getArgument('datumTime');
            } else {
                $timeString = '';
            }
            $auftraege->setDatum(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('datum') . $timeString)));
        }
        if ($this->request->hasArgument('datumAbschluss')) {
            $auftraege->setDatumAbschluss(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('datumAbschluss'))));
        }
        if ($this->request->hasArgument('datumfertigstellung')) {
            if ($this->request->getArgument('datumfertigstellung')) {
                $auftraege->setDatumfertigstellung(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('datumfertigstellung'))));
            } else {
                //echo "ahhh";
                $auftraege->deleteDatumfertigstellung();
            }
        }
        if ($this->request->hasArgument('datumproduktion')) {
            if ($this->request->getArgument('datumproduktion')) {
                $auftraege->setDatumproduktion(new \DateTime(\DslFactory\DslIntranet\Utility\DateUtility::init()->parseDateString($this->request->getArgument('datumproduktion'))));
            } else {
                //echo "ahhh";
                $auftraege->deleteDatumproduktion();
            }
        }
        if ($this->request->hasArgument('ansprechpartner')) {
            //print_r($this->request->getArgument('ansprechpartner'));
            //die;
            if (is_array($this->request->getArgument('ansprechpartner'))) {
                foreach ($this->request->getArgument('ansprechpartner') as $ansprechpartner) {
                    $auftraege->setAnsprechpartner($this->mitarbeiterRepository->findByUid($ansprechpartner));
                }
            } else {
                $ansprechpartner = $this->request->getArgument('ansprechpartner');
                if ($ansprechpartner) {
                    $auftraege->setAnsprechpartner($this->mitarbeiterRepository->findByUid($ansprechpartner));
                }
            }
        }
        if ($this->request->hasArgument('projekt')) {
            if (is_array($this->request->getArgument('projekt'))) {
                foreach ($this->request->getArgument('projekt') as $projekt) {
                    $auftraege->setProjekt($this->projekteRepository->findByUid($projekt));
                }
            } else {
                $projekt = $this->request->getArgument('projekt');
                if ($projekt) {
                    $auftraege->setProjekt($this->projekteRepository->findByUid($projekt));
                }
            }
        }
        if ($this->request->hasArgument('mitarbeiter')) {
            $auftraege->setMitarbeiter($this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
            if (is_array($this->request->getArgument('mitarbeiter'))) {
                foreach ($this->request->getArgument('mitarbeiter') as $mitarbeiter) {
                    //echo "setMitarbeiter(".$mitarbeiter.")";
                    $auftraege->addMitarbeiter($this->mitarbeiterRepository->findByUid($mitarbeiter));
                }
            }
        }
        if ($this->request->hasArgument('lieferanten')) {
            $auftraege->setLieferanten($this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
            if (is_array($this->request->getArgument('lieferanten'))) {
                foreach ($this->request->getArgument('lieferanten') as $lieferant) {
                    $auftraege->addLieferanten($this->lieferantenRepository->findByUid($lieferant));
                }
            }
        }


        if ($this->request->hasArgument('lieferantenNeu')) {
            if ($this->request->getArgument('lieferantenNeu')) {
                //echo 2;
                //echo 1;
                foreach (explode('<br />', nl2br($this->request->getArgument('lieferantenNeu'))) as $lieferantName) {
                    //echo 3;
                    $tmpName = trim($lieferantName);
                    //echo 4;
                    if ($tmpName) {
                        //echo 5;
                        //echo "neuerlieferant:".$tmpName;
                        if ($lieferant = $this->lieferantenRepository->findByName($tmpName)) {
                            //echo 6;
                            //  echo "bereits da:".$lieferant->getUid();
                            $auftraege->addLieferanten($lieferant);
                        } else {
                            //echo 7;
                            // echo "neuanlegen";
                            $lieferantNeu = new \DslFactory\DslIntranet\Domain\Model\Lieferanten();
                            $lieferantNeu->setName($tmpName);
                            $auftraege->addLieferanten($lieferantNeu);
                        }
                    }
                }

            }
            //
        }


        if ($this->request->hasArgument('fegroups')) {
            $auftraege->setFegroups($this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
            if (is_array($this->request->getArgument('fegroups'))) {
                foreach ($this->request->getArgument('fegroups') as $fegroup) {
                    $auftraege->addFegroup($this->fegroupsRepository->findByUid($fegroup));
                }
            }
        }
        if ($this->request->hasArgument('phasen')) {
            $auftraege->setPhasen($this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
            if (is_array($this->request->getArgument('phasen'))) {
                foreach ($this->request->getArgument('phasen') as $phase) {
                    $auftraege->addPhasen($this->phasenRepository->findByUid($phase));
                }
            }
        }
        if ($this->request->hasArgument('phasenKontingent')) {
            if (is_array($this->request->getArgument('phasenKontingent'))) {
                $auftraege->setPhasenKontingent(serialize($this->request->getArgument('phasenKontingent')));
            } else {
                $auftraege->setPhasenKontingent(serialize(array()));
            }
        }
        if ($this->request->hasArgument('mitarbeiterKontingent')) {
            if (is_array($this->request->getArgument('mitarbeiterKontingent'))) {
                $auftraege->setMitarbeiterKontingent(serialize($this->request->getArgument('mitarbeiterKontingent')));
            } else {
                $auftraege->setMitarbeiterKontingent(serialize(array()));
            }
        }
        if ($this->request->hasArgument('phasenStundensatz')) {
            if (is_array($this->request->getArgument('phasenStundensatz'))) {
                $auftraege->setPhasenStundensatz(serialize($this->request->getArgument('phasenStundensatz')));
            } else {
                $auftraege->setPhasenStundensatz(serialize(array()));
            }
        }
        if ($this->request->hasArgument('kontingent')) {
            $auftraege->setKontingent((int)$this->request->getArgument('kontingent'));
        }
        if ($this->request->hasArgument('festpreis')) {
            if ($this->request->getArgument('festpreis')) {
                $auftraege->setFestpreis((float)$this->request->getArgument('festpreis'));
            } else {
                $auftraege->setFestpreis(0);
            }
        }
        //echo floatval($this->request->getArgument('stundensatz'));
        if ($this->request->hasArgument('stundensatz')) {
            if ($this->request->getArgument('stundensatz')) {
                //				$auftraege->setStundensatz(222.9898);
                $auftraege->setStundensatz(floatval($this->request->getArgument('stundensatz')));
            }
        }
        if ($this->request->hasArgument('stundensatzAgenturvertrag')) {
            //   if ($this->request->getArgument('stundensatzAgenturvertrag')) {
            //				$auftraege->setStundensatz(222.9898);
            $auftraege->setStundensatzAgenturvertrag(floatval($this->request->getArgument('stundensatzAgenturvertrag')));
        }
        if ($this->request->hasArgument('changeFremdkosten')) {
            $auftraege->setFremdkosten($this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage'));
            $fremdkostenSumme = 0;
            if ($this->request->hasArgument('fremdkostenAnzahl') && $this->request->hasArgument('fremdkostenName') && $this->request->hasArgument('fremdkostenPreis')) {
                $fremdkostenAnzahl = $this->request->getArgument('fremdkostenAnzahl');
                $fremdkostenName = $this->request->getArgument('fremdkostenName');
                $fremdkostenPreis = $this->request->getArgument('fremdkostenPreis');

                for ($x = 0; $x < count($fremdkostenAnzahl); $x++) {
                    $fremdkosten = new \DslFactory\DslIntranet\Domain\Model\Fremdkosten();
                    $fremdkosten->setAnzahl($fremdkostenAnzahl[$x]);
                    $fremdkosten->setName($fremdkostenName[$x]);
                    $fremdkosten->setPreis($fremdkostenPreis[$x]);
                    $fremdkostenSumme += $fremdkosten->getPreissumme();
                    $auftraege->addFremdkosten($fremdkosten);
                }

            }
            $auftraege->setFremdkostenSumme($fremdkostenSumme);
        }
        if ($this->request->hasArgument('textNotizenIntern')) {
            $auftraege->setNotizenIntern($this->request->getArgument('textNotizenIntern'));
        }
        //  var_dump($this->request->getArguments());
        // die;*/
        return $auftraege;
    }

    private function getPrioritaets()
    {
        $prioritaets = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['prioritaet']['config']['items'] as $prioritaet) {
			$prioritaets[$prioritaet[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.prioritaet.' . $prioritaet[1], 'dsl_intranet',[],'de');
        }
        return $prioritaets;
    }

    private function getStatuss()
    {
        $statuss = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['status']['config']['items'] as $status) {
            //vorbereitet durch kunde angelegt status rauslassen
            if ($status[1] != 5) {
                $statuss[$status[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.statusnr.' . $status[1], 'dsl_intranet',[],'de') . '. ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.status.' . $status[1], 'dsl_intranet',[],'de');
            }
        }
        return $statuss;
    }

    private function getKundenStatuss()
    {
        $statuss = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['status']['config']['items'] as $status) {
            //vorbereitet durch kunde angelegt status rauslassen
            if ($status[1] != 5 && $status[1] != 10 && $status[1] != 70) {
                // && $status[1] != 70
                $statuss[$status[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.kundenstatusnr.' . $status[1], 'dsl_intranet',[],'de') . '. ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.kundenstatus.' . $status[1], 'dsl_intranet',[],'de');
            }
        }
        return $statuss;
    }

    private function getPers()
    {
        $pers = array();
        foreach ($GLOBALS['TCA']['tx_dslintranet_domain_model_auftraege']['columns']['per']['config']['items'] as $per) {
            $pers[$per[1]] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_dslintranet_domain_model_auftraege.per.' . $per[1], 'dsl_intranet',[],'de');
        }
        return $pers;
    }

    /**
     * action import
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function importAction(): \Psr\Http\Message\ResponseInterface
    {
        //$file = 'H:/dsl_data/projekte/web/dsl_intranet/export.json';
        //$file = 'H:/Shares/dsl_data/projekte/web/dsl_intranet/export.json';
        $file = 'W:/xampp/htdocs/server/dsl_intranet/export.json';
        $file = '/var/www/kd/dsl-factory.de/intern/export.json';
        $resultarray = array();
        $resultarray['datei'] = $file;
        $resultarray['dateidatum'] = date('d.m.Y H:i:s', filemtime($file)) . ' Uhr';
        $resultarray['dateigröße'] = filesize($file) . ' Bytes';
        $importArr = json_decode(file_get_contents($file));
        $importUsers = $importArr->fe_users;
        $importAuftraege = $importArr->dsl_auftraege;
        $importZeiten = $importArr->dsl_zeiten;
        $counter = 0;
        foreach ($importAuftraege->items as $importAuftrag) {
            //  echo '!!!!!!!!!!!!!<hr>';
            $counter++;
            //echo $counter;
            $resultarray[] = $importAuftrag[$importAuftraege->index->dsl_auftraege_title];
            if ($auftraege = $this->auftraegeRepository->findByOldid($importAuftrag[$importAuftraege->index->dsl_auftraege_id])) {
                $auftraege = $this->updateAuftraegeImport($auftraege, $importAuftrag, $importAuftraege->index, $importUsers);
                $this->auftraegeRepository->update($auftraege);
            } else {
                $auftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();
                $auftraege = $this->updateAuftraegeImport($auftraege, $importAuftrag, $importAuftraege->index, $importUsers);
                $this->auftraegeRepository->add($auftraege);
            }
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //zeiten eintragen
        $counter = 0;
        foreach ($importZeiten->items as $importZeiteintrag) {
            //echo '<br>ZE:!!' . $importZeiteintrag[$importZeiten->index->dsl_zeiten_dsl_auftraege_id];
            if ($importZeiteintrag[$importZeiten->index->dsl_zeiten_dsl_auftraege_id]) {
                //  echo 'JAZEITEINTRAG';
                //nur wenn es sich um einen normalen zeiteintrag handelt und nicht um einen von nem wartungsvertrag (dsl_zeiten_dsl_wartung_id)
                $counter++;
                $resultarray[] = $importZeiteintrag[$importZeiten->index->dsl_zeiten_text];
                if ($zeiteintraege = $this->zeiteintraegeRepository->findByOldid($importZeiteintrag[$importZeiten->index->dsl_zeiten_id])) {
                    $resultarray[] = 'foundbyoldid';
                    $zeiteintraege = $this->updateZeiteintraegeImport($zeiteintraege, $importZeiteintrag, $importZeiten->index, $importUsers);
                    $this->zeiteintraegeRepository->update($zeiteintraege);
                } else {
                    $resultarray[] = 'neuereintrag!';
                    $zeiteintraege = new \DslFactory\DslIntranet\Domain\Model\Zeiteintraege();
                    $zeiteintraege->setPid($this->settings['zeiteintraegePid']);
                    $zeiteintraege = $this->updateZeiteintraegeImport($zeiteintraege, $importZeiteintrag, $importZeiten->index, $importUsers);
                    $this->zeiteintraegeRepository->add($zeiteintraege);
                }
            } else {

            }
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        /*
        Leeren!!
        SELECT * FROM tx_dslintranet_domain_model_auftraege WHERE oldid

        DELETE FROM tx_dslintranet_domain_model_auftraege WHERE oldid
        */

        $this->view->assign('resultarray', $resultarray);
        // echo "drei";
        echo $this->view->render();
        return $this->htmlResponse();
    }

    /**
     * @param $auftraege
     * @param $importAuftrag
     * @param $index
     * @param $importUsers
     */
    public function updateAuftraegeImport($auftraege, $importAuftrag, $index, $importUsers)
    {
        $fegroup = $this->fegroupsRepository->findByUid(6);
        $auftraege->addFegroup($fegroup);
        /*
        $cfg["astatus"] = array(
        	20 => "Angebot schreiben",
        	30 => "Angeboten",
        	40 => "Auftrag erteilt",
        	50 => "in Bearbeitung",
        	60 => "in Produktion",
        	80 => "Rechn. schreiben",
        	90 => "Rechn. geschrieben"
        );
        array('Vorbereitet', 10),//nur in Kundenansicht
        array('Angebot schreiben', 20),
        array('Auftrag Erteilt', 30),
        array('in Bearbeitung', 40),
        array('in Produktion', 50),
        		array('Produziert/Rechnung schreiben', 60),
        		array('Abgeschlossen / Archiv', 70)

        		//alt:
        array('in Auslieferung', 60),
        array('Rechnung schreiben', 70),
        array('Auftrag Abgeschlossen', 80)
        */

        $statusMapping = array(20 => 10, 30 => 20, 40 => 30, 50 => 40, 60 => 50, 80 => 60, 90 => 70);
        /*

        "prioritaet"=>array(
        	1=>array("value"=>"A","color"=>"F8D6F2"),
        	2=>array("value"=>"B","color"=>"FAE7D0"),
        	3=>array("value"=>"C","color"=>"F0FEE8")
        ),

        array('A', 10),
        array('B', 20),
        array('C', 30)
        */

        $prioritaetMapping = array(1 => 10, 2 => 20, 3 => 30);
        /*	$cfg["auftragsart"] = array(
           2=>array("value"=>"Grafik / Print","shortvalue"=>"G","color"=>"FFFFFF"),
           4=>array("value"=>"Web","shortvalue"=>"W","color"=>"FDF8F3"),
           5=>array("value"=>"Service","shortvalue"=>"S","color"=>"EAF3F3"),
           1=>array("value"=>"Foto","shortvalue"=>"F","color"=>"F8ECF6"),
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                	);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                		1 Grafik / Print
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                	2 Foto
           3 Web
           4 Service                                                                                                                                						*/

        $auftragsartMapping = array(
            1 => 2,
            2 => 1,
            4 => 3,
            5 => 4
        );
        $perMapping = array(
            10 => 10,
            20 => 20,
            30 => 30,
            40 => 40,
            50 => 50
        );
        $auftraege->setTitel($importAuftrag[$index->dsl_auftraege_title]);
        $auftraege->setOldid($importAuftrag[$index->dsl_auftraege_id]);
        //echo ":::";
        //echo count($auftraege->getTexte());
        if (!count($auftraege->getTexte())) {
            $texte = new \DslFactory\DslIntranet\Domain\Model\AuftraegeTexte();
            $texte->setPid($this->settings['auftraegeTextePid']);
            $texte->setBeschreibung($importAuftrag[$index->dsl_auftraege_text]);
            $texte->setTitel('Auftragsbeschreibung');
            $texte->setSichtbarkeit(false);
            $this->auftraegeTexteRepository->add($texte);
            $auftraege->addTexte($texte);
        }
        //$auftraege->setBeschreibung($importAuftrag[$index->dsl_auftraege_text]);
        //$auftraege->setBeschreibung($importAuftrag[$index->dsl_auftraege_text]);
        $auftraege->setDatum(new \DateTime($importAuftrag[$index->dsl_auftraege_datum]));
        if ($importAuftrag[$index->dsl_auftraege_end] != '0000-00-00 00:00:00') {
            $auftraege->setDatumfertigstellung(new \DateTime($importAuftrag[$index->dsl_auftraege_end]));
        } else {
            $auftraege->setDatumfertigstellung(new \DateTime($importAuftrag[$index->dsl_auftraege_datum]));
        }
        //		echo "I3";
        $auftraege->setKontingent($importAuftrag[$index->dsl_auftraege_minuten]);
        $auftraege->setDurch($importAuftrag[$index->dsl_auftraege_erhaltenvon]);
        //dsl_auftraege_erhaltenper
        //per
        $auftraege->setPer($perMapping[$importAuftrag[$index->dsl_auftraege_erhaltenper]]);
        $mitarbeiterSet = false;
        //		echo "I4";
        foreach (explode(',', $importAuftrag[$index->dsl_auftraege_bearbeiter]) as $fe_user_uid) {
            $user = $importUsers->items->{$fe_user_uid};
            if ($user[$importUsers->index->title]) {
                if ($bearbeiter = $this->mitarbeiterRepository->findByInitialien($user[$importUsers->index->title])) {
                    $mitarbeiterSet = true;
                    $auftraege->addMitarbeiter($bearbeiter);
                }
            }
        }
        //		echo "Z1";
        if (!$mitarbeiterSet) {
            $mitarbeiter = $this->mitarbeiterRepository->findByInitialien('DD');
            $auftraege->addMitarbeiter($mitarbeiter);
        }
        if (!$auftraege->getAnsprechpartner()) {
            $mitarbeiter = $this->mitarbeiterRepository->findByInitialien('DD');
            $auftraege->setAnsprechpartner($mitarbeiter);
        }
        //		echo "Z2";
        $user = $importUsers->items->{$importAuftrag[$index->dsl_auftraege_kunden_uid]};
        //		echo "Z3";
        //echo '<br>gefunden :' . $user[$importUsers->index->title] . ' (' . $importAuftrag[$index->dsl_auftraege_kunden_uid] . ')';
        //echo 	$user[$importUsers->index->title];
        //	$importAuftrag[$index->dsl_auftraege_kunden_uid] => nummer rausfinden
        //		echo '<div>'.$importAuftrag[$index->dsl_auftraege_title].': Kundeladen: (' . $user[$importUsers->index->name] . ' / ' . $user[$importUsers->index->company] . ') im alten typo3:' . $user[$importUsers->index->uid] . '</div>';
        if ($user[$importUsers->index->title]) {
            //			echo '<div>nutzer existiert im import</div>';
            if ($kunde = $this->kundenRepository->findByNummer($user[$importUsers->index->title])) {
                //  			echo '<div>'.$kunde.'</div>';
                $auftraege->setKunde($kunde);
                $kunde->setDeleted(0);
                //$kunde->setName($kunde->getName().'___###');
                $this->kundenRepository->update($kunde);
            } else {
                echo '<div>FEHLER! Kunde nicht gefunden</div>';
            }
        } else {
            echo '<div>FEHLER! Kunde (' . $user[$importUsers->index->name] . ' / ' . $user[$importUsers->index->company] . ') hat keine kundennummer uid im alten typo3:' . $user[$importUsers->index->uid] . '</div>';
        }
        //		echo "Z4";
        $auftraege->setAuftragsart($this->auftragsartenRepository->findByUid($auftragsartMapping[$importAuftrag[$index->dsl_auftraege_auftragsart]]));
        //		echo "Y2";
        $auftraege->setPrioritaet($prioritaetMapping[$importAuftrag[$index->dsl_auftraege_abc]]);
        // echo 'Y3';
        $auftraege->setStatus($statusMapping[$importAuftrag[$index->dsl_auftraege_astatus]]);
        //echo 'Z5';
        if ($importAuftrag[$index->dsl_auftraege_archiv]) {
            $auftraege->setStatus(70);
        }
        //echo 'Z6';
        return $auftraege;
    }

    /**
     * @param $zeiteintraege
     * @param $importZeiteintrag
     * @param $index
     * @param $importUsers
     */
    public function updateZeiteintraegeImport($zeiteintraege, $importZeiteintrag, $index, $importUsers)
    {
        $zeiteintraege->setText($importZeiteintrag[$index->dsl_zeiten_text]);
        //		$zeiteintraege->set
        /*$auftraege->setTitel($importAuftrag[$index->dsl_auftraege_title] . ' ' . time());*/
        $zeiteintraege->setOldid($importZeiteintrag[$index->dsl_zeiten_id]);
        $zeiteintraege->setBegin(new \DateTime(date('Y-m-d H:i:s', $importZeiteintrag[$index->dsl_zeiten_start])));
        $zeiteintraege->setEnd(new \DateTime(date('Y-m-d H:i:s', $importZeiteintrag[$index->dsl_zeiten_end])));
        //echo "<pre>".print_r($importUsers)."</pre>";
        //echo "!!!!!".$importUsers->index->title.' ::: '.$importUsers[$importUsers->index->title];
        //		$zeiteintraege->setCruser($mitarbeiter);
        $user = $importUsers->items->{$importZeiteintrag[$index->dsl_zeiten_fe_user_uid]};
        //echo '<br>gefunden!!!! :' . $user[$importUsers->index->title] . ' (' . $importAuftrag[$index->dsl_auftraege_kunden_uid] . ')'.$user[$importUsers->index->title]."!!!";
        if ($mitarbeiter = $this->mitarbeiterRepository->findByInitialien($user[$importUsers->index->title])) {
            //echo "MITARBEITER GEFUNDEN!!!";
            $zeiteintraege->setCruser($mitarbeiter);
        } else {
            //echo "MITARBEITER NICHT GEFUNDEN / STANDARD SK!!!";
            $mitarbeiter = $this->mitarbeiterRepository->findByInitialien('JL');
            $zeiteintraege->setCruser($mitarbeiter);
        }
        if ($auftraege = $this->auftraegeRepository->findByOldid($importZeiteintrag[$index->dsl_zeiten_dsl_auftraege_id])) {
            $auftraege->addZeiten($zeiteintraege);
            $this->auftraegeRepository->update($auftraege);
        }
        //$importZeiteintrag[$index->dsl_zeiten_fe_user_uid]
        //$importZeiteintrag[$index->dsl_zeiten_dsl_auftraege_id]
        //setCruser
        $zeiteintraege->setPhase($this->phasenRepository->findByUid(2));
        $zeiteintraege->setKontingent(ceil(($importZeiteintrag[$index->dsl_zeiten_end] - $importZeiteintrag[$index->dsl_zeiten_start]) / 60));
        return $zeiteintraege;
    }

    /**
     * @param $kunde
     */
    protected function listJSONDataTable($kunde = false)
    {
        // sortierung speichern ?!
        $data = array();
        //$user = $GLOBALS['TSFE']->fe_user->user;
        $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($kunde) {
            $template = 'KundenAuftraege/ListJSONDataTable.html';
        } else {
            $template = 'Auftraege/ListJSONDataTable.html';
        }
        $settings = $benutzer->getSettings();
		
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView($template, $this->request->getControllerExtensionName());
        if (isset($_GET['start'])) {
            $start = intval($_GET['start']);
        } else {
            $start = 0;
        }
        if (isset($_GET['length'])) {
            $length = intval($_GET['length']);
        } else {
            $length = 10;
        }
        if (isset($_GET['order'])) {
            //order hier speichern
            $order = $_GET['order'];
            if (!is_array($settings)){
                $array = json_decode($settings, true);
            }
			$array['auftraegeOrder'] = $order;
			/**************change to string*********************/
			$settings = json_encode($array);


            $benutzer->setSettings($settings);
            $this->frontendUserRepository->update($benutzer);
            $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        
		} else {
            if (isset($settings['auftraegeOrder'])) {
                $order = $settings['auftraegeOrder'];
            } else {
                $order = array();
            }
        }
        if (isset($_GET['search'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = false;
        }
        $auftraegesAnzahlFiltered = count($this->auftraegeRepository->findByFilter($settings, false, false, array(), false, $kunde));

        $auftraegesAnzahl = $this->auftraegeRepository->findByFilter($settings, false, false, array(), $search, $kunde);

        if ($auftraegesAnzahlFiltered) {
            //wenn überhaupt aufträge vorhanden sind
            $sortInRepository = true;
            if ($order[0]['column'] == 3 || $order[0]['column'] == 6) {
                $auftraeges = $this->auftraegeRepository->findByFilter($settings, false, false, array(), $search, $kunde);

                if (count($auftraeges) < 500) {
                    $sortInRepository = false;
                    $dbView->assign('sortDir', strtoupper($order[0]['dir']));
                    if ($order[0]['column'] == 3) {
                        //$dbView->assign('sortField', 'kunde.name,datum');//$dbView->assign('sortField', 'kunde.name');
                        $dbView->assign('sortField', 'kunde.name');
                        $dbView->assign('sortFlags', 'SORT_STRING,SORT_FLAG_CASE');
                    }
                    if ($order[0]['column'] == 6) {
                        $dbView->assign('sortField', 'kontingentUsed');
                        $dbView->assign('sortFlags', 'SORT_NUMERIC,SORT_FLAG_CASE');
                    }
                    $dbView->assign('auftraeges', $auftraeges);
                    $dataTmp = explode('<--line-->', $dbView->render());
                    foreach ($dataTmp as $key => $auftrag) {
                        $data[] = explode('<--break-->', $auftrag);
                    }
                    $data = array_slice($data, $start, $length);
                }
            }

            //\TYPO3\CMS\Core\Utility\DebugUtility::debug($sortInRepository);

            if ($sortInRepository) {

                $auftraeges = $this->auftraegeRepository->findByFilter($settings, $start, $length, $order, $search, $kunde);
                foreach ($auftraeges as $auftraege) {
                    $dbView->assign('auftraege', $auftraege);
                    $data[] = explode('<--break-->', $dbView->render());
                }




            }

        }

        if (isset($data[0])) {
            if (count($data[0]) == 1) {
                $data = array();
            }
        }
        //fehlerbehebung bei leeren datensätzen
        $retarray = array(
            'draw' => $_GET['draw'],
            'recordsTotal' => $auftraegesAnzahlFiltered,
            'recordsFiltered' => count($auftraegesAnzahl),
            'data' => $data
        );

        return $retarray;
    }
    /**
     * Gets authenticated user with proper type handling
     */
    protected function getAuthenticatedBenutzer()
    {
        $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();

        if (is_array($benutzer)) {
            return $this->kundenRepository->findByUid($benutzer['uid'] ?? 0);
        }

        return $benutzer;
    }

    /**
     * Safely extracts user settings
     */
    protected function getUserSettings($benutzer): array
    {
        if (is_array($benutzer)) {
            return $benutzer['settings'] ?? [];
        }

        if (is_object($benutzer) && method_exists($benutzer, 'getSettings')) {
            return $benutzer->getSettings() ?? [];
        }

        return [];
    }

    /**
     * Prepares all view assignments
     */
    /**
     * @param $benutzer
     * @param $auftraeges
     * @param array $settings
     */
    protected function prepareViewAssignments($benutzer, $auftraeges, array $settings): void
    {
        $this->view->assignMultiple([
            'prioritaets' => $this->getPrioritaets(),
            'auftraeges' => $auftraeges,
            'auftraegesAnzahl' => count($this->auftraegeRepository->findByFilter([], false, false, [], false, true)),
            'statuss' => $this->getKundenStatuss(),
            'settings' => $settings,
            'aktiverTab' => $this->getActiveTabIndex($benutzer),
            'auftraegesOffen' => $this->processOpenOrders($benutzer)
        ]);
    }

    /**
     * Processes open orders and returns filtered collection
     */
    /**
     * @param $benutzer
     * @return iterable
     */
    protected function processOpenOrders($benutzer): iterable
    {
        if (!is_object($benutzer) || !method_exists($benutzer, 'getOffeneAuftraege')) {
            return [];
        }

        $auftraegesOffen = $benutzer->getOffeneAuftraege() ?? [];
        $toRemove = [];

        foreach ($auftraegesOffen as $auftraege) {
            if ($benutzer != $auftraege->getKunde() || !$auftraege->getSichtbarkeit()) {
                $toRemove[] = $auftraege;
            }
        }

        if (!empty($toRemove)) {
            foreach ($toRemove as $auftraege) {
                $benutzer->removeOffeneAuftraege($auftraege);
            }

            $this->kundenRepository->update($benutzer);
            $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface::class)
                ->persistAll();
        }

        return $auftraegesOffen;
    }

    /**
     * Determines active tab index
     */
    /**
     * @param $benutzer
     * @return int
     */
    protected function getActiveTabIndex($benutzer): int
    {
        if (!is_object($benutzer) || !method_exists($benutzer, 'getOffeneAuftraege')) {
            return 0;
        }

        $auftraegesOffen = $benutzer->getOffeneAuftraege() ?? [];
        $aktiverTab = 0;

        foreach ($auftraegesOffen as $index => $auftraege) {
            if ($benutzer->getGeoeffneterAuftrag() == $auftraege->getUid()) {
                $aktiverTab = $index;
                break;
            }
        }

        return $aktiverTab;
    }
    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function kundenlistAction(): \Psr\Http\Message\ResponseInterface
    {
        // Initialize required dependencies
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface::class);

        // Get authenticated user with type safety
        $benutzer = $this->getAuthenticatedBenutzer();
        $settings = $this->getUserSettings($benutzer);

        // Get filtered orders
        $auftraeges = $this->auftraegeRepository->findByFilter(
            $settings,
            false,
            false,
            [],
            false,
            true
        );

        // Prepare view assignments
        $this->prepareViewAssignments(
            $benutzer,
            $auftraeges,
            $settings
        );

        // Handle AJAX request
        if ($this->request->hasArgument('ajaxGet')) {
            return $this->jsonResponse($this->view->render());
        }

        return $this->htmlResponse();
    }

    /**
     * action kundenshow
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function kundenshowAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action kundenajax
     *
     * @return void
     */
    public function kundenajaxAction()
    {
        if ($this->request->hasArgument('switch')) {
            switch ($this->request->getArgument('switch')) {
                case 'deleteDatei':    if ($this->request->hasArgument('uid')) {
                    //echo $this->request->getArgument('uid');
                    if ($datei = $this->dateienRepository->findByUid($this->request->getArgument('uid'))) {
                        //echo $datei->getUid();
                        $auftrag = $datei->getAuftraege();
                        //$auftragUid = $auftrag->getUid();
                        //$auftragOriginal = $this->auftraegeRepository->findByUid($auftrag->getUid());
                        //$auftrag->removeDateien($datei);
                        //$auftragOriginal->removeDateien($datei);
                        //echo "auftragdateiremoved";
                        //$this->auftraegeRepository->update($auftrag);
                        //echo "auftragupdated";
                        //die;
                        /*$storageCfg = $datei->getDatei()->getOriginalResource()->getOriginalFile()->getStorage()->getConfiguration();
                          if ($storageCfg['basePath'] && $datei->getDatei()->getOriginalResource()->getOriginalFile()->getIdentifier()) {
                          unlink(rtrim($storageCfg['basePath'], '/') . $datei->getDatei()->getOriginalResource()->getOriginalFile()->getIdentifier());
                          }*/

                        //$datei->getDatei()->detach();
                        //echo "before remove";
                        $this->dateienRepository->remove($datei);
                        //echo "removed!";
                        $datei->getDatei()->getOriginalResource()->getOriginalFile()->getStorage()->deleteFile($datei->getDatei()->getOriginalResource()->getOriginalFile());
                        //echo "after";
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        $auftrag->removeDateien($datei);
                        $this->auftraegeRepository->update($auftrag);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    }
                }
                    return true;
                    break;
                case 'updateDateiTitel':    if ($this->request->hasArgument('uid')) {
                    if ($datei = $this->dateienRepository->findByUid($this->request->getArgument('uid'))) {
                        $datei->setTitel($this->request->getArgument('titel'));
                        $this->dateienRepository->update($datei);
                        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                        echo json_encode(array('uid' => $datei->getUid()));
                    }
                }
                    die;
                    break;
                case 'filterSet':    $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
                    if ($this->request->hasArgument('settings')) {
                        $stringRepresentation= json_encode($this->request->getArgument('settings'));
                        $benutzer->setSettings($stringRepresentation);
                    } else {
                        $benutzer->setSettings('');
                    }
                    $this->frontendUserRepository->update($benutzer);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    $settings = $benutzer->getSettings();
                    $auftraegeGefiltert = $this->auftraegeRepository->findByFilter($settings, false, false, array(), false, true);
                    $found = count($auftraegeGefiltert);
                    echo json_encode(array('found' => $found, 'contentShow' => $this->getKundenAuftraegeList($auftraegeGefiltert)));
                    //from wird nicht mehr benötigt ?! //  'from' => count($this->auftraegeRepository->findByFilter(array(), false, false, array(), false, true)),
                    //,'contentShow'=>$this->getKundenAuftraegeList($auftraegeGefiltert)
                    die;
                    break;
                case 'auftraegeKundenlist':    $retarray = $this->listJSONDataTable(true);
                    echo json_encode($retarray);
                    die;
                    break;
                case 'show':    if (!$this->request->hasArgument('uid')) {
                    break;
                }
                    //					echo asd":".22""
                    //echo "bla";die;
                    $uid = $this->request->getArgument('uid');
                    $tmpArr = explode('-', $uid);
                    if (count($tmpArr) > 1) {
                        $uid = $tmpArr[count($tmpArr) - 1];
                    }
                    $auftraege = $this->auftraegeRepository->findByUid($uid);
                    if ($auftraege->getKunde()->getUid() != $GLOBALS['TSFE']->fe_user->user['uid'] || !$auftraege->getSichtbarkeit()) {
                        die;
                    }
                    //abbruch wegen benutzerrechten
                    return $this->showAction($auftraege);
                    break;
                case 'closeAuftrag':    if (!$this->request->hasArgument('auftragId')) {
                    break;
                }
                    //z.B. #auftrag-show-8
                    $uid = $this->request->getArgument('auftragId');
                    $tmpArr = explode('-', $uid);
                    if (count($tmpArr) > 1) {
                        $uid = $tmpArr[count($tmpArr) - 1];
                    }
                    $auftrag = $this->auftraegeRepository->findByUid($uid);
                    //                    echo $auftrag->getTitel();
                    $user = $GLOBALS['TSFE']->fe_user->user;
                    $benutzer = $this->kundenRepository->findByUid($user['uid']);
                    $benutzer->removeOffeneAuftraege($auftrag);
                    $this->kundenRepository->update($benutzer);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                    //   echo 'mid:' . $benutzer->getUid();
                    die;
                    break;
                case 'setGeoeffneterAuftrag':    if ($this->request->hasArgument('uid')) {
                    $user = $GLOBALS['TSFE']->fe_user->user;
                    $benutzer = $this->kundenRepository->findByUid($user['uid']);
                    $benutzer->setGeoeffneterAuftrag($this->request->getArgument('uid'));
                    $this->kundenRepository->update($benutzer);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                }
                    die;
                    break;
            }
        }
        header('HTTP/1.1 400 Bad Request');
        return json_encode(array('error' => 'Bad request!'));
    }

    /**
     * @param $debugvar
     */
    private function maintenanceCheckRunningZeiteintraege($debugvar)
    {
        //stoppen von zeiteinträgen
        //$debugvar = array();
        //$debugvar['bla']='abc';
        //echo "maintenanceCheckRunningZeiteintraege";
        if ($runningZeiteintraege = $this->zeiteintraegeRepository->findAllRunning()) {
            foreach ($runningZeiteintraege as $tracker) {
                $tracker = $this->checkTracker($tracker);


                //Kontingent neu zusammenrechnen
                if($tracker->getAuftraege()){
                    $tracker->getAuftraege()->setKontingentUsedCached(0);
                    $tracker->getAuftraege()->getKontingentUsed();
                    $this->zeiteintraegeRepository->update($tracker);
                    $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
                }

            }
        }
        return $debugvar;
    }

    /**
     * action maintenance
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function maintenanceAction(): \Psr\Http\Message\ResponseInterface
    {
        $debugvar = array();
        $debugvar = $this->maintenanceCheckRunningZeiteintraege($debugvar);
        \DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceCheckForWartungsvertraegeNewZeitraeume();
        \DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceCheckForWartungsvertraegeNewRechnungen();
        \DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceCheckForWartungsvertraegeRechnungenStatus();
        \DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceCheckForWartungsvertraegeRechnungenMehraufwandZeitraeumeStatus();
        \DslFactory\DslIntranet\Utility\MaintenanceUtility::init()->maintenanceDateienTempFields();
        //$debugvar = $this->maintenanceCheckForRechnungenMehraufwandZeitraeumeStatus($debugvar);



        /*
        //zeiten in allen aufträgen aktualisieren
        $auftraeges = $this->auftraegeRepository->findAll();
//        echo "<br>anzahlaufträge:".count($auftraeges);
        $updateZeiten = false;
        $zaehler = 0;
        foreach ($auftraeges as $auftraege) {
            $zaehler++;
//            echo "<br>".$zaehler.". auftrag: ".$auftraege->getUid();
//            echo ": minuten: ";
            $auftraege->setKontingentUsedCached(0);
            $auftraege->getKontingentUsed();
            echo $auftraege->getKontingentUsedCached();
            $this->auftraegeRepository->update($auftraege);

        }
        //if($updateZeiten) {
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //}


*/
        $this->view->assign('debugvar', $debugvar);
//        echo "<hr><strong>FERTIG</strong>";
        return $this->htmlResponse();
    }
   

    /**
     * action upload
     *
     * @return void
     */
    public function uploadAction()
    {
        $auftrag = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
		$newDateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
		
        if ($auftrag->getKunde() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $auftrag->getKunde()->_loadRealInstance();
        }
        if ($this->request->getArgument('type') == 30) {
            //	$newDateien->getDatei()->delete();
            $tmpArr = explode('_', $newDateien->getDateiNameOhneErweiterung());
            if ($tmpArr[0]) {
                $invalid = false;
            }
            if (count($tmpArr) > 1) {
                if (strlen($tmpArr[0]) == 8 && strlen($tmpArr[1]) == 4) {
                    if ($tmpArr[1] == $auftrag->getKunde()->getNummer()) {

                    } else {
                        $invalid = 'Kundennummer im Dateiname passt nicht.';
                    }
                } else {
                    $invalid = 'Der Dateiname muß mit der Rechnungsnummer gefolgt von der Kundennummer beginnen. (xxxxxxxx_xxxx.pdf)';
                }
            } else {
                $invalid = 'Der Dateiname muß mit der Rechnungsnummer gefolgt von der Kundennummer beginnen. (xxxxxxxx_xxxx.pdf)';
            }
            if (!is_numeric(str_replace('_', '', str_replace(array(',', '.', '-'), 'A', $newDateien->getDateiNameOhneErweiterung())))) {
                $invalid = 'Es sind nur Zahlen im Dateiname erlaubt. (xxxxxxxx_xxxx.pdf)';
            }
            if ($invalid) {
                echo $invalid;
                $newDateien->getDatei()->getOriginalResource()->getOriginalFile()->getStorage()->deleteFile($newDateien->getDatei()->getOriginalResource()->getOriginalFile());
                die;
            }
        }
        if ($this->request->getArgument('type') == 20) {
            //	$newDateien->getDatei()->delete();
			if($newDateien->getDateiNameOhneErweiterung()){
				$tmpArr = explode('_', $newDateien->getDateiNameOhneErweiterung());
				if ($tmpArr[0]) {
					$invalid = false;
				}
				if (count($tmpArr) > 1) {
					if (strlen($tmpArr[0]) >= 4 && strlen($tmpArr[0]) < 8 && strlen($tmpArr[1]) == 4) {
						if ($tmpArr[1] == $auftrag->getKunde()->getNummer()) {

						} else {
							$invalid = 'Kundennummer im Dateiname passt nicht.';
						}
					} else {
						$invalid = 'Der Dateiname muß mit der Angebotsnummer gofolgt von der Kundennummer beginnen. (xxxx_xxxx.pdf)';
					}
				} else {
					$invalid = 'Der Dateiname muß mit der Angebotsnummer gofolgt von der Kundennummer beginnen. (xxxx_xxxx.pdf)';
				}
				if (!is_numeric(str_replace('_', '', str_replace(array(',', '.', '-'), 'A', $newDateien->getDateiNameOhneErweiterung())))) {
					$invalid = 'Es sind nur Zahlen im Dateiname erlaubt. (xxxx_xxxx.pdf)';
				}
				if ($invalid) {
					echo $invalid;
					$newDateien->getDatei()->getOriginalResource()->getOriginalFile()->getStorage()->deleteFile($newDateien->getDatei()->getOriginalResource()->getOriginalFile());
					die;
				}
			}
        }
        //die;
        $newDateien->setType((int)$this->request->getArgument('type'));
        $newDateien->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        // 20 = angebot / 30 = rechnung
        //$orgres = $newDateien->getDatei()->getOriginalResource();
        //$orgres->setStorage(2);
        if ($auftrag->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $auftrag->getMitarbeiter()->_loadRealInstance();
        }
        if ($auftrag->getAnsprechpartner() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $auftrag->getAnsprechpartner()->_loadRealInstance();
        }
        /*
        array('KD Angebot', 20),
        array('Rechnung', 30),
        */

        //$newDateien->setKunden($auftrag->getKunde());///
        $auftrag->getKunde()->addDateien($newDateien);
        if ($newDateien->getType() == 20 || $newDateien->getType() == 30) {
            $newDateien->setSichtbarkeit(true);
			if($newDateien->getDateiNameOhneErweiterung()){
				//achtung existiert noch im AuftraegeController
				$tmpArr = explode('_', $newDateien->getDateiNameOhneErweiterung());
				if (count($tmpArr) > 1) {
					//rechnung oder angebot
					if (strlen($tmpArr[0]) == 8) {
						//rechnung
						//$newDateien->setType(30);
						$newDateien->setTempRechnungsNummer($tmpArr[0]);
					} elseif (strlen($tmpArr[0]) == 4) {
						//angebot
						$newDateien->setTempRechnungsNummer($tmpArr[0]);
					}
				}
			}
        }
		
		 if ($this->request->hasArgument('newDateien')) {
            $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            $FileDeletionAspect = GeneralUtility::makeInstance(FileDeletionAspect::class);
            $fileUtility = new FileUtility($resourceFactory, $FileDeletionAspect);

            $uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('auftraegeAngeboteRechnungen');

            //$uploadedImage = $this->createUserProfileImage($image);
            // Index the image, it will move the file and return the FAL file object
            $indexedFiles = $fileUtility->indexImages($this->request->getArgument('newDateien')['datei'], $uploadSettings['falStorageSubDir'], true);

            if (!empty($indexedFiles)) {
                $falFile = $indexedFiles[0];

                // Now, you can create a FileReference from this FAL file and save it to your model
                $fileReference = $fileUtility->createFileReferenceFromFalFileObject($falFile, 0, 0,'','');

                // Assuming you have an Event model that accepts a FileReference
                $newDateien->setDatei($fileReference);


            }
        }
        $newDateien->setTempKundenName($auftrag->getKunde()->getName());
        $newDateien->setTempKundenNummer($auftrag->getKunde()->getNummer());
        $this->dateienRepository->add($newDateien);
        $auftrag->addDateien($newDateien);
        //$auftrag->addDateien($newDateien);
        $this->auftraegeRepository->update($auftrag);
       
        $protokolle = new \DslFactory\DslIntranet\Domain\Model\Protokolle();
        $protokolle->setPid((int)$this->settings['protokollePid']);
        $protokolle->setAuftrag($auftrag);
        $protokolle->setDatei($newDateien);
        //		echo "b";
        $protokolle->setAktion(90);
        $protokolle->setZeitpunkt(new \DateTime());
        $protokolle->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        //		echo "c";
        $this->protokolleRepository->add($protokolle);
        //		echo "d";
        //dslneu
        //if ($auftrag->getSichtbarkeit()) {
        //$protokolle->sendKundeninfoMail();
        //			echo "e";
        $mailSettings = $protokolle->getMailSettings();
        //echo $mailSettings["template"];die;
        if (!$mailSettings['mailInfoDenied'] && $mailSettings['template'] && $newDateien->getSichtbarkeit()) {
            $newProtokollePending = $this->initProtokollPending($protokolle);
        }
        //print_r($mailSettings);die;
        //}
        //		echo "f";
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //echo "a1";
        $notificationAnsprechpartner = new \DslFactory\DslIntranet\Domain\Model\Notification();
        $notificationAnsprechpartner->setAuftrag($auftrag);
        $notificationAnsprechpartner->setArt(80, $auftrag->getStatusText(), $newDateien->getDateiName(), $newDateien->getDateiGroesse(), $newDateien->getType());
        $notificationAnsprechpartner->setMitarbeiter($auftrag->getAnsprechpartner());
        if ($notificationAnsprechpartner->forOtherUser()) {
            $this->notificationRepository->add($notificationAnsprechpartner);
        }
        //echo "b";
        foreach ($auftrag->getMitarbeiter() as $mitarbeiter) {
            //echo "c";
            if ($auftrag->getAnsprechpartner() != $mitarbeiter) {
                //echo "d";
                $notificationMitarbeiter = clone $notificationAnsprechpartner;
                $notificationMitarbeiter->resetUid();
                //echo "e";
                //$notificationMitarbeiter->setMitarbeiter($mitarbeiter);
                if ($notificationMitarbeiter->forOtherUser()) {
                    //echo "f";
                    $this->notificationRepository->add($notificationMitarbeiter);
                }
            }
        }
        //echo "g";
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //echo 1;
        echo json_encode(array('uid' => $auftrag->getUid(), 'protokollePendingUid' => $newProtokollePending ? $newProtokollePending->getUid() : false));
        //echo "<div>bla</div>";
        //       echo $this->view->render();
		 $this->redirect('list');
        die;
    }

    
    /**
     * action kundenupload
     *
     * @return void
     */
    public function kundenuploadAction()
    {
		$newDateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
        $newDateien->setType(50);
        $newDateien->setSichtbarkeit(TRUE);
        $newDateien->setCruser(\DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        // 20 = angebot / 30 = rechnung
        //$orgres = $newDateien->getDatei()->getOriginalResource();
        //$orgres->setStorage(2);
        $auftrag = $this->auftraegeRepository->findByUid($this->request->getArgument('auftraege'));
        $newDateien->setTempKundenName($auftrag->getKunde()->getName());
        $newDateien->setTempKundenNummer($auftrag->getKunde()->getNummer());
		if ($this->request->hasArgument('newDateien')) {
            $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            $FileDeletionAspect = GeneralUtility::makeInstance(FileDeletionAspect::class);
            $fileUtility = new FileUtility($resourceFactory, $FileDeletionAspect);

            $uploadSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('auftraegeKundenUploads');

            //$uploadedImage = $this->createUserProfileImage($image);
            // Index the image, it will move the file and return the FAL file object
            $indexedFiles = $fileUtility->indexImages($this->request->getArgument('newDateien')['datei'], $uploadSettings['falStorageSubDir'], true);

            if (!empty($indexedFiles)) {
                $falFile = $indexedFiles[0];

                // Now, you can create a FileReference from this FAL file and save it to your model
                $fileReference = $fileUtility->createFileReferenceFromFalFileObject($falFile, 0, 0,'','');

                // Assuming you have an Event model that accepts a FileReference
                $newDateien->setDatei($fileReference);


            }
        }
        $this->dateienRepository->add($newDateien);
        //evtl. prüfen ob der auftrag auch dem kunde gehört!!!!!!!!!///SECURITY
        $auftrag->getKunde()->addDateien($newDateien);
        $auftrag->addDateien($newDateien);
        $this->auftraegeRepository->update($auftrag);
        //		$storageCfg = $newDateien->getDatei()->getOriginalResource()->getOriginalFile()->getStorage()->getConfiguration();
        //		$resultarray[] = rtrim($storageCfg['basePath'], '/') . $newDateien->getDatei()->getOriginalResource()->getOriginalFile()->getIdentifier();
        //fehlerumgehung
        $newDateien->setAuftraege($auftrag);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //echo $newDateien->getUid().":".$newDateien->getCrdate();die;
        $notificationAnsprechpartner = new \DslFactory\DslIntranet\Domain\Model\Notification();
        $notificationAnsprechpartner->setAuftrag($auftrag);
        $notificationAnsprechpartner->setArt(90, $auftrag->getStatusText(), $newDateien->getDateiName(), $newDateien->getDateiGroesse(), $newDateien->getType());
        $notificationAnsprechpartner->setMitarbeiter($auftrag->getAnsprechpartner());
        if ($notificationAnsprechpartner->forOtherUser()) {
            $this->notificationRepository->add($notificationAnsprechpartner);
        }
        foreach ($auftrag->getMitarbeiter() as $mitarbeiter) {
            if ($auftrag->getAnsprechpartner() != $mitarbeiter) {
                $notificationMitarbeiter = clone $notificationAnsprechpartner;
                $notificationMitarbeiter->resetUid();
                //$notificationMitarbeiter->setMitarbeiter($mitarbeiter);
                if ($notificationMitarbeiter->forOtherUser()) {
                    $this->notificationRepository->add($notificationMitarbeiter);
                }
            }
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        //	echo "puuuh";
        echo json_encode(array('auftraegeUid' => $auftrag->getUid(), 'uid' => $newDateien->getUid(), 'contentShow' => $this->getDownloadsPartialsListRow($newDateien)));
        //echo json_encode(array('auftraegeUid' => $auftrag->getUid(), 'uid' => $newDateien->getUid(), 'contentShow' => $this->getDownloadsPartialsListRow($newDateien)));
        die;
        echo 1;
        //echo "<div>bla</div>";
        //       echo $this->view->render();
        die;
    }

    /**
     * @param \DslFactory\DslIntranet\Domain\Model\Dateien $datei
     */
    public function getDownloadsPartialsListRow(\DslFactory\DslIntranet\Domain\Model\Dateien $datei)
    {
        $user = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        if ($user->isKunde()) {
            //return "idkunde";
            $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Dateien/KundenDownloadsListItemAjax.html', $this->request->getControllerExtensionName());
        } else {
            $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Dateien/DownloadsListItemAjax.html', $this->request->getControllerExtensionName());
        }
        $dbView->assignMultiple(array('datei' => $datei));
        return $dbView->render();
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DslFactory\DslIntranet\Domain\Model\Auftraege> $auftraege
     */
    public function getKundenAuftraegeList($auftraege)
    {
        //	return "bla";
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('KundenAuftraege/ListAjax.html', $this->request->getControllerExtensionName());
        $dbView->assignMultiple(array('auftraeges' => $auftraege));
        return $dbView->render();
    }

    /**
     * action kundenhome
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function kundenhomeAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action agenturauftraegelist
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function agenturauftraegelistAction(): \Psr\Http\Message\ResponseInterface
    {
        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Auftraege/Agenturauftraegelist.html', $this->request->getControllerExtensionName());
        $dbView->assign('kunde', $kunde);
        return $this->htmlResponse();
    }

    /**
     * action index
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(): \Psr\Http\Message\ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('feuser', \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        
        /*
              $caldavSettings = \DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('caldav');
        		?><pre><?php var_dump($caldavSettings);die;*/

        /*
        		$caldavclient = \DslFactory\DslIntranet\Utility\CalDavClientUtility::init('http://176.95.184.45:8888/caldav/', "dirk", "dd_0006",8888);
        		$arrayOfCalendars = $caldavclient->findCalendars();?><pre><?php var_dump($arrayOfCalendars);?></pre><?php 
        		
        		//$caldavclient->setCalendar($arrayOfCalendars["10D60E1B-6676-47AA-A254-9AC2919F877A"]->getURL());
        		$caldavclient->setCalendar($arrayOfCalendars["FDE2BEB4-AB68-4E27-80C8-39C0AEC10A24"]->getURL());//dd
        		
        		
        		$events = $caldavclient->getEvents('20191101T103000Z', '20191131T200000Z');//'20140418T103000Z', '20200419T200000Z'
        			
        		 ?><hr><pre><?php var_dump($events);?></pre><?php 
        		
        		foreach($events as $key => $event){
        		
        
        			echo "<hr>";
        			?><pre><?php print_r(array(
        				"summary" => $events[$key]["event"]->summary,
        				"description" => $events[$key]["event"]->description,
        				"dateStart" => $events[$key]["event"]->dateStart,
        				"dateEnd" => $events[$key]["event"]->dateEnd,
        				"location" => $events[$key]["event"]->location
        			));?></pre><?php 
        			
        
        			
        			?><pre><?php var_dump($events[$key]["data"]);?></pre><?php 
        			?><pre><?php var_dump($events[$key]["event"]);?></pre><?php 
        		}
        	
        		die;
        		/**/

        $this->view->assign('prioritaets', $this->getPrioritaets());
        $kundens = $this->kundenRepository->getActive();
        $this->view->assign('kundens', $kundens);
        $auftragsartens = $this->auftragsartenRepository->findAll();
        $this->view->assign('auftragsartens', $auftragsartens);
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        $this->view->assign('mitarbeiters', $mitarbeiters);
        
$statuss = $this->getStatuss();
foreach($statuss as $statusKey => $statusValue){
    $statuss[$statusKey].=" (".count($this->auftraegeRepository->findByFilter(array('statuss' => array($statusKey)))).")"; 
}
//die;

        $this->view->assign('statuss', $statuss);
        $this->view->assign('pers', $this->getPers());
        //laden der aktiven Filterzustände
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $settings = $mitarbeiter->getSettings();
        $this->view->assign('settings', $settings);
        //print_r($settings);
        //die;


       if(isset($settings['favoriten'])){
           unset($settings['favoriten']);
       }

        $auftraeges = $this->auftraegeRepository->findByFilter($settings);

        $this->view->assign('auftraeges', $auftraeges);

        if($this->auftraegeRepository->findByFilter(array('favoriten' => true)) == NULL){
            $this->view->assign('auftraegesFavoritenAnzahl', 0);

        }else{
            $this->view->assign('auftraegesFavoritenAnzahl', count($this->auftraegeRepository->findByFilter(array('favoriten' => true))));

        }
        //		$auftraeges = $this->auftraegeRepository->findAll();
        if ($this->request->hasArgument('ajaxGet')) {
            //		echo "AJAX!!!:";
            echo trim($this->view->render());
            die;
        }
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     * @param $setOffenerAuftrag
     * @return void
     */
    public function showAction(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege, $setOffenerAuftrag = false)
    {
        $user = $GLOBALS['TSFE']->fe_user->user;
        $kundeUid = 0;
        if ($auftraege->getKunde()) {
            $kundeUid = $auftraege->getKunde()->getUid();
        }

        if ($kundeUid == $user['uid']) {
            $kunde = true;
            $template = 'KundenAuftraege/Show.html';
            $benutzer = $this->kundenRepository->findByUid($user['uid']);
        } else {
            $kunde = false;
            $template = 'Auftraege/Show.html';
            $benutzer = $this->mitarbeiterRepository->findByUid($user['uid']);
        }

        $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView($template, $this->request->getControllerExtensionName());
        $dbView->assign('auftraege', $auftraege);
        $dbView->assign('gentime', time());
        if ($setOffenerAuftrag) {
            $benutzer->addOffeneAuftraege($auftraege);
            $benutzer->setGeoeffneterAuftrag($auftraege->getUid());
        }
        //echo "\ngeöfnetterauftrag:".$benutzer->getGeoeffneterAuftrag();
        //echo "test";
        if ($kunde) {
            $this->kundenRepository->update($benutzer);
        } else {
            $this->mitarbeiterRepository->update($benutzer);
            $newDateien = new \DslFactory\DslIntranet\Domain\Model\Dateien();
            $dbView->assign('newDateien', $newDateien);
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        $phasenDefaultArr = array();
        $phasens = $this->phasenRepository->findAll();
        foreach ($phasens as $phase) {
            $phasenDefaultArr[$phase->getUid()]['label'] = $phase->getTitel();
            $phasenDefaultArr[$phase->getUid()]['color'] = $phase->getColor();
            $phasenDefaultArr[$phase->getUid()]['highlight'] = $phase->getHighlightcolor();
        }
        $phasenDefaultArr[0] = array('color' => '#f4f4f4', 'label' => 'Offen', 'highlight' => '#f4f4f4');
        $dbView->assign('phasens', $phasens);
        $kontingentPhasenArr = $auftraege->getKontingentPhasenUsed();
        $kontingentPhasenJson = array(
            'labels' => array(),
            'datasets' => array(
                array(
                    'data' => array(),
                    'backgroundColor' => array(),
                    'hoverBackgroundColor' => array(),
                    'borderWidth' => 0
                )
            )
        );
        foreach ($phasenDefaultArr as $key => $v) {
            // Check if the key exists in $kontingentPhasenArr and has content
            if (!empty($kontingentPhasenArr[$key])) {
                $phase = $kontingentPhasenArr[$key];

                // Initialize datasets array if not exists
                if (!isset($kontingentPhasenJson['datasets'][0])) {
                    $kontingentPhasenJson['datasets'][0] = [
                        'data' => [],
                        'backgroundColor' => [],
                        'hoverBackgroundColor' => []
                    ];
                }

                $kontingentPhasenJson['labels'][] = '';

                if ($key === 0) {
                    $kontingentPhasenJson['datasets'][0]['data'][] = $phase['used'] ?? 0;
                    $kontingentPhasenJson['datasets'][0]['backgroundColor'][] = '#c5c6c8';
                    $kontingentPhasenJson['datasets'][0]['hoverBackgroundColor'][] = '#9c9d9f';
                } else {
                    // Safely access phase default values with fallbacks
                    $defaultColor = $phasenDefaultArr[$key]['color'] ?? '#cccccc';
                    $defaultHighlight = $phasenDefaultArr[$key]['highlight'] ?? '#aaaaaa';

                    $kontingentPhasenJson['datasets'][0]['data'][] = $phase['used'] ?? 0;
                    $kontingentPhasenJson['datasets'][0]['backgroundColor'][] = $defaultColor;
                    $kontingentPhasenJson['datasets'][0]['hoverBackgroundColor'][] = $defaultHighlight;
                }
            }
        }
        //echo 4;
        if ($kontingentPhasenArr['all']['free'] > 0) {
            $kontingentPhasenJson['labels'][] = '';
            $kontingentPhasenJson['datasets'][0]['data'][] = $kontingentPhasenArr['all']['free'];
            $kontingentPhasenJson['datasets'][0]['backgroundColor'][] = $phasenDefaultArr[0]['color'];
            $kontingentPhasenJson['datasets'][0]['hoverBackgroundColor'][] = $phasenDefaultArr[0]['highlight'];
        }
        $dbView->assign('kontingentPhasenChartJson', json_encode($kontingentPhasenJson));
        //        $dbView->assign('kontingentPhasenChart', $kontingentPhasenArr);
        //        $dbView->assign('kontingentPhasenJson', $kontingentPhasenJson);
        //        $dbView->assign('phasenDefaultArr', $phasenDefaultArr);
        $aktivitaetDefaultDate = new \DateTime();
        if ($this->request->hasArgument('aktivitaetsDatum')) {
            if ($aktivitaetsDatum = $this->request->getArgument('aktivitaetsDatum')) {
                $aktivitaetDefaultDate = new \DateTime($aktivitaetsDatum);
            }
        }
        $validToTrack = false;
        if (!$kunde) {


            /*geändert getZeiteintragCounter*/
            //$tracker = $this->getTracker($auftraege->getUid());

            if($this->request->hasArgument('uid')){
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dslintranet_domain_model_zeiteintraege');
                $result = $queryBuilder
                    ->select('uid')
                    ->from('tx_dslintranet_domain_model_zeiteintraege')
                    ->where(
                        $queryBuilder->expr()->eq(
                            'auftraege',
                            $queryBuilder->createNamedParameter((int)$this->request->getArgument('uid'), Connection::PARAM_INT)
                        )
                    )
                    ->andWhere(
                        $queryBuilder->expr()->eq(
                            'end',
                            $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)
                        )
                    )
                    ->executeQuery()
                    ->fetchAssociative();



                $tracker = $this->zeiteintraegeRepository->findByUid($result['uid']);
            }else{
                $tracker = $this->getTracker($auftraege->getUid());
            }

            //\TYPO3\CMS\Core\Utility\DebugUtility::debug($tracker);
            if ($tracker) {
                $auftraege->setMitarbeiterTracker($tracker);
                if ($tracker->isValidToTrack()) {
                    $validToTrack = true;
                } else {
                    $aktivitaetDefaultDate = $tracker->getBegin();
                }
            } else {
                $validToTrack = true;
            }
            $dbView->assign('tracker', $tracker);
        }
        //echo 5;
        $dbView->assign('validToTrack', $validToTrack);
        $mitarbeiters = $this->mitarbeiterRepository->findByGroups($auftraege->getFegroups());
        //$mitarbeiters = $this->mitarbeiterRepository->findAll();
        //die;
        $dbView->assign('mitarbeiters', $mitarbeiters);
        $mitarbeiterSet = array();
        $ansprechpartnerSet = array();
        foreach ($mitarbeiters as $mitarbeiter) {
            $mitarbeiterSet[$mitarbeiter->getUid()] = false;
            $ansprechpartnerSet[$mitarbeiter->getUid()] = false;
        }
        //neu
        if ($auftraege->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $auftraege->getMitarbeiter()->_loadRealInstance();
        }
        foreach ($auftraege->getMitarbeiter() as $mitarbeiter) {
            $mitarbeiterSet[$mitarbeiter->getUid()] = true;
        }
        $dbView->assign('mitarbeiterSet', $mitarbeiterSet);
        if ($auftraege->getAnsprechpartner()) {
            $ansprechpartnerSet[$auftraege->getAnsprechpartner()->getUid()] = true;
        }
        //echo 6;
        $dbView->assign('ansprechpartnerSet', $ansprechpartnerSet);
        //$zeiteintraege = $this->zeiteintraegeRepository->findByUid($this->request->getArgument('uid'));
        if (!$kunde) {
            $dbView->assignMultiple($this->getVarsForAktivitaeten($aktivitaetDefaultDate, $auftraege));

            $dbView->assign('feuser', \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser());
        }
        return $dbView->render();
    }

    /**
     * @param $aktivitaetDate
     * @param $auftraege
     */
    function getVarsForAktivitaeten($aktivitaetDate, $auftraege)
    {
        $benutzer = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $aktivitaeten = $this->zeiteintraegeRepository->findAktivitaeten($aktivitaetDate, $benutzer);
        $tagBegin = new \DateTime(date('Y-m-d 07:00:00', $aktivitaetDate->getTimestamp()));
        $tagEnd = new \DateTime(date('Y-m-d 19:00:00', $aktivitaetDate->getTimestamp()));
        $aktivitaetenGesamtMinuten = 0;
        foreach ($aktivitaeten as $aktivitaet) {
            $aktivitaetenGesamtMinuten += $aktivitaet->getMinutes();
        }
        //echo "bla";
        //die;
        $now = new \DateTime();
        $enabledDatesArr = array($aktivitaetDate->format('m/d/Y') => 1);
        $enabledDatesArr[$now->format('m/d/Y')] = 1;
        $aktivitaetenTemp = $this->zeiteintraegeRepository->findAktivitaetenForAuftrag($auftraege, $benutzer);
        foreach ($aktivitaetenTemp as $temp) {
            $enabledDatesArr[$temp->getBegin()->format('m/d/Y')] = 1;
        }
        $enabledDates = '["' . implode('","', array_keys($enabledDatesArr)) . '"]';
        //echo $enabledDates;
        return array(
            'aktivitaetenGesamtMinuten' => $aktivitaetenGesamtMinuten,
            'aktivitaetenGesamtProzent' => ceil($aktivitaetenGesamtMinuten / 480 * 100),
            'enabledDates' => $enabledDates,
            'aktivitaeten' => $aktivitaeten,
            'aktivitaetDefaultDate' => $aktivitaetDate,
            'effektivitaetBegin' => 0,
            'effektivitaetEnd' => 600,
            'tagesuebersichtBegin' => $tagBegin->getTimestamp(),
            'tagesuebersichtEnd' => $tagEnd->getTimestamp(),
            'effektivitaetArr' => $this->getEffektivitaetArr(),
            'aktivitaetenArr' => $this->getAktivitaetenArr()
        );
    }

    function getEffektivitaetArr()
    {
        $effektivitaetArr = array();
        for ($x = 0; $x < 10; $x++) {
            $effektivitaetArr[$x] = array(
                'labelLeft' => $x,
                'class' => ''
            );
            if ($x < 8) {
                $effektivitaetArr[$x]['class'] = 'bg_light';
            }
            if ($x == 9) {
                $effektivitaetArr[$x]['labelRight'] = 10;
            }
        }
        return $effektivitaetArr;
    }

    function getAktivitaetenArr()
    {
        $effektivitaetArr = array();
        for ($x = 7; $x < 19; $x++) {
            $effektivitaetArr[$x] = array(
                'labelLeft' => $x . ' Uhr',
                'class' => ''
            );
            if ($x > 7 && $x < 17) {
                $effektivitaetArr[$x]['class'] = 'bg_light';
            }
            if ($x == 18) {
                $effektivitaetArr[$x]['labelRight'] = '19 Uhr';
            }
        }
        return $effektivitaetArr;
    }

    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newAction(): \Psr\Http\Message\ResponseInterface
    {
        $newAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();
		
        //$newAuftraege->setTitel('neu / vorbelegung');
        $newAuftraege->setDatum(new \DateTime());
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        $newAuftraege->addMitarbeiter($mitarbeiter);
        $newAuftraege->setFegroups($mitarbeiter->getUsergroup());
        $newAuftraege->setAnsprechpartner($mitarbeiter);
        $newAuftraege->setNutzungsFaktorNurEntwurfKreativleistung(true);
        $newAuftraege->setSichtbarkeit(true);
        $this->view->assign('defaultStundensatz', floatval(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('defaultStundensatz')));
        $this->view->assign('prioritaets', $this->getPrioritaets());
        //$this->view->assign('statuss', $this->getStatuss());
        $this->view->assign('pers', $this->getPers());
        $this->view->assign('auftraege', $newAuftraege);
        $mitarbeiters = $this->mitarbeiterRepository->findAll();

        $this->view->assign('mitarbeiters', $mitarbeiters);
        $kundens = $this->kundenRepository->getActive();
        $this->view->assign('kundens', $kundens);
        $lieferantens = $this->lieferantenRepository->findAll();
        $this->view->assign('lieferantens', $lieferantens);
        $fegroups = $this->fegroupsRepository->findAll();

        $this->view->assign('fegroups', $fegroups);
        $auftragsartens = $this->auftragsartenRepository->findAll();
        $this->view->assign('auftragsartens', $auftragsartens);
        $phasens = $this->phasenRepository->findAll();
        $this->view->assign('phasens', $phasens);
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @return void
     */
    public function createAction()
    {
		
		$newAuftraege = new \DslFactory\DslIntranet\Domain\Model\Auftraege();
	    $newAuftraege = $this->updateAuftragFromRequest($newAuftraege);
		$this->auftraegeRepository->add($newAuftraege);

        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        $this->view->assign('Auftraege', $newAuftraege);
        $this->view->assign('returnString', json_encode(array('newUid' => $newAuftraege->getUid())));
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("auftraege")
     * @return void
     */
    public function editAction(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege)
    {
        //$auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('uid'));
       // \TYPO3\CMS\Core\Utility\DebugUtility::debug($auftraege);
		//die();
		$dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Auftraege/Edit.html', $this->request->getControllerExtensionName());
        $fegroups = $this->fegroupsRepository->findAll();
        $dbView->assign('defaultStundensatz', floatval(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('defaultStundensatz')));
        $dbView->assign('fegroups', $fegroups);
        $mitarbeiters = $this->mitarbeiterRepository->findAll();
        $dbView->assign('mitarbeiters', $mitarbeiters);
        $kundens = $this->kundenRepository->getActive();
        $dbView->assign('kundens', $kundens);
        $lieferantens = $this->lieferantenRepository->findAll();
        $dbView->assign('lieferantens', $lieferantens);
        if ($auftraege->getKunde()) {
            $dbView->assign('projekte', $this->projekteRepository->findByKunde($auftraege->getKunde()));
        }
        //hier weg
        //        $projekte = $this->projekteRepository->findAll();
        //      $dbView->assign('projekte', $projekte);
        $auftragsartens = $this->auftragsartenRepository->findAll();
        $fegroups = $this->fegroupsRepository->findAll();
        $dbView->assign('fegroups', $fegroups);
        $dbView->assign('auftragsartens', $auftragsartens);
        $phasens = $this->phasenRepository->findAll();
        $dbView->assign('phasens', $phasens);
        //$phasens = $this->phasenRepository->findAll();
        //$dbView->assign('prioritaets', $prioritaets);
        $dbView->assign('prioritaets', $this->getPrioritaets());
        //	$dbView->assign('statuss', $this->getStatuss());
        $dbView->assign('pers', $this->getPers());
        $dbView->assign('auftraege', $auftraege);
        //$dbView->assignMultiple(array('auftraege' => $auftraege));
         echo $dbView->render();
        die;
    }

    /**
     * action edit
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("auftraege")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editStatusChange(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege): \Psr\Http\Message\ResponseInterface
    {
        if ($this->request->hasArgument('statusAlt') && $this->request->hasArgument('statusNeu') && $this->request->hasArgument('uniqueSelector')) {
            $statusAlt = $this->request->getArgument('statusAlt');
            $statusNeu = $this->request->getArgument('statusNeu');
            $uniqueSelector = $this->request->getArgument('uniqueSelector');
            //switch($statusAlt."_".$statusNeu){
            switch ('' . $statusNeu . '') {
                case '50':    //von in Bearbeitung in Produktion
                    //if(!$datumproduktion){}
                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Auftraege/EditStatusTo50.html', $this->request->getControllerExtensionName());
                    $dbView->assign('auftraege', $auftraege);
                    $dbView->assign('statusNeu', $statusNeu);
                    $dbView->assign('statusAlt', $statusAlt);
                    $dbView->assign('uniqueSelector', $uniqueSelector);
                    $dbView->assign('status', array($statusAlt, $statusNeu));
                    echo $dbView->render();
                    break;
            }
        }
        //$auftraege = $this->auftraegeRepository->findByUid($this->request->getArgument('uid'));
        //$dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Auftraege/EditStatus40To50.html', $this->request->getControllerExtensionName());
        //$dbView->assign('status', array($this->request->getArgument('statusAlt'),$this->request->getArgument('statusNeu')));
        //$dbView->assign('fegroups', $fegroups);
        //echo "bla";
        /*
                $fegroups = $this->fegroupsRepository->findAll();
                $dbView->assign('defaultStundensatz', floatval(\DslFactory\DslIntranet\Utility\SettingsUtility::init()->getSettingFor('defaultStundensatz')));
                $dbView->assign('fegroups', $fegroups);
                $mitarbeiters = $this->mitarbeiterRepository->findAll();
                $dbView->assign('mitarbeiters', $mitarbeiters);
                $kundens = $this->kundenRepository->getActive();
                $dbView->assign('kundens', $kundens);
                $lieferantens = $this->lieferantenRepository->findAll();
                $dbView->assign('lieferantens', $lieferantens);
                $auftragsartens = $this->auftragsartenRepository->findAll();
                $fegroups = $this->fegroupsRepository->findAll();
                $dbView->assign('fegroups', $fegroups);
                $dbView->assign('auftragsartens', $auftragsartens);
                $phasens = $this->phasenRepository->findAll();
                $dbView->assign('phasens', $phasens);
                //$phasens = $this->phasenRepository->findAll();
                //$dbView->assign('prioritaets', $prioritaets);
                $dbView->assign('prioritaets', $this->getPrioritaets());
                //	$dbView->assign('statuss', $this->getStatuss());
                $dbView->assign('pers', $this->getPers());
        */

        //$dbView->assign('auftraege', $auftraege);
        //$dbView->assignMultiple(array('auftraege' => $auftraege));
        //  echo $dbView->render();
        die;
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function updateAction(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->auftraegeRepository->update($auftraege);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
     */
    public function deleteAction(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege)
    {
        if ($auftraege->getAnsprechpartner() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $auftraege->getAnsprechpartner()->_loadRealInstance();
        }
        if ($auftraege->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $auftraege->getMitarbeiter()->_loadRealInstance();
        }
        if ($aufgaben = $this->aufgabenRepository->findByAuftrag($auftraege)) {
            foreach ($aufgaben as $aufgabe) {
                //if(!$aufgabe->getNotiz()){
                $aufgabe->setNotiz($aufgabe->getNotizFuerKalender());
                $this->aufgabenRepository->update($aufgabe);
                $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
            }
        }
        $notificationAnsprechpartner = new \DslFactory\DslIntranet\Domain\Model\Notification();
        $notificationAnsprechpartner->setAuftrag($auftraege);
        $notificationAnsprechpartner->setArt(60, $auftraege->getStatusText());
        $notificationAnsprechpartner->setMitarbeiter($auftraege->getAnsprechpartner());
        if ($notificationAnsprechpartner->forOtherUser()) {
            $this->notificationRepository->add($notificationAnsprechpartner);
        }
        foreach ($auftraege->getMitarbeiter() as $mitarbeiter) {
            if ($auftraege->getAnsprechpartner() != $mitarbeiter) {
                $notificationMitarbeiter = clone $notificationAnsprechpartner;
                $notificationMitarbeiter->resetUid();
                //$notificationMitarbeiter->setMitarbeiter($mitarbeiter);
                if ($notificationMitarbeiter->forOtherUser()) {
                    $this->notificationRepository->add($notificationMitarbeiter);
                }
            }
        }
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        /*Notification Versenden Ende*/
        $this->auftraegeRepository->remove($auftraege);
        //$this->redirect('list');
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        die;
    }

   

    /**
     * initProtokollPending
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Protokolle $protokolle
     * @return \DslFactory\DslIntranet\Domain\Model\ProtokollePending $protokollePending
     */
    private function initProtokollPending($protokolle)
    {
        $newProtokollePending = new \DslFactory\DslIntranet\Domain\Model\ProtokollePending();
        $mitarbeiter = \DslFactory\DslIntranet\Utility\UsersUtility::init()->getFeUser();
        //echo "bla";
        //echo $protokolle->getUid();
        if ($protokolle->getPending()) {
            foreach ($protokolle->getPending() as $protokollePending) {
                if ($protokollePending->getMitarbeiter() instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
                    $protokollePending->getMitarbeiter()->_loadRealInstance();
                }
                if ($protokollePending->getPending() && $protokollePending->getMitarbeiter() == $mitarbeiter) {
                    $protokollePending->setTimestamp(new \DateTime());
                    $this->protokollePendingRepository->update($protokollePending);
                    unset($newProtokollePending);
                    break;
                }
            }
        }
        if ($newProtokollePending) {
            $newProtokollePending->setMitarbeiter($mitarbeiter);
            $newProtokollePending->setPending(true);
            $newProtokollePending->setTimestamp(new \DateTime());
            $this->protokollePendingRepository->add($newProtokollePending);
            $protokolle->addPending($newProtokollePending);
            if ($protokolle->getUid()) {
                $this->protokolleRepository->update($protokolle);
            }
            $protokollePending = $newProtokollePending;
        }
        return $protokollePending;
    }
	
	 /**
     * action editStatusChange
     *
     * @param \DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("auftraege")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editStatusChangeAction(\DslFactory\DslIntranet\Domain\Model\Auftraege $auftraege)
    {
        if ($this->request->hasArgument('statusAlt') && $this->request->hasArgument('statusNeu') && $this->request->hasArgument('uniqueSelector')) {
            $statusAlt = $this->request->getArgument('statusAlt');
            $statusNeu = $this->request->getArgument('statusNeu');
            $uniqueSelector = $this->request->getArgument('uniqueSelector');
            //switch($statusAlt."_".$statusNeu){
            switch ('' . $statusNeu . '') {
                case '50':    //von in Bearbeitung in Produktion
                    //if(!$datumproduktion){}
                    $dbView = \DslFactory\DslIntranet\Utility\ViewUtility::init()->getView('Auftraege/EditStatusTo50.html', $this->request->getControllerExtensionName());
                    $dbView->assign('auftraege', $auftraege);
                    $dbView->assign('statusNeu', $statusNeu);
                    $dbView->assign('statusAlt', $statusAlt);
                    $dbView->assign('uniqueSelector', $uniqueSelector);
                    $dbView->assign('status', array($statusAlt, $statusNeu));
                    echo $dbView->render();
                    break;
            }
        }
      
        die;
		return $this->htmlResponse();
    }

}
