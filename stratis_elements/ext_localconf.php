<?php
defined('TYPO3') || die;

call_user_func(function () {
    /**
     * Register as Content Provider
     */
    \FluidTYPO3\Flux\Core::registerProviderExtensionKey('Stratis.StratisElements', 'Content');

    $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['dumpFileUrl'] = \Stratis\StratisElements\Controller\FileDumpController::class . '::dumpAction';
    
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1638000000] = [
        'nodeName' => 'imageMapElement',
        'priority' => 40,
        'class' => \Stratis\StratisElements\Form\Element\ImageMapFormElementAdapter::class,
    ];
});
