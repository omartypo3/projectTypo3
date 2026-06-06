<?php 

namespace DslFactory\DslIntranet\ViewHelpers;

class GetMinutesByFixedPriceAndHourlyFeeViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper { 
       
	 /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('fixedPrice', 'float', 'The fixed price', true);
        $this->registerArgument('hourlyFee', 'float', 'The hourly fee', true);
    }
	/**
     * @return int
     */
    public function render() { 
		
				//$stunden = floor($time / 60);
				//$minuten = $time - $stunden * 60;
				
				 $fixedPrice = $this->arguments['fixedPrice'];
        $hourlyFee = $this->arguments['hourlyFee'];
				
				return round($fixedPrice/$hourlyFee*60);//ceil durch round ersetzt
		
			
/*				$result = false;
		
                if(is_object($obj)) { 
                        $result = $obj->$prop; 
                } elseif(is_array($obj)) { 
                        if(array_key_exists($prop, $obj)) { 
                                $result = $obj[$prop]; 
                        } 
                } 
				if($result){
					if($forKey) if(isset($result[$forKey])) return $result[$forKey];
					if($withKey) return array( $withKey => $result );
					return $result;
				}
				
                return NULL; */
        } 
} 

?>