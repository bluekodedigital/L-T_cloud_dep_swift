<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$packid = mssql_escape($_POST['key']);
$last_status = mssql_escape1($_POST['last_status']);
$repo_remarks = mssql_escape1($_POST['repo_remarks']);
$expDateVendor= mssql_escape1($_POST['expDateVendor']);
$expDateVendor = formatDate($_POST['expDateVendor'], 'Y-m-d');
$sql = "update swift_packagemaster set last_week_status='" . $last_status . "',repo_remarks='" . $repo_remarks . "',expDateVendor='".$expDateVendor."' where pm_packid='" . $packid . "' ";
$query = mssql_query($sql);


?>