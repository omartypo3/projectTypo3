<?php

declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Service;

use Solarium\QueryType\Update\RequestBuilder\Json;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Core\View\ViewFactoryData;

final class TypeService 
{
    protected $typeannuaireRepository;
    protected $champBddRepository;
    protected $ficheRepository;
    protected $registry;
    protected $listeChampsBdd;
    protected $currentField = [];
    protected $oldToNewTypeUid = [];
    protected ViewFactoryInterface $viewFactory;
    
    public function __construct(
        \Emagineurs\EAnnuaires\Domain\Repository\Conf\TypeannuaireRepository $typeannuaireRepository,
        \Emagineurs\EAnnuaires\Domain\Repository\Conf\ChampbddRepository $champBddRepository,
        \Emagineurs\EAnnuaires\Domain\Repository\FicheRepository $ficheRepository,
        ViewFactoryInterface $viewFactory
    ) {
        $this->typeannuaireRepository = $typeannuaireRepository;
        $this->champBddRepository = $champBddRepository;
        $this->ficheRepository = $ficheRepository;
        $this->viewFactory = $viewFactory;
    }



    public function initializeAction(): void
    {
        $this->registry = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Registry::class);
        $this->listeChampsBdd = $this->getListeChampsBdd();
    }

    /**
     * Summary of createType
     * @param string $newTypeName
     * @return JsonResponse
     */
  
    public function createType(string $newTypeName): JsonResponse
    {
        $newType = GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Conf\Typeannuaire::class);
        $newType->setPid(1);
        $newType->setTitle($newTypeName);
        $this->typeannuaireRepository->add($newType);

        $newField = GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Conf\Champbdd::class);
        $newField->setTitle('title');
        $newField->setPid(1);
        $newField->setSorting(0);
        $newField->setTypeannuaire($newType);

        $this->champBddRepository->add($newField);

        $this->typeannuaireRepository->publicPersistAll();
        $this->champBddRepository->publicPersistAll();

        $contentConf = $this->getContentConf($newType);

        $this->generateConf();

        return new JsonResponse([
            'contentConf' => $contentConf,
            'contentType' => '...', 
            'idType' => $newType->getUid()
        ]);
    }

    public function getContentConf($type)
    {
        $mainTemplate = GeneralUtility::getFileAbsFileName('EXT:e_annuaires/Resources/Private/Partials/Conf/Type.html');
        $viewFactoryData = new ViewFactoryData(templatePathAndFilename: $mainTemplate);
        $tmpView = $this->viewFactory->create($viewFactoryData);

        $tmpView->assign('type', $type);
        $tmpView->assign('ListeChampBdd', $this->listeChampsBdd);

        return $tmpView->render();
    }

    public function getListeChampsBdd()
    {
        // On récupère la liste des champs de la table des fiches annuaires
        $fieldListArray = array();
        $connection = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getConnectionForTable('tx_eannuaires_domain_model_fiche');
        $fieldListArrayBegin = $connection->createSchemaManager()->listTableColumns('tx_eannuaires_domain_model_fiche');

        // On exclut les tables dont on sait qu'elle ne seront pas utilsé dans le TCA
        $excludeFields = array(
            'uid',
            'pid',
            'cruser_id',
            'deleted',
            't3ver_oid',
            't3ver_id',
            't3ver_wsid',
            't3ver_label',
            't3ver_state',
            't3ver_stage',
            't3ver_count',
            't3ver_tstamp',
            't3ver_move_id',
            't3_origuid',
            'l10n_parent',
            'l10n_diffsource',
            'typeelement'
        );

        foreach ($fieldListArrayBegin as $field => $column) {
            if (!in_array($field, $excludeFields)) {
                $fieldListArray[$field]['title'] = $field;
                $fieldListArray[$field]['config'] = $GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns'][$field]['config'] ?? [];
            }
        }

        sort($fieldListArray);

        return $fieldListArray;
    }
  
    /**
     * Summary of deleteType
     * @param mixed $currentType
     * @return JsonResponse
     */
    public function deleteType(mixed $currentType): JsonResponse
    {
        $typeString = is_array($currentType) && isset($currentType['typeToDelete'])
            ? $currentType['typeToDelete']
            : (string)$currentType;

        $typeToDeleteInfoArray = GeneralUtility::trimExplode('-', $typeString);
        $typeToDeleteUid = $typeToDeleteInfoArray[1] ?? null;

        if (!$typeToDeleteUid) {
            return new JsonResponse(['deleteSuccess' => false, 'error' => 'Invalid type UID']);
        }

        $typeToDelete = $this->typeannuaireRepository->findByUid((int)$typeToDeleteUid);

        if ($typeToDelete) {
            $this->typeannuaireRepository->remove($typeToDelete);
            $this->typeannuaireRepository->publicPersistAll();
        }

        $checkType = $this->typeannuaireRepository->findByUid((int)$typeToDeleteUid);
        $deleteSuccess = $checkType === null;

        $this->generateConf();

       

        return new JsonResponse([
            'deleteSuccess' => $deleteSuccess,
            'typeUid' => $typeToDeleteUid
        ]);
    }

    /**
     * Summary of addNewFieldAction
     * @param array $newFieldData
     * @return JsonResponse
     */

    public function addNewFieldAction(array $newFieldData): JsonResponse
    {
        // Create a new field instance
        $newField = GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Domain\Model\Conf\Champbdd::class);

        // Set title and sorting
        $newField->setTitle(is_array($newFieldData['newFieldName'])
            ? $newFieldData['newFieldName'][0]
            : $newFieldData['newFieldName']);

        $newField->setSorting($newFieldData['sorting'] ?? 0);
        $newField->setPid(1);

        // Set type
        $type = $this->typeannuaireRepository->findByUid((int)($newFieldData['newFieldType'] ?? 0));
        $newField->setTypeannuaire($type);

        $this->champBddRepository->add($newField);
        $this->champBddRepository->publicPersistAll();

        // Check if added successfully
        $newFieldCheck = $this->champBddRepository->findByUid($newField->getUid());
        $success = $newFieldCheck !== null;

        $content = $success ? [
            'uid' => $newFieldCheck->getUid(),
            'title' => $newFieldCheck->getTitle(),
            'sorting' => $newFieldCheck->getSorting()
        ] : null;

        $this->generateConf();

        // Return JSON directly
        return new JsonResponse([
            'addNewField' => $content,
            'success' => $success
        ]);
    }

    /**
     * Summary of changeSortingAction
     * @param array $currentRequest
     * @return JsonResponse
     */

    public function changeSortingAction(array $currentRequest): JsonResponse
    {
        $lowSorting = (int)$currentRequest['lowSorting'];
        $highSorting = (int)$currentRequest['highSorting'];

        // Get corresponding records
        $fieldWithIncreasingSorting = $this->champBddRepository->findByUid($lowSorting);
        $fieldWithDecreasingSorting = $this->champBddRepository->findByUid($highSorting);

        if (!$fieldWithIncreasingSorting || !$fieldWithDecreasingSorting) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Champs introuvables'
            ]);
        }

        // Swap sorting values
        $highestSorting = $fieldWithDecreasingSorting->getSorting();
        $lowestSorting = $fieldWithIncreasingSorting->getSorting();

        $fieldWithIncreasingSorting->setSorting($highestSorting);
        $fieldWithDecreasingSorting->setSorting($lowestSorting);

        // Persist changes
        $this->champBddRepository->update($fieldWithIncreasingSorting);
        $this->champBddRepository->update($fieldWithDecreasingSorting);
        $this->champBddRepository->publicPersistAll();

        $this->generateConf();

        return new JsonResponse([
            'success' => true,
            'message' => 'Tri mis à jour avec succès'
        ]);
    }

    /**
     * Summary of deleteField
     * @param mixed $fieldData
     * @return JsonResponse
     */

    public function deleteField(mixed $fieldData): JsonResponse
    {
        $fieldUid = (int)($fieldData['fieldToDelete'] ?? 0);
        $fieldToDelete = $this->champBddRepository->findByUid($fieldUid);

        if (!$fieldToDelete) {
            return new JsonResponse([
                'success' => false,
                'fieldUid' => $fieldUid,
                'message' => 'Champ introuvable'
            ]);
        }

        // Get all fields for this type
        $fieldsToUpdate = $this->champBddRepository
            ->findByTypeannuaire($fieldToDelete->getTypeannuaire())
            ->toArray();

        // Remove the field
        $this->champBddRepository->remove($fieldToDelete);

        // Recalculate sorting
        foreach ($fieldsToUpdate as $field) {
            $newSorting = max(intval($field->getSorting()) - 1, 0);
            $field->setSorting($newSorting);
            $this->champBddRepository->update($field);
        }

        $this->champBddRepository->publicPersistAll();

        // Check deletion
        $deleted = $this->champBddRepository->findByUid($fieldUid) === null;

        $this->generateConf();

        return new JsonResponse([
            'success' => $deleted,
            'fieldUid' => $fieldUid,
            'message' => $deleted ? 'Champ supprimé' : 'La suppression du champ a échoué'
        ]);
    }

    /**
     * Summary of generateConf
     * @return array
     */

    public function generateConf(): array
    {
        $confArray = [];

        $listType = $this->typeannuaireRepository->findAll()->toArray();

        if (!empty($listType)) {
            foreach ($listType as $type) {
                $confArray['confAnnuaires'][$type->getUid()] = $this->generateConfArray($type->getUid());
            }
        }

        // Save to registry
        $extConfig = GeneralUtility::makeInstance(ExtensionConfiguration::class);
       
        $extConfig->set('e_annuaires', $confArray);

        return [
            'success' => !empty($confArray),
            'conf' => $confArray
        ];
    }

    /**
     * Summary of generateConfArray
     * @param mixed $type
     * @return array
     */

    public function generateConfArray($type)
    {
        if (intval($type) > 0) {
            $confTypeArray = array();

            $listChampType = $this->champBddRepository->selectConfType($type)->toArray();

            foreach ($listChampType as $champ) {
                $confTypeArray[$champ->getTitle() . '.'] = array(
                    'value' => $champ->getTitle(),
                    'sorting' => $champ->getSorting(),
                    'label' => $champ->getLabel(),
                    'newTab' => $champ->getTablabel()
                );
            }

            return $confTypeArray;
        }
    }

    public function updateLabelTab(array $updateArray, int $idType): array
    {
        $updatedFields = [];

        foreach ($updateArray as $inputField => $inputVal) {
            $infoInput = explode('-', $inputField); // [newLabel/newTab, uid]
            $uid = (int)($infoInput[1] ?? 0);

            if (!$uid) {
                continue;
            }

            $field = $this->champBddRepository->findByUid($uid);
            if (!$field) {
                continue;
            }

            if ($infoInput[0] === 'newLabel') {
                $field->setLabel($inputVal);
            } elseif ($infoInput[0] === 'newTab') {
                $field->setTablabel($inputVal);
            }

            $this->champBddRepository->update($field);
            $updatedFields[$uid] = $field;
        }

        // Save updates
        $this->champBddRepository->publicPersistAll();

        // Validation
        $valid = true;
        foreach ($updatedFields as $uid => $field) {
            if (
                $field->getLabel() !== ($updateArray["newLabel-$uid"] ?? $field->getLabel())
                || $field->getTablabel() !== ($updateArray["newTab-$uid"] ?? $field->getTablabel())
            ) {
                $valid = false;
            }
        }

        $this->generateConf();

        return [
            'success' => $valid,
            'message' => $valid
                ? 'Les labels ont bien été sauvegardé.'
                : 'La sauvegarde des labels a échoué',
            'idType' => $idType
        ];
    }


    private function arrayToXml(array $data, string $root = 'root', \XMLWriter $xml = null): string
{
    $isRoot = false;

    if ($xml === null) {
        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement($root);
        $isRoot = true;
    }

    foreach ($data as $key => $value) {
        $tag = preg_match('/^[A-Za-z_][A-Za-z0-9_-]*$/', (string)$key) ? (string)$key : 'item';

        if (is_array($value)) {
            $xml->startElement($tag);
            $this->arrayToXml($value, $root, $xml);
            $xml->endElement();
        } else {
            $xml->writeElement($tag, (string)$value);
        }
    }

    if ($isRoot) {
        $xml->endElement();
        $xml->endDocument();
    }

    return $xml->outputMemory();
}



}
