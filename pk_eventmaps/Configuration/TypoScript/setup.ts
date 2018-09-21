
plugin.tx_pkeventmaps_pkeventmap {
  view {
    templateRootPaths.0 = EXT:pk_eventmaps/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_pkeventmaps_pkeventmap.view.templateRootPath}
    partialRootPaths.0 = EXT:pk_eventmaps/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_pkeventmaps_pkeventmap.view.partialRootPath}
    layoutRootPaths.0 = EXT:pk_eventmaps/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_pkeventmaps_pkeventmap.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_pkeventmaps_pkeventmap.persistence.storagePid}
    recursive = 1
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}


page.includeJS.jQuery = EXT:pk_eventmaps/Resources/Public/js/jquery.js
page.includeJSFooter.googleMaps = https://maps.googleapis.com/maps/api/js?v=3.exp
//page.includeJSFooter.googleMaps = https://maps.google.com/maps/api/js?key=AIzaSyCfDtiw0_N8gAvOJDJ2Zy6TLMcPo2QHdCI
//page.includeJSFooter.googleMaps.external = 1
page.includeJSFooter.tx_pkeventmaps_pkeventmap = EXT:pk_eventmaps/Resources/Public/js/mapscript.js

page.includeCSS.tx_pkeventmaps_pkeventmap = EXT:pk_eventmaps/Resources/Public/css/map.css
