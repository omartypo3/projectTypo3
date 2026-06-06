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

/**
 *
 *
 * @package e_gmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EExtendedTable
{

    // présence des lignes SQL pour l'ajout des champ, dans le fichier .sql
    public $isSqlfile = false;
    // présence des champs, dans la BDD
    public $isSqlbdd = false;
    //présence des champs, dans le TCA
    public $isTca = false;
    //présence de la configuration, en TS-Config
    public $isTSConfig = false;
    //présence du typoscript relatif a extbase, pour l'extension du model.
    public $isTSExtbase = false;
    //présence du fichier php du model
    public $isModel = false;
    //présence du fichier php du repository
    public $isRepo = false;
    //présence du fichier xml pour la liste des points
    public $isXml = false;
    //présence du fichier html pour le template de l'infobulle
    public $isHtml = false;
    //Est ce que tout est bon
    public $isOk = false;

    //nom de la table en BDD
    public $table = '';
    //nom de la clée utilisée, qui sera le nom du model
    public $key = '';
    //nom du model etendu
    public $extmodel = '';
    //champ categorie
    public $extcat = '';

    //objet parent, EExtendedTables, contenant ce qui sera necessaire a la verification
    protected $pObj = '';

    public function setConf($table, $key, $pObj)
    {
        $this->table = $table;
        $this->key = $key;
        $this->pObj = $pObj;
    }

    public function check()
    {
        $this->isSqlfile = $this->isInSqlFile();
        $this->isSqlbdd = $this->isInSqlBdd();
        $this->isTca = $this->isInTca();
        $this->isTSConfig = $this->isInTSConfig();
        $this->isTSExtbase = $this->isInTSExtbase();
        $this->isModel = $this->isModel();
        $this->isRepo = $this->isRepo();
        $this->isXml = $this->isXml();
        $this->isHtml = $this->isHtml();
        $this->isOk = $this->isOk();

        $this->extmodel = $this->getExtModel();
        $this->extcat = $this->getExtCat();
    }


    /* methods */
    protected function isInSqlFile()
    {
        return $this->pObj->isInSqlFile($this->table);
    }

    protected function isInSqlBdd()
    {
        return $this->pObj->isInSqlBdd($this->table);
    }

    protected function isInTca()
    {
        return $this->pObj->isInTca($this->table);
    }

    protected function isInTSConfig()
    {
        return $this->pObj->isInTSConfig($this->table, $this->key);
    }

    protected function isInTSExtbase()
    {
        return $this->pObj->isInTSExtbase($this->table, $this->key);
    }

    protected function isModel()
    {
        return $this->pObj->isModel($this->key);
    }

    protected function isRepo()
    {
        return $this->pObj->isRepo($this->key);
    }

    protected function isXml()
    {
        return $this->pObj->isXml($this->key);
    }

    protected function isHtml()
    {
        return $this->pObj->isHtml($this->key);
    }

    protected function isOk()
    {
        return $this->isSqlfile
            && $this->isSqlbdd
            && $this->isTca
            && $this->isTSConfig
            && $this->isTSExtbase
            && $this->isModel
            && $this->isRepo
            && $this->isXml
            && $this->isHtml;
    }

    public function getExtModel()
    {
        return $this->pObj->getExtModel($this->key);
    }

    public function getExtCat()
    {
        return $this->pObj->getExtCat($this->key);
    }
}