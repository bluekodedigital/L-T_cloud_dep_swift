<?php
// error_reporting(1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");
if (isset($_POST['approve_package'])) {
    $spoc_id = $_POST['spoc_id'];
    $expdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));
//        $actdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['act_date'])));
    $actdate = date('Y-m-d');
    $expertid = $_POST['expert_id'];
    $remarks = $_POST['remarks'];
    $next_stage = $_POST['next_stage'];exit;
    // get project details query
    $sql = "select * from swift_techspoc where ts_id='$spoc_id'";
    $query1 = mssql_query($sql);
    while ($row = mssql_fetch_array($query1)) {
        $proj_id = $row['ts_projid'];
        $pack_id = $row['ts_packid'];
    }

    $senduserid = $_SESSION['uid'];
    $recvid = $_POST['expert_id'];
    $sendstageid = 3;
    $recvstageid = 4;
//    $recvstageid = 5;


    $get_projname = mssql_query(" select proj_name from   dbo.Project where proj_id='" . $proj_id . "'");
    $pnameqrow = mssql_fetch_array($get_projname);

    $get_packname = mssql_query(" select package_name from dbo.package_mst where pk_id='$pack_id'");
    $packnameqrow = mssql_fetch_array($get_packname);

    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$pack_id' and ps_stageid = $sendstageid";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];

    $txp_sentdate = date("Y-m-d h:i:s");
    $txp_planneddate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $planned_date)));
    $txp_status = 0;
    $txp_action = 1;

    // update tech spoc status
    $sql = "UPDATE swift_techspoc SET ts_status = '1',ts_active='1',ts_expdate='" . $actdate . "',ts_actual='" . $actdate . "' WHERE ts_id = '$spoc_id'";
    $query = mssql_query($sql);
    $sql2 = "UPDATE swift_workflow_CurrentStage SET cs_active='1',cs_expdate='" . $actdate . "',cs_actual='" . $actdate . "' WHERE cs_packid = '$spoc_id'";
    $query2 = mssql_query($sql2);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$pack_id' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',ps_userid='$recvid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$senduserid' WHERE ps_packid = '$pack_id' AND ps_stageid = '$sendstageid' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);

    // insert to expert table
    $sql = "SELECT MAX(txp_id) as id FROM swift_techexpert;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $txpid = $row['id'] + 1;
    $sql = "SELECT * FROM swift_techexpert WHERE txp_projid='$proj_id' AND txp_packid='$pack_id'";
    $query = mssql_query($sql);
    $row1 = mssql_fetch_array($query);
    if ($row1 > 0) {
        $sql = "UPDATE swift_techexpert SET txp_active='0' WHERE txp_projid='$proj_id' AND txp_packid='$pack_id'";
        $query = mssql_query($sql);
    }
    $sql = "INSERT INTO swift_techexpert(txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,txp_planneddate,txp_remarks,txp_status,txp_active) 
                VALUES('" . $txpid . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $txp_sentdate . "','" . $txp_planneddate . "','" . $remarks . "','0','1')";
    $query = mssql_query($sql);
    if ($query) {
        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "','" . $txp_sentdate . "','" . $txp_planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";
        $query = mssql_query($sql);
        $send_email=$cls_comm->send_email_tech($proj_id,$pack_id,$recvstageid,$recvid,$remarks,$sendstageid);
        if ($query) {
            echo "<script>window.location.href='../tech_spoc_workflow';</script>";
        } else {
            echo "not insert";
        }
    } else {
        echo "not success";
    }
}
?>