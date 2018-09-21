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
$table = 'fe_users';
// Table's primary key
$primaryKey = 'uid';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
//517bd089b493a9f9186f1fe3fcbef2f3777a2826
$db_code = "/typo3/index.php?M=web_DldDldback&moduleToken=xxxxxxxxxx";
$GLOBALS['code']=$db_code;

$columns = array(
    array('db' => "CONCAT(`file`.`identifier`,',',`user`.`uid`)", 'dt' => 0, 'field' => "CONCAT(`file`.`identifier`,',',`user`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            if(!$info[0]=='')
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpeople%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=People" class="urichange"><img src="../fileadmin/'.$info[0].'"height="50"/></a>';
        }
    ),

    array('db' => "CONCAT(`user`.`first_name`,',',`user`.`uid`)", 'dt' => 1, 'field' => "CONCAT(`user`.`first_name`,',',`user`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpeople%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=People" class="urichange">'.utf8_encode($info[0]).'</a>';

        }
    ),
    array('db' => "CONCAT(`user`.`last_name`,',',`user`.`uid`)", 'dt' => 2, 'field' => "CONCAT(`user`.`last_name`,',',`user`.`uid`)",
         'formatter' => function( $d, $row ) {
             $info = explode(",",$d);
             return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpeople%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=People" class="urichange">'.utf8_encode($info[0]).'</a>';

         }
    ),
    array('db' => "CONCAT(`user`.`company`,',',`user`.`uid`)", 'dt' => 3, 'field' => "CONCAT(`user`.`company`,',',`user`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpeople%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=People" class="urichange">'.$info[0].'</a>';

        }
    ),
    array('db' => "CONCAT(`user`.`username`,',',`user`.`uid`)", 'dt' => 4, 'field' => "CONCAT(`user`.`username`,',',`user`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpeople%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=People" class="urichange">'.$info[0].'</a>';

        }
    ),
    array('db' =>"user.social_twitter_username",     'dt' => 5, 'field' => "social_twitter_username",
        'formatter' => function( $d, $row ) {
            return '<a href="https://twitter.com/'.$d.'" target="_blank">'.$d.'</a>';
        }
    ),
    array('db' => 'user.uid',     'dt' => 6, 'field' => 'uid',
        'formatter' => function( $d, $row) {
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpeople%5D='.$d.'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=People" class="urichange"><i class="fa fa-edit"></i></a>';

        }
    ),
    array('db' => 'user.uid',     'dt' => 7, 'field' => 'uid',
        'formatter' => function( $d, $row ) {
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bpeople%5D='.$d.'&tx_dld_web_dlddldback%5Baction%5D=delete&tx_dld_web_dlddldback%5Bcontroller%5D=People" class="urichange"><i class="fa fa-trash"></i></a>';
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

$joinQuery = "FROM `fe_users` AS `user` LEFT JOIN `sys_file_reference` AS `sys` ON (`user`.`uid` = `sys`.`uid_foreign` and `sys`.`deleted`=0  and `sys`.`hidden`=0 and `sys`.`tablenames`='fe_users') LEFT JOIN `sys_file` AS `file` ON (`file`.`uid` = `sys`.`uid_local`)";
$extraWhere = "user.deleted=0";
$groupBy = "";
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