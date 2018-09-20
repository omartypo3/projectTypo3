
plugin.tx_j77products_maschine {
    view {
        # cat=plugin.tx_j77products_maschine/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:j77products/Resources/Private/Templates/
        # cat=plugin.tx_j77products_maschine/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:j77products/Resources/Private/Partials/
        # cat=plugin.tx_j77products_maschine/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:j77products/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_j77products_maschine//a; type=string; label=Default storage PID
        storagePid =
    }
}

plugin.tx_j77products_prozessanlage {
    view {
        # cat=plugin.tx_j77products_prozessanlage/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:j77products/Resources/Private/Templates/
        # cat=plugin.tx_j77products_prozessanlage/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:j77products/Resources/Private/Partials/
        # cat=plugin.tx_j77products_prozessanlage/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:j77products/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_j77products_prozessanlage//a; type=string; label=Default storage PID
        storagePid =
    }
}

plugin.tx_j77products_slider {
    view {
        # cat=plugin.tx_j77products_slider/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:j77products/Resources/Private/Templates/
        # cat=plugin.tx_j77products_slider/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:j77products/Resources/Private/Partials/
        # cat=plugin.tx_j77products_slider/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:j77products/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_j77products_slider//a; type=string; label=Default storage PID
        storagePid =
    }
}

## Define custom categories
# customsubcategory=general=Allgemein
# customsubcategory=ids=Seiten-IDs

# cat=template/ids/; type=string; label= Maschinen-Detail
plugin.tx_j77products.settings.template.maschinendetail = 

# cat=template/ids/; type=string; label= Anlagen-Detail
plugin.tx_j77products.settings.template.anlagendetail = 

# cat=template/ids/; type=string; label= Kontakt
plugin.tx_j77products.settings.contact = 

# cat=template/general/; type=boolean; label= Debug Modus
plugin.tx_j77products.settings.debugMode = 0
