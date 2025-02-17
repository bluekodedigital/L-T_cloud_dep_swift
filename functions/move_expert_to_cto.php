<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");






// if( isset($_SESSION['token']) && $csrf_token === $_SESSION['token']   ) {

if (isset($_POST['approve_package'])) {
    $exp_id = mssql_escape($_POST['exp_id']);
    $expdate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');
//    $actdate = formatDate(str_replace('/', '-', $_POST['act_date']), 'Y-m-d h:i:s');
    $actdate = date('Y-m-d');
    $remarks = mssql_escape($_POST['remarks']);
    $senduserid = $_SESSION['uid'];
    $sql = "select * from swift_techexpert where txp_id='" . $exp_id . "'";
    $query = mssql_query($sql);
    $result = array();
    while ($row = mssql_fetch_array($query)) {
        $projid = $row['txp_projid'];
        $packid = $row['txp_packid'];
        $flag = $row['txp_status'];
    }

    $sql1 = "select * from Project where proj_id= '" . $projid . "'";
    $qry = mssql_query($sql1);
    $r1 = mssql_fetch_array($qry);
    $segmentId = $r1['cat_id'];
if($_SESSION['milcom']=='1')
        {
         $cond=" and milcom_app='1'";   
        }else
        {
          $cond=" and milcom_app!='1'";      
        }
    if ($segmentId == 33) {
        $where = "and user_seg = '" . $segmentId . "' $cond";
    } else if ($segmentId == 37) {
        $where = "and user_seg = '" . $segmentId . "' $cond";
    } else if ($segmentId == 36) {
        $where = "and user_seg = '33' $cond";
    } else if ($segmentId == 35) {
        $where = "and user_seg = '33' $cond";
    } else {
        $where = " $cond";
    }

    $sql = "SELECT uid FROM usermst WHERE usertype='12' $where";
    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $recvid = $row['uid'];
    }
    $sendstageid = 5;
    $recvstageid = 6;

    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$packid' and ps_stageid = '$sendstageid'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];
    $txp_sentdate = date("Y-m-d h:i:s");
    $txp_planneddate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');


    // update tech expert status
    $sql = "UPDATE swift_techexpert SET txp_status = '1',txp_active='1',txp_expdate='$actdate',txp_actual='$actdate' WHERE txp_id = '$exp_id'";
    $query = mssql_query($sql);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',ps_userid='$recvid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$senduserid' WHERE ps_packid = '$packid' AND ps_stageid = '$sendstageid' AND ps_projid='$projid'";
    $query = mssql_query($sql);

    // insert to cto table
    $sql = "SELECT MAX(cto_id) as id FROM swift_techCTO;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $id = $row['id'] + 1;

    $sql = "SELECT * FROM swift_techCTO WHERE cto_projid='$projid' AND cto_packid='$packid'";

    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    $row1 = mssql_fetch_array($query);
    if ($num_rows > 0) {
        $sql = "UPDATE swift_techcto SET cto_active='0' WHERE cto_projid='$projid' AND cto_packid='$packid'";
        $query = mssql_query($sql);
    }
