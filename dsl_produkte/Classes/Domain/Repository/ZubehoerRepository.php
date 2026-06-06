<?php
namespace DslFactory\DslProdukte\Domain\Repository;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Mike Zimmer <mz@dsl-factory.de>, dsl factory design GbR
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
 * The repository for Zubehoers
 */
class ZubehoerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function findAllWithoutPidRestriction() {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		return $query->execute();
	}


	public function initializeObject() {
		//exit; // da wohl nicht benutzt
		//$this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		//$this->defaultQuerySettings->setRespectStoragePage(FALSE);
	}

	/*public function replace($existingObject, $newObject) {
		$newObject->setAlias('testalias');
		// Does nothing here as explicit update replaces objects in persistence session already
	}*/

/*
	public function update($modifiedObject) {
		if (!$modifiedObject instanceof $this->objectType) {
			throw new \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException('The modified object given to update() was not of the type (' . $this->objectType . ') this repository manages.', 1249479625);
		}
		$modifiedObject->setAlias($modifiedObject->alias."__END");
		$this->persistenceManager->update($modifiedObject);
	}*/
	
	/*
	public function remove( $object ) {
    parent::__remove( $object );
    do_something_i_want();
}
	*/

}