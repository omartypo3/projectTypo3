<?php 

namespace DslFactory\DslIntranet\ViewHelpers;

class CheckedViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper { 

	/**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('obj', 'mixed', 'Object or array', true);
        $this->registerArgument('prop', 'string', 'Property', true);
    }
	/**
     * Render method.
     *
     * @return string
     */
        public function render() { 
			
			$obj = $this->arguments['obj'];
        $prop = $this->arguments['prop'];
                if(is_object($obj)) { 
					foreach($obj as $val){
						//return "true";
						
					
						
					
						
						if(method_exists($prop,'getUid') && method_exists($val,'getUid') ){
							if($prop->getUid() == $val->getUid()) return "true";
						} else {
						/*
						echo "begin:";
						echo $prop;
						if(is_object($prop)) echo "(".$prop->getUid().")";
						echo ":";
						echo $val;
						if(is_object($val)) echo "(".$val->getUid().")";
						print_r($prop);
						print_r($val);
						if($prop == $val) echo "....";
						
						echo "<hr>\n";
						*/
							if($prop == $val) return "true";
						}
					}
                } elseif(is_array($obj)) { 
                        if(array_key_exists($prop, $obj)) { 
                        	return "true"; 
                        } 
                } 
                return ""; 
        } 
} 

?>