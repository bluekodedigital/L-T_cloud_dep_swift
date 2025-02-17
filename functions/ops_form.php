<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST['sendtospoc'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $rsql = mssql_query("select uid from usermst where usertype=10");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['uid'];
    $isql = mssql_query("select isnull (max(ts_id+1),1) as id from  swift_techspoc");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    //$mtreq = formatDate(str_replace('/', '-', $mat_req_site), 'Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $sql = "insert into swift_techspoc ( ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ts_planneddate,ts_remarks,ts_status,ts_active)"
            . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','2','3','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";
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
            $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
            $update_status = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='1' where ps_stageid='2'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
            $send_email = $cls_comm->send_email($projectid, $packageid, '3', $rec_uid, $opstospocremarks);
            if ($update_status) {
                // header('Location: ../files_for_techspoc');
                echo "<script>window.location.href='../files_for_techspoc';</script>";
            }
        }
    }
}
if (isset($_REQUEST['sent_back_spoc'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $rsql = mssql_query("select uid from usermst where usertype=10");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['uid'];
    $isql = mssql_query("select isnull (max(ts_id+1),1) as id from  swift_techspoc");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $sql = mssql_query("select * from swift_techspoc where ts_packid='" . $packageid . "' and ts_projid='" . $projectid . "' and ts_recvuid='" . $rec_uid . "' and ts_active='1'");
//    echo "select * from swift_techspoc where ts_packid='" . $packageid . "' and ts_projid='" . $projectid . "' and ts_recvuid='" . $rec_uid . "' and ts_active='1'";
    $num_rows = mssql_num_rows($sql);
    if ($num_rows > 0) {
        $updatespoc = mssql_query("update swift_techspoc set ts_active='0'  where ts_packid='" . $packageid . "' and ts_projid='" . $projectid . "' and ts_recvuid='" . $rec_uid . "' and ts_active='1'");
        if ($updatespoc) {
            $sql = "insert into swift_techspoc ( ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ts_planneddate,ts_remarks,ts_status,ts_active)"
                    . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','7','3','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";
            $insert = mssql_query($sql);
            if ($insert) {
                $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                $trow = mssql_fetch_array($tsql);
                $tid = $trow['tid'];
                $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','7','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
                $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "' where ps_stageid='7'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                $update_status = mssql_query("update swift_packagestatus set active='1' ,ps_stback=1 ,ps_userid='" . $rec_uid . "' where ps_stageid='3'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                $updateCto_ops = mssql_query("update swift_CTOtoOPS set ctops_active=0 where ctops_packid='" . $packageid . "' and ctops_projid='" . $projectid . "'");
                $send_email = $cls_comm->send_email($projectid, $packageid, '3', $rec_uid, $opstospocremarks);
                if ($updateCto_ops) {
                    // header('Location: ../files_from_CTO');
                    echo "<script>window.location.href='../files_from_CTO';</script>";
                }
            }
        }
    }
}
if (isset($_REQUEST['sent_toom'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $rsql = mssql_query("select uid from usermst where usertype=15");

    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['uid'];
    $isql = mssql_query("select isnull (max(om_id+1),1) as id from  swift_OandM");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $sql = mssql_query("select * from swift_OandM where om_packid='" . $packageid . "' and om_projid='" . $projectid . "' and om_recvuid='" . $rec_uid . "' and om_active='1'");
    $num_rows = mssql_num_rows($sql);
    if ($num_rows > 0) {
        $updateoandm = mssql_query("update swift_OandM set om_active='0'  where om_packid='" . $packageid . "' and om_projid='" . $projectid . "' and om_recvuid='" . $rec_uid . "' and om_active='1'");
    }
    $sql = "insert into swift_OandM (om_id,om_packid,om_projid,om_senderuid,om_recvuid,om_sendr_stageid,om_recv_stageid,om_sentdate,om_planneddate,om_remarks,om_status,om_active)"
            . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','8','9','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";

    $insert = mssql_query($sql);
    if ($insert) {
        $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
        $trow = mssql_fetch_array($tsql);
        $tid = $trow['tid'];
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','8','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $rec_uid . "',ps_remarks='" . $opstospocremarks . "',active='0',ps_sbuid='" . $uid . "' where ps_stageid='8'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status8 = mssql_query("update swift_packagestatus set active='1',ps_stback=0 where ps_stageid='8'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $updateCto_ops = mssql_query("update swift_CTOtoOPS set ctops_status=1 where ctops_packid='" . $packageid . "' and ctops_projid='" . $projectid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '9', $rec_uid, $opstospocremarks, '8');
        if ($updateCto_ops) {
            // header('Location: ../files_from_CTO');
            echo "<script>window.location.href='../files_from_CTO';</script>";
        }
    }
}
if (isset($_REQUEST['sent_toscm'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
          if($_SESSION['milcom']=='1')
    {
      $cond=" and milcom_app='1'";  
    }else
    {
      $cond="";  
    }
    $rsql = mssql_query("select uid from usermst where usertype=14 $cond");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['uid'];
    
    
    $isql = mssql_query("select isnull (max(sc_id+1),1) as id from  swift_SCMSPOC");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $sql = mssql_query("select * from swift_SCMSPOC where sc_packid='" . $packageid . "' and sc_projid='" . $projectid . "' and sc_recvuid='" . $rec_uid . "' and sc_active='1'");
    $num_rows = mssql_num_rows($sql);
    if ($num_rows > 0) {
        $updatescmspoc = mssql_query("update swift_SCMSPOC set sc_active='0'  where sc_packid='" . $packageid . "' and sc_projid='" . $projectid . "' and sc_recvuid='" . $rec_uid . "' and sc_active='1'");
    }
    $sql = "insert into swift_SCMSPOC (sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_remarks,sc_status,sc_active)"
            . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','12','13','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";

    $insert = mssql_query($sql);
    if ($insert) {
        $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
        $trow = mssql_fetch_array($tsql);
        $tid = $trow['tid'];
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','12','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='0' where ps_stageid='12'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status8 = mssql_query("update swift_packagestatus set active='1',ps_userid='" . $rec_uid . "',ps_sbuid='" . $uid . "' where ps_stageid='12'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $updateCto_ops = mssql_query("update swift_CTOtoOPS set ctops_status=1 where ctops_packid='" . $packageid . "' and ctops_projid='" . $projectid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '13', $rec_uid, $opstospocremarks, '12');
        if ($updateCto_ops) {
            // header('Location: ../files_from_CTO');
            echo "<script>window.location.href='../files_from_CTO';</script>";
        }
    }
}
if (isset($_REQUEST['sent_back_spocom'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $rsql = mssql_query("select uid from usermst where usertype=10");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['uid'];
    $isql = mssql_query("select isnull (max(ts_id+1),1) as id from  swift_techspoc");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $sql = mssql_query("select * from swift_techspoc where ts_packid='" . $packageid . "' and ts_projid='" . $projectid . "' and ts_recvuid='" . $rec_uid . "' and ts_active='1'");
    // echo "select * from swift_techspoc where ts_packid='" . $packageid . "' and ts_projid='" . $projectid . "' and ts_recvuid='" . $rec_uid . "' and ts_active='1'";
    $num_rows = mssql_num_rows($sql);
    if ($num_rows > 0) {
        $updatespoc = mssql_query("update swift_techspoc set ts_active='0'  where ts_packid='" . $packageid . "' and ts_projid='" . $projectid . "' and ts_recvuid='" . $rec_uid . "' and ts_active='1'");
        if ($updatespoc) {
            $sql = "insert into swift_techspoc ( ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ts_planneddate,ts_remarks,ts_status,ts_active)"
                    . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','10','3','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";
            $insert = mssql_query($sql);
            if ($insert) {
                $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                $trow = mssql_fetch_array($tsql);
                $tid = $trow['tid'];
                $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','10','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
                $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                $update_status10 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "' where ps_stageid='10'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                $update_status = mssql_query("update swift_packagestatus set active='1',ps_stback=1,ps_userid='" . $uid . "' where ps_stageid='3'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                $updateCto_ops = mssql_query("update swift_OMtoOPs set omop_status=1  where omop_packid='" . $packageid . "' and omop_projid='" . $projectid . "'");
                $send_email = $cls_comm->send_email($projectid, $packageid, '3', $rec_uid, $opstospocremarks);
                if ($updateCto_ops) {
                    // header('Location: ../files_from_OM');
                    echo "<script>window.location.href='../files_from_OM';</script>";
                }
            }
        }
    }
}
if (isset($_REQUEST['sent_toscmom'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
      if($_SESSION['milcom']=='1')
    {
      $cond=" and milcom_app='1'";  
    }else
    {
      $cond="";  
    }
    $rsql = mssql_query("select uid from usermst where usertype=14 $cond");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['uid'];
    
    $isql = mssql_query("select isnull (max(sc_id+1),1) as id from  swift_SCMSPOC");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $sql = mssql_query("select * from swift_SCMSPOC where sc_packid='" . $packageid . "' and sc_projid='" . $projectid . "' and sc_recvuid='" . $rec_uid . "' and sc_active='1'");
    $num_rows = mssql_num_rows($sql);
    if ($num_rows > 0) {
        $updatescmspoc = mssql_query("update swift_SCMSPOC set sc_active='0'  where sc_packid='" . $packageid . "' and sc_projid='" . $projectid . "' and sc_recvuid='" . $rec_uid . "' and sc_active='1'");
    }
    $sql = "insert into swift_SCMSPOC (sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_remarks,sc_status,sc_active)"
            . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','12','13','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";

    $insert = mssql_query($sql);
    if ($insert) {
        $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
        $trow = mssql_fetch_array($tsql);
        $tid = $trow['tid'];
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','12','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='0' where ps_stageid='12'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status8 = mssql_query("update swift_packagestatus set active='1',ps_userid='" . $rec_uid . "',ps_sbuid='" . $uid . "' where ps_stageid='12'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $updateCto_ops = mssql_query("update swift_OMtoOPs set omop_status=1 where omop_packid='" . $packageid . "' and omop_projid='" . $projectid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '13', $rec_uid, $opstospocremarks, '12');
        if ($updateCto_ops) {
            // header('Location: ../files_from_OM');
            echo "<script>window.location.href='../files_from_OM';</script>";
        }
    }
}
if (isset($_REQUEST['sent_toomom'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $rsql = mssql_query("select uid from usermst where usertype=15");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['uid'];
    $isql = mssql_query("select isnull (max(om_id+1),1) as id from  swift_OandM");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $sql = mssql_query("select * from swift_OandM where om_packid='" . $packageid . "' and om_projid='" . $projectid . "' and om_recvuid='" . $rec_uid . "' and om_active='1'");
//        echo  "select * from swift_OandM where om_packid='" . $packageid . "' and om_projid='" . $projectid . "' and om_recvuid='" . $rec_uid . "' and om_active='1'";
    $num_rows = mssql_num_rows($sql);
    if ($num_rows > 0) {
        $updateoandm = mssql_query("update swift_OandM set om_active='0'  where om_packid='" . $packageid . "' and om_projid='" . $projectid . "' and om_recvuid='" . $rec_uid . "' and om_active='1'");
    }
    $sql = "insert into swift_OandM (om_id,om_packid,om_projid,om_senderuid,om_recvuid,om_sendr_stageid,om_recv_stageid,om_sentdate,om_planneddate,om_remarks,om_status,om_active)"
            . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','8','9','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";

    $insert = mssql_query($sql);
    if ($insert) {
        $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
        $trow = mssql_fetch_array($tsql);
        $tid = $trow['tid'];
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','8','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='0' where ps_stageid='8'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status8 = mssql_query("update swift_packagestatus set active='1',ps_userid='" . $rec_uid . "',ps_sbuid='" . $uid . "' where ps_stageid='8'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $updateCto_ops = mssql_query("update swift_OMtoOPs set omop_status=1 where omop_packid='" . $packageid . "' and omop_projid='" . $projectid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '9', $rec_uid, $opstospocremarks, '8');
        if ($updateCto_ops) {
            // header('Location: ../files_from_OM');
            echo "<script>window.location.href='../files_from_OM';</script>";
        }
    }
}
if (isset($_REQUEST['sent_to_back_ops'])) {
    extract($_REQUEST);
    
   // $uid = $_SESSION['uid'];
    $uid = $user_id;
    $isql = mssql_query("select isnull (max(om_id+1),1) as id from  swift_OandM");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $rsql = mssql_query("select * from swift_OandM where om_packid='" . $packageid . "' and om_projid='" . $projectid . "' and om_active='1'");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['om_senderuid'];

    $sql = mssql_query("select * from swift_OMtoOPs where omop_packid='" . $packageid . "' and omop_projid='" . $projectid . "' and omop_recvuid='" . $rec_uid . "' and omop_active='1'");
    $num_rows = mssql_num_rows($sql);
    if ($num_rows > 0) {
        $updatescmspoc = mssql_query("update swift_OMtoOPs set omop_active='0'  where omop_packid='" . $packageid . "' and omop_projid='" . $projectid . "' and omop_recvuid='" . $rec_uid . "' and omop_active='1'");
    }

    $sql = "insert into swift_OMtoOPs (omop_id,omop_packid,omop_projid,omop_senderuid,omop_recvuid,omop_sendr_stageid,omop_recv_stageid,omop_sentdate,omop_planneddate,omop_remarks,omop_status,omop_active)"
            . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','9','12','" . $sentdate . "','','" . mssql_escape1($opstospocremarks) . "','0','1')";

    $insert = mssql_query($sql);
    if ($insert) {
        $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
        $trow = mssql_fetch_array($tsql);
        $tid = $trow['tid'];
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','9','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . mssql_escape1($opstospocremarks) . "','0')");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $rec_uid . "',ps_remarks='" . mssql_escape1($opstospocremarks) . "',active='0',ps_sbuid='" . $uid . "' where ps_stageid='9'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status8 = mssql_query("update swift_packagestatus set active='1' where ps_stageid='9'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $updateCto_ops = mssql_query("update swift_OandM set om_status=1 where om_packid='" . $packageid . "' and om_projid='" . $projectid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '12', $rec_uid, $opstospocremarks, '9');
        if ($updateCto_ops) {
            // header('Location: ../om_workflow');
            echo "<script>window.location.href='../om_workflow';</script>";
        } else {
            echo "<script>window.location.href='../om_workflow?msg=0';</script>";
        }
    } else {
        echo "<script>window.location.href='../om_workflow?msg=0';</script>";
    }
}
if (isset($_REQUEST['sent_back_spoc_scm'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    if($_SESSION['milcom']=='1')
    {
      $cond=" and milcom_app='1'";  
    }else
    {
      $cond="";  
    }
    $rsql = mssql_query("select uid from usermst where usertype=10 $cond");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['uid'];
    $isql = mssql_query("select isnull (max(ts_id+1),1) as id from  swift_techspoc");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $sql = mssql_query("select * from swift_techspoc where ts_packid='" . $packageid . "' and ts_projid='" . $projectid . "' and ts_recvuid='" . $rec_uid . "' and ts_active='1'");
    // echo "select * from swift_techspoc where ts_packid='" . $packageid . "' and ts_projid='" . $projectid . "' and ts_recvuid='" . $rec_uid . "' and ts_active='1'";
    $num_rows = mssql_num_rows($sql);
    if ($num_rows > 0) {
        $updatespoc = mssql_query("update swift_techspoc set ts_active='0'  where ts_packid='" . $packageid . "' and ts_projid='" . $projectid . "' and ts_recvuid='" . $rec_uid . "' and ts_active='1'");
        if ($updatespoc) {
            $sql = "insert into swift_techspoc ( ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ts_planneddate,ts_remarks,ts_status,ts_active)"
                    . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','7','3','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";
            $insert = mssql_query($sql);
            if ($insert) {
                $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
                $trow = mssql_fetch_array($tsql);
                $tid = $trow['tid'];
                $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','7','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
                $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0  where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                $update_status10 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "' where ps_stageid='7'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                $update_status = mssql_query("update swift_packagestatus set active='1',ps_stback=1,ps_userid='" . $rec_uid . "' where ps_stageid='3'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
                $updateCto_ops = mssql_query("update swift_SCMtoOPS set scop_status=1  where scop_packid='" . $packageid . "' and scop_projid='" . $projectid . "'");
                $send_email = $cls_comm->send_email($projectid, $packageid, '3', $rec_uid, $opstospocremarks);
                if ($updateCto_ops) {
                    // header('Location: ../files_from_SCM');
                    echo "<script>window.location.href='../files_from_SCM';</script>";
                }
            }
        }
    }
}
if (isset($_REQUEST['sent_toscm_scm'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
      if($_SESSION['milcom']=='1')
    {
      $cond=" and milcom_app='1'";  
    }else
    {
      $cond="";  
    }
    $rsql = mssql_query("select uid from usermst where usertype=14 $cond");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['uid'];
    $isql = mssql_query("select isnull (max(sc_id+1),1) as id from  swift_SCMSPOC");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $sql = mssql_query("select * from swift_SCMSPOC where sc_packid='" . $packageid . "' and sc_projid='" . $projectid . "' and sc_recvuid='" . $rec_uid . "' and sc_active='1'");
    $num_rows = mssql_num_rows($sql);
    if ($num_rows > 0) {
        $updatescmspoc = mssql_query("update swift_SCMSPOC set sc_active='0'  where sc_packid='" . $packageid . "' and sc_projid='" . $projectid . "' and sc_recvuid='" . $rec_uid . "' and sc_active='1'");
    }
    $sql = "insert into swift_SCMSPOC (sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_remarks,sc_status,sc_active)"
            . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','12','13','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";

    $insert = mssql_query($sql);
    if ($insert) {
        $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
        $trow = mssql_fetch_array($tsql);
        $tid = $trow['tid'];
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','12','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0  where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='0' where ps_stageid='12'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status8 = mssql_query("update swift_packagestatus set active='1',ps_userid='" . $rec_uid . "',ps_sbuid='" . $uid . "' where ps_stageid='12'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $updateCto_ops = mssql_query("update swift_SCMtoOPS set scop_status=1 where scop_packid='" . $packageid . "' and scop_projid='" . $projectid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '13', $rec_uid, $opstospocremarks, '12');
        if ($updateCto_ops) {
            // header('Location: ../files_from_SCM');
            echo "<script>window.location.href='../files_from_SCM';</script>";
        }
    }
}
if (isset($_REQUEST['sent_toom_scm'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $rsql = mssql_query("select uid from usermst where usertype=15");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['uid'];
    $isql = mssql_query("select isnull (max(om_id+1),1) as id from  swift_OandM");
    $row = mssql_fetch_array($isql);
    $id = $row['id'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $sql = mssql_query("select * from swift_OandM where om_packid='" . $packageid . "' and om_projid='" . $projectid . "' and om_recvuid='" . $rec_uid . "' and om_active='1'");
//        echo  "select * from swift_OandM where om_packid='" . $packageid . "' and om_projid='" . $projectid . "' and om_recvuid='" . $rec_uid . "' and om_active='1'";
    $num_rows = mssql_num_rows($sql);
    if ($num_rows > 0) {
        $updateoandm = mssql_query("update swift_OandM set om_active='0'  where om_packid='" . $packageid . "' and om_projid='" . $projectid . "' and om_recvuid='" . $rec_uid . "' and om_active='1'");
    }
    $sql = "insert into swift_OandM (om_id,om_packid,om_projid,om_senderuid,om_recvuid,om_sendr_stageid,om_recv_stageid,om_sentdate,om_planneddate,om_remarks,om_status,om_active)"
            . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','8','9','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";

    $insert = mssql_query($sql);
    if ($insert) {
        $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
        $trow = mssql_fetch_array($tsql);
        $tid = $trow['tid'];
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','8','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0  where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='0' where ps_stageid='8'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status8 = mssql_query("update swift_packagestatus set active='1' ,ps_stback=1,ps_userid='" . $uid . "',ps_sbuid='" . $rec_uid . "' where ps_stageid='9'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $updateCto_ops = mssql_query("update swift_SCMtoOPS set scop_status=1 where scop_packid='" . $packageid . "' and scop_projid='" . $projectid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '9', $rec_uid, $opstospocremarks, '8');
        if ($updateCto_ops) {
            // header('Location: ../files_from_SCM');
            echo "<script>window.location.href='../files_from_SCM';</script>";
        }
    }
}
if (isset($_REQUEST['sent_to_buyer'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
    $trow = mssql_fetch_array($tsql);
    $tid = $trow['tid'];
    $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','19','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
    $update = mssql_query("update swift_filesfrom_smartsignoff set so_status=3,po_wo_status=0,emr_date='" . $sentdate . "',emr_number='" . $emr_no . "' where so_proj_id='" . $projectid . "' and so_pack_id='" . $packageid . "' ");
    $update_status19 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='0' where ps_stageid='19'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0  where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    $update_status = mssql_query("update swift_packagestatus set active='1' ,ps_userid='" . $uid . "'where ps_stageid='20'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");

    if ($update_status) {
        // header('Location: ../files_from_Smartsign');
        echo "<script>window.location.href='../files_from_Smartsign';</script>";
    }
}
if (isset($_REQUEST['sent_to_tech_expert'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
    $trow = mssql_fetch_array($tsql);
    $tid = $trow['tid'];

    $asql = mssql_query("select isnull (max(tech_id+1),1) as aid from  swift_techapproval");
    $arow = mssql_fetch_array($asql);
    $aid = $arow['aid'];

    if ($flag == 0) {
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','25','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $sql = "insert into swift_techapproval ( tech_id,tech_packid,tech_projid,tech_senderuid,tech_recvuid,tech_sendr_stageid,tech_recv_stageid,tech_sentdate,tech_planneddate,tech_remarks,tech_status,tech_active)"
                . "values('" . $aid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $uid . "','25','26','" . $sentdate . "','','" . $opstospocremarks . "','1','1')";
        $insert = mssql_query($sql);

        $update = mssql_query("update swift_techapproval set tech_status='',tech_active=0,tech_senderuid='" . $uid . "',tech_recvuid='" . $uid . "',tech_sendr_stageid='25',tech_recv_stageid='26',tech_remarks='" . $opstospocremarks . "' where tech_projid='" . $projectid . "' and tech_packid='" . $packageid . "' and tech_status=0 and tech_active=1 ");
        $update_status25 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='0' where ps_stageid='25'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status = mssql_query("update swift_packagestatus set active='1',ps_userid='" . $uid . "' where ps_stageid='26'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '26', $uid, $opstospocremarks, '25');
        if ($update_status) {
            // header('Location: ../files_for_techapproval');
            echo "<script>window.location.href='../files_for_techapproval';</script>";
        }
    } else if ($flag == 1) {
        $rsql = mssql_query("select txp_recvuid from swift_techexpert where txp_packid='" . $packageid . "' and txp_projid='" . $projectid . "' and txp_status='1' and txp_active='1'");
        $r = mssql_fetch_array($rsql);
//       $rec_uid = $r['txp_recvuid'];

        $rec_uid = $_POST['expert_id'];


        $sql = "insert into swift_techapproval ( tech_id,tech_packid,tech_projid,tech_senderuid,tech_recvuid,tech_sendr_stageid,tech_recv_stageid,tech_sentdate,tech_planneddate,tech_remarks,tech_status,tech_active)"
                . "values('" . $aid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','26','27','" . $sentdate . "','','" . $opstospocremarks . "','2','1')";
        $insert = mssql_query($sql);



        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','26','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update = mssql_query("update swift_techapproval set tech_status='',tech_active=0,tech_senderuid='" . $uid . "',tech_recvuid='" . $rec_uid . "',tech_sendr_stageid='26',tech_recv_stageid='27',tech_remarks='" . $opstospocremarks . "' where tech_projid='" . $projectid . "' and tech_packid='" . $packageid . "' and tech_status=1 and tech_active=1 ");
        $update_status25 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='0' where ps_stageid='25'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status26 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $rec_uid . "',ps_sbuid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='0' where ps_stageid='26'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status = mssql_query("update swift_packagestatus set active='1' where ps_stageid='26'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '27', $rec_uid, $opstospocremarks, '26');
        if ($update_status) {
            // header('Location: ../files_for_techapproval');
            echo "<script>window.location.href='../files_for_techapproval_poc';</script>";
        }
    } else if ($flag == 3) {
        $sql = "insert into swift_techapproval ( tech_id,tech_packid,tech_projid,tech_senderuid,tech_recvuid,tech_sendr_stageid,tech_recv_stageid,tech_sentdate,tech_planneddate,tech_remarks,tech_status,tech_active)"
                . "values('" . $aid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $uid . "','28','29','" . $sentdate . "','','" . $opstospocremarks . "','4','1')";
        $insert = mssql_query($sql);


        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','28','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update = mssql_query("update swift_techapproval set tech_status='',tech_active=0,tech_senderuid='" . $uid . "',tech_recvuid='" . $uid . "',tech_sendr_stageid='28',tech_recv_stageid='29',tech_remarks='" . $opstospocremarks . "' where tech_projid='" . $projectid . "' and tech_packid='" . $packageid . "' and tech_status=3 and tech_active=1 ");
        $update_status28 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_sbuid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',active='0' where ps_stageid='28'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status = mssql_query("update swift_packagestatus set active='1' where ps_stageid='28'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");

        $send_email = $cls_comm->send_email($projectid, $packageid, '29', $uid, $opstospocremarks, '28');

        if ($update_status) {
            // header('Location: ../files_for_techapproval');
            echo "<script>window.location.href='../files_for_techapproval';</script>";
        }
    }
}
if (isset($_REQUEST['update_loi'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');
    $so_status = 0;
    if ($po_wo == 2) {
        $po_status = 0;
        $woorder = '';
        $emr_app = 3;
    } else if ($po_wo == 3) {
        $po_status = 2;
        $woorder = 0;
        $emr_app = 3;
    } else if ($po_wo == 1) {
        $po_status = '';
        $woorder = 0;
        $emr_app = 1;
    }
    
    $buyer_sql = mssql_query("SELECT * FROM swift_SCMtoBUYER where bu_packid='" . $pack_id . "' and bu_status=1");
    $brow = mssql_fetch_array($buyer_sql);
    $id_buyer = $brow['bu_buyer_id'];
    
    
    if ($hpc_app == 1) {
        $smartini_date = formatDate(str_replace('/', '-', $smartini_date), 'Y-m-d');
        $smartapp_date = formatDate(str_replace('/', '-', $smartapp_date), 'Y-m-d');
        $update_ss = mssql_query("update swift_filesfrom_smartsignoff set so_hw_sw ='" . $po_wo . "',so_commercial_close_date ='" . $smartapp_date . "',so_package_sentdate ='" . $smartini_date . "',so_package_approved_date ='" . $smartapp_date . "',so_status ='" . $so_status . "',po_wo_status ='" . $po_status . "',work_order ='" . $woorder . "' where so_proj_id='" . $projectid . "' and so_pack_id='" . $packageid . "'");
        $ins_swift = mssql_query("insert into swift_filesfrom_smartsignoff (so_id,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,po_wo_status,work_order,hpc_app) values ('" . $id . "','" . $proj_id . "','" . $pack_id . "','" . $po_wo . "','" . $pack_sentdate . "','" . $pack_sentdate . "','" . $smartapp_date . "','" . $so_status . "','" . $po_status . "','" . $woorder . "',1)");
        $update_status15 = mssql_query("update swift_packagestatus set ps_expdate='" . $smartini_date . "',ps_actualdate='" . $smartini_date . "',ps_remarks='From smart Signoff',active='0' where ps_stageid='15'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status16 = mssql_query("update swift_packagestatus set ps_expdate='" . $smartini_date . "',ps_actualdate='" . $smartini_date . "',ps_userid='" . $uid . "',ps_remarks='From smart Signoff',active='0' where ps_stageid='16'  and ps_projid='" . $proj_id . "' and ps_packid='" . $pack_id . "'");
        $update_status17 = mssql_query("update swift_packagestatus set ps_expdate='" . $smartini_date . "',ps_actualdate='" . $smartini_date . "',ps_remarks='From smart Signoff',active='0',ps_sbuid='" . $uid . "',ps_userid='" . $id_buyer . "' where ps_stageid='17'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");

        //    $update_status15 = mssql_query("update swift_packagestatus set ps_expdate='" . $today . "',ps_actualdate='" . $today . "',ps_userid='" . $uid . "',ps_remarks='From smart Signoff',active='0' where ps_stageid='15'  and ps_projid='" . $proj_id . "' and ps_packid='" . $pack_id . "'");
////        $update_status16 = mssql_query("update swift_packagestatus set ps_expdate='" . $today . "',ps_actualdate='" . $today . "',ps_userid='" . $uid . "',ps_remarks='From smart Signoff',active='0' where ps_stageid='16'  and ps_projid='" . $proj_id . "' and ps_packid='" . $pack_id . "'");
//    $update_status17 = mssql_query("update swift_packagestatus set ps_expdate='" . $today . "',ps_actualdate='" . $today . "',ps_userid='" . $recvid . "',ps_remarks='From smart Signoff',active='0',ps_sbuid='" . $uid . "' where ps_stageid='17'  and ps_projid='" . $proj_id . "' and ps_packid='" . $pack_id . "'");
//    $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $proj_id . "' and ps_packid='" . $pack_id . "'");
//    $update_status = mssql_query("update swift_packagestatus set active='1' where ps_stageid='17'  and ps_projid='" . $proj_id . "' and ps_packid='" . $pack_id . "'");
    } else {
        $update_ss = mssql_query("update swift_filesfrom_smartsignoff set so_hw_sw ='" . $po_wo . "' ,so_status ='" . $so_status . "',po_wo_status ='" . $po_status . "',work_order ='" . $woorder . "' where so_proj_id='" . $projectid . "' and so_pack_id='" . $packageid . "'");
    }


    $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
    $trow = mssql_fetch_array($tsql);
    $tid = $trow['tid'];
    $sql = " SELECT * FROM swift_packagemaster where pm_packid='$packageid'";
    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $recvid = $row['pm_userid'];
    }

    $update_emr_status = mssql_query("update [dbo].[swift_packagemaster] set emr_status='" . $emr_app . "' where pm_packid='" . $packageid . "'");
    $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','18','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $actual_date . "','" . $opstospocremarks . "','0')");
    $update = mssql_query("update swift_filesfrom_smartsignoff set so_status=1,so_loi_date='" . $actual_date . "', loi_number='" . $loi_number . "' where so_proj_id='" . $projectid . "' and so_pack_id='" . $packageid . "' ");
    $update_status18 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $actual_date . "',ps_userid='" . $recvid . "',ps_sbuid='" . $uid . "',ps_remarks='LOI Generated',active='0' where ps_stageid='18'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    $update_status = mssql_query("update swift_packagestatus set active='1' where ps_stageid='18'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    $send_email = $cls_comm->send_email($projectid, $packageid, '19', $recvid, $opstospocremarks, '18');
//    $send_email = $cls_comm->send_email($projectid, $packageid, '20', $uid, $opstospocremarks);
    if ($update_status) {
        // header('Location: ../loi_update');
        echo "<script>window.location.href='../loi_update';</script>";
    }
}
if (isset($_REQUEST['create_emr'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');

    $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
    $trow = mssql_fetch_array($tsql);
    $tid = $trow['tid'];

    $buyer_sql = mssql_query("SELECT * FROM swift_SCMtoBUYER where bu_packid='" . $packageid . "' and bu_status=1");
    $brow = mssql_fetch_array($buyer_sql);
    $count = mssql_num_rows($buyer_sql);
    $recvid = $brow['bu_buyer_id'];


    $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','19','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $actual_date . "','" . $opstospocremarks . "','0')");
    $update_allstatus = mssql_query("update swift_packagestatus set active='0' where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    if ($count > 0) {
        $update_status19 = mssql_query("update swift_packagestatus set ps_expdate='" . $sentdate . "',ps_actualdate='" . $actual_date . "',ps_userid='" . $recvid . "',ps_sbuid='" . $uid . "',ps_remarks='EMR Generated',active='0' where ps_stageid='19'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status20 = mssql_query("update swift_packagestatus set active='1' where ps_stageid='19'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    } else {
        $update_status19 = mssql_query("update swift_packagestatus set ps_expdate='" . $sentdate . "',ps_actualdate='" . $actual_date . "',ps_userid='" . $uid . "',ps_remarks='EMR Generated',active='0' where ps_stageid='19'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
    }

    //$update_status19 = mssql_query("update swift_packagestatus set ps_expdate='" . $sentdate . "',ps_actualdate='" . $actual_date . "',ps_userid='" . $uid . "',ps_remarks='EMR Generated',active='0' where ps_stageid='19'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");


    $sql = mssql_query("select isnull (max(emr_id+1),1) as id from swift_emrcreation");
    $row = mssql_fetch_array($sql);
    $id = $row['id'];

    $insert = mssql_query("insert into swift_emrcreation(emr_id,emr_packid,emr_projid,emr_uid,emr_createddate,emr_remarks,emr_number)"
            . "values('" . $id . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $actual_date . "','" . $opstospocremarks . "','" . $emr_no . "')");

    $update = mssql_query("update swift_packagemaster set emr_status=1 where pm_packid='" . $packageid . "' and pm_projid='" . $projectid . "'");
    if ($count > 0) {
        $send_email = $cls_comm->send_email($projectid, $packageid, '20', $recvid, $opstospocremarks, '19');
    }

    if ($insert) {
        // header('Location: ../loi_update');
        echo "<script>window.location.href='../files_from_Smartsign';</script>";
    }
}

if (isset($_REQUEST['sent_back_toexpert'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];

    $rsql = mssql_query("SELECT * FROM swift_techexpert WHERE txp_projid='$projectid' AND txp_packid='$packageid' and txp_active=1");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['txp_recvuid'];



    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');

    // insert to expert table
    $sql = "SELECT MAX(txp_id) as id FROM swift_techexpert;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $txpid = $row['id'] + 1;
    $sql = "SELECT * FROM swift_techexpert WHERE txp_projid='$projectid' AND txp_packid='$packageid'";
    $query = mssql_query($sql);
    $row1 = mssql_fetch_array($query);
    if ($row1 > 0) {
        $sql = "UPDATE swift_techexpert SET txp_active='0' WHERE txp_projid='$projectid' AND txp_packid='$packageid'";
        $query = mssql_query($sql);
    }
    $sql = "INSERT INTO swift_techexpert(txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,txp_planneddate,txp_remarks,txp_status,txp_active) 
                VALUES('" . $txpid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','7','5','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";
    $query = mssql_query($sql);
    if ($query) {

        $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
        $trow = mssql_fetch_array($tsql);
        $tid = $trow['tid'];
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','7','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status7 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "' where ps_stageid='7'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status = mssql_query("update swift_packagestatus set active='1',ps_stback=1 ,ps_userid='" . $uid . "',ps_sbuid='" . $rec_uid . "' where ps_stageid='5'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $updateCto_ops = mssql_query("update swift_CTOtoOPS set ctops_active=0 where ctops_packid='" . $packageid . "' and ctops_projid='" . $projectid . "'");
        $send_email = $cls_comm->sendback_email($projectid, $packageid, '5', $rec_uid, $opstospocremarks, '8');
        if ($updateCto_ops) {
            // header('Location: ../files_from_CTO');
            echo "<script>window.location.href='../files_from_CTO';</script>";
        }
    }
}


if (isset($_REQUEST['sent_back_expertom'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];

    $rsql = mssql_query("SELECT * FROM swift_techexpert WHERE txp_projid='$projectid' AND txp_packid='$packageid' and txp_active=1");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['txp_recvuid'];



    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');

    // insert to expert table
    $sql = "SELECT MAX(txp_id) as id FROM swift_techexpert;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $txpid = $row['id'] + 1;
    $sql = "SELECT * FROM swift_techexpert WHERE txp_projid='$projectid' AND txp_packid='$packageid'";
    $query = mssql_query($sql);
    $row1 = mssql_fetch_array($query);
    if ($row1 > 0) {
        $sql = "UPDATE swift_techexpert SET txp_active='0' WHERE txp_projid='$projectid' AND txp_packid='$packageid'";
        $query = mssql_query($sql);
    }
    $sql = "INSERT INTO swift_techexpert(txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,txp_planneddate,txp_remarks,txp_status,txp_active) 
                VALUES('" . $txpid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','10','5','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";
    $query = mssql_query($sql);
    if ($query) {

        $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
        $trow = mssql_fetch_array($tsql);
        $tid = $trow['tid'];
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','10','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status10 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "' where ps_stageid='10'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status = mssql_query("update swift_packagestatus set active='1',ps_stback=1,ps_userid='" . $uid . "',ps_sbuid='" . $rec_uid . "' where ps_stageid='5'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $updateCto_ops = mssql_query("update swift_OMtoOPs set omop_status=1  where omop_packid='" . $packageid . "' and omop_projid='" . $projectid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '5', $rec_uid, $opstospocremarks, '12');

        if ($updateCto_ops) {
            // header('Location: ../files_from_OM');
            echo "<script>window.location.href='../files_from_OM';</script>";
        }
    }
}

if (isset($_REQUEST['sent_back_expert_scm'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];

    $rsql = mssql_query("SELECT * FROM swift_techexpert WHERE txp_projid='$projectid' AND txp_packid='$packageid' and txp_active=1");
    $r = mssql_fetch_array($rsql);
    $rec_uid = $r['txp_recvuid'];



    $sentdate = date('Y-m-d');
    $planneddate = formatDate(str_replace('/', '-', $planneddate), 'Y-m-d');
    $expected_date = formatDate(str_replace('/', '-', $expected_date), 'Y-m-d');
    $actual_date = formatDate(str_replace('/', '-', $actual_date), 'Y-m-d');

    // insert to expert table
    $sql = "SELECT MAX(txp_id) as id FROM swift_techexpert;";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $txpid = $row['id'] + 1;
    $sql = "SELECT * FROM swift_techexpert WHERE txp_projid='$projectid' AND txp_packid='$packageid'";
    $query = mssql_query($sql);
    $row1 = mssql_fetch_array($query);
    if ($row1 > 0) {
        $sql = "UPDATE swift_techexpert SET txp_active='0' WHERE txp_projid='$projectid' AND txp_packid='$packageid'";
        $query = mssql_query($sql);
    }
    $sql = "INSERT INTO swift_techexpert(txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,txp_planneddate,txp_remarks,txp_status,txp_active) 
                VALUES('" . $txpid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','" . $rec_uid . "','7','5','" . $sentdate . "','','" . $opstospocremarks . "','0','1')";
    $query = mssql_query($sql);
    if ($query) {

        $tsql = mssql_query("select isnull (max(st_id+1),1) as tid from  swift_transactions");
        $trow = mssql_fetch_array($tsql);
        $tid = $trow['tid'];
        $insert_trans = mssql_query("insert into swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
                values('" . $tid . "','" . $packageid . "','" . $projectid . "','" . $uid . "','7','" . $sentdate . "','" . $planneddate . "','" . $expected_date . "','" . $sentdate . "','" . $opstospocremarks . "','0')");
        $update_allstatus = mssql_query("update swift_packagestatus set active='0',ps_stback=0 where  ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status10 = mssql_query("update swift_packagestatus set ps_expdate='" . $expected_date . "',ps_actualdate='" . $sentdate . "',ps_userid='" . $uid . "',ps_remarks='" . $opstospocremarks . "',ps_stback=1 where ps_stageid='7'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $update_status = mssql_query("update swift_packagestatus set active='1',ps_userid='" . $uid . "',ps_sbuid='" . $rec_uid . "',ps_stback=1 where ps_stageid='5'  and ps_projid='" . $projectid . "' and ps_packid='" . $packageid . "'");
        $updateCto_ops = mssql_query("update swift_SCMtoOPS set scop_status=1  where scop_packid='" . $packageid . "' and scop_projid='" . $projectid . "'");
        $send_email = $cls_comm->send_email($projectid, $packageid, '5', $rec_uid, $opstospocremarks, '12');
        if ($updateCto_ops) {
            // header('Location: ../files_from_SCM');
            echo "<script>window.location.href='../files_from_SCM';</script>";
        }
    }
}
?>