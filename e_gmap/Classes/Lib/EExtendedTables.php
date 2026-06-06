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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Schema\SchemaMigrator;
use TYPO3\CMS\Core\Database\Schema\SqlReader;
use Emagineurs\EGmap\Lib\EExtendedTable;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\ArrayUtility;

class EExtendedTables
{
    //Configuration Files
    protected $typoscriptFile = 'Configuration/TypoScriptForce/TSExtbasePersistent.txt';
    protected $tsconfigFile = 'Configuration/TSConfig/pageTSConfig.txt';
    protected $sqlFile = 'ext_tables.sql';
    protected $listFile = 'Configuration/ListExt/extlist';

    //Template Files

    protected $templateModel = 'Resources/Private/Templates/Geoloc/Model.html';
    protected $templateRepo = 'Resources/Private/Templates/Geoloc/Repo.html';
    protected $templateXml = 'Resources/Private/Templates/Geoloc/Xml.html';
    protected $templateHtml = 'Resources/Private/Templates/Geoloc/Html.html';

    //SQL fields to check 
    protected $sqlFields = array('picto', 'poi', 'lat', 'lng');

    protected array $collection = [];
    protected string $extPath = '';
    protected ?array $tsconfig = null;
    protected ?array $typoscript = null;
    protected ?object $pObj = null;
    protected array $res = [];


    //contenu du fichier SQL
    protected $sqlFileContent = '';
    //contenu du fichier TSConfig
    protected $tsconfigFileContent = '';
    //contenu du fichier typoscript
    protected $typoscriptFileContent = '';

 
    public function __construct(protected readonly ConnectionPool $connectionPool ,protected readonly EExtendedTable $extTable ,protected  readonly SchemaMigrator $schemaMigrator,protected readonly SqlReader $sqlReader , protected readonly CacheManager $cacheManager) {
    }

    public function setConf($extPath, $tsconfig, $typoscript, $pObj = null)
    {
        $this->extPath = $extPath;
        $this->tsconfig = $tsconfig;
        $this->typoscript = $typoscript;
        $this->pObj = $pObj;
        // $this->listFile = PATH_site.$this->listFile;
        //Initialize file paths 
        $this->listFile = $this->extPath . $this->listFile;
        $this->sqlFile = $this->extPath . $this->sqlFile;
        $this->tsconfigFile = $this->extPath . $this->tsconfigFile;
        $this->typoscriptFile = $this->extPath . $this->typoscriptFile;
        $this->templateModel = $this->extPath . $this->templateModel;
        $this->templateRepo = $this->extPath . $this->templateRepo;
        $this->templateXml = $this->extPath . $this->templateXml;
        $this->templateHtml = $this->extPath . $this->templateHtml;
    }

    /**
     * Summary of check
     * @return void
     */
    public function check()
    {
        $liste = $this->getList();

        if(!is_array($liste)){
            return;
        }
            foreach ($liste as $table => $key) {
                $extTableInstance = clone $this->extTable;
                // we clone the injected dependency  to  avoid reusing the same instance for all tables 
                $extTableInstance->setConf($table, $key, $this);
                $extTableInstance->check();
                $this->collection[$table] = $extTableInstance;
            }
        
    }

    /**
     * Summary of getList
     */
    protected function getList()
    {
        $content = $this->readFile($this->listFile);
        return $content ? unserialize($content) : null ;
    }

    /**
     * Summary of readFile
     * @param string $file
     * @return bool|string
     */
    protected function readFile($file)
    {
        return GeneralUtility::getUrl($file);
    }

