<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$stage_id=$_POST['stage_id'];
$exp_date=formatDate($_POST['exp_date'], 'Y-m-d');
$sql="update swift_packagestatus set ps_expdate='".$exp_date."' where ps_stageid='".$stage_id."' and ps_packid='" . $pack_id . "'";
mssql_query($sql);
if($sql){
    echo $sql;
}

?>
 


