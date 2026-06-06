<?php

declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Ajax;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Registry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Emagineurs\EAnnuaires\Domain\Repository\Conf\TypeannuaireRepository;
use Emagineurs\EAnnuaires\Domain\Repository\Conf\ChampbddRepository;
use Emagineurs\EAnnuaires\Service\FormService;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Core\View\ViewFactoryData;
use Psr\Container\ContainerInterface;
use Emagineurs\EAnnuaires\Service\TypeService;

class Conf
{
	protected Registry $registry;
	protected ChampbddRepository $champBddRepository;
	protected TypeannuaireRepository $typeannuaireRepository;

	protected TypeService $typeService;

	protected FormService $formService;

	protected ViewFactoryInterface $viewFactory;

	public function __construct(
		Registry $registry,
		ChampbddRepository $champBddRepository,
		TypeannuaireRepository $typeannuaireRepository,
		TypeService $typeService,
		FormService $formService,
		ViewFactoryInterface $viewFactory
	) {
		$this->registry = $registry;
		$this->champBddRepository = $champBddRepository;
		$this->typeannuaireRepository = $typeannuaireRepository;
		$this->typeService = $typeService;
		$this->formService = $formService;
		$this->viewFactory = $viewFactory;
	}

	protected function getChampBddRepository(): ChampbddRepository
	{
		return $this->champBddRepository;
	}

	protected function getTypeannuaireRepository(): TypeannuaireRepository
	{
		return $this->typeannuaireRepository;
	}

	public function main($request = null)
	{
		if ($request instanceof ServerRequestInterface) {
			$parsedBody = $request->getParsedBody();
			$isAjaxRoute = true;
		} else {
			$parsedBody = $_POST;
			$isAjaxRoute = false;
		}

		$typeReq = $parsedBody['type'] ?? '';
		$conf = [];

		if (is_array($parsedBody['request'] ?? null) && !empty($parsedBody['request'])) {
			foreach ($parsedBody['request'] as $param => $value) {
				$conf['arguments'][$param] = $value;
			}
		}

		$method = 'handle' . ucFirst($typeReq);

		if (in_array($method, get_class_methods($this), true)) {
			try {
				$result = $this->$method($conf);
			} catch (\Exception $e) {
				$result = [
					'error' => 'Exception in method: ' . $method,
					'message' => $e->getMessage(),
					'trace' => $e->getTraceAsString()
				];
			}
		} else {
			$result = [
				'error' => 'Method not found: ' . $method,
				'method' => $method,
				'type' => $typeReq,
				'available_methods' => array_filter(get_class_methods($this), function ($m) {
					return strpos($m, 'handle') === 0;
				}),
				'parsedBody' => $parsedBody
			];
		}

		if (!$isAjaxRoute) {
			header('Content-Type: application/json');
			echo json_encode($result ?? []);
			exit;
		}

		return new JsonResponse($result ?? []);
	}

	public function handleSaveLocallang($conf)
	{
		$message = ($this->saveLocallang($conf['arguments']['locallangPath'])) ? 'Le chemin du locallang a bien été enregistré' : 'L\'enregistrement du chemin a echoué';
		$result = array(
			'message' => $message
		);

		return $result;
	}

	public function handleSaveNewType(array $conf): array
	{
		$data = $this->saveNewType($conf['arguments']['newTypeName']);

		// Optional: save to BE_USER session if needed
		$GLOBALS['BE_USER']->setAndSaveSessionData('tx_eannuaires', $data);

		$message = ($data['contentConf'] && $data['contentType']) ? 0 : "L'enregistrement du type a échoué";

		return [
			'message' => $message,
			'contentType' => $data['contentType'] ?? null,
			'contentConf' => $data['contentConf'] ?? null,
			'idType' => $data['idType'] ?? null		];
	}

	public function handleDeleteType($conf): array
	{
		$data = $this->deleteType($conf['arguments']['typeToDelete']);

		$message = ($data['deleteSuccess']) ? 0 : 'La suppression du type a échoué';

		return [
			'message' => $message,
			'typeToDelete' => $conf['arguments']['typeToDelete']
		];
	}

	public function handleGenerateDetailConf($conf)
	{
		try {
			$idTypeInfoArray = GeneralUtility::trimExplode('-', $conf['arguments']['idType']);
			$idType = (int)$idTypeInfoArray[1];
			$source = $conf['arguments']['source'] ?? 'tca';

			if ($idType > 0) {
				$selectedFields = $this->getChampBddRepository()->selectConfType($idType);

				$templatePath = GeneralUtility::getFileAbsFileName('EXT:e_annuaires/Resources/Private/Templates/Conf/Conf/GenerateDetailConf.html');
				$viewFactoryData = new ViewFactoryData(
					templatePathAndFilename: $templatePath
				);
				$view = $this->viewFactory->create($viewFactoryData);
				$view->assign('selectedFields', $selectedFields);
				$view->assign('source', $source);

				$content = $view->render();
			} else {
				$content = 'Aucun type d\'annuaire n\'a été sélectionné';
			}

			$result = array(
				'content' => $content,
				'idType' => $conf['arguments']['idType']
			);
		} catch (\Exception $e) {
			$result = array(
				'content' => 'Erreur: ' . $e->getMessage(),
				'idType' => $conf['arguments']['idType'] ?? ''
			);
		}

		return $result;
	}