    public function addExtTable($key, $table, $model, $cat)
    {
        $this->res = array();
        $this->res['status'] = 'Unexpected error';
        $this->res['error'] = true;

        $extTableInsance = clone $this->extTable;
        $extTable=$extTableInsance;
        $extTable->setConf($table, $key, $this);
        $extTable->check();

        if (!$extTable->isOk) {
            $this->res['error'] = false;

            if (!$extTable->isSqlfile) {
                $this->res['etapes'][] = 'Mise a jour du fichier SQL';
                $this->updateSqlFile($table, $key);
            }
            if (!$extTable->isSqlbdd) {
                $this->res['etapes'][] = 'Mise a jour de la BDD';
                $this->updateSqlBdd($table);
            }
            if (!$extTable->isTca) {
                $this->res['etapes'][] = 'Mise a jour du TCA';
                $this->updateTca($table, $key);
            }
            if (!$extTable->isTSConfig) {
                $this->res['etapes'][] = 'Mise a jour du TSConfig';
                $this->updateTSConfig($table, $key, $model, $cat);
            }
            if (!$extTable->isTSExtbase) {
                $this->res['etapes'][] = 'Mise a jour du TS pour extbase';
                $this->updateTSExtbase($table, $key);
            }
            if (!$extTable->isModel) {
                $this->res['etapes'][] = 'Création du fichier du model';
                $this->updateModel($key, $model);
            }
            if (!$extTable->isRepo) {
                $this->res['etapes'][] = 'Création du fichier du repository';
                $this->updateRepo($table, $key);
            }
            if (!$extTable->isXml) {
                $this->res['etapes'][] = 'Création du fichier du Xml';
                $this->updateXml($key);
            }
            if (!$extTable->isHtml) {
                $this->res['etapes'][] = 'Création du fichier du Html';
                $this->updateHtml($key);
            }

            $this->res['etapes'][] = 'Mise a jour de la liste';
            $this->updatetList($table, $key);

            $this->res['etapes'][] = 'Vider les caches';
            $this->flushCache();

            $this->res['status'] = 'Ok';
        } else {
            $this->res['status'] = 'Deja Ok.';
            $this->res['error'] = false;
        }

        return $this->res;
    }

    protected function updateSqlFile($table)
    {
        if (empty($this->sqlFileContent)) {
            $this->readSqlFile();
        }

        $this->sqlFileContent .= "
		
#
# Table structure for table '" . $table . "'
#
CREATE TABLE " . $table . " (
	poi int(11) unsigned DEFAULT '0' NOT NULL,
	picto int(11) unsigned NOT NULL default '0',
	lat varchar(255) DEFAULT '' NOT NULL,
	lng varchar(255) DEFAULT '' NOT NULL,
);
";

        if ($this->writeFile($this->sqlFile, $this->sqlFileContent)) {
            $this->res['etapes'][] = 'Ok';
        } else {
            $this->res['etapes'][] = 'Fail';
            $this->res['error'] = true;
        }
    }

    protected function readSqlFile()
    {
        $this->sqlFileContent = $this->readFile($this->sqlFile);
    }

    protected function writeFile($file, $content)
    {
        return GeneralUtility::writeFile($file, $content);
    }

    /**
     * Update SQL database
     */
    protected function updateSqlBdd(string $table): void
    {
        if (empty($this->sqlFileContent)) {
            $this->readSqlFile();
        }
        try {
            // Parse SQL statements from the SQL file
            $sqlStatements = $this->sqlReader->getCreateTableStatementArray($this->sqlFileContent);

            $updateStatements = $this->schemaMigrator->getUpdateSuggestions($sqlStatements);

            $selectedStatements = [];

            if (!empty($updateStatements['create_table'])) {
                $selectedStatements = array_merge($selectedStatements, $updateStatements['create_table']);
            }

            if (!empty($updateStatements['add'])) {
                $selectedStatements = array_merge($selectedStatements, $updateStatements['add']);
            }

            if (!empty($selectedStatements)) {
                $this->schemaMigrator->migrate($sqlStatements, $selectedStatements);
                $this->res['etapes'][] = 'Ok - ' . count($selectedStatements) . ' statement(s) executed';
            } else {
                $this->res['etapes'][] = 'Ok - No changes needed';
            }
        } catch (\Exception $e) {
            $this->res['etapes'][] = 'Fail: ' . $e->getMessage();
            $this->res['error'] = true;
        }
    }

    protected function updateTca($table, $key)
    {
        $this->res['etapes'][] = 'Rien a faire, ne devrait pas arriver.';
    }

