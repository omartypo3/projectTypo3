$(document).ready(function () {
    eGmapLoadMap({
        'marker' : [],
        'uidToKey' : [],
        'layers' : [],
        <f:if condition="{eGmapPois}">'pois' : <f:format.htmlentitiesDecode>{eGmapPois}</f:format.htmlentitiesDecode>,</f:if>
        <f:if condition="{eGmapKmls}">'kmls' : <f:format.htmlentitiesDecode>{eGmapKmls}</f:format.htmlentitiesDecode>,</f:if>
        <f:if condition="{params}">'params' : <f:format.htmlentitiesDecode>{params}</f:format.htmlentitiesDecode>,</f:if>
        'settings' : <f:format.htmlentitiesDecode>{eGmapSettings}</f:format.htmlentitiesDecode>,
        'labels' : {
            'check': "<f:translate key='LLL:EXT:e_gmap/Resources/Private/Language/locallang.xlf:cat.checkAll'/>",
            'uncheck' : "<f:translate key='LLL:EXT:e_gmap/Resources/Private/Language/locallang.xlf:cat.uncheckAll'/>"
        }
    });
});