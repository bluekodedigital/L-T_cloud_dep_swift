<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id = $_POST['id'];
$active=$_POST['active'];
echo $sql="update swift_workflow_master set active='".$active."' where id='".$id."'";
mssql_query($sql);
if($sql){
    echo $sql;
}

?>
 


