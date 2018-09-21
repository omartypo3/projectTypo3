
plugin.tx_pkeventmaps_pkeventmap {
  view {
    # cat=plugin.tx_pkeventmaps_pkeventmap/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:pk_eventmaps/Resources/Private/Templates/
    # cat=plugin.tx_pkeventmaps_pkeventmap/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:pk_eventmaps/Resources/Private/Partials/
    # cat=plugin.tx_pkeventmaps_pkeventmap/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:pk_eventmaps/Resources/Private/Layouts/
  }
  persistence {
    # cat=plugin.tx_pkeventmaps_pkeventmap//a; type=string; label=Default storage PID
    storagePid = 1
  }
}
