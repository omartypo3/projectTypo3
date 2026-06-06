<?php
defined('TYPO3') or die;

use Stratis\StratisSocialAuth\Domain\Model\Provider;

$LLL = 'LLL:EXT:stratis_social_auth/Resources/Private/Language/locallang_db.xlf:tx_stratissocialauth_domain_model_provider';

return [
    'ctrl' => [
        'title' => $LLL,
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'dividers2tabs' => true,
        'default_sortby' => 'ORDER BY title',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'hideTable' => true,
        'typeicon_column' => 'type',
        'typeicon_classes' => [
            'default' => 'stratis-socialauth-provider',
            Provider::FACEBOOK => 'stratis-socialauth-facebook',
            Provider::GOOGLE => 'stratis-socialauth-google',
            Provider::FRANCE_CONNECT => 'stratis-socialauth-franceconnect',
            Provider::PUBLIK => 'stratis-socialauth-publik',
        ],
    ],
    'columns' => [
        'title' => [
            'exclude' => true,
            'label' => $LLL . '.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => $LLL . '.hidden',
            'config' => [
                'type' => 'check',
                'default' => false,
            ],
        ],
        'type' => [
            'exclude' => true,
            'onChange' => 'reload',
            'label' => $LLL . '.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $LLL . '.type.I.' . Provider::FACEBOOK,
                        'value' => Provider::FACEBOOK,
                        'icon' => 'stratis-socialauth-facebook',
                    ],
                    [
                        'label' => $LLL . '.type.I.' . Provider::GOOGLE,
                        'value' => Provider::GOOGLE,
                        'icon' => 'stratis-socialauth-google',
                    ],
                    [
                        'label' => $LLL . '.type.I.' . Provider::FRANCE_CONNECT,
                        'value' => Provider::FRANCE_CONNECT,
                        'icon' => 'stratis-socialauth-franceconnect',
                    ],
                    [
                        'label' => $LLL . '.type.I.' . Provider::PUBLIK,
                        'value' => Provider::PUBLIK,
                        'icon' => 'stratis-socialauth-publik',
                    ],
                ],
            ],
        ],
        'key_id' => [
            'exclude' => true,
            'label' => $LLL . '.keyId',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'key_secret' => [
            'exclude' => true,
            'label' => $LLL . '.keySecret',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'open_id_url' => [
            'exclude' => true,
            'label' => $LLL . '.openIdUrl',
            'displayCond' => [
                'OR' => [
                    'FIELD:type:=:' . Provider::FRANCE_CONNECT,
                    'FIELD:type:=:' . Provider::PUBLIK,
                ],
            ],
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'scope' => [
            'exclude' => true,
            'label' => $LLL . '.scope',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'acr_values' => [
            'exclude' => true,
            'label' => $LLL . '.acr_values',
            'displayCond' => 'FIELD:type:=:' . Provider::FRANCE_CONNECT,
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $LLL . '.acr_values.eidas1',
                        'value' => 'eidas1',
                    ],
                    [
                        'label' => $LLL . '.acr_values.eidas2',
                        'value' => 'eidas2',
                    ],
                    [
                        'label' => $LLL . '.acr_values.eidas3',
                        'value' => 'eidas3',
                    ],
                ],
            ],
        ],
        'display' => [
            'exclude' => true,
            'label' => $LLL . '.display',
            'displayCond' => 'FIELD:type:=:' . Provider::FACEBOOK,
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $LLL . '.display.page',
                        'value' => 'page',
                        'icon' => 'stratis-socialauth-page',
                    ],
                    [
                        'label' => $LLL . '.display.popup',
                        'value' => 'popup',
                        'icon' => 'stratis-socialauth-popup',
                    ],
                ],
            ],
        ],
    ],
    'types' => [
        0 => [
            'showitem' => '--palette--;;paletteCore',
        ],
    ],
    'palettes' => [
        'paletteCore' => [
            'showitem' => 'title, hidden, --linebreak--, type, --linebreak--, key_id, --linebreak--, key_secret, --linebreak--, open_id_url, --linebreak--, scope,  --linebreak--, acr_values, --linebreak--, display',
            'canNotCollapse' => true
        ],
    ],
];
