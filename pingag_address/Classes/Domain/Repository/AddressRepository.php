<?php
declare(strict_types=1);

namespace Pingag\PingagAddress\Domain\Repository;

/**
 * This file is part of the "tt_address" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use FriendsOfTYPO3\TtAddress\Domain\Model\Dto\Demand;
use FriendsOfTYPO3\TtAddress\Service\CategoryService;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;

/**
 * The repository for the domain model Address
 */
class AddressRepository extends \FriendsOfTYPO3\TtAddress\Domain\Repository\AddressRepository
{
    const PINGAG_IP = '196.179.244.127';
    protected $defaultOrderings =
        array(
            'name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        );


    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getByLangAndLat(array $matchingServices , $ids): QueryResult
    {
        $debug = ($_SERVER['REMOTE_ADDR'] == self::PINGAG_IP || $_SERVER['HTTP_X_FORWARDED_FOR'] == self::PINGAG_IP);


        $query = $this->createQuery();
        $constraint= [];
        /**Set the constraint Between */
        if($matchingServices['inputValue'] != ''){
            $constraint[] =  $query->logicalAnd(
                [
                    $query->logicalOr(
                        $query->like('name', '%'.$matchingServices['inputValue'].'%'),
                        $query->like('first_name', '%'.$matchingServices['inputValue'].'%'),
                        $query->like('last_name', '%'.$matchingServices['inputValue'].'%'),
                        $query->like('address',  '%'.$matchingServices['inputValue'].'%'),
                        $query->like('description',  '%'.$matchingServices['inputValue'].'%'),
                        $query->like('weiterestandorte.strasse',  '%'.$matchingServices['inputValue'].'%')
                   /* $query->like('weiterestandorte.ort',  '%'.$matchingServices['inputValue'].'%'),
                    $query->like('weiterestandorte.email',  '%'.$matchingServices['inputValue'].'%'),
                    $query->like('weiterestandorte.telefon',  '%'.$matchingServices['inputValue'].'%'),
                    $query->like('weiterestandorte.url',  '%'.$matchingServices['inputValue'].'%')*/
                    ),
                    $query->in('pid', $ids)
                    //$query->between('latitude', (float)$matchingServices['minLattitude'],(float)$matchingServices['maxlattitude']),
                    //$query->between('longitude', (float)$matchingServices['minLongitude'],(float)$matchingServices['maxLongitude']),
                ]
            );
        }
        if($matchingServices['zipValue'] != ''){
            $zip = $this->geocode((int)$matchingServices['zipValue']);
            //\TYPO3\CMS\Core\Utility\DebugUtility::debug($matchingServices['zipValue']);
            if($zip){
                if($matchingServices['umkreisValue'] != '' && $matchingServices['umkreisValue'] != '0'){
                    // $newLatitude = $this->addDistanceToCoordinates((float)$zip[0],(float)$zip[1],(int)$matchingServices['umkreisValue'],true);
                    // $newLongitude = $this->addDistanceToCoordinates((float)$zip[0],(float)$zip[1],(int)$matchingServices['umkreisValue'],false);

                    $lowerLatitude = $this->subDistanceFromCoordinates((float)$zip[0],(float)$zip[1],(int)$matchingServices['umkreisValue'],true);
                    $upperLatitude = $this->addDistanceToCoordinates((float)$zip[0],(float)$zip[1],(int)$matchingServices['umkreisValue'],true);
                    $lowerLongitude = $this->subDistanceFromCoordinates((float)$zip[0],(float)$zip[1],(int)$matchingServices['umkreisValue'],false);
                    $upperLongitude = $this->addDistanceToCoordinates((float)$zip[0],(float)$zip[1],(int)$matchingServices['umkreisValue'],false);
                    $allzips = $this->newCalcul((int)$matchingServices['zipValue'],(int)$matchingServices['umkreisValue']);

                    // write coordinates to file (for debugging)
                    // $file = 'test.txt';
                    // $coord = (float) $lowerLatitude . " " . (float) $upperLatitude . " " . (float) $lowerLongitude . " " . (float) $upperLongitude . "\n";
                    // file_put_contents($file, $coord, FILE_APPEND | LOCK_EX);

                    //$coord = (float) $lowerLatitude . " " . (float) $upperLatitude . " " . (float) $lowerLongitude . " " . (float) $upperLongitude . "\n";
                    //\TYPO3\CMS\Core\Utility\DebugUtility::debug($coord);

                    $constraint[] =  $query->logicalAnd(
                        [
                            $query->logicalOr(
                                //  $query->equals('zip', (int)$matchingServices['zipValue']),
                                $query->logicalAnd(
                                    $query->between('latitude', (float)$lowerLatitude,(float)$upperLatitude),
                                    $query->between('longitude', (float)$lowerLongitude,(float)$upperLongitude)
                                ),
                                $query->logicalAnd(
                                    $query->between('weiterestandorte.breitengrad', (float)$lowerLatitude,(float)$upperLatitude),
                                    $query->between('weiterestandorte.laungengrad', (float)$lowerLongitude,(float)$upperLongitude)
                                )

                            ),
                            /************************************another methode*******************************************/
                            /*$query->logicalAnd(
                                $query->logicalOr(
                                //  $query->equals('zip', (int)$matchingServices['zipValue']),
                                    $query->in('zip', $allzips),
                                    $query->in('weiterestandorte.plz', $allzips)
                                // $query->between('weiterestandorte.breitengrad', (float)$zip['0'],(float)$lowerLatitude),
                                // $query->between('weiterestandorte.laungengrad', (float)$zip['1'],(float)$lowerLongitude),
                                //$query->between('latitude', (float)$lowerLatitude,(float)$zip['0']),
                                //$query->between('weiterestandorte.laungengrad', (float)$lowerLongitude,(float)$zip[1]),
                                //$query->between('longitude', (float)$lowerLongitude,(float)$zip[1])
                                )
                            ),*/
                            $query->in('pid', $ids)
                            //$query->between('latitude', (float)$matchingServices['minLattitude'],(float)$matchingServices['maxlattitude']),
                            //$query->between('longitude', (float)$matchingServices['minLongitude'],(float)$matchingServices['maxLongitude']),
                        ]
                    );
                }else{

                    $constraint[] =  $query->logicalAnd(
                        [
                            $query->logicalOr(
                                $query->equals('zip',(int)$matchingServices['zipValue']),
                                $query->equals('weiterestandorte.plz', (int)$matchingServices['zipValue'])
                            ),
                            $query->in('pid', $ids),

                        ]
                    );
                }

            }else{
                $constraint[] =  $query->logicalAnd(
                    [
                        $query->logicalOr(
                            $query->equals('zip', (int)$matchingServices['zipValue']),
                            $query->equals('weiterestandorte.plz', (int)$matchingServices['zipValue'])
                        ),
                        $query->in('pid', $ids)
                        //$query->between('latitude', (float)$matchingServices['minLattitude'],(float)$matchingServices['maxlattitude']),
                        //$query->between('longitude', (float)$matchingServices['minLongitude'],(float)$matchingServices['maxLongitude']),
                    ]
                );
            }

        }



        if($constraint){
            $query->matching($query->logicalAnd($constraint));
        }else{
            $query->matching($query->logicalAnd($query->in('pid', $ids)));
        }

        
        $result = $query->execute();
        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($result);

        /*this line are here just to use if you want to see the sql query */
        // $queryParser = $this->objectManager->get(Typo3DbQueryParser::class);
        // var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL());
        // \TYPO3\CMS\Core\Utility\DebugUtility::debug($queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL());
        // \TYPO3\CMS\Core\Utility\DebugUtility::debug($queryParser->convertQueryToDoctrineQueryBuilder($query)->getParameters());
        // die;
        return $result;
    }

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
     * @param $address
     * @return array
     */
    function geocode($address)
    {
        // get matching Ort name from PLZ
        $ort = "";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://openplzapi.org/ch/Localities?postalCode=" . $address);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Accept: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            // do nothing
        } else {
            $result = json_decode($result);
            foreach ($result as $result1) {
                $ort = $result1->name;
                $ort = str_replace(' ', '', $ort);
            }
        }
        curl_close ($ch);

        if (empty($result)) {
            return $this->geocode(intval($address) + 1);
        }
        
        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($ort);

        // --- Step 2: Build structured Nominatim query ---
        $nominatimUrl = "https://nominatim.openstreetmap.org/search?";
        $query = [
            'country'     => 'Switzerland',
            'postalcode'  => $address,
            'format'      => 'json',
            'limit'       => 1
        ];
        if (!empty($ort)) {
            $query['city'] = $ort;
        }

        $requestURL = $nominatimUrl . http_build_query($query);

        // --- Step 3: Query Nominatim via cURL ---
        $ch = curl_init($requestURL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["User-Agent: MyAppGeocoder/1.0"],
            CURLOPT_TIMEOUT => 10
        ]);

