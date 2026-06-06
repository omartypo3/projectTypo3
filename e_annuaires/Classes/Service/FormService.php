<?php

declare(strict_types=1);

namespace Emagineurs\EAnnuaires\Service;

use Emagineurs\EAnnuaires\Domain\Repository\Conf\TypeannuaireRepository;
use Emagineurs\EAnnuaires\Domain\Repository\Conf\ChampbddRepository;
use Emagineurs\EAnnuaires\Domain\Repository\FicheRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Service\MarkerBasedTemplateService;
use TYPO3\CMS\Extbase\Reflection\ClassSchema;
use TYPO3\CMS\Extbase\Reflection\ReflectionService;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

final class FormService
{
    protected TypeannuaireRepository $typeannuaireRepository;
    protected ChampbddRepository $champBddRepository;
    protected FicheRepository $ficheRepository;
    protected MarkerBasedTemplateService $markerService;
    protected ReflectionService $reflection;
    protected ?ClassSchema $modelSchema = null;
    protected bool $rte = false;

    public function __construct(
        TypeannuaireRepository $typeannuaireRepository,
        ChampbddRepository $champBddRepository,
        FicheRepository $ficheRepository,
        MarkerBasedTemplateService $markerService,
        ReflectionService $reflection
    ) {
        $this->typeannuaireRepository = $typeannuaireRepository;
        $this->champBddRepository = $champBddRepository;
        $this->ficheRepository = $ficheRepository;
        $this->markerService = $markerService;
        $this->reflection = $reflection;

        // Initialize modelSchema in constructor to avoid null reference errors
        $this->initializeModelSchema();
    }

    /**
     * Initialize model schema
     * Allow creation of submodel company
     */
    protected function initializeModelSchema(): void
    {
        $this->modelSchema = $this->reflection->getClassSchema(\Emagineurs\EAnnuaires\Domain\Model\Fiche::class);
    }

    /**
     * @deprecated Use initializeModelSchema() instead
     */
    public function initializeAction(): void
    {
        $this->initializeModelSchema();
    }

    public function generateFormTemplateAction(array $currentRequest): JsonResponse
    {
        $fields = $currentRequest ?? [];
        // La présence ou non de RTE dans le formulaire change les attributs de la balise form, on l'initialise donc a false
        // et on l'assigne après le parsing des champs (dans lequel se fera le changement de valeur si nécessaire).
        $this->rte = false;

        $fieldsContent = '';

        if (is_array($fields) && count($fields) > 0) {
            foreach ($fields as $field) {
                $tcaConfig = $GLOBALS['TCA']['tx_eannuaires_domain_model_fiche']['columns'][$field]['config'] ?? [];

                if (empty($tcaConfig)) {
                    continue;
                }

                try {
                    $templateField = $this->getTemplateField($tcaConfig, $field);
                    $fieldsContent .= $templateField;
                } catch (\Exception $e) {
                    // Log error instead of echo for better error handling
                    error_log('ECHEC de la génération du champ ' . $field . ' pour le template : ' . $e->getMessage());
                }
            }
        }

        if ($this->rte === true) {
            $formPath = GeneralUtility::getFileAbsFileName('EXT:e_annuaires/Resources/Private/Templates/Conf/Form/FormRte.html');
        } else {
            $formPath = GeneralUtility::getFileAbsFileName('EXT:e_annuaires/Resources/Private/Templates/Conf/Form/Form.html');
        }

        $formTemplate = file_get_contents($formPath);

        $contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $content = $contentObjectRenderer->wrap($fieldsContent, $formTemplate, '||');

        // Return JSON response


        return new JsonResponse([
            'message' => 'Le formulaire a bien été généré',
            'content' => $content,
        ]);
    }

    public function getTemplateField(array $tcaConfig, string $field): string
    {
        $type = $tcaConfig['type'] ?? '';

        if (empty($type)) {
            throw new \Exception('No TCA type defined for field: ' . $field);
        }

        $handler = 'get' . ucfirst($type) . 'Template';

        if (in_array($handler, get_class_methods($this))) {
            // Raté pour l'aspect Fluid 
            $view = $this->getFluidTemplate($type);

            // Dans les handlers on fait les assignations en fonction des conf TCA et model
            $template = $this->$handler($tcaConfig, $view, $field);

            return $template;
        } else {
            throw new \Exception('No handler is defined for this TCA type in class ' . __CLASS__);
        }
    }

    public function getFluidTemplate(string $type): string
    {
        $mainTemplate = GeneralUtility::getFileAbsFileName('EXT:e_annuaires/Resources/Private/Templates/Conf/Form/' . ucfirst($type) . '.html');
        $contentTemplate = file_get_contents($mainTemplate);

        $template = $this->markerService->getSubpart($contentTemplate, '###SUBPART_CURRENT_TCATYPE###');

        return $template;
    }

