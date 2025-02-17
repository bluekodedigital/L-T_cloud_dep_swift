<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");
$uid = $_SESSION['uid'];

$quoteid = array();

$popay_value = array();


$quoteid = $_POST['sel_quote'];
$popay_value = $_POST['popay_value'];

$lc_id = mssql_escape($_POST['lc_id']);
$vid = mssql_escape($_POST['vid']);
$lc_payment_value = mssql_escape($_POST['lc_payment_value']);
$lc_payment_date = formatDate($_POST['lc_payment_date'], 'Y-m-d');
$lc_exchange_rate = mssql_escape($_POST['lc_exchange_rate']);
$total_supply = mssql_escape($_POST['total_supply']);


$sql1 = "select sum(lph_payment) as total_payment from lc_payment_history where  lph_lcid='" . $lc_id . "' ";
$qret = mssql_query($sql1);
$row = mssql_fetch_array($qret);
$total_payment = $row['total_payment'];

if ($total_payment > $total_supply) {
    echo 2;
    exit();
} else {
    $isql = mssql_query("select isnull (max(lph_id+1),1) as id from  lc_payment_history");
    $row = mssql_fetch_array($isql);
    $sid = $row['id'];
    $sql = "insert into lc_payment_history (lph_id,lph_paydate ,lph_payment,lph_exchange ,lph_lcid,lph_uid )        
        values('" . $sid . "','" . $lc_payment_date . "','" . $lc_payment_value . "','" . $lc_exchange_rate . "','" . $lc_id . "','" . $uid . "')";
    $query = mssql_query($sql);
    if ($query) {
        $sql1 = "select sum(lph_payment) as total_payment from lc_payment_history where  lph_lcid='" . $lc_id . "' ";
        $qret = mssql_query($sql1);
        $row = mssql_fetch_array($qret);
        $total_payment = $row['total_payment'];
        $update1 = mssql_query("update swift_lcmaster set lcm_payment_mst='" . $total_payment . "' where lcm_id='" . $lc_id . "'");
        $update2 = mssql_query("update lc_creation_masters set lcm_payment='" . $total_payment . "' where lcm_lcid='" . $lc_id . "'");
    }
    if ($update2) {

        for ($i = 0; $i < sizeof($quoteid); $i++) {
            $isql = mssql_query("select isnull (max(lc_pyid+1),1) as id from  lc_payment_update_detls");
            $row = mssql_fetch_array($isql);
            $dtid = $row['id'];

            $sql2 = "insert into lc_payment_update_detls (lc_pyid,lc_pymstid,lc_pydate,lc_pyval,lc_pyuid,lc_pyqid,lc_pyvid,lc_pylcid)
                values('" . $dtid . "','" . $sid . "','" . $lc_payment_date . "','" . $popay_value[$i] . "','" . $uid . "','" . $quoteid[$i] . "','" . $vid . "','" . $lc_id . "' )";
            $query2 = mssql_query($sql2);
        }
        if ($query2) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}
?>