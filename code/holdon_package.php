<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$projid = $_REQUEST['projid'];
$packid = $_REQUEST['packid'];
$flag = $_REQUEST['flag'];

$sql = "UPDATE  swift_packagemaster set hold_on ='$flag' where pm_packid='" . $packid . "' and pm_projid='" . $projid . "' ";
$query = mssql_query($sql);
if ($query > 0) {
     echo 1;
} else {
    echo 0;
}
?> 