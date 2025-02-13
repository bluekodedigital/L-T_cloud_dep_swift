<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");

if (isset($_POST['approve_package'])) {
    $cto_id = $_POST['cto_id'];
    $expdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));
//        $actdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['act_date'])));
    $remarks = $_POST['remarks'];
    $actdate = date('Y-m-d');
    $sql = "SELECT * FROM swift_techCTO WHERE cto_id='" . $cto_id . "'";
    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $projid = $row['cto_projid'];
        $packid = $row['cto_packid'];
    }
    $senduserid = $_SESSION['uid'];
    $sendstageid = 6;
    $recvstageid = 8;

//    $sql = "SELECT ts_senderuid FROM swift_techspoc WHERE ts_projid= '$projid' AND ts_packid = '$packid' AND ts_status = '1' AND ts_active = '1'";
    $sql = " SELECT * FROM swift_packagemaster where pm_packid='$packid'";

    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $recvid = $row['pm_userid'];
    }

    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date from swift_packagestatus where ps_packid = '$packid' and ps_stageid = $sendstageid";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];

    $ctops_sentdate = date("Y-m-d h:i:s");
    $ctops_planneddate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));

    // update techcto status
    $sql = "UPDATE swift_techCTO SET cto_status = '1',cto_active='1',cto_expdate='$actdate',cto_actual='$actdate' WHERE cto_id = '$cto_id'";
    $query = mssql_query($sql);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expdate',ps_actualdate='$actdate',ps_userid='$recvid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$senduserid' WHERE ps_packid = '$packid' and ps_stageid = $sendstageid";
    $query = mssql_query($sql);

    // insert to cto table

    $sql = "SELECT MAX(ctops_id) as id FROM swift_CTOtoOPS;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $id = $row['id'] + 1;

    $sql = "SELECT * FROM swift_CTOtoOPS WHERE ctops_projid='$projid' AND ctops_packid='$packid'";
    $query = mssql_query($sql);
    $row1 = mssql_fetch_array($query);
    if ($row1 > 0) {
        $sql = "UPDATE swift_CTOtoOPS SET ctops_active='0' WHERE ctops_projid='$projid' AND ctops_packid='$packid'";
        $query = mssql_query($sql);
    }
    $sql = "INSERT INTO swift_CTOtoOPS(ctops_id,ctops_packid,ctops_projid,ctops_senderuid,ctops_recvuid,ctops_sendr_stageid,ctops_recv_stageid,ctops_sentdate,ctops_planneddate,ctops_remarks,ctops_status,ctops_active)
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $ctops_sentdate . "','" . $ctops_planneddate . "','" . $remarks . "','0','1')";
    $query = mssql_query($sql);
    if ($query) {
        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $sendstageid . "','" . $ctops_sentdate . "','" . $ctops_planneddate . "','" . $expdate . "','" . $actdate . "','" . $remarks . "','0')";
        $query = mssql_query($sql);
        $send_email = $cls_comm->send_email($projid, $packid, $recvstageid, $recvid, $remarks, $sendstageid);
        if ($query) {
            echo "<script>window.location.href='../tech_cto_workflow';</script>";
        } else {
            echo "not insert";
        }
    } else {
        echo "not success";
    }
}
if (isset($_POST['reject_package'])) {
    $cto_id = $_POST['cto_id'];
    $expdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));
//        $actdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['act_date'])));
    $remarks = $_POST['remarks'];
    $actdate = date('Y-m-d');
    $sql = "SELECT * FROM swift_techCTO WHERE cto_id='" . $cto_id . "'";

    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $projid = $row['cto_projid'];
        $packid = $row['cto_packid'];
    }
    $sql1 = "select * from swift_techexpert where txp_packid='" . $packid . "' and txp_active=1";
