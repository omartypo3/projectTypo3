<?php
namespace EventMaps\PkEventmaps\Controller;

/***
 *
 * This file is part of the "EventMaps" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Patrick Kudla, Avonis
 *
 ***/

/**
 * EventController
 */
class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * eventRepository
     *
     * @var \EventMaps\PkEventmaps\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;


    /**
     * action findSorted
     *
     * @return void
     */
    public function findSorted() {
        $query = $this->createQuery();
        $query->setOrderings(array("sorting" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
        $query = $query->execute();
    }



    public function getCoordinates($address)
    {
        $address = str_replace(array(' '),array('+'),$address);
        $url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyCfDtiw0_N8gAvOJDJ2Zy6TLMcPo2QHdCI&address=$address";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);

        $geo['lon'] = $response_a->results[0]->geometry->location->lng;
        $geo['lat'] = $response_a->results[0]->geometry->location->lat;
        return ( $geo );
    }


    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $events = $this->eventRepository->findSorted();
        $results = array();
        foreach ($events as $item){
           if(strlen($item->getLon()) <= 0 || strlen($item->getLat()) <= 0 ){
               $geo = $this->getCoordinates($item->getStreet().'+'.$item->getStreetnumber().'+'.$item->getZip().'+'.$item->getCity());

               $address = $item->getStreet().'+'.$item->getStreetnumber().'+'.$item->getZip().'+'.$item->getCity();
               $address = str_replace(array(' '),array('+'),$address);
               $url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyCfDtiw0_N8gAvOJDJ2Zy6TLMcPo2QHdCI&address=$address";
               echo $url;
               echo $geo['lon'];
               if(is_array($geo) && $geo['lon'] != 'NULL' && $geo['lat'] != 'NULL'){
                    $item->setLon($geo['lon']);
                    $item->setLat($geo['lat']);
                    $this->eventRepository->update($item);
                }
            }

            //exclude
            $y = $item->getDate()->format('Y');
            $m = $item->getDate()->format('m');
            $d = $item->getDate()->format('d');
            if( $y > date('Y') || $m > date('m') || $d > date('d') && $m >= date('m') ){
                //remove Item
            }

            //BUILD JSON
            $orderArray = array();
            $orderArray['uid']= $item->getUid();
            $orderArray['longitude']= $item->getLon();
            $orderArray['latitude']= $item->getLat();
            $orderArray['fon']= $item->getFon();
            $orderArray['fax']= $item->getFax();
            $orderArray['mail']= $item->getMail();
            $orderArray['moderator']= $item->getModerator();
            $orderArray['location']= $item->getLocation();
            $orderArray['time']= $item->getAktionszeit();
            $orderArray['date']= $item->getDate()->format('d.m.Y');
            $orderArray['street']= $item->getStreet();
            $orderArray['streetnumber']= $item->getStreetnumber();
            $orderArray['zip']= $item->getZip();
            $orderArray['city']= $item->getCity();
            $results[] = $orderArray;
        }
        $this->view->assign('events', $events);
        $this->view->assign('json', json_encode($results));
    }
}
