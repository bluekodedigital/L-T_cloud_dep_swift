<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id = $_REQUEST['key'];
$keyflag = $_REQUEST['keyflag'];
$uid = $_SESSION['uid'];
$sql = "UPDATE  swift_comman_uploads set key_flag ='$keyflag' where upid='" . $id . "' ";
$query = mssql_query($sql);
if ($query > 0) {
     echo 1;
} else {
    echo 0;
}
?> 