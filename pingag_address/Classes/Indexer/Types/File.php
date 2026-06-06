<?php

namespace Pingag\PingagAddress\Indexer\Types;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Stefan Froemken
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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

use Tpwd\KeSearch\Domain\Repository\IndexRepository;
use Tpwd\KeSearch\Indexer\Filetypes\FileIndexerInterface;
use Tpwd\KeSearch\Indexer\IndexerBase;
use Tpwd\KeSearch\Indexer\IndexerRunner;
use Tpwd\KeSearch\Lib\Fileinfo;
use Tpwd\KeSearch\Lib\SearchHelper;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Resource\Index\MetaDataRepository;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Site\SiteFinder;

/**
 * Plugin 'Faceted search' for the 'ke_search' extension.
 * @author    Stefan Froemken
 * @author    Christian Bülter
 * @package    TYPO3
 * @subpackage    tx_kesearch
 */
class File extends \Tpwd\KeSearch\Indexer\Types\File
{

}
