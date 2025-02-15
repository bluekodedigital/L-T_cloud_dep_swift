<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$proj_id = $_POST['proj_id'];
$per = $_POST['per'];
$sql = "select * from swift_wocreation where wo_packid='" . $pack_id . "'";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
$row = mssql_fetch_array($query);
if ($num_rows > 0) {
    $total = $row['wo_ttlcompleted'];
    if ($total >= 100) {
        echo 0;
        exit();
    } else {
        $ttl = $total + $per;
        $update = mssql_query("update swift_wocreation set wo_completion_entry='" . $per . "',wo_ttlcompleted='" . $ttl . "',wo_entrydate=getdate()"
                . "where wo_packid='" . $pack_id . "'");
        echo 1;
        exit();
    }
} else {
    $insert = mssql_query("insert into swift_wocreation(wo_packid,wo_projid,wo_completion_entry,wo_ttlcompleted,wo_entrydate) "
            . "values('" . $pack_id . "','" . $proj_id . "','" . $per . "','" . $per . "',getdate())");
    echo 2;
    exit();
}
?>
 