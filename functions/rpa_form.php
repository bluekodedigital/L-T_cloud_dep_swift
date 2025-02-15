<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST['rpamst_create'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $rpa_number = $rpa_num;
    $rpa_date = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $rpa_date)));
    $valid_from = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $from_rpa)));
    $valid_to = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $to_rpa)));
    $vendor = $vendor;
// Check LC already Exsits for selected Vendor    
    $sql = "select * from swift_rpamaster where  rpa_num='" . $rpa_number . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        echo "<script>window.location.href='../rpa_master?msg=0';</script>";
    } else {
        $isql = mssql_query("select isnull (max(rpa_id+1),1) as id from  swift_rpamaster");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];
        $insert = mssql_query("insert into swift_rpamaster(rpa_id,rpa_venid,rpa_num,rpa_bank,rpa_date,rpa_from,rpa_to,rpa_created,rpa_updated,rpa_userid)"
                . "values('" . $id . "','" . $vendor . "','" . $rpa_number . "','" . $bank_name . "','" . $rpa_date . "','" . $valid_from . "','" . $valid_to . "',GETDATE(),GETDATE(),'" . $uid . "')");
    }
    if ($insert) {
        echo "<script>window.location.href='../rpa_master';</script>";
    }
}

if (isset($_REQUEST['rpamst_update'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $rpa_number = $rpa_num;
    $rpa_date = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $rpa_date)));
    $valid_from = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $from_rpa)));
    $valid_to = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $to_rpa)));
    $vendor = $vendor;
  
// Check LC already Exsits for selected Vendor    
    $sql = "select * from swift_rpamaster where  rpa_num='" . $rpa_number . "' and rpa_id='" . $rpaid . "' ";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $update = mssql_query("update swift_rpamaster set rpa_venid='" . $vendor . "',rpa_bank='".$bank_name."',rpa_date='" . $rpa_date . "',rpa_from='" . $valid_from . "',rpa_to='" . $valid_to . "',rpa_created=GETDATE(),rpa_updated=GETDATE(),rpa_userid='" . $uid . "'"
                . "where rpa_num='" . $rpa_number . "' and rpa_id='" . $rpaid . "' ");
    } else {

        echo "<script>window.location.href='../rpa_master?msg=1';</script>";
    }
    if ($update) {
        echo "<script>window.location.href='../rpa_master';</script>";
    }
}
?>