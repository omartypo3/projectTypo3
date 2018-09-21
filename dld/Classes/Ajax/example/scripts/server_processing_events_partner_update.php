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


    array('db' => "partner.name", 'dt' => 0, 'field' => 'name'),
    array('db' => "file.identifier", 'dt' => 1, 'field' => 'identifier',
        'formatter' => function( $d, $row ) {
            $info = explode(" ",$d);
            if(!$d=='')
                return '<img src="../fileadmin'.$info[0].'"height="50"/>';
        }
    ),
    array('db' => 'concat(partner.uid,(case when partner_id=partner.uid then ",1" else ",0" end ))  as stt', 'dt' => 2, 'field' => 'stt' ,
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            if($info[1] == '1'){
                return "<input type='checkbox' checked ='checked' class='remove".$info[0]."' value='".$info[0]."' name='tx_dld_web_dlddldback[partners][]' multiple='1'/>";

            }else{
                return "<input type='checkbox' class='remove".$info[0]."' value='".$info[0]."' name='tx_dld_web_dlddldback[partners][]' multiple='1'/>";

            }
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
$joinQuery = "FROM `tx_dld_domain_model_partner` AS `partner` LEFT JOIN `sys_file_reference` AS `sys` ON (`partner`.`uid` = `sys`.`uid_foreign` and `sys`.`deleted`=0  and `sys`.`hidden`=0 and `sys`.`tablenames`='tx_dld_domain_model_partner') LEFT JOIN `sys_file` AS `file` ON (`file`.`uid` = `sys`.`uid_local`) LEFT JOIN `tx_dld_domain_model_eventpartner` AS `p`  ON (`partner`.`uid` =`p`.`partner_id` and `p`.`deleted` = 0 and `p`.`event_id`=".$_COOKIE["uidevent"].")";
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
