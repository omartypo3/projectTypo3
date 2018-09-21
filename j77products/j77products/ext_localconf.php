<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'J77.J77products',
            'Maschine',
            [
                'Maschine' => 'teaser, detail',
                'Slider' => 'list',
                'Maschinenelemente' => 'list, show',
                'Download' => 'list, show',
                'Icon' => 'list, show',
                'WeitereAnforderungen' => 'list, show',
                'Prozessanlage' => 'list, show'
            ],
            // non-cacheable actions
            [
                'Maschine' => '',
                'Maschinenelemente' => '',
                'Download' => '',
                'Icon' => '',
                'WeitereAnforderungen' => '',
                'Prozessanlage' => ''
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'J77.J77products',
            'Prozessanlage',
            [
                'Prozessanlage' => 'list, show',
                'Slider' => 'list',
                'Maschine' => 'list, show, teaser, detail',
                'Maschinenelemente' => 'list, show',
                'Download' => 'list, show',
                'Icon' => 'list, show',
                'WeitereAnforderungen' => 'list, show'
            ],
            // non-cacheable actions
            [
                'Maschine' => '',
                'Maschinenelemente' => '',
                'Download' => '',
                'Icon' => '',
                'WeitereAnforderungen' => '',
                'Prozessanlage' => ''
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'J77.J77products',
            'Slider',
            [
                'Slider' => 'list',
                'Maschine' => 'list, show, teaser, detail',
                'Maschinenelemente' => 'list, show',
                'Download' => 'list, show',
                'Icon' => 'list, show',
                'WeitereAnforderungen' => 'list, show',
                'Prozessanlage' => 'list, show'
            ],
            // non-cacheable actions
            [
                'Maschine' => '',
                'Maschinenelemente' => '',
                'Download' => '',
                'Icon' => '',
                'WeitereAnforderungen' => '',
                'Prozessanlage' => ''
            ]
        );
        
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        $iconRegistry->registerIcon(
            'tx-iconmaschine',
             \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:j77products/Resources/Public/Icons/user_plugin_maschine.svg']
        );
        $iconRegistry->registerIcon(
            'tx-iconprozessanlage',
             \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:j77products/Resources/Public/Icons/user_plugin_prozessanlage.svg']
        );
        $iconRegistry->registerIcon(
            'tx-iconslider',
             \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:j77products/Resources/Public/Icons/user_plugin_slider.svg']
        );
      

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    maschine {
                        iconIdentifier = tx-iconmaschine
                        title = LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschine
                        description = LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_maschine.description
                        tt_content_defValues {
                            CType = list
                            list_type = j77products_maschine
                        }
                    }
                    prozessanlage {
                        iconIdentifier = tx-iconprozessanlage
                        title = LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_prozessanlage
                        description = LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_prozessanlage.description
                        tt_content_defValues {
                            CType = list
                            list_type = j77products_prozessanlage
                        }
                    }
                    slider {
                        iconIdentifier = tx-iconslider
                        title = LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_slider
                        description = LLL:EXT:j77products/Resources/Private/Language/locallang_db.xlf:tx_j77products_domain_model_slider.description
                        tt_content_defValues {
                            CType = list
                            list_type = j77products_slider
                        }
                    }
                }
                show = *
            }
       }'
    );
    
    
    }
);
