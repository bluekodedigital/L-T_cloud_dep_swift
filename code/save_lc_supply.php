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

$supply_value = array();
$supply_date = array();
$exchage_rate = array();

$quoteid = mssql_escape($_POST['key']);
$po_number = mssql_escape($_POST['po_number']);
$po_value = mssql_escape($_POST['supplied_value']);
$po_type = mssql_escape($_POST['po_type']);
$pay_term = mssql_escape1($_POST['pay_term']);
$project = mssql_escape($_POST['project']);
$package = mssql_escape($_POST['package']);
$vid = mssql_escape($_POST['vid']);
$total_po = mssql_escape($_POST['total_po']);
$final_forex = mssql_escape($_POST['final_forex']);
$final_val_inr = mssql_escape($_POST['final_val_inr']);
$supply_value = mssql_escape($_POST['supply_value']);
$supply_date = mssql_escape($_POST['supply_date']);
$exchage_rate = mssql_escape($_POST['exchage_rate']);
$lc_id = mssql_escape($_POST['lc_id']);
$balance = mssql_escape($_POST['balance']);


//echo '<pre>';
//print_r($quoteid);
//exit();
for ($i = 0; $i < sizeof($quoteid); $i++) {
    if (!empty($quoteid[$i])) {


        $sql = "select * from lc_creation_details where lcr_id='" . $quoteid[$i] . "'  and lcr_lcid='" . $lc_id . "'";
        $query1 = mssql_query($sql);
        $num_rows = mssql_num_rows($query1);



        $isql = mssql_query("select isnull (max(lc_sid+1),1) as id from  lc_supply_updation");
        $row = mssql_fetch_array($isql);
        $sid = $row['id'];

        $sql = "insert into lc_supply_updation (lc_sid,lc_sup_date,lc_sup_val ,lc_sup_ex_rate,lc_sup_uid,lc_sup_qid,lc_sup_vid,lc_sup_lcid )
                values('" . $sid . "','" . date('Y-m-d', strtotime($supply_date[$i])) . "','" . $supply_value[$i] . "','" . $exchage_rate[$i] . "','" . $uid . "','" . $quoteid[$i] . "','" . $vid . "','" . $lc_id . "' )";
        $query = mssql_query($sql);

        if ($num_rows > 0) {
            $sql1 = "select sum(lc_sup_val) as total_supply from lc_supply_updation where  lc_sup_lcid='" . $lc_id . "' and lc_sup_qid='" . $quoteid[$i] . "'";
            $qret = mssql_query($sql1);
            $row = mssql_fetch_array($qret);
            $total_supply = $row['total_supply'];
            $update_details = "update lc_creation_details set lcr_supply='" . $total_supply . "',lcr_supply_exchange='" . $exchage_rate[$i] . "',lcr_supply_date='" . date('Y-m-d', strtotime($supply_date[$i])) . "'  where  lcr_id='" . $quoteid[$i] . "'   and lcr_lcid='" . $lc_id . "'";
            $query = mssql_query($update_details);
        }
    }
}
if ($query) {
    $sql = "select * from lc_creation_masters where    lcm_lcid='" . $lc_id . "'";
    $query1 = mssql_query($sql);
    $num_rows1 = mssql_num_rows($query1);
    if ($num_rows1 > 0) {

        $sql1 = "select sum(lc_sup_val) as total_supply from lc_supply_updation where  lc_sup_lcid='" . $lc_id . "' ";
        $qret = mssql_query($sql1);
        $row = mssql_fetch_array($qret);
        $total_supply = $row['total_supply'];

//        $update_lcmst = mssql_query("update swift_lcmaster set lcm_balance=(lcm_value-('$total_supply'/lcm_forex)) where lcm_id='" . $lc_id . "'");
        $update_lcmst = mssql_query("update swift_lcmaster set lcm_balance='$balance',lcm_supplied_value='".$total_supply."' where lcm_id='" . $lc_id . "'");

        $update_mst = "update lc_creation_masters set lcm_supply_uid='" . $uid . "',lcm_supply_forex='" . $final_forex . "',lcm_supply_value='" . $final_val_inr . "',lcm_appliedpovalue='" . $total_supply . "' where   lcm_lcid='" . $lc_id . "' ";
        $quer = mssql_query($update_mst);
    }

    if ($quer) {
        echo 1;
    } else {
        echo 0;
    }
}
?>