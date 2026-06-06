<?php
namespace Emagineurs\EImportExport\Handlers\Import;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Ian SEBBAGH <isebbagh@e-magineurs.com>, E-magineurs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use Emagineurs\EImportExport\Domain\Model\Field;
use SimpleXMLElement;

/**
 * XmlValue
 *
 * Is used to store xml datas like arguments and content
 */
class XmlValue {
	/** $value
	 *
	 * @var string
	 */
	private $value;
	
	/** $value
	 *
	 * @var array of string
	 */
	private $attributes;
	
	/**
	 * Constructor
	 *
	 * @param string $value The content inside the tags
	 * @param array $attributes An array formated as 'attributeName' => 'value'
	 * @access public
	 * @return void
	 */
	public function __construct($value, $attributes) {
		$this->value = $value;
		$this->attributes = $attributes;
	}
	
	/**
	 * __toString implantation, return the content inside the tags
	 *
	 * @access public
	 * @return string
	 */
	public function __toString() {
		return $this->value;
	}
	
	/**
	 * Get an attribute value
	 *
	 * @param string $key The argument name
	 * @access public
	 * @return string
	 */
	public function getAttribute($key) {
		return $this->attributes[$key];
	}
}

/**
 * XmlHandlers
 */
class XmlHandlers extends AbstractHandlers {
    /**
     * Read the contents from the file, store it into $this->dataArray, an array with a specific format, the format is an array of object with $obj->key = $value
     *
     * @access public
     * @param $inputHandle resource the input resource
     */
	public function read($inputHandle){
		$data = stream_get_contents($inputHandle);
		$xml = simplexml_load_string($data);

		$this->dataArray = $xml;
	}
	
    /**
     * Modified to access properties by using tag@property
     *
	 * @param \stdclass $value The row
	 * @param Field $field The field model object
	 * @access protected
	 * @return mixed the value
	 */
	public function getValue($valueInit, $field){
		$type = $field->getType();
		if($type!=5){
			$value = $valueInit;
			$tag = explode('.', $field->getName());
			foreach($tag as $elem){
				if(strpos($elem, '@')!==false){
					list($element, $attribute) = explode('@', $elem);
					if(!empty($element) && !empty($attribute)){
						$value = $value->$element;
						$value = (string)$value->getAttribute($attribute);
					}
				}else{
					$value = $value->$elem;
				}
			}
		}
		return (string)$value;
	}
}