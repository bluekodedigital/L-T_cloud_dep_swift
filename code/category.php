<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cat_id = $_REQUEST['key'];
$sql = "select * from   swift_workflow_Master where Id='" . $cat_id . "' and active=1";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
    $row = mssql_fetch_array($query);

    $master = $row['workflow_Master'];
 
 
    echo json_encode(array(
        'master' => $master,
       
    ));
}
?>