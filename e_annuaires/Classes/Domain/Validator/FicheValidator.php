<?php
namespace Emagineurs\EAnnuaires\Domain\Validator;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 xley <xley@e-magineurs.com>
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
 
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Reflection\ReflectionService;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
 
/**
 *
 *
 * @package e_annuaires
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class FicheValidator extends AbstractValidator {

    /**
	 * @var ConfigurationManagerInterface
	 */
	protected $configurationManager;
	
    /**
	 * @var ReflectionService
	 */
	protected $reflection;
	
    /**
	 * Tell if an error has occurred
	 *
	 * @var bool
	 */
	protected $valid = true;

	/**
	 * @var array
	 */
	protected $ficheModelSchema = [];

	/**
	 * @var array
	 */
	protected $schema = [];

	/**
	 * Constructor for dependency injection
	 */
	public function __construct(
		ConfigurationManagerInterface $configurationManager,
		ReflectionService $reflection
	) {
		$this->configurationManager = $configurationManager;
		$this->reflection = $reflection;
	}

        // First we get the settings for the current action
	public function isValid(mixed $value): void
	{
        $settings = $this->configurationManager
            ->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);

		// We get the reflection datas
        $this->ficheModelSchema = $this->reflection
            ->getClassSchema('Emagineurs\EAnnuaires\Domain\Model\Fiche')
            ->getProperties();


		// The validation is only here for the create action of the editFe controller, so we check if we are using the form
        // note: Shouldn't be necessary but errors are displayed even in the edit action
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
        $parsedBody = $request ? $request->getParsedBody() : [];
        if ($parsedBody['tx_eannuaires_pi1'] ?? false) {
            $validation = $settings['editFe']['validate'][$settings['editFe']['defaultValues']['typeelement']];

			// If there is a configuration for the validation, we start applying it
            if (is_array($validation) && !empty($validation)) {
				// We check each property configured
                foreach ($validation as $field => $criterias) {
                    if (is_array($criterias) && !empty($criterias)) {
						// We check every criterias that has been set for the current field
                        foreach ($criterias as $criteria => $criteriaValue) {
                            $this->checkCriteria($field, $criteria, $criteriaValue);
                        }
                    }
                }
            }
        }
		// Delete the uploaded file if the whole form is not valid
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
        if ($request instanceof \Psr\Http\Message\ServerRequestInterface) {
            $feUser = $request->getAttribute('frontend.user');
            
            if (!($this->valid) && $feUser !== null) {
                $sessionValue = $feUser->getKey('ses', 'LM');
                if (isset($sessionValue['name'])) {
                    $publicPath = \TYPO3\CMS\Core\Core\Environment::getPublicPath();
                    $filePath = $publicPath . '/fileadmin' . $sessionValue['name'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
            }
        }
            }
            
            if ($feUser !== null) {
                $feUser->removeSessionData();
            }
        }
	}

	/**
	 * Handle the validation
	 *
	 * @param string $field
	 * @param string $criteria
	 * @param mixed $value
	 * @return void
	 */
	public function checkCriteria($field, $criteria, $value): void {
		if($criteria == 'field'){
			 $this->checkRelatedObjCriteria($field, $criteria, $value);
		} else {
			$this->checkCurrentObjCriteria($field, $criteria, $value);
		}
	}

	/**
	 * Handle the validation
	 *
	 * @param string $field
	 * @param string $criteria
	 * @param mixed $value
	 * @return void
	 */
	public function checkRelatedObjCriteria($field, $criteria, $value): void {
		foreach ($value as $relatedField => $propertyArray) {
			foreach ($propertyArray as $criteria => $value) {
				$this->checkCurrentObjCriteria($field, $criteria, $value, $relatedField);
			}
		}
	} 

	/**
	 * Handle the validation
	 *
	 * @param string $field
	 * @param string $criteria
	 * @param mixed $value
 	 * @param string $relatedField
     */
	public function checkCurrentObjCriteria($field, $criteria, $value, $relatedField = NULL) {
		$criteriaHandlerMethod = 'check'.ucFirst($criteria).'Validation';
        $this->$criteriaHandlerMethod($field, $value, $relatedField);
	} 

	/**
	 * Validate the file size
	 *
	 * @param string $field
	 * @param mixed $value
	 * @param mixed $relatedField
     * @return void
	 */
	public function checkMaxSizeValidation($field, $value, $relatedField) {

		if ($relatedField !== NULL) {
			$this->schema = $this->reflection->getClassSchema('Emagineurs\EAnnuaires\Domain\Model\\'.ucwords($field))
											 ->getProperties();
			if($this->schema[$relatedField]['elementType'] == 'Emagineurs\EAnnuaires\Domain\Model\Filereference') {

				$size = $_FILES[$field]['size'];
				$maxValue = intval($value) * 1024 * 1024;

				if($size > $maxValue) {
					$this->addError('La taille du fichier du CV ne doit pas dépasser '.$value.' MB' , 1501684472);
					$this->valid = false;
				}
			} else {
				throw new \Exception (
					'The validation "maxSize" cannot be applied to the field "'.$field.'". The field should be 
					using Emagineurs\EAnnuaires\Domain\Model\Filereference inside an objectStorage the model.',
					1501768900
				);
			}
		} else {
		
			if($this->ficheModelSchema[$field]['elementType'] == 'Emagineurs\EAnnuaires\Domain\Model\Filereference') {
				$fileField = $field.'instancier';
				$fileSizeArray = $_FILES['tx_eannuaires_pi1']['size']['fiche'][$fileField];
				
				foreach($fileSizeArray as $subField => $size) {
					$fileSize = $size;
				}
				
				$maxValue = intval($value) * 1024 * 1024;

				if($fileSize > $maxValue) {
                    $this->addError('La taille du fichier de la lettre de motivation ne doit pas dépasser 
                    '.$value.' MB' , 1501684472);
                    $this->valid = false;
				}
			} else {
				throw new \Exception (
					'The validation "maxSize" cannot be applied to the field "'.$field.'". The field should be 
					using Emagineurs\EAnnuaires\Domain\Model\Filereference inside an objectStorage the model.',
					1501768900
				);
			}
		}

	}

	/**
	 * Handle the extension file
	 *
	 * @param string $field
	 * @param mixed $value
     * @param mixed $relatedField
	 * @return void
	 */
	public function checkExtensionsValidation($field, $value, $relatedField): void {
        if ($relatedField !== NULL) {
            if (!empty($_FILES[$field]['name'])) {
                $this->schema = $this->reflection->getClassSchema('Emagineurs\EAnnuaires\Domain\Model\\' . ucwords($field))
                    ->getProperties();
                if ($this->schema[$relatedField]['elementType'] == 'Emagineurs\EAnnuaires\Domain\Model\Filereference') {

                    $fileType = $_FILES[$field]['name'];
                    $valueArray = explode(',', $value);
                    $this->valid = false;
                    foreach ($valueArray as $valueExt) {
                        if (explode('.', $fileType)[1] === trim($valueExt)) {
                            $this->valid = true;
                        }
                    }
                    if (!($this->valid)) {
                        $this->addError('Extensions autorisées pour le CV : pdf, doc ou docx.', 1504699319);
                    }
                } else {
                    throw new \Exception (
                        'The validation "maxSize" cannot be applied to the field "' . $field . '". The field should be
                     using Emagineurs\EAnnuaires\Domain\Model\Filereference inside an objectStorage the model.',
                        1501768900
                    );
                }
            }
        } else {
            if ($this->ficheModelSchema[$field]['elementType'] == 'Emagineurs\EAnnuaires\Domain\Model\Filereference') {
                $fileField = $field . 'instancier';
                if(!empty($_FILES['tx_eannuaires_pi1']['name']['fiche'][$fileField]['file-2']['name'])) {
                    $fileTypeArray = $_FILES['tx_eannuaires_pi1']['name']['fiche'][$fileField];
                    $valueArray = explode(',', $value);
                    $this->valid = false;
                    foreach ($fileTypeArray as $fileType) {
                        foreach ($valueArray as $valueExt) {
                            if (explode('.', $fileType)[1] === trim($valueExt)) {
                                $this->valid = true;
                            }
                        }
                    }
                    if (!($this->valid)) {
                        $this->addError('Extensions autorisées pour la lettre de motivation : pdf, doc ou docx.',
                            1504699319);
                    }
                }
            } else {
                throw new \Exception (
                    'The validation "maxSize" cannot be applied to the field "' . $field . '". The field should be 
                     using Emagineurs\EAnnuaires\Domain\Model\Filereference inside an objectStorage the model.',
                    1501768900
                );
            }
        }
	}
}