<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$ven_id = $_POST['key'];

$sql = "select sup_code from vendor where sup_id='".$ven_id."'";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
   $row= mssql_fetch_array($query);
   $sup_code=$row['sup_code'];
   echo $sup_code;
}
?>
