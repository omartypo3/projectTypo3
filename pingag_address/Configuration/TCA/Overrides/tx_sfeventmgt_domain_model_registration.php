<?php

$registrationcolumns = [
    'bill' => [
        'exclude' => true,
        'label' => 'Rechnungsadresse',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'Rechnung an meine Privatadresse',
                    'p',
                ],
                [
                    'Rechnung an die Adresse des Arbeitgebers',
                    'c',
                ],
            ],
            'size' => 1,
            'maxitems' => 1,
        ],
    ],
    /*'acompany' => [
        'exclude' => true,
        'label' => 'LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:tx_sfeventmgt_domain_model_registration.company',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
    ],*/
    'aaddress' => [
        'exclude' => true,
        'label' => 'Firma Anschrift',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
    ],
    'azip' => [
        'exclude' => true,
        'label' => 'Firma PLZ',
        'config' => [
            'type' => 'input',
            'size' => 4,
        ],
    ],
    'acity' => [
        'exclude' => true,
        'label' => 'Firma Stadt',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
    ],
    'aphone' => [
        'exclude' => true,
        'label' => 'Firma Telefon',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
    ],
    'aemail' => [
        'exclude' => true,
        'label' => 'Firma E-Mail',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'email,trim,required',
        ],
    ],
    'ajob' => [
        'exclude' => true,
        'label' => 'Tätigkeit',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
    ],
    'documents' => [
        'exclude' => true,
        'label' => 'Bitte schicken Sie mir alle Unterlagen zu diesem Kurs an die',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'Privatadresse inkl. E-Mail',
                    'p',
                ],
                [
                    'Arbeitsadresse inkl. E-Mail',
                    'c',
                ],
            ],
            'size' => 1,
            'maxitems' => 1,
        ],
    ],
    'situation' => [
        'exclude' => true,
        'label' => 'Weiteres',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'Ich bin sehend',
                    's',
                ],
                [
                    'Ich bin sehbehindert / blind',
                    'b',
                ],
                [
                    'Ich bin hörbehindert',
                    'h',
                ],
            ],
            'size' => 1,
            'maxitems' => 1,
        ],
    ],
    'newsletter' => [
        'exclude' => true,
        'label' => 'Newsletter',
        'config' => [
            'type' => 'check',
            'default' => 0,
        ],
    ],
    'personaldata' => [
        'exclude' => true,
        'label' => 'personal data consent accepted ',
        'config' => [
            'type' => 'check',
            'default' => 0,
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_sfeventmgt_domain_model_registration',$registrationcolumns);
$GLOBALS['TCA']['tx_sfeventmgt_domain_model_registration']['types'] =[
    '1' => [
        'showitem' => '
            --palette--;;paletteGenderTitle,
            --palette--;;paletteName,
            company,
            --palette--;;paletteAddress,
            country, phone, email, date_of_birth, accepttc, notes, registration_date, bill, aaddress, azip,
            acity, aphone, aemail, ajob, documents, situation, newsletter,personaldata,

            --div--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:event.tabs.additional,
                fe_user, confirmation_until, confirmed, ignore_notifications, amount_of_registrations,
                waitlist, main_registration,

            --div--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:event.tabs.registration_fields,
                field_values,

            --div--;LLL:EXT:sf_event_mgt/Resources/Private/Language/locallang_db.xlf:registration.tabs.payment,
                paid, paymentmethod, payment_reference,

            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                hidden,--palette--;;timeRestriction',
    ],
];