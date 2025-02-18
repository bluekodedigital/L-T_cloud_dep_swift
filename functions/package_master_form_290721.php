<?php

 
// error_reporting(1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once ("../config/inc_function.php");
//$csrf_token = $_REQUEST['csrf_token'];


//if (isset($_SESSION['token']) && $csrf_token === $_SESSION['token']) {

    if (isset($_REQUEST['package_create'])) {
        extract($_REQUEST);
       
        
        $omattachs = explode(",", $ptwattachment);
     
        array_splice($omattachs, 0, 1);
         
        $uid = $_SESSION['uid'];
        if ($opstospocremarks == '') {
            $opstospocremarks = 'Nil';
        }
        if (isset($_POST['tech_skip'])) {
            $tech_skip = 0;
        } else {
            $tech_skip = 1;
        }

        $segment_sql = mssql_query("select cat_id from Project where proj_id='" . $proj_name . "'");
        $sqry = mssql_fetch_array($segment_sql);
        $segment = $sqry['cat_id'];

        $stages = array();
        $sql = "select * from  swift_packagemaster where pm_packagename='" . mssql_escape1($pack_name) . "' and pm_projid='" . $proj_name . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);

        if ($num_rows > 0) {
            if ($page_name == 'files') {
                echo "<script>window.location.href='../files_from_contract?msg=0';</script>";
                //header('Location: ../files_from_contract?msg=0');
            } elseif ($page_name == 'masters') {
                echo "<script>window.location.href='../package_master?msg=0';</script>";
//            header('Location: ../package_master?msg=0');
            }
        } else {
            $isql = mssql_query("select isnull (max(pm_packid+1),1) as id from  swift_packagemaster");

            $row = mssql_fetch_array($isql);
            $id = $row['id'];
            $mtreq = formatDate(str_replace('/', '-', $mat_req_site), 'Y-m-d');
            $org = formatDate(str_replace('/', '-', $org_schedule), 'Y-m-d');
            $sql = "insert into swift_packagemaster(pm_packid,pm_projid,pm_packagename,pm_createdate,pm_material_req,pm_leadtime,pm_userid,tech_status,pm_revised_material_req,pm_revised_lead_time,emr_status,pm_catid,pm_remarks,tech_skip)"
                    . "values('" . $id . "','" . $proj_name . "','" . mssql_escape1($pack_name) . "','" . date('Y-m-d h:i:s') . "','" . $org . "','" . mssql_escape1($lead_time) . "','" . $uid . "','0','" . $mtreq . "','" . mssql_escape1($lead_time) . "','0','" . $pack_cat_name . "','" . $opstospocremarks . "','" . $tech_skip . "')";

            $insert = mssql_query($sql);

            if ($insert) {
                $update = mssql_query("update Project set package_status=1 where proj_id='" . $proj_name . "'");
                $diff = ($lead_time + 54); //15-23-6-15
                $stages[1] = date('d-M-y', strtotime(formatDate($mtreq, 'Y-m-d') . '-' . $diff . 'days')); //1Contracts to Ops    
                $stages[2] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //2Ops to Engineering SPOC
                $stages[3] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //3$SPOC_to_Tech_Expert
                $stages[4] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //4$Tech_Expert_Clerance
                $stages[5] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //5$Tech_Expert_to_CTO_for_approval
                $stages[6] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //6$CTO_Approval
                $stages[7] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //7$Tech_SPOC_toOps
                $stages[8] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //8$OpstoOM
                $stages[9] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //9$OMApproval
                $stages[10] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //10$OMtoOps 
                $stages[11] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //11$OpshandingovertoSCM
                $stages[12] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //12$AcutalOpshandingovertoSCM
                $stages[13] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //13$FileAcceptancefromOpsDate
                $stages[14] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //14$FileReceivedDateRevised
                $stages[15] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //15$ExpectedDateofOrderClosing
                $stages[16] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //16$PackageSentDate
                $stages[17] = formatDate($stages[16] . '+4 days', 'Y-m-d'); //17$PackageApprovedDate
                $stages[18] = formatDate($stages[17] . '+2 days', 'Y-m-d'); //18$LOIdate
                $stages[19] = formatDate($stages[18] . '+2 days', 'Y-m-d'); //19$EMRdate
                $stages[20] = formatDate($stages[19] . '+3 days', 'Y-m-d'); //20$PODate
                $stages[21] = formatDate($stages[20] . '+2 days', 'Y-m-d'); //21$POApprovedDate
                $stages[22] = formatDate($stages[18] . '+3 days', 'Y-m-d'); //22$WODate
                $stages[23] = formatDate($stages[22] . '+2 days', 'Y-m-d'); //23$WOApprovedDate
                $stages[24] = formatDate($stages[21] . '+7 days', 'Y-m-d'); //24$LCDate
                $stages[25] = formatDate($stages[21] . '+3 days', 'Y-m-d'); //25$VendortoOpsDrawingSamplePOCSubmission
                $stages[26] = formatDate($stages[25] . '+1 days', 'Y-m-d'); //26$OpstoEngineeringVendor Drawing/POC
                $stages[27] = formatDate($stages[26] . '+2 days', 'Y-m-d'); //27$EngineeringtoOpsforVendorDesignApproval
                $stages[28] = formatDate($stages[27] . '+1 days', 'Y-m-d'); //28$OpstoVendorApprovedDrawing
                $stages[29] = formatDate($stages[28] . '+2 days', 'Y-m-d'); //29$ManufacturingClearance
                $inf = ($lead_time + 2);
                $stages[30] = date('d-M-y', strtotime(formatDate($stages[29] . '+', 'Y-m-d') . $inf . 'days')); //30$Inspection
                $stages[31] = formatDate($stages[30] . '+2 days', 'Y-m-d'); //31$MDCC 
                $stages[32] = formatDate($stages[31] . '+15 days', 'Y-m-d'); //32$CustomClearanceDate
                $stages[33] = formatDate($stages[31] . '+3 days', 'Y-m-d'); //33$Mtlsreceivedatsite
                $stages[34] = formatDate($stages[33] . '+2 days', 'Y-m-d'); //34$MRN
                $count = sizeof($stages);

                for ($i = 1; $i <= $count; $i++) {
                    $sql = "insert into swift_packagestatus(ps_projid,ps_packid,ps_stageid,ps_planneddate,ps_userid,revised_planned_date)"
                            . "values('" . $proj_name . "','" . $id . "','" . $i . "','" . $stages[$i] . "','','" . $stages[$i] . "')";
                    $pack_status = mssql_query($sql);
                }

                $contoops = mssql_query("update swift_packagestatus set active=0,ps_expdate='" . date('Y-m-d H:i:s') . "',ps_actualdate='" . date('Y-m-d H:i:s') . "',ps_userid='" . $uid . "' where ps_stageid='1' and ps_packid='" . $id . "' ");
                $update_stage = mssql_query("update swift_packagestatus set active=1  where ps_stageid='2' and ps_packid='" . $id . "' ");

                $stages[1] = date('d-M-y', strtotime(formatDate($org, 'Y-m-d') . '-' . $diff . 'days')); //1Contracts to Ops
                $stages[2] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //2Ops to Engineering SPOC
                $stages[3] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //3$SPOC_to_Tech_Expert
                $stages[4] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //4$Tech_Expert_Clerance
                $stages[5] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //5$Tech_Expert_to_CTO_for_approval
                $stages[6] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //6$CTO_Approval
                $stages[7] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //7$Tech_SPOC_toOps
                $stages[8] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //8$OpstoOM
                $stages[9] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //9$OMApproval
                $stages[10] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //10$OMtoOps 
                $stages[11] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //11$OpshandingovertoSCM
                $stages[12] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //12$AcutalOpshandingovertoSCM
                $stages[13] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //13$FileAcceptancefromOpsDate
                $stages[14] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //14$FileReceivedDateRevised
                $stages[15] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //15$ExpectedDateofOrderClosing
                $stages[16] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //16$PackageSentDate
                $stages[17] = formatDate($stages[16] . '+4 days', 'Y-m-d'); //17$PackageApprovedDate
                $stages[18] = formatDate($stages[17] . '+2 days', 'Y-m-d'); //18$LOIdate
                $stages[19] = formatDate($stages[18] . '+2 days', 'Y-m-d'); //19$EMRdate
                $stages[20] = formatDate($stages[19] . '+3 days', 'Y-m-d'); //20$PODate
                $stages[21] = formatDate($stages[20] . '+2 days', 'Y-m-d'); //21$POApprovedDate
                $stages[22] = formatDate($stages[18] . '+3 days', 'Y-m-d'); //22$WODate
                $stages[23] = formatDate($stages[22] . '+2 days', 'Y-m-d'); //23$WOApprovedDate
                $stages[24] = formatDate($stages[21] . '+7 days', 'Y-m-d'); //24$LCDate
                $stages[25] = formatDate($stages[21] . '+3 days', 'Y-m-d'); //25$VendortoOpsDrawingSamplePOCSubmission
                $stages[26] = formatDate($stages[25] . '+1 days', 'Y-m-d'); //26$OpstoEngineeringVendor Drawing/POC
                $stages[27] = formatDate($stages[26] . '+2 days', 'Y-m-d'); //27$EngineeringtoOpsforVendorDesignApproval
                $stages[28] = formatDate($stages[27] . '+1 days', 'Y-m-d'); //28$OpstoVendorApprovedDrawing
                $stages[29] = formatDate($stages[28] . '+2 days', 'Y-m-d'); //29$ManufacturingClearance
                $inf = ($lead_time + 2);
                $stages[30] = date('d-M-y', strtotime(formatDate($stages[29] . '+', 'Y-m-d') . $inf . 'days')); //30$Inspection
                $stages[31] = formatDate($stages[30] . '+2 days', 'Y-m-d'); //31$MDCC 
                $stages[32] = formatDate($stages[31] . '+15 days', 'Y-m-d'); //32$CustomClearanceDate
                $stages[33] = formatDate($stages[31] . '+3 days', 'Y-m-d'); //33$Mtlsreceivedatsite
                $stages[34] = formatDate($stages[33] . '+2 days', 'Y-m-d'); //34$MRN

                $counnt = sizeof($stages);

                for ($i = 1; $i <= $counnt; $i++) {
                    $sql = "update swift_packagestatus set ps_planneddate='" . $stages[$i] . "' where ps_projid='" . $proj_name . "' and ps_packid='" . $id . "' and ps_stageid='" . $i . "'";
                    $pack_status = mssql_query($sql);
                }

                if ($pack_status) {
                    if ($segment == 35) {
                        if ($tech_skip == 1) {
                            $packageid = $id;
                            $projectid = $proj_name;
                            $uid = $_SESSION['uid'];
                            

                        if (sizeof($omattachs) > 0) {
           
                           
                            
                            for($a=0; $a<sizeof($omattachs);$a++){
                                //uploads Document
                            $isql = mssql_query("select isnull (max(oexp_upid+1),1) as id from  swift_ops_expert_uploads");
                            $row = mssql_fetch_array($isql);
                            $dcid = $row['id'];

                            //check revisions 
                            $ck_sql= mssql_query("select * from swift_ops_expert_uploads where oexp_up_packid='".$packageid."' and oexp_up_projid ='".$projectid."'");
                            $ck_numrows = mssql_num_rows($ck_sql);
                            $exp_rev= 'rev 0.'.$ck_numrows;
                            
                            $sql = "insert into swift_ops_expert_uploads(oexp_upid,oexp_up_projid,oexp_up_packid,oexp_up_uid,oexp_update,oexp_filename,oexp_filepath,oexp_upactive,oexp_rev) "
                                        . "values('" . $dcid . "','" . $projectid . "','" . $packageid . "','".$uid."',GETDATE(),'" . $tags[$a] . "','" . $omattachs[$a] . "','1','".$exp_rev."')";
                                $query = mssql_query($sql);
                                
                            }

                           
                        }


                            $rsql = mssql_query("select uid from usermst where usertype=14");
                            $r = mssql_fetch_array($rsql);
                            $rec_uid = $r['uid'];

                            $isql = mssql_query("select isnull (max(sc_id+1),1) as id from  swift_SCMSPOC");
                            $row = mssql_fetch_array($isql);
                            $ids = $row['id'];

                            $sentdate = date('Y-m-d');
//                            $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');

                            $spsql = mssql_query("select revised_planned_date as planned from swift_packagestatus where ps_packid='" . $packageid . "' and ps_stageid=13");
                            $prow = mssql_fetch_array($pquery);
                            $planneddate = formatDate($prow['planned'], 'Y-m-d');

//                            $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
//                            $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
                            $expected_date = $sentdate;
                            $actual_date = $sentdate;

                            $sql = mssql_query("select * from swift_SCMSPOC where sc_packid='" . $packageid . "' and sc_projid='" . $projectid . "' and sc_recvuid='" . $rec_uid . "' and sc_active='1'");
                            $num_rows = mssql_num_rows($sql);
                            if ($num_rows > 0) {
                                $updatescmspoc = mssql_query("update swift_SCMSPOC set sc_active='0'  where sc_packid='" . $packageid . "' and sc_projid='" . $projectid . "' and sc_recvuid='" . $rec_uid . "' and sc_active='1'");
                            }
                            $sql = "insert into swift_SCMSPOC (sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_remarks,sc_status,sc_active)"
                                    . "values('" . $ids . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','12','13','" . $sentdate . "','','" . mssql_escape1($opstospocremarks) . "','0','1')";

                            $insert = mssql_query($sql);
                            if ($insert) {
                                $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                                $trow = mssql_fetch_array($tsql);
                                $tid = $trow['tid'];
                                $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','12','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . mssql_escape1($opstospocremarks) . "','0')");
                                $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                                $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . mssql_escape1($opstospocremarks) . "',active='0' where ps_stageid='12'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                                $update_status8 = mssql_query("update swift_packagestatus set active='1',ps_userid='" . $rec_uid . "',ps_sbuid='" . $uid . "' where ps_stageid='12'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                                $updateCto_ops = mssql_query("update swift_OMtoOPs set omop_status=1 where omop_packid='" . $packageid . "' and omop_projid='" . $projectid . "'");
                                $send_email = $cls_comm->send_email($projectid, $packageid, '13', $rec_uid, $opstospocremarks, '12');
                                if ($updateCto_ops) {

                                    if ($page_name == 'files') {
                                        echo "<script>window.location.href='../files_from_contract';</script>";
                                    } elseif ($page_name == 'masters') {
                                        echo "<script>window.location.href='../package_master';</script>";
                                    }
                                }
                            }
                        } 
                        else {
                            $packageid = $id;
                            $projectid = $proj_name;

                            if ($segment == 37) {
                                $cc = 'J-SRIDHAR@lntecc.com';
                            } else {
                                $cc = 'shankaranr@lntecc.com';
                            }
                            $uid = $_SESSION['uid'];
                            $rsql = mssql_query("select * from usermst where usertype=10 and tech_seg like '%$segment%'");

                            $r = mssql_fetch_array($rsql);
                            $rec_uid = $r['uid'];
                            $rec_email = $r['uname'];
                            $rec_name = $r['name'];
                            //$rec_email = 'srini.rpsm@gmail.com';
                            //$rec_name = 'Srinivasan';

                            $isql = mssql_query("select isnull (max(ts_id+1),1) as id from  swift_techspoc");
                            $row = mssql_fetch_array($isql);
                            $ids = $row['id'];

//                $opstospocremarks = '$ops_remarks';


                            $sentdate = date('Y-m-d');
                            //$mtreq = formatDate(str_replace('/', '-', $mat_req_site), 'Y-m-d');
//                $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
                            $spsql = mssql_query("select revised_planned_date as planned from swift_packagestatus where ps_packid='" . $id . "' and ps_stageid=1");
//                $pquery = mssql_query($spsql);
                            $prow = mssql_fetch_array($pquery);
                            $planneddate = formatDate($prow['planned'], 'Y-m-d');

                            $spsql_spoc = mssql_query("select revised_planned_date as planned_spoc from swift_packagestatus where ps_packid='" . $id . "' and ps_stageid=3");

//                $pquery_spoc = mssql_query($spsql_spoc);
                            $prow_spoc = mssql_fetch_array($spsql_spoc);
                            $planneddate_spoc = formatDate($prow_spoc['planned_spoc'], 'd-M-Y');
                            $get_projname = mssql_query(" select proj_name from   dbo.Project where proj_id='" . $proj_name . "'");
                            $pnameqrow = mssql_fetch_array($get_projname);

//                $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
//                $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
                            $expected_date = $sentdate;
                            $actual_date = $sentdate;
                            $sql = "insert into swift_techspoc ( ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ts_planneddate,ts_remarks,ts_status,ts_active)"
                                    . "values('" . $ids . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','2','3','" . $sentdate . "','','" . mssql_escape1($opstospocremarks) . "','0','1')";
                            $insert = mssql_query($sql);
                            if ($insert) {
                                $update = mssql_query("update swift_packagemaster set  tech_status=1  where pm_packid='" . $packageid . "'");
                                if ($update) {
                                    $update_proj = mssql_query("update Project set  package_status=1  where proj_id='" . $projectid . "'");
                                    $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                                    $trow = mssql_fetch_array($tsql);
                                    $tid = $trow['tid'];
                                    $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
            values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','2','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
                                    $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                                    $update_status = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $rec_uid . "',ps_remarks='" . mssql_escape1($opstospocremarks) . "',active='1' where ps_stageid='2'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");

//                        if ($update_status) {
//                            // header('Location: ../files_for_techspoc');
//                            echo "<script>window.location.href='../files_for_techspoc';</script>";
//                        }
                                    require '../PHPMailer/PHPMailerAutoload.php';
                                    $message = '<div width="100%" style="background: #f8f8f8;  font-family:verdana; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
    <div style="max-width: 100%;  font-size: 12px">
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: -30px">
            <tbody>
                <tr>
                    <td style="vertical-align: top; " align="center">
                        <!-- <img src="../images/logo-dark.png" alt="Eliteadmin Responsive web app kit" style="border:none" height="100px;" width="100px"> -->
                    </td>
                </tr>
            </tbody>
        </table>
        <div style=" background: #fff;  font-family: calibri; font-size: 16px; font-weight: normal; font-size: 16px;">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td><b>Dear Sir/Madam,</b>

                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; Margin-bottom: 15px;">The Following files has been sent to your flow for action.</p>
                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; ">Please use the below links to view </p>
                            <p  style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal;   Margin-bottom: 15px;"> <a href="https://swc.ltts.com/swift" target="blank">Link - SWIFT</a></p>
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                                <thead >
                                    <tr>
                                        <th style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Project Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Package Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Received From</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Received Stage</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Remarks</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Next Stage Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Stage Planned</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pnameqrow['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pack_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $_SESSION['name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">Ops to Tech. SPOC</td>
                                          <td style=" text-align: center;  border: 1px solid #ddd;">' . $opstospocremarks . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">Tech SPOC to Expert</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $planneddate_spoc . '</td>
                                      
                                    </tr>
                                </tbody>
                            </table><br>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Regards,</p>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><b>Swift</b></p>

                            <p style="font-family:calibri;color:lightgray;font-size:14px">This is Auto generated mail hence Please do not reply</p>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
            <p> Powered by Bluekode
                <br>
        </div>
    </div>
</div>';
                                    $email = $rec_email;
                                    $name = $rec_name;
//For Live
                                    $get_smtp = mssql_query("select * from dbo.swift_smtp_setting where smtp_status=1");
                                    //For Production 
//                        $get_smtp = mssql_query("select * from dbo.swift_smtp_setting where smtp_status=0");
                                    $sm_row = mssql_fetch_array($get_smtp);
                                    $con_smtp = $sm_row['smtp_email'];
                                    $con_email = $sm_row['smtp_sendermail'];
                                    $con_pass = $sm_row['smtp_password'];
                                    $con_port = $sm_row['smtp_portno'];

                                    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                                    try {
                                        //Server settingss
                                        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
                                        $mail->isSMTP();                                      // Set mailer to use SMTP
                                        $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
                                        $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                        $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
                                        $mail->Password = '!Lntswc123';                      // SMTP password
//        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
                                        $mail->Port = 25;
//                            $mail->Port = 587;
// TCP port to connect to
//Recipients
                                        $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
                                        $mail->addAddress($rec_email, $rec_name); // Add a recipient
                                        //$mail->addAddress('uuk@lntecc.com', 'Smart Signoff'); // Add a recipient
//                            $mail->addAddress('srini.rpsm@gmail.com'); // Name is optional

                                        $sqlccs1 = mssql_query("select * from swiftCcMailSetting where   ccExceptProjid in (0) and ccSegid=$segment and ccActive=1");
                                        $cc_numr1 = mssql_num_rows($sqlccs1);
                                        if ($cc_numr1 > 0) {
                                            while ($cc_row1 = mssql_fetch_array($sqlccs1)) {
                                                $mail->addCC($cc_row1['ccMail'], 'SWIFT'); // Add a recipient
                                            }
                                        }

                                        $sqlccs2 = mssql_query("select * from swiftCcMailSetting where ccExceptProjid in ($projectid)  and ccSegid=$segment and ccActive=1");
                                        $cc_numr2 = mssql_num_rows($sqlccs2);
                                        if ($cc_numr2 > 0) {
                                            while ($cc_row2 = mssql_fetch_array($sqlccs2)) {
                                                $mail->addCC($cc_row2['ccMail'], 'SWIFT'); // Add a recipient
                                            }
                                        }





                                        $mail->addCC('uuk@lntecc.com', 'SWIFT'); // Add a recipient
                                        // $mail->addReplyTo('info@example.com', 'Information');
                                        //$mail->addCC('cc@example.com');
                                        $mail->addBCC('srini.rpsm@gmail.com');
                                        //Attachments
                                        // $mail->addAttachment('C:/xampp/htdocs/QA/fpdf/status_pdf/'.$filename);                    // Add attachments
                                        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');// Optional name
                                        //Content
                                        $mail->isHTML(true);                                 // Set email format to HTML
                                        // $mail->AddEmbeddedImage('logo.png', 'logoimg'); // attach file logo.jpg, and later link to it using identfier logoimg

                                        $mail->Subject = 'Swift';
                                        $mail->Body = $message;
                                        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                                        $isql = mssql_query("select isnull (max(sms_id+1),1) as id from  sms_tracking");
                                        $row = mssql_fetch_array($isql);
                                        $sid = $row['id'];
                                        $sql = mssql_query("insert into sms_tracking (sms_id,sms_userid,sms_email,sent_date,_type)"
                                                . "values('" . $sid . "','" . $rec_uid . "','" . $rec_email . "',GETDATE(),'1')");
                                        $mail->send();
                                        $Msg = "Mail Send";
                                    } catch (Exception $e) {
                                        echo 'Message could not be sent.';
                                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        $Msg = "Mail Not Send";
                                    }
                                }
                            }

                            if ($page_name == 'files') {
                                echo "<script>window.location.href='../files_from_contract';</script>";
//                    header('Location: ../files_from_contract');
                            } elseif ($page_name == 'masters') {
                                echo "<script>window.location.href='../package_master';</script>";
//                    header('Location: ../package_master');
                            }
                        }
                    } 
                    elseif ($segment == 39) {
                        if ($tech_skip == 1) {
                            $packageid = $id;
                            $projectid = $proj_name;
                            $uid = $_SESSION['uid'];
                        if (sizeof($omattachs) > 0) {
           
                           
                            
                            for($a=0; $a<sizeof($omattachs);$a++){
                                //uploads Document
                            $isql = mssql_query("select isnull (max(oexp_upid+1),1) as id from  swift_ops_expert_uploads");
                            $row = mssql_fetch_array($isql);
                            $dcid = $row['id'];

                            //check revisions 
                            $ck_sql= mssql_query("select * from swift_ops_expert_uploads where oexp_up_packid='".$packageid."' and oexp_up_projid ='".$projectid."'");
                            $ck_numrows = mssql_num_rows($ck_sql);
                            $exp_rev= 'rev 0.'.$ck_numrows;
                            
                            $sql = "insert into swift_ops_expert_uploads(oexp_upid,oexp_up_projid,oexp_up_packid,oexp_up_uid,oexp_update,oexp_filename,oexp_filepath,oexp_upactive,oexp_rev) "
                                        . "values('" . $dcid . "','" . $projectid . "','" . $packageid . "','".$uid."',GETDATE(),'" . $tags[$a] . "','" . $omattachs[$a] . "','1','".$exp_rev."')";
                                $query = mssql_query($sql);
                                
                            }

                           
                        }

                            $rsql = mssql_query("select uid from usermst where usertype=14");
                            $r = mssql_fetch_array($rsql);
                            $rec_uid = $r['uid'];

                            $isql = mssql_query("select isnull (max(sc_id+1),1) as id from  swift_SCMSPOC");
                            $row = mssql_fetch_array($isql);
                            $ids = $row['id'];

                            $sentdate = date('Y-m-d');
//                            $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');

                            $spsql = mssql_query("select revised_planned_date as planned from swift_packagestatus where ps_packid='" . $packageid . "' and ps_stageid=13");
                            $prow = mssql_fetch_array($pquery);
                            $planneddate = formatDate($prow['planned'], 'Y-m-d');

//                            $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
//                            $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
                            $expected_date = $sentdate;
                            $actual_date = $sentdate;

                            $sql = mssql_query("select * from swift_SCMSPOC where sc_packid='" . $packageid . "' and sc_projid='" . $projectid . "' and sc_recvuid='" . $rec_uid . "' and sc_active='1'");
                            $num_rows = mssql_num_rows($sql);
                            if ($num_rows > 0) {
                                $updatescmspoc = mssql_query("update swift_SCMSPOC set sc_active='0'  where sc_packid='" . $packageid . "' and sc_projid='" . $projectid . "' and sc_recvuid='" . $rec_uid . "' and sc_active='1'");
                            }
                            $sql = "insert into swift_SCMSPOC (sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_remarks,sc_status,sc_active)"
                                    . "values('" . $ids . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','12','13','" . $sentdate . "','','" . mssql_escape1($opstospocremarks) . "','0','1')";

                            $insert = mssql_query($sql);
                            if ($insert) {
                                $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                                $trow = mssql_fetch_array($tsql);
                                $tid = $trow['tid'];
                                $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','12','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . mssql_escape1($opstospocremarks) . "','0')");
                                $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                                $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . mssql_escape1($opstospocremarks) . "',active='0' where ps_stageid='12'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                                $update_status8 = mssql_query("update swift_packagestatus set active='1',ps_userid='" . $rec_uid . "',ps_sbuid='" . $uid . "' where ps_stageid='12'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                                $updateCto_ops = mssql_query("update swift_OMtoOPs set omop_status=1 where omop_packid='" . $packageid . "' and omop_projid='" . $projectid . "'");
                                $send_email = $cls_comm->send_email($projectid, $packageid, '13', $rec_uid, $opstospocremarks, '12');
                                if ($updateCto_ops) {

                                    if ($page_name == 'files') {
                                        echo "<script>window.location.href='../files_from_contract';</script>";
                                    } elseif ($page_name == 'masters') {
                                        echo "<script>window.location.href='../package_master';</script>";
                                    }
                                }
                            }
                        } 
                        else {
                            $packageid = $id;
                            $projectid = $proj_name;

                            if ($segment == 37) {
                                $cc = 'J-SRIDHAR@lntecc.com';
                            } else {
                                $cc = 'shankaranr@lntecc.com';
                            }
                            $uid = $_SESSION['uid'];
                            $rsql = mssql_query("select * from usermst where usertype=10 and tech_seg like '%$segment%'");

                            $r = mssql_fetch_array($rsql);
                            $rec_uid = $r['uid'];
                            $rec_email = $r['uname'];
                            $rec_name = $r['name'];
                            //$rec_email = 'srini.rpsm@gmail.com';
                            //$rec_name = 'Srinivasan';

                            $isql = mssql_query("select isnull (max(ts_id+1),1) as id from  swift_techspoc");
                            $row = mssql_fetch_array($isql);
                            $ids = $row['id'];

//                $opstospocremarks = '$ops_remarks';


                            $sentdate = date('Y-m-d');
                            //$mtreq = formatDate(str_replace('/', '-', $mat_req_site), 'Y-m-d');
//                $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
                            $spsql = mssql_query("select revised_planned_date as planned from swift_packagestatus where ps_packid='" . $id . "' and ps_stageid=1");
//                $pquery = mssql_query($spsql);
                            $prow = mssql_fetch_array($pquery);
                            $planneddate = formatDate($prow['planned'], 'Y-m-d');

                            $spsql_spoc = mssql_query("select revised_planned_date as planned_spoc from swift_packagestatus where ps_packid='" . $id . "' and ps_stageid=3");

//                $pquery_spoc = mssql_query($spsql_spoc);
                            $prow_spoc = mssql_fetch_array($spsql_spoc);
                            $planneddate_spoc = formatDate($prow_spoc['planned_spoc'], 'd-M-Y');
                            $get_projname = mssql_query(" select proj_name from   dbo.Project where proj_id='" . $proj_name . "'");
                            $pnameqrow = mssql_fetch_array($get_projname);

//                $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
//                $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
                            $expected_date = $sentdate;
                            $actual_date = $sentdate;
                            $sql = "insert into swift_techspoc ( ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ts_planneddate,ts_remarks,ts_status,ts_active)"
                                    . "values('" . $ids . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','2','3','" . $sentdate . "','','" . mssql_escape1($opstospocremarks) . "','0','1')";
                            $insert = mssql_query($sql);
                            if ($insert) {
                                $update = mssql_query("update swift_packagemaster set  tech_status=1  where pm_packid='" . $packageid . "'");
                                if ($update) {
                                    $update_proj = mssql_query("update Project set  package_status=1  where proj_id='" . $projectid . "'");
                                    $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                                    $trow = mssql_fetch_array($tsql);
                                    $tid = $trow['tid'];
                                    $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
            values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','2','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
                                    $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                                    $update_status = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $rec_uid . "',ps_remarks='" . mssql_escape1($opstospocremarks) . "',active='1' where ps_stageid='2'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");

//                        if ($update_status) {
//                            // header('Location: ../files_for_techspoc');
//                            echo "<script>window.location.href='../files_for_techspoc';</script>";
//                        }
                                    require '../PHPMailer/PHPMailerAutoload.php';
                                    $message = '<div width="100%" style="background: #f8f8f8;  font-family:verdana; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
    <div style="max-width: 100%;  font-size: 12px">
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: -30px">
            <tbody>
                <tr>
                    <td style="vertical-align: top; " align="center">
                        <!-- <img src="../images/logo-dark.png" alt="Eliteadmin Responsive web app kit" style="border:none" height="100px;" width="100px"> -->
                    </td>
                </tr>
            </tbody>
        </table>
        <div style=" background: #fff;  font-family: calibri; font-size: 16px; font-weight: normal; font-size: 16px;">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td><b>Dear Sir/Madam,</b>

                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; Margin-bottom: 15px;">The Following files has been sent to your flow for action.</p>
                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; ">Please use the below links to view </p>
                            <p  style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal;   Margin-bottom: 15px;"> <a href="https://swc.ltts.com/swift" target="blank">Link - SWIFT</a></p>
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                                <thead >
                                    <tr>
                                        <th style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Project Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Package Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Received From</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Received Stage</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Remarks</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Next Stage Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Stage Planned</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pnameqrow['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pack_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $_SESSION['name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">Ops to Tech. SPOC</td>
                                          <td style=" text-align: center;  border: 1px solid #ddd;">' . $opstospocremarks . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">Tech SPOC to Expert</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $planneddate_spoc . '</td>
                                      
                                    </tr>
                                </tbody>
                            </table><br>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Regards,</p>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><b>Swift</b></p>

                            <p style="font-family:calibri;color:lightgray;font-size:14px">This is Auto generated mail hence Please do not reply</p>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
            <p> Powered by Bluekode
                <br>
        </div>
    </div>
</div>';
                                    $email = $rec_email;
                                    $name = $rec_name;
//For Live
                                    $get_smtp = mssql_query("select * from dbo.swift_smtp_setting where smtp_status=1");
                                    //For Production 
//                        $get_smtp = mssql_query("select * from dbo.swift_smtp_setting where smtp_status=0");
                                    $sm_row = mssql_fetch_array($get_smtp);
                                    $con_smtp = $sm_row['smtp_email'];
                                    $con_email = $sm_row['smtp_sendermail'];
                                    $con_pass = $sm_row['smtp_password'];
                                    $con_port = $sm_row['smtp_portno'];

                                    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                                    try {
                                        //Server settingss
                                        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
                                        $mail->isSMTP();                                      // Set mailer to use SMTP
                                        $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
                                        $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                        $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
                                        $mail->Password = '!Lntswc123';                      // SMTP password
//        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
                                        $mail->Port = 25;
//                            $mail->Port = 587;
// TCP port to connect to
//Recipients
                                        $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
                                        $mail->addAddress($rec_email, $rec_name); // Add a recipient
                                        //$mail->addAddress('uuk@lntecc.com', 'Smart Signoff'); // Add a recipient
//                            $mail->addAddress('srini.rpsm@gmail.com'); // Name is optional

                                        $sqlccs1 = mssql_query("select * from swiftCcMailSetting where   ccExceptProjid in (0) and ccSegid=$segment and ccActive=1");
                                        $cc_numr1 = mssql_num_rows($sqlccs1);
                                        if ($cc_numr1 > 0) {
                                            while ($cc_row1 = mssql_fetch_array($sqlccs1)) {
                                                $mail->addCC($cc_row1['ccMail'], 'SWIFT'); // Add a recipient
                                            }
                                        }

                                        $sqlccs2 = mssql_query("select * from swiftCcMailSetting where ccExceptProjid in ($projectid)  and ccSegid=$segment and ccActive=1");
                                        $cc_numr2 = mssql_num_rows($sqlccs2);
                                        if ($cc_numr2 > 0) {
                                            while ($cc_row2 = mssql_fetch_array($sqlccs2)) {
                                                $mail->addCC($cc_row2['ccMail'], 'SWIFT'); // Add a recipient
                                            }
                                        }





                                        $mail->addCC('uuk@lntecc.com', 'SWIFT'); // Add a recipient
                                        // $mail->addReplyTo('info@example.com', 'Information');
                                        //$mail->addCC('cc@example.com');
                                        $mail->addBCC('srini.rpsm@gmail.com');
                                        //Attachments
                                        // $mail->addAttachment('C:/xampp/htdocs/QA/fpdf/status_pdf/'.$filename);                    // Add attachments
                                        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');// Optional name
                                        //Content
                                        $mail->isHTML(true);                                 // Set email format to HTML
                                        // $mail->AddEmbeddedImage('logo.png', 'logoimg'); // attach file logo.jpg, and later link to it using identfier logoimg

                                        $mail->Subject = 'Swift';
                                        $mail->Body = $message;
                                        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                                        $isql = mssql_query("select isnull (max(sms_id+1),1) as id from  sms_tracking");
                                        $row = mssql_fetch_array($isql);
                                        $sid = $row['id'];
                                        $sql = mssql_query("insert into sms_tracking (sms_id,sms_userid,sms_email,sent_date,_type)"
                                                . "values('" . $sid . "','" . $rec_uid . "','" . $rec_email . "',GETDATE(),'1')");
                                        $mail->send();
                                        $Msg = "Mail Send";
                                    } catch (Exception $e) {
                                        echo 'Message could not be sent.';
                                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        $Msg = "Mail Not Send";
                                    }
                                }
                            }

                            if ($page_name == 'files') {
                                echo "<script>window.location.href='../files_from_contract';</script>";
//                    header('Location: ../files_from_contract');
                            } elseif ($page_name == 'masters') {
                                echo "<script>window.location.href='../package_master';</script>";
//                    header('Location: ../package_master');
                            }
                        }
                    } 
                    else {
                        $packageid = $id;
                        $projectid = $proj_name;

                        if ($segment == 37) {
                            $cc = 'J-SRIDHAR@lntecc.com';
                        } else {
                            $cc = 'shankaranr@lntecc.com';
                        }
                        $uid = $_SESSION['uid'];
                        $rsql = mssql_query("select * from usermst where usertype=10 and tech_seg like '%$segment%'");

                        $r = mssql_fetch_array($rsql);
                        $rec_uid = $r['uid'];
                        $rec_email = $r['uname'];
                        $rec_name = $r['name'];
                        //$rec_email = 'srini.rpsm@gmail.com';
                        //$rec_name = 'Srinivasan';

                        $isql = mssql_query("select isnull (max(ts_id+1),1) as id from  swift_techspoc");
                        $row = mssql_fetch_array($isql);
                        $ids = $row['id'];

//                $opstospocremarks = '$ops_remarks';


                        $sentdate = date('Y-m-d');
                        //$mtreq = formatDate(str_replace('/', '-', $mat_req_site), 'Y-m-d');
//                $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
                        $spsql = mssql_query("select revised_planned_date as planned from swift_packagestatus where ps_packid='" . $id . "' and ps_stageid=1");
//                $pquery = mssql_query($spsql);
                        $prow = mssql_fetch_array($pquery);
                        $planneddate = formatDate($prow['planned'], 'Y-m-d');

                        $spsql_spoc = mssql_query("select revised_planned_date as planned_spoc from swift_packagestatus where ps_packid='" . $id . "' and ps_stageid=3");

//                $pquery_spoc = mssql_query($spsql_spoc);
                        $prow_spoc = mssql_fetch_array($spsql_spoc);
                        $planneddate_spoc = formatDate($prow_spoc['planned_spoc'], 'd-M-Y');
                        $get_projname = mssql_query(" select proj_name from   dbo.Project where proj_id='" . $proj_name . "'");
                        $pnameqrow = mssql_fetch_array($get_projname);

//                $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
//                $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
                        $expected_date = $sentdate;
                        $actual_date = $sentdate;
                        $sql = "insert into swift_techspoc ( ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ts_planneddate,ts_remarks,ts_status,ts_active)"
                                . "values('" . $ids . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','2','3','" . $sentdate . "','','" . mssql_escape1($opstospocremarks) . "','0','1')";
                        $insert = mssql_query($sql);
                        if ($insert) {
                            $update = mssql_query("update swift_packagemaster set  tech_status=1  where pm_packid='" . $packageid . "'");
                            if ($update) {
                                $update_proj = mssql_query("update Project set  package_status=1  where proj_id='" . $projectid . "'");
                                $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                                $trow = mssql_fetch_array($tsql);
                                $tid = $trow['tid'];
                                $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
            values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','2','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
                                $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                                $update_status = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $rec_uid . "',ps_remarks='" . mssql_escape1($opstospocremarks) . "',active='1' where ps_stageid='2'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");

//                        if ($update_status) {
//                            // header('Location: ../files_for_techspoc');
//                            echo "<script>window.location.href='../files_for_techspoc';</script>";
//                        }
                                require '../PHPMailer/PHPMailerAutoload.php';
                                $message = '<div width="100%" style="background: #f8f8f8;  font-family:verdana; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
    <div style="max-width: 100%;  font-size: 12px">
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: -30px">
            <tbody>
                <tr>
                    <td style="vertical-align: top; " align="center">
                        <!-- <img src="../images/logo-dark.png" alt="Eliteadmin Responsive web app kit" style="border:none" height="100px;" width="100px"> -->
                    </td>
                </tr>
            </tbody>
        </table>
        <div style=" background: #fff;  font-family: calibri; font-size: 16px; font-weight: normal; font-size: 16px;">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td><b>Dear Sir/Madam,</b>

                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; Margin-bottom: 15px;">The Following files has been sent to your flow for action.</p>
                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; ">Please use the below links to view </p>
                            <p  style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal;   Margin-bottom: 15px;"> <a href="https://swc.ltts.com/swift" target="blank">Link - SWIFT</a></p>
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                                <thead >
                                    <tr>
                                        <th style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Project Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Package Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Received From</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Received Stage</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Remarks</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Next Stage Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Stage Planned</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pnameqrow['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pack_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $_SESSION['name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">Ops to Tech. SPOC</td>
                                          <td style=" text-align: center;  border: 1px solid #ddd;">' . $opstospocremarks . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">Tech SPOC to Expert</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $planneddate_spoc . '</td>
                                      
                                    </tr>
                                </tbody>
                            </table><br>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Regards,</p>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><b>Swift</b></p>

                            <p style="font-family:calibri;color:lightgray;font-size:14px">This is Auto generated mail hence Please do not reply</p>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
            <p> Powered by Bluekode
                <br>
        </div>
    </div>
</div>';
                                $email = $rec_email;
                                $name = $rec_name;
//For Live
                                $get_smtp = mssql_query("select * from dbo.swift_smtp_setting where smtp_status=1");
                                //For Production 
//                        $get_smtp = mssql_query("select * from dbo.swift_smtp_setting where smtp_status=0");
                                $sm_row = mssql_fetch_array($get_smtp);
                                $con_smtp = $sm_row['smtp_email'];
                                $con_email = $sm_row['smtp_sendermail'];
                                $con_pass = $sm_row['smtp_password'];
                                $con_port = $sm_row['smtp_portno'];

                                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                                try {
                                    //Server settingss
                                    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
                                    $mail->isSMTP();                                      // Set mailer to use SMTP
                                    $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
                                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                    $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
                                    $mail->Password = '!Lntswc123';                      // SMTP password
//        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
                                    $mail->Port = 25;
//                            $mail->Port = 587;
// TCP port to connect to
//Recipients
                                    $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
                                    $mail->addAddress($rec_email, $rec_name); // Add a recipient
                                    //$mail->addAddress('uuk@lntecc.com', 'Smart Signoff'); // Add a recipient
//                            $mail->addAddress('srini.rpsm@gmail.com'); // Name is optional

                                    $sqlccs1 = mssql_query("select * from swiftCcMailSetting where   ccExceptProjid in (0) and ccSegid=$segment and ccActive=1");
                                    $cc_numr1 = mssql_num_rows($sqlccs1);
                                    if ($cc_numr1 > 0) {
                                        while ($cc_row1 = mssql_fetch_array($sqlccs1)) {
                                            $mail->addCC($cc_row1['ccMail'], 'SWIFT'); // Add a recipient
                                        }
                                    }

                                    $sqlccs2 = mssql_query("select * from swiftCcMailSetting where ccExceptProjid in ($projectid)  and ccSegid=$segment and ccActive=1");
                                    $cc_numr2 = mssql_num_rows($sqlccs2);
                                    if ($cc_numr2 > 0) {
                                        while ($cc_row2 = mssql_fetch_array($sqlccs2)) {
                                            $mail->addCC($cc_row2['ccMail'], 'SWIFT'); // Add a recipient
                                        }
                                    }





                                    $mail->addCC('uuk@lntecc.com', 'SWIFT'); // Add a recipient
                                    // $mail->addReplyTo('info@example.com', 'Information');
                                    //$mail->addCC('cc@example.com');
                                    $mail->addBCC('srini.rpsm@gmail.com');
                                    //Attachments
                                    // $mail->addAttachment('C:/xampp/htdocs/QA/fpdf/status_pdf/'.$filename);                    // Add attachments
                                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');// Optional name
                                    //Content
                                    $mail->isHTML(true);                                 // Set email format to HTML
                                    // $mail->AddEmbeddedImage('logo.png', 'logoimg'); // attach file logo.jpg, and later link to it using identfier logoimg

                                    $mail->Subject = 'Swift';
                                    $mail->Body = $message;
                                    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                                    $isql = mssql_query("select isnull (max(sms_id+1),1) as id from  sms_tracking");
                                    $row = mssql_fetch_array($isql);
                                    $sid = $row['id'];
                                    $sql = mssql_query("insert into sms_tracking (sms_id,sms_userid,sms_email,sent_date,_type)"
                                            . "values('" . $sid . "','" . $rec_uid . "','" . $rec_email . "',GETDATE(),'1')");
                                    $mail->send();
                                    $Msg = "Mail Send";
                                } catch (Exception $e) {
                                    echo 'Message could not be sent.';
                                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                                    $Msg = "Mail Not Send";
                                }
                            }
                        }

                        if ($page_name == 'files') {
                            echo "<script>window.location.href='../files_from_contract';</script>";
//                    header('Location: ../files_from_contract');
                        } elseif ($page_name == 'masters') {
                            echo "<script>window.location.href='../package_master';</script>";
//                    header('Location: ../package_master');
                        }
                    }
                }
