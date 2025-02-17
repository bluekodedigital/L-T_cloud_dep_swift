<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$milcom = $_SESSION['milcom'];
include_once("../config/inc_function.php");
$csrf_token = $_REQUEST['csrf_token'];
if (isset($_SESSION['token']) && $csrf_token === $_SESSION['token']) {
if (isset($_REQUEST['create_emr'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];

    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');


    $sql = "select * from swift_workflow_CurrentStage where cs_packid='$packageid'";
    $query1 = mssql_query($sql);
    while ($row = mssql_fetch_array($query1)) {
        $from_remark = $row['to_remark'];
        $from_uid = $row['from_uid'];
        $to_uid   = $row['to_uid'];
        //$to_stage_id = $row['to_stage_id'];
    }
    //Current status Update
    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '14',
    to_stage_id = '15',cs_userid='$uid',from_remark = '$from_remark',from_uid=$to_uid,to_uid=$from_uid,
    cs_active=0 ,to_remark = '".sanitize($opstospocremarks)."' ,
    cs_created_date='$actual_date',cs_expdate='" . $planneddate . "',cs_actual='" . $actual_date . "' WHERE cs_packid = '$packageid'";
    //echo $sql2;exit;
    $query2 = mssql_query($sql2);
    //Transaction  Insert
    $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
    $trow = mssql_fetch_array($tsql);
    $tid = $trow['tid'];

    $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','14','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $actual_date . "','" . sanitize($opstospocremarks) . "','0')");
    // repository Insert 
    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
    $row2 = mssql_fetch_array($isql2);
    $rsid = $row2['id'];

    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
        . "values('" . $rsid . "','" . $packageid . "','" . $projectid . "','14','15','" . $uid . "','" . $uid . "','0','" . mssql_escape1($from_remark) . "','" . sanitize($opstospocremarks) . "','" . $actual_date . "','" . $uid . "','" . $sentdate . "','" . $expected_date . "')";
    $insert3 = mssql_query($sql3);
    //packagestatus Update
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$packageid' AND ps_projid= '$projectid'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expected_date',ps_actualdate='$actual_date',ps_userid='$uid',ps_remarks='".sanitize($opstospocremarks)."',updated_date=GETDATE(),active='1',ps_sbuid='$uid' 
    WHERE ps_packid = '$packageid' AND ps_stageid = '15' AND ps_projid= '$projectid'";
    $query = mssql_query($sql);
    //EMR Details Insert
    $sql = mssql_query("select isnull (max(emr_id+1),1) as id from swift_emrcreation");
    $row = mssql_fetch_array($sql);
    $id = $row['id'];

    $insert = mssql_query("insert into swift_emrcreation(emr_id,emr_packid,emr_projid,emr_uid,emr_createddate,emr_remarks,emr_number)"
        . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $actual_date . "','" . sanitize($opstospocremarks) . "','" . sanitize($emr_no) . "')");
    //packagemaster emr status update 
    $update = mssql_query("update swift_packagemaster set emr_status=1 where pm_packid='" . $packageid . "' and pm_projid='" . $projectid . "'");

    $sqlpowo = "UPDATE Swift_po_wo_Details SET wo_flag =1, flag = 1 WHERE emr_flag = 1 and  pw_packid = '$packageid'  and pw_projid= '$projectid'";
    $queryemr = mssql_query($sqlpowo);

    // if ($count > 0) {
    //     //$send_email = $cls_comm->send_email($projectid, $packageid, '20', $recvid, $opstospocremarks, '19');
    // }
    if ($insert) {
        $send_email = $cls_comm->Send_MailNew($projectid, $packageid, $milcom, 14, 15);
        // header('Location: ../loi_update');
        echo "<script>window.location.href='../files_from_loi';</script>";
    }
}
if (isset($_POST['wo_create'])) {
    $pack_id = $_POST['pack_id'];
    $proj_id = $_POST['proj_id'];
    $wo_number = $_POST['wo_number'];
    $wo_expected = $_POST['wo_expected'];
    $wo_actual = $_POST['wo_actual'];
    $wo_value = $_POST['wo_value'];
    //           $wo_actual = date('Y-m-d'); 
    $wo_remarks = $_POST['wo_remarks'];
    $senduserid = $_SESSION['uid'];

    $isql2 = mssql_query("select * from  swift_workflow_CurrentStage  where cs_packid='$pack_id'");
    $row2 = mssql_fetch_array($isql2);
    $from_stage_id = $row2['from_stage_id'];
    $to_stage_id   = $row2['to_stage_id'];
    $from_remark   = $row2['to_remark'];
    $recvstageid   = $to_stage_id;
    $sendstageid   = $from_stage_id;

    // update status for smartsignoff table

    $sqlpowo = "UPDATE Swift_po_wo_Details SET wo_flag=2, wo_no ='" . $wo_number . "' ,wo_created_on='" . $wo_actual . "' WHERE  pw_packid = '$pack_id'  and pw_projid= '$proj_id'";
    $querypo = mssql_query($sqlpowo);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$pack_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$wo_expected',ps_actualdate='$wo_actual',ps_userid='$senduserid',ps_sbuid='$senduserid',ps_remarks='$wo_remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid'";
    $query = mssql_query($sql);


    $sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$proj_id' AND ps_packid='$pack_id' AND ps_stageid='15'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['revised_planned_date'];

    // transaction table functions
    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $id = $row['id'] + 1;



    // insert to transaction table
    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
            VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "',GETDATE(),'" . $planned_date . "','" . $wo_actual . "','" . $wo_actual . "','" . $wo_remarks . "','0')";
    $query = mssql_query($sql);


    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '14',
    to_stage_id = '15',cs_userid='$senduserid',from_remark = '$from_remark',cs_active=0 ,to_remark = '$wo_remarks' ,
    cs_created_date='$wo_actual',cs_expdate='" . $planned_date . "',cs_actual='" . $wo_actual . "' WHERE cs_packid = '$pack_id'";
    //echo $sql2;exit;
    $query2 = mssql_query($sql2);

    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
    $row2 = mssql_fetch_array($isql2);
    $rsid = $row2['id'];

    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
        . "values('" . $rsid . "','" . $pack_id . "','" . $proj_id . "','14','15','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','" . mssql_escape1($wo_remarks) . "',
        '" . $wo_actual . "','" . $senduserid . "','" . $wo_actual . "','" . $planned_date . "')";
    $insert3 = mssql_query($sql3);

    // $send_email = $cls_comm->send_email($proj_id, $pack_id, '23', $senduserid, $wo_remarks);
    if ($query) {

        echo "<script>window.location.href='../files_for_ops_wo_entry';</script>";
    } else {
        echo "not insert";
    }
} else if (isset($_POST['wo_approve'])) {
    $pack_id = $_POST['pack_id'];
    $proj_id = $_POST['proj_id'];
    $wo_expected = $_POST['wo_expected'];
    $wo_actual = $_POST['wo_actual'];
    //           $wo_actual = date('Y-m-d'); 
    $wo_remarks = $_POST['wo_remarks'];
    $senduserid = $_SESSION['uid'];
    $recvstageid = 23;
    $sendstageid = 23;

    // update status for smartsignoff table
    $sql = "UPDATE swift_filesfrom_smartsignoff SET work_order = '3' WHERE so_pack_id = '$pack_id'";
    $query = mssql_query($sql);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$pack_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$wo_actual',ps_actualdate='$wo_actual',ps_userid='$senduserid',ps_remarks='$wo_remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid'";
    $query = mssql_query($sql);

    $sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$proj_id' AND ps_packid='$pack_id' AND ps_stageid='20'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $wo_planned_date = $row['revised_planned_date'];

    // transaction table functions
    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $id = $row['id'] + 1;

    // insert to transaction table
    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
            VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "',GETDATE(),'" . $wo_planned_date . "','" . $wo_actual . "','" . $wo_actual . "','" . $wo_remarks . "','0')";
    $query = mssql_query($sql);
    if ($query) {

        echo "<script>window.location.href='../files_for_ops_wo_entry';</script>";
    } else {
        echo "not insert";
    }
} else if (isset($_POST['wo_approve_only'])) {
    $pack_id = $_POST['pack_id'];
    $proj_id = $_POST['proj_id'];
    $wo_expected = $_POST['wo_expected'];
    $wo_actual = $_POST['wo_actual'];
    $wo_number = sanitize($_POST['wo_number']);
    $wo_remarks = sanitize($_POST['wo_remarks']);
    $senduserid = $_SESSION['uid'];

    $isql2 = mssql_query("select * from  swift_workflow_CurrentStage  where cs_packid='$pack_id'");
    $row2 = mssql_fetch_array($isql2);
    $from_stage_id = $row2['from_stage_id'];
    $to_stage_id   = $row2['to_stage_id'];
    $from_remark   = $row2['to_remark'];
    $recvstageid   = $to_stage_id + 1;
    $sendstageid   = $from_stage_id;

    $flags = mssql_query("select * from  Swift_po_wo_Details  where pw_packid='$pack_id'");
    $rowpw = mssql_fetch_array($flags);
    $pflag = $rowpw['flag'];
    $wflag = $rowpw['wo_flag'];
    $po_status = $rowpw['po_wo_status'];
    if ($wflag == 1 || $po_status = 2) {
        $wo_completed = 1;
    } else {
        $wo_completed = 0;
    }
    if ($wo_completed == 1) {
        $flag_query = mssql_query("select top 1 * from  Swift_Mail_Details  where md_packid='$pack_id' and md_projid='$proj_id' and flag=1 order by md_id ");
        $row_dist = mssql_fetch_array($flag_query);
        $md_id = $row_dist['md_id'];

        $count = mssql_num_rows($flag_query);
        if ($count == 1) {

            $send_email = $cls_comm->Send_Mail_Dist($proj_id, $pack_id, $md_id);
            //print_r($send_email);die;
        }

        // http://192.168.0.216:8001/api/MailLink
        // Api Calling for Link Send To Particular  site Planing 

    }
    // update status for smartsignoff table
    //flag=2 and wo_po_status=1 = pocompleted
    $wo_create = formatDate(str_replace('/', '-', $wo_actual), 'Y-m-d h:i:s');

    $sqlpowo = "UPDATE Swift_po_wo_Details SET  wo_flag =2,
    wo_no ='" . $wo_number . "' ,wo_created_on='" . $wo_create . "',wo_complete = '" . $wo_completed . "' ,wo_approved_on='" . $wo_create . "' WHERE  pw_packid = '$pack_id'  and pw_projid= '$proj_id'";

    $querypo = mssql_query($sqlpowo);

    // $sqlpowo = "UPDATE Swift_po_wo_Details SET wo_flag=2, wo_no ='" . $wo_number . "' ,wo_created_on='" . $wo_actual . "' WHERE  pw_packid = '$pack_id'  and pw_projid= '$proj_id'";
    // $querypo = mssql_query($sqlpowo);


    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$pack_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$wo_expected',ps_actualdate='$wo_actual',ps_userid='$senduserid',ps_sbuid='$senduserid',ps_remarks='$wo_remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid'";
    $query = mssql_query($sql);


    $sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$proj_id' AND ps_packid='$pack_id' AND ps_stageid='16'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['revised_planned_date'];

    // transaction table functions
    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $id = $row['id'] + 1;



    // insert to transaction table
    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
            VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "',GETDATE(),'" . $planned_date . "','" . $wo_actual . "','" . $wo_actual . "','" . $wo_remarks . "','0')";
    $query = mssql_query($sql);


    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '15',
    to_stage_id = '16',cs_userid='$senduserid',from_remark = '$from_remark',cs_active=0 ,to_remark = '$po_remarks' ,
    cs_created_date='$wo_actual',cs_expdate='" . $planned_date . "',cs_actual='" . $wo_actual . "' WHERE cs_packid = '$pack_id'";
    //echo $sql2;exit;
    $query2 = mssql_query($sql2);

    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
    $row2 = mssql_fetch_array($isql2);
    $rsid = $row2['id'];


    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
        . "values('" . $rsid . "','" . $pack_id . "','" . $proj_id . "','15','16','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','" . mssql_escape1($wo_remarks) . "',
        '" . $wo_actual . "','" . $senduserid . "','" . $wo_actual . "','" . $planned_date . "')";
    $insert3 = mssql_query($sql3);


    if ($query) {
        $send_email = $cls_comm->Send_MailNew($proj_id, $pack_id, $milcom, 15, 16);
        echo "<script>window.location.href='../files_for_ops_wo_entry';</script>";
    } else {
        echo "not insert";
    }
    // } else if (isset($_POST['po_create'])) {
    //     $pack_id = $_POST['pack_id'];
    //     $proj_id = $_POST['proj_id'];
    //     $po_expected = $_POST['po_expected'];
    //     $po_actual = $_POST['po_actual'];
    //     //           $po_actual = date('Y-m-d'); 
    //     $po_remarks = $_POST['po_remarks'];
    //     $po_number = $_POST['apo_num'];
    //     $po_value = $_POST['po_value'];
    //     $senduserid = $_SESSION['uid'];
    //     $isql2 = mssql_query("select * from  swift_workflow_CurrentStage  where cs_packid='$pack_id'");
    //     $row2 = mssql_fetch_array($isql2);
    //     $from_stage_id = $row2['from_stage_id'];
    //     $to_stage_id   = $row2['to_stage_id'];
    //     $from_remark   = $row2['to_remark'];
    //     $recvstageid   = $to_stage_id;
    //     $sendstageid   = $from_stage_id;

    //     // update status for smartsignoff table

    //     $sqlpowo = "UPDATE Swift_po_wo_Details SET flag = 2 , po_no='" . $po_number . "' ,po_value= '" . $po_value . "' ,po_created_on='" . $po_actual . "' WHERE emr_flag = 1 and  pw_packid = '$pack_id'  and pw_projid= '$proj_id'";
    //     $querypo = mssql_query($sqlpowo);

    //     // update package status
    //     $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$pack_id'";
    //     $query = mssql_query($sql);
    //     $sql = "UPDATE swift_packagestatus SET ps_expdate = '$po_expected',ps_actualdate='$po_actual',ps_userid='$senduserid',ps_sbuid='$senduserid',ps_remarks='$po_remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid'";
    //     $query = mssql_query($sql);

    //     $sql = "UPDATE swift_podetails set povalue='$po_value' where po_number='$po_number'";
    //     $query = mssql_query($sql);

    //     $sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$proj_id' AND ps_packid='$pack_id' AND ps_stageid='15'";
    //     $query = mssql_query($sql);
    //     $row = mssql_fetch_array($query);
    //     $po_planned_date = $row['revised_planned_date'];

    //     // transaction table functions
    //     $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
    //     $query = mssql_query($sql);
    //     $row = mssql_fetch_array($query);
    //     $id = $row['id'] + 1;


    //     // insert to transaction table
    //     $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
    //             VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "',GETDATE(),'" . $po_planned_date . "','" . $po_actual . "','" . $po_actual . "','" . $po_remarks . "','0')";
    //     $query = mssql_query($sql);


    //     $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '14',
    //     to_stage_id = '15',cs_userid='$senduserid',from_remark = '$from_remark',cs_active=0 ,to_remark = '$po_remarks' ,
    //     cs_created_date='$po_actual',cs_expdate='" . $po_planned_date . "',cs_actual='" . $po_actual . "' WHERE cs_packid = '$pack_id'";
    //     //echo $sql2;exit;
    //     $query2 = mssql_query($sql2);

    //     $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
    //     $row2 = mssql_fetch_array($isql2);
    //     $rsid = $row2['id'];


    //     $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
    //         . "values('" . $rsid . "','" . $pack_id . "','" . $proj_id . "','14','15','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','" . mssql_escape1($po_remarks) . "',
    //         '" . $po_actual . "','" . $senduserid . "','" . $po_actual . "','" . $po_planned_date . "')";
    //     $insert3 = mssql_query($sql3);

    //     //$send_email = $cls_comm->send_email($proj_id, $pack_id, '21', $senduserid, $po_remarks,'20');

    //     if ($query) {
    //         echo "<script>window.location.href='../files_from_po';</script>";
    //     } else {
    //         echo "not insert";
    //     }
    // 
} else if (isset($_POST['po_approve'])) {
    $pack_id = $_POST['pack_id'];
    $proj_id = $_POST['proj_id'];
    $po_expected = $_POST['po_expected'];
    $po_actual = $_POST['po_actual'];
    $po_no = $_POST['apo_num'];
    //$po_value = $_POST['po_value'];
    //$po_actual = date('Y-m-d'); 
    $po_remarks = sanitize($_POST['po_remarks']);
    $senduserid = $_SESSION['uid'];
    // $recvstageid = 16;
    // $sendstageid = 15;
    $sentdate = date("Y-m-d h:i:s");
    $page_name = sanitize($_POST['pagename']);
    $isql2 = mssql_query("select * from  swift_workflow_CurrentStage  where cs_packid='$pack_id'");
    $row2 = mssql_fetch_array($isql2);
    $from_stage_id = $row2['from_stage_id'];
    $to_stage_id   = $row2['to_stage_id'];
    $from_remark   = $row2['to_remark'];
    $recvstageid   = $to_stage_id;
    $sendstageid   = $from_stage_id;
    $from_uid = $row2['from_uid'];
    $to_uid   = $row2['to_uid'];

    $flag = mssql_query("select * from  Swift_po_wo_Details  where pw_packid='$pack_id'");
    $rowpw = mssql_fetch_array($flag);
    $flag = $rowpw['flag'];
    $po_status = $rowpw['po_wo_status'];
    if ($flag == 1 &&  $po_status = 1) {
        $po_completed = 1;
    } else {
        $po_completed = 0;
    }
    if ($po_completed == 1) {
        $flag_query = mssql_query("select top 1 * from  Swift_Mail_Details  where md_packid='$pack_id' and md_projid='$proj_id' and flag=1 order by md_id ");
        $row_dist = mssql_fetch_array($flag_query);
        $md_id = $row_dist['md_id'];

        $count = mssql_num_rows($flag_query);
        if ($count == 1) {

            $send_email = $cls_comm->Send_Mail_Dist($proj_id, $pack_id, $md_id);
        }

        // http://192.168.0.216:8001/api/MailLink
        // Api Calling for Link Send To Particular  site Planing 

    }

    // update status for smartsignoff table
    //flag=2 and wo_po_status=1 = pocompleted
    $sqlpowo = "UPDATE Swift_po_wo_Details SET flag = 2 ,po_no= '$po_no' ,po_complete = '" . $po_completed . "' ,po_created_on='" . $po_actual . "',po_approved_on='" . $po_actual . "' WHERE emr_flag = 1 and  pw_packid = '$pack_id'  and pw_projid= '$proj_id'";
    $querypo = mssql_query($sqlpowo);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$pack_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$po_expected',ps_actualdate='$po_actual',ps_userid='$senduserid',ps_sbuid='$senduserid',ps_remarks='$po_remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid'";
    $query = mssql_query($sql);

    // $sql = "UPDATE swift_podetails set povalue='$po_value' where po_number='$po_number'";
    // $query = mssql_query($sql);

    $sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$proj_id' AND ps_packid='$pack_id' AND ps_stageid='15'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $po_planned_date = formatDate($row['revised_planned_date'], 'd-M-y');

    // transaction table functions
    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $id = $row['id'] + 1;



    // insert to transaction table
    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
            VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $recvstageid . "',GETDATE(),'" . $po_planned_date . "','" . $po_actual . "','" . $po_actual . "','" . $po_remarks . "','0')";
    $query = mssql_query($sql);


    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '14',
    to_stage_id = '15',cs_userid='$senduserid',from_remark = '$from_remark',
    from_uid=$to_uid,to_uid=$from_uid,cs_active=0 ,to_remark = '$po_remarks' ,
    cs_created_date='$po_actual',cs_expdate='" . $po_planned_date . "',cs_actual='" . $po_actual . "' WHERE cs_packid = '$pack_id'";
    //echo $sql2;exit;
    $query2 = mssql_query($sql2);

    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
    $row2 = mssql_fetch_array($isql2);
    $rsid = $row2['id'];


    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
        . "values('" . $rsid . "','" . $pack_id . "','" . $proj_id . "','14','15','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','" . mssql_escape1($po_remarks) . "',
        '" . $po_actual . "','" . $senduserid . "','" . $po_actual . "','" . $po_planned_date . "')";
    $insert3 = mssql_query($sql3);

    //$send_email = $cls_comm->send_email($proj_id, $pack_id, '25', $recvid1, $po_remarks,'21');
    if ($query) {
        $send_email = $cls_comm->Send_MailNew($proj_id, $pack_id, $milcom, 14, 15);
        if ($page_name == 'popage') {
            echo "<script>window.location.href='../files_from_po_approval';</script>";
        } else {
            echo "<script>window.location.href='../files_from_po';</script>";
        }
    } else {
        echo "not insert";
    }
} else if (isset($_POST['order_approve'])) {
    $pack_id   = $_POST['pack_id'];
    $proj_id   = $_POST['proj_id'];
    $po_actual = $_POST['po_actual'];
    $remarks   = sanitize($_POST['remarks']);
    $po_expected = $_POST['po_expected'];
    $po_actual = $_POST['po_actual'];
    $senduserid = $_SESSION['uid'];


    $sentdate = date("Y-m-d h:i:s");
    $page_name = $_POST['pagename'];
    $isql2 = mssql_query("select * from  swift_workflow_CurrentStage  where cs_packid='$pack_id'");
    $row2 = mssql_fetch_array($isql2);
    $from_stage_id = $row2['from_stage_id'];
    $to_stage_id   = $row2['to_stage_id'];
    $from_remark   = $row2['to_remark'];
    $recvstageid   = $to_stage_id;
    $sendstageid   = $from_stage_id;
    $from_uid = $row2['from_uid'];
    $to_uid   = $row2['to_uid'];
    $sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$proj_id' AND ps_packid='$pack_id' AND ps_stageid='$recvstageid'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $po_planned_date = $row['revised_planned_date'];


    $sqlbuyer = "UPDATE Swift_Mail_Details SET send_back = 0, buyer_app = 1 WHERE md_packid = '$pack_id' and md_projid='$proj_id'";
    $querybuyer = mssql_query($sqlbuyer);


    $mdsql = mssql_query("select isnull (max(ba_id+1),1) as id from  Swift_Buyer_approve");
    $md1 = mssql_fetch_array($mdsql);
    $baid = $md1['id'];
    //Mail Details
     $mail_sql3 = "insert into Swift_Buyer_approve (ba_id,ba_packid,ba_projid,remark,send_back,buyer_app,buyer_app_on)"
        . "values('" . $baid . "','" . $pack_id . "','" . $proj_id . "','$remarks','0','1','" . $po_actual . "')";
    $insert_buyer = mssql_query($mail_sql3);



    // transaction table functions
    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $id = $row['id'] + 1;
    // insert to transaction table
    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
            VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $recvstageid . "',GETDATE(),'" . $po_planned_date . "','" . $po_actual . "','" . $po_actual . "','" . $remarks . "','0')";
    $query = mssql_query($sql);


    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '15',
    to_stage_id = '16',cs_userid='$senduserid',from_remark = '$from_remark',
    from_uid=$to_uid,to_uid=$from_uid,cs_active=0 ,to_remark = '$remarks' ,
    cs_created_date='$po_actual',cs_expdate='" . $po_planned_date . "',cs_actual='" . $po_actual . "' WHERE cs_packid = '$pack_id'";
    //echo $sql2;exit;
    $query2 = mssql_query($sql2);

    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
    $row2 = mssql_fetch_array($isql2);
    $rsid = $row2['id'];


    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
        . "values('" . $rsid . "','" . $pack_id . "','" . $proj_id . "','15','16','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','" . mssql_escape1($remarks) . "',
        '" . $po_actual . "','" . $senduserid . "','" . $po_actual . "','" . $po_planned_date . "')";
    $insert3 = mssql_query($sql3);



    $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$pack_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$po_expected',ps_actualdate='$po_actual',ps_userid='$senduserid',ps_sbuid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$pack_id' AND ps_stageid = '16'";
    $query = mssql_query($sql);



    if ($insert_buyer) {
        echo "<script>window.location.href='../swift_distributor_history';</script>";
    } else {
        echo "not insert";
    }
} else if (isset($_POST['buyersend_back'])) {
    $pack_id   = $_POST['pack_id'];
    $proj_id   = $_POST['proj_id'];
    $po_actual = $_POST['po_actual'];
    $remarks   = sanitize($_POST['remarks']);
    // $flag_query = mssql_query("select top 1 * from  Swift_Mail_Details  where md_packid='$pack_id' and md_projid='$proj_id'and  flag=1 ");
    // $row_dist   = mssql_fetch_array($flag_query);
    $md_id = $_POST['senbackDist'];

    // $sqlbuyer = "UPDATE Swift_Buyer_approve SET remark ='$remarks', send_back = 1 WHERE ba_packid = '$pack_id' and ba_projid='$proj_id'";
    // $querybuyer = mssql_query($sqlbuyer);

    $mdsql = mssql_query("select isnull (max(ba_id+1),1) as id from  Swift_Buyer_approve");
    $md1 = mssql_fetch_array($mdsql);
    $baid = $md1['id'];
    //Mail Details
    $mail_sql3 = "insert into Swift_Buyer_approve (ba_id,ba_packid,ba_projid,remark,send_back,buyer_app,buyer_app_on)"
        . "values('" . $baid . "','" . $pack_id . "','" . $proj_id . "','$remarks','1','0','" . $po_actual . "')";
    $insert_buyer = mssql_query($mail_sql3);

    $sqlbuyer = "UPDATE Swift_Mail_Details SET send_back = 1, buyer_app=2 WHERE md_packid = '$pack_id' and md_projid='$proj_id' and md_id='$md_id' ";
    $querybuyer = mssql_query($sqlbuyer);

    echo $sqlbuyer = "UPDATE Swift_Disributor_log SET send_back = 1 WHERE dl_packid = '$pack_id' and dl_projid='$proj_id' and md_id = $md_id";
    $querybuyerbback = mssql_query($sqlbuyer);

    if ($querybuyerbback) {
        $send_email = $cls_comm->Send_Mail_Dist($proj_id, $pack_id, $md_id);

        echo "<script>window.location.href='../swift_distributor_history';</script>";
    } else {
        echo "not insert";
    }
}
}