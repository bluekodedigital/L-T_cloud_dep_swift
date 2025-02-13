<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$dt_id = $_REQUEST['key'];
$sql = "select * from  swift_bank_details where bid='" . $dt_id . "'";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
    $row = mssql_fetch_array($query);
    $dt_doctype = $row['bank_name'];
    $dt_docname = $row['bank_address'];  
 
    echo json_encode(array(
        'dt_doctype' => $dt_doctype,
        'dt_docname' => $dt_docname,
    ));
}
?>