    public function getSelectTemplate(array $tcaConfig, string $view, string $field): string
    {
        $contentSubpart = '';
        $template = '';
        $currentSubpart = '';

        if ($this->modelSchema === null) {
            $this->initializeModelSchema();
        }

        $modelConfig = $this->modelSchema->getProperties();
        $modelConfigField = $modelConfig[$field] ?? null;

        $renderType = $tcaConfig['renderType'] ?? '';

        if ($renderType === 'selectSingle') {
            if ($modelConfigField && ($modelConfigField['type'] ?? '') === 'TYPO3\CMS\Extbase\Persistence\ObjectStorage') {
                $currentSubpart = 'single_storage';
            } else {
                $currentSubpart = 'single_raw';
            }
        } else {
            $currentSubpart = 'multiple_raw';
        }

        $markerArray = [
            '###FIELD###' => $field,
            '###UCF_FIELD###' => ucfirst($field)
        ];

        $template = $this->markerService->getSubpart($view, '###SUBPART_CURRENT_TCATYPE_' . strtoupper($currentSubpart) . '###');
        $contentSubpart = $this->markerService->substituteMarkerArray($template, $markerArray);

        return $contentSubpart;
    }

    public function getCheckTemplate(array $tcaConfig, string $view, string $field): string
    {
        $contentSubpart = '';
        $template = '';

        $currentSubpart = 'radio';

        $markerArray = [
            '###FIELD###' => $field
        ];

        $template = $this->markerService->getSubpart($view, '###SUBPART_CURRENT_TCATYPE_' . strtoupper($currentSubpart) . '###');
        $contentSubpart = $this->markerService->substituteMarkerArray($template, $markerArray);

        return $contentSubpart;
    }

    public function getInputTemplate(array $tcaConfig, string $view, string $field): string
    {
        $contentSubpart = '';
        $template = '';
        $date = false;

        if (!empty($tcaConfig['eval'])) {
            if (strpos($tcaConfig['eval'], 'date') !== false) {
                $date = true;
            }
        }

        $markerArray = [
            '###FIELD###' => $field
        ];

        if ($date === true) {
            $currentSubpart = 'date';
        } else {
            $currentSubpart = 'simple';
        }

        $template = $this->markerService->getSubpart($view, '###SUBPART_CURRENT_TCATYPE_' . strtoupper($currentSubpart) . '###');
        $contentSubpart = $this->markerService->substituteMarkerArray($template, $markerArray);

        return $contentSubpart;
    }

    public function getTextTemplate(array $tcaConfig, string $view, string $field): string
    {
        $contentSubpart = '';
        $template = '';

        if (!empty($tcaConfig['wizards'])) {
            if (array_key_exists('RTE', $tcaConfig['wizards'])) {
                $this->rte = true;
            }
        }

        $markerArray = [
            '###FIELD###' => $field
        ];

        if ($this->rte === true) {
            // Actuellement on ne sait pas faire fonctionner le RTE en front donc on se contente d'un textarea
            // $currentSubpart = 'withrte';
            $currentSubpart = 'withoutrte';
        } else {
            $currentSubpart = 'withoutrte';
        }

        $template = $this->markerService->getSubpart($view, '###SUBPART_CURRENT_TCATYPE_' . strtoupper($currentSubpart) . '###');
        $contentSubpart = $this->markerService->substituteMarkerArray($template, $markerArray);

        return $contentSubpart;
    }

    public function getGroupTemplate(array $tcaConfig, string $view, string $field): string
    {
        $contentSubpart = '';
        $template = '';
        return $contentSubpart;
    }

    public function getInlineTemplate(array $tcaConfig, string $view, string $field): string
    {
        if ($this->modelSchema === null) {
            $this->initializeModelSchema();
        }
        $modelConfig = $this->modelSchema->getProperties();
        $modelConfigField = $modelConfig[$field] ?? null;
        if ($modelConfigField !== null && method_exists($modelConfigField, 'getElementType')) {
            $elementType = $modelConfigField->getElementType();
        } else {
            $elementType = null;
        }
        if ($elementType === \Emagineurs\EAnnuaires\Domain\Model\Filereference::class) {
            $currentSubpart = 'image';
        } else {
            $currentSubpart = 'inline';
        }
        $markerArray = [
            '###FIELD###' => $field,
            '###UCF_FIELD###' => ucfirst($field)
        ];
        $template = $this->markerService->getSubpart($view, '###SUBPART_CURRENT_TCATYPE_' . strtoupper($currentSubpart) . '###');
        $contentSubpart = $this->markerService->substituteMarkerArray($template, $markerArray);
        return $contentSubpart;
    }
}
