<?php
// Check if IN_APPLICATION constant is defined
// if (!defined('IN_APPLICATION')) {
//     // Redirect the user or terminate the script
//     header('HTTP/1.1 403 Forbidden');
//     exit('Direct access not allowed.');
// }
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");
$msg = 0;
if (isset($_POST['otp'])) {
    $otp = mssql_escape($_POST['otp']);
    $email = mssql_escape($_POST['key']);


    if ($_SESSION['otp'] == $otp) {

        if ($_SESSION['otp_email'] == $email) {

            $msg = 1;
        }
    }
}
echo $msg;
