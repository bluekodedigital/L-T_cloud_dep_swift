<?php
 
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$proj_id = mssql_escape($_POST['proj_id']);

$segment_sql = mssql_query("select cat_id from Project where proj_id='" . $proj_id . "'");


 
$num_rows = mssql_num_rows($segment_sql);
if ($num_rows > 0) {
   $sqry = mssql_fetch_array($segment_sql);
   $segment = $sqry['cat_id'];
   echo  $segment;
}
?>
