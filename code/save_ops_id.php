<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$csrf_token = $_REQUEST['csrf_token'];


if (isset($_SESSION['token']) && $csrf_token === $_SESSION['token']) {
$uid = $_POST['key'];
$projid = $_POST['projid'];
$ty = $_POST['ty'];
$isql = mssql_query("select isnull (max(oid+1),1) as id from  ops_mailsetting");
$row = mssql_fetch_array($isql);
$id = $row['id'];
if ($ty == 0) {
    $sql = mssql_query("insert into ops_mailsetting (oid,ops_projid,ops_toemail,ops_cc,ops_active) "
            . "values('" . $id . "','" . $projid . "','" . $uid . "','','1') ");
} else {
    $sql = mssql_query("insert into ops_mailsetting (oid,ops_projid,ops_toemail,ops_cc,ops_active) "
            . "values('" . $id . "','" . $projid . "','','" . $uid . "','1') ");
}

if ($sql) {
    echo 1;
} else {
    echo 0;
}
}
?>