//    $sql1 = "SELECT * FROM swift_techReviewer WHERE techRev_packid='" . $packid . "' and  techRev_status=1 and techRev_active=1";
    $query1 = mssql_query($sql1);
    $row1 = mssql_fetch_array($query1);
    $recvid = $row1['txp_recvuid'];

    $senduserid = $_SESSION['uid'];
    $sendstageid = 6;
    $recvstageid = 5;

    // insert to expert table
    $sql = "SELECT MAX(txp_id) as id FROM swift_techexpert;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $txpid = $row['id'] + 1;
    $sql = "SELECT * FROM swift_techexpert WHERE txp_projid='$projid' AND txp_packid='$packid'";
    $query = mssql_query($sql);
    $row1 = mssql_fetch_array($query);
    if ($row1 > 0) {
        $sql = "UPDATE swift_techexpert SET txp_active='0' WHERE txp_projid='$projid' AND txp_packid='$packid'";
        $query = mssql_query($sql);
    }
    $sql = "INSERT INTO swift_techexpert(txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,txp_planneddate,txp_remarks,txp_status,txp_active) 
                VALUES('" . $txpid . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $actdate . "','','" . $remarks . "','2','1')";
    $query = mssql_query($sql);
    if ($query) {
        // update techcto status
        $sql = "UPDATE swift_techCTO SET cto_status = '1',cto_active='1',cto_expdate='$actdate',cto_actual='$actdate' WHERE cto_id = '$cto_id'";
        $query = mssql_query($sql);
    }
    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expdate',ps_actualdate='$actdate',ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_stback='1',ps_sbuid='$recvid' WHERE ps_packid = '$packid' AND ps_stageid = '$sendstageid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $send_email = $cls_comm->sendback_email($projid, $packid, $recvstageid, $recvid, $remarks, '6');
    if ($query) {
        echo "<script>window.location.href='../tech_cto_workflow';</script>";
    } else {
        echo "not insert";
    }
}
if (isset($_POST['sendtocto'])) {
    $cto_id = $_POST['cto_id'];
    $cto_user_id =$_POST['cto_user_id'];
    $expdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));
//        $actdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['act_date'])));
    $remarks = $_POST['remarks'];
    $actdate = date('Y-m-d');
    $sql = "SELECT * FROM swift_techReviewer WHERE techRev_id='" . $cto_id . "'";
    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $projid = $row['techRev_projid'];
        $packid = $row['techRev_packid'];
        $flag = $row['techRev_status'];
    }
    $senduserid = $_SESSION['uid'];

    $s1 = "select * from swift_SCMtoOPS where scop_MajMin =1 and scop_active =1 and  scop_packid=$packid";
    $ql = mssql_query($s1);
    $r1 = mssql_fetch_array($ql);
    $nrows1 = mssql_num_rows($ql);
    if ($nrows1 > 0) {
        $nrows = 1;
    } else {
        $s2 = "select * from swift_techexpert where txp_MajMin =1 and txp_active =1 and  txp_packid=$packid";
        $q2 = mssql_query($s2);
        $r2 = mssql_fetch_array($q2);
        $nrows2 = mssql_num_rows($q2);
        if ($nrows2 > 0) {
            $nrows = 1;
        }else{
            $nrows = 0;
        }
    }


    if ($nrows > 0) {
        $sendstageid = 5;
        $recvstageid = 8;

//    $sql = "SELECT ts_senderuid FROM swift_techspoc WHERE ts_projid= '$projid' AND ts_packid = '$packid' AND ts_status = '1' AND ts_active = '1'";
        $sql = " SELECT * FROM swift_packagemaster where pm_packid='$packid'";

        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $recvid = $row['pm_userid'];
        }

        // get planned date query
        $sql = "SELECT ps_planneddate as planned_date from swift_packagestatus where ps_packid = '$packid' and ps_stageid = $sendstageid";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $planned_date = $row['planned_date'];

        $ctops_sentdate = date("Y-m-d h:i:s");
        $ctops_planneddate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));

        // update techcto status
