<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'tx_dld_domain_model_partner';

// Table's primary key
$primaryKey = 'uid';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$db_code = "/typo3/index.php?M=web_DldDldback&moduleToken=xxxxxxxxxx";
$GLOBALS['code']=$db_code;
$columns = array(


    array('db' => "CONCAT(`partner`.`name`,' ',`partner`.`uid`)", 'dt' => 0, 'field' => "CONCAT(`partner`.`name`,' ',`partner`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(" ",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpartner%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Partner" class="urichange">'.$info[0].'</a>';
        }
    ),
    array('db' => "CONCAT(`file`.`identifier`,' ',`partner`.`uid`)", 'dt' => 1, 'field' => "CONCAT(`file`.`identifier`,' ',`partner`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(" ",$d);
            if(!$d=='')
                return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpartner%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Partner" class="urichange"><img src="../fileadmin'.$info[0].'"height="50"/>.</a>';
        }
    ),
    array('db' => "CONCAT(`partner`.`country`,',',`partner`.`uid`)", 'dt' => 2, 'field' => "CONCAT(`partner`.`country`,',',`partner`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpartner%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Partner" class="urichange">'.$info[0].'</a>';
        }
    ),
    array('db' => "CONCAT(`partner`.`city`,',',`partner`.`uid`)", 'dt' => 3, 'field' => "CONCAT(`partner`.`city`,',',`partner`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpartner%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Partner" class="urichange">'.$info[0].'</a>';
        }
    ),
    array('db' => 'partner.description', 'dt' => 4, 'field' => 'description' ,
        'formatter' => function( $d, $row ) {
            return mb_substr ($d,0,100);
        }
    ),
    array('db' => 'partner.social_linkedin_url',     'dt' => 5, 'field' => 'social_linkedin_url',
        'formatter' => function( $d, $row ) {
            return '<a href="'.$d.'" target="_blank">'.$d.'</a>';
        }
    ),
    
    array('db' => 'partner.social_twitter_username',     'dt' => 6, 'field' => 'social_twitter_username',
        'formatter' => function( $d, $row ) {
            return '<a href="https://twitter.com/'.$d.'" target="_blank">'.$d.'</a>';
        }
    ),
    array('db' => 'partner.uid',     'dt' => 7, 'field' => 'uid',
        'formatter' => function( $d, $row ) {
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpartner%5D='.$d.'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Partner" class="urichange"><i class="fa fa-edit"></i></a>';

        }
    ),
    array('db' => 'partner.uid',     'dt' => 8, 'field' => 'uid',
        'formatter' => function( $d, $row ) {
            return $d;
            #return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpartner%5D='.$d.'&tx_dld_web_dlddldback%5Baction%5D=delete&tx_dld_web_dlddldback%5Bcontroller%5D=Partner" class="urichange"><i class="fa fa-trash"></i></a>';
        }
    ),


);

// SQL server connection information
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

//require( 'ssp.class.php' );
require('ssp.customized.class.php' );
$joinQuery = "FROM `tx_dld_domain_model_partner` AS `partner` LEFT JOIN `sys_file_reference` AS `sys` ON (`partner`.`uid` = `sys`.`uid_foreign`  and `sys`.`deleted`=0  and `sys`.`hidden`=0 and `sys`.`tablenames`='tx_dld_domain_model_partner') LEFT JOIN `sys_file` AS `file` ON (`file`.`uid` = `sys`.`uid_local`)";
$extraWhere = "partner.deleted=0 and partner.hidden=0";
$groupBy = "partner.uid";
$having = "";

if(isset($_COOKIE['be_typo_user'])){
    echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
    );
}else{
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
    $url = $protocol.$_SERVER['HTTP_HOST'].'/';
    //$_SERVER['HTTP_HOST'];
    header('Location: '.$url);
    exit();
}
