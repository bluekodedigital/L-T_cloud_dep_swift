<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id = $_REQUEST['key'];
$uid = $_SESSION['uid'];
$sql = "delete from swift_comman_uploads where upid='" . $id . "' ";
$query = mssql_query($sql);
if ($query > 0) {
     echo 1;
} else {
    echo 0;
}
?> 