//    $remarks = mssql_escape1($remarks);
    $sql = "INSERT INTO swift_techCTO(cto_id,cto_packid,cto_projid,cto_senderuid,cto_recvuid,cto_sendr_stageid,cto_recv_stageid,cto_sentdate,cto_planneddate,cto_remarks,cto_status,cto_active) 
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $txp_sentdate . "','" . $txp_planneddate . "','" . $remarks . "','0','1')";
    $query = mssql_query($sql);
    if ($query) {
        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $sendstageid . "','" . $txp_sentdate . "','" . $txp_planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";


        $query = mssql_query($sql);



        $send_email = $cls_comm->send_email_tech($projid, $packid, $recvstageid, $recvid, $remarks, $sendstageid);

        if ($query) {
            if ($flag == 1 || $flag == 0) {
                echo "<script>window.location.href='../tech_expert_workflow';</script>";
            } else if ($flag == 2) {
                echo "<script>window.location.href='../tech_expert_sentbackfromcto';</script>";
            }
        } else {
            echo "not insert";
//            echo "<script>window.location.href='../tech_expert_workflow';</script>";
        }
    } else {
        echo "not success";
//        echo "<script>window.location.href='../tech_expert_workflow';</script>";
    }
} 
elseif (isset($_POST['sent_back_to_spoc'])) {
    $exp_id = mssql_escape($_POST['exp_id']);
    $expdate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');
//    $actdate = formatDate(str_replace('/', '-', $_POST['act_date']), 'Y-m-d h:i:s');
    $actdate = date('Y-m-d');
    $remarks = mssql_escape($_POST['remarks']);
    $senduserid = $_SESSION['uid'];
    $sql = "select * from swift_techexpert where txp_id='" . $exp_id . "'";
    $query = mssql_query($sql);
    $result = array();
    while ($row = mssql_fetch_array($query)) {
        $projid = $row['txp_projid'];
        $packid = $row['txp_packid'];
        $flag = $row['txp_status'];
        $recvid = $row['txp_senderuid'];
    }
    $sendstageid = 5;
    $recvstageid = 3;

    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$packid' and ps_stageid = '$sendstageid'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];
    $txp_sentdate = date("Y-m-d h:i:s");
    $txp_planneddate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');

    // update tech expert status
    $sql = "UPDATE swift_techexpert SET txp_status = '1',txp_active='1',txp_expdate='$actdate',txp_actual='$actdate' WHERE txp_id = '$exp_id'";
    $query = mssql_query($sql);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_stback=1,ps_sbuid='$recvid' WHERE ps_packid = '$packid' AND ps_stageid = '$recvstageid' AND ps_projid='$projid'";
    $query = mssql_query($sql);

    //insert into tech spoc table

    $isql = mssql_query("select isnull (max(ts_id+1),1) as id from  swift_techspoc");
    $row = mssql_fetch_array($isql);
    $ids = $row['id'];

    $sql = "select * from swift_techspoc WHERE ts_projid='$projid' AND ts_packid='$packid'";

    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    $row1 = mssql_fetch_array($query);
    if ($num_rows > 0) {
        $sql = "UPDATE swift_techspoc SET ts_active='0' WHERE ts_projid='$projid' AND ts_packid='$packid'";
        $query = mssql_query($sql);
    }

    $sql = "insert into swift_techspoc ( ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ts_planneddate,ts_remarks,ts_status,ts_active)"
            . "values('" . $ids . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $actdate . "','" . $txp_planneddate . "','" . $remarks . "','0','1')";
    $insert = mssql_query($sql);
    if ($query) {
        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $sendstageid . "','" . $txp_sentdate . "','" . $txp_planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";


        $query = mssql_query($sql);
        $send_email = $cls_comm->sendback_email($projid, $packid, $recvstageid, $recvid, $remarks, $sendstageid);

        if ($query) {

            echo "<script>window.location.href='../tech_expert_workflow';</script>";
        } else {
            echo "not insert";
//            echo "<script>window.location.href='../tech_expert_workflow';</script>";
        }
    } else {
        echo "not success";
//        echo "<script>window.location.href='../tech_expert_workflow';</script>";
    }
} 
else if (isset($_POST['sendtoreviewer'])) {
    $exp_id = mssql_escape($_POST['exp_id']);
    $expdate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');
//    $actdate = formatDate(str_replace('/', '-', $_POST['act_date']), 'Y-m-d h:i:s');
    $actdate = date('Y-m-d');
    $remarks = mssql_escape($_POST['remarks']);
    $senduserid = $_SESSION['uid'];
    $sql = "select * from swift_techexpert where txp_id='" . $exp_id . "'";
    $query = mssql_query($sql);
    $result = array();
    while ($row = mssql_fetch_array($query)) {
        $projid = $row['txp_projid'];
        $packid = $row['txp_packid'];
        $flag = $row['txp_status'];
    }

    $sql1 = "select * from Project where proj_id= '" . $projid . "'";
    $qry = mssql_query($sql1);
    $r1 = mssql_fetch_array($qry);
     
 
    $recvid = mssql_escape($_POST['reviewer']);  
    $sendstageid = 4;
    $recvstageid = 5;

    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$packid' and ps_stageid = '$sendstageid'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];
    $txp_sentdate = date("Y-m-d h:i:s");
    $txp_planneddate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');


    // update tech expert status
    $sql = "UPDATE swift_techexpert SET txp_status = '1',txp_active='1',txp_expdate='$actdate',txp_actual='$actdate' WHERE txp_id = '$exp_id'";
    $query = mssql_query($sql);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',ps_userid='$recvid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$senduserid' WHERE ps_packid = '$packid' AND ps_stageid = '$sendstageid' AND ps_projid='$projid'";
    $query = mssql_query($sql);

    // insert to cto table
    $sql = "SELECT MAX(techRev_id) as id FROM swift_techReviewer";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $id = $row['id'] + 1;

    $sql = "SELECT * FROM swift_techReviewer WHERE techRev_projid='$projid' AND techRev_packid='$packid'";

    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    $row1 = mssql_fetch_array($query);
    if ($num_rows > 0) {
        $sql = "UPDATE swift_techReviewer SET techRev_active='0' WHERE techRev_projid='$projid' AND techRev_packid='$packid'";
        $query = mssql_query($sql);
    }
//    $remarks = mssql_escape1($remarks);
    $sql = "INSERT INTO swift_techReviewer(techRev_id,techRev_packid,techRev_projid,techRev_senderuid,techRev_recvuid,techRev_sendr_stageid,techRev_recv_stageid,techRev_sentdate,techRev_planneddate,techRev_remarks,techRev_status,techRev_active) 
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $txp_sentdate . "','" . $txp_planneddate . "','" . $remarks . "','0','1')";
    $query = mssql_query($sql);
    if ($query) {
        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $sendstageid . "','" . $txp_sentdate . "','" . $txp_planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";

        $query = mssql_query($sql);

//        $send_email = $cls_comm->send_email_tech($projid, $packid, $recvstageid, $recvid, $remarks, $sendstageid);

        if ($query) {
            if ($flag == 1 || $flag == 0) {
                echo "<script>window.location.href='../tech_expert_workflow';</script>";
            } else if ($flag == 2) {
                echo "<script>window.location.href='../tech_expert_sentbackfromcto';</script>";
            }else if ($flag == 3) {
                echo "<script>window.location.href='../tech_expert_sentbackfromreviewer';</script>";
            }
        } else {
            echo "not insert";
//            echo "<script>window.location.href='../tech_expert_workflow';</script>";
        }
    } else {
        echo "not success";
//        echo "<script>window.location.href='../tech_expert_workflow';</script>";
    }
}
// }
// else {
//      die("CSRF token validation failed");
// }
?>