    protected function updateTSConfig($table, $key, $model, $cat)
    {
        if (empty($this->tsconfigFileContent)) {
            $this->readTsconfigFile();
        }

        $this->tsconfigFileContent .= "

        tx_egmap_conf{
            extensions{
                " . $key . " {
                    table = " . $table . "
                    model = " . $model . "
                    cat = " . $cat . "
                }
            }
        }
";

        if ($this->writeFile($this->tsconfigFile, $this->tsconfigFileContent)) {
            $this->res['etapes'][] = 'Ok';
        } else {
            $this->res['etapes'][] = 'Fail';
            $this->res['error'] = true;
        }
    }

    protected function readTsconfigFile()
    {
        $this->tsconfigFileContent = $this->readFile($this->tsconfigFile);
    }

    protected function updateTSExtbase($table, $key)
    {
        if (empty($this->typoscriptFileContent)) {
            $this->readTyposcriptFile();
        }

        $this->typoscriptFileContent .= "

config.tx_extbase{
	persistence.classes {
		Emagineurs\EGmap\Domain\Model\\" . $key . " {
			mapping{
				tableName = " . $table . "
			}
		}
	}
}

";

        if ($this->writeFile($this->typoscriptFile, $this->typoscriptFileContent)) {
            $this->res['etapes'][] = 'Ok';
        } else {
            $this->res['etapes'][] = 'Fail';
            $this->res['error'] = true;
        }
    }

    /* Updates */

    protected function readTyposcriptFile()
    {
        $this->typoscriptFileContent = $this->readFile($this->typoscriptFile);
    }

    protected function updateModel($key, $model)
    {
        $content = $this->readFile($this->templateModel);
        $content = str_replace(array('###key###', '###model###'), array($key, $model), $content);

        $modelFile = $this->extPath . 'Classes/Domain/Model/' . $key . '.php';

        if (!empty($content) && $this->writeFile($modelFile, $content)) {
            $this->res['etapes'][] = 'Ok';
        } else {
            $this->res['etapes'][] = 'Fail';
            $this->res['error'] = true;
        }
    }

    protected function updateRepo($table, $key)
    {
        $content = $this->readFile($this->templateRepo);
        $content = str_replace(array('###key###', '###table###'), array($key, $table), $content);

        $repoFile = $this->extPath . 'Classes/Domain/Repository/' . $key . 'Repository.php';

        if (!empty($content) && $this->writeFile($repoFile, $content)) {
            $this->res['etapes'][] = 'Ok';
        } else {
            $this->res['etapes'][] = 'Fail';
            $this->res['error'] = true;
        }
    }

    protected function updateXml($key)
    {
        $content = $this->readFile($this->templateXml);

        $xmlFile = GeneralUtility::getFileAbsFileName(
            $this->getTemplateRootPath() . 'Map/'
        ) . ucfirst($key) . '.xml';

        if (!empty($content) && $this->writeFile($xmlFile, $content)) {
            $this->res['etapes'][] = 'Ok';
        } else {
            $this->res['etapes'][] = 'Fail';
            $this->res['error'] = true;
        }
    }

    public function getTemplateRootPath()
    {
        if (
            !empty($this->typoscript['view']['templateRootPath'])
            && is_dir(GeneralUtility::getFileAbsFileName($this->typoscript['view']['templateRootPath']))
        ) {
            return $this->typoscript['view']['templateRootPath'];
        }

        if (
            !empty($this->typoscript['view']['templateRootPaths'])
            && is_array($this->typoscript['view']['templateRootPaths'])
        ) {
            $paths = ArrayUtility::sortArrayWithIntegerKeys(
                $this->typoscript['view']['templateRootPaths']
            );
            $paths = array_reverse($paths, true);
            foreach ($paths as $path) {
                if (is_dir(GeneralUtility::getFileAbsFileName($path))) {
                    return $path;
                }
            }
        }
    }

