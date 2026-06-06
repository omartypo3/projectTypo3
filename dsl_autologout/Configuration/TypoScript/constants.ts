
plugin.tx_dslautologout_felogincheck {
  view {
    # cat=plugin.tx_dslautologout_felogincheck/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:dsl_autologout/Resources/Private/Templates/
    # cat=plugin.tx_dslautologout_felogincheck/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:dsl_autologout/Resources/Private/Partials/
    # cat=plugin.tx_dslautologout_felogincheck/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:dsl_autologout/Resources/Private/Layouts/
  }
  persistence {
    # cat=plugin.tx_dslautologout_felogincheck//a; type=string; label=Default storage PID
    storagePid =
  }
}

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

# cat=plugin.tx_dslautologout_felogincheck//a; type=string; label=Seite für Redirect
plugin.tx_dslautologout_felogincheck.settings.redirectPid = 