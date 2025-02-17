<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");

if (isset($_POST['reject'])) {
    $tech_id = $_POST['tech_id'];
    $expdate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');
//        $actdate = formatDate(str_replace('/', '-', $_POST['act_date']), 'Y-m-d h:i:s');
    $remarks = $_POST['remarks'];
    $senduserid = $_SESSION['uid'];
    $actdate = date('Y-m-d');
    $sql = "SELECT * FROM swift_techapproval WHERE tech_id='" . $tech_id . "'";
    $query = mssql_query($sql);
    $result = array();
    while ($row = mssql_fetch_array($query)) {
        $projid = $row['tech_projid'];
        $packid = $row['tech_packid'];
    }
    $sql = " SELECT * FROM swift_packagemaster where pm_packid='$packid'";

    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $recvid = $row['pm_userid'];
    }
    // UPDATE FLAG
    $sql = "UPDATE swift_techapproval SET tech_status = '1',tech_active='1' WHERE tech_id='$tech_id'";
    $query = mssql_query($sql);

    $sendstageid = 27;
    // $recvstageid=27;
    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',ps_userid='$recvid',ps_sbuid='" . $senduserid . "',ps_remarks='$remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$packid' AND ps_stageid = '$sendstageid' AND ps_projid='$projid'";
    $query = mssql_query($sql);

    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$packid' and ps_stageid = '$sendstageid'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    // $planned_date = $row['planned_date'];
    $planneddate = formatDate(str_replace('/', '-', $row['planned_date']), 'Y-m-d h:i:s');

    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $id = $row['id'] + 1;

    // insert to transaction table
    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
            VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $sendstageid . "',GETDATE(),'" . $planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";
    $query = mssql_query($sql);

    $send_email = $cls_comm->send_email($projid, $packid, '26', $recvid, $remarks,'27');

    if ($query) {
        echo "<script>window.location.href='../files_for_technical_approval';</script>";
    } else {
        echo "not insert";
    }
} else if (isset($_POST['approve'])) {
    $tech_id = $_POST['tech_id'];
    $expdate = formatDate(str_replace('/', '-', $_POST['exp_date']), 'Y-m-d h:i:s');
//    $actdate = formatDate(str_replace('/', '-', $_POST['act_date']), 'Y-m-d h:i:s');
    $actdate = date('Y-m-d');
    $remarks = $_POST['remarks'];
    $senduserid = $_SESSION['uid'];

    $sql = "SELECT * FROM swift_techapproval WHERE tech_id='" . $tech_id . "'";
    $query = mssql_query($sql);
    $result = array();
    while ($row = mssql_fetch_array($query)) {
        $projid = $row['tech_projid'];
        $packid = $row['tech_packid'];
    }
    $sql = " SELECT * FROM swift_packagemaster where pm_packid='$packid'";

    $query = mssql_query($sql);
    while ($row = mssql_fetch_array($query)) {
        $recvid = $row['pm_userid'];
    }
    // UPDATE FLAG
    $sql = "UPDATE swift_techapproval SET tech_status = '3',tech_active='1' WHERE tech_id='$tech_id'";
    $query = mssql_query($sql);

    $sendstageid = 27;
    // $recvstageid=27;
    // update package status
    $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$packid' AND ps_projid= '$projid'";
    $query = mssql_query($sql);
    $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',ps_userid='$recvid',ps_sbuid='" . $senduserid . "',ps_remarks='$remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$packid' AND ps_stageid = '$sendstageid' AND ps_projid='$projid'";
    $query = mssql_query($sql);

    // get planned date query
    $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$packid' and ps_stageid = '$sendstageid'";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    // $planned_date = $row['planned_date'];
    $planneddate = formatDate(str_replace('/', '-', $row['planned_date']), 'Y-m-d h:i:s');

    $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
    $query = mssql_query($sql);
    $row = mssql_fetch_array($query);
    $id = $row['id'] + 1;

    // insert to transaction table
    $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status)
            VALUES('" . $id . "','" . $packid . "','" . $projid . "','" . $senduserid . "','" . $sendstageid . "',GETDATE(),'" . $planneddate . "','" . $actdate . "','" . $actdate . "','" . $remarks . "','0')";
    $query = mssql_query($sql);

    $send_email = $cls_comm->send_email($projid, $packid, '28', $recvid, $remarks,'27');
    if ($query) {
        echo "<script>window.location.href='../files_for_technical_approval';</script>";
    } else {
        echo "not insert";
    }
}
?>