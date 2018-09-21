<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 27/04/2018
 * Time: 16:50
 */

namespace DLD\Dld\ViewHelpers;
/**
 * Class EventSpeakersViewHelper
 * @package DLD\Dld\ViewHelpers
 */

class EventSpeakersViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * sessionReposetory
     *
     * @var \DLD\Dld\Domain\Repository\SessionRepository
     * @inject
     */
    protected $sessionReposetory;

    /**
     * sessionPeopleReposetory
     *
     * @var \DLD\Dld\Domain\Repository\SessionPeopleRepository
     * @inject
     */
    protected $SessionPeopleRepository;

    /**
     * @param int $uid
     *
     */

    public function render($uid){
       $events= $this->sessionReposetory->findByEventId($uid);
       $sessionUid = array();
       foreach ($events as $event){
           $sessionUid[] = $event->getUid();
       }
        if(!empty($sessionUid)){
            $peoples = $this->SessionPeopleRepository->findPeople($sessionUid);
            $unique = array();
            foreach ($peoples as $p){

                $unique[] = $p->getPeopleId();
            }

            $peoples = array_unique($unique);

            return $peoples;
        }


    }
}