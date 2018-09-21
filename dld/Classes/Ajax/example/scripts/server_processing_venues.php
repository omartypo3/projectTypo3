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
$table = 'tx_dld_domain_model_venue';

// Table's primary key
$primaryKey = 'uid';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
 $db_code = "/typo3/index.php?M=web_DldDldback&moduleToken=xxxxxxxxxx";
 $GLOBALS['code']=$db_code;
$columns = array(
	array('db' => "CONCAT(`venue`.`name`,',',`venue`.`uid`)", 'dt' => 0, 'field' => "CONCAT(`venue`.`name`,',',`venue`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bvenue%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Venue" class="urichange">'.$info[0].'</a>';

        }
    ),
    array('db' => "CONCAT(`venue`.`street`,',',`venue`.`uid`)", 'dt' => 1, 'field' => "CONCAT(`venue`.`street`,',',`venue`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bvenue%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Venue" class="urichange">'.$info[0].'</a>';

        }
    ),
    array('db' => "CONCAT(`venue`.`zipcode`,' ', `venue`.`city`,',' ,`venue`.`uid`)", 'dt' => 2, 'field' => "CONCAT(`venue`.`zipcode`,' ', `venue`.`city`,',' ,`venue`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bvenue%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Venue" class="urichange">'.$info[0].'</a>';

        }
    ),
    array('db' => "CONCAT(`venue`.`country`,',',`venue`.`uid`)", 'dt' => 3, 'field' => "CONCAT(`venue`.`country`,',',`venue`.`uid`)",
        'formatter' => function( $d, $row ) {
            $info = explode(",",$d);
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bvenue%5D='.$info[1].'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Venue" class="urichange">'.$info[0].'</a>';

        }
    ),
    array('db' => 'uid',     'dt' => 4, 'field' => 'uid',
        'formatter' => function( $d, $row ) {
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bvenue%5D='.$d.'&tx_dld_web_dlddldback%5Baction%5D=edit&tx_dld_web_dlddldback%5Bcontroller%5D=Venue" class="urichange"><i class="fa fa-edit"></i></a>';

        }
    ),
    array('db' => 'uid',     'dt' => 5, 'field' => 'uid',
        'formatter' => function( $d, $row ) {
            return '<a href="'.$GLOBALS['code'].'&tx_dld_web_dlddldback%5Bvenue%5D='.$d.'&tx_dld_web_dlddldback%5Baction%5D=delete&tx_dld_web_dlddldback%5Bcontroller%5D=Venue" class="urichange"><i class="fa fa-trash"></i></a>';
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

$joinQuery = "from tx_dld_domain_model_venue AS `venue`";
$extraWhere = "deleted=0 and hidden=0";
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
