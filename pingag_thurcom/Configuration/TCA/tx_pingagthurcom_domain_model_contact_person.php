<?php


$helper = new \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper(

    'tx_pingagthurcom_domain_model_contact_person',
    [
        'default' => "--palette--;;name, --palette--;Kontaktinformationen;contact, position, image",
    ]
);

$defaultFields = 'firstname, lastname, email, position';

return array(

    'ctrl' => array(
        'title' => $helper->trans('entity_title'),
        'label' => 'firstname',
        'label_alt' => 'lastname',
        'thumbnail' => 'image',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ),
        'sortby' => 'sorting',
        'searchFields' => $defaultFields,
        'iconfile' => $helper->getIconPath(),
    ),
    'interface' => \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper::getInterfaceConfig($helper->getInterfaceFields()),
    'types' => \Pingag\PingagThurcom\Configuration\TCA\TCAConfigHelper::getTypesConfig($helper->getTypesFields()),
    'palettes' => array(
        'name' => array('showitem' => "firstname, lastname"),
        'contact' => array('showitem' => "email, telephone"),
    ),

    'columns' => $helper->getDefaultColumnsConfig(
        array(
            // FIELDS START
            'firstname' => $helper->getInputColumnsConfig('firstname'),
            'lastname' => $helper->getInputColumnsConfig('lastname'),
            'position' => $helper->getInputColumnsConfig('position', false),
            'email' => $helper->getInputColumnsConfig('email', false),
            'telephone' => $helper->getInputColumnsConfig('telephone'),
            'image' => $helper->getFalMediaColumnConfig('image', 'image', 'png, jpg, jpeg'),
            // FIELDS END
        )
    ),

);