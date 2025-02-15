<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$tc_id = $_REQUEST['key'];
$sql = "select * from  swift_credit_periods where cp_id='" . $tc_id . "'";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
    $row = mssql_fetch_array($query);
    $tc_teamcode = $row['cp_period'];
    $tc_teamname = '';  
 
    echo json_encode(array(
        'tc_teamcode' => $tc_teamcode,
        'tc_teamname' => $tc_teamname,
    ));
}
?>