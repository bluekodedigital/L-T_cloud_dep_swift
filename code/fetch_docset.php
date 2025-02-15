<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$dt_id = $_REQUEST['key'];
$sql = "select * from  swift_docsetcode where dc_id='" . $dt_id . "' and dc_active=1";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
    $row = mssql_fetch_array($query);
    $dc_setcode = $row['dc_setcode'];
    $dc_setname = $row['dc_setname'];  
 
    echo json_encode(array(
        'dc_setcode' => $dc_setcode,
        'dc_setname' => sanitize_decode($dc_setname),
    ));
}
?>