//        $sql = "UPDATE swift_techCTO SET cto_status = '1',cto_active='1',cto_expdate='$actdate',cto_actual='$actdate' WHERE cto_id = '$cto_id'";
//        $query = mssql_query($sql);

        $sql = "UPDATE swift_techReviewer SET techRev_status = '1',techRev_active='1',techRev_expdate='$actdate',techRev_actual='$actdate' WHERE techRev_id = '$cto_id'";
        $query = mssql_query($sql);

        // update package status
        $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
        $query = mssql_query($sql);
      $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expdate',ps_actualdate='$actdate',ps_userid='$recvid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$senduserid' WHERE ps_packid = '$packid' and ps_stageid = $sendstageid";
        $query = mssql_query($sql);


        // insert to cto table

        $sql = "SELECT MAX(ctops_id) as id FROM swift_CTOtoOPS;";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        $sql = "SELECT * FROM swift_CTOtoOPS WHERE ctops_projid='$projid' AND ctops_packid='$packid'";
        $query = mssql_query($sql);
        $row1 = mssql_fetch_array($query);
        if ($row1 > 0) {
            $sql = "UPDATE swift_CTOtoOPS SET ctops_active='0' WHERE ctops_projid='$projid' AND ctops_packid='$packid'";
            $query = mssql_query($sql);
        }
        $sql = "INSERT INTO swift_CTOtoOPS(ctops_id,ctops_packid,ctops_projid,ctops_senderuid,ctops_recvuid,ctops_sendr_stageid,ctops_recv_stageid,ctops_sentdate,ctops_planneddate,ctops_remarks,ctops_status,ctops_active)
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $ctops_sentdate . "','" . $ctops_planneddate . "','" . $remarks . "','0','1')";
        $query = mssql_query($sql);
        if ($query) {
            $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
            $query = mssql_query($sql);
            $row = mssql_fetch_array($query);
            $id = $row['id'] + 1;

            // insert to transaction table
            $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $sendstageid . "','" . $ctops_sentdate . "','" . $ctops_planneddate . "','" . $expdate . "','" . $actdate . "','" . $remarks . "','0')";
            $query = mssql_query($sql);
            $send_email = $cls_comm->send_email($projid, $packid, $recvstageid, $recvid, $remarks, $sendstageid);
            if ($query) {
                echo "<script>window.location.href='../tech_cto_workflow';</script>";
            } else {
                echo "not insert";
            }
        } else {
            echo "not success";
        }
    } 
    else {


        $sendstageid = 5;
        $recvstageid = 6;

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
//        while ($row = mssql_fetch_array($query)) {
//            $recvid = $row['uid'];
//        }
        $recvid = $cto_user_id;

        // get planned date query
        $sql = "SELECT ps_planneddate as planned_date from swift_packagestatus where ps_packid = '$packid' and ps_stageid = $sendstageid";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $planned_date = $row['planned_date'];

        $ctops_sentdate = date("Y-m-d h:i:s");
        $ctops_planneddate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));

        // update techcto status
        $sql = "UPDATE swift_techReviewer SET techRev_status = '1',techRev_active='1',techRev_expdate='$actdate',techRev_actual='$actdate' WHERE techRev_id = '$cto_id'";
        $query = mssql_query($sql);

        // update package status
        $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
        $query = mssql_query($sql);
        $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expdate',ps_actualdate='$actdate',ps_userid='$recvid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$senduserid' WHERE ps_packid = '$packid' and ps_stageid = $sendstageid"; 
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
            $sql = "UPDATE swift_techCTO SET cto_active='0' WHERE cto_projid='$projid' AND cto_packid='$packid'";
            $query = mssql_query($sql);
        }
//    $remarks = mssql_escape1($remarks);
       $sql = "INSERT INTO swift_techCTO(cto_id,cto_packid,cto_projid,cto_senderuid,cto_recvuid,cto_sendr_stageid,cto_recv_stageid,cto_sentdate,cto_planneddate,cto_remarks,cto_status,cto_active) 
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $ctops_sentdate . "','" . $ctops_planneddate . "','" . $remarks . "','0','1')"; 
        $query = mssql_query($sql);



        if ($query) {
            $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
            $query = mssql_query($sql);
            $row = mssql_fetch_array($query);
            $id = $row['id'] + 1;

            // insert to transaction table
            $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $sendstageid . "','" . $ctops_sentdate . "','" . $ctops_planneddate . "','" . $expdate . "','" . $actdate . "','" . $remarks . "','0')";
            $query = mssql_query($sql);
            $send_email = $cls_comm->send_email($projid, $packid, $recvstageid, $recvid, $remarks, $sendstageid);
            if ($query) {
                if ($flag == 0) {
                    echo "<script>window.location.href='../tech_reviewer_workflow';</script>";
                } else {
                    echo "<script>window.location.href='../tech_reviewer_workflowfromcto';</script>";
                }
            } else {
                echo "not insert";
            }
        } else {
            echo "not success";
        }
    }
}
if (isset($_POST['reject_packagebyreviewer'])) {
    $cto_id = $_POST['cto_id'];
    $expdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));
