<?php
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']=array (
  'woba.dsl-factory.de' => 
  array (
    'init' => 
    array (
      'appendMissingSlash' => 'ifNotFile,redirect',
      'emptyUrlReturnValue' => '/',
    ),
    'pagePath' => 
    array (
      'rootpage_id' => '1',
    ),
    'fileName' => 
    array (
      'defaultToHTMLsuffixOnPrev' => 0,
      'acceptHTMLsuffix' => 1,
      'index' => 
      array (
        'print' => 
        array (
          'keyValues' => 
          array (
            'type' => 98,
          ),
        ),
      ),
    ),
    'preVars' => 
    array (
      0 => 
      array (
        'GETvar' => 'L',
        'valueMap' => 
        array (
          'de' => '2',
        ),
        'noMatch' => 'bypass',
      ),
    ),
    'postVarSets' => 
    array (
      '_DEFAULT' => 
      array (
        'news' => 
        array (
          0 => 
          array (
            'GETvar' => 'tx_news_pi1[news]',
            'lookUpTable' => 
            array (
              'table' => 'tx_news_domain_model_news',
              'id_field' => 'uid',
              'alias_field' => 'title',
              'useUniqueCache' => 1,
              'useUniqueCache_conf' => 
              array (
                'strtolower' => 1,
                'spaceCharacter' => '-',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
