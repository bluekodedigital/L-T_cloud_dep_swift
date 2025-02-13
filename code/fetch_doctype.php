<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$dt_id = $_REQUEST['key'];
$sql = "select * from  swift_doctype where dt_id='" . $dt_id . "' and dt_active=1";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
    $row = mssql_fetch_array($query);
    $dt_doctype = $row['dt_doctype'];
    $dt_docname = $row['dt_docname'];  
 
    echo json_encode(array(
        'dt_doctype' => sanitize_decode($dt_doctype),
        'dt_docname' => sanitize_decode($dt_docname),
    ));
}
?>