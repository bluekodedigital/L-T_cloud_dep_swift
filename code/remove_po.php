<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id = $_POST['key'];
$packid = $_POST['packid'];
$sql = "delete from dbo.swift_podetails where swid='" . $id . "' and po_pack_id='" . $packid . "'";
$query = mssql_query($sql);
if ($query) {
    echo 1;
} else {
    echo 0;
}
?>

