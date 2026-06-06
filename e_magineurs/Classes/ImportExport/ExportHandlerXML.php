<?php

namespace Emagineurs\EMagineurs\ImportExport;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2018 Marvin MARCHAND <mmarchand@e-magineurs.com>, E-magineurs
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
class ExportHandlerXml extends \Emagineurs\EImportExport\Handlers\Export\XmlHandlers {

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
     * @param \resource $outputHandle
     * @access protected
     * @return void
     */
    protected function write() {
        $tags = explode(".", ($this->conf->getTag()) ? $this->conf->getTag() : "FLUX");
        if ($this->conf->getTag() == "null" && count($this->datas) < 2) {
            $tags = array(key(reset($this->datas)));
            $array_shift = array_shift($this->datas[0]);
            $this->datas = (is_array($array_shift)) ? $array_shift : array();
        }
        $xmlRoot = $this->buildRoot($tags);

        $childNames = $tags[1];
        if (!$childNames) {
            $childNames = "item";
        }
        $xmlRoot->addChild('eolas'," ");
        $channel = $xmlRoot->addChild('channel');
        $channel = $this->getHeader($channel);

        foreach ($this->datas as $elem) {
            $child = ($childNames) ? $channel->addChild($childNames) : $channel;
        $istopnew = 0;
            foreach ($elem as $key => $value) {
        if($key == "istopnews" && $value == 1){
            $istopnew = 1;
        }

        if($key == "category" && $istopnew == 1){
            if(empty($value)){
                $value= array();
            }
            array_push($value,array("categoryelement"=>"A la une"));
            $this->buildHierarchy($child, $key, $value);
        }else{
            $this->buildHierarchy($child, $key, $value);
        }
            }
        }
        $returns['content'] = $xmlRoot->asXML();

        echo $xmlRoot->asXML();
        die();
        return $returns;
    }

    /**
     * 
     * @access protected
     * @return void
     */
    protected function buildRoot(&$parent = null, &$tags = null) {
        if ($tags === null) {
            $tags = $parent;

            $xmlRoot = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><xml version="2.0"></xml>');

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

    protected function getHeader(&$channel) {
        $url = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_REQUEST_HOST');

        $channel->addChild('title', strtolower($this->conf->getTitle()));
        $image = $channel->addChild('image');
        $image->addChild('title');
        $image->addChild('url');
        $image->addchild('link', $url);
        $channel->addchild('link', $url);
        $channel->addchild('description', strtolower($this->conf->getTitle()));
        return $channel;
    }

}
