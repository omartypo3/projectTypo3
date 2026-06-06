<?php

namespace Emagineurs\EImportExport\Handlers\Export;

/* * *************************************************************
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
 * ************************************************************* */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository for Confs
 */
class XmlHandlers extends AbstractHandlers {

    /**
     * Write header for file type
     * 
     * @access protected
     * @return void
     */
    public function header() {
        header('Content-Type:application/xml;charset=utf-8');
    }

    /**
     * Build the file content
     * 
     * @param resource|null $outputHandle
     * @access protected
     * @return void
     */
    protected function write($outputHandle = null) {

        $tags = explode(".", ($this->conf->getTag()) ? $this->conf->getTag() : "FLUX");
        if ($this->conf->getTag() == "null" && count($this->datas) < 2) {
            $tags = array(key(reset($this->datas)));
            $array_shift = array_shift($this->datas[0]);
            $this->datas = (is_array($array_shift)) ? $array_shift : array();
        }
        $xmlRoot = $this->buildRoot($tags);
        $childNames = $tags[1];
        foreach ($this->datas as $elem) {
            $child = ($childNames) ? $xmlRoot->addChild($childNames) : $xmlRoot;
            foreach ($elem as $key => $value) {

                $this->buildHierarchy($child, $key, $value);
            }
        }
        $returns['content'] = $xmlRoot->asXML();
        echo $xmlRoot->asXML();
        die();
        return $returns;
    }

    /**
     * Return an xml string that represent the $source datas
     * 
     * @param array $source
     * @access protected
     * @return string
     */
    private function xmlEncode($source) {
        $array_xml = GeneralUtility::array2xml($source, '', 0, ($this->firstTag != '') ? $this->firstTag : 'FLUX', 0, array('useNindex' => 1, 'disableTypeAttrib' => 2));

        $pattern = "#<n[0-9]+>|</n[0-9]+>#";
        $replacement = "";
        $encode = preg_replace($pattern, $replacement, $array_xml);
        return $encode;
    }

    /**
     * Turn the field named like elem1.elem2@attr to elem1
     *
     * @param array $source
     * @access protected
     * @return void
     */
    protected function buildHierarchy(\SimpleXMLElement &$parent, $name, $value) {
        $tags = explode(".", $name, 2);
        $attr = explode("@", $tags[0], 2);
        $tag = $attr[0];

        if (count($attr) == 1) {
            if (is_array($value)) {
                $elem = $parent->addChild($tag);
                foreach ($value as $arrayElem) {
                    //// Si on doit faire une relation pour récupérer des éléments mais qu'il faut que cela apparaisse en ligne, on
                    /// met le nom du champ vide dans la conf.

                    if (empty(array_filter(array_keys($arrayElem)))) {
                        $parent->$tag = reset($arrayElem);
                    } else {
                        foreach ($arrayElem as $key => $child) {
                            $this->buildHierarchy($elem, $key, $child);
                        }
                    }
                }
            } else {
                if (empty($tag)) {

                    $elem = $parent->addChild($parent->getName(), $value);
                } else {
                    $elem = $parent->addChild($tag, $value);
                }
            }
        } else {
            //attribut
            if ($tag == '') {
                $parent->addAttribute($attr[1], $value);
            } else {
                foreach ($parent->children() as $child) {
                    if ($child->getName() == $tag) {
                        $child->addAttribute($attr[1], $value);
                    }
                }
            }
        }
    }

    /**
     * 
     *
     * @access protected
     * @return void
     */
    protected function buildRoot(&$parent = null, &$tags = null) {
        if ($tags === null) {
            $tags = $parent;
            $xmlRoot = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><' . $tags[0] . '/>');
            $this->buildRoot($xmlRoot, $tags);
            return $xmlRoot;
        } else {
            array_shift($tags);
            if (isset($tags[0]) AND isset($tags[1])) {
                $child = $parent->addChild($tags[0]);
                $this->buildRoot($child, $tags);
            }
            return $parent;
        }
    }

}
