<?php

class Admin {

    function get_smtp_email() {
        $sql = "select * from dbo.swift_smtp_setting";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_emails_byid($id) {
        $sql = "select * from dbo.swift_smtp_setting where smtp_id='" . $id . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_ops_users() {
        $sql = "select * from usermst where usertype in (5,15)";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_approvers() {
        $sql = "select * from usermst where usertype=3";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_generalusers() {
        $sql = "select * from usermst where usertype=2";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function check_opssetting($ops_id, $pid) {
        $sql = "select * from ops_mailsetting where ops_projid='".$pid."' and ops_toemail='".$ops_id."'";
        $query = mssql_query($sql);
        $num_rows= mssql_num_rows($query);
        return $num_rows;
         
    }
    function check_opssetting_cc($ops_id, $pid){
        $sql = "select * from ops_mailsetting where ops_projid='".$pid."' and ops_cc='".$ops_id."'";
        $query = mssql_query($sql);
        $num_rows= mssql_num_rows($query);
        return $num_rows;
    }
     function select_techCTO_workflowM($id,$uid,$seg) {
         if($seg !='')
         {
          $cond=" AND cat_id='38'";
         }else
         {
          $cond=" AND cat_id!='38'";  
         }
        if ($id != "") {
            $sql = "SELECT cto_id,cto_projid,proj_name,cto_packid,pm_packagename,cto_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_expdate,ps_actualdate,cto_remarks,cto_sentdate FROM Project,swift_packagemaster,swift_techCTO,swift_packagestatus 
            WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '0' AND cto_active = '1' AND ps_stageid='6' AND cto_projid='$id' AND cto_recvuid='$uid' $cond";
        } else {
            $sql = "SELECT cto_id,cto_projid,proj_name,cto_packid,pm_packagename,cto_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_expdate,ps_actualdate,cto_remarks,cto_sentdate FROM Project,swift_packagemaster,swift_techCTO,swift_packagestatus 
            WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '0' AND cto_active = '1' AND ps_stageid='6' AND cto_recvuid='$uid' $cond";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_techCTO_repositoryM($id,$uid,$seg) {
         if($seg !='')
         {
             $cond=" AND cat_id='38'";
         }else
         {
           $cond=" AND cat_id!='38'";  
         }
        if ($id != "") {
            $sql = "SELECT cto_id,cto_projid,proj_name,cto_packid,pm_packagename,cto_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_actualdate,cto_remarks,ps_planneddate as org_plandate,ps_expdate,ps_stageid,ps_actualdate
            FROM swift_techCTO,swift_packagestatus,swift_packagemaster,Project WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '1' AND cto_active = '1' AND ps_stageid='6' AND cto_projid='$id' AND cto_recvuid='$uid' $cond";
        } else {
            $sql = "SELECT cto_id,cto_projid,proj_name,cto_packid,pm_packagename,cto_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_actualdate,cto_remarks,ps_planneddate as org_plandate,ps_expdate,ps_stageid,ps_actualdate
            FROM swift_techCTO,swift_packagestatus,swift_packagemaster,Project WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '1' AND cto_active = '1' AND ps_stageid='6' AND cto_recvuid='$uid' $cond";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function get_projmanger() {
        $sql = "select * from usermst where usertype=6";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function get_projusers() {
        $sql = "select * from usermst where usertype=17";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_techReviewer_workflow($id,$uid) {
        if ($id != "") {
            $sql = "SELECT techRev_id,techRev_projid,proj_name,techRev_packid,pm_packagename,techRev_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_expdate,ps_actualdate,techRev_remarks,techRev_sentdate FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '0' AND techRev_active = '1' AND ps_stageid='5' AND techRev_projid='$id' AND techRev_recvuid='$uid'";
        } else {
            $sql = "SELECT techRev_id,techRev_projid,proj_name,techRev_packid,pm_packagename,techRev_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_expdate,ps_actualdate,techRev_remarks,techRev_sentdate FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '0' AND techRev_active = '1' AND ps_stageid='5' AND techRev_recvuid='$uid'";
        }
        
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
      function select_techReviewer_workflowCto($id,$uid) {
        if ($id != "") {
            $sql = "SELECT techRev_id,techRev_projid,proj_name,techRev_packid,pm_packagename,techRev_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_expdate,ps_actualdate,techRev_remarks,techRev_sentdate FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '2' AND techRev_active = '1' AND ps_stageid='5' AND techRev_projid='$id' AND techRev_recvuid='$uid'";
        } else {
            $sql = "SELECT techRev_id,techRev_projid,proj_name,techRev_packid,pm_packagename,techRev_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_expdate,ps_actualdate,techRev_remarks,techRev_sentdate FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '2' AND techRev_active = '1' AND ps_stageid='5' AND techRev_recvuid='$uid'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_techReviewer_repository($id,$uid) {
        if ($id != "") {
            $sql = "SELECT techRev_id,techRev_projid,proj_name,techRev_packid,pm_packagename,techRev_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_expdate,ps_actualdate,techRev_remarks,techRev_sentdate FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '1' AND techRev_active = '1' AND ps_stageid='5' AND techRev_projid='$id' AND techRev_recvuid='$uid'";
        } else {
            $sql = "SELECT techRev_id,techRev_projid,proj_name,techRev_packid,pm_packagename,techRev_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_expdate,ps_actualdate,techRev_remarks,techRev_sentdate FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '1' AND techRev_active = '1' AND ps_stageid='5' AND techRev_recvuid='$uid'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

}

?>
