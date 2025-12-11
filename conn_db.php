<?php
// conn_db.php
// Database connection settings (edit password/dbname if needed)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_host = "127.0.0.1";
$db_user = "root";
$db_pass = "";   // set to your MySQL root password
$db_name = "kctms";
$db_port = 3306;

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
$mysqli->set_charset("utf8mb4");

if (!defined('SITE_ROOT')) {
    define('SITE_ROOT', realpath(dirname(__FILE__)));
}

date_default_timezone_set('Asia/Kolkata');
?>
