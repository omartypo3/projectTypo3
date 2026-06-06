<?php
defined('TYPO3') or die;

call_user_func(
    function () {
        // Add extension as provider for Content elements (BE)
        \FluidTYPO3\Flux\Core::registerProviderExtensionKey('Stratis.StratisNewsletter', 'Page');
        \FluidTYPO3\Flux\Core::registerProviderExtensionKey('Stratis.StratisNewsletter', 'Content');
    }
);
