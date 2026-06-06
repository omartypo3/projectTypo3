<?php 

namespace DslFactory\DslIntranet\ViewHelpers;
class GetFromArrayViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper { 
   /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('obj', 'mixed', 'Object or array', true);
        $this->registerArgument('prop', 'string', 'Property', true);
        $this->registerArgument('withKey', 'string', 'Property', false, null);
        $this->registerArgument('forKey', 'string', 'Property', false, null);
    }
	
	/**
     * Render method.
     *
     * @return mixed|null
     */
    public function render()
    {
        $obj = $this->arguments['obj'];
        $prop = $this->arguments['prop'];
        $withKey = $this->arguments['withKey'];
        $forKey = $this->arguments['forKey'];
		
		
        $result = null;

        if (is_object($obj) && property_exists($obj, $prop)) {
            $result = $obj->$prop;
        } elseif (is_array($obj) && array_key_exists($prop, $obj)) {
            $result = $obj[$prop];
        }

        if ($result !== null) {
            if ($forKey !== null) {
                return $result[$forKey] ?? null;
            }
            if ($withKey !== null) {
                return [$withKey => $result];
            }

            return $result;
        }

        return null;
    }
} 

?>


