<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$dt_id = $_REQUEST['key'];
$sql = "select * from  swift_systemcode where sc_id='" . $dt_id . "' and sc_active=1";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
    $row = mssql_fetch_array($query);
    $sc_code = $row['sc_code'];
    $sc_name = $row['sc_name'];  
 
    echo json_encode(array(
        'sc_code' => $sc_code,
        'sc_name' => sanitize_decode($sc_name),
    ));
}
?>