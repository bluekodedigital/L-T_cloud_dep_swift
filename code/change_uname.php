<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$uid = $_SESSION['uid'];
$otp = $_POST['otp'];
$uname = $_POST['uname'];
$old_uname = $_POST['old_uname'];
$date = date('Y-m-d H:i:s');
$sql = "select * from uname_log where uid='" . $uid . "' and otp='" . $otp . "' and status=0 and is_verify=0";
$query = mssql_query($sql);
$count = mssql_num_rows($query);
if ($count > 0) {
    $up=mssql_query("update uname_log set status = 1, is_verify = 1, verify_date='".$date."' where  uid='" . $uid . "' and status=0 and is_verify=0");
    $up1=mssql_query("update usermst set uname='".$uname."', old_uname='".$old_uname."' where  uid='" . $uid . "'");
    if($up){
        echo 1;
    }
} else {
    echo 0;
}
?>