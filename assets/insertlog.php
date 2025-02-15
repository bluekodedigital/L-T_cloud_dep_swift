<?php

include_once '../config/db_con1.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$name=$_SESSION['name'];
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$ip = get_client_ip();

if ($_POST['key'] == 'SADMIN') {
    $module = $name;
}
if ($_POST['key'] == 'BUYER') {
    $module = $name;
}
if ($_POST['key'] == 'APPROVER') {
    $module = $name;
}
if ($_POST['key'] == 'SWIFTUSERS') {
    $module = $name;
}
if ($_POST['key'] == 'USER') {
    $module = $name;
}
//if ($_POST['key'] == 'SADMIN') {
//    $module = 'SADMIN';
//}
//if ($_POST['key'] == 'BUYER') {
//    $module = 'BUYER';
//}
//if ($_POST['key'] == 'APPROVER') {
//    $module = 'APPROVER';
//}
//if ($_POST['key'] == 'SWIFTUSERS') {
//    $module = 'SWIFTUSERS';
//}
//if ($_POST['key'] == 'USER') {
//    $module = 'USER';
//}

$max_logq = mssql_query("SELECT MAX(L_id) as log FROM Log_log");
if (mssql_num_rows($max_logq) > 0) {
    $max_log_arr = mssql_fetch_array($max_logq);
    $max_log = $max_log_arr['log'] + 1;
} else {
    $max_log = 1;
}

$ins = mssql_query("INSERT INTO Log_log (L_id, L_module, L_projid, L_name, L_date, L_Ip) VALUES (" . $max_log . ",'Swift', 'Swift', '" . $module . "', getdate(), '" . $ip . "')");

if ($ins) {
    echo 1;
} else {
    echo 0;
}
mssql_close($con1);
?> 
