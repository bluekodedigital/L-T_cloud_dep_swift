<?php 
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    include_once ("../config/inc_function.php");

    if(isset($_POST['lc_create'])){
        $row_id = $_POST['lc_row_id'];
        $pack_id = $_POST['lc_pack_id'];
        $lc_number = $_POST['lc_number'];
        $lc_date = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['lc_date'])));
        $valid_from = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['start_lc'])));
        $valid_to = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['end_lc'])));
        $lc_value = $_POST['lc_value'];
        $remarks = $_POST['remarks'];
        $recvstageid=24;
        $sendstageid=24;
        $senduserid = $_SESSION['uid'];

        $sql = "SELECT pm_projid FROM swift_packagemaster WHERE pm_packid='$pack_id'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $proj_id = $row['pm_projid'];
        }

        // INSERT DATAS INTO    SWIFT_LC_RPA
        $sql = "SELECT ISNULL(MAX(lr_id), 0)+1 AS id FROM swift_lc_rpa";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'];

        $sql = "INSERT INTO swift_lc_rpa(lr_id,lr_projid,lr_packid,lr_senderuid,lc_number,lc_value,lc_valid_from,lc_valid_to) 
        VALUES('".$id."','".$proj_id."','".$pack_id."','".$senduserid."','".$lc_number."','".$lc_value."','".$valid_from."','".$valid_to."')";
        $query = mssql_query($sql);

         // update package status
         $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$pack_id'";
         $query = mssql_query($sql);
         $sql = "UPDATE swift_packagestatus SET ps_expdate = GETDATE(),ps_actualdate=GETDATE(),ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid'";
         $query = mssql_query($sql);
         
         $sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$proj_id' AND ps_packid='$pack_id' AND ps_stageid='$sendstageid'";
         $query = mssql_query($sql);
         $row = mssql_fetch_array($query);
         $planned_date = $row['revised_planned_date'];
 
         // transaction table functions
         $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
         $query = mssql_query($sql);
         $row = mssql_fetch_array($query);
         $id = $row['id']+1;
         
         // insert to transaction table
         $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
             VALUES('".$id."','".$pack_id."','".$proj_id."','".$senduserid."','".$sendstageid."',GETDATE(),'".$planned_date."',GETDATE(),GETDATE(),'".$remarks."','0')";
         $query = mssql_query($sql);
         if($query){
            $sql = "UPDATE swift_checklist_mapping SET lc_complete='1' WHERE cm_id='$row_id'";
            $query = mssql_query($sql);
             echo "<script>window.location.href='../lc_page';</script>";
         }else{
             echo "not insert";
         }
    }
    else if(isset($_POST['rpa_create'])){
        $row_id = $_POST['rpa_row_id'];
        $pack_id = $_POST['rpa_pack_id'];
        $rpa_number = $_POST['rpa_number'];
        $rpa_date = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['rpa_date'])));
        $valid_from = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['start_rpa'])));
        $valid_to = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $_POST['end_rpa'])));
        $rpa_value = $_POST['rpa_value'];
        $remarks = $_POST['remarks'];
        $recvstageid=24;
        $sendstageid=24;
        $senduserid = $_SESSION['uid'];
        
        $sql = "SELECT pm_projid FROM swift_packagemaster WHERE pm_packid='$pack_id'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $proj_id = $row['pm_projid'];
        }

        // INSERT DATAS INTO SWIFT_LC_RPA
        $sql ="SELECT * FROM swift_lc_rpa WHERE lr_packid='$pack_id'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        $sql = "SELECT ISNULL(MAX(lr_id), 0)+1 AS id FROM swift_lc_rpa";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'];

        $sql = "INSERT INTO swift_lc_rpa(lr_id,lr_projid,lr_packid,lr_senderuid,rpa_number,rpa_value,rpa_valid_from,rpa_valid_to) 
        VALUES('".$id."','".$proj_id."','".$pack_id."','".$senduserid."','".$rpa_number."','".$rpa_value."','".$valid_from."','".$valid_to."')";
        $query = mssql_query($sql);

         // update package status
         $sql = "UPDATE swift_packagestatus SET active = '0' WHERE ps_packid = '$pack_id'";
         $query = mssql_query($sql);
         $sql = "UPDATE swift_packagestatus SET ps_expdate = GETDATE(),ps_actualdate=GETDATE(),ps_userid='$senduserid',ps_remarks='$remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid'";
         $query = mssql_query($sql);
         
         $sql = "SELECT revised_planned_date FROM swift_packagestatus WHERE ps_projid= '$proj_id' AND ps_packid='$pack_id' AND ps_stageid='$sendstageid'";
         $query = mssql_query($sql);
         $row = mssql_fetch_array($query);
         $planned_date = $row['revised_planned_date'];
 
         // transaction table functions
         $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
         $query = mssql_query($sql);
         $row = mssql_fetch_array($query);
         $id = $row['id']+1;
         
         // insert to transaction table
         $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
             VALUES('".$id."','".$pack_id."','".$proj_id."','".$senduserid."','".$sendstageid."',GETDATE(),'".$planned_date."',GETDATE(),GETDATE(),'".$remarks."','0')";
         $query = mssql_query($sql);
         if($query){
            $sql = "UPDATE swift_checklist_mapping SET rpa_complete='1' WHERE cm_id='$row_id'";
            $query = mssql_query($sql);
             echo "<script>window.location.href='../lc_page';</script>";
         }else{
             echo "not insert";
         }
    }

?>