<?php
namespace Emagineurs\EAnnuaires\SchedulerTask;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 BEAURIN Tristan<tbeaurin@e-magineurs.com>, E-magineurs
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
class PurgeCandidaturesTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

    /**
     * Function execute from the Scheduler
     *
     * @return boolean TRUE on successful execution, FALSE on error
     */
    public function execute(){
        $typeCandidatureArray = explode(',', $this->typeCandidature);
        $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $ficheRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\FicheRepository::class);
        $documentsRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\DocumentsRepository::class);

        // Remplacer par des confs de la tache cron
        $query = $ficheRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraints[] = $query->in('typeelement',$typeCandidatureArray);
        $constraints[] = $query->lessThanOrEqual('crdate', time() - $this->nbDays*24*60*60);
        $offres = $query->matching($query->logicalAnd($constraints))->execute();

        foreach ($offres as $offre) {
            foreach ($offre->getMedia() as $media) {
                $file = $media->getOriginalResource()->getOriginalFile();
                $file->delete();
            }
            foreach ($offre->getDocuments() as $doc) {
                foreach ($doc->getFichier() as $fichier) {
                    $file = $fichier->getOriginalResource()->getOriginalFile();
                    $file->delete();
                }
                $documentsRepository->remove($doc);
                $persistenceManager->persistAll();
            }
            $offre->setMedia(new \TYPO3\CMS\Extbase\Persistence\ObjectStorage());
            $offre->setDocuments(new \TYPO3\CMS\Extbase\Persistence\ObjectStorage());
            $offre->setTitle('plop');
            $ficheRepository->update($offre);
            $persistenceManager->persistAll();
        }

        return true;
    }

}
