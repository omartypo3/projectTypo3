<?php
namespace FRONTAL\FagInstitutionManagement\Service;

class ListPersonService implements \TYPO3\CMS\Core\SingletonInterface {
    /**
     * action clearList
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $fullList
     * @return array $clearList
     */
    public function clearList($fullList) {
        $clearedList = array();
        $notShowedPersons = array();

        foreach ($fullList as $person) {
            if($this->showPerson($person)) {
                if($person->getShowInRegister()) {
                    $clearedList[] = $person;
                } else {
                    $notShowedPersons[] = $person;
                }
            } else {
                $notShowedPersons[] = $person;
            }
        }

        return $clearedList;
    }

    /**
     * @param FRONTAL\FagInstitutionManagement\Domain\Model\User $person
     * @return boolean
     */
    protected function showPerson($person) {

        if(!empty(count($person->getRoles()))) {
            foreach ($person->getRoles() as $role) {
                if($role->getPid() == 421) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