        $json = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log("Nominatim request failed: " . curl_error($ch));
            curl_close($ch);
            return null;
        }
        curl_close($ch);

        // --- Step 4: Parse response ---
        $data = json_decode($json, true);
        if (empty($data) || !isset($data[0]['lat'], $data[0]['lon'])) {
            return null;
        }

        $lat = (float)$data[0]['lat'];
        $lon = (float)$data[0]['lon'];

        return [$lat, $lon];
    }

    // Function to add distance in kilometers to latitude or longitude
    function addDistanceToCoordinates($lat, $lon, $kmToAdd, $isLatitude) {
        $degreesToAdd = $kmToAdd / ($isLatitude ? 111 : (111 * cos(deg2rad($lat))));
        return $isLatitude ? $lat + $degreesToAdd : $lon + $degreesToAdd;
    }

    // Function to subtract distance in kilometers to latitude or longitude
    function subDistanceFromCoordinates($lat, $lon, $kmToSub, $isLatitude) {
        $degreesToSub = $kmToSub / ($isLatitude ? 111 : (111 * cos(deg2rad($lat))));
        return $isLatitude ? $lat - $degreesToSub : $lon - $degreesToSub;
    }


    function newCalcul($code,$zip){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $data = [
            "code" => $code,
            "radius" => $zip,
            "country" => "ch",
        ];

        curl_setopt($ch, CURLOPT_URL, "https://app.zipcodebase.com/api/v1/radius?" . http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "apikey: d09df0d0-1390-11ef-9c23-cf2e1c0c9643",
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($response);
        $array = [];
        foreach ($json->results as $file){
            array_push($array,$file->code);
        }

       return array_unique($array);

    }



}
