<?php
namespace NITSAN\NsRevolutionSlider\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class BackendController extends ActionController
{
    /**
     * @var AppPath
     */
    protected $appPath;

    /**
     * Init
     *
     * @return void
     */
    public function initializeIndexAction()
    {

        /*$this->webPath = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . 'typo3conf/ext/ns_revolution_slider/vendor/wp';
        $this->appPath = GeneralUtility::getFileAbsFileName('EXT:ns_revolution_slider/vendor/wp/');*/

        /*$this->appPath = ExtensionManagementUtility::extPath('ns_revolution_slider') . 'Resources/Public/vendor/wp/';
        $this->webPath = PathUtility::getPublicResourceWebPath(
            'EXT:ns_revolution_slider/Resources/Public/vendor/wp'
        );*/

        /*$this->appPath = GeneralUtility::getFileAbsFileName('wdpr/wp/');
        $this->webPath = 'https://dsl-factory.dsl.sofflex.com/wdpr/wp/';*/

        $this->appPath = GeneralUtility::getFileAbsFileName('wp/');
        $this->webPath = 'https://dsl-factory.dsl.sofflex.com/wp';



        $this->wpConfigPath = $this->appPath . 'wp-config-t3terminal.php';

        // WordPress Editor User Credentials
        $this->wpUserName = '';
        $this->wpPassWord = '';

        // Create default tocken
        $this->t3AuthTocken = $this->wpRandomPassword(70);
    }

    /**
     * Main Action
     *
     * @return string
     */
    public function indexAction()
    {
        // Setup WordPress and Grab AutoLogin Link
        $wpAutoLogin = $this->wpUserSetup();

        // Check if WordPress App there?
        if (!is_dir($this->appPath)) {
            exit('Error: WordPress instance does not exist as Vendor; please update to the latest version of EXT.ns_revolution_slider from NITSAN > License Management module.');
        }
        // Render WordPress Application with Auto-Login and Redirect to Revolution Slider Plugin
        else {

            // Check If WordPress Configuration There?
            if ($this->wpCheckConfig()) {

                // If WordPress Is Ready Then Let's Launch
                echo "
                    <style>body {margin:0px;padding:0px;overflow:hidden; }</style>
                    <iframe src='$wpAutoLogin' frameborder='0' style='overflow:hidden;height:100%;width:100%' height='100%' width='100%'></iframe>
                ";
            } else {
                exit('Error: Something is wrong! Please re-install EXT.ns_revolution_slider from Admin Tools > Extensions Manager');
            }
        }
        die;
    }

    /**
     * Check WordPress User
     *
     * @return string
     */
    public function wpUserSetup()
    {
        // Include PasswordHash Class from WordPress Core
        @require_once $this->appPath . 'wp-includes/class-phpass.php';
        $class = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('PasswordHash', 8, true);

        // Let's Check WordPress User Access
        $arrWpUser = $this->wpGetUserAccess();

        if (empty($arrWpUser['is_password_reset_typo3'])) {
            $newPassword = $this->wpRandomPassword();
            $arrWpUser['is_password_reset_typo3'] = $newPassword;

            // Create New Password
            $hasPassword = $class->HashPassword($newPassword);

            // Update New Password
            $this->updateWpUserAccess($newPassword, $hasPassword);

            // Let's Grab New Passwords
            $arrWpUser = $this->wpGetUserAccess();
        }

        // Check through WordPress PasswordHash Class
        $check_password = $class->CheckPassword($arrWpUser['is_password_reset_typo3'], $arrWpUser['user_pass']);

        //$wpAutoLogin = $this->webPath . '/wp-login.php?autologin=1&username=' . $arrWpUser['user_login'] . '&password=' . $arrWpUser['is_password_reset_typo3'];

        $wpAutoLogin = $this->webPath . '/wp-login.php?autologin=1&t3AuthTocken='.$this->t3AuthTocken;

        // Set Editor User Credentials
        $this->wpUserName = $arrWpUser['user_login'];
        $this->wpPassWord = $arrWpUser['is_password_reset_typo3'];

        // Let's Securely Set AuthTocken to Bridget Between TYPO3 & WordPress
        $this->updateT3AuthTocken($this->t3AuthTocken);

        return $wpAutoLogin;
    }

