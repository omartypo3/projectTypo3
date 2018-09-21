<?php
/**
 * Created by PhpStorm.
 * User: Oussama
 * Date: 24/05/2018
 * Time: 09:51
 */

namespace DLD\Dld\Command;

use DLD\Dld\Domain\Model\People;
use DLD\Dld\Domain\Model\UserTag;
use TYPO3\CMS\Core\Crypto\Random;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

class highriseCommandController extends CommandController
{

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * peopleRepository
     *
     * @var \DLD\Dld\Domain\Repository\PeopleRepository
     * @inject
     */
    protected $peopleRepository = null;
    /**
     * eventRepository
     *
     * @var \DLD\Dld\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * userGroupRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $userGroupRepository = null;
    /**
     * userTagRepository
     *
     * @var \DLD\Dld\Domain\Repository\UserTagRepository
     * @inject
     */
    protected $userTagRepository = null;

    public function cronCommand()
    {
        /**********************************************************Highrise to TYPO3************************/
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $urlPeople = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['url'] . '/people/';
        $urlSince = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['url'] . '/people.xml?since=';
        $urlXml = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['url'] . '/people.xml';
        $urlDelete = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['url'] . '/deletions.xml?since=';
        $higriseKey = $extbaseFrameworkConfiguration['plugin.']['tx_dld_dldfront.']['settings.']['higriseKey'];
        $pasword = new Random();
        $passwRandom = $pasword->generateRandomInteger(1, 999999999);
        $d = new \DateTime('NOW', new \DateTimeZone("UTC"));/*Higrise time is UTC */
        $t = $d->modify('-1 minutes');
        $cronTime = $t->format('YmdHis');
        $auth = base64_encode($higriseKey . ":X");
        $context = stream_context_create(['http' => ['header' => "Authorization: Basic $auth"]]);

        $homepage = file_get_contents($urlSince . $cronTime, false, $context);

        $elem = new \SimpleXMLElement($homepage);
        $tagsArray = array();
        foreach ($elem->person as $p) {

            $createdAt = (string)$p->{'created-at'};
            $cr = new \DateTime($createdAt);
            $created_at = $cr->format('YmdHis');
            $updatedAt = (string)$p->{'updated-at'};
            $upd = new \DateTime($updatedAt);
            $updated_at = $upd->format('YmdHis');
            $adressForTypo = (string)$p->{'contact-data'}->addresses->address->street . " " . (string)$p->{'contact-data'}->addresses->address->city . " " . (string)$p->{'contact-data'}->addresses->address->country;

            if ($created_at < $cronTime) {//brought by updated at
                $highrisePeople = $this->peopleRepository->findOneByHighrisePersonId((integer)$p->id);

                $highrisePeople->setFirstName((string)$p->{'first-name'});
                $highrisePeople->setLastname((string)$p->{'last-name'});
                $highrisePeople->setCompany((string)$p->{'company-name'});
                foreach ($p->{'contact-data'} as $email) {
                    $highrisePeople->setEmailPrivate((string)$email->{'email-addresses'}->{'email-address'}->{'address'});
                }
                if (count($p->tags) > 0) {
                    foreach ($p->tags->tag as $tagHighrise) {
                        if ($this->userTagRepository->getByTagsAndUserId((string)$tagHighrise->name, $highrisePeople->getUid()) == 0) {
                            $tag = new UserTag();
                            $tag->setUserid($highrisePeople->getUid());
                            $tag->setHighrisetag((string)$tagHighrise->name);
                            $tag->setHighriseTagcreatedat(new \DateTime('NOW'));
                            $this->userTagRepository->add($tag);
                            if (stripos(strrev((string)$tagHighrise->name), strrev('_invited'))==0) {
                                $tagefix = substr((string)$tagHighrise->name, 0, strlen((string)$tagHighrise->name) - strlen('_invited'));
                                $event = $this->eventRepository->findByTagPrefix($tagefix)->getFirst();
                                $event->setInvitednumber($event->getInvitednumber()+1);
                                $this->eventRepository->update($event);
                            }
                            elseif (stripos(strrev((string)$tagHighrise->name), strrev('_applied'))==0) {
                                $tagefix = substr((string)$tagHighrise->name, 0, strlen((string)$tagHighrise->name) - strlen('_applied'));
                                $event = $this->eventRepository->findByTagPrefix($tagefix)->getFirst();
                                $event->setAppliednumber($event->getIAppliednumber()+1);
                                $this->eventRepository->update($event);
                            }
                        }

                    }

                }
                $this->peopleRepository->update($highrisePeople);

            } else {
                $highrisePeople = $this->peopleRepository->findOneByHighrisePersonId((integer)$p->id);// the updated was done in less of one minute of creation
                if (count($highrisePeople)) {
                    $highrisePeople = $this->peopleRepository->findOneByHighrisePersonId((integer)$p->id);
                    $highrisePeople->setFirstName((string)$p->{'first-name'});
                    $highrisePeople->setLastname((string)$p->{'last-name'});
                    $highrisePeople->setCompany((string)$p->{'company-name'});
                    foreach ($p->{'contact-data'} as $email) {
                        $highrisePeople->setEmailPrivate((string)$email->{'email-addresses'}->{'email-address'}->{'address'});
                    }
                    if (count($p->tags) > 0) {

                        foreach ($p->tags->tag as $tagHighrise) {
                            if ($this->userTagRepository->getByTagsAndUserId((string)$tagHighrise->name, $highrisePeople->getUid()) == 0) {
                                $tag = new UserTag();
                                $tag->setUserid($highrisePeople->getUid());
                                $tag->setHighrisetag((string)$tagHighrise->name);
                                $tag->setHighriseTagcreatedat(new \DateTime('NOW'));
                                $this->userTagRepository->add($tag);
                                if (stripos(strrev((string)$tagHighrise->name), strrev('_invited'))==0) {
                                    $tagefix = substr((string)$tagHighrise->name, 0, strlen((string)$tagHighrise->name) - strlen('_invited'));
                                    $event = $this->eventRepository->findByTagPrefix($tagefix)->getFirst();
                                    $event->setInvitednumber($event->getInvitednumber()+1);
                                    $this->eventRepository->update($event);
                                }
                                elseif (stripos(strrev((string)$tagHighrise->name), strrev('_applied'))==0) {
                                    $tagefix = substr((string)$tagHighrise->name, 0, strlen((string)$tagHighrise->name) - strlen('_applied'));
                                    $event = $this->eventRepository->findByTagPrefix($tagefix)->getFirst();
                                    $event->setAppliednumber($event->getIAppliednumber()+1);
                                    $this->eventRepository->update($event);
                                }

                            }
                        }
                    }
                    $this->peopleRepository->update($highrisePeople);
                } else {

                    $people = new People();
                    $people->setHighrisePersonId((integer)$p->id);
                    $people->setFirstName((string)$p->{'first-name'});
                    $people->setName((string)$p->{'first-name'} . " " . (string)$p->{'last-name'});
                    $people->setLastname((string)$p->{'last-name'});
                    $people->setCompany((string)$p->{'company-name'});
                    foreach ($p->{'contact-data'} as $email) {
                        $people->setEmailPrivate((string)$email->{'email-addresses'}->{'email-address'}->{'address'});
                    }

                    /********Only the first address will be taken *********/
                    $people->setAddress($adressForTypo);
                    $people->setPassword($passwRandom);
                    $people->setUsername((string)$p->{'first-name'});
                    $people->setPid(10);
//                $people->addUsergroup($userGroup);
                    $this->peopleRepository->add($people);
                    $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                    $persistenceManager->persistAll();

                    if (count($p->tags) > 0) {
                        foreach ($p->tags->tag as $tagHighrise) {
                            if ($this->userTagRepository->getByTagsAndUserId((string)$tagHighrise->name, $highrisePeople->getUid()) == 0) {
                                $tag = new UserTag();
                                $tag->setUserid($highrisePeople->getUid());
                                $tag->setHighrisetag((string)$tagHighrise->name);
                                $tag->setHighriseTagcreatedat(new \DateTime('NOW'));
                                $this->userTagRepository->add($tag);
                                if (stripos(strrev((string)$tagHighrise->name), strrev('_invited'))==0) {
                                    $tagefix = substr((string)$tagHighrise->name, 0, strlen((string)$tagHighrise->name) - strlen('_invited'));
                                    $event = $this->eventRepository->findByTagPrefix($tagefix)->getFirst();
                                    $event->setInvitednumber($event->getInvitednumber()+1);
                                    $this->eventRepository->update($event);
                                }
                                elseif (stripos(strrev((string)$tagHighrise->name), strrev('_applied'))==0) {
                                    $tagefix = substr((string)$tagHighrise->name, 0, strlen((string)$tagHighrise->name) - strlen('_applied'));
                                    $event = $this->eventRepository->findByTagPrefix($tagefix)->getFirst();
                                    $event->setAppliednumber($event->getIAppliednumber()+1);
                                    $this->eventRepository->update($event);
                                }
                            }
                        }

                    }

                }


            }
        }
        /**Delete**/
        /**Delete**/
        $Delete = file_get_contents($urlDelete . $cronTime, false, $context);
        $elemD = new \SimpleXMLElement($Delete);
        foreach ($elemD->deletion as $d) {
            if ($d['type'] == "Person") {
                $idDeletePeople = (integer)$d->id;
                $highriseDeletePeople = $this->peopleRepository->findOneByHighrisePersonId($idDeletePeople);
                $this->peopleRepository->remove($highriseDeletePeople);
            }
        }

        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        /***************End of "Highrise to TYPO3"******************************************************************/

        /************************************************************Typo3 to highrise********************************************************************************/

        $newCreatedPeoples = $this->peopleRepository->GetByNewCreatedAt();
        $updatedPeoples = $this->peopleRepository->getByUpdatedPeople();
        $deletedPeoples = $this->peopleRepository->getByDeletedPeople();

        if (count($newCreatedPeoples)) {
            foreach ($newCreatedPeoples as $newCreatedPeople) {

                $personNewArray = array(
                    "first-name" => $newCreatedPeople->getFirstName(),
                    "last-name" => $newCreatedPeople->getLastName(),
                    "company-name" => $newCreatedPeople->getCompany(),
                    "background" => $newCreatedPeople->getBiography(),
                    "linkedin-url" => $newCreatedPeople->getSocialLinkedinUrl(),
                    "contact-data" => array(
                        "email-addresses" => array(
                            "email-address" => array(
                                "address" => $newCreatedPeople->getEmailPrivate(),
                            )
                        )
                    )
                );
                $url = $urlXml;
                $post_string = $this->arrayToXml($personNewArray);
//               \TYPO3\CMS\Core\Utility\DebugUtility::debug($post_string);die();
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);

                // For xml, change the content-type.
                curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_USERPWD, $higriseKey . ":X");
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

                // Send to remote and return data to caller.
                $result = curl_exec($ch);
                $elem = new \SimpleXMLElement($result);
                $newCreatedPeople->setHighrisePersonId((integer)$elem->id);
                $this->peopleRepository->update($newCreatedPeople);

            }
        }
        if (count($updatedPeoples)) {
            foreach ($updatedPeoples as $updatedPeople) {
                $hiriseId = $updatedPeople->getHighrisePersonId();
                $urlUpdate = $urlPeople . $hiriseId . ".xml";
                $personUpdateArray = array(
                    "first-name" => $updatedPeople->getFirstName(),
                    "last-name" => $updatedPeople->getLastName(),
                    "company-name" => $updatedPeople->getCompany(),
                    "background" => $updatedPeople->getBiography(),
                    "linkedin-url" => $updatedPeople->getSocialLinkedinUrl(),
                    "contact-data" => array(
                        "email-addresses" => array(
                            "email-address" => array(
                                "address" => $updatedPeople->getEmailPrivate(),
                            )
                        )
                    ),
                );
                $post_string = $this->arrayToXml($personUpdateArray);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $urlUpdate);

                // For xml, change the content-type.
                curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_USERPWD, $higriseKey . ":X");
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

                $result = curl_exec($ch);

            }
        }

        $newtags = $this->userTagRepository->getByNewTags();

        if (count($newtags)) {
            $post_string = $this->arrayToXml($personUpdateArray);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlUpdate);

            // For xml, change the content-type.
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_USERPWD, $higriseKey . ":X");
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            foreach ($newtags as $newtag) {
                $tags = "<?xml version='1.0' encoding='UTF-8'?>
                   <name>" . $newtag->getHighrisetag() . "</name>";
                $peopleupdated = $this->peopleRepository->findByUid($newtag->getUserid());
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $urlPeople . $peopleupdated->getHighrisePersonId() . "/tags.xml");

                // For xml, change the content-type.
                curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $tags);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_USERPWD, $higriseKey . ":X");
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                $result = curl_exec($ch);
//                   \TYPO3\CMS\Core\Utility\DebugUtility::debug($result);
            }
        }
        if (count($deletedPeoples)) {
            foreach ($deletedPeoples as $deletedPeople) {
                $hiriseId = $deletedPeople->getHighrisePersonId();
                $urlDelete = $urlPeople . $hiriseId . ".xml";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $urlDelete);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_USERPWD, $higriseKey . ":X");
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_exec($ch);
            }
        }
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
    }


    function arrayToXml($array, $rootElement = null, $xml = null)
    {
        $_xml = $xml;

        if ($_xml === null) {
            $_xml = new \SimpleXMLElement($rootElement !== null ? $rootElement : '<person/>');
        }

        foreach ($array as $k => $v) {
            if (is_array($v)) { //nested array
                $this->arrayToXml($v, $k, $_xml->addChild($k));
            } else {
                $_xml->addChild($k, $v);
            }
        }

        return $_xml->asXML();
    }
}