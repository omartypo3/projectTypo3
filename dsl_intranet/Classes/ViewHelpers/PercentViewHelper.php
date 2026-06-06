<?php 

namespace DslFactory\DslIntranet\ViewHelpers;

class PercentViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper { 
	 /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('percent', 'int', 'The percentage value', true);
        $this->registerArgument('type', 'string', 'The type of highlight', true);
    }
	 /** 
		 * @return string
         */	
        public function render() { 
			
			$percent = $this->arguments['percent'];
        $type = $this->arguments['type'];
			switch($type){
				case 'hightlightClass':
					
					if($percent>100) return 'text-time-over';
						//elseif($percent>75) return 'text-warning';
							else return 'text-time-intime';
				

				break;
				case 'hightlightClassOverload':
					
					if($percent>100) return 'text-time-over';
						//elseif($percent>75) return 'text-warning';
							//else return 'text-primary';
				

				break;
			
			}
			return '';
        } 
} 

?>