    /**
     * action wpCheckConfig
     *
     * @return bool
     */
    public function wpCheckConfig()
    {
        // Let's Assume - Default Everything Is Good
        $isSuccess = true;


        // Get Current TYPO3 Database Configuration

        $dbTYPO3 = $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default'];


        // Let's Load Default WordPress Configuration
        @require_once($this->wpConfigPath);

        // Check If Database Configured Well of WordPress
        if (DB_HOST != $dbTYPO3['host'] ||
            DB_NAME != $dbTYPO3['dbname'] ||
            DB_USER != $dbTYPO3['user'] ||
            DB_PASSWORD != $dbTYPO3['password'] ||
            DB_PORT != $dbTYPO3['port'] ||
            WP_HOME != $this->webPath || 
            WP_USERNAME != $this->wpUserName || 
            WP_PASSWORD != $this->wpPassWord 
        ) {
            // Let's Prepare WodPress Config
            $strWpConfig = "<?php

/** The name of the database for WordPress **/
define('DB_NAME', '" . $dbTYPO3['dbname'] . "');

/** MySQL database username **/
define('DB_USER', '" . $dbTYPO3['user'] . "');

/** MySQL database password **/
define('DB_PASSWORD', '" . $dbTYPO3['password'] . "');

/** MySQL hostname **/
define('DB_HOST', '" . $dbTYPO3['host'] . "');

/** MySQL port **/
define('DB_PORT', '" . $dbTYPO3['port'] . "');

/** WP_HOME URL **/
define('WP_HOME', '" . $this->webPath . "');

/** WP_SITEURL location **/
define('WP_SITEURL', WP_HOME . '/');

/** Enable debug **/
define('WP_DEBUG', false);

/** Disable Auto Update **/
define( 'WP_AUTO_UPDATE_CORE', false);

/** DOMAIN HOST **/
define( 'DOMAIN_HOST', '". GeneralUtility::getIndpEnv('HTTP_HOST') ."');

/** Backend WordPress Editor Username **/
define( 'WP_USERNAME', '". $this->wpUserName ."');

/** Backend WordPress Editor Password **/
define( 'WP_PASSWORD', '". $this->wpPassWord ."');
";
            // Fix Permission of WP Config File
            //GeneralUtility::fixPermissions($this->wpConfigPath);

            // Let's Write wp-config File
            $isSuccess = GeneralUtility::writeFile($this->wpConfigPath, $strWpConfig);
            sleep(5);
        }

        return $isSuccess;
    }

    /**
     * Get WP User Details
     *
     * @return void
     */
    public function wpGetUserAccess()
    {

            $queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('wp_users');
            $rows = $queryBuilder
                ->select('*')
                ->from('wp_users')
                ->where(
                    $queryBuilder->expr()->eq('id', $queryBuilder->createNamedParameter(2, \PDO::PARAM_INT))
                )
                ->execute()
                ->fetch();

        return $rows;
    }

    /**
     * Update WP User Details
     *
     * @return void
     */
    public function updateWpUserAccess($newPassword, $hasPassword)
    {
            $queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('wp_users');
            $rows = $queryBuilder
                ->update('wp_users')
                ->where(
                    $queryBuilder->expr()->eq('id', $queryBuilder->createNamedParameter(2, \PDO::PARAM_INT))
                )
                ->set('is_password_reset_typo3', $newPassword)
                ->set('user_pass', $hasPassword)
                ->execute();

        return $rows;
    }

    /**
     * Update new Authentication tocken for securely communicate between TYPO3 & WordPress
     *
     * @return void
     */
    public function updateT3AuthTocken($t3AuthTocken)
    {
        // Let's check if `t3_authtocken` existing in WordPress (if first time install or update version)
        $queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('wp_options');
        $statement = $queryBuilder
            ->select('option_id', 'option_value')
            ->from('wp_options')
            ->where(
                $queryBuilder->expr()->eq('option_name', $queryBuilder->createNamedParameter('t3_authtocken'))
            )
            ->execute();
        $isRecord = false;
        while ($rows = $statement->fetch()) {
           if(!empty($rows['option_id'])) {
               $isRecord = true;
           }
        }

        // If `t3_authtocken` does not - then let's add it
        if(!$isRecord) {
            $queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('wp_options');
            $rows = $queryBuilder
                ->insert('wp_options')
                ->values([
                    'option_name' => 't3_authtocken',
                    'option_value' => '',
                ])
                ->execute();
        }

        // Let's Update new Auth Tocken
        $queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('wp_options');
        $queryBuilder
            ->update('wp_options')
            ->where(
                $queryBuilder->expr()->eq('option_name', $queryBuilder->createNamedParameter('t3_authtocken'))
            )
            ->set('option_value', $t3AuthTocken)
            ->execute();
        return $rows;
    }

    /**
     * Create Randome Password
     *
     * @return void
     */
    public function wpRandomPassword($length = 20)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = []; //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
