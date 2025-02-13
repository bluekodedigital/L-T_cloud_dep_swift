<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cat_id = $_REQUEST['key'];
$sql = "select * from  swift_package_category where pc_id='" . $cat_id . "'";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
    $row= mssql_fetch_array($query);
    $leadtime=$row['pc_leadtime'];
    echo trim($leadtime);
            
} else {
   echo 0;
}
?>