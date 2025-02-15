<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$projid = $_REQUEST['projid'];
$uid = $_SESSION['uid'];
$clk_id = $_REQUEST['id'];
$appremarks = $_REQUEST['remarks'];
$check = mssql_query("select * from swift_checklist_docs  where clk_id='" . $clk_id . "' and ck_projid='" . $projid . "' ");
$num_rows = mssql_num_rows($check);
if ($num_rows > 0) {
    $sql = "update swift_checklist_docs set cd_appdate=GETDATE(),cd_status='2', cd_appid ='" . $uid . "',cd_remarks='" . $appremarks . "'  where clk_id='" . $clk_id . "' and ck_projid='" . $projid . "'";
    $query = mssql_query($sql);
}

if ($query) {
    echo 'success';
}
?>