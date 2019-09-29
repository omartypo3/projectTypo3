
plugin.tx_contactform_fecontactform {
    view {
        # cat=plugin.tx_contactform_fecontactform/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:contact_form/Resources/Private/Templates/
        # cat=plugin.tx_contactform_fecontactform/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:contact_form/Resources/Private/Partials/
        # cat=plugin.tx_contactform_fecontactform/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:contact_form/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_contactform_fecontactform//a; type=string; label=Default storage PID
        storagePid =
    }
}
styles.content.loginform.templateFile = typo3conf/ext/contact_form/Resources/Private/Templates/FrontendLogin.html
plugin.tx_contactform_feevents {
    view {
        # cat=plugin.tx_contactform_feevents/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:contact_form/Resources/Private/Templates/
        # cat=plugin.tx_contactform_feevents/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:contact_form/Resources/Private/Partials/
        # cat=plugin.tx_contactform_feevents/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:contact_form/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_contactform_feevents//a; type=string; label=Default storage PID
        storagePid =
    }
}
