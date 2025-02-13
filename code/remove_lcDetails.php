<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id = mssql_escape($_POST['key']);
$sql = mssql_query("delete from lc_creation_details where lcr_id= $id");
if ($sql) {
    echo 1;
} else {
    echo 0;
}
?>