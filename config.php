<?php
/*define("DB_HOST", "192.168.1.240");
define("DB_PORT", "3307");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "FPPassw0rd1234");
define("DB_NAME", "infosec_coffee");
*/
define("DB_HOST", "localhost");
define("DB_PORT", "3306");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "infosec_coffee");



define("DB_CONNECTION_STRING", "mysql:host=".DB_HOST.":".DB_PORT.";dbname=".DB_NAME);

if (DB_USERNAME == "" || DB_HOST == ""){
    throw new Exception("Configure database in includes.php first.");
}