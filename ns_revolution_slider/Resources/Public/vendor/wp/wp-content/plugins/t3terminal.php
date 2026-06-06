<?php
/*
Plugin Name: T3Terminal
Plugin URI: https://t3terminal.com/
Description: Special WordPress Plugin for T3Terminal Revolution Slider TYPO3 Extension
Version: 1.0.0
Author: T3Terminal
Author URI: https://t3terminal.com/revolution-slider-typo3-extension
*/

##########################
### Auto Login Feature ###
##########################

// Include PasswordHash Class from WordPress Core
include_once(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "wp-includes" . DIRECTORY_SEPARATOR . "class-phpass.php");

function auto_login() {

    // Initiate WPDB global variable
    global $wpdb;

    // Get TYPO3 Authentication Security Tocken to secure login
    $result = $wpdb->get_results ( "SELECT * FROM  {$wpdb->prefix}options WHERE option_name = 't3_authtocken'", OBJECT );
    foreach ( $result as $data ){
        $t3AuthTocken = $data->option_value;
    }

    // Immediately Let's Remove TYPO3 Authentication Security Tocken
    $wpdb->update( $wpdb->prefix.'options', array( 'option_value' => ''), array('option_name'=>'t3_authtocken'));
    
    // Let's check if Autologin = TRUE
    if(isset($_GET['autologin']) && (isset($_GET['t3AuthTocken']) && $_GET['t3AuthTocken'] == $t3AuthTocken)) {

        // Grab User/Pass from wp-config-t3terminal.php
        $username = WP_USERNAME;
        $password = WP_PASSWORD;

        if(!empty($username) && !empty($password)) {
        
            // Get User Data from Username
            $get_user_data = get_user_by('login',$username);
            if($get_user_data) {
                $tuserid = $get_user_data->ID;
                $user_id = $tuserid;
                $user = get_user_by( 'id', $user_id );

                // Check through WordPress PasswordHash Class
                $wp_hasher = new PasswordHash(8, true);
                $check_password = $wp_hasher->CheckPassword($password, $user->data->user_pass);

                // Let's check final to match Username & Password
                if(is_object($user)) {
                    if($username == $user->data->user_login && $check_password) {

                        // Set WordPress Core Login Setup
                        wp_set_current_user( $user_id, $user->user_login );
                        wp_set_auth_cookie( $user_id );
                        do_action( 'wp_login', $user->user_login );

                        // Redirect to Revolution Slider
                        header('Location: wp-admin/admin.php?page=revslider');
                    }
                }
            }
        }
    }
}
add_action('init', 'auto_login');

##########################
### Hide Backend Menus ###
##########################

function custom_menu_page_removing() {
    remove_menu_page( 'index.php' );
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'upload.php' );
    remove_menu_page( 'edit.php?post_type=page' );
    remove_menu_page( 'edit-comments.php' );
    remove_menu_page( 'themes.php' );
    remove_menu_page( 'plugins.php' );
    remove_menu_page( 'users.php   ' );
    remove_menu_page( 'tools.php' );
    remove_menu_page( 'options-general.php' );
    remove_menu_page( 'users.php' );
    remove_menu_page( 'profile.php' );
}
add_action( 'admin_menu', 'custom_menu_page_removing' );

#######################
### Remove With CSS ###
#######################

function custom_css() {
    echo '<style>
        /* PATCH */
        #wpadminbar, #wpfooter, #adminmenumain, #rb_the_logo,#plugin_update_row #available_version_icon,#plugin_update_row #available_version_content,#plugin_update_row #check_for_updates, #activation_area .infobox, #rs_welcome_header_area, #plugin_update_row #updateplugin,body.login, body.login-action-login{
            display:none !important;
        }
        #rs_overview #add_new_slider_wrap {
            margin-top: 0;
        }
        .folded #wpcontent, 
        .folded #wpfooter,
        #wpwrap #wpcontent {
            margin-left: 0;
        }
        html.wp-toolbar {
            padding-top: 0;
        }
        #rs_overview_menu {
            top: 0 !important;
        }
        #wpadmin_overlay_top {
            height: 0 !important;
        }
    </style>';
}
add_action('admin_head', 'custom_css');