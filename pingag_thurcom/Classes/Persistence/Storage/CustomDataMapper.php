<?php

namespace Pingag\PingagClicConnector\Persistence\Storage;

/**
 * Created by PhpStorm.
 * User: Cyrill Gsell
 * Date: 12.09.2017
 * Time: 10:48
 */
class CustomDataMapper extends \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper {

    /**
     * Maps a single row on an object of the given class
     *
     * @param string $className The name of the target class
     * @param array $row A single array with field_name => value pairs
     * @return object An object of the given class
     */
    protected function mapSingleRow($className, array $row) {
        $uid = isset($row['_LOCALIZED_UID']) ? $row['_LOCALIZED_UID'] : $row['uid'];
        if ($this->identityMap->hasIdentifier($uid, $className)) {
            $object = $this->identityMap->getObjectByIdentifier($uid, $className);
        } else {
            $object = $this->createEmptyObject($className);
            $this->identityMap->registerObject($object, $uid);
            $this->thawProperties($object, $row);
            $object->_memorizeCleanState();
            $this->persistenceSession->registerReconstitutedEntity($object);
        }
        return $object;
    }
}