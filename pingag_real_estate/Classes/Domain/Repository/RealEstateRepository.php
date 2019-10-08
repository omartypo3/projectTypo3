<?php
/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 27.07.2018
 * Time: 14:45
 */

namespace Pingag\PingagRealEstate\Domain\Repository;

use Pingag\PingagRealEstate\Domain\Model\RealEstate;
use Pingag\PingagRealEstate\Form\RealEstateFilter;
use Pingag\PingagRealEstate\Service\RealEstateOptionFactory;
use Pingag\PingagRealEstate\Util\GeneralUtil;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class RealEstateRepository extends Repository
{

    protected $defaultOrderings = array(
        'last_modified' => QueryInterface::ORDER_DESCENDING,
    );

    public function findNewBuildings()
    {
        $query = $this->createQuery();
        $query->matching($query->equals('new_building', 1));
        return $query->execute();
    }

    public function findByFilter(RealEstateFilter $filter = null)
    {
        $query = $this->createQuery();

        if ($filter) {
            $conditions = [];
            $zip = [];
            $uidFilter = [];
            $city = [];
            // offer type
            $conditions[] = $query->equals('offer_type', $filter->getOfferType());

            // search string
            if (!empty($filter->getSearchString())) {
                // km string
                if (!empty($filter->getSearchkm())) {
                    $km = $filter->getSearchkm();
                    foreach ($filter->getSearchString() as $searchItem1) {
                        $value = $this->getKm($searchItem1);
                        $valueXY = $this->getXY($value['0'], $value['1'],$km);
                        $valueMinX = $valueXY[0][0];
                        $valueMinY = $valueXY[0][1];
                        $valueMaxX = $valueXY[0][2];
                        $valueMaxY = $valueXY[0][3];
                        $find = $this->findAll();
                        foreach ($find as $findvlue){
                            $X = $findvlue->getObjectX();
                            $Y = $findvlue->getObjectY();
                            $price = $findvlue->getPrice();
                            //if($price!=0){
                                if(($X >= $valueMinX && $X <= $valueMaxX) && ($Y >= $valueMinY && $Y <= $valueMaxY)){
                           

                                    array_push($uidFilter, $findvlue->getUid());
                                }								
                            //}
                        }

                    }
					if(count($uidFilter)> 0){
							
						$conditions [] = $query->logicalOr(
							$query->in('uid', $uidFilter)
						);
					}else{
                        $conditions=[];
                    }

                }else{
                    if (count($filter->getSearchString()) != 0) {
                        foreach ($filter->getSearchString() as $searchItem) {
                            $search = preg_split('/(?<=\D)(?=\d)|\d+\K/', $searchItem);
                            array_push($zip, $search['0']);
                            array_push($city, $search['1']);
                        }
                        $conditions [] = $query->logicalOr(
                            $query->in('object_city', $search),
                            $query->in('object_zip', $zip)

                        );
                    }
                }
            }

            // object category + type
            $this->addSelectCondition('object_category', $filter->getObjectCategory(), $conditions, $query);
            $this->addSelectCondition('object_type', $filter->getObjectType(), $conditions, $query);

            // price
            $this->addRangeCondition(
                'price',
                $filter->getPriceMin(),
                $filter->getPriceMax(),
                $conditions,
                $query
            );

            // rooms
            $this->addRangeCondition(
                'number_of_rooms',
                $filter->getRoomsMin(),
                $filter->getRoomsMax(),
                $conditions,
                $query
            );

            $this->addRangeCondition(
                'surface_living',
                $filter->getSurfaceUsableMin(),
                $filter->getSurfaceUsableMax(),
                $conditions,
                $query
            );

            // floor
            $this->addSelectCondition('floor', $filter->getFloor(), $conditions, $query);

            // props
            foreach ($filter->getProperties() as $property) {
                if (in_array($property, RealEstate::REAL_ESTATE_PROPERTIES)) {
                    $fieldName = GeneralUtil::camelCaseToSnake($property);
                    $this->addBooleanCondition($fieldName, $conditions, $query);
                }
            }

            $query->matching($query->logicalAnd($conditions));

            // limit
            if ($limit = $filter->getLimit()) {
                $query->setLimit($limit);
            }

            // offset
            if ($offset = $filter->getOffset()) {
                $query->setOffset($offset);
            }
        }

        //$this->debugQuery($query->execute());
        return $query->execute();
    }

    protected function addRangeCondition($fieldName, $min, $max, array &$conditions, QueryInterface $query)
    {
        $conditions[] = $query->logicalAnd(
            $query->greaterThanOrEqual($fieldName, $min),
            $query->lessThanOrEqual($fieldName, $max)
        );
    }

    protected function addSelectCondition($fieldName, $filterValue, array &$conditions, QueryInterface $query)
    {
        if ($filterValue !== null && $filterValue !== RealEstateFilter::SELECT_ALL_KEYWORD) {
            $conditions[] = $query->equals($fieldName, $filterValue);
        }
    }

    protected function addBooleanCondition($fieldName, array &$conditions, QueryInterface $query)
    {
        $conditions[] = $query->equals($fieldName, 1);
    }

    public function getGroupedFieldValues($fieldName, $where = null)
    {
        $query = $this->createQuery();
        $table = $this->getTableName();

        if ($where && strpos($where, 'WHERE') === false) {
            $where = 'WHERE ' . trim($where);
        }

        $query->statement("SELECT {$fieldName} FROM {$table} {$where} GROUP BY {$fieldName}");
        $values = $query->execute(true);
        return array_column($values, $fieldName);
    }

    protected function getTableName()
    {
        $className = RealEstate::class;
        $dataMapper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(DataMapper::class);
        return $dataMapper->getDataMap($className)->getTableName();
    }

    /**
     * Debugs a SQL query from a QueryResult
     *
     * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $queryResult
     * @param boolean $explainOutput
     * @return void
     */
    public function debugQuery(\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $queryResult, $explainOutput = FALSE)
    {
        $GLOBALS['TYPO3_DB']->debugOutput = 2;
        if ($explainOutput) {
            $GLOBALS['TYPO3_DB']->explainOutput = true;
        }
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = true;
        $queryResult->toArray();
        DebuggerUtility::var_dump($GLOBALS['TYPO3_DB']->debug_lastBuiltQuery);

        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = false;
        $GLOBALS['TYPO3_DB']->explainOutput = false;
        $GLOBALS['TYPO3_DB']->debugOutput = false;
    }

    public function getXY($x,$y,$km){
        $data_arr = array();
        $m = $km * 1000;
        $MinX =0;$MinY=0;$MaxX=0;$MaxY = 0;
        $MinX += $x - $m;
        $MinY += $y - $m;
        $MaxX += $x + $m;
        $MaxY += $y + $m;
        $minMax = array('0' => $MinX,'1' => $MinY,'2'=>$MaxX ,'3'=>$MaxY);
        array_push($data_arr,$minMax);
        return $data_arr;
    }
    public function getKm($fieldName){
        // url encode the address
        $address = urlencode($fieldName);
        $opts = array('http' => array('header' => "User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
        $context = stream_context_create($opts);
        $json = file_get_contents('https://api3.geo.admin.ch/rest/services/api/SearchServer?searchText='.$address.'&type=locations&origins=address&limit=1', false, $context);
        $data = json_decode($json, true);
        $data_arr = array();
        foreach ($data as $data1) {
            $x = $data1['0']['attrs']['x'];
            $y = $data1['0']['attrs']['y'];
            // put the data in the array
            $data_arr = array();

            array_push(
                $data_arr,
                $x,
                $y
            );
        }
        return $data_arr;

    }
}