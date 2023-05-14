<?php
ob_start();
ini_set('date.timezone', 'Asia/Manila');
date_default_timezone_set('Asia/Manila');
session_start();

require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/DateConfig.php');


$db = new DBConnection;
$conn = $db->conn;
function redirect($url = '')
{
    if (!empty($url))
        echo '<script>location.href="' . base_url . $url . '"</script>';
}
ob_end_flush();
