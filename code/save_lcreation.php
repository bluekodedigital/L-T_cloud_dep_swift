<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");
$uid = $_SESSION['uid'];

$quoteid = array();
$po_number = array();
$po_value = array();
$po_type = array();
$pay_term = array();
$project = array();
$package = array();

$quoteid = $_POST['key'];
$po_number = $_POST['po_number'];
$po_value = $_POST['po_value'];
$po_type = $_POST['po_type'];
$pay_term = $_POST['pay_term'];
$project = $_POST['project'];
$package = $_POST['package'];
$vid = $_POST['vid'];
$total_po = $_POST['total_po'];

//echo '<pre>';
//print_r($quoteid);
for ($i = 0; $i < sizeof($quoteid); $i++) {
    if (!empty($quoteid[$i])) {


        $sql = "select * from lc_creation_details where lcr_ponumber='" . $po_number[$i] . "' and lcr_vid='" . $vid . "'";
        $query1 = mssql_query($sql);
        $num_rows = mssql_num_rows($query1);
        if ($num_rows > 0) {

            $update_details = "update lc_creation_details set lcr_povalue='" . $po_value[$i] . "',lcr_potype='" . $po_type[$i] . "',lcr_payterms='" . $pay_term[$i] . "',lcr_ponumber='" . $po_number[$i] . "' where  lcr_qid='" . $quoteid[$i] . "' and  lcr_vid='" . $vid . "'";
            $query = mssql_query($update_details);
        } else {
            $isql = mssql_query("select isnull (max(lcr_id+1),1) as id from  lc_creation_details");
            $row = mssql_fetch_array($isql);
            $id = $row['id'];

            $insert_details = "insert into lc_creation_details
                     (lcr_id,lcr_qid,lcr_vid,lcr_projid,lcr_packid,lcr_uid,lcr_povalue,lcr_potype,lcr_payterms,lcr_update,lcr_ponumber) 
                     values('" . $id . "','" . $quoteid[$i] . "','" . $vid . "','" . $project[$i] . "','" . $package[$i] . "','" . $uid . "','" . $po_value[$i] . "','" . $po_type[$i] . "','" . $pay_term[$i] . "',GETDATE(),'" . $po_number[$i] . "')";
            $query = mssql_query($insert_details);
        }
    }
}
if ($query) {
    $sql = "select * from lc_creation_masters where  lcm_vid='" . $vid . "'";
    $query1 = mssql_query($sql);
    $num_rows1 = mssql_num_rows($query1);
    if ($num_rows1 > 0) {

        $update_query = "update lc_creation_masters set lcm_totalpovalue='" . $total_po . "',lcm_update= GETDATE()where lcm_vid='" . $vid . "'  ";
        $quer = mssql_query($update_query);
//        $delete_query = mssql_query("delete from lc_creation_masters where lcm_vid='" . $vid . "' ");
//        if ($delete_query) {
//            $isql = mssql_query("select isnull (max(lcm_id+1),1) as id from  lc_creation_masters");
//            $row = mssql_fetch_array($isql);
//            $id = $row['id'];
//
//            $insert_master = "insert into lc_creation_masters(lcm_id,lcm_totalpovalue,lcm_vid,lcm_update)
//                values('" . $id . "','" . $total_po . "','" . $vid . "',GETDATE()) ";
//            $quer = mssql_query($insert_master);
//        }
    } else {
        $isql = mssql_query("select isnull (max(lcm_id+1),1) as id from  lc_creation_masters");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];

        $insert_master = "insert into lc_creation_masters(lcm_id,lcm_totalpovalue,lcm_vid,lcm_update)
                values('" . $id . "','" . $total_po . "','" . $vid . "',GETDATE()) ";
        $quer = mssql_query($insert_master);
    }

    if ($quer) {
        echo 1;
    } else {
        echo 0;
    }
}
?>