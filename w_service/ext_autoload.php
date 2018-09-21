<?php

$extensionPath = t3lib_extMgm::extPath('w_service');
return array(

    'tx_wservice_scheduler_converttask' => $extensionPath . 'Classes/Scheduler/ConvertTask.php',
    'tx_wservice_scheduler_converttaskadditionalfieldprovider' => $extensionPath . 'Classes/Scheduler/ConvertTaskAdditionalFieldProvider.php',
    'tx_wservice_scheduler_cleartask' => $extensionPath . 'Classes/Scheduler/ClearTask.php'

);