<?php
// error_reporting(1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$milcom = $_SESSION['milcom'];
include_once("../config/inc_function.php");
$csrf_token = $_REQUEST['csrf_token'];
if (isset($_SESSION['token']) && $csrf_token === $_SESSION['token']) {

function function_alert($message, $from_dist, $projectid, $pack_id)
{
    if ($message != '') {
        echo "<script>alert('$message');</script>";
        echo "<script>window.location.href='../DistributorForm?mdid=$from_dist&projid=$projectid&packid=$pack_id';</script>";
    } else {
        echo "<script>window.location.href='../DistributorForm?mdid=$from_dist&projid=$projectid&packid=$pack_id';</script>";
    }
}
if (isset($_POST['distributor_create'])) {

    $projectid = $_POST['projectid'];
    $pack_id   = $_POST['packageid'];

    $from_dist  = trim($_POST['mdid']);

    $ds_id     = $_POST['dsid'];
    $flag      = $_POST['distributor'];
    $oem       = $_POST['oem'];
    $remarks   = sanitize($_POST['remarks']);
    $oem_flag   = $_POST['oem_flag'];
    $txp_sentdate = date("Y-m-d h:i:s");
    $txt_name       = sanitize($_POST['dist1_name']);
    $txt_mobno      = sanitize($_POST['dist1_mobno']);
    $txt_mailid     = sanitize($_POST['dist1_mailid']);

   // echo "SELECT count(md_id) as counts from  Swift_Mail_Details  where mobile_no='$txt_mobno' and md_packid='$pack_id' and md_projid='$projectid'   ";
    $sel_query_mob = mssql_query("SELECT count(md_id) as counts from  Swift_Mail_Details  where mobile_no='$txt_mobno' and md_packid='$pack_id' and md_projid='$projectid'   ");
    $row_count1   = mssql_fetch_array($sel_query_mob);

    $sel_query_email = mssql_query("SELECT count(md_id) as counts2 from  Swift_Mail_Details  where email_id='$txt_mailid' and md_packid='$pack_id' and md_projid='$projectid' ");
    $row_count2   = mssql_fetch_array($sel_query_email);


    if ($oem == '') {
        
        if ($row_count1['counts'] == 0) {
           
            $error = "Mobile No Not Valid";
        } else if ($row_count2['counts2'] == 0) {
            $error = "Mail Id Not Valid";
        } else {
            
            $sel_mdid = mssql_query("SELECT md_id,contact_name,mobile_no,email_id  from  Swift_Mail_Details  where mobile_no='$txt_mobno' and md_packid='$pack_id' and md_projid='$projectid'  ");
            $sel_mdids   = mssql_fetch_array($sel_mdid);
            $to_dist = $sel_mdids['md_id'];
            $contact_name = $sel_mdids['contact_name'];
            $mobile_no = $sel_mdids['mobile_no'];
            $email_id = $sel_mdids['email_id'];

            //update approval date
            $sql2   = "UPDATE Swift_Mail_Details SET oem_flag ='$oem_flag' , remark ='" . $remarks . "',approved_on='" . $txp_sentdate . "'  WHERE md_id ='$from_dist'";
            $query2 = mssql_query($sql2);
            //distributor log 
            $dlsql = mssql_query("select isnull (max(dl_id+1),1) as id from  Swift_Disributor_log");
            $dl = mssql_fetch_array($dlsql);
            $dlid = $dl['id'];
            $dis_sql3 = "insert into Swift_Disributor_log (dl_id,md_id,dl_packid,dl_projid,dl_date,contact_name,mobile_no,email_id,dl_flag,remark)"
                . "values('" . $dlid . "','" . $from_dist . "','" . $pack_id . "','" . $projectid . "','$txp_sentdate','" . $contact_name . "','" . $mobile_no . "','" . $email_id . "',
              '" . $flag  . "','" . $remarks . "')";
            $insert_dis = mssql_query($dis_sql3);

            //Update Current Distributor details
            if ($ds_id == 0) {
                $dlsql = mssql_query("select isnull (max(ds_id+1),1) as id from  Swift_Disributor_status");
                $dl = mssql_fetch_array($dlsql);
                $dsid = $dl['id'];

                $dis_status = "INSERT into Swift_Disributor_status (ds_id,from_dist,to_dist,ds_packid,ds_projid,approved_date,ds_flag,remark,cur_md_id)"
                    . "values('" . $dsid . "','" . $from_dist . "','" . $to_dist . "','" . $pack_id . "','" . $projectid . "','$txp_sentdate',
                '" . $flag  . "','" . $remarks . "','" . $to_dist . "')";
                $insert_status = mssql_query($dis_status);
            } else {

                $update_status   = "UPDATE Swift_Disributor_status SET from_dist ='$from_dist' ,to_dist='$to_dist',approved_date='$txp_sentdate',ds_flag='$flag',
                remark = ' $remarks',  cur_md_id = '$to_dist' WHERE ds_packid = '$pack_id' and  ds_id='$ds_id'";

                $upate_query2 = mssql_query($update_status);
            }

            $send_email = $cls_comm->Send_Mail_Dist($projectid, $pack_id, $to_dist);
            function_alert('', base64_encode($from_dist), base64_encode($projectid), base64_encode($pack_id));
        }
    } else {

        $sel_mdid = mssql_query("SELECT md_id,contact_name,mobile_no,email_id  from  Swift_Mail_Details  where  md_packid='$pack_id' and md_projid='$projectid' and flag=2  ");
        $sel_mdids   = mssql_fetch_array($sel_mdid);
        $to_dist = $sel_mdids['md_id'];
        $contact_name = sanitize($sel_mdids['contact_name']);
        $mobile_no = sanitize($sel_mdids['mobile_no']);
        $email_id = sanitize($sel_mdids['email_id']);
        //update approval date
         $sql2_update   = "UPDATE Swift_Mail_Details SET oem_flag ='$oem_flag',
         remark ='$remarks', approved_on='$txp_sentdate' WHERE md_id='$from_dist'";

        $query2 = mssql_query($sql2_update);
        
        //distributor log 
        $dlsql = mssql_query("select isnull (max(dl_id+1),1) as id from  Swift_Disributor_log");
        $dl = mssql_fetch_array($dlsql);
        $dlid = $dl['id'];
        $dis_sql = "insert into Swift_Disributor_log (dl_id,md_id,dl_packid,dl_projid,dl_date,contact_name,mobile_no,email_id,dl_flag,remark)"
            . "values($dlid,$from_dist,$pack_id,$projectid,'$txp_sentdate','" . $contact_name . "','" . $mobile_no . "','" . $email_id . "',
            '" . $flag  . "','" . $remarks . "')";
        $insert_dis = mssql_query($dis_sql);

        //Update Current Distributor details
        $update_status   = "UPDATE Swift_Disributor_status SET from_dist ='$from_dist' ,to_dist='$to_dist',approved_date='$txp_sentdate',ds_flag='$flag',
        remark = '$remarks', cur_md_id ='$to_dist' WHERE ds_packid ='$pack_id' and  ds_id='$ds_id'";

        $upate_query2 = mssql_query($update_status);

        $send_email = $cls_comm->Send_Mail_OEM($projectid, $pack_id, 0);

        function_alert('', base64_encode($from_dist), base64_encode($projectid), base64_encode($pack_id));
    }
} else if (isset($_POST['distributor_update'])) {
    $projectid = $_POST['projectid'];
    $pack_id   = $_POST['packageid'];
    $from_dist     = $_POST['mdid'];
    $remarks   = sanitize($_POST['remarks']);

    $sql2   = "UPDATE Swift_Disributor_log SET remark = ' $remarks',  send_back = '0' WHERE md_id = '$from_dist'";
    $query2 = mssql_query($sql2);

    $sql2   = "UPDATE Swift_Mail_Details SET remark = '" . $remarks . "',send_back = '2', buyer_app='0' WHERE md_packid = '$pack_id' and  md_projid='$projectid' ";
    $query2 = mssql_query($sql2);
    if ($query2) {
        function_alert('', base64_encode($from_dist), base64_encode($projectid), base64_encode($pack_id));
    } else {
        echo "not insert";
    }
}
}
