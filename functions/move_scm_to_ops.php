<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");
if (isset($_POST['scmreject'])) {
    $scm_id = $_POST['scm_id'];

    $expdate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');
//    $actdate = formatDate(str_replace('/', '-', $_POST['act_date']), 'Y-m-d h:i:s');
//        $expertid=$_POST['expert_id'];
    $remarks = $_POST['remarks'];
    // get project details query
    $sql = "SELECT * FROM swift_SCMSPOC WHERE sc_id = '$scm_id'";
    $actdate = date('Y-m-d');
    $query1 = mssql_query($sql);
    while ($row = mssql_fetch_array($query1)) {
        $proj_id = $row['sc_projid'];
        $pack_id = $row['sc_packid'];
        $recvid = $row['sc_senderuid'];
    }

    $senduserid = $_SESSION['uid'];
    $sendstageid = 13;
    $recvstageid = 8;

    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$pack_id' and ps_stageid = $sendstageid";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];

    $scm_sentdate = date("Y-m-d h:i:s");
    $scm_planneddate = formatDate(str_replace('/', '-', $planned_date), 'Y-m-d h:i:s');


    // update 
    $sql = "UPDATE swift_SCMSPOC SET sc_planneddate='" . $scm_planneddate . "',sc_expdate='" . $expdate . "',sc_actual='" . $actdate . "',sc_status='1',sc_active='0' WHERE sc_id = '$scm_id'";
    $query = mssql_query($sql);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$pack_id' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expdate',ps_stback=1 ,ps_actualdate='$actdate',ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$recvid' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);

    if (isset($_POST['scop_MajMin'])) {
        $scop_MajMin = mssql_escape($_POST['scop_MajMin']);
    } else {
        $scop_MajMin = 1;
    }



    // insert to expert table
    $sql = "SELECT MAX(scop_id) as id FROM swift_SCMtoOPS;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $sid = $row['id'] + 1;
    $sql = "SELECT * FROM swift_SCMtoOPS WHERE scop_projid='$proj_id' AND scop_packid='$pack_id'";
    $query = mssql_query($sql);
    $row1 = mssql_fetch_array($query);
    if ($row1 > 0) {
        $sql = "UPDATE swift_SCMtoOPS SET scop_active='0' WHERE scop_projid='$proj_id' AND scop_packid='$pack_id'";
        $query = mssql_query($sql);
    }
    $sql = "INSERT INTO swift_SCMtoOPS(scop_id,scop_packid,scop_projid,scop_senderuid,scop_recvuid,scop_sendr_stageid,scop_recv_stageid,scop_sentdate,scop_remarks,scop_status,scop_active,scop_MajMin) 
                VALUES('" . $sid . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $scm_sentdate . "','" . $remarks . "','0','1',$scop_MajMin)";
    $query = mssql_query($sql);


    if ($query) {
        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "','" . $scm_sentdate . "','" . $scm_planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";
        $query = mssql_query($sql);
        $send_email = $cls_comm->sendback_email($proj_id, $pack_id, $recvstageid, $recvid, $remarks, '13');
        if ($query) {
            echo "<script>window.location.href='../scm_workflow';</script>";
        } else {
            echo "not insert";
        }
    } else {
        echo "not success";
    }
}
if (isset($_POST['scmbuyerreject'])) {
    $scm_id = $_POST['scm_id'];

    $expdate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');
//     $actdate = formatDate(str_replace('/', '-', $_POST['act_date']), 'Y-m-d h:i:s');
    $actdate = date('Y-m-d');
//        $expertid=$_POST['expert_id'];
    $remarks = $_POST['remarks'];
    // get project details query
    $sql = "SELECT * FROM swift_SCMtoBUYER WHERE bu_id = '$scm_id'";

    $query1 = mssql_query($sql);
    $row = mssql_fetch_array($query1);
    $proj_id = $row['bu_projid'];
    $pack_id = $row['bu_packid'];
//    $recvid = $row['bu_senderuid'];
//            echo $sql;
//            print_r($row);
//             exit();
    $sql = " SELECT * FROM swift_packagemaster where pm_packid='$pack_id'";

    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $recvid = $row['pm_userid'];
    }

    $senduserid = $_SESSION['uid'];
    $sendstageid = 13;
    $recvstageid = 8;

    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$pack_id' and ps_stageid = $sendstageid";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];

    $scm_sentdate = date("Y-m-d h:i:s");
    $scm_planneddate = formatDate(str_replace('/', '-', $planned_date), 'Y-m-d h:i:s');


    // update 
    $sql = "UPDATE swift_SCMSPOC SET sc_planneddate='" . $scm_planneddate . "',sc_expdate='" . $expdate . "',sc_actual='" . $actdate . "',sc_status='1',sc_active='0' WHERE sc_id = '$scm_id'";
    $query = mssql_query($sql);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$pack_id' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expdate',ps_actualdate='$actdate',ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_stback=1,ps_sbuid='$recvid' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);

    // insert to expert table
    $sql = "SELECT MAX(scop_id) as id FROM swift_SCMtoOPS;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $sid = $row['id'] + 1;
    $sql = "SELECT * FROM swift_SCMtoOPS WHERE scop_projid='$proj_id' AND scop_packid='$pack_id'";
    $query = mssql_query($sql);
    $row1 = mssql_fetch_array($query);
    if ($row1 > 0) {
        $sql = "UPDATE swift_SCMtoOPS SET scop_active='0' WHERE scop_projid='$proj_id' AND scop_packid='$pack_id'";
        $query = mssql_query($sql);
    }
    $sql = "INSERT INTO swift_SCMtoOPS(scop_id,scop_packid,scop_projid,scop_senderuid,scop_recvuid,scop_sendr_stageid,scop_recv_stageid,scop_sentdate,scop_remarks,scop_status,scop_active) 
                VALUES('" . $sid . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $scm_sentdate . "','" . $remarks . "','0','1')";
    $query = mssql_query($sql);

    $update = mssql_query("update swift_SCMtoBUYER set bu_status='3' where bu_packid='$pack_id' and bu_projid='$proj_id'");

    if ($query) {
        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "','" . $scm_sentdate . "','" . $scm_planneddate . "','" . $expdate . "','" . $actdate . "','" . $remarks . "','0')";
        $query = mssql_query($sql);
        $send_email = $cls_comm->sendback_email($proj_id, $pack_id, $recvstageid, $recvid, $remarks, $sendstageid);
        if ($query) {
            echo "<script>window.location.href='../files_from_buyer';</script>";
        } else {
            echo "not insert";
        }
    } else {
        echo "not success";
    }
}
if (isset($_POST['allocatingtobuyer'])) {
    $buyer_id = $_POST['buyer_id'];
    $scm_id = $_POST['scmbu_id'];
    $expdate = formatDate(str_replace('/', '-', $_POST['al_act_date']), 'Y-m-d h:i:s');
//        $actdate = formatDate(str_replace('/', '-', $_POST['al_act_date']), 'Y-m-d h:i:s');
    $actdate = date('Y-m-d');
    $remarks = $_POST['remarks'];
    $ace_value = '';
    $sales_value = '';
    // get project details query
    $sql = "SELECT * FROM swift_SCMSPOC WHERE sc_id = '$scm_id'";
    $query1 = mssql_query($sql);
    while ($row = mssql_fetch_array($query1)) {
        $proj_id = $row['sc_projid'];
        $pack_id = $row['sc_packid'];
    }

    $senduserid = $_SESSION['uid'];
    $sendstageid = 13;
    $recvstageid = 14;
    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$pack_id' and ps_stageid = $sendstageid";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];
    $scm_sentdate = date("Y-m-d h:i:s");
    $scm_planneddate = formatDate(str_replace('/', '-', $planned_date), 'Y-m-d h:i:s');

    // update 
    $sql = "UPDATE swift_SCMSPOC SET sc_planneddate='" . $scm_planneddate . "',sc_expdate='" . $actdate . "',sc_actual='" . $actdate . "',sc_status='1',sc_active='1' WHERE sc_id = '$scm_id'";
    $query = mssql_query($sql);

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$pack_id' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',ps_userid='$buyer_id',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$senduserid' WHERE ps_packid = '$pack_id' AND ps_stageid = '$sendstageid' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);

    // insert to expert table
    $sql = "SELECT * FROM swift_SCMtoBUYER WHERE bu_projid='$proj_id' AND bu_packid='$pack_id'";
    $query = mssql_query($sql);
    $row1 = mssql_fetch_array($query);
    if ($row1 > 0) {
        $sql = "UPDATE swift_SCMtoBUYER SET bu_status='3' WHERE bu_projid='$proj_id' AND bu_packid='$pack_id'";
        $query = mssql_query($sql);
    }
    $sql = "SELECT MAX(bu_id) as id FROM swift_SCMtoBUYER;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $sid = $row['id'] + 1;
    $sql = "INSERT INTO swift_SCMtoBUYER(bu_id,bu_packid,bu_projid,bu_senderuid,bu_buyer_id,bu_sentdate,bu_remarks,bu_ace_value,bu_sales_value,bu_status) 
                VALUES('" . $sid . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $buyer_id . "','" . $scm_sentdate . "','" . $remarks . "','" . $ace_value . "','" . $sales_value . "','0')";
    $query = mssql_query($sql);
    if ($query) {
        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "','" . $scm_sentdate . "','" . $scm_planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";
        $query = mssql_query($sql);
        $send_email = $cls_comm->send_email($proj_id, $pack_id, $recvstageid, $buyer_id, $remarks, '13');
        if ($query) {
            echo "<script>window.location.href='../scm_workflow';</script>";
        } else {
            echo "not insert";
        }
    } else {
        echo "not success";
    }
}
if (isset($_POST['buyer_realocate'])) {
    $row_id = $_POST['row_id'];
    $buyer_id = $_POST['buyer_id'];
    $ace_value = $_POST['ace_value'];
    $sales_value = $_POST['sales_value'];
    $remarks = $_POST['remarks'];
    $senduserid = $_SESSION['uid'];
    $scm_sentdate = date("Y-m-d h:i:s");
    $sendstageid = 13;
    $recvstageid = 14;

    $sql = "SELECT * FROM swift_SCMtoBUYER WHERE bu_id = '$row_id'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $proj_id = $row['bu_projid'];
    $pack_id = $row['bu_packid'];

    $sql = "UPDATE swift_SCMtoBUYER SET bu_status='3' WHERE bu_id = '$row_id'";
    $query = mssql_query($sql);


    $sql = "SELECT MAX(bu_id) as id FROM swift_SCMtoBUYER;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $sid = $row['id'] + 1;
    $sql = "INSERT INTO swift_SCMtoBUYER(bu_id,bu_packid,bu_projid,bu_senderuid,bu_buyer_id,bu_sentdate,bu_remarks,bu_ace_value,bu_sales_value,bu_status) 
                VALUES('" . $sid . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $buyer_id . "','" . $scm_sentdate . "','" . $remarks . "','" . $ace_value . "','" . $sales_value . "','0')";
    $query = mssql_query($sql);

    $sql = "UPDATE swift_packagestatus SET ps_userid='$buyer_id',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$senduserid' WHERE ps_packid = '$pack_id' AND ps_stageid = '$sendstageid' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);
    $send_email = $cls_comm->send_email($proj_id, $pack_id, $recvstageid, $buyer_id, $remarks, $sendstageid);
    if ($query) {
        echo "<script>window.location.href='../files_from_buyer';</script>";
    } else {
        echo "not insert";
    }
} 
if (isset($_POST['scmrejecttoexpert'])) {
    $scm_id = $_POST['scm_id'];

    $expdate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');
//    $actdate = formatDate(str_replace('/', '-', $_POST['act_date']), 'Y-m-d h:i:s');
//        $expertid=$_POST['expert_id'];
    $remarks = $_POST['remarks'];
    // get project details query
    $sql = "SELECT * FROM swift_SCMSPOC WHERE sc_id = '$scm_id'";
    $actdate = date('Y-m-d');
    $query1 = mssql_query($sql);
    while ($row = mssql_fetch_array($query1)) {
        $proj_id = $row['sc_projid'];
        $pack_id = $row['sc_packid'];  
//        $recvid = $row['sc_senderuid'];
    }

    $sql1 = "select * from swift_techexpert where txp_packid='" . $pack_id . "' and txp_active=1";
//    $sql1 = "SELECT * FROM swift_techReviewer WHERE techRev_packid='" . $packid . "' and  techRev_status=1 and techRev_active=1";
    $query1 = mssql_query($sql1);
    $row1 = mssql_fetch_array($query1);
   $recvid = $row1['txp_recvuid'];   

    $senduserid = $_SESSION['uid'];
    $sendstageid = 13;
    $recvstageid = 4;

    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$pack_id' and ps_stageid = $sendstageid";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];

    $scm_sentdate = date("Y-m-d h:i:s");
    $scm_planneddate = formatDate(str_replace('/', '-', $planned_date), 'Y-m-d h:i:s');


    // update 
    $sql = "UPDATE swift_SCMSPOC SET sc_planneddate='" . $scm_planneddate . "',sc_expdate='" . $expdate . "',sc_actual='" . $actdate . "',sc_status='1',sc_active='0' WHERE sc_id = '$scm_id'";
    $query = mssql_query($sql);
    
    
    
    
    

    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$pack_id' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$expdate',ps_stback=1 ,ps_actualdate='$actdate',ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$recvid' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);

    if (isset($_POST['scop_MajMin'])) {
        $scop_MajMin = mssql_escape($_POST['scop_MajMin']);
    } else {
        $scop_MajMin = 1;
    }

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
    $sql = "INSERT INTO swift_techexpert(txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,txp_planneddate,txp_remarks,txp_status,txp_active,txp_MajMin) 
                VALUES('" . $txpid . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $recvid . "','" . $sendstageid . "','" . $recvstageid . "','" . $actdate . "','','" . $remarks . "','0','1',$scop_MajMin)";
    $query = mssql_query($sql);


    if ($query) {
        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "','" . $scm_sentdate . "','" . $scm_planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";
        $query = mssql_query($sql);
        $send_email = $cls_comm->sendback_email($proj_id, $pack_id, $recvstageid, $recvid, $remarks, '13');
        if ($query) {
            echo "<script>window.location.href='../scm_workflow';</script>";
        } else {
            echo "not insert";
        }
    } else {
        echo "not success";
    }
}
?>