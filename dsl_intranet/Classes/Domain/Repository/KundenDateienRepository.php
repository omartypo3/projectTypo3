<?php
namespace DslFactory\DslIntranet\Domain\Repository;

/***
 *
 * This file is part of the "Intranet" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
 *
 ***/

/**
 * The repository for KundenDateiens
 */
class KundenDateienRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected $orderMapDefaultArr = array(
        '0asc' => array(
            //'titel' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
			'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '0desc' => array(
            //'titel' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
			'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '1asc' => array(
            'tempDateiName' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '1desc' => array(
            'tempDateiName' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '2asc' => array(
            'tempType' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '2desc' => array(
            'tempType' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '3asc' => array(
        //    'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
			'tempType' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '3desc' => array(
        //    'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
			'tempType' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        )
    );

    protected $orderMapRechnungenArr = array(
        '0asc' => array(
            'tempRechnungsnummer' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '0desc' => array(
            'tempRechnungsnummer' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '1asc' => array(
            'auftraege' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '1desc' => array(
            'auftraege' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '2asc' => array(
            'tempDateiName' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '2desc' => array(
            'tempDateiName' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        ),
        '3asc' => array(
            'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ),
        '3desc' => array(
            'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
        )
    );

    // Order by BE sorting
    protected $defaultOrderings = array(
        'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
    );

    /**
     * @param array $settings
     * @param integer $offset
     * @param integer $limit
     * @param array $order
     * @param string $search
     * @param string $orderMap
     */
    public function findByFilter($settings, $offset = false, $limit = false, $order = array(), $search = false, $orderMap = false)
    {
        if ($limit === -1) {
            $limit = false;
        }
        $manuallyOrderings = array();
        foreach ($order as $orderItem) {
            switch ($orderMap) {
                case 'rechnungen':    foreach ($this->orderMapRechnungenArr[$orderItem['column'] . $orderItem['dir']] as $k => $v) {
                        $manuallyOrderings[$k] = $v;
                    }
                    break;
                default:    foreach ($this->orderMapDefaultArr[$orderItem['column'] . $orderItem['dir']] as $k => $v) {
                        $manuallyOrderings[$k] = $v;
                    }
                    break;
            }
        }
        if (count($manuallyOrderings)) {
            foreach ($this->defaultOrderings as $k => $v) {
                if (!isset($manuallyOrderings[$k])) {
                    $manuallyOrderings[$k] = $v;
                }
            }
            $this->defaultOrderings = $manuallyOrderings;
        }
        $query = $this->createQuery();
        $andConstraints = array();
        //$andConstraints[] = $query->equals('kunde', $GLOBALS['TSFE']->fe_user->user['uid']);
        $andConstraints[] = $query->equals('kunden', $GLOBALS['TSFE']->fe_user->user['uid']);
        $andConstraints[] = $query->equals('sichtbarkeit', 1);
        foreach ($settings as $key => $value) {
            if (is_array($value)) {
                $orConstraints = array();
                switch ($key) {
                    case 'kundens':    foreach ($value as $wert) {
                            $orConstraints[] = $query->equals('kunden', $wert);
                        }
                        break;
                    case 'typens':    foreach ($value as $wert) {
                            $orConstraints[] = $query->equals('type', $wert);
                        }
                        break;
                }
                if (count($orConstraints)) {
                    $andConstraints[] = $query->logicalOr($orConstraints);
                }
            } else {
                switch ($key) {
                    case 'von':    //die;
                        if ($value) {
                            $von = new \DateTime($value);
                            $vonBeginOfDay = new \DateTime($von->format('Y-m-d'));
                            $andConstraints[] = $query->greaterThan('datum', $vonBeginOfDay->getTimestamp() - 1);
                        }
                        break;
                    case 'bis':    //die;
                        if ($value) {
                            $bis = new \DateTime($value);
                            date_add($bis, date_interval_create_from_date_string('1 days'));
                            $bisNextDay = new \DateTime($bis->format('Y-m-d'));
                            $andConstraints[] = $query->lessThanOrEqual('datum', $bisNextDay->getTimestamp() - 1);
                        }
                        break;
                    case 'suchtext':    //   die;
                        $search = $value;
                        break;
                }
            }
        }
        $searchOrConstraints = array();
        if ($search !== false) {
            //echo "search";die;
            //Auftragsnummer
            $searchOrConstraints[] = $query->logicalOr(array($query->equals('uid', intval($search)), $query->like('uid', '%' . $search . '%')));
            //$query->logicalOr($searchOrConstraints)
            //im Auftragstitel
            $searchOrConstraints[] = $query->like('titel', '%' . $search . '%');
            $searchOrConstraints[] = $query->like('temp_datei_name', '%' . $search . '%');
            $searchOrConstraints[] = $query->like('temp_type', '%' . $search . '%');
            $searchOrConstraints[] = $query->like('temp_kunden_name', '%' . $search . '%');
            $searchOrConstraints[] = $query->equals('temp_kunden_nummer', $search);
        }
        if (count($searchOrConstraints)) {
            $andConstraints[] = $query->logicalOr($searchOrConstraints);
        }
        //        $andConstraints[] = $query->equals('auftraege', 0);
        if (count($andConstraints)) {
            $query->matching($query->logicalAnd($andConstraints));
        }
        if ($offset !== false) {
            $query->setOffset($offset);
        }
        if ($limit !== false) {
            $query->setLimit($limit);
        }
        $posts = $query->execute();
        // 		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($query);
        //		die;
        return $posts;
    }
}
