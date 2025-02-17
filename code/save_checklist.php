<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$projid = $_REQUEST['projid'];
$uid = $_SESSION['uid'];
$clk_id = $_REQUEST['id'];
$complete = $_REQUEST['complete'];
$date = formatDate($_REQUEST['date'], 'Y-m-d');

$isql = mssql_query("select isnull (max(cd_id+1),1) as id from  swift_checklist_docs");
$row = mssql_fetch_array($isql);
$id = $row['id'];

$check = mssql_query("select * from swift_checklist_docs  where clk_id='" . $clk_id . "' and ck_projid='" . $projid . "' and cd_uid ='" . $uid . "' ");
$num_rows = mssql_num_rows($check);
if ($num_rows > 0) {
    $sql = "update swift_checklist_docs set cd_date='" . $date . "' ,cd_status='0' where clk_id='" . $clk_id . "' and ck_projid='" . $projid . "' and cd_uid ='" . $uid . "' ";
    $query = mssql_query($sql);
} else {
    $sql = "insert into swift_checklist_docs(cd_id,clk_id,ck_projid,cd_uid,cd_completed,cd_date,cd_status) "
            . "values('" . $id . "','" . $clk_id . "','" . $projid . "','" . $uid . "','" . $complete . "','" . $date . "','0')";
    $query = mssql_query($sql);
}

if ($query) {
    echo 'success';
}
?>