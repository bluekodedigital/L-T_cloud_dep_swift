<?php

include_once ("../config/inc_function.php");
// error_reporting(1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$csrf_token = $_REQUEST['csrf_token'];
if (isset($_SESSION['token']) && $csrf_token === $_SESSION['token']) {
    
if (isset($_REQUEST['package_cat_create'])) {
   
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_package_category where pc_pack_cat_name='" . filterText($pack_cat_name) . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        if ($epage_name == 'admin') {
            echo "<script>window.location.href='../package_category_master_edit?msg=0';</script>";
        } else {
            echo "<script>window.location.href='../package_category_master?msg=0';</script>";
        }
    } else {
        
        $isql = mssql_query("select isnull (max(pc_id+1),1) as id from  swift_package_category");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];

        $sql = mssql_query("insert into swift_package_category(pc_id,pc_pack_cat_name,pc_leadtime,pc_uid,pc_create)"
                . "values('" . $id . "','" . sanitize($pack_cat_name) . "','" . sanitize($lead_time). "','" . $uid . "',GETDATE())");
       
                if ($sql) {
            if ($epage_name == 'admin') {
                echo "<script>window.location.href='../package_category_master_edit';</script>";
            } else {
                echo "<script>window.location.href='../package_category_master';</script>";
            }
        }
    }
}
if (isset($_REQUEST['package_cat_update'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
     $sql = "select * from  swift_package_category where pc_id='" . $pc_id . "'";
    $query = mssql_query($sql);
     $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $update = mssql_query("update swift_package_category set pc_pack_cat_name='" . sanitize($pack_cat_name) . "',pc_leadtime='" . sanitize($lead_time) . "',pc_uid='" . $uid . "',pc_create=GETDATE() where pc_id='" . $pc_id . "' ");
        if ($update) {
            if ($epage_name == 'admin') {
                echo "<script>window.location.href='../package_category_master_edit';</script>";
            } else {
                echo "<script>window.location.href='../package_category_master_edit';</script>";
            }
        }
    } else {

        if ($epage_name == 'admin') {
            echo "<script>window.location.href='../package_category_master_edit?msg=1';</script>";
        } else {
            echo "<script>window.location.href='../package_category_master_edit?msg=1';</script>";
        }
    }
}
if (isset($_REQUEST['catid'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $pc_id = $_REQUEST['catid'];
    $sql = "select * from  swift_package_category where pc_id='" . $pc_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $delete = mssql_query("delete from swift_package_category where pc_id='" . $pc_id . "' ");
        if ($delete) {

            echo "<script>window.location.href='../package_category_master_edit';</script>";
        }
    } else {


        echo "<script>window.location.href='../package_category_master_edit?msg=1';</script>";
    }
}
}
?>