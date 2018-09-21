
plugin.tx_dld_dldfront {
  view {
    # cat=plugin.tx_dld_dldfront/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:dld/Resources/Private/Templates/
    # cat=plugin.tx_dld_dldfront/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:dld/Resources/Private/Partials/
    # cat=plugin.tx_dld_dldfront/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:dld/Resources/Private/Layouts/
  }
  persistence {
    # cat=plugin.tx_dld_dldfront//a; type=string; label=Default storage PID
    storagePid =
  }
  settings{
    feUserStoragePid = 2
    partnersPid = 44
    targetPageID = 88
    ParentPageID = 4
    flickrApiKey = a0bb241c73b709ea1210b4fd958496b1
  }
}

plugin.tx_dld_dldyoutube {
  view {
    # cat=plugin.tx_dld_dldyoutube/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:dld/Resources/Private/Templates/
    # cat=plugin.tx_dld_dldyoutube/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:dld/Resources/Private/Partials/
    # cat=plugin.tx_dld_dldyoutube/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:dld/Resources/Private/Layouts/
  }

  persistence {
    # cat=plugin.tx_dldyoutube//a; type=string; label=Default storage PID
    storagePid =
  }

  settings {
    typeNum = 135 
  }
}
module.tx_dld_dldback {
  view {
    # cat=module.tx_dld_dldback/file; type=string; label=Path to template root (BE)
    templateRootPath = EXT:dld/Resources/Private/Backend/Templates/
    # cat=module.tx_dld_dldback/file; type=string; label=Path to template partials (BE)
    partialRootPath = EXT:dld/Resources/Private/Backend/Partials/
    # cat=module.tx_dld_dldback/file; type=string; label=Path to template layouts (BE)
    layoutRootPath = EXT:dld/Resources/Private/Backend/Layouts/
  }
  persistence {
    # cat=module.tx_dld_dldback//a; type=string; label=Default storage PID
    storagePid =
  }
}
plugin.tx_dld_dldevent {
  settings {
    eventPageID = 13
    sessionPageID = 12
    peoplePageID = 11
    partnerPageID = 13

  }
}
