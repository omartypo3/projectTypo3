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
$columns = array(


    array('db' => "CONCAT(`user`.`first_name`,' ',`user`.`last_name`)", 'dt' => 0, 'field' => "CONCAT(`user`.`first_name`,' ',`user`.`last_name`)",
        'formatter' => function( $d, $row ) {
            return utf8_encode($d);
        }
    ),
    array('db' => 'user.uid', 'dt' => 1, 'field' => 'uid' ,
        'formatter' => function( $d, $row ) {
            return "<input type='checkbox' class='remove".$d."' value='".$d."' name='tx_dld_web_dlddldback[speakers][]' multiple='1'/>";
        }
    ),
    array('db' => 'user.uid', 'dt' => 2, 'field' => 'uid' ,
        'formatter' => function( $d, $row ) {
            return "<input type='checkbox' class='remove".$d."' value='".$d."' name='tx_dld_web_dlddldback[moderator][]' multiple='1'/>";

        }
    ),
    array('db' => 'user.uid', 'dt' => 3, 'field' => 'uid' ,
        'formatter' => function( $d, $row ) {
            return "<span class='fa fa-times' id='remove".$d."' onclick='removeFromSession(".$d.")'></span>";
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
//$joinQuery = "";
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
