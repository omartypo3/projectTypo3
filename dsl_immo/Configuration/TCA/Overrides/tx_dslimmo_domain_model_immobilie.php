<?php
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['pid'] = array(
    'config' => array(
        'type' => 'passthrough',
    )
);

$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['ctrl']['label'] = 'openimmoobid';
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['ctrl']['label_alt'] = 'objekttitel';
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['ctrl']['label_alt_force'] = 1;
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['crdate'] = array(
    			'exclude' => 1,
    			'config' => array(
    				'type' => 'input',
    				'size' => 13,
    				'max' => 20,
    				'eval' => 'datetime',
    				'checkbox' => 0,
    				'default' => 0,
    				'range' => array(
    					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
    				),
    			),
    		);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['tstamp'] = array(
    			'exclude' => 1,
    			'config' => array(
    				'type' => 'input',
    				'size' => 13,
    				'max' => 20,
    				'eval' => 'datetime',
    				'checkbox' => 0,
    				'default' => 0,
    				'range' => array(
    					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
    				),
    			),
    		);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['nutzungs_art']['config']['items'] = array(
					array('WOHNEN', 10),
					array('GEWERBE', 20),
					array('ANLAGE', 30),
					array('WAZ', 40),
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['vermarktungs_art']['config']['items'] = array(
					array('KAUF', 10),
					array('MIETE_PACHT', 20),
					array('ERBPACHT', 30),
					array('LEASING', 40),
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['geo_lage_im_bau']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('LINKS', 10),
					array('RECHTS', 20),
					array('VORNE', 30),
					array('HINTEN', 40),
					
	),
	'size' => 4,'maxitems' => 4,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_wohnung_typ']['config']['items'] = array(
					array('KEINE_ANGABE', 10),
					array('DACHGESCHOSS', 20),
					array('MAISONETTE', 30),
					array('LOFT-STUDIO-ATELIER', 40),
					array('PENTHOUSE', 50),
					array('TERRASSEN', 60),
					array('ETAGE', 70),
					array('ERDGESCHOSS', 80),
					array('SOUTERRAIN', 90),
					array('APARTMENT', 100),
					array('FERIENWOHNUNG', 110),
					array('GALERIE', 120),
					array('ROHDACHBODEN', 130),
					array('ATTIKAWOHNUNG', 140),
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['zustand_art']['config']['items'] = array(
					array('ERSTBEZUG', 10),
					array('TEIL_VOLLRENOVIERUNGSBED', 20),
					array('NEUWERTIG', 30),
					array('TEIL_VOLLSANIERT', 40),
					array('TEIL_VOLLRENOVIERT', 50),
					array('TEIL_SANIERT', 60),
					array('VOLL_SANIERT', 70),
					array('SANIERUNGSBEDUERFTIG', 80),
					array('BAUFAELLIG', 90),
					array('NACH_VEREINBARUNG', 100),
					array('MODERNISIERT', 110),
					array('GEPFLEGT', 120),
					array('ROHBAU', 130),
					array('ENTKERNT', 140),
					array('ABRISSOBJEKT', 150),
					array('PROJEKTIERT', 160),
);
#https://docs.typo3.org/typo3cms/TCAReference/7.6/Reference/Columns/Select/Index.html#items
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_bad']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('DUSCHE', 10),
					array('WANNE', 20),
					array('FENSTER', 30),
					array('BIDET', 40),
					array('PISSOIR', 50),
	),
	'size' => 5,'maxitems' => 5,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_kueche']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('EBK', 10),
					array('OFFEN', 20),
					array('PANTRY', 30),
	),
	'size' => 3,'maxitems' => 3,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_boden']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('FLIESEN', 10),
					array('STEIN', 20),
					array('TEPPICH', 30),
					array('PARKETT', 40),
					array('FERTIGPARKETT', 50),
					array('LAMINAT', 60),
					array('DIELEN', 70),
					array('KUNSTSTOFF', 80),
					array('ESTRICH', 90),
					array('DOPPELBODEN', 100),
					array('LINOLEUM', 110),
					array('MARMOR', 120),
					array('TERRAKOTTA', 130),
					array('GRANIT', 140),	
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_heizungsart']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('OFEN', 10),
					array('ETAGE', 20),
					array('ZENTRAL', 30),
					array('FERN', 40),
					array('FUSSBODEN', 50),
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_befeuerung']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('OEL', 10),
					array('GAS', 20),
					array('ELEKTRO', 30),
					array('ALTERNATIV', 40),
					array('SOLAR', 50),
					array('ERDWAERME', 60),
					array('LUFTWP', 70),
					array('FERN', 80),
					array('BLOCK', 90),	
					array('WASSER-ELEKTRO', 100),
					array('PELLET', 110),
					array('KOHLE', 120),	
					array('HOLZ', 130),	
					array('FLUESSIGGAS', 140),
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_fahrstuhl']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('PERSONEN', 10),
					array('LASTEN', 20),
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_stellplatzart']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('GARAGE', 10),
					array('TIEFGARAGE', 20),
					array('CARPORT', 30),
					array('FREIPLATZ', 40),
					array('PARKHAUS', 50),
					array('DUPLEX', 60),
					
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_ausricht_balkon_terasse']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('NORD', 10),
					array('OST', 20),
					array('SUED', 30),
					array('WEST', 40),
					array('NORDOST', 50),
					array('NORDWEST', 60),
					array('SUEDOST', 70),
					array('SUEDWEST', 80),
					
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_angeschl_gastronomie']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('HOTELRESTAURANT', 10),
					array('BAR', 20),
					
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_serviceleistungen']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('BETREUTES_WOHNEN', 10),
					array('CATERING', 20),
					array('REINIGUNG', 30),
					array('EINKAUF', 40),
					array('WACHDIENST', 50),
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_sicherheitstechnik']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('ALARMANLAGE', 10),
					array('KAMERA', 20),
					array('POLIZEIRUF', 30),
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_dachform']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('KRUEPPELWALMDACH', 10),
					array('MANSARDDACH', 20),
					array('PULTDACH', 30),
					array('SATTELDACH', 40),
					array('WALMDACH', 50),
					array('FLACHDACH', 60),
					array('PYRAMIDENDACH', 70),
					
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_bauweise']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('MASSIV', 10),
					array('FERTIGTEILE', 20),
					array('HOLZ', 30),
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_ausbaustufe']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('BAUSATZHAUS', 10),
					array('AUSBAUHAUS', 20),
					array('SCHLUESSELFERTIGMITKELLER', 30),
					array('SCHLUESSELFERTIGOHNEBODENPLATTE', 40),
					array('SCHLUESSELFERTIGMITBODENPLATTE', 50),
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_energietyp']['config'] = array(
	'type' => 'select','renderType' => 'selectCheckBox',
	'items' => array(
					array('PASSIVHAUS', 10),
					array('NIEDRIGENERGIE', 20),
					array('NEUBAUSTANDARD', 30),
					array('KFW40', 40),
					array('KFW60', 50),
					array('KFW55', 60),
					array('KFW70', 70),
					array('MINERGIEBAUWEISE', 80),
					array('MINERGIE_ZERTIFIZIERT', 90),
	),
	'size' => 15,'maxitems' => 15,'eval' => ''
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_kategorie']['config']['items'] = array(
	array('-KEINEANGABE-', 0),
					array('STANDARD', 10),
					array('GEHOBEN', 20),
					array('LUXUS', 30),
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_moebliert']['config']['items'] = array(
	array('-KEINEANGABE-', 0),
					array('VOLL', 10),
					array('TEIL', 20),
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['ausstattung_unterkellert']['config']['items'] = array(
	array('-KEINEANGABE-', 0),
					array('JA', 10),
					array('NEIN', 20),
					array('TEIL', 30),
);


