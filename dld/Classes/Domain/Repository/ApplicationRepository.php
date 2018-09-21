<?php

namespace DLD\Dld\Domain\Repository;

/***
 *
 * This file is part of the "DLD Conference" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * The repository for Application
 */

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;


class ApplicationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        $this->defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $this->defaultQuerySettings->setRespectStoragePage(FALSE);
    }

    public function findByUserAndEvent($uid, $conference_id)
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_dld_domain_model_application WHERE  `event_id` ='.$conference_id . ' and  `user_id` ='.$uid );
        $resultat = $query->execute();
        return $resultat;
    }
    public function findByUser($uid)
    {
        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_dld_domain_model_application WHERE  `user_id` ='.$uid );
        $resultat = $query->execute();
        return $resultat;
    }
}
