<?php

include_once ("../config/inc_function.php");
// error_reporting(1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_REQUEST['catid'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $pc_id = $_REQUEST['catid'];
    $sql = "select * from  swift_workflow_Master where Id='" . $pc_id . "' and active=1 ";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $delete = mssql_query("Update   swift_workflow_Master set active=0 where Id='" . $pc_id . "' ");
        if ($delete) {

            echo "<script>window.location.href='../workflowmaster.php';</script>";
        }
    } else {


        echo "<script>window.location.href='../package_category_master_edit?msg=1';</script>";
    }
}
?>