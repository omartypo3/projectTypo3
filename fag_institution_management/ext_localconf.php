<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'FRONTAL.'.$_EXTKEY,
    'Directoryservices',
    array(
        'Institution' => 'list,show,specialShow',
        
    ),
    // non-cacheable actions
    array(
        'Institution' => 'list,show,specialShow',
        
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'FRONTAL.'.$_EXTKEY,
    'Peopleregister',
    array(
        'Institution' => 'listPeople',
        
    ),
    // non-cacheable actions
    array(
        'Institution' => 'listPeople',
        
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'FRONTAL.'.$_EXTKEY,
    'Citycouncil',
    array(
        'Institution' => 'listCitycouncil',
        
    ),
    // non-cacheable actions
    array(
        'Institution' => 'listCitycouncil',
        
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'FRONTAL.'.$_EXTKEY,
    'Onlineswitch',
    array(
        'Institution' => 'listLinks',
        
    ),
    // non-cacheable actions
    array(
        'Institution' => 'listLinks',
        
    )
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'FRONTAL.'.$_EXTKEY,
    'NextStepLogin',
    array(

        'Institution' => 'nextStep,edit,update,editUser,userUpdate,personen,addUser,termine,createEvent,deleteUser,updatePersonen,roleUpdate,linkUser,updateSorting',

    ),
    // non-cacheable actions
    array(
        'Institution' => 'nextStep,edit,update,editUser,userUpdate,personen,addUser,termine,createEvent,deleteUser,updatePersonen,roleUpdate,linkUser,updateSorting',

    )
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'FRONTAL.'.$_EXTKEY,
    'Terminal',
    array(
        'Event' => 'new, create ,edit , update ,delete ',
        'Dates' => 'list, show, new, create, edit, update, delete',
        'Institution' => 'nextStep,edit,update,editUser,userUpdate,personen,addUser,termine,createEvent,deleteUser,updatePersonen,roleUpdate,linkUser,updateSorting',

    ),
    // non-cacheable actions
    array(
        'Event' => 'new, create, edit , update,delete ',
        'Dates' => 'create, update, delete',
        'Institution' => 'nextStep,edit,update,editUser,userUpdate,personen,addUser,termine,createEvent,deleteUser,updatePersonen,roleUpdate,linkUser,updateSorting',


    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('FRONTAL\\FagInstitutionManagement\\Property\\TypeConverter\\UploadedFileReferenceConverter');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerTypeConverter('FRONTAL\\FagInstitutionManagement\\Property\\TypeConverter\\ObjectStorageConverter');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:fag_institution_management/Classes/Hooks/UserHook.php:FRONTAL\FagInstitutionManagement\Hooks\UserHook';

// Register the class to be available in 'eval' of TCA
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals']['FRONTAL\\FagInstitutionManagement\\Evaluation\\UniqueFrontendUserEvaluation'] = '';