	public function handleAddNewField(array $conf): array
	{
		// Ensure newFieldName is a string
		$newFieldName = is_array($conf['arguments']['newFieldName'])
			? $conf['arguments']['newFieldName'][0]
			: $conf['arguments']['newFieldName'];

		$data = $this->addNewField(
			$newFieldName,
			(int)$conf['arguments']['newFieldType'],
			(int)$conf['arguments']['sorting']
		);

		$success = $data['success'] ?? false;
		$content = $success ? $data['addNewField'] : "L'ajout du champ a échoué";

		return [
			'content' => $content,
			'idType' => (int)$conf['arguments']['newFieldType'],
			'success' => $success
		];
	}

	public function handleChangeSorting(array $conf): array
	{
		// Call the Service directly
		$response = $this->typeService->changeSortingAction([
			'lowSorting' => (int)$conf['arguments']['lowSorting'],
			'highSorting' => (int)$conf['arguments']['highSorting']
		]);

		// Decode the JsonResponse
		$data = json_decode($response->getBody()->__toString(), true);

		return [
			'success' => $data['success'] ?? false,
			'message' => $data['message'] ?? 'Erreur pendant le tri'
		];
	}

	public function handleDeleteField(array $conf): array
	{
		$fieldId = $conf['arguments']['fieldToDelete'] ?? 0;

		$data = $this->deleteField((int)$fieldId);

		return [
			'success' => $data['success'] ?? false,
			'idField' => $data['fieldUid'] ?? null,
			'message' => $data['message'] ?? 'La suppression du champ a échoué'
		];
	}

	public function handleUpdateLabelTab(array $conf): array
	{
		$data = $this->updateLabelTab(
			$conf['arguments']['updateArray'],
			(int)$conf['arguments']['idType']
		);

		return [
			'success' => $data['success'],
			'content' => $data['message'],
			'idType' => $data['idType']
		];
	}

	public function handleGetTcaConf($conf)
	{
		$fieldName = $conf['arguments']['fieldName'] ?? '';

		if (!empty($fieldName) && isset($GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns'][$fieldName])) {
			$tcaConf = $GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns'][$fieldName]['config'];

			ob_start();
			\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($tcaConf, $fieldName);
			$content = ob_get_contents();
			ob_end_clean();
		} else {
			$content = 'Champ "' . htmlspecialchars($fieldName) . '" non trouvé dans TCA';
		}

		$result = array(
			'content' => $content,
			'idSelect' => $conf['arguments']['idSelect']
		);

		return $result;
	}

	public function handleGenerateConf(array $conf): array
	{
		$data = $this->generateConf();

		return [
			'success' => $data['success'],
			'content' => $data['success']
				? 'La conf a bien été générée'
				: 'La génération de la conf a échoué'
		];
	}


	public function handleGenerateFormTemplate($conf)
	{

		$jsonResponse = $this->formService->generateFormTemplateAction($conf['arguments']['arrayFields']);

		// Decode and return directly
		$data = json_decode($jsonResponse->getBody()->__toString(), true);

		return $data;
	}

	public function saveLocallang($locallangPath)
	{
		// On récupère la conf depuis la table des registres
		$conf = $this->registry->set('tx_eannuaires', 'locallangPath', $locallangPath);

		return true;
	}

	public function saveNewType(string $newTypeName): array
	{
		$response = $this->typeService->createType($newTypeName); // JsonResponse
		$data = json_decode($response->getBody()->__toString(), true);

		return $data;
	}

	public function deleteType($typeToDelete): array
	{
		// Call the service
		$response = $this->typeService->deleteType($typeToDelete);

		// Decode JSON body to array
		$data = json_decode($response->getBody()->__toString(), true);

		return $data; // ['deleteSuccess' => true/false, 'typeUid' => ...]
	}

	public function generateDetailConf($conf)
	{
		$args = array();
		$args = $conf;

		$this->execControllerAction('generateDetailConf', $args);
	}

	public function addNewField(string $newFieldName, int $newFieldType, int $sorting): array
	{
		// Call the service
		$response = $this->typeService->addNewFieldAction([
			'newFieldName' => [$newFieldName], // service expects an array
			'newFieldType' => $newFieldType,
			'sorting' => $sorting
		]);

		// Decode the JsonResponse body to array
		return json_decode($response->getBody()->__toString(), true);
	}


	public function deleteField(int $fieldToDelete): array
	{
		// Call the service
		$response = $this->typeService->deleteField([
			'fieldToDelete' => $fieldToDelete
		]);

		// Decode JSON body once
		return json_decode($response->getBody()->getContents(), true);
	}


	public function updateLabelTab(array $updateArray, int $idType): array
	{
		return $this->typeService->updateLabelTab($updateArray, $idType);
	}


	public function getTcaConf($fieldName)
	{
		$args = array(
			'fieldName' => $fieldName
		);

		$this->execControllerAction('getTcaConf', $args);
	}

	public function generateConf()
	{
		return $this->typeService->generateConf();
	}

	// public function generateFormTemplate($conf){
	// 	$this->execControllerAction('generateFormTemplate',$conf,'Conf\Form');
	// }

	public function execControllerAction($action, $args, $controller = 'Conf\Conf')
	{
		$conf['vendor'] = 'Emagineurs';
		$conf['extensionName'] = 'EAnnuaires';
		$conf['pluginName'] = 'annuaires';
		$conf['controller'] = $controller;

		$conf['action'] = $action;
		$conf['arguments'] = $args;

		$contentObj = GeneralUtility::makeInstance(\Emagineurs\EAnnuaires\Utility\AbstractLib::class);
		$content = $contentObj->callExtbaseAction($conf);
		// return $content;
	}
}