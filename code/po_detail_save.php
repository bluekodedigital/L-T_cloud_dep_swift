<?php

include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('Asia/Kolkata');


$packid = $_POST['packid'];
$column_name = sanitize($_POST['name']);
$qty = sanitize($_POST['qty']);
$rid = $_POST['rid'];
$cus = $_POST['cus'];
$cnum = $_POST['cnum'];
$date = date('Y-m-d H:i:s');
$uid = $_SESSION['uid'];
$date_col = $column_name . '_date';
$stage_date = date('Y-m-d', strtotime($_POST['stage_date']));

$sql_ck = mssql_query("SELECT * FROM swift_poentrysave WHERE swe_packid='" . $packid . "' AND sweid='" . $rid . "'");
$check = mssql_num_rows($sql_ck);
if ($check > 0) {
    $row1 = mssql_fetch_array($sql_ck);
    $bal_qty = $row1['bal_qty'];
    $mqty_bal = $row1['mqty_bal'];
    $iqty_bal = $row1['iqty_bal'];
    $mdccqty_bal = $row1['mdccqty_bal'];
    $cclr_qty_bal = $row1['cclr_qty_bal'];

    $mqty = $row1['mqty'];
    $iqty = $row1['iqty'];
    $mdccqty = $row1['mdccqty'];
    $cclr_qty = $row1['cclr_qty'];
    $mrqty = $row1['mrqty'];
}

$isql2 = mssql_query("select * from  swift_workflow_CurrentStage  where cs_packid='$packid'");
$row2 = mssql_fetch_array($isql2);
$proj_id   = $row2['cs_projid'];
$senduserid = $_SESSION['uid'];
$from_stage_id = $row2['from_stage_id'];
$to_stage_id   = $row2['to_stage_id'];
$from_remark   = $row2['to_remark'];
$recvstageid   = $to_stage_id;
$sendstageid   = $from_stage_id;
$from_uid = $row2['from_uid'];
$to_uid   = $row2['to_uid'];

$actual = date("Y-m-d h:i:s");

$sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$proj_id' AND ps_packid='$packid' AND ps_stageid='15'";
$query = mssql_query($sql);
$row = mssql_fetch_array($query);
//$planned_date = $row['revised_planned_date'];
$planned_date = date('d-M-y', strtotime(str_replace('/', '-', $row['revised_planned_date'])));
$cqty = mssql_query("SELECT * FROM swift_po_master WHERE po_pack_id='" . $packid . "' AND po_id='" . $rid . "'");
$row = mssql_fetch_array($cqty);
$sqty = $row['po_scope_qty'];


