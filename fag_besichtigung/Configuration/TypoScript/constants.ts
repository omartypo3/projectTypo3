
plugin.tx_fagbesichtigung_besichtigung {
    view {
        # cat=plugin.tx_fagbesichtigung_besichtigung/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:fag_besichtigung/Resources/Private/Templates/
        # cat=plugin.tx_fagbesichtigung_besichtigung/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:fag_besichtigung/Resources/Private/Partials/
        # cat=plugin.tx_fagbesichtigung_besichtigung/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:fag_besichtigung/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_fagbesichtigung_besichtigung//a; type=string; label=Default storage PID
        storagePid =
    }
}
