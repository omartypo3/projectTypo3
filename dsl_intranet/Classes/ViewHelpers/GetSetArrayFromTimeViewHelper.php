<?php 

namespace DslFactory\DslIntranet\ViewHelpers;

class GetSetArrayFromTimeViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper { 
      
	/**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('time', 'int', 'The time in minutes', true);
    }
	  /** 
		 * @return array		 
         */	
        public function render() { 
		
				$time = $this->arguments['time'];
				$stunden = floor($time / 60);
				$minuten = $time - $stunden * 60;
				
				return array('stunden' => $stunden, 'minuten' => $minuten);
		
			
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