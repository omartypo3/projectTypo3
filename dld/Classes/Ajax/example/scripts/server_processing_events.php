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
$table = 'tx_dld_domain_model_event';

// Table's primary key
$primaryKey = 'uid';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$db_code = "/typo3/index.php?M=web_DldDldback&moduleToken=xxxxxxxxxx";
$GLOBALS['code']=$db_code;
$columns = array(
    array('db' => 'event.uid', 'dt' => 0, 'field' => 'uid' ,
        'formatter' => function( $d, $row ) {
            return '#';
        }
    ),
    array('db' => "CONCAT(event.appliednumber , '(' , event.invitednumber, '/',(event.appliednumber - event.invitednumber),')')", 'dt' => 1, 'field' => "CONCAT(event.appliednumber , '(' , event.invitednumber, '/',(event.appliednumber - event.invitednumber),')')" ,
        'formatter' => function( $d, $row ) {
            $info = $d;
           // if($info[1]>$info[0]){
                return $info;
            //}

        }
    ),
    array('db' => "CONCAT(`event`.`start`,',',`event`.`uid`)", 'dt' => 2, 'field' => "CONCAT(`event`.`start`,',',`event`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            $infodate = date( 'Y-m-d', $info[0]);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bevent%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Event" class="urichange">'.$infodate.'</a>';

        }

    ),
    array('db' => "CONCAT(`event`.`uid`,',',`event`.`title`)", 'dt' => 3, 'field' => "CONCAT(`event`.`uid`,',',`event`.`title`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bevent%5D='.$info[0].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Event" class="urichange">'.$info[1].'</a>';

        }
    ),
    array('db' => "GROUP_CONCAT(session.name)", 'dt' => 4, 'field' => 'GROUP_CONCAT(session.name)',
        'formatter' => function( $d, $row ) {
            return mb_substr($d, 0, 50);

        }
    ),



    array('db' =>"CONCAT(`venue`.`name`,',',`venue`.`city`,'/',`event`.`uid`)",     'dt' => 5, 'field' => "CONCAT(`venue`.`name`,',',`venue`.`city`,'/',`event`.`uid`)",
        'formatter' => function( $d, $row ) {

            if(!$d==""){
                $info = explode("/",$d);
               return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bevent%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Event" class="urichange"><i class="fa fa-map-marker"></i>&nbsp;'.$info[0].'</a>';

            }
        }

    ),
    array('db' => 'event.twitter_hashtag', 'dt' => 6, 'field' => 'twitter_hashtag' ),
    array('db' => 'event.tag_prefix', 'dt' => 7, 'field' => 'tag_prefix' ),
    array('db' => 'event.uid',     'dt' => 8, 'field' => 'uid',
        'formatter' => function( $d, $row ) {
            setcookie("uidevent",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bevent%5D='.$d.'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Event" class="urichange"><i class="fa fa-edit"></i></a>';

        }
    ),
    array('db' => 'event.uid',     'dt' => 9, 'field' => 'uid',
        'formatter' => function( $d, $row ) {
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bevent%5D='.$d.'&tx_dld_web_dlddldback%5Baction%5D=delete&tx_dld_web_dlddldback%5Bcontroller%5D=Event" class="urichange"><i class="fa fa-trash"></i></a>';
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
//echo $_SERVER['SERVER_PROTOCOL'],$_SERVER['HTTP_HOST'];
$joinQuery = "FROM `tx_dld_domain_model_event` AS `event` LEFT JOIN `tx_dld_domain_model_venue` AS `venue` ON (`venue`.`uid` = `event`.`venue_id`)  JOIN `tx_dld_domain_model_session` AS `session` ON (`session`.`event_id` = `event`.`uid` and `session`.`deleted`=0 and `session`.`hidden`=0)";
$extraWhere = "event.deleted=0 and event.hidden=0";
$groupBy = "event.uid";
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