    protected function updateHtml($key)
    {
        $content = $this->readFile($this->templateHtml);

        $htmlFile =GeneralUtility::getFileAbsFileName(
            $this->getTemplateRootPath() . 'Map/'
        ) . ucfirst($key) . '.html';

        if (!empty($content) && $this->writeFile($htmlFile, $content)) {
            $this->res['etapes'][] = 'Ok';
        } else {
            $this->res['etapes'][] = 'Fail';
            $this->res['error'] = true;
        }
    }

    protected function updatetList($table, $key)
    {
        $liste = $this->getList();
        $liste[$table] = $key;
        if ($this->setList($liste)) {
            $this->res['etapes'][] = 'Ok';
        } else {
            $this->res['etapes'][] = 'Fail';
            $this->res['error'] = true;
        }
    }

    protected function setList($list)
    {
        return $this->writeFile($this->listFile, serialize($list));
    }

    protected function flushCache()
    {
       $this->cacheManager->flushCachesInGroup('system');
        $this->res['etapes'][] = 'Ok';
    }

    public function isInSqlFile($table)
    {
        if (empty($this->sqlFileContent)) {
            $this->readSqlFile();
        }

        return (strpos($this->sqlFileContent, $table) !== false);
    }

    /* geters */

    public function isInSqlBdd($table)
    {
        $res = true;
        $connection = $this->connectionPool->getConnectionForTable($table);
        $schemaManager = $connection->createSchemaManager();
        try {
            $columns = $schemaManager->listTableColumns($table);
            $listField = array_keys($columns);
        } catch (\Doctrine\DBAL\Exception $e) {
            // Table does not exist or cannot be read
            return false;
        }

        $res = true;
        foreach ($this->sqlFields as $field) {
            $res = $res && in_array($field, $listField, true);
        }

        return $res;
    }

    public function isInTca($table)
    {
        $res = true;

        $columns = $GLOBALS['TCA'][$table]['columns'] ?? null;
        $listField = is_array($columns) ? array_keys($columns) : [];
        foreach ($this->sqlFields as $field) {
            $res = $res && in_array($field, $listField);
        }
        return $res;
    }

    public function isInTSConfig($table, $key)
    {
        return (isset($this->tsconfig['tx_egmap_conf.']['extensions.'][$key . '.']['table'])
            && $this->tsconfig['tx_egmap_conf.']['extensions.'][$key . '.']['table'] == $table);
    }

    public function isInTSExtbase($table, $key)
    {
        return (isset($this->typoscript['persistence']['classes']['Emagineurs\EGmap\Domain\Model\\' . ucfirst($key)]['mapping']['tableName'])
            && $this->typoscript['persistence']['classes']['Emagineurs\EGmap\Domain\Model\\' . ucfirst($key)]['mapping']['tableName'] == $table);
    }

    /* Utils */

    public function isModel($key)
    {
        return $this->isFile($this->extPath . 'Classes/Domain/Model/' . ucfirst($key) . '.php');
    }

    protected function isFile($file)
    {
        return file_exists($file);
    }

    public function isRepo($key)
    {
        return $this->isFile($this->extPath . 'Classes/Domain/Repository/' . ucfirst($key) . 'Repository.php');
    }

    public function isXml($key)
    {
        return $this->isFile(
            GeneralUtility::getFileAbsFileName(
                $this->getTemplateRootPath() . 'Map/' . ucfirst($key) . '.xml'
            )
        );
    }

    public function isHtml($key)
    {
        return $this->isFile(
            GeneralUtility::getFileAbsFileName(
                $this->getTemplateRootPath() . 'Map/' . ucfirst($key) . '.html'
            )
        );
    }

    /* Low Level */

    public function isKeyInList($key)
    {
        $liste = $this->getList();
        return in_array($key, $liste);
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function getExtModel(string $key): ?string
    {
        $txConfig = $this->tsconfig['tx_egmap_conf']['extensions'][$key]['model'] ?? null;
        return $txConfig;
    }

    public function getExtCat(string $key): ?string
    {
        $txConfig = $this->tsconfig['tx_egmap_conf']['extensions'][$key]['cat'] ?? null;
        return $txConfig;
    }
}