$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_zimmer_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('ZIMMER', 20),
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_haus_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('REIHENHAUS', 20),
					array('REIHENEND', 30),
					array('REIHENMITTEL', 40),
					array('REIHENECK', 50),
					array('DOPPELHAUSHAELFTE', 60),
					array('EINFAMILIENHAUS', 70),
					array('STADTHAUS', 80),
					array('BUNGALOW', 90),
					array('VILLA', 100),
					array('RESTHOF', 110),
					array('BAUERNHAUS', 120),
					array('LANDHAUS', 130),
					array('SCHLOSS', 140),
					array('ZWEIFAMILIENHAUS', 150),
					array('MEHRFAMILIENHAUS', 160),
					array('FERIENHAUS', 170),
					array('BERGHUETTE', 180),
					array('CHALET', 190),
					array('STRANDHAUS', 200),
					array('LAUBE-DATSCHE-GARTENHAUS', 210),
					array('APARTMENTHAUS', 220),
					array('BURG', 230),
					array('HERRENHAUS', 240),
					array('FINCA', 250),
					array('RUSTICO', 260),
					array('FERTIGHAUS', 270),
					
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_grundstueck_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('WOHNEN', 20),
					array('INDUSTRIE', 30),
					array('LAND_FORSTWIRSCHAFT', 40),
					array('FREIZEIT', 50),
					array('GEMISCHT', 60),
					array('GEWERBEPARK', 70),
					array('SONDERNUTZUNG', 80),
					array('SEELIEGENSCHAFT', 90),
					
					
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_buero_praxen_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('BUEROFLAECHE', 20),
					array('BUEROHAUS', 30),
					array('BUEROZENTRUM', 40),
					array('LOFT_ATELIER', 50),
					array('PRAXIS', 60),
					array('PRAXISFLAECHE', 70),
					array('PRAXISHAUS', 80),
					array('AUSSTELLUNGSFLAECHE', 90),
					array('COWORKING', 100),
					array('SHARED_OFFICE', 110),
					
					
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_einzelhandel_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('LADENLOKAL', 20),
					array('EINZELHANDELSLADEN', 30),
					array('VERBRAUCHERMARKT', 40),
					array('EINKAUFSZENTRUM', 50),
					array('KAUFHAUS', 60),
					array('FACTORY_OUTLET', 70),
					array('KIOSK', 80),
					array('VERKAUFSFLAECHE', 90),
					array('AUSSTELLUNGSFLAECHE', 100),
);
/**/
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_gastgewerbe_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('GASTRONOMIE', 20),
					array('GASTRONOMIE_UND_WOHNUNG', 30),
					array('PENSIONEN', 40),
					array('HOTELS', 50),
					array('WEITERE_BEHERBERGUNGSBETRIEBE', 60),
					array('BAR', 70),
					array('CAFE', 80),
					array('DISCOTHEK', 90),
					array('RESTAURANT', 100),
					array('RAUCHERLOKAL', 110),
					array('EINRAUMLOKAL', 120),
); 
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_hallen_lager_produktion_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('HALLE', 20),
					array('INDUSTRIEHALLE', 30),
					array('LAGER', 40),
					array('LAGERFLAECHEN', 50),
					array('LAGER_MIT_FREIFLAECHE', 60),
					array('HOCHREGALLAGER', 70),
					array('SPEDITIONSLAGER', 80),
					array('PRODUKTION', 90),
					array('WERKSTATT', 100),
					array('SERVICE', 110),
					array('FREIFLAECHEN', 120),
					array('KUEHLHAUS', 130),
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_land_forstwirtschaft_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('LANDWIRTSCHAFTLICHE_BETRIEBE', 20),
					array('BAUERNHOF', 30),
					array('AUSSIEDLERHOF', 40),
					array('GARTENBAU', 50),
					array('ACKERBAU', 60),
					array('WEINBAU', 70),
					array('VIEHWIRTSCHAFT', 80),
					array('JAGD_UND_FORSTWIRTSCHAFT', 90),
					array('TEICH_UND_FISCHWIRTSCHAFT', 100),
					array('SCHEUNEN', 110),
					array('REITERHOEFE', 120),
					array('SONSTIGE_LANDWIRTSCHAFTSIMMOBILIEN', 130),
					array('ANWESEN', 140),
					array('JAGDREVIER', 150),
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_parken_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('STELLPLATZ', 20),
					array('CARPORT', 30),
					array('DOPPELGARAGE', 40),
					array('DUPLEX', 50),
					array('TIEFGARAGE', 60),
					array('WEINBAU', 70),
					array('BOOTSLIEGEPLATZ', 80),
					array('EINZELGARAGE', 90),
					array('PARKHAUS', 100),
					array('TIEFGARAGENSTELLPLATZ', 110),
					array('PARKPLATZ_STROM', 120),
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_sonstige_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('PARKHAUS', 20),
					array('TANKSTELLE', 30),
					array('KRANKENHAUS', 40),
					array('SONSTIGE', 50),
					
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_freizeitimmobilie_gewerblich_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('SPORTANLAGEN', 20),
					array('VERGNUEGUNGSPARKS_UND_CENTER', 30),
					array('FREIZEITANLAGE', 40),
					
);
$GLOBALS['TCA']['tx_dslimmo_domain_model_immobilie']['columns']['objekt_art_zinshaus_renditeobjekt_typ']['config']['items'] = array(
					//array('KEINE_ANGABE', 10),
					array('MEHRFAMILIENHAUS', 20),
					array('WOHN_UND_GESCHAEFTSHAUS', 30),
					array('GESCHAEFTSHAUS', 40),
					array('BUEROGEBAEUDE', 50),
					array('SB_MAERKTE', 60),
					array('EINKAUFSCENTREN', 70),
					array('WOHNANLAGEN', 80),
					array('VERBRAUCHERMAERKTE', 90),
					array('INDUSTRIEANLAGEN', 100),
					array('PFLEGEHEIM', 110),
					array('SANATORIUM', 120),
					array('SENIORENHEIM', 130),
					array('BETREUTES-WOHNEN', 140),
);
/*
,,,,,,,objekt_art_zinshaus_renditeobjekt_typ
*/
	
/*
ausstattung_bad
ausstattung_kueche
ausstattung_boden
*/