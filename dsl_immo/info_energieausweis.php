<?php 

?>
<!-- ###ENERGIEAUSWEIS_JA### -->
	<tr>	
		<td valign="top">Energieausweis:</td>
		<td>###ENERGIEAUSWEIS### (###ENERGIEAUSWEIS_DATUM###)<!-- ###ENERGIEAUSWEIS_WERT_JA### --> ###ENERGIEAUSWEIS_WERT### kWh/(m²*a)<!-- ###ENERGIEAUSWEIS_WERT_JA### --><!-- ###ENERGIEAUSWEIS_INKL_WARMWASSER### --> / inklusive Energieverbrauch für Warmwasser<!-- ###ENERGIEAUSWEIS_INKL_WARMWASSER### -->###ENERGIEAUSWEIS_EFFIZIENZKLASSE######ENERGIEAUSWEIS_ENERGIETRAEGER###</td>
	</tr><!-- ###ENERGIEAUSWEIS_JA### -->
<?php               
-----------------------------
//Energieausweis:
		if($objekt->energieausweis_typ){
			$this->markerArray["###ENERGIEAUSWEIS###"] = $objekt->energieausweis_name;
			$this->markerArray["###ENERGIEAUSWEIS_DATUM###"] = $objekt->energieausweis_datum_name;
			
			$this->markerArray["###ENERGIEAUSWEIS_WERT###"] = number_format($objekt->energieausweis_wert,2,',','.');
			if($objekt->energieausweis_wert) unset($this->subpartArray["###ENERGIEAUSWEIS_WERT_JA###"]); else $this->subpartArray["###ENERGIEAUSWEIS_WERT_JA###"]="";
			if($objekt->energieverbrauch_warmwasserenthalten) unset($this->subpartArray["###ENERGIEAUSWEIS_INKL_WARMWASSER###"]); else $this->subpartArray["###ENERGIEAUSWEIS_INKL_WARMWASSER###"]="";
			unset($this->subpartArray["###ENERGIEAUSWEIS_JA###"]);
			
			if($objekt->energieausweis_datum==1) $this->markerArray["###ENERGIEAUSWEIS_EFFIZIENZKLASSE###"] = " / Energieeffizienzklasse ".$objekt->energieausweis_effizienzklasse_name; else $this->markerArray["###ENERGIEAUSWEIS_EFFIZIENZKLASSE###"] = "";
			if($objekt->energieausweis_energietraeger_name) $this->markerArray["###ENERGIEAUSWEIS_ENERGIETRAEGER###"] = utf8_encode(" / <br />Energieträger: ").$objekt->energieausweis_energietraeger_name; else $this->markerArray["###ENERGIEAUSWEIS_ENERGIETRAEGER###"] = "";
			
		} else $this->subpartArray["###ENERGIEAUSWEIS_JA###"]="";

---------------------------	

$this->energieausweis_typ = $objekt["energieausweis_typ"];
		switch($this->energieausweis_typ){
			case 1:
				$this->energieausweis_name = "Bedarfsausweis";
				$this->energieausweis_wert = $this->energiebedarf_wert = $objekt["energiebedarf_wert"];
			break;
			case 2:
				$this->energieausweis_name = "Verbrauchsausweis";
				$this->energieausweis_wert = $this->energieverbrauch_wert = $objekt["energieverbrauch_wert"];
				$this->energieverbrauch_warmwasserenthalten = $objekt["energieverbrauch_warmwasserenthalten"];
			break;
		}
		if($this->energieausweis_wert=="0.00") $this->energieausweis_wert="";
		$this->energieausweis_baujahr = $objekt["energieausweis_baujahr"];
		
		
		
		$this->energieausweis_energietraeger =  $objekt["energieausweis_energietraeger"];
		$this->energieausweis_effizienzklasse =  $objekt["energieausweis_effizienzklasse"];


		$heatingTypeArr = array();
		if($this->energieausweis_energietraeger){
			$tmpArr = explode(",",$this->energieausweis_energietraeger);
			if(is_array($tmpArr)) foreach($tmpArr as $key) switch($key){
				case 0: $heatingTypeArr[] = "Holz-Hackschnitzel";break;
				case 1: $heatingTypeArr[] = "Öl";break;
				case 2: $heatingTypeArr[] = "Erdgas leicht";break;
				case 3: $heatingTypeArr[] = "Holzpellets";break;
				case 4: $heatingTypeArr[] = "Kohle";break;
				case 5: $heatingTypeArr[] = "Solar-Heizung";break;
				case 6: $heatingTypeArr[] = "Erdgas schwer";break;
				case 7: $heatingTypeArr[] = "Erdwärme";break;
				case 8: $heatingTypeArr[] = "Strom";break;
				case 9: $heatingTypeArr[] = "Wärmelieferung";break;
				case 10: $heatingTypeArr[] = "Kohle/Koks";break;
				case 11: $heatingTypeArr[] = "Flüssiggas";break;
				case 12: $heatingTypeArr[] = "Nahwärme";break;
				case 13: $heatingTypeArr[] = "Gas";break;
				case 14: $heatingTypeArr[] = "Fernwärme Dampf";break;
				case 15: $heatingTypeArr[] = "Holz";break;
				
			} 
		}
		if(count($heatingTypeArr)) $this->energieausweis_energietraeger_name = implode(", ",$heatingTypeArr);
		
		$this->energieausweis_datum =  $objekt["energieausweis_datum"];
		switch($this->energieausweis_datum){
			case 0:$this->energieausweis_datum_name = "EnEV 2009";break;	
			case 1:
				switch($this->energieausweis_effizienzklasse){
					case 0:$this->energieausweis_effizienzklasse_name = "A+";break;	
					case 1:$this->energieausweis_effizienzklasse_name = "A";break;	
					case 2:$this->energieausweis_effizienzklasse_name = "B";break;	
					case 3:$this->energieausweis_effizienzklasse_name = "C";break;	
					case 4:$this->energieausweis_effizienzklasse_name = "D";break;	
					case 5:$this->energieausweis_effizienzklasse_name = "E";break;	
					case 6:$this->energieausweis_effizienzklasse_name = "F";break;	
					case 7:$this->energieausweis_effizienzklasse_name = "G";break;	
					case 8:$this->energieausweis_effizienzklasse_name = "H";break;	
				}
				$this->energieausweis_datum_name = "EnEV 2014";
			break;	
		}
		


?>