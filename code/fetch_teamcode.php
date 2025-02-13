<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$tc_id = $_REQUEST['key'];
$sql = "select * from  swift_temcode where tc_id='" . $tc_id . "' and tc_active=1";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
    $row = mssql_fetch_array($query);
    $tc_teamcode = $row['tc_teamcode'];
    $tc_teamname = $row['tc_teamname'];  
 
    echo json_encode(array(
        'tc_teamcode' => sanitize_decode($tc_teamcode),
        'tc_teamname' => sanitize_decode($tc_teamname),
    ));
}
?>