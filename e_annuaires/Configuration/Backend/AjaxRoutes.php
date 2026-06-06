<?php

declare(strict_types=1);

use Emagineurs\EAnnuaires\Ajax\Conf;
use Emagineurs\EAnnuaires\Ajax\Offres;

/**
 * Definitions for AJAX routes provided by EXT:e_annuaires
 */
return [
	'eannuaires_conf' => [
		'path' => '/eannuaires/conf/main',
		'target' => Conf::class . '::main'
	],
	'eannuaires_offres' => [
		'path' => '/eannuaires/offres/main',
		'target' => Offres::class . '::main'
	],
];
