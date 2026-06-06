<?php

declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Repository;


/**
 * This file is part of the "pingagaddress" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2022 
 */
use \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;

/**
 * The repository for Maps
 */
class AddressPersonRepository  extends \FriendsOfTYPO3\TtAddress\Domain\Repository\AddressRepository
{
    protected $defaultOrderings =
        array(
            'last_name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        );

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAdressPid($ids): QueryResult
    {

        $query = $this->createQuery();
        $query->matching($query->in('pid', $ids));
        $result = $query->execute();

        return $result;
    }

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAdress($ids,$Geschlecht,$Techniken,$Muttersprache,$Sprachen,$ort,$Gehoerlos,$notwenidg): QueryResult
    {

        $query = $this->createQuery();
        $constraint= [];
        if($ids){
            $constraint[] = $query->in('pid', $ids);
        }
        /**Set the constraint Between */
        if($Geschlecht){
            $constraint[] = $query->logicalOr($query->like('gender', '%'.$Geschlecht.'%'));
        }
        if($ort != 0){
            $uids = ['1','4','7'];
            //\TYPO3\CMS\Core\Utility\DebugUtility::debug($ort);
            if(in_array($ort, $uids)){
                $constraint[] = $query->logicalOr(
                    $query->like('placeofuse','%10%'),
                    $query->like('placeofuse','%'.$ort.'%')
                );
            }else{
                $constraint[] = $query->logicalOr(
                    $query->like('placeofuse','%'.$ort.'%')
                );
            }
            //$constraint[] =  $query->logicalOr($query->like('placeofuse', '%'.$ort));
        }
        /*if($ort){
            foreach ($ort as $orts){


                if($orts != 0) {
                    $constraint[] = $query->logicalOr(
                        $query->like('placeofuse', '%'.$orts.'%')
                    );
                }
            }
        }*/
        if($Techniken){
            if($Techniken[0] == 1){
                rsort($Techniken);
                foreach ($Techniken as $key  => $Tech){
                    if($Tech != 0) {
                        // \TYPO3\CMS\Core\Utility\DebugUtility::debug($Techniken[0]);
                        // \TYPO3\CMS\Core\Utility\DebugUtility::debug($Techniken[$key + 1]);

                        $constraint[] = $query->logicalOr(
                            $query->equals('technikenlevel.techniques', $Techniken[0]),
                            $query->equals('technikenlevel.techniques', $Techniken[$key + 1])

                        //  $query->equals('technikenlevel.techniques', 2)
                        );
                    }
                }


            }else{
                foreach ($Techniken as $key  => $Tech){
                    if($Tech != 0) {
                        // \TYPO3\CMS\Core\Utility\DebugUtility::debug($Techniken[0]);
                        // \TYPO3\CMS\Core\Utility\DebugUtility::debug($Techniken[$key + 1]);

                        $constraint[] = $query->logicalOr(
                            $query->equals('technikenlevel.techniques', $Techniken[0]),
                            $query->equals('technikenlevel.techniques', $Techniken[$key + 1])

                        //  $query->equals('technikenlevel.techniques', 2)
                        );
                    }
                }
            }

        }
        if($Muttersprache != 0){
            if($Muttersprache == '999999'){
                $uids = [16,1,2,5,4,6];
                $constraint[] = $query->logicalNot($query->in('mutter_sprache',$uids));
            }else{
                $constraint[] = $query->logicalOr(
                    $query->like('mutter_sprache','%'.$Muttersprache.'%')
                );
            }

        }
        if($Sprachen){
            foreach ($Sprachen as $lang){
                if($lang != 0) {
                    $constraint[] = $query->logicalOr(
                        $query->equals('weitereSprachenOral.language', $lang),
                        $query->equals('weitereSprachenWritten.language',$lang)
                    );
                }
            }
        }
        /*if($Gehoerlos == 'FALSE'){
            $constraint[] =$query->logicalOr($query->like('gehoerlos', 0));
        }
        if($Gehoerlos == 'TRUE'){
            $constraint[] =$query->logicalOr($query->like('gehoerlos', 1));
        }*/

        if($Gehoerlos != -1){

            // Wenn im Filter "Hörend" ausgewählt ist, soll in der Resultatsliste auch "Hörend (schwerhörig)" ausgegeben werden.
            if($Gehoerlos == 4) {
                $constraint[] = $query->logicalOr(
                    $query->like('gehoerlos','%4%'),
                    $query->like('gehoerlos','%7%')
                );
            } else {
                $constraint[] = $query->logicalOr(
                    $query->like('gehoerlos','%'.$Gehoerlos.'%')
                );
            }
            //$constraint[] =  $query->logicalOr($query->like('placeofuse', '%'.$ort));
        }
        
        if($notwenidg == 'FALSE'){
            $constraint[] =$query->logicalOr($query->like('auto_benoetigt', 0));
        }
        if($notwenidg == 'TRUE'){
            $constraint[] =$query->logicalOr($query->like('auto_benoetigt', 1));
        }


        $query->matching($query->logicalAnd($constraint));

        $result = $query->execute();

        return $result;
    }
}
