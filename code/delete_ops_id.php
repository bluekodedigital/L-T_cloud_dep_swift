<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$uid = $_POST['key'];
$projid = $_POST['projid'];
$ty = $_POST['ty'];
$isql = mssql_query("select isnull (max(oid+1),1) as id from  ops_mailsetting");
$row = mssql_fetch_array($isql);
$id = $row['id'];
if ($ty == 1) {
    $sql = mssql_query("delete from ops_mailsetting where ops_projid ='" . $projid . "' and ops_cc='" . $uid . "' ");
} else {
    $sql = mssql_query("delete from ops_mailsetting where ops_projid ='" . $projid . "' and ops_toemail='" . $uid . "' ");
}

if ($sql) {
    echo 1;
} else {
    echo 0;
}
?>

