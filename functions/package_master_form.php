<?php

// error_reporting(1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../config/inc_function.php");
$csrf_token = $_REQUEST['csrf_token'];
if (isset($_SESSION['token']) && $csrf_token === $_SESSION['token']) {

    if (isset($_REQUEST['package_create'])) {
        extract($_REQUEST);
        $omattachs = explode(",", $ptwattachment);
        array_splice($omattachs, 0, 1);
        $rec_uid = $_POST['user_filter'];
        $uid = $_SESSION['uid'];
        $milcom = $_SESSION['milcom'];
        if ($_SESSION['milcom'] == '1') {
            $seg = " and milcom_app='1'";
        } else {
            $seg = "and milcom_app!='1'";
        }

        if ($opstospocremarks == '') {
            $opstospocremarks = 'Nil';
        }
        if (isset($_POST['tech_skip'])) {
            $tech_skip = 0;
        } else {
            $tech_skip = 1;
        }
        if (isset($_POST['dates'])) {
            $counnt = count($_POST['stages']);
        }
        if (isset($_POST['pack_work_flow'])) {
            $pm_wfid = $_POST['pack_work_flow'];
            $stagesarr = $_POST['stages'];
        }
        $pm_stages = implode(",", $stagesarr);
        $count = sizeof($dates);
        // for ($i = 0; $i < $count; $i++) {
        //    print($stagesarr[$i]);echo "<br>";
        // }exit;

        // for ($z = 1; $z <= $stagect; $z++) {
        //     $dates  = $_POST['dates'][$z];
        //     $stages  = $_POST['stages'][$z];

        // }

        $segment_sql = mssql_query("select cat_id from Project where proj_id='" . $proj_name . "'");
        $sqry = mssql_fetch_array($segment_sql);
        $segment = $sqry['cat_id'];

        $stages = array();
        $sql = "select * from  swift_packagemaster where pm_packagename='" . sanitize($pack_name) . "' and pm_projid='" . $proj_name . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);

        if ($num_rows > 0) {
            if ($page_name == 'files') {
                echo "<script>window.location.href='../files_from_contract?msg=0';</script>";
            } elseif ($page_name == 'masters') {
                echo "<script>window.location.href='../package_master?msg=0';</script>";
            }
        } else {
            $isql = mssql_query("select isnull (max(pm_packid+1),1) as id from  swift_packagemaster");

            $row = mssql_fetch_array($isql);
            $id = $row['id'];
            $packageid = $id;
            $projectid = $proj_name;
            $sentdate = date('Y-m-d');
            $expected_date = $sentdate;
            $actual_date = $sentdate;

            $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
            $row2 = mssql_fetch_array($isql2);
            $rsid = $row2['id'];
            // $rsql = mssql_query("select * from usermst where usertype=10 and tech_seg like '%$segment%' $seg");
            // $r = mssql_fetch_array($rsql);
            // $rec_uid = $r['uid'];



            $mtreq = formatDate(str_replace('/', '-', $mat_req_site), 'Y-m-d');
            $org = formatDate(str_replace('/', '-', $org_schedule), 'Y-m-d');

            $sql = "insert into swift_packagemaster(pm_packid,pm_projid,pm_packagename,pm_createdate,pm_material_req,pm_leadtime,pm_userid,tech_status,pm_revised_material_req,pm_revised_lead_time,emr_status,pm_catid,pm_remarks,tech_skip, pm_wfid,pm_stages,lt_flag)"
                . "values('" . $id . "','" . $proj_name . "','" . sanitize($pack_name) . "','" . date('Y-m-d h:i:s') . "','" . $org . "','" . sanitize($lead_time) . "','" . $uid . "','0','" . $mtreq . "','" . sanitize($lead_time) . "','0','" . $pack_cat_name . "','" . sanitize($opstospocremarks) . "','" . $tech_skip . "','" . $pm_wfid . "' ,'" . $pm_stages . "' ,'" . $lt_violation . "' )";

            $insert = mssql_query($sql);

            if ($insert) {
                $update = mssql_query("update Project set package_status=1 where proj_id='" . $proj_name . "'");
                if (isset($dates)) {
                    $count = sizeof($dates);
                    for ($i = 0; $i < $count; $i++) {
                        $sql = "insert into swift_packagestatus(ps_projid,ps_packid,ps_stageid,ps_planneddate,ps_userid,revised_planned_date)"
                            . "values('" . $proj_name . "','" . $id . "','" . $stagesarr[$i] . "','" . $dates[$i] . "','','" . $dates[$i] . "')";
                        $pack_status = mssql_query($sql);
                    }
                    if ($pack_status) {
                        echo "<script> alert('Successfully Inserted')</script>";
                    }
                }
                $contoops = mssql_query("update swift_packagestatus set active=0,ps_expdate='" . date('Y-m-d H:i:s') . "',ps_actualdate='" . date('Y-m-d H:i:s') . "',ps_userid='" . $uid . "' where ps_stageid='2' and ps_packid='" . $id . "' ");
                // $update_stage = mssql_query("update swift_packagestatus set active=1  where ps_stageid='3' and ps_packid='" . $id . "' ");
                if (isset($_POST['dates'])) {
                    $counnt = count($_POST['stages']);
                }
                for ($i = 0; $i < $counnt; $i++) {
                    //echo  $_POST['stages'][1];echo "<br>";
                    // echo  $_POST['stages'][2];echo "<br>";
                    $stage_date = $_POST['dates'][$i];
                    $stage_id = $_POST['stages'][$i];
                    $CurremtStage = $_POST['stages'][0];
                    $NextSatge = $_POST['stages'][1];

                    // $sql = "update swift_packagestatus set active='0',ps_planneddate='" . $stage_date . "',revised_planned_date='" . $stage_date . "' where ps_projid='" . $proj_name . "' and ps_packid='" . $id . "' and ps_stageid='" . $stage_id . "'";
                    // $pack_status = mssql_query($sql);

                    $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "' and ps_stageid='" . $stage_id . "' ");
                    $update_status = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . sanitize($opstospocremarks) . "',active='1' where ps_stageid='" . $NextSatge . "'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                }

                if ($pack_status) {
                    // echo "select uid from  swift_packagestatus as a 
                    // left join swift_stage_master as b on a.ps_stageid=b.stage_id
                    // left join usermst as c on c.usertype=b.usertype
                    // where a.active=1 and ps_packid='" .$id. "' 
                    // and tech_seg like '%$segment%' $seg";
                    $rsql = mssql_query("select uid from  swift_packagestatus as a 
                left join swift_stage_master as b on a.ps_stageid=b.stage_id
                left join usermst as c on c.usertype=b.usertype
                where a.active=1 and ps_packid='" . $id . "' 
                $seg");
                    $r = mssql_fetch_array($rsql);
                    // $rec_uid = $r['uid'];

                    $pquery = mssql_query("select revised_planned_date as planned from swift_packagestatus where ps_packid='" . $id . "' and ps_stageid='" . $CurremtStage . "'");
                    $prow = mssql_fetch_array($pquery);
                    $planneddate = formatDate($prow['planned'], 'Y-m-d');

                    //for current stage from to
                    $sql2 = "insert into swift_workflow_CurrentStage (cs_packid,cs_projid,from_stage_id,to_stage_id,from_uid,to_uid,cs_active,from_remark,to_remark,cs_created_date,cs_userid, cs_actual,cs_expdate)"
                        . "values('" . $packageid . "','" . $projectid . "','" . $CurremtStage . "','" . $NextSatge . "','" . $uid . "','" . $rec_uid . "','0','" . sanitize($opstospocremarks) . "','" . sanitize($opstospocremarks) . "','" . $sentdate . "','" . $uid . "','" . $actual_date . "','" . $expected_date . "')";
                    $insert2 = mssql_query($sql2);
                    // for Repository from and to
                    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
                        . "values('" . $rsid . "','" . $packageid . "','" . $projectid . "','" . $CurremtStage . "','" . $NextSatge . "','" . $uid . "','" . $rec_uid . "','0','" . sanitize($opstospocremarks) . "','" . sanitize($opstospocremarks) . "','" . $sentdate . "','" . $uid . "','" . $actual_date . "','" . $expected_date . "')";
                    $insert3 = mssql_query($sql3);

                    //Transaction history
                    $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                    $trow = mssql_fetch_array($tsql);
                    $tid = $trow['tid'];
                    $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $CurremtStage . "','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");

                    //upload attachment 
                    $doc_name = $_POST['doc_name'];
                    $stageid = $CurremtStage;
                    $pack_id = $packageid;
                    $projid = $projectid;
                    $uid = $_SESSION['uid'];
                    $attach_flag = 0;
                    if (isset($_POST['keyattach'])) {
                        $attach_flag = 1;
                    }
                    $isql = mssql_query("select isnull (max(upid+1),1) as id from  swift_comman_uploads");
                    $row = mssql_fetch_array($isql);
                    $id = $row['id'];
                    //check revisions 
                    $ck_sql = mssql_query("select * from swift_comman_uploads where up_packid='" . $pack_id . "' and up_projid ='" . $projid . "'");
                    $ck_numrows = mssql_num_rows($ck_sql);
                    $exp_rev = 'rev 0.' . $ck_numrows;
                    $rand = $id . '_' . $pack_id . '_' . $projid;
                    $ext = substr(strrchr($_FILES['file']['name'], "."), 1);
                    if (0 < $_FILES['file']['error']) {
                        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
                    } else if ($ext == 'msg') {
                        echo '.msg format not supported';
                    } else {
                        $name = $rand . '_' . $_FILES['file']['name'];
                        //echo $stageid;
                        $name1 = $_FILES['file']['name'];
                        move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/document/' . $name);
                           $sql = "insert into swift_comman_uploads(upid,up_projid,up_packid,up_uid,up_update,up_filename,up_filepath,upactive,rev,up_stage,key_flag) "
                            . "values('" . $id . "','" . $projid . "','" . $pack_id . "','" . $uid . "',GETDATE(),'" . $doc_name . "','" . $name . "','1','" . $exp_rev . "','" . $stageid . "','" . $attach_flag . "')";
                        $query = mssql_query($sql);
                        if ($query) {
                            echo 'success';
                        }
                        echo 'success';
                    }
                    $send_email = $cls_comm->Send_MailNew($projectid, $packageid, $milcom, $CurremtStage, $NextSatge);
                    if ($page_name == 'files') {
                         echo "<script>window.location.href='../files_from_contract';</script>";
                        //                    header('Location: ../files_from_contract');
                    } elseif ($page_name == 'masters') {
                          echo "<script>window.location.href='../package_master';</script>";
                        //                    header('Location: ../package_master');
                    }
                }
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
                            . "values('" . $cat_rid . "','" . $pack_cat_name . "','" . $lead_time . "','" . $uid . "',GETDATE(),'" . sanitize($opstospocremarks) . "')");
                    }


                    //insert into package Master
                    $isql = mssql_query("select isnull (max(pm_packid+1),1) as id from  swift_packagemaster");
                    $row = mssql_fetch_array($isql);
                    $id = $row['id'];
                    $mtreq = formatDate(str_replace('/', '-', $mat_req_site), 'Y-m-d');
                    $org = formatDate(str_replace('/', '-', $org_schedule), 'Y-m-d');
                    $sql = "insert into swift_packagemaster(pm_packid,pm_projid,pm_packagename,pm_createdate,pm_material_req,pm_leadtime,pm_userid,tech_status,pm_revised_material_req,pm_revised_lead_time,emr_status,pm_catid,pm_wfid,pm_stages)"
                        . "values('" . $id . "','" . $proj_name . "','" . sanitize($pack_name) . "','" . date('Y-m-d h:i:s') . "','" . $org . "','" . sanitize($lead_time) . "','" . $uid . "','0','" . $mtreq . "','" . sanitize($lead_time) . "','0','" . $cat_rid . "','" . $pm_wfid . "' ,'" . $pm_stages . "' )";

                    $insert = mssql_query($sql);
                    if ($insert) {
                        $update = mssql_query("update Project set package_status=1 where proj_id='" . $proj_name . "'");
                        //calculation of planned Dates
                        if (isset($dates)) {
                            $countt = sizeof($dates);
                            for ($i = 1; $i <= $countt; $i++) {
                                $sql = "insert into swift_packagestatus(ps_projid,ps_packid,ps_stageid,ps_planneddate,ps_userid,revised_planned_date)"
                                    . "values('" . $proj_name . "','" . $id . "','" . $i . "','" . $dates[$i] . "','','" . $dates[$i] . "')";
                                mssql_query($sql);
                            }
                        }
                        $contoops = mssql_query("update swift_packagestatus set  active=0,ps_expdate='" . date('Y-m-d H:i:s') . "',ps_actualdate='" . date('Y-m-d H:i:s') . "',ps_userid='" . $uid . "' where ps_stageid='2' and ps_packid='" . $id . "' ");
                        $update_stage = mssql_query("update swift_packagestatus set active=1  where ps_stageid='3' and ps_packid='" . $id . "' ");

                        if (isset($_POST['dates'])) {
                            $counnt = count($_POST['stages']);
                        }
                        for ($i = 0; $i < $counnt; $i++) {
                            $stage_date = $_POST['dates'][$i];
                            $stage_id = $_POST['stages'][$i];
                            $sql = "update swift_packagestatus set ps_planneddate='" . $stage_date . "',revised_planned_date='" . $stage_date . "' where ps_projid='" . $proj_name . "' and ps_packid='" . $id . "' and ps_stageid='" . $stage_id . "'";
                            $pack_status = mssql_query($sql);
                        }

                        $packageid = $id;
                        $projectid = $proj_name;
                        $uid = $_SESSION['uid'];
                        if ($_SESSION['milcom'] == '1') {
                            $seg = " and milcom_app='1'";
                        } else {
                            $seg = "and milcom_app!='1'";
                        }
                        $rsql = mssql_query("select uid from usermst where usertype=10 $seg");
                        $r = mssql_fetch_array($rsql);
                        //$rec_uid = $r['uid'];

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
                            . "values('" . $ids . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','2','3','" . $sentdate . "','','" . sanitize($opstospocremarks) . "','0','1')";
                        $insert = mssql_query($sql);
                        $sql2 = "insert into swift_workflow_CurrentStage (cs_packid,cs_projid,from_stage_id,to_stage_id,from_uid,to_uid,cs_active,from_remark,to_remark,cs_created_date,cs_userid, cs_actual,cs_expdate)"
                            . "values('" . $packageid . "','" . $projectid . "','2','3','" . $uid . "','" . $rec_uid . "','0','" . sanitize($opstospocremarks) . "','" . sanitize($opstospocremarks) . "','" . $sentdate . "','" . $uid . "','" . $actual_date . "','" . $expected_date . "')";
                        $insert2 = mssql_query($sql2);
                        $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
                            . "values('" . $rsid . "','" . $packageid . "','" . $projectid . "','2','3','" . $uid . "','" . $rec_uid . "','0','" . sanitize($opstospocremarks) . "','" . sanitize($opstospocremarks) . "','" . $sentdate . "','" . $uid . "','" . $actual_date . "','" . $expected_date . "')";
                        $insert3 = mssql_query($sql3);
                        if ($insert) {
                            $update = mssql_query("update swift_packagemaster set  tech_status=1  where pm_packid='" . $packageid . "'");
                            if ($update) {
                                $update_proj = mssql_query("update Project set  package_status=1  where proj_id='" . $projectid . "'");
                                $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                                $trow = mssql_fetch_array($tsql);
                                $tid = $trow['tid'];
                                $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
            values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','2','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . sanitize($opstospocremarks) . "','0')");
                                $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . sanitize($opstospocremarks) . "' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "' and ps_stageid='2'");
                                $update_status = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . sanitize($opstospocremarks) . "',active='1' where ps_stageid='3'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");

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

            $sql = "update swift_packagemaster set pm_material_req='" . $org . "' , pm_leadtime='" . sanitize($lead_time) . "',pm_revised_material_req='" . $mtreq . "',pm_revised_lead_time='" . $lead_time . "',pm_remarks='" . sanitize($opstospocremarks) . "' where pm_packid='" . $pck_id . "' and pm_projid='" . $proj_name . "' ";
            $update = mssql_query($sql);
            if ($update) {



                $countt = sizeof($dates);
                for ($i = 1; $i <= $countt; $i++) {
                    $sql = "update swift_packagestatus set ps_planneddate='" . $dates[$i] . "',revised_planned_date='" . $dates[$i] . "' where ps_packid='" . $pck_id . "' and ps_projid='" . $proj_name . "' and ps_stageid='" . $i . "'  ";
                    mssql_query($sql);
                }

                $diff = ($lead_time + 54);

                if (isset($_POST['dates'])) {
                    $counnt = count($_POST['stages']);
                }
                for ($i = 0; $i < $counnt; $i++) {
                    $stage_date = $_POST['dates'][$i];
                    $stage_id = $_POST['stages'][$i];
                    $sql = "update swift_packagestatus set ps_planneddate='" . $stage_date . "' where ps_projid='" . $proj_name . "' and ps_packid='" . $id . "' and ps_stageid='" . $stage_id . "'";
                    $pack_status = mssql_query($sql);
                }

                if ($page_name == 'masters') {
                    echo "<script>window.location.href='../package_master';</script>";
                }
            }
        }
    }
} else {
    die("CSRF token validation failed");
}
//$Contracts_to_Ops
//$Ops_to_Engineering_SPOC
//$SPOC_to_Tech_Expert
//$Tech_Expert_Clerance - Expert to Reviewer
//$Tech_Expert_to_CTO_for_approval - Tech_Reviewer_to_CTO_for_approval 
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
