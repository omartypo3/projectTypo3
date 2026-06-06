<?php
namespace Emagineurs\EMagineurs\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Xavier Ley <xley@e-magineurs.com>
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
 *
 *
 * @package e_magineurs
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */

use TYPO3\CMS\Core\Utility\GeneralUtility ;

class Eannuaires extends \Emagineurs\EAnnuaires\Controller\EditfeController
{
    const SIGNAL_PreFileAdd = 'preFileAdd';
    const SIGNAL_PostFileAdd = 'postFileAdd';

    public function addDocumentToCandidature($fiche, $parent) {
		if(!empty($_FILES['documents']['name'])){
            // On ajoute le fichier dans FAL et on créé une reference
            $file = \Emagineurs\EAnnuaires\Utility\FileUtility::generateFile($_FILES['documents']);
             
            $fileRef = GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Filereference::class);
            $filerefObjStorage = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
                        
            $originalResource = \Emagineurs\EAnnuaires\Utility\FileUtility::createFileReference($file);
            
            $fileRef->setOriginalResource($originalResource);
            $fileRef->setTableLocal('sys_file');
            $fileRef->setShowinpreview(TRUE);
            
            $filerefObjStorage->attach($fileRef);
                            
            $document = GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Documents::class);
            
            // On associe la reference créée au document
            $document->setFichier($filerefObjStorage);
            
            // On set le pid
            $document->setPid($parent->settings['editFe']['defaultValues']['pid']);
            
            // On crée en base de données l'enregistrement correspondant à l'objet de l'inline courant
            $repoDocument = GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Repository\DocumentsRepository::class);
            $repoDocument->add($document);
                    
            $persistenceManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
            $persistenceManager->persistAll();
            
            // On l'ajoute ensuite à la fiche annuaire en cours de création
            $objStorage = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
            $objStorage->attach($document);
            $fiche->setDocuments($objStorage);
        }
	}

}
