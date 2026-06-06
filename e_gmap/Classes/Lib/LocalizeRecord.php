<?php

namespace Emagineurs\EGmap\Lib;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Ian SEBBAGH <isebbagh@e-magineurs.com>, E-magineurs
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 *
 *
 * @package e_gmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class LocalizeRecord
{
    protected $row = array();
    protected $conf = array();
    protected $lat = null;
    protected $lng = null;
    protected $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=';


    public function setConf($row, $conf)
    {
        $this->row = $row;
        $this->conf = $conf;
    }

    public function setCoord()
    {
        if ($this->getCoord()) {
            $this->updateRecord();
            return true;
        }
        return false;
    }

    public function getCoord()
    {
        $reponse = \Emagineurs\EGmap\Lib\ELib::readAFile($this->url . urlencode($this->row['coord']));
        $this->errorMessage = 'No response';
        if (!empty($reponse)) {
            $json = json_decode($reponse);
            if ($json->status != 'OK') {
                $this->errorMessage = $json->status;
                if (!empty($json->error_message)) {
                    $this->errorMessage .= ' - ' . $json->error_message;
                }
                return false;
            }
            $this->errorMessage = 'No results';
            if (!empty($json->results[0]->geometry->location)) {
                $this->lat = $json->results[0]->geometry->location->lat;
                $this->lng = $json->results[0]->geometry->location->lng;
                return true;
            }
        }
        return false;
    }

    public function updateRecord()
    {
        $table = $this->row['table'];
        $uid = $this->row['uid'];

        $conf = $this->conf[$table . '.'];
        $fieldLat = $conf['lat'];
        $fieldLng = $conf['lng'];

        $fields = array(
            $fieldLat => $this->lat,
            $fieldLng => $this->lng
        );

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $connection = $connectionPool->getConnectionForTable($table);
        $connection->update($table, $fields, ['uid' => (int)$uid]);
    }

    public function debugCoord()
    {
        $debug = array();
        if (!empty($this->lat)) {
            $debug[] = 'Lat: ' . $this->lat;
        }
        if (!empty($this->lng)) {
            $debug[] = 'Lng: ' . $this->lng;
        }
        if (count($debug) == 0) {
            $debug = 'Coordonnée non récupérées : ' . $this->errorMessage;
        } else {
            $debug = implode(',', $debug);
        }
        $debug = '[' . $this->row['uid'] . '] "' . $this->row['coord'] . '" ' . $debug;
        return $debug;
    }
}