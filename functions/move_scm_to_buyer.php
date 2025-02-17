<?php 
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    include_once ("../config/inc_function.php");
    if(isset($_POST['buyer_realocate'])){
        $row_id=$_POST['row_id'];
        $buyer_id=$_POST['buyer_id'];
        $ace_value=$_POST['ace_value'];
        $sales_value=$_POST['sales_value'];
        $remarks=$_POST['remarks'];
        $senduserid=$_SESSION['uid'];
        $scm_sentdate = date("Y-m-d h:i:s");

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
        $sid = $row['id']+1;
        $sql = "INSERT INTO swift_SCMtoBUYER(bu_id,bu_packid,bu_projid,bu_senderuid,bu_buyer_id,bu_sentdate,bu_remarks,bu_ace_value,bu_sales_value,bu_status) 
                VALUES('".$sid."','".$pack_id."','".$proj_id."','".$senduserid."','".$buyer_id."','".$scm_sentdate."','".$remarks."','".$ace_value."','".$sales_value."','0')";
        $query = mssql_query($sql);

        if($query){
            echo "<script>window.location.href='../files_from_buyer';</script>";
        }else{
            echo "not insert";
        }
    }
    else{
        $buyer_id=$_POST['buyer_id'];
        $scm_id=$_POST['scmbu_id'];
     
        $expdate = formatDate(str_replace('/', '-', $_POST['al_act_date']), 'Y-m-d h:i:s');
        $actdate = formatDate(str_replace('/', '-', $_POST['al_act_date']), 'Y-m-d h:i:s');
        $remarks=$_POST['al_remarks'];
        $ace_value=$_POST['ace_value'];
        $sales_value=$_POST['sales_value'];
        // get project details query
      $sql = "SELECT * FROM swift_SCMSPOC WHERE sc_id = '$scm_id'"; 
        $query1 = mssql_query($sql);
        while ($row = mssql_fetch_array($query1)) {
            $proj_id = $row['sc_projid'];
            $pack_id = $row['sc_packid'];
        }
        
        $senduserid=$_SESSION['uid'];
        $sendstageid=13;
        $recvstageid=14;
        // get planned date query
        $sql = "SELECT ps_planneddate as planned_date FROM swift_packagestatus WHERE ps_packid = '$pack_id' and ps_stageid = $sendstageid";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $planned_date = $row['planned_date'];
        $scm_sentdate = date("Y-m-d h:i:s");
        $scm_planneddate = formatDate(str_replace('/', '-', $planned_date), 'Y-m-d h:i:s');
        
        // update 
        $sql = "UPDATE swift_SCMSPOC SET sc_planneddate='".$scm_planneddate."',sc_expdate='".$actdate."',sc_actual='".$actdate."',sc_status='1',sc_active='1' WHERE sc_id = '$scm_id'";
        $query = mssql_query($sql);

        // update package status
        $sql = "UPDATE swift_packagestatus SET active = '0',ps_stback=0 WHERE ps_packid = '$pack_id' AND ps_projid= '$proj_id'";
        $query = mssql_query($sql);
        $sql = "UPDATE swift_packagestatus SET ps_expdate = '$actdate',ps_actualdate='$actdate',ps_userid='$buyer_id',ps_remarks='$remarks',updated_date=GETDATE(),active='1' WHERE ps_packid = '$pack_id' AND ps_stageid = '$recvstageid' AND ps_projid= '$proj_id'";
        $query = mssql_query($sql);

        // insert to expert table
        $sql = "SELECT * FROM swift_SCMtoBUYER WHERE bu_projid='$proj_id' AND bu_packid='$pack_id'";
        $query = mssql_query($sql);
        $row1 =mssql_fetch_array($query);
        if($row1 > 0){
            $sql = "UPDATE swift_SCMtoBUYER SET bu_status='0' WHERE bu_projid='$proj_id' AND bu_packid='$pack_id'";
            $query = mssql_query($sql);
        }
        $sql = "SELECT MAX(bu_id) as id FROM swift_SCMtoBUYER;";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $sid = $row['id']+1;
        $sql = "INSERT INTO swift_SCMtoBUYER(bu_id,bu_packid,bu_projid,bu_senderuid,bu_buyer_id,bu_sentdate,bu_remarks,bu_ace_value,bu_sales_value,bu_status) 
                VALUES('".$sid."','".$pack_id."','".$proj_id."','".$senduserid."','".$buyer_id."','".$scm_sentdate."','".$remarks."','".$ace_value."','".$sales_value."','0')";
        $query = mssql_query($sql);
        if($query){
            $sql = "SELECT MAX(st_id) as id FROM swift_transactions";
            $query = mssql_query($sql);
            $row = mssql_fetch_array($query);
            $id = $row['id']+1;
            
            // insert to transaction table
            $sql = "INSERT INTO swift_transactions(st_id,st_packid,st_projid,st_uid,st_stageid,st_sentdate,st_planneddate,st_expdate,st_actual,st_remarks,st_status) 
                VALUES('".$id."','".$pack_id."','".$proj_id."','".$senduserid."','".$sendstageid."','".$scm_sentdate."','".$scm_planneddate."','".$actdate."','".$actdate."','".$remarks."','0')";
            $query = mssql_query($sql);
                    $send_email=$cls_comm->send_email($proj_id,$pack_id,$recvstageid,$buyer_id,$remarks);
            if($query){
                echo "<script>window.location.href='../scm_workflow';</script>";
            }else{
                echo "not insert";
            }
        }else{
            echo "not success";
        }
    }
        
?>