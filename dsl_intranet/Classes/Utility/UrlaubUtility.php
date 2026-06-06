<?php

namespace DslFactory\DslIntranet\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;



/**
 * Utility class for Urlaub
 *
 * @package TYPO3
 * @subpackage tx_dslintranet
 */
class UrlaubUtility 
{
	
	protected $objectManager;
	protected $urlaubRepository;
	
	public static $instance;
    public function __construct() {
        self::$instance = $this;
    }


	public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
	
	public function initVars(){//\TYPO3\CMS\Core\Utility\
		if(!$this->objectManager) $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		if(!$this->urlaubRepository) $this->urlaubRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\UrlaubRepository');
		
		/*if(!$this->wartungsvertraegeRepository) $this->wartungsvertraegeRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRepository');
		if(!$this->wartungsvertraegeZeitraeumeRepository) $this->wartungsvertraegeZeitraeumeRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeZeitraeumeRepository');
		if(!$this->wartungsvertraegeRechnungenRepository) $this->wartungsvertraegeRechnungenRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\WartungsvertraegeRechnungenRepository');
		if(!$this->protokolleRepository) $this->protokolleRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\ProtokolleRepository');
		if(!$this->dateienRepository) $this->dateienRepository = $this->objectManager->get('DslFactory\\DslIntranet\\Domain\\Repository\\DateienRepository');*/
	}
	
	public function getUrlaubTermineArr($filter)
    { //http://lokal.intranet.dsl-factory.de/index.php?id=12&no_cache=1&tx_dslintranet_wochenlisteaufgabenplatzierung[action]=listjson&tx_dslintranet_wochenlisteaufgabenplatzierung[controller]=Aufgaben&tx_dslintranet_wochenlisteaufgabenplatzierung[aufgabenmitarbeiters]=1&tx_dslintranet_wochenlisteaufgabenplatzierung[start]=2017-11-20T00%3A00%3A00%2B01%3A00&tx_dslintranet_wochenlisteaufgabenplatzierung[end]=2017-11-26T00%3A00%3A00%2B01%3A00&_=1510667586315
		$this->initVars();
		
		$urlaubArr = array();
		//var_dump($filter);die;
		$urlaubs = $this->urlaubRepository->findByFilter($filter);
		foreach($urlaubs as $urlaub){
			date_add($urlaub->getEnd(), date_interval_create_from_date_string('1 day'));
			$urlaubArr[]=array(
				
					"id" => "U".$urlaub->getUid(),
					"title" => "Urlaub ".$urlaub->getTitel(),
					"start" => $urlaub->getBegin()->format("Y-m-d")."T00:00:00",
					"end" => $urlaub->getEnd()->format("Y-m-d")."T00:00:00",
					"allDay" => true,
					"mitarbeiterUid" => $urlaub->getMitarbeiter()->getUid(),
					"type"=>"urlaub",
					"editable"=>false
				
			);
		}
		/*
		$aufgabenArr[] = array(
			'id'=>"U"."9999",
			"title"=>"urlaub",
			"start"=>"2017-11-15T00:00:00",
			"end"=>"2017-11-17T00:00:00",
			"allDay"=>true,
			"mitarbeiterUid"=>1
		);
		*/
		return $urlaubArr;
		return array(1,23,44);
	}
	


}