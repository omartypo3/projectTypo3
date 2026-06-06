<?php
namespace BravoBuero\BbPortfolio\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use BravoBuero\BbPortfolio\Domain\Model\Kategorien;
use BravoBuero\BbPortfolio\Domain\Model\Hashtags;
use BravoBuero\BbPortfolio\Domain\Model\Kunden;
use BravoBuero\BbPortfolio\Domain\Model\Portfolio;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017
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
 * The repository for Portfolios
 */
class PortfolioRepository extends Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'datum' => QueryInterface::ORDER_DESCENDING
    );
    
    /**
     * @param \BravoBuero\BbPortfolio\Domain\Model\Kategorien $kategorien
     * @param \BravoBuero\BbPortfolio\Domain\Model\Hashtags $hashtags
     * @param int $offset
     * @param int $limit
     */
    public function findByKategorienHashtags(Kategorien $kategorien = NULL, Hashtags $hashtags = NULL, $offset = NULL, $limit = NULL)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        if ($kategorien) {
            $andConstraints[] = $query->contains('kategorie', $kategorien);
        }
        if ($hashtags) {
            $andConstraints[] = $query->contains('hashtags', $hashtags);
        }
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd(...$andConstraints));
        }
        if ($offset !== NULL) {
            $query->setOffset($offset);
        }
        if ($limit !== NULL) {
            $query->setLimit($limit);
        }
        $posts = $query->execute();
        return $posts;
    }
    
    /**
     * @param \BravoBuero\BbPortfolio\Domain\Model\Kunden $kunden
     */
    public function findByKunden(Kunden $kunden)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        if ($kunden) {
            $andConstraints[] = $query->equals('kunde', $kunden);
        }
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd(...$andConstraints));
        }
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        $posts = $query->execute();
        return $posts;
    }
    
    public function findLatest()
    {
        $query = $this->createQuery();
        $andConstraints = array();
        $query->setLimit(5);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd(...$andConstraints));
        }
        $posts = $query->execute();
        return $posts;
    }
    
    /**
     * @param \BravoBuero\BbPortfolio\Domain\Model\Portfolio $portfolio
     * @param \BravoBuero\BbPortfolio\Domain\Model\Kategorien $kategorien
     * @param \BravoBuero\BbPortfolio\Domain\Model\Hashtags $hashtags
     */
    public function findByKategorienOrHashtags(Portfolio $portfolio, Kategorien $kategorien = NULL, Hashtags $hashtags = NULL)
    {
        $query = $this->createQuery();
        $andConstraints = array();
        $andConstraints[] = $query->logicalNot($query->equals('uid', $portfolio));
        $orConstraints = array();
        if ($kategorien) {
            $orConstraints[] = $query->contains('kategorie', $kategorien);
        } else {
            //echo count($portfolio->getKategorie());
            if (count($portfolio->getKategorie())) {
                //$kategorieOrConstraints[] = array();
                foreach ($portfolio->getKategorie() as $kategorie) {
                    $orConstraints[] = $query->contains('kategorie', $kategorie);
                }
            }
        }
        if ($hashtags) {
            $orConstraints[] = $query->contains('hashtags', $hashtags);
        }
        if (count($orConstraints)) {
            $andConstraints[] = $query->logicalOr(...$orConstraints);
        }
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd(...$andConstraints));
        }

        $posts = $query->execute();
        return $posts;
    }

}