<?php

declare(strict_types=1);

namespace Emagineurs\EMagineurs\Hooks;

use TYPO3\CMS\Backend\Controller\Event\ModifyNewContentElementWizardItemsEvent;

/**
 * Filter content element wizard groups and items
 */
class WizardItemsFilter
{
    private const ALLOWED_GROUPS = [
        'carto',
        'default',
        'lists',
        'empl',
        'footer',
        'forms',
        'homepage',
        'menu',
        'onlinepayment',
        'plugins',
        'popup',
        'special',
        'stratisnewsletters',
        'container',
        'ext-powermail',
        'search',
        'annuaires',
        'news',
    ];

    private const GROUP_ORDER = [
        'carto',
        'default',
        'lists',
        'empl',
        'footer',
        'forms',
        'homepage',
        'menu',
        'onlinepayment',
        'plugins',
        'annuaires',
        'news',
        'ext-powermail',
        'search',
        'popup',
        'special',
        'stratisnewsletters',
        'container',
    ];

 
    private const ALLOWED_ITEMS_BY_GROUP = [
        'default' => [
            'header', 
            'textmedia', 
        ],
        'lists' => [
            'uploads', 
        ],
    ];

    /**
     * List of items to exclude from specific groups
     */
    private const EXCLUDED_ITEMS_BY_GROUP = [
        'plugins' => [
            'plugins_web2pdf_pi1',
            'plugins_ecalameopublisher_calameoplugin',
            'plugins_erssaggregator_aggregator',
            'plugins_dpnglossary_glossary',
            'plugins_dpnglossary_previewnewest',
            'plugins_dpnglossary_previewselected',
            'plugins_dpnglossary_previewrandom',
        ],
    ];

    /**
     * Filter wizard items using PSR-14 event
     *
     * @param ModifyNewContentElementWizardItemsEvent $event
     */
    public function filterWizardItems(ModifyNewContentElementWizardItemsEvent $event): void
    {
        $wizardItems = $event->getWizardItems();
        $filteredItems = [];
        $itemsByGroup = [];
        $currentGroup = '';
        $keepCurrentGroup = false;

        foreach ($wizardItems as $key => $item) {
            if (!is_array($item)) {
                continue;
            }

            if (isset($item['header'])) {
                $currentGroup = $key;
                $keepCurrentGroup = in_array($currentGroup, self::ALLOWED_GROUPS, true);
                
                if ($keepCurrentGroup) {
                    $filteredItems[$key] = $item;
                    
                    if ($currentGroup === 'container') {
                        $filteredItems[$key]['header'] = 'Éléments de grille';
                    }
                    
                    if (!isset($itemsByGroup[$currentGroup])) {
                        $itemsByGroup[$currentGroup] = [];
                    }
                } else {
                    $keepCurrentGroup = false;
                }
            } else {
                $groupIdentifier = '';
                $itemIdentifier = '';
                
                if (is_string($key) && strpos($key, '_') !== false) {
                    $parts = explode('_', $key);
                    if (!empty($parts[0])) {
                        $groupIdentifier = $parts[0];
                    }
                    if (count($parts) > 1) {
                        $itemIdentifier = end($parts);
                    }
                } else {
                    if (!empty($currentGroup) && $keepCurrentGroup) {
                        $groupIdentifier = $currentGroup;
                        $itemIdentifier = $key;
                    }
                }
                
                $itemGroup = '';
                if ($keepCurrentGroup && !empty($currentGroup)) {
                    $itemGroup = $currentGroup;
                    if (empty($itemIdentifier)) {
                        if (is_string($key) && strpos($key, '_') !== false) {
                            $parts = explode('_', $key);
                            if (count($parts) > 1) {
                                $itemIdentifier = end($parts);
                            }
                        } else {
                            $itemIdentifier = $key;
                        }
                    }
                } elseif (!empty($groupIdentifier)) {
                    $itemGroup = $groupIdentifier;
                }
                
                if (!empty($itemGroup) && in_array($itemGroup, self::ALLOWED_GROUPS, true)) {
                    if (isset(self::EXCLUDED_ITEMS_BY_GROUP[$itemGroup])) {
                        $isExcluded = false;
                        foreach (self::EXCLUDED_ITEMS_BY_GROUP[$itemGroup] as $excludedItem) {
                            if ($key === $excludedItem || strpos($key, $excludedItem) !== false) {
                                $isExcluded = true;
                                break;
                            }
                        }
                        if ($isExcluded) {
                            continue;
                        }
                    }
                    
                    if (isset(self::ALLOWED_ITEMS_BY_GROUP[$itemGroup])) {
                        $matches = false;
                        
                        if (!empty($itemIdentifier) && in_array($itemIdentifier, self::ALLOWED_ITEMS_BY_GROUP[$itemGroup], true)) {
                            $matches = true;
                        }
                        
                        if (!$matches && is_string($key) && in_array($key, self::ALLOWED_ITEMS_BY_GROUP[$itemGroup], true)) {
                            $matches = true;
                        }
                        
                        if (!$matches && is_string($key)) {
                            foreach (self::ALLOWED_ITEMS_BY_GROUP[$itemGroup] as $allowedItem) {
                                if (strpos($key, $allowedItem) !== false) {
                                    $matches = true;
                                    break;
                                }
                            }
                        }
                        
                        if (!$matches && isset($item['defaultValues']['CType'])) {
                            $cType = $item['defaultValues']['CType'];
                            if (in_array($cType, self::ALLOWED_ITEMS_BY_GROUP[$itemGroup], true)) {
                                $matches = true;
                            }
                        }
                        
                        if ($matches) {
                            $filteredItems[$key] = $item;
                            if (!isset($itemsByGroup[$itemGroup])) {
                                $itemsByGroup[$itemGroup] = [];
                            }
                            $itemsByGroup[$itemGroup][$key] = $item;
                        }
                    } else {
                        $filteredItems[$key] = $item;
                        if (!isset($itemsByGroup[$itemGroup])) {
                            $itemsByGroup[$itemGroup] = [];
                        }
                        $itemsByGroup[$itemGroup][$key] = $item;
                    }
                }
            }
        }

        $orderedItems = [];
        
        foreach (self::GROUP_ORDER as $groupKey) {
            if (isset($filteredItems[$groupKey])) {
                $orderedItems[$groupKey] = $filteredItems[$groupKey];
            }
            
            if (isset($itemsByGroup[$groupKey])) {
                foreach ($itemsByGroup[$groupKey] as $key => $item) {
                    $orderedItems[$key] = $item;
                }
            }
        }
        
        foreach ($filteredItems as $key => $item) {
            if (!isset($orderedItems[$key])) {
                $orderedItems[$key] = $item;
            }
        }

        $event->setWizardItems($orderedItems);
    }
}