//            
                // print_r($stages);
//            echo "update swift_packagestatus set ps_expdate='" . date('Y-m-d H:i:s') . "',ps_actualdate='" . date('Y-m-d H:i:s') . "',ps_userid='" . $uid . "' where ps_stageid='1' and ps_packid='" . $id . "' ";
            }
        }
    }

    if (isset($_REQUEST['package_excel_upload'])) {
        extract($_REQUEST);
        $uid = $_SESSION['uid'];
        $proj_name = $eproj_name;
        $stages = array();
        $filename = $_FILES["file"]["tmp_name"];
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($filename, "r");
            $data = array();
            //data from csv file
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $data[] = $emapData;
            }
            ini_set('max_execution_time', 300);
            $count = count($data);
            for ($x = 1; $x < $count; $x++) {
                $pack_name = trim($data[$x][0]);
                $pack_cat_name = trim($data[$x][1]);
                $org_schedule = trim($data[$x][2]);
                $mat_req_site = trim($data[$x][3]);
                $lead_time = trim($data[$x][4]);
                $opstospocremarks = trim($data[$x][5]);


                //check package name exsits respective of project
                $sql = "select * from  swift_packagemaster where pm_packagename='" . filterText($pack_name) . "' and pm_projid='" . $proj_name . "'" . '<br>';
                $query = mssql_query($sql);
                $num_rows = mssql_num_rows($query);
                if ($num_rows > 0) {
                    if ($epage_name == 'files') {
                        echo "<script>window.location.href='../files_from_contract?msg=0';</script>";
//                    header('Location: ../files_from_contract?msg=0');
                    } elseif ($epage_name == 'masters') {
                        echo "<script>window.location.href='../package_master?msg=0';</script>";
//                    header('Location: ../package_master?msg=0');
                    }
                } else {
                    //check category
                    $cat_sql = "select * from  swift_package_category where pc_pack_cat_name='" . $pack_cat_name . "'";
                    $cat_query = mssql_query($cat_sql);
                    $num_rows = mssql_num_rows($cat_query);
                    if ($num_rows > 0) {
                        $row = mssql_fetch_array($cat_query);
                        $cat_rid = $row['pc_id'];
                    } else {
                        $isql = mssql_query("select isnull (max(pc_id+1),1) as id from  swift_package_category");
                        $row = mssql_fetch_array($isql);
                        $cat_rid = $row['id'];
                        $sql = mssql_query("insert into swift_package_category(pc_id,pc_pack_cat_name,pc_leadtime,pc_uid,pc_create,pm_remarks)"
                                . "values('" . $cat_rid . "','" . $pack_cat_name . "','" . $lead_time . "','" . $uid . "',GETDATE(),'" . mssql_escape1($opstospocremarks) . "')");
                    }


                    //insert into package Master
                    $isql = mssql_query("select isnull (max(pm_packid+1),1) as id from  swift_packagemaster");
                    $row = mssql_fetch_array($isql);
                    $id = $row['id'];
                    $mtreq = formatDate(str_replace('/', '-', $mat_req_site), 'Y-m-d');
                    $org = formatDate(str_replace('/', '-', $org_schedule), 'Y-m-d');
                    $sql = "insert into swift_packagemaster(pm_packid,pm_projid,pm_packagename,pm_createdate,pm_material_req,pm_leadtime,pm_userid,tech_status,pm_revised_material_req,pm_revised_lead_time,emr_status,pm_catid)"
                            . "values('" . $id . "','" . $proj_name . "','" . mssql_escape1($pack_name) . "','" . date('Y-m-d h:i:s') . "','" . $org . "','" . mssql_escape1($lead_time) . "','" . $uid . "','0','" . $mtreq . "','" . mssql_escape1($lead_time) . "','0','" . $cat_rid . "')";

                    $insert = mssql_query($sql);
                    if ($insert) {
                        $update = mssql_query("update Project set package_status=1 where proj_id='" . $proj_name . "'");
                        //calculation of planned Dates
                        $diff = ($lead_time + 54);
                        $stages[1] = date('d-M-y', strtotime(formatDate($mtreq, 'Y-m-d') . '-' . $diff . 'days')); //1Contracts to Ops
                        $stages[2] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //2Ops to Engineering SPOC
                        $stages[3] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //3$SPOC_to_Tech_Expert
                        $stages[4] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //4$Tech_Expert_Clerance
                        $stages[5] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //5$Tech_Expert_to_CTO_for_approval
                        $stages[6] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //6$CTO_Approval
                        $stages[7] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //7$Tech_SPOC_toOps
                        $stages[8] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //8$OpstoOM
                        $stages[9] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //9$OMApproval
                        $stages[10] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //10$OMtoOps 
                        $stages[11] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //11$OpshandingovertoSCM
                        $stages[12] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //12$AcutalOpshandingovertoSCM
                        $stages[13] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //13$FileAcceptancefromOpsDate
                        $stages[14] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //14$FileReceivedDateRevised
                        $stages[15] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //15$ExpectedDateofOrderClosing
                        $stages[16] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //16$PackageSentDate
                        $stages[17] = formatDate($stages[16] . '+4 days', 'Y-m-d'); //17$PackageApprovedDate
                        $stages[18] = formatDate($stages[17] . '+2 days', 'Y-m-d'); //18$LOIdate
                        $stages[19] = formatDate($stages[18] . '+2 days', 'Y-m-d'); //19$EMRdate
                        $stages[20] = formatDate($stages[19] . '+3 days', 'Y-m-d'); //20$PODate
                        $stages[21] = formatDate($stages[20] . '+2 days', 'Y-m-d'); //21$POApprovedDate
                        $stages[22] = formatDate($stages[18] . '+3 days', 'Y-m-d'); //22$WODate
                        $stages[23] = formatDate($stages[22] . '+2 days', 'Y-m-d'); //23$WOApprovedDate
                        $stages[24] = formatDate($stages[21] . '+7 days', 'Y-m-d'); //24$LCDate
                        $stages[25] = formatDate($stages[21] . '+3 days', 'Y-m-d'); //25$VendortoOpsDrawingSamplePOCSubmission
                        $stages[26] = formatDate($stages[25] . '+1 days', 'Y-m-d'); //26$OpstoEngineeringVendor Drawing/POC
                        $stages[27] = formatDate($stages[26] . '+2 days', 'Y-m-d'); //27$EngineeringtoOpsforVendorDesignApproval
                        $stages[28] = formatDate($stages[27] . '+1 days', 'Y-m-d'); //28$OpstoVendorApprovedDrawing
                        $stages[29] = formatDate($stages[28] . '+2 days', 'Y-m-d'); //29$ManufacturingClearance
                        $inf = ($lead_time + 2);
                        $stages[30] = date('d-M-y', strtotime(formatDate($stages[29] . '+', 'Y-m-d') . $inf . 'days')); //30$Inspection
                        $stages[31] = formatDate($stages[30] . '+2 days', 'Y-m-d'); //31$MDCC 
                        $stages[32] = formatDate($stages[31] . '+15 days', 'Y-m-d'); //32$CustomClearanceDate
                        $stages[33] = formatDate($stages[31] . '+3 days', 'Y-m-d'); //33$Mtlsreceivedatsite
                        $stages[34] = formatDate($stages[33] . '+2 days', 'Y-m-d'); //34$MRN
                        $countt = sizeof($stages);
                        for ($i = 1; $i <= $countt; $i++) {
                            $sql = "insert into swift_packagestatus(ps_projid,ps_packid,ps_stageid,ps_planneddate,ps_userid,revised_planned_date)"
                                    . "values('" . $proj_name . "','" . $id . "','" . $i . "','" . $stages[$i] . "','','" . $stages[$i] . "')";
                            mssql_query($sql);
                        }
                        $contoops = mssql_query("update swift_packagestatus set  active=0,ps_expdate='" . date('Y-m-d H:i:s') . "',ps_actualdate='" . date('Y-m-d H:i:s') . "',ps_userid='" . $uid . "' where ps_stageid='1' and ps_packid='" . $id . "' ");
                        $update_stage = mssql_query("update swift_packagestatus set active=1  where ps_stageid='2' and ps_packid='" . $id . "' ");
                        $stages[1] = date('d-M-y', strtotime(formatDate($org, 'Y-m-d') . '-' . $diff . 'days')); //1Contracts to Ops
                        $stages[2] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //2Ops to Engineering SPOC
                        $stages[3] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //3$SPOC_to_Tech_Expert
                        $stages[4] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //4$Tech_Expert_Clerance
                        $stages[5] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //5$Tech_Expert_to_CTO_for_approval
                        $stages[6] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //6$CTO_Approval
                        $stages[7] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //7$Tech_SPOC_toOps
                        $stages[8] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //8$OpstoOM
                        $stages[9] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //9$OMApproval
                        $stages[10] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //10$OMtoOps 
                        $stages[11] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //11$OpshandingovertoSCM
                        $stages[12] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //12$AcutalOpshandingovertoSCM
                        $stages[13] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //13$FileAcceptancefromOpsDate
                        $stages[14] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //14$FileReceivedDateRevised
                        $stages[15] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //15$ExpectedDateofOrderClosing
                        $stages[16] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //16$PackageSentDate
                        $stages[17] = formatDate($stages[16] . '+4 days', 'Y-m-d'); //17$PackageApprovedDate
                        $stages[18] = formatDate($stages[17] . '+2 days', 'Y-m-d'); //18$LOIdate
                        $stages[19] = formatDate($stages[18] . '+2 days', 'Y-m-d'); //19$EMRdate
                        $stages[20] = formatDate($stages[19] . '+3 days', 'Y-m-d'); //20$PODate
                        $stages[21] = formatDate($stages[20] . '+2 days', 'Y-m-d'); //21$POApprovedDate
                        $stages[22] = formatDate($stages[18] . '+3 days', 'Y-m-d'); //22$WODate
                        $stages[23] = formatDate($stages[22] . '+2 days', 'Y-m-d'); //23$WOApprovedDate
                        $stages[24] = formatDate($stages[21] . '+7 days', 'Y-m-d'); //24$LCDate
                        $stages[25] = formatDate($stages[21] . '+3 days', 'Y-m-d'); //25$VendortoOpsDrawingSamplePOCSubmission
                        $stages[26] = formatDate($stages[25] . '+1 days', 'Y-m-d'); //26$OpstoEngineeringVendor Drawing/POC
                        $stages[27] = formatDate($stages[26] . '+2 days', 'Y-m-d'); //27$EngineeringtoOpsforVendorDesignApproval
                        $stages[28] = formatDate($stages[27] . '+1 days', 'Y-m-d'); //28$OpstoVendorApprovedDrawing
                        $stages[29] = formatDate($stages[28] . '+2 days', 'Y-m-d'); //29$ManufacturingClearance
                        $inf = ($lead_time + 2);
                        $stages[30] = date('d-M-y', strtotime(formatDate($stages[29] . '+', 'Y-m-d') . $inf . 'days')); //30$Inspection
                        $stages[31] = formatDate($stages[30] . '+2 days', 'Y-m-d'); //31$MDCC 
                        $stages[32] = formatDate($stages[31] . '+15 days', 'Y-m-d'); //32$CustomClearanceDate
                        $stages[33] = formatDate($stages[31] . '+3 days', 'Y-m-d'); //33$Mtlsreceivedatsite
                        $stages[34] = formatDate($stages[33] . '+2 days', 'Y-m-d'); //34$MRN
                        $counnt = sizeof($stages);
                        for ($i = 1; $i <= $counnt; $i++) {
                            $sql = "update swift_packagestatus set ps_planneddate='" . $stages[$i] . "' where ps_projid='" . $proj_name . "' and ps_packid='" . $id . "' and ps_stageid='" . $i . "'";
                            $pack_status = mssql_query($sql);
                        }

                        $packageid = $id;
                        $projectid = $proj_name;
                        $uid = $_SESSION['uid'];
                        $rsql = mssql_query("select uid from usermst where usertype=10");
                        $r = mssql_fetch_array($rsql);
                        $rec_uid = $r['uid'];

                        $isql = mssql_query("select isnull (max(ts_id+1),1) as id from  swift_techspoc");
                        $row = mssql_fetch_array($isql);
                        $ids = $row['id'];


                        $sentdate = date('Y-m-d');
                        //$mtreq = formatDate(str_replace('/', '-', $mat_req_site), 'Y-m-d');
//                $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
                        $spsql = mssql_query("select revised_planned_date as planned from swift_packagestatus where ps_packid='" . $ids . "' and ps_stageid=1");
                        $pquery = mssql_query($spsql);
                        $prow = mssql_fetch_array($pquery);
                        $planneddate = formatDate($prow['planned'], 'Y-m-d');

//                $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
//                $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
                        $expected_date = $sentdate;
                        $actual_date = $sentdate;
                        $sql = "insert into swift_techspoc ( ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ts_planneddate,ts_remarks,ts_status,ts_active)"
                                . "values('" . $ids . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','2','3','" . $sentdate . "','','" . mssql_escape1($opstospocremarks) . "','0','1')";
                        $insert = mssql_query($sql);
                        if ($insert) {
                            $update = mssql_query("update swift_packagemaster set  tech_status=1  where pm_packid='" . $packageid . "'");
                            if ($update) {
                                $update_proj = mssql_query("update Project set  package_status=1  where proj_id='" . $projectid . "'");
                                $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                                $trow = mssql_fetch_array($tsql);
                                $tid = $trow['tid'];
                                $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
            values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','2','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . mssql_escape1($opstospocremarks) . "','0')");
                                $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                                $update_status = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . mssql_escape1($opstospocremarks) . "',active='1' where ps_stageid='2'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");

//                        if ($update_status) {
//                            // header('Location: ../files_for_techspoc');
//                            echo "<script>window.location.href='../files_for_techspoc';</script>";
//                        }
                            }
                        }
                    }
                }
            }
            fclose($file);
            if ($epage_name == 'files') {
                echo "<script>window.location.href='../files_from_contract';</script>";
//            header('Location: ../files_from_contract');
            } elseif ($epage_name == 'masters') {
                echo "<script>window.location.href='../package_master';</script>";
//            header('Location: ../package_master');
            }
        }
    }


    if (isset($_REQUEST['package_update'])) {
        extract($_REQUEST);
        $uid = $_SESSION['uid'];
        if ($opstospocremarks == '') {
            $opstospocremarks = 'Nil';
        }
        $stages = array();
        $mtreq = formatDate(str_replace('/', '-', $mat_req_site), 'Y-m-d');
        $org = formatDate(str_replace('/', '-', $org_schedule), 'Y-m-d');

        $sql = "select * from swift_packagemaster where pm_packid='" . $pck_id . "' and pm_projid='" . $proj_name . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {

            $sql = "update swift_packagemaster set pm_material_req='" . $org . "' , pm_leadtime='" . mssql_escape1($lead_time) . "',pm_revised_material_req='" . $mtreq . "',pm_revised_lead_time='" . $lead_time . "',pm_remarks='" . mssql_escape1($opstospocremarks) . "' where pm_packid='" . $pck_id . "' and pm_projid='" . $proj_name . "' ";
            $update = mssql_query($sql);
            if ($update) {

                $diff = ($lead_time + 54);
                $stages[1] = date('d-M-y', strtotime(formatDate($mtreq, 'Y-m-d') . '-' . $diff . 'days')); //1Contracts to Ops
                $stages[2] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //2Ops to Engineering SPOC
                $stages[3] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //3$SPOC_to_Tech_Expert
                $stages[4] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //4$Tech_Expert_Clerance
                $stages[5] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //5$Tech_Expert_to_CTO_for_approval
                $stages[6] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //6$CTO_Approval
                $stages[7] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //7$Tech_SPOC_toOps
                $stages[8] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //8$OpstoOM
                $stages[9] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //9$OMApproval
                $stages[10] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //10$OMtoOps 
                $stages[11] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //11$OpshandingovertoSCM
                $stages[12] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //12$AcutalOpshandingovertoSCM
                $stages[13] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //13$FileAcceptancefromOpsDate
                $stages[14] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //14$FileReceivedDateRevised
                $stages[15] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //15$ExpectedDateofOrderClosing
                $stages[16] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //16$PackageSentDate
                $stages[17] = formatDate($stages[16] . '+4 days', 'Y-m-d'); //17$PackageApprovedDate
                $stages[18] = formatDate($stages[17] . '+2 days', 'Y-m-d'); //18$LOIdate
                $stages[19] = formatDate($stages[18] . '+2 days', 'Y-m-d'); //19$EMRdate
                $stages[20] = formatDate($stages[19] . '+3 days', 'Y-m-d'); //20$PODate
                $stages[21] = formatDate($stages[20] . '+2 days', 'Y-m-d'); //21$POApprovedDate
                $stages[22] = formatDate($stages[18] . '+3 days', 'Y-m-d'); //22$WODate
                $stages[23] = formatDate($stages[22] . '+2 days', 'Y-m-d'); //23$WOApprovedDate
                $stages[24] = formatDate($stages[21] . '+7 days', 'Y-m-d'); //24$LCDate
                $stages[25] = formatDate($stages[21] . '+3 days', 'Y-m-d'); //25$VendortoOpsDrawingSamplePOCSubmission
                $stages[26] = formatDate($stages[25] . '+1 days', 'Y-m-d'); //26$OpstoEngineeringVendor Drawing/POC
                $stages[27] = formatDate($stages[26] . '+2 days', 'Y-m-d'); //27$EngineeringtoOpsforVendorDesignApproval
                $stages[28] = formatDate($stages[27] . '+1 days', 'Y-m-d'); //28$OpstoVendorApprovedDrawing
                $stages[29] = formatDate($stages[28] . '+2 days', 'Y-m-d'); //29$ManufacturingClearance
                $inf = ($lead_time + 2);
                $stages[30] = date('d-M-y', strtotime(formatDate($stages[29] . '+', 'Y-m-d') . $inf . 'days')); //30$Inspection
                $stages[31] = formatDate($stages[30] . '+2 days', 'Y-m-d'); //31$MDCC 
                $stages[32] = formatDate($stages[31] . '+15 days', 'Y-m-d'); //32$CustomClearanceDate
                $stages[33] = formatDate($stages[31] . '+3 days', 'Y-m-d'); //33$Mtlsreceivedatsite
                $stages[34] = formatDate($stages[33] . '+2 days', 'Y-m-d'); //34$MRN

                $countt = sizeof($stages);
                for ($i = 1; $i <= $countt; $i++) {
                    $sql = "update swift_packagestatus set ps_planneddate='" . $stages[$i] . "',revised_planned_date='" . $stages[$i] . "' where ps_packid='" . $pck_id . "' and ps_projid='" . $proj_name . "' and ps_stageid='" . $i . "'  ";
                    mssql_query($sql);
                }

                $diff = ($lead_time + 54);
                $stages[1] = date('d-M-y', strtotime(formatDate($org, 'Y-m-d') . '-' . $diff . 'days')); //1Contracts to Ops
                $stages[2] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //2Ops to Engineering SPOC
                $stages[3] = formatDate($stages[1] . '+1 days', 'Y-m-d'); //3$SPOC_to_Tech_Expert
                $stages[4] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //4$Tech_Expert_Clerance
                $stages[5] = formatDate($stages[3] . '+5 days', 'Y-m-d'); //5$Tech_Expert_to_CTO_for_approval
                $stages[6] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //6$CTO_Approval
                $stages[7] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //7$Tech_SPOC_toOps
                $stages[8] = formatDate($stages[5] . '+2 days', 'Y-m-d'); //8$OpstoOM
                $stages[9] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //9$OMApproval
                $stages[10] = formatDate($stages[8] . '+3 days', 'Y-m-d'); //10$OMtoOps 
                $stages[11] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //11$OpshandingovertoSCM
                $stages[12] = formatDate($stages[10] . '+1 days', 'Y-m-d'); //12$AcutalOpshandingovertoSCM
                $stages[13] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //13$FileAcceptancefromOpsDate
                $stages[14] = formatDate($stages[12] . '+1 days', 'Y-m-d'); //14$FileReceivedDateRevised
                $stages[15] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //15$ExpectedDateofOrderClosing
                $stages[16] = formatDate($stages[14] . '+12 days', 'Y-m-d'); //16$PackageSentDate
                $stages[17] = formatDate($stages[16] . '+4 days', 'Y-m-d'); //17$PackageApprovedDate
                $stages[18] = formatDate($stages[17] . '+2 days', 'Y-m-d'); //18$LOIdate
                $stages[19] = formatDate($stages[18] . '+2 days', 'Y-m-d'); //19$EMRdate
                $stages[20] = formatDate($stages[19] . '+3 days', 'Y-m-d'); //20$PODate
                $stages[21] = formatDate($stages[20] . '+2 days', 'Y-m-d'); //21$POApprovedDate
                $stages[22] = formatDate($stages[18] . '+3 days', 'Y-m-d'); //22$WODate
                $stages[23] = formatDate($stages[22] . '+2 days', 'Y-m-d'); //23$WOApprovedDate
                $stages[24] = formatDate($stages[21] . '+7 days', 'Y-m-d'); //24$LCDate
                $stages[25] = formatDate($stages[21] . '+3 days', 'Y-m-d'); //25$VendortoOpsDrawingSamplePOCSubmission
                $stages[26] = formatDate($stages[25] . '+1 days', 'Y-m-d'); //26$OpstoEngineeringVendor Drawing/POC
                $stages[27] = formatDate($stages[26] . '+2 days', 'Y-m-d'); //27$EngineeringtoOpsforVendorDesignApproval
                $stages[28] = formatDate($stages[27] . '+1 days', 'Y-m-d'); //28$OpstoVendorApprovedDrawing
                $stages[29] = formatDate($stages[28] . '+2 days', 'Y-m-d'); //29$ManufacturingClearance
                $inf = ($lead_time + 2);
                $stages[30] = date('d-M-y', strtotime(formatDate($stages[29] . '+', 'Y-m-d') . $inf . 'days')); //30$Inspection
                $stages[31] = formatDate($stages[30] . '+2 days', 'Y-m-d'); //31$MDCC 
                $stages[32] = formatDate($stages[31] . '+15 days', 'Y-m-d'); //32$CustomClearanceDate
                $stages[33] = formatDate($stages[31] . '+3 days', 'Y-m-d'); //33$Mtlsreceivedatsite
                $stages[34] = formatDate($stages[33] . '+2 days', 'Y-m-d'); //34$MRN

                $count = sizeof($stages);
                for ($i = 1; $i <= $count; $i++) {
                    $sql = "update swift_packagestatus set ps_planneddate='" . $stages[$i] . "' where ps_packid='" . $pck_id . "' and ps_projid='" . $proj_name . "' and ps_stageid='" . $i . "'  ";
                    mssql_query($sql);
                }

                if ($page_name == 'masters') {
                    echo "<script>window.location.href='../package_master';</script>";
                }
            }
        }
    }
//} else {
//    die("CSRF token validation failed");
//}


//$Contracts_to_Ops
//$Ops_to_Engineering_SPOC
//$SPOC_to_Tech_Expert
//$Tech_Expert_Clerance
//$Tech_Expert_to_CTO_for_approval
//$CTO_Approval
//$Tech_SPOC_toOps
//$OpstoOM
//$OMApproval
//$OMtoOps
//$OpshandingovertoSCM
//$AcutalOpshandingovertoSCM
//$FileAcceptancefromOpsDate
//$FileReceivedDateRevised
//$ExpectedDateofOrderClosing
//$PackageSentDate
//$PackageApprovedDate
//$LOIdate
//$EMRdate
//$PODate
//$POApprovedDate
//$WODate
//$WOApprovedDate
//$LCDate
//$VendortoOpsDrawingSamplePOCSubmission
//$OpstoEngineeringVendor Drawing/POC
//$EngineeringtoOpsforVendorDesignApproval
//$OpstoVendorApprovedDrawing
//$ManufacturingClearance
//$Inspection
//$MDCC 
//$CustomClearanceDate
//$Mtlsreceivedatsite
//$MRN
?>
