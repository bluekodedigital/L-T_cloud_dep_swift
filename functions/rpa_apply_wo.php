<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");

if (isset($_POST['rpa_apply'])) {
    extract($_POST);
    $today = date('d-M-Y');
    $end_rpa = formatDate($end_rpa, 'd-M-Y');
    $totalRvalue = $rpa_tbrvalue + $ebr_billvalue;

    $expected = formatDate(str_replace('/', '-', $_POST['expe_date']), 'Y-m-d h:i:s');
    $due_date = formatDate(str_replace('/', '-', $_POST['due_date']), 'Y-m-d h:i:s');

    if ($today > $end_rpa) {
        echo "<script>window.location.href='../rpa_page?msg=0';</script>";
    } else if ($totalRvalue > $rpa_povalue) {
        echo "<script>window.location.href='../rpa_page?msg=1';</script>";
    } else {
        $isql = mssql_query("select isnull (max(ebr_id+1),1) as id from  swift_ebrbill_entry");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];

        $sql = "insert into swift_ebrbill_entry(ebr_id,ebrmst_id,ebr_packid,ebr_venid,ebr_rpanum,ebr_projid,ebr_ponum,ebr_billno,ebr_billvalue,ebr_billdate,ebr_remarks,ebr_po_wo_flag,ebr_entrydate)
            values('" . $id . "','" . $rpa_mst_id . "','" . $rpa_pack_id . "','" . $rpa_venid . "','" . $rpa_number . "','" . $rpa_proj_id . "','" . $rpo_number . "','" . $ebr_billno . "','" . $ebr_billvalue . "','" . $due_date . "','" . $remarks . "','0',GETDATE())";
        $query = mssql_query($sql);


        $recvstageid = 24;
        $sendstageid = 24;
        $senduserid = $_SESSION['uid'];

        $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$rpa_pack_id'";
        $query = mssql_query($sql);

        $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expected',ps_actualdate=GETDATE(),ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$rpa_pack_id' AND ps_stageid = '$recvstageid'";
        $query = mssql_query($sql);

        //-----//
        $sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$rpa_proj_id' AND ps_packid='$rpa_pack_id' AND ps_stageid='$sendstageid'";
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
             VALUES('" . $id . "','" . $rpa_pack_id . "','" . $rpa_proj_id . "','" . $senduserid . "','" . $sendstageid . "',GETDATE(),'" . $planned_date . "','" . $expected . "',GETDATE(),'" . $remarks . "','0')";
        $query = mssql_query($sql);


        if ($totalRvalue == $rpa_povalue) {
            $update = mssql_query("update swift_checklist_mapping set rpa_complete=1 where cm_pack_id='" . $rpa_pack_id . "'");
        }
        if ($update) {
            echo "<script>window.location.href='../rpa_page';</script>";
        }
        echo "<script>window.location.href='../rpa_page';</script>";
    }
}
?>