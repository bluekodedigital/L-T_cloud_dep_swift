<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");

if (isset($_POST['lc_apply'])) {
    extract($_POST);
    $today = date('d-M-Y');
    $end_lc = formatDate($end_lc, 'd-M-Y');

    $expected = formatDate(str_replace('/', '-', $_POST['expe_date']), 'Y-m-d h:i:s');

    if ($today > $end_lc) {
        echo "<script>window.location.href='../lc_page?msg=0';</script>";
    } else if ($lc_value > $lc_balance) {
        echo "<script>window.location.href='../lc_page?msg=1';</script>";
    } else {
        $isql = mssql_query("select isnull (max(lce_id+1),1) as id from  swift_lc_entry");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];

        $sql = "insert into swift_lc_entry(lce_id,lcmst_id,lce_packid,lce_venid,lce_projid,lce_ponum,lce_applied,lce_ttl,lce_balance,lce_applydate,lce_remarks,po_wo_flag)
            values('" . $id . "','" . $lc_mst_id . "','" . $lc_pack_id . "','" . $lc_venid . "','" . $lc_proj_id . "','" . $lpo_number . "','" . $lc_value . "','" . $lc_ttl . "','" . ($lc_ttl - $lc_value) . "',GETDATE(),'" . $remarks . "','0')";
        $query = mssql_query($sql);

        $recvstageid = 24;
        $sendstageid = 24;
        $senduserid = $_SESSION['uid'];

        $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$lc_pack_id'";
        $query = mssql_query($sql);

        $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expected',ps_actualdate=GETDATE(),ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$lc_pack_id' AND ps_stageid = '$recvstageid'";
        $query = mssql_query($sql);

        //-----//
        $sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$lc_proj_id' AND ps_packid='$lc_pack_id' AND ps_stageid='$sendstageid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $planned_date = $row['revised_planned_date'];

        // transaction table functions
        $sql = "SELECT isnull (MAX(st_id+1),1) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
             VALUES('" . $id . "','" . $lc_pack_id . "','" . $lc_proj_id . "','" . $senduserid . "','" . $sendstageid . "',GETDATE(),'" . $planned_date . "','" . $expected . "',GETDATE(),'" . $remarks . "','0')";
        $query = mssql_query($sql);

        $lc_balance = $lc_balance - $lc_value;

        $update = mssql_query("update swift_lcmaster set lcm_balance='" . $lc_balance . "' where lcm_id='" . $lc_mst_id . "' ");


        if ($lc_balance == 0 || $lc_balance < 0) {
            $update1 = mssql_query("update swift_checklist_mapping set lc_complete=1 where cm_pack_id='" . $lc_pack_id . "'");
        }
        if ($update) {
            echo "<script>window.location.href='../lc_page';</script>";
        }
    }
}
?>