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
$table = 'tx_dld_domain_model_session';

// Table's primary key
$primaryKey = 'uid';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
 $db_code = "/typo3/index.php?M=web_DldDldback&moduleToken=xxxxxxxxxx";
 $GLOBALS['code']=$db_code;
$columns = array(
    array('db' => "CONCAT(`session`.`name`,',',`session`.`uid`)", 'dt' => 0, 'field' => "CONCAT(`session`.`name`,',',`session`.`uid`)" ,
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bsession%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Session" class="urichange">'.$info[0].'</a>';

        }
    ),
    array('db' => "CONCAT(`session`.`start`,',',`session`.`uid`)", 'dt' => 1, 'field' => "CONCAT(`session`.`start`,',',`session`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            $infodate = date( 'Y-m-d  H:i', $info[0]);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bsession%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Session" class="urichange">'.$infodate.'</a>';

        }

    ),
    array('db' => "CONCAT(`session`.`end`,',',`session`.`uid`)", 'dt' => 2, 'field' => "CONCAT(`session`.`end`,',',`session`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            $infodate = date( 'Y-m-d  H:i', $info[0]);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bsession%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Session" class="urichange">'.$infodate.'</a>';

        }
    ),
    array('db' => "CONCAT(`session`.`is_visible`,',',`session`.`uid`)", 'dt' => 3, 'field' => "CONCAT(`session`.`is_visible`,',',`session`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            if($info[0]==1){
                return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bsession%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Session" class="urichange">visible</a>';

            }else{
                return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bsession%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Session" class="urichange">not visible</a>';

            }
        }),

    array('db' => "CONCAT(`event`.`title`,',',`session`.`uid`)", 'dt' => 4, 'field' => "CONCAT(`event`.`title`,',',`session`.`uid`)" ,
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bsession%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Session" class="urichange">'.$info[0].'</a>';
        }),
    array('db' => 'session.uid',     'dt' => 5, 'field' => 'uid',
         'formatter' => function( $d, $row ) {
             setcookie("uidsession",$d);
             return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bsession%5D='.$d.'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Session" class="urichange"><i class="fa fa-edit"></i></a>';

         }
     ),
    array('db' => 'session.uid',     'dt' => 6, 'field' => 'uid',
        'formatter' => function( $d, $row ) {
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bsession%5D='.$d.'&tx_dld_web_dlddldback%5Baction%5D=delete&tx_dld_web_dlddldback%5Bcontroller%5D=Session" class="urichange"><i class="fa fa-trash"></i></a>';
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
$joinQuery = "FROM `tx_dld_domain_model_session` AS `session` LEFT JOIN `tx_dld_domain_model_event` AS `event` ON (`session`.`event_id` = `event`.`uid`)";
$extraWhere = "session.deleted=0 and session.hidden=0";
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