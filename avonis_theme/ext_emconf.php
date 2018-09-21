<?php

$EM_CONF[$_EXTKEY] = array (
	'title'            => 'Avonis Theme',
	'description'      => 'Provides Page Templates and individual settings for the Avonis Theme',
	'category'         => 'misc',
	'version'          => '0.8.4',
	'state'            => 'alpha',
	'uploadfolder'     => 0,
	'createDirs'       => '',
	'clearcacheonload' => 1,
	'author'           => 'Daniel Mross',
	'author_email'     => 'dm@avonis.com',
	'author_company'   => 'Avonis New Media - www.avonis.com',
	'constraints'      =>
	array (
		'depends'   =>
            array (
	            'typo3'        => '6.2.0-6.2.99',
	            'cms'          => '',
	            'fluidpages'   => '',
	            'fluidcontent' => '',
            ),
		'conflicts' =>
            array (
            ),
		'suggests'  =>
            array (
            ),
	),
);

