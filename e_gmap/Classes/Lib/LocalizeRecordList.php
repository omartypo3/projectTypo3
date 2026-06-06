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

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Localization\LanguageService;
use Doctrine\DBAL\ParameterType;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 *
 *
 * @package e_gmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class LocalizeRecordList
{
    protected $conf = [];
    protected $pid = false;
    public function setConf($conf, $pid)
    {
        $this->conf = $conf;
        $this->pid = $pid;
    }
    public function getTableList()
    {
        $resFinal = [];
        if (!is_array($this->conf) || count($this->conf) < 1) {
            return false;
        }
        foreach ($this->conf as $tableTmp => $confTable) {
            $table = substr($tableTmp, 0, -1);
            if (
                $this->isTableAllowed($table)
                && is_array($GLOBALS['TCA'][$table] ?? null)
                && $this->isInPid($table)
            ) {
                $label = $this->getLanguageService()->sL($GLOBALS['TCA'][$table]['ctrl']['title']);
                $resFinal[] = [
                    'table' => $table,
                    'label' => $label,
                    'pattern' => $confTable['pattern'],
                    'lat' => $confTable['lat'],
                    'lng' => $confTable['lng']
                ];
            }
        }
        return count($resFinal) > 0 ? $resFinal : false;
    }
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG']; 
    }
    public function isTableAllowed($tableSubmited)
    {
        if ($tableSubmited == 'tx_egmap_domain_model_poi') {
            return true;
        }
        $result = false;
        $allowedTables = ELib::getListTables();
        if (is_array($allowedTables)) {
            foreach ($allowedTables as $table => $key) {
                if ($tableSubmited == $table) {
                    $result = true;
                }
            }
        }
        return $result;
    }
    public function isInPid($table)
    {
        if (!$this->pid || empty($table)) {
            return false;
        }
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($table);
        $count = $queryBuilder
            ->count('*')
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter((int)$this->pid, ParameterType::INTEGER)),
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER))
            )
            ->executeQuery()
            ->fetchOne();

        return ((int)$count > 0);
    }
    public function getRows(string $table): array
    {

        if (!$table || !isset($this->conf[$table . '.'])) {
            return [];
        }
        $conf = $this->conf[$table . '.'];

        $res = $conf;
        $res['rows'] = [];
        $res['toLocalize'] = 0;
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($table);
        $rows = $queryBuilder
            ->select('*')
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter((int)$this->pid, ParameterType::INTEGER))
            )
            ->andWhere(
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0, ParameterType::INTEGER))
            )
            ->executeQuery()
            ->fetchAllAssociative();

        $res['total'] = count($rows);
        foreach ($rows as $row) {
            $labelField = $GLOBALS['TCA'][$table]['ctrl']['label'] ?? null;
            $coord = $this->getCoord($conf['pattern'] ?? '', $row, $table);
            $lat = $row[$conf['lat']] ?? null;
            $lng = $row[$conf['lng']] ?? null;
            $status = (!empty($lat) && !empty($lng)) || empty($coord);
            if (!$status) {
                $res['toLocalize']++;
            }
            $res['rows'][] = [
                'key' => $table . '_' . $row['uid'],
                'uid' => $row['uid'],
                'table' => $table,
                'title' => $labelField && isset($row[$labelField]) ? $row[$labelField] : 'No title',
                'coord' => $coord,
                'lat' => $lat,
                'lng' => $lng,
                'status' => $status,
            ];
        }

        return $res;
    }

    public function getCoord($pattern, $row, $table)
    {
        $repo = ELib::getRepositoryForTable($table, (int)$this->pid);
        $record = $repo->findByUid($row['uid']);
        
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplateSource($pattern);
        $view->assignMultiple($row);
        $view->assign('record', $record);
        return $view->render();
    }
}
