
plugin.tx_dsljobs_jobs {
  view {
    # cat=plugin.tx_dsljobs_jobs/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:dsl_jobs/Resources/Private/Templates/
    # cat=plugin.tx_dsljobs_jobs/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:dsl_jobs/Resources/Private/Partials/
    # cat=plugin.tx_dsljobs_jobs/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:dsl_jobs/Resources/Private/Layouts/
  }
  persistence {
    # cat=plugin.tx_dsljobs_jobs//a; type=string; label=Default storage PID
    storagePid =
  }
}

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder