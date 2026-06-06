<?php

declare(strict_types=1);

use DslFactory\DslImmo\Command\ImportCommand;
use DslFactory\DslImmo\Command\ImportIvmCommand;

return [
    'dslImmo:import' => [
        'class' => ImportCommand::class,
        'schedulable' => true,
    ],
    'dslImmo:importIvm' => [
        'class' => ImportIvmCommand::class,
        'schedulable' => true,
    ],
];
