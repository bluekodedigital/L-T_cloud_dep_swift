<?php
// error_reporting(1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$milcom = $_SESSION['milcom'];
include_once("../config/inc_function.php");
$csrf_token = $_REQUEST['csrf_token'];
if (isset($_SESSION['token']) && $csrf_token === $_SESSION['token']) {
if (isset($_POST['approve_package'])) {
    $pack_id = $_POST['packageid'];
    $proj_id = $_POST['projectid'];

    $expdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));
    $actdate = date('Y-m-d');
    $forward     = $_POST['forwardto'];
    if ($forward == '') {
        $recvid  = $_POST['forward'];
    } else {
        $recvid  = $_POST['forwardto'];
    }

    $remarks     = sanitize($_POST['remarks']);
    $sendstageid = $_POST['cur_stage'];
    $recvstageid = $_POST['next_stage'];
    $senduserid  = $_SESSION['uid'];
    // get project details query
    $sql = "SELECT * from swift_workflow_CurrentStage where cs_packid='$pack_id' and cs_projid='$proj_id'";
    $query1 = mssql_query($sql);
    while ($row = mssql_fetch_array($query1)) {
        //$proj_id = $row['cs_projid'];
        $pack_id = $row['cs_packid'];
        $from_remark = $row['to_remark'];
    }
    // $get_projname = mssql_query(" select proj_name from   dbo.Project where proj_id='" . $proj_id . "'");
    // $pnameqrow = mssql_fetch_array($get_projname);

    // $get_packname = mssql_query(" select package_name from dbo.package_mst where pk_id='$pack_id'");
    // $packnameqrow = mssql_fetch_array($get_packname);

    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$pack_id' and ps_stageid = $sendstageid";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];
    $txp_sentdate = date("Y-m-d h:i:s");
    $txp_planneddate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $planned_date)));
    //By uma New Work Flow
    //Final Approval 
    if ($recvstageid == '') {
        echo "true";
        $sql = "UPDATE swift_repository SET rs_active = '2' WHERE rs_packid = '$pack_id' AND rs_to_stage = '$sendstageid' AND rs_projid= '$proj_id'";
        $query = mssql_query($sql);
        $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '$sendstageid',
        to_stage_id = '$recvstageid' ,from_uid ='$senduserid', to_uid='$recvid' ,cs_userid='$senduserid' ,
        from_remark = '$from_remark',cs_active=2, to_remark = '$remarks' ,cs_created_date='$actdate',cs_expdate='" . $planned_date . "',cs_actual='" . $actdate . "' WHERE cs_packid = '$pack_id'";
        $query2 = mssql_query($sql2);
    } else {
        if ($recvstageid == '10') {
            $buyer_id = $recvid;
            $scm_id   = $_POST['scmbu_id'];
            //$expdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['al_act_date'])));
            //        $actdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['al_act_date'])));
            //$actdate = date('Y-m-d');
            // $remarks = $_POST['remarks'];
            $ace_value = '';
            $sales_value = '';
            // get project details query
            // $sql = "SELECT * FROM swift_SCMSPOC WHERE sc_id = '$scm_id' and sc_projid='" . $proj_id . "'";
            // $query1 = mssql_query($sql);
            // while ($row = mssql_fetch_array($query1)) {
            //     $proj_id = $row['sc_projid'];
            //     $pack_id = $row['sc_packid'];
            // }

            //$senduserid = $_SESSION['uid'];
            // get planned date query
            // $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$pack_id' and ps_stageid = $sendstageid";
            // $query = mssql_query($sql);
            // $row = mssql_fetch_array($query);
            // $planned_date = $row['planned_date'];
            // $scm_sentdate = date("Y-m-d h:i:s");
            // $scm_planneddate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $planned_date)));

            // update 
            $sql = "UPDATE swift_SCMSPOC SET sc_planneddate='" . $txp_planneddate . "',sc_expdate='" . $actdate . "',sc_actual='" . $actdate . "',sc_status='1',sc_active='1' WHERE sc_id = '$scm_id'";
            $query = mssql_query($sql);

            // update package status
            // $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$pack_id' AND ps_projid= '$proj_id'";
            // $query = mssql_query($sql);
            // $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',ps_userid='$buyer_id',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$senduserid' WHERE ps_packid = '$pack_id' AND ps_stageid = '$sendstageid' AND ps_projid= '$proj_id'";
            // $query = mssql_query($sql);

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
                    VALUES('" . $sid . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $buyer_id . "','" . $txp_sentdate . "','" . $remarks . "','" . $ace_value . "','" . $sales_value . "','0')";
            $query = mssql_query($sql);
            // if ($query) {
            // $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
            // $query = mssql_query($sql);
            // $row = mssql_fetch_array($query);
            // $id = $row['id'] + 1;

            // insert to transaction table
            // $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
            //     VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "','" . $scm_sentdate . "','" . $scm_planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";
            // $query = mssql_query($sql);
            // $send_email = $cls_comm->send_email($proj_id, $pack_id, $recvstageid, $buyer_id, $remarks, '13');
            if ($query) {
                echo "<script>window.location.href='../swift_workflow';</script>";
            } else {
                echo "not insert";
            }
            // } else {
            //     echo "not success";
            // }
        } elseif ($sendstageid == '13') {
            $loi_number     = sanitize($_POST['loi_number']);
            $loi_date       = $_POST['loi_date'];
            $po_wo_status   = $_POST['po_wo'];
            $hpc_app        = $_POST['hpc_app'];
            $checkflag      = $_POST['deal_checkbox'];
            $type           = $_POST['type'];
            $dist_name      = $_POST['dist_name'];
            $dist_mobno      = $_POST['dist_mobno'];
            $dist_mailid     = $_POST['dist_mailid'];
            $rowcount = count($dist_name);
            
            $po_com = 0;
            $wo_com = 0;
            if ($po_wo_status == 1) {
                $powo_flag = 0;
                $wo_flag = 0;
                $emr_flag = 1;
            } else if ($po_wo_status == 2) {
                $powo_flag = 0;
                $wo_flag = 1;
                $emr_flag = 0;
            } else if ($po_wo_status == 3) {
                $powo_flag = 0;
                $wo_flag = 0;
                $emr_flag = 1;
            }
            if (isset($_POST['deal_checkbox'])) {
                $deal_flag = 1;
            } else {
                $deal_flag = 0;
            }
           //Site plan only
           $name      = sanitize($_POST['site_name']);
           $mobno     = sanitize($_POST['site_mobno']);
           $mailid    = sanitize($_POST['site_mailid']);

           $mdsql = mssql_query("select isnull (max(md_id+1),1) as id from  Swift_Mail_Details");
           $md1 = mssql_fetch_array($mdsql);
           $mdid = $md1['id'];
           $loi_sql3 = "insert into Swift_Mail_Details (md_id,md_packid,md_projid,md_date,contact_name,mobile_no,email_id,flag,deal_path,send_back)"
               . "values('" . $mdid . "','" . $pack_id . "','" . $proj_id . "','$txp_sentdate','" . $name . "','" . $mobno . "','" . $mailid . "','0','" . $deal_flag . "','0')";
           $insert_loi = mssql_query($loi_sql3);
            //Distributor details only
            if ($deal_flag == 1) {
                for ($i = 0; $i < $rowcount; $i++) {
                    //$flag = $i;
                   
                    $flag      = $_POST['type'][$i];
                    $name      = sanitize($_POST['dist_name'][$i]);
                    $mobno     = sanitize($_POST['dist_mobno'][$i]);
                    $mailid    = sanitize($_POST['dist_mailid'][$i]); 

                    $mdsql = mssql_query("select isnull (max(md_id+1),1) as id from  Swift_Mail_Details");
                    $md1 = mssql_fetch_array($mdsql);
                    $mdid = $md1['id'];
                    $loi_sql3 = "insert into Swift_Mail_Details (md_id,md_packid,md_projid,md_date,contact_name,mobile_no,email_id,flag,deal_path,send_back)"
                        . "values('" . $mdid . "','" . $pack_id . "','" . $proj_id . "','$txp_sentdate','" . $name . "','" . $mobno . "','" . $mailid . "','" . $flag  . "','" . $deal_flag . "','0')";
                    $insert_loi = mssql_query($loi_sql3);
                }
            }

            
            $pwsql = mssql_query("select isnull (max(pw_id+1),1) as id from  Swift_po_wo_Details");
            $pw1 = mssql_fetch_array($pwsql);
            $pwid = $pw1['id'];
            $loi_sql3 = "insert into Swift_po_wo_Details 
                    (pw_id,pw_packid,pw_projid,pw_date,loi_number,loi_date,po_wo_status,flag,po_complete,wo_complete,emr_flag,wo_flag)"
                . "values('" . $pwid . "','" . $pack_id . "','" . $proj_id . "','$txp_sentdate','" .  $loi_number . "',
                  '" . $loi_date . "','" . $po_wo_status . "','" . $powo_flag . "' ,'" . $po_com  . "','" . $wo_com  . "','" . $emr_flag . "','" . $wo_flag . "')";
            $insert_loi = mssql_query($loi_sql3);

            if ($insert_loi) {
                echo "<script>window.location.href='../buyer_dash';</script>";
            } else {
                echo "not insert";
            }
        }
    }

    //current stage
    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '$sendstageid',
    to_stage_id = '$recvstageid' ,from_uid ='$senduserid', to_uid='$recvid' ,cs_userid='$senduserid' ,
    from_remark = '$from_remark',cs_active=0, to_remark = '$remarks' ,cs_created_date='$actdate',cs_expdate='" . $planned_date . "',cs_actual='" . $actdate . "' WHERE cs_packid = '$pack_id'";
    $query2 = mssql_query($sql2);
    //Repository flow
    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
    $row2 = mssql_fetch_array($isql2);
    $rsid = $row2['id'];

    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
        . "values('" . $rsid . "','" . $pack_id . "','" . $proj_id . "','$sendstageid','$recvstageid','" . $senduserid . "','" . $recvid . "','0','" . mssql_escape1($from_remark) . "','" . mssql_escape1($remarks) . "','" . $txp_sentdate . "','" . $senduserid . "','" . $actdate . "','" . $txp_planneddate . "')";
    $insert3 = mssql_query($sql3);
    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$pack_id' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',ps_userid='$recvid',ps_remarks='$remarks',updated_date=GETDATE(),active='1',ps_sbuid='$senduserid' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid' AND ps_projid= '$proj_id'";
    $query = mssql_query($sql);
    //Transaction history
    if ($query) {

        $send_email = $cls_comm->Send_MailNew($proj_id, $pack_id, $milcom, $sendstageid, $recvstageid);

        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;
        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('" . $id . "','" . $pack_id . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "','" . $txp_sentdate . "','" . $txp_planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";
        $query = mssql_query($sql);
        // $send_email = $cls_comm->send_email_tech($proj_id, $pack_id, $recvstageid, $recvid, $remarks, $sendstageid);
        if ($query) {
            echo "<script>window.location.href='../swift_workflow';</script>";
        } else {
            echo "not insert";
        }
    } else {
        echo "not success";
    }
} elseif (isset($_POST['sent_back_to_previous'])) {
    $pack_id           = mssql_escape($_POST['packageid']);
    $projid           = mssql_escape($_POST['projectid']);
    $sendbackstageid   = mssql_escape($_POST['senbackstage']);
    $sendbackuid       = mssql_escape($_POST['senbackuid']);
    $curdstageid       =  mssql_escape($_POST['cur_stage']);
    $expdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));
    //    $actdate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['act_date'])));
    $actdate = date('Y-m-d');
    $remarks = sanitize($_POST['remarks']);
    $senduserid = $_SESSION['uid'];
    $sql = "select * from swift_workflow_CurrentStage where cs_packid='" . $pack_id . "' and cs_projid='" .$proj_id. "'";
    $query = mssql_query($sql);
    $result = array();
    while ($row = mssql_fetch_array($query)) {
       // $projid = $row['cs_projid'];
        $packid = $row['cs_packid'];
        $flag   = $row['cs_active'];
        $recvid = $row['from_uid'];
        $from_remark = $row['to_remark'];
    }

    // $recvstageid = $_POST['forward'];
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$packid' and ps_stageid = '$sendstageid'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $planned_date = $row['planned_date'];
    $txp_sentdate = date("Y-m-d h:i:s");
    $txp_planneddate = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['exp_date'])));
    //Current  stage update 
    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '$curdstageid',
    to_stage_id = '$sendbackstageid' ,from_uid ='$senduserid', to_uid='$sendbackuid' ,cs_userid='$senduserid' ,
    from_remark = '$from_remark',cs_active=1 ,to_remark = '$remarks' ,cs_created_date='$actdate',cs_expdate='" . $planned_date . "',cs_actual='" . $actdate . "' WHERE cs_packid = '$pack_id'";
    //echo $sql2;exit;
    $query2 = mssql_query($sql2);

    //  repository details insert
    $sql2 = "UPDATE swift_repository SET rs_from_uid ='$senduserid', 
    rs_to_uid='$sendbackuid' ,rs_userid='$senduserid' ,
    rs_from_remark = '$from_remark',rs_to_remark = '$remarks' ,
    rs_from_stage='$curdstageid' , rs_to_stage = '$sendbackstageid',
    rs_created_date='$actdate',rs_active=1,rs_expdate='" . $actdate . "',
    rs_actual='" . $actdate . "' WHERE rs_packid = '$pack_id' 
    and rs_to_stage = '$curdstageid'  ";
    $query2 = mssql_query($sql2);


    // update package status
    // $sql = "UPDATE swift_packagestatus SET active = '1',ps_stback=0 WHERE ps_packid = '$pack_id' AND ps_projid= '$projid'";
    // $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',
    ps_userid='$sendbackuid',ps_remarks='$remarks',updated_date=GETDATE(),ps_stback=1,ps_sbuid='$sendbackuid' 
    WHERE ps_packid = '$pack_id' AND ps_stageid = '$curdstageid' AND ps_projid='$projid'";
    $query = mssql_query($sql);

    //Transaction history insert
    if ($query) {
        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        // insert to transaction table
        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                VALUES('" . $id . "','" . $pack_id . "','" . $projid . "','" . $senduserid . "','" . $curdstageid . "','" . $txp_sentdate . "','" . $txp_planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','1')";

        $query = mssql_query($sql);

        if ($query) {


            $send_email = $cls_comm->Send_MailNew($projid, $pack_id, $milcom, $curdstageid, $sendbackstageid);
            echo "<script>window.location.href='../swift_workflow';</script>";
        } else {
            echo "not insert";
            //            echo "<script>window.location.href='../tech_expert_workflow';</script>";
        }
    } else {
        echo "not success";
        //        echo "<script>window.location.href='../tech_expert_workflow';</script>";
    }
}
if (isset($_REQUEST['create_emr'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sentdate = date('Y-m-d');
    $planneddate = date('Y-m-d', strtotime(str_replace('/', '-', $planneddate)));
    $expected_date = date('Y-m-d', strtotime(str_replace('/', '-', $expected_date)));
    $actual_date = date('Y-m-d', strtotime(str_replace('/', '-', $actual_date)));

    $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");

    $trow = mssql_fetch_array($tsql);
    $tid = $trow['tid'];

    $buyer_sql = mssql_query("SELECT * FROM swift_SCMtoBUYER where bu_packid='" . $packageid . "' and bu_status=1");
    $brow = mssql_fetch_array($buyer_sql);
    $count = mssql_num_rows($buyer_sql);
    $recvid = $brow['bu_buyer_id'];
    $sql = "select * from swift_workflow_CurrentStage where cs_packid='$packageid'";
    $query1 = mssql_query($sql);
    while ($row = mssql_fetch_array($query1)) {
        $from_remark = $row['to_remark'];
        //$to_stage_id = $row['to_stage_id'];
    }
    $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','15','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $actual_date . "','" . $opstospocremarks . "','0')");
    $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");

    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
    $row2 = mssql_fetch_array($isql2);
    $rsid = $row2['id'];

    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
        . "values('" . $rsid . "','" . $packageid . "','" . $projectid . "','14','15','" . $uid . "','" . $uid . "','0','" . mssql_escape1($from_remark) . "','" . mssql_escape1($opstospocremarks) . "','" . $actual_date . "','" . $uid . "','" . $sentdate . "','" . $expected_date . "')";
    $insert3 = mssql_query($sql3);

    if ($count > 0) {
        $update_status19 = mssql_query("update swift_packagestatus set ps_expdate='" . $sentdate . "',ps_actualdate='" . $actual_date . "',ps_userid='" . $recvid . "',ps_sbuid='" . $uid . "',ps_remarks='EMR Generated',active='0' where ps_stageid='19'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status20 = mssql_query("update swift_packagestatus set active='1' where ps_stageid='15'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    } else {
        $update_status19 = mssql_query("update swift_packagestatus set ps_expdate='" . $sentdate . "',ps_actualdate='" . $actual_date . "',ps_userid='" . $uid . "',ps_remarks='EMR Generated',active='0' where ps_stageid='15'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    }

    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '14',
    to_stage_id = '15',cs_userid='$uid',from_remark = '$from_remark',cs_active=0 ,to_remark = '$opstospocremarks' ,
    cs_created_date='$actual_date',cs_expdate='" . $planneddate . "',cs_actual='" . $actual_date . "' WHERE cs_packid = '$packageid'";
    //echo $sql2;exit;
    $query2 = mssql_query($sql2);



    //$update_status19 = mssql_query("update swift_packagestatus set ps_expdate='" . $sentdate . "',ps_actualdate='" . $actual_date . "',ps_userid='" . $uid . "',ps_remarks='EMR Generated',active='0' where ps_stageid='19'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    $sql = mssql_query("select isnull (max(emr_id+1),1) as id from swift_emrcreation");
    $row = mssql_fetch_array($sql);
    $id = $row['id'];
    $insert = mssql_query("insert into swift_emrcreation(emr_id,emr_packid,emr_projid,emr_uid,emr_createddate,emr_remarks,emr_number)"
        . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $actual_date . "','" . $opstospocremarks . "','" . $emr_no . "')");

    $update = mssql_query("update swift_packagemaster set emr_status=1 where pm_packid='" . $packageid . "' and pm_projid='" . $projectid . "'");
    // if ($count > 0) {
    //     $send_email = $cls_comm->send_email($projectid, $packageid, '20', $recvid, $opstospocremarks, '19');
    // }
    if ($insert) {

        $send_email = $cls_comm->Send_MailNew($projectid, $packageid, $milcom, 14, 15);
        // header('Location: ../loi_update');
        echo "<script>window.location.href='../files_from_Smartsign';</script>";
    }
}
}