//        $actdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['act_date'])));
    $remarks = $_POST['remarks'];
    $actdate = date('Y-m-d');
    $sql = "SELECT * FROM swift_techReviewer WHERE techRev_id='" . $cto_id . "'";
    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $projid = $row['techRev_projid'];
        $packid = $row['techRev_packid'];
        $recvid = $row['techRev_senderuid'];
    }
    $senduserid = $_SESSION['uid'];
    $sendstageid = 5;
    $recvstageid = 4;

    // insert to expert table
    $sql = "SELECT MAX(txp_id) as id FROM swift_techexpert";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $txpid = $row['id'] + 1;

    $sql = "SELECT * FROM swift_techexpert WHERE txp_projid='$projid' AND txp_packid='$packid'";
    $query = mssql_query($sql);
    $row1 = mssql_fetch_array($query);
    if ($row1 > 0) {
        $sql = "UPDATE swift_techexpert SET txp_active='0' WHERE txp_projid='$projid' AND txp_packid='$packid'";
        $query = mssql_query($sql);
    }
    $sql = "INSERT INTO swift_techexpert(txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,txp_planneddate,txp_remarks,txp_status,txp_active) 
                VALUES('" . $txpid . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $actdate . "','','" . $remarks . "','3','1')";
    $query = mssql_query($sql);
    if ($query) {
        // update techcto status
        $sql = "UPDATE swift_techReviewer SET techRev_status = '1',techRev_active='1',techRev_expdate='$actdate',techRev_actual='$actdate' WHERE techRev_id = '$cto_id'";
        $query = mssql_query($sql);
    }
    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expdate',ps_actualdate='$actdate',ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_stback='1',ps_sbuid='$recvid' WHERE ps_packid = '$packid' AND ps_stageid = '$sendstageid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $send_email = $cls_comm->sendback_email($projid, $packid, $recvstageid, $recvid, $remarks, '6');
    if ($query) {
        echo "<script>window.location.href='../tech_reviewer_workflow';</script>";
    } else {
        echo "not insert";
    }
}
if (isset($_POST['sentbacktoreviewer'])) {
    $cto_id = $_POST['cto_id'];
    $expdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));
//        $actdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['act_date'])));
    $remarks = $_POST['remarks'];
    $actdate = date('Y-m-d');
    $sql = "SELECT * FROM swift_techCTO WHERE cto_id='" . $cto_id . "'";
    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $projid = $row['cto_projid'];
        $packid = $row['cto_packid'];
        $recvid = $row['cto_senderuid'];
    }
    $senduserid = $_SESSION['uid'];
    $sendstageid = 6;
    $recvstageid = 5;



    // insert to reviewer table
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
                VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $actdate . "','','" . $remarks . "','2','1')";
    $query = mssql_query($sql);



    if ($query) {
        // update techcto status
        $sql = "UPDATE swift_techCTO SET cto_status = '1',cto_active='1',cto_expdate='$actdate',cto_actual='$actdate' WHERE cto_id = '$cto_id'";
        $query = mssql_query($sql);
    }
    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expdate',ps_actualdate='$actdate',ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_stback='1',ps_sbuid='$recvid' WHERE ps_packid = '$packid' AND ps_stageid = '$sendstageid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $send_email = $cls_comm->sendback_email($projid, $packid, $recvstageid, $recvid, $remarks, '6');
    if ($query) {
        echo "<script>window.location.href='../tech_cto_workflow';</script>";
    } else {
        echo "not insert";
    }
}
?>