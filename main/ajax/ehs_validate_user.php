<?php

require_once("../dbcon.php");
$name = $_POST['name'];
$pass = $_POST['pass'];
$sql = "select * from ehs_alert_users where ehs_name='" . $name . "' and ehs_pass='" . $pass . "'";
$query = mssql_query($sql);
$row = mssql_num_rows($query);
if ($row > 0) {

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



    $max_logq = mssql_query("SELECT MAX(L_id) as log FROM Log_log");
    if (mssql_num_rows($max_logq) > 0) {
        $max_log_arr = mssql_fetch_array($max_logq);
        $max_log = $max_log_arr['log'] + 1;
    } else {
        $max_log = 1;
    }

    $ins = mssql_query("INSERT INTO Log_log (L_id, L_module, L_projid, L_name, L_date, L_Ip) VALUES (" . $max_log . ",'EHS ALERT', 'EHS ALERT', 'ADMIN', getdate(), '" . $ip . "')");
    if ($ins) {
        echo 'success';
    }
} else {
    echo 'error';
}
?>