if ($cnum == '1') {
    $action = 'Man.Clr';
    // echo $check;
    // echo "ji" ;die;
    if ($check > 0) {

        if ($bal_qty > 0) {
            $bal_qty = $row1['bal_qty'];
            if ($qty > $bal_qty) {
                echo 3;
                exit();
            } else {
                $sql = "UPDATE swift_poentrysave SET mqty ='" . ($mqty + $qty) . "',mqty_date = '" . $stage_date . "',bal_qty = '" . ($bal_qty - $qty) . "',
                mqty_bal = '" . ($mqty_bal + $qty) . "' WHERE sweid='" . $rid . "' AND swe_packid='" . $packid . "'";
                $query = mssql_query($sql);
                // update history
                $sql = "INSERT INTO swift_poentryhistory(swhid,swh_qte,swh_uid,actions,h_qty,e_date,disorder) 
                        VALUES('" . $rid . "','" . $packid . "','" . $uid . "','" . $action . "','" . $qty . "','" . $date . "','" . $cnum . "')";
                $query = mssql_query($sql);
                $upadate_all = mssql_query("update swift_packagestatus set active=0 where  ps_packid='" . $packid . "'");
                $upadate_29 = mssql_query("update swift_packagestatus set ps_userid='$senduserid', active=1,ps_expdate='" . $stage_date . "',ps_actualdate='" . $date . "' where  ps_packid='" . $packid . "' and ps_stageid=17");


                //STAGE HISTORY
                $sql1 = "UPDATE swift_transactions SET st_uid = '$senduserid',
                st_sentdate = GETDATE(),st_planneddate='$planned_date',st_actual = '$actual',
                st_expdate='$actual'  WHERE st_packid = '$packid' AND st_stageid = 16";
                $query1 = mssql_query($sql1);

                $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '16',
                to_stage_id = '17',cs_userid='$senduserid',cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                $query2 = mssql_query($sql2);

                $sql1 = "UPDATE swift_repository SET rs_userid='$senduserid',
                rs_actual = '$actual',rs_expdate='$actual'  
                WHERE rs_packid = '$packid' AND rs_to_stage = 16";

                $query1 = mssql_query($sql1);
                echo 2;
                exit();
            }
        } else {
            echo 5;
            exit();
        }
    } else {
        $bal_qty = $sqty;
        if ($qty > $bal_qty) {
            echo 3;
            exit();
        } else {
            $sql = "INSERT INTO swift_poentrysave(sweid,swe_qte,swe_uid,mqty,mqty_date,bal_qty,mqty_bal,swe_packid)  
            values('" . $rid . "','" . $packid . "','" . $uid . "','" . $qty . "','" . $stage_date . "','" . ($bal_qty - $qty) . "','" . ($mqty_bal + $qty) . "','" . $packid . "')";
            $query = mssql_query($sql);
            // update history
            $sql = "INSERT INTO swift_poentryhistory(swhid,swh_qte,swh_uid,actions,h_qty,e_date,disorder) 
                        VALUES('" . $rid . "','" . $packid . "','" . $uid . "','" . $action . "','" . $qty . "','" . $date . "','" . $cnum . "')";
            $query = mssql_query($sql);
            $upadate_all = mssql_query("update swift_packagestatus set active=0 where  ps_packid='" . $packid . "'");
            $upadate_29 = mssql_query("update swift_packagestatus set ps_userid='$senduserid',active=1,ps_expdate='" . $stage_date . "',ps_actualdate='" . $date . "' where  ps_packid='" . $packid . "' and ps_stageid=17");

            //insert to transaction table STAGE HISTORY

            $sql = "SELECT count(st_id) as rwcount FROM swift_transactions where st_packid='$packid' and st_stageid=16";
            $query = mssql_query($sql);
            $row = mssql_fetch_array($query);
            $rwcount = $row['rwcount'];

            if ($rwcount == 0) {


                $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
                $query = mssql_query($sql);
                $row = mssql_fetch_array($query);
                $id = $row['id'] + 1;


                $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('" . $id . "','" . $packid . "','" . $proj_id . "','" . $senduserid . "','" . $sendstageid . "',GETDATE(),'" . $planned_date . "','" . $actual . "','" . $actual . "','','0')";
                $query = mssql_query($sql);


                $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '16',
                to_stage_id = '17',cs_userid='$senduserid',from_remark = '$from_remark',
                cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                $query2 = mssql_query($sql2);

                $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
                $row2 = mssql_fetch_array($isql2);
                $rsid = $row2['id'];

                $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
                    . "values('" . $rsid . "','" . $packid . "','" . $proj_id . "','16','17','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','',
                '" . $actual . "','" . $senduserid . "','" . $actual . "','" . $planned_date . "')";
                $insert3 = mssql_query($sql3);
            } else {

                $sql1 = "UPDATE swift_transactions SET st_uid = '$senduserid',
                st_sentdate = GETDATE(),st_planneddate='$planned_date',st_actual = '$actual',
                st_expdate='$actual'  WHERE st_packid = '$packid' AND st_stageid = 16";
                $query1 = mssql_query($sql1);

                $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '16',
                to_stage_id = '17',cs_userid='$senduserid',
                cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";

                $query2 = mssql_query($sql2);

                $sql1 = "UPDATE swift_repository SET rs_userid='$senduserid',
                rs_actual = '$actual',rs_expdate='$actual'  
                WHERE rs_packid = '$packid' AND rs_to_stage = 16";

                $query1 = mssql_query($sql1);
            }
            echo 1;
            exit();
        }
    }
} else if ($cnum == '2') {
    $action = 'Inspection';
    if ($check > 0) {
        if ($mqty_bal > 0) {
            if ($qty > $mqty_bal) {
                echo 3;
                exit();
            } else {

                $sql = "UPDATE swift_poentrysave SET iqty ='" . ($iqty + $qty) . "',iqty_date = '" . $stage_date . "',mqty_bal = '" . ($mqty_bal - $qty) . "',
                iqty_bal = '" . ($iqty_bal + $qty) . "' WHERE sweid='" . $rid . "' AND swe_packid='" . $packid . "'";
                $query = mssql_query($sql);
                // update history
                $sql = "INSERT INTO swift_poentryhistory(swhid,swh_qte,swh_uid,actions,h_qty,e_date,disorder) 
                        VALUES('" . $rid . "','" . $packid . "','" . $uid . "','" . $action . "','" . $qty . "','" . $date . "','" . $cnum . "')";
                $query = mssql_query($sql);
                $upadate_all = mssql_query("update swift_packagestatus set active=0 where  ps_packid='" . $packid . "'");
                $upadate_30 = mssql_query("update swift_packagestatus set ps_userid='$senduserid',active=1,ps_expdate='" . $stage_date . "',ps_actualdate='" . $date . "' where  ps_packid='" . $packid . "' and ps_stageid=18");

                //insert to transaction table STAGE HISTORY

                $sql = "SELECT count(st_id) as rwcount FROM swift_transactions where st_packid='$packid' and st_stageid=17";
                $query = mssql_query($sql);
                $row = mssql_fetch_array($query);
                $rwcount = $row['rwcount'];

                if ($rwcount == 0) {

                    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
                    $query = mssql_query($sql);
                    $row = mssql_fetch_array($query);
                    $id = $row['id'] + 1;

                    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                    VALUES('" . $id . "','" . $packid . "','" . $proj_id . "','" . $senduserid . "','" . 17 . "',GETDATE(),'" . $planned_date . "','" . $actual . "','" . $actual . "','','0')";
                    $query = mssql_query($sql);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '17',
                    to_stage_id = '18',cs_userid='$senduserid',cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
                    $row2 = mssql_fetch_array($isql2);
                    $rsid = $row2['id'];

                    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
                        . "values('" . $rsid . "','" . $packid . "','" . $proj_id . "','17','18','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','',
                     '" . $actual . "','" . $senduserid . "','" . $actual . "','" . $planned_date . "')";
                    $insert3 = mssql_query($sql3);
                } else {

                    $sql1 = "UPDATE swift_transactions SET st_uid = '$senduserid',
                    st_sentdate = GETDATE(),st_planneddate='$planned_date',st_actual = '$actual',
                    st_expdate='$actual'  WHERE st_packid = '$packid' AND st_stageid = 17";
                    $query1 = mssql_query($sql1);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '17',
                    to_stage_id = '18',cs_userid='$senduserid',
                    cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $sql1 = "UPDATE swift_repository SET rs_userid='$senduserid',
                    rs_actual = '$actual',rs_expdate='$actual'  
                    WHERE rs_packid = '$packid' AND rs_to_stage = 17";
                    $query1 = mssql_query($sql1);
                }

                echo 2;
                exit();
            }
        } else {
            echo 5;
            exit();
        }
    } else {
        echo 5;
        exit();
    }
} else if ($cnum == '3') {
    $action = 'MDCC';
    // echo $cnum;die;
    // echo $check ; 
    if ($check > 0) {
        if ($iqty_bal > 0) {
            $iqty_bal = $row1['iqty_bal'];
            if ($qty > $iqty_bal) {
                echo 3;
                exit();
            } else {

                $sql = "UPDATE swift_poentrysave SET mdccqty ='" . ($mdccqty + $qty) . "',mdccqty_date = '" . $stage_date . "',iqty_bal = '" . ($iqty_bal - $qty) . "',
                mdccqty_bal = '" . ($mdccqty_bal + $qty) . "' WHERE sweid='" . $rid . "' AND swe_packid='" . $packid . "'";
                $query = mssql_query($sql);
                // update history
                $sql = "INSERT INTO swift_poentryhistory(swhid,swh_qte,swh_uid,actions,h_qty,e_date,disorder) 
                        VALUES('" . $rid . "','" . $packid . "','" . $uid . "','" . $action . "','" . $qty . "','" . $date . "','" . $cnum . "')";
                $query = mssql_query($sql);
                $upadate_all = mssql_query("update swift_packagestatus set active=0 where  ps_packid='" . $packid . "'");
                $upadate_31 = mssql_query("update swift_packagestatus set ps_userid='$senduserid',active=1,ps_expdate='" . $stage_date . "',ps_actualdate='" . $date . "' where  ps_packid='" . $packid . "' and ps_stageid=19");

                //insert to transaction table STAGE HISTORY

                $sql = "SELECT count(st_id) as rwcount FROM swift_transactions where st_packid='$packid' and st_stageid=18";
                $query = mssql_query($sql);
                $row = mssql_fetch_array($query);
                $rwcount = $row['rwcount'];

                if ($rwcount == 0) {

                    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
                    $query = mssql_query($sql);
                    $row = mssql_fetch_array($query);
                    $id = $row['id'] + 1;

                    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                          VALUES('" . $id . "','" . $packid . "','" . $proj_id . "','" . $senduserid . "','" . 18 . "',GETDATE(),'" . $planned_date . "','" . $actual . "','" . $actual . "','','0')";
                    $query = mssql_query($sql);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '18',
                          to_stage_id = '18',cs_userid='$senduserid',cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
                    $row2 = mssql_fetch_array($isql2);
                    $rsid = $row2['id'];

                    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
                        . "values('" . $rsid . "','" . $packid . "','" . $proj_id . "','18','19','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','',
                           '" . $actual . "','" . $senduserid . "','" . $actual . "','" . $planned_date . "')";
                    $insert3 = mssql_query($sql3);
                } else {

                    $sql1 = "UPDATE swift_transactions SET st_uid = '$senduserid',
                          st_sentdate = GETDATE(),st_planneddate='$planned_date',st_actual = '$actual',
                          st_expdate='$actual'  WHERE st_packid = '$packid' AND st_stageid = 18";
                    $query1 = mssql_query($sql1);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '18',
                          to_stage_id = '19',cs_userid='$senduserid',
                          cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $sql1 = "UPDATE swift_repository SET rs_userid='$senduserid',
                          rs_actual = '$actual',rs_expdate='$actual'  
                          WHERE rs_packid = '$packid' AND rs_to_stage = 18";
                    $query1 = mssql_query($sql1);
                }



                echo 2;
                exit();
            }
        } else {
            echo 5;
            exit();
        }
    } else {
        echo 5;
        exit();
    }
} else if ($cnum == '4') {
    $action = 'Cus.Clr';
    if ($check > 0) {
        if ($mdccqty_bal > 0) {
            $mdccqty_bal = $row1['mdccqty_bal'];
            if ($qty > $mdccqty_bal) {
                echo 3;
                exit();
            } else {
                $sql = "UPDATE swift_poentrysave SET cclr_qty ='" . ($cclr_qty + $qty) . "',cclr_qty_date = '" . $stage_date . "',mdccqty_bal = '" . ($mdccqty_bal - $qty) . "',
                cclr_qty_bal = '" . ($cclr_qty_bal + $qty) . "' WHERE sweid='" . $rid . "' AND swe_packid='" . $packid . "'";
                $query = mssql_query($sql);
                // update history
                $sql = "INSERT INTO swift_poentryhistory(swhid,swh_qte,swh_uid,actions,h_qty,e_date,disorder) 
                        VALUES('" . $rid . "','" . $packid . "','" . $uid . "','" . $action . "','" . $qty . "','" . $date . "','" . $cnum . "')";
                $query = mssql_query($sql);
                $upadate_all = mssql_query("update swift_packagestatus set active=0 where  ps_packid='" . $packid . "'");
                $upadate_32 = mssql_query("update swift_packagestatus set ps_userid='$senduserid',active=1,ps_expdate='" . $stage_date . "',ps_actualdate='" . $date . "' where  ps_packid='" . $packid . "' and ps_stageid=19");


                //insert to transaction table STAGE HISTORY

                $sql = "SELECT count(st_id) as rwcount FROM swift_transactions where st_packid='$packid' and st_stageid=18";
                $query = mssql_query($sql);
                $row = mssql_fetch_array($query);
                $rwcount = $row['rwcount'];

                if ($rwcount == 0) {

                    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
                    $query = mssql_query($sql);
                    $row = mssql_fetch_array($query);
                    $id = $row['id'] + 1;

                    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                          VALUES('" . $id . "','" . $packid . "','" . $proj_id . "','" . $senduserid . "','" . 18 . "',GETDATE(),'" . $planned_date . "','" . $actual . "','" . $actual . "','','0')";
                    $query = mssql_query($sql);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '18',
                          to_stage_id = '18',cs_userid='$senduserid',cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
                    $row2 = mssql_fetch_array($isql2);
                    $rsid = $row2['id'];

                    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
                        . "values('" . $rsid . "','" . $packid . "','" . $proj_id . "','18','19','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','',
                           '" . $actual . "','" . $senduserid . "','" . $actual . "','" . $planned_date . "')";
                    $insert3 = mssql_query($sql3);
                } else {

                    $sql1 = "UPDATE swift_transactions SET st_uid = '$senduserid',
                          st_sentdate = GETDATE(),st_planneddate='$planned_date',st_actual = '$actual',
                          st_expdate='$actual'  WHERE st_packid = '$packid' AND st_stageid = 18";
                    $query1 = mssql_query($sql1);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '18',
                          to_stage_id = '19',cs_userid='$senduserid',
                          cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $sql1 = "UPDATE swift_repository SET rs_userid='$senduserid',
                          rs_actual = '$actual',rs_expdate='$actual'  
                          WHERE rs_packid = '$packid' AND rs_to_stage = 18";
                    $query1 = mssql_query($sql1);
                }

                echo 2;
                exit();
            }
        } else {
            echo 5;
            exit();
        }
    } else {
        echo 5;
        exit();
    }
} else if ($cnum == '5') {
    $action = 'Mtl.Req@site';
    if ($check > 0) {
        if ($cclr_qty_bal > 0) {
            $cclr_qty_bal = $row1['cclr_qty_bal'];
            if ($qty > $cclr_qty_bal) {
                echo 3;
                exit();
            } else {
                $sql = "UPDATE swift_poentrysave SET mrqty ='" . ($mrqty + $qty) . "',mrqty_date = '" . $stage_date . "',cclr_qty_bal = '" . ($cclr_qty_bal - $qty) . "',
                mrqty_bal = '" . ($mrqty_bal + $qty) . "' WHERE sweid='" . $rid . "' AND swe_packid='" . $packid . "'";
                $query = mssql_query($sql);
                // update history
                $sql = "INSERT INTO swift_poentryhistory(swhid,swh_qte,swh_uid,actions,h_qty,e_date,disorder) 
                        VALUES('" . $rid . "','" . $packid . "','" . $uid . "','" . $action . "','" . $qty . "','" . $date . "','" . $cnum . "')";
                $query = mssql_query($sql);
                $upadate_all = mssql_query("update swift_packagestatus set active=0 where  ps_packid='" . $packid . "'");
                $upadate_33 = mssql_query("update swift_packagestatus set ps_userid='$senduserid',active=1,ps_expdate='" . $stage_date . "',ps_actualdate='" . $date . "' where  ps_packid='" . $packid . "' and ps_stageid=20");


                //insert to transaction table STAGE HISTORY

                $sql = "SELECT count(st_id) as rwcount FROM swift_transactions where st_packid='$packid' and st_stageid=19";
                $query = mssql_query($sql);
                $row = mssql_fetch_array($query);
                $rwcount = $row['rwcount'];

                if ($rwcount == 0) {

                    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
                    $query = mssql_query($sql);
                    $row = mssql_fetch_array($query);
                    $id = $row['id'] + 1;

                    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                          VALUES('" . $id . "','" . $packid . "','" . $proj_id . "','" . $senduserid . "','" . 19 . "',GETDATE(),'" . $planned_date . "','" . $actual . "','" . $actual . "','','0')";
                    $query = mssql_query($sql);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '19',
                          to_stage_id = '20',cs_userid='$senduserid',cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
                    $row2 = mssql_fetch_array($isql2);
                    $rsid = $row2['id'];

                    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
                        . "values('" . $rsid . "','" . $packid . "','" . $proj_id . "','19','20','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','',
                           '" . $actual . "','" . $senduserid . "','" . $actual . "','" . $planned_date . "')";
                    $insert3 = mssql_query($sql3);
                } else {

                    $sql1 = "UPDATE swift_transactions SET st_uid = '$senduserid',
                          st_sentdate = GETDATE(),st_planneddate='$planned_date',st_actual = '$actual',
                          st_expdate='$actual'  WHERE st_packid = '$packid' AND st_stageid = 19";
                    $query1 = mssql_query($sql1);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '19',
                          to_stage_id = '20',cs_userid='$senduserid',
                          cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $sql1 = "UPDATE swift_repository SET rs_userid='$senduserid',
                          rs_actual = '$actual',rs_expdate='$actual'  
                          WHERE rs_packid = '$packid' AND rs_to_stage = 19";
                    $query1 = mssql_query($sql1);
                }


                echo 2;
                exit();
            }
        } else {
            echo 5;
            exit();
        }
    } else {
        echo 5;
        exit();
    }
} else if ($cnum == '6') {
    $action = 'MDCC';
    if ($check > 0) {
        if ($iqty_bal > 0) {
            $iqty_bal = $row1['iqty_bal'];
            if ($qty > $iqty_bal) {
                echo 3;
                exit();
            } else {
                $sql = "UPDATE swift_poentrysave SET mdccqty ='" . ($mdccqty + $qty) . "',mdccqty_date = '" . $stage_date . "',iqty_bal = '" . ($iqty_bal - $qty) . "',
                mdccqty_bal = '" . ($mdccqty_bal + $qty) . "' WHERE sweid='" . $rid . "' AND swe_packid='" . $packid . "'";
                $query = mssql_query($sql);
                // update history
                $sql = "INSERT INTO swift_poentryhistory(swhid,swh_qte,swh_uid,actions,h_qty,e_date,disorder) 
                        VALUES('" . $rid . "','" . $packid . "','" . $uid . "','" . $action . "','" . $qty . "','" . $date . "','" . $cnum . "')";
                $query = mssql_query($sql);
                $upadate_all = mssql_query("update swift_packagestatus set active=0 where  ps_packid='" . $packid . "'");
                $upadate_31 = mssql_query("update swift_packagestatus set ps_userid='$senduserid',active=1,ps_expdate='" . $stage_date . "',ps_actualdate='" . $date . "' where  ps_packid='" . $packid . "' and ps_stageid=19");


                //insert to transaction table STAGE HISTORY

                $sql = "SELECT count(st_id) as rwcount FROM swift_transactions where st_packid='$packid' and st_stageid=18";
                $query = mssql_query($sql);
                $row = mssql_fetch_array($query);
                $rwcount = $row['rwcount'];

                if ($rwcount == 0) {

                    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
                    $query = mssql_query($sql);
                    $row = mssql_fetch_array($query);
                    $id = $row['id'] + 1;

                    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                          VALUES('" . $id . "','" . $packid . "','" . $proj_id . "','" . $senduserid . "','" . 18 . "',GETDATE(),'" . $planned_date . "','" . $actual . "','" . $actual . "','','0')";
                    $query = mssql_query($sql);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '18',
                          to_stage_id = '18',cs_userid='$senduserid',cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
                    $row2 = mssql_fetch_array($isql2);
                    $rsid = $row2['id'];

                    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
                        . "values('" . $rsid . "','" . $packid . "','" . $proj_id . "','18','19','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','',
                           '" . $actual . "','" . $senduserid . "','" . $actual . "','" . $planned_date . "')";
                    $insert3 = mssql_query($sql3);
                } else {

                    $sql1 = "UPDATE swift_transactions SET st_uid = '$senduserid',
                          st_sentdate = GETDATE(),st_planneddate='$planned_date',st_actual = '$actual',
                          st_expdate='$actual'  WHERE st_packid = '$packid' AND st_stageid = 18";
                    $query1 = mssql_query($sql1);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '18',
                          to_stage_id = '19',cs_userid='$senduserid',
                          cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $sql1 = "UPDATE swift_repository SET rs_userid='$senduserid',
                          rs_actual = '$actual',rs_expdate='$actual'  
                          WHERE rs_packid = '$packid' AND rs_to_stage = 18";
                    $query1 = mssql_query($sql1);
                }

                echo 2;
                exit();
            }
        } else {
            echo 5;
            exit();
        }
    } else {
        echo 5;
        exit();
    }
} else if ($cnum == '7') {
    $action = 'Mtl.Req@site';
    if ($check > 0) {
        if ($mdccqty_bal > 0) {
            $mdccqty_bal = $row1['mdccqty_bal'];
            if ($qty > $mdccqty_bal) {
                echo 3;
                exit();
            } else {
                $sql = "UPDATE swift_poentrysave SET mrqty ='" . ($mrqty + $qty) . "',mrqty_date = '" . $stage_date . "',mdccqty_bal = '" . ($mdccqty_bal - $qty) . "',
                mrqty_bal = '" . ($mrqty_bal + $qty) . "' WHERE sweid='" . $rid . "' AND swe_packid='" . $packid . "'";
                $query = mssql_query($sql);
                // update history
                $sql = "INSERT INTO swift_poentryhistory(swhid,swh_qte,swh_uid,actions,h_qty,e_date,disorder) 
                        VALUES('" . $rid . "','" . $packid . "','" . $uid . "','" . $action . "','" . $qty . "','" . $date . "','" . $cnum . "')";
                $query = mssql_query($sql);

                $upadate_all = mssql_query("update swift_packagestatus set active=0 where  ps_packid='" . $packid . "'");
                $upadate_33 = mssql_query("update swift_packagestatus set ps_userid='$senduserid',active=1,ps_expdate='" . $stage_date . "',ps_actualdate='" . $date . "' where  ps_packid='" . $packid . "' and ps_stageid=20");

                //insert to transaction table STAGE HISTORY

                $sql = "SELECT count(st_id) as rwcount FROM swift_transactions where st_packid='$packid' and st_stageid=19";
                $query = mssql_query($sql);
                $row = mssql_fetch_array($query);
                $rwcount = $row['rwcount'];
                //echo 'hi'.$rwcount;
                if ($rwcount == 0) {

                    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
                    $query = mssql_query($sql);
                    $row = mssql_fetch_array($query);
                    $id = $row['id'] + 1;

                    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                  VALUES('" . $id . "','" . $packid . "','" . $proj_id . "','" . $senduserid . "','" . 19 . "',GETDATE(),'" . $planned_date . "','" . $actual . "','" . $actual . "','','0')";
                    $query = mssql_query($sql);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '19',
                  to_stage_id = '20',cs_userid='$senduserid',cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
                    $row2 = mssql_fetch_array($isql2);
                    $rsid = $row2['id'];

                    $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
                        . "values('" . $rsid . "','" . $packid . "','" . $proj_id . "','19','20','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','',
                   '" . $actual . "','" . $senduserid . "','" . $actual . "','" . $planned_date . "')";
                    $insert3 = mssql_query($sql3);
                } else {

                    $sql1 = "UPDATE swift_transactions SET st_uid = '$senduserid',
                  st_sentdate = GETDATE(),st_planneddate='$planned_date',st_actual = '$actual',
                  st_expdate='$actual'  WHERE st_packid = '$packid' AND st_stageid = 19";
                    $query1 = mssql_query($sql1);

                    $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '19',
                  to_stage_id = '20',cs_userid='$senduserid',
                  cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
                    $query2 = mssql_query($sql2);

                    $sql1 = "UPDATE swift_repository SET rs_userid='$senduserid',
                  rs_actual = '$actual',rs_expdate='$actual'  
                  WHERE rs_packid = '$packid' AND rs_to_stage = 19";
                    $query1 = mssql_query($sql1);
                }



                echo 2;
                exit();
            }
        } else {
            echo 5;
            exit();
        }
    } else {
        echo 5;
        exit();
    }
} else if ($cnum == '8') {
    $action = 'Mrn';


    $sql = "UPDATE swift_poentrysave SET mrn_num ='" . $qty . "',mrn_date = '" . $stage_date . "' WHERE sweid='" . $rid . "' AND swe_packid='" . $packid . "'";
    $query = mssql_query($sql);
    // update history
    $sql = "INSERT INTO swift_poentryhistory(swhid,swh_qte,swh_uid,actions,h_qty,e_date,disorder) 
                        VALUES('" . $rid . "','" . $packid . "','" . $uid . "','" . $action . "','" . $qty . "','" . $date . "','" . $cnum . "')";
    $query = mssql_query($sql);

    $upadate_all = mssql_query("update swift_packagestatus set active=0 where  ps_packid='" . $packid . "'");
    $upadate_34 = mssql_query("update swift_packagestatus set ps_userid='$senduserid',active=1,ps_expdate='" . $stage_date . "',ps_actualdate='" . $date . "' where  ps_packid='" . $packid . "' and ps_stageid=20");


    //insert to transaction table STAGE HISTORY

    $sql = "SELECT count(st_id) as rwcount FROM swift_transactions where st_packid='$packid' and st_stageid=20";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $rwcount = $row['rwcount'];

    if ($rwcount == 0) {

        $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;

        $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                  VALUES('" . $id . "','" . $packid . "','" . $proj_id . "','" . $senduserid . "','" . 20 . "',GETDATE(),'" . $planned_date . "','" . $actual . "','" . $actual . "','','0')";
        $query = mssql_query($sql);

        $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '20',
                  to_stage_id = '20',cs_userid='$senduserid',cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
        $query2 = mssql_query($sql2);

        $isql2 = mssql_query("select isnull (max(rsid+1),1) as id from  swift_repository");
        $row2 = mssql_fetch_array($isql2);
        $rsid = $row2['id'];

        $sql3 = "insert into swift_repository (rsid,rs_packid,rs_projid,rs_from_stage,rs_to_stage,rs_from_uid,rs_to_uid,rs_active,rs_from_remark,rs_to_remark,rs_created_date,rs_userid,rs_actual,rs_expdate)"
            . "values('" . $rsid . "','" . $packid . "','" . $proj_id . "','20','20','" . $senduserid . "','" . $senduserid . "','0','" . mssql_escape1($from_remark) . "','',
                   '" . $actual . "','" . $senduserid . "','" . $actual . "','" . $planned_date . "')";
        $insert3 = mssql_query($sql3);
    } else {

        $sql1 = "UPDATE swift_transactions SET st_uid = '$senduserid',
                  st_sentdate = GETDATE(),st_planneddate='$planned_date',st_actual = '$actual',
                  st_expdate='$actual'  WHERE st_packid = '$packid' AND st_stageid = 20";
        $query1 = mssql_query($sql1);

        $sql2 = "UPDATE swift_workflow_CurrentStage SET from_stage_id = '20',
                  to_stage_id = '20',cs_userid='$senduserid',
                  cs_active=0 ,cs_created_date='$actual',cs_expdate='" . $planned_date . "',cs_actual='" . $actual . "' WHERE cs_packid = '$packid'";
        $query2 = mssql_query($sql2);

        $sql1 = "UPDATE swift_repository SET rs_userid='$senduserid',
                  rs_actual = '$actual',rs_expdate='$actual'  
                  WHERE rs_packid = '$packid' AND rs_to_stage = 20";
        $query1 = mssql_query($sql1);
    }



    echo 2;
    exit();
}
