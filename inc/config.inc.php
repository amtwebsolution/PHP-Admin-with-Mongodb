<?php

// SITE MODES
//------------------------------------------------------------------------------
define("_SITE_MODE", "debug"); // debug, production 
// SITE CONSTANTS
//------------------------------------------------------------------------------
define("_PANEL_NAME", "Admin Panel");
define("_SITE_NAME", "Mongodb admin");
define("_SITE_ADDRESS", "amtwebsolution.com");
define("_SITE_LANGUAGE", "en");
define("_ADMIN_EMAIL", " info@amtwebsolution.com");
define("_CSS_STYLE", "blue"); // blue, green
define("_DB_PREFIX", "bl_");
define("_PHP_AP_VERSION", "1.0.0");
define("_SUPPORT_EMAIL", "support <info@amtwebsolution.com>");
define("_CUSTOMER_EMAIL", "support <info@amtwebsolution.com>");
define("_SITE_DIRECTORY", "");
define("_SITE_UP_DIRECTORY", "");

// *** encrypt or not admin password true|false
define("USE_PASSWORD_ENCRYPTION", true);
// *** type of encryption - AES|MD5
define("PASSWORD_ENCRYPTION_TYPE", "MD5");
// *** password encryption key 
define("PASSWORD_ENCRYPTION_KEY", "apphp_adminpanel");
/*Upload category image*/
define("UPLOAD_DIR_CATEGORY", "media/category/");
define("UPLOAD_DIR_PRODUCT", "media/products/");
define("UPLOAD_DIR_PROFILE", "media/profile/");

$imageExtension = array('jpg', 'png');
/*Table name*/
$caTable = _DB_PREFIX . 'categories';
$proTable = _DB_PREFIX . 'products';
$customerTable = _DB_PREFIX . 'customers';
$adminTable = _DB_PREFIX . 'admins';

//------------------------------------------------------------------------------
if (_SITE_MODE == "debug") {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

//------------------------------------------------------------------------------
class Config {

    var $host = '';
    var $user = '';
    var $password = '';
    var $database = '';

    function Config() {
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->database = "demodb";
    }

}

?>
