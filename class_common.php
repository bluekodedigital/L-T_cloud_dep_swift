<?php

class Common {

    function select_segment() {
        $sql = "select * from segment_master";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_allprojects() {
        $sql = "select * from Project order by proj_name ASC";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_projects($id) {
        $sql = "select * from Project where proj_id = $id";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_segment_id($id) {
        $sql = "select * from segment_master where seg_pid='" . $id . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function datechange($date) {
        $date = date_create($date);
        $date = date_format($date, "d-M-y");
        return $date;
    }

    function select_table($table) {
        $sql = "select * from $table";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_project_notpackage($pid, $segment) {
        if ($pid == "") {
            $sql = "select * from Project,usermst where package_status in(0,1) and creator_id=uid  and cat_id='" . $segment . "' order by proj_id DESC";
        } else {
            $sql = "select * from Project,usermst where package_status in(0,1) and creator_id=uid and cat_id='" . $segment . "' and proj_id='" . $pid . "' order by proj_id DESC";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_allpackages($pid, $segment) {
        if ($pid == "") {
            $sql = "select pm_packid,pm_projid,proj_name,pm_packagename,pm_createdate,pm_material_req,pm_revised_material_req,pm_leadtime,pm_userid 
                from swift_packagemaster,Project where proj_id=pm_projid and cat_id='" . $segment . "'";
        } else {
            $sql = "select pm_packid,pm_projid,proj_name,pm_packagename,pm_createdate,pm_material_req,pm_revised_material_req,pm_leadtime,pm_userid 
                from swift_packagemaster,Project where proj_id=pm_projid and cat_id='" . $segment . "' and proj_id='" . $pid . "'";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function sendtospoc($segment) {
        $sql = "select pm_packid,proj_name,pm_packagename,pm_createdate as planned,GETDATE() as actual,stage_name
from  swift_packagemaster,Project,swift_stage_master where proj_id=pm_projid and tech_status=0 and stage_id=1 and cat_id='" . $segment . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function sendtospocdata($pack_id) {
        $sql = "select proj_id,proj_name,pm_packagename,pm_revised_material_req,revised_planned_date as planned,ps_expdate,pm_createdate as expected,GETDATE() as actual,stage_name
from  swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=pm_projid 
and tech_status=0 and stage_id=1 and ps_packid=pm_packid and  ps_packid='" . $pack_id . "' and ps_stageid=1 ";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_allprojects_seg($segment) {
        $sql = "select * from Project where cat_id='" . $segment . "' order by proj_name ASC";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function dash_filter() {
        $sql = "SELECT  distinct proj_id,proj_name FROM project,swift_packagestatus WHERE proj_id=ps_projid";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function sendtospoc_projfilter($pid, $segment) {
        if ($pid != "") {
            $sql = "select distinct pm_packid,proj_name,pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,GETDATE() as actual,ps_expdate,stage_name,pm_createdate
from  swift_packagestatus,swift_packagemaster,Project,swift_stage_master where proj_id=pm_projid and proj_id=ps_projid and tech_status=0 
and stage_id=ps_stageid and cat_id='" . $segment . "' and proj_id='" . $pid . "' and pm_packid=ps_packid and ps_stageid=1";
        } else {
            $sql = "select distinct pm_packid,proj_name,pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,GETDATE() as actual,ps_expdate,stage_name,pm_createdate
from  swift_packagestatus,swift_packagemaster,Project,swift_stage_master where proj_id=pm_projid and proj_id=ps_projid and tech_status=0 
and stage_id=ps_stageid and cat_id='" . $segment . "' and pm_packid=ps_packid and ps_stageid=1";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_allomproject($segment) {
        $sql = "select distinct proj_id,ps_projid,proj_name from swift_packagestatus,Project where proj_id=ps_projid";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    //sakthi
    // sakthi
    function select_stages($id) {
        $sql = "select * from swift_stage_master where stage_id = $id";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function select_techspoc_workflow($id, $segment) {
        if ($id != "") {
            $sql = "SELECT ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ps_planneddate as org_plandate,ps_expdate,
            ps_actualdate,ts_expdate,ts_actual,ts_remarks,ts_status,ts_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date
            FROM swift_techspoc,swift_packagestatus,swift_packagemaster,Project WHERE ts_status = '0' AND ts_active = '1' AND ps_stageid = '3' and ts_packid=ps_packid and ts_packid=pm_packid AND ts_projid= '$id' and ts_packid=pm_packid and proj_id=ts_projid and cat_id in($segment)";
        } else {
            $sql = " SELECT ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ps_planneddate as org_plandate,ps_expdate,
            ps_actualdate,ts_expdate,ts_actual,ts_remarks,ts_status,ts_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date
            FROM swift_techspoc,swift_packagestatus,swift_packagemaster,Project WHERE ts_status = '0' AND ts_active = '1' AND ps_stageid = '3' and ts_packid=ps_packid and ts_packid=pm_packid and proj_id=ts_projid and cat_id in($segment)";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function select_techspoc_repository($id, $uid) {
        if ($id != "") {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' AND ts_projid= '$id'";
            $sql = "SELECT ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ps_planneddate as org_plandate,
            ps_expdate,ps_actualdate,ts_expdate,ps_stageid,ts_actual,ts_remarks,ts_status,ts_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date  
            FROM swift_techspoc,swift_packagestatus,swift_packagemaster WHERE ts_status = '1' AND ts_active = '1' AND active = '1' and ts_packid=ps_packid AND ts_packid=pm_packid AND ts_recvuid='$uid' AND ts_projid= '$id'";
        } else {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' ";
         echo    $sql = "SELECT ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ps_planneddate as org_plandate,
            ps_expdate,ps_actualdate,ts_expdate,ps_stageid,ts_actual,ts_remarks,ts_status,ts_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date  
            FROM swift_techspoc,swift_packagestatus,swift_packagemaster WHERE ts_status = '1' AND ts_active = '1' AND active = '1' and ts_packid=ps_packid AND ts_packid=pm_packid AND ts_recvuid='$uid'";
        }
        
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
  // sakthi
  function select_workflow_repository($id, $uid) {
    if ($id != "") {
        // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' AND ts_projid= '$id'";
        $sql = "SELECT ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ps_planneddate as org_plandate,
        ps_expdate,ps_actualdate,ts_expdate,ps_stageid,ts_actual,ts_remarks,ts_status,ts_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date  
        FROM swift_techspoc,swift_packagestatus,swift_packagemaster WHERE ts_status = '1' AND ts_active = '1' AND active = '1' and ts_packid=ps_packid AND ts_packid=pm_packid AND ts_recvuid='$uid' AND ts_projid= '$id'";
    } else {
        // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' ";
     echo   $sql = "SELECT ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ps_planneddate as org_plandate,
        ps_expdate,ps_actualdate,ts_expdate,ps_stageid,ts_actual,ts_remarks,ts_status,ts_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date  
        FROM swift_techspoc,swift_packagestatus,swift_packagemaster WHERE ts_status = '1' AND ts_active = '1' AND active = '1' and ts_packid=ps_packid AND ts_packid=pm_packid AND ts_recvuid='$uid'";
   die;
}
    $query = mssql_query($sql);
    $result = array();
    while ($row = mssql_fetch_array($query)) {
        $result[] = $row;
    }
    $res = json_encode($result);
    return $res;
}

    // sakthi
    function select_techexpert_workflow($id, $uid) {
        if ($id != "") {
            $sql = "SELECT txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,ps_planneddate as org_plandate,ps_expdate,
            ps_actualdate,txp_expdate,txp_actual,txp_remarks,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '0' AND txp_active='1' AND txp_projid = '$id' AND txp_recvuid='$uid'";
        } else {
            $sql = "SELECT txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,ps_planneddate as org_plandate,ps_expdate,
            ps_actualdate,txp_expdate,txp_actual,txp_remarks,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '0' AND txp_active='1' AND txp_recvuid='$uid'";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function select_techexpert_repository($id, $uid) {
        if ($id != "") {
            $sql = "SELECT txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,ps_planneddate as org_plandate,ps_expdate,ps_stageid,
            ps_actualdate,txp_expdate,txp_actual,txp_remarks,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '1' AND txp_active='1' AND txp_projid = '$id' AND txp_recvuid='$uid'";
        } else {
            $sql = "SELECT txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,ps_planneddate as org_plandate,ps_expdate,ps_stageid,
            ps_actualdate,txp_expdate,txp_actual,txp_remarks,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '1' AND txp_active='1' AND txp_recvuid='$uid'";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function select_techCTO_workflow($id) {
        if ($id != "") {
            $sql = "SELECT cto_id,cto_projid,proj_name,cto_packid,pm_packagename,cto_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_expdate,ps_actualdate,cto_remarks,cto_sentdate FROM Project,swift_packagemaster,swift_techCTO,swift_packagestatus 
            WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '0' AND cto_active = '1' AND ps_stageid='6' AND cto_projid='$id'";
        } else {
            $sql = "SELECT cto_id,cto_projid,proj_name,cto_packid,pm_packagename,cto_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_expdate,ps_actualdate,cto_remarks,cto_sentdate FROM Project,swift_packagemaster,swift_techCTO,swift_packagestatus 
            WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '0' AND cto_active = '1' AND ps_stageid='6'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_techCTO_repository($id) {
        if ($id != "") {
            $sql = "SELECT cto_id,cto_projid,proj_name,cto_packid,pm_packagename,cto_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_actualdate,cto_remarks,ps_planneddate as org_plandate,ps_expdate,ps_stageid,ps_actualdate
            FROM swift_techCTO,swift_packagestatus,swift_packagemaster,Project WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '1' AND cto_active = '1' AND ps_stageid='6' AND cto_projid='$id'";
        } else {
            $sql = "SELECT cto_id,cto_projid,proj_name,cto_packid,pm_packagename,cto_senderuid,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,
            revised_planned_date as planned_date,ps_actualdate,cto_remarks,ps_planneddate as org_plandate,ps_expdate,ps_stageid,ps_actualdate
            FROM swift_techCTO,swift_packagestatus,swift_packagemaster,Project WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '1' AND cto_active = '1' AND ps_stageid='6'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function select_scmspoc($id) {
        if ($id != "") {
            $sql = "SELECT sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_expdate,sc_actual,
            sc_remarks,sc_status,sc_active,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,revised_planned_date as planned_date,ps_expdate,ps_actualdate
            FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND sc_status='0' AND sc_active='1' AND sc_projid= '$id'";
        } else {
            $sql = "SELECT sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_expdate,sc_actual,
            sc_remarks,sc_status,sc_active,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,revised_planned_date as planned_date,ps_expdate,ps_actualdate
            FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND sc_status='0' AND sc_active='1'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function select_frombuyer($id) {
        if ($id != "") {
            $sql = "SELECT bu_id,bu_packid,bu_projid,bu_buyer_id as sender_id,bu_sentdate,bu_ace_value,bu_sales_value,sb_remarks,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate
            FROM swift_SCMtoBUYER,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '13' AND bu_packid=ps_packid AND bu_packid=pm_packid AND bu_status='2' AND bu_projid= '$id'";
        } else {
            $sql = "SELECT bu_id,bu_packid,bu_projid,bu_buyer_id as sender_id,bu_sentdate,bu_ace_value,bu_sales_value,sb_remarks,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate
            FROM swift_SCMtoBUYER,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '13' AND bu_packid=ps_packid AND bu_packid=pm_packid AND bu_status='2'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function select_smartsignoff($id, $uid) {
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER  
            WHERE stage_id=ps_stageid and  so_pack_id=pm_packid AND so_pack_id=ps_packid AND  ps_stageid=20
            AND (so_hw_sw=2 and po_wo_status ='0' or so_hw_sw=3 and po_wo_status ='2' ) AND so_proj_id= '$id' and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "'";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER 
            WHERE stage_id=ps_stageid and so_pack_id=pm_packid and ps_stageid=20
            AND (so_hw_sw=2 and po_wo_status ='0' or so_hw_sw=3 and po_wo_status ='2' ) and  so_pack_id=ps_packid and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_smartsignoff1($id, $uid) {
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER  
            WHERE stage_id=ps_stageid and  so_pack_id=pm_packid AND so_pack_id=ps_packid AND  ps_stageid=20
            AND (so_hw_sw=2 and po_wo_status ='1' or so_hw_sw=3 and po_wo_status ='3' ) AND so_proj_id= '$id' and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "'";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER 
            WHERE stage_id=ps_stageid and so_pack_id=pm_packid and ps_stageid=20
            AND (so_hw_sw=2 and po_wo_status ='1' or so_hw_sw=3 and po_wo_status ='3' ) and  so_pack_id=ps_packid  AND po_wo_status !='4' and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function select_lc($id) {
        if ($id != "") {
            $sql = "SELECT cm_id,cm_proj_id,cm_pack_id,cm_buyer_id,created_date,ps_planneddate as org_plandate,ps_expdate,ps_actualdate,ps_remarks,wo_number,po_number,
            revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date
            FROM swift_checklist_mapping,swift_packagestatus,swift_packagemaster,swift_filesfrom_smartsignoff
            WHERE ps_stageid = '24' and so_pack_id=cm_pack_id AND cm_pack_id=ps_packid AND cm_pack_id=pm_packid AND cm_lc='1' AND lc_complete = '0'AND cm_proj_id = '$id'";
        } else {
            $sql = "SELECT cm_id,cm_proj_id,cm_pack_id,cm_buyer_id,created_date,ps_planneddate as org_plandate,ps_expdate,ps_actualdate,ps_remarks,wo_number,po_number,
            revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date
            FROM swift_checklist_mapping,swift_packagestatus,swift_packagemaster,swift_filesfrom_smartsignoff
            WHERE ps_stageid = '24' and so_pack_id=cm_pack_id AND cm_pack_id=ps_packid AND cm_pack_id=pm_packid AND cm_lc='1' AND lc_complete = '0'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function select_rpa($id) {
        if ($id != "") {
            $sql = "SELECT cm_id,cm_proj_id,cm_pack_id,cm_buyer_id,created_date,ps_planneddate as org_plandate,ps_expdate,ps_actualdate,ps_remarks,wo_number,po_number,
            revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date
            FROM swift_checklist_mapping,swift_packagestatus,swift_packagemaster,swift_filesfrom_smartsignoff 
            WHERE ps_stageid = '24' and so_pack_id=cm_pack_id AND cm_pack_id=ps_packid AND cm_pack_id=pm_packid AND cm_rpa='1' AND RPA_complete = '0' AND cm_proj_id = '$id'";
        } else {
            $sql = "SELECT cm_id,cm_proj_id,cm_pack_id,cm_buyer_id,created_date,ps_planneddate as org_plandate,ps_expdate,ps_actualdate,ps_remarks,wo_number,po_number,
            revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date
            FROM swift_checklist_mapping,swift_packagestatus,swift_packagemaster,swift_filesfrom_smartsignoff
            WHERE ps_stageid = '24' and so_pack_id=cm_pack_id AND cm_pack_id=ps_packid AND cm_pack_id=pm_packid AND cm_rpa='1' AND RPA_complete = '0'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function select_lc_repository($id) {
        if ($id != "") {
            $sql = "SELECT * FROM swift_lc_rpa,swift_filesfrom_smartsignoff where lc_number !='' and so_pack_id=lr_packid  AND lr_projid = '$id'";
        } else {
            $sql = "SELECT * FROM swift_lc_rpa,swift_filesfrom_smartsignoff where lc_number !='' and so_pack_id=lr_packid  ";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_lc_newrepository($id) {
        if ($id != "") {
            $sql = "select  distinct lce_packid,lce_venid,sup_name,lcm_num,lce_projid,lce_ponum,sum(lce_applied) as applied_val,
lcm_value,lcm_balance,proj_name,pm_packid,lcm_from,lcm_to,DATEDIFF(DAY,GETDATE(),lcm_to) as validity,po_wo_flag
from swift_lc_entry,vendor,swift_lcmaster,Project,swift_packagemaster
where lce_venid=sup_id and lcm_id=lcmst_id and pm_packid=lce_packid and lce_projid=proj_id and proj_id='" . $id . "'
group by lce_packid,lce_venid,sup_name,lce_projid,lce_ponum,lcm_value,lcm_balance,proj_name,pm_packid,lcm_from,lcm_to,lcm_num,po_wo_flag";
        } else {
            $sql = "select  distinct lce_packid,lce_venid,sup_name,lcm_num,lce_projid,lce_ponum,sum(lce_applied) as applied_val,
lcm_value,lcm_balance,proj_name,pm_packid,lcm_from,lcm_to,DATEDIFF(DAY,GETDATE(),lcm_to) as validity,po_wo_flag 
from swift_lc_entry,vendor,swift_lcmaster,Project,swift_packagemaster
where lce_venid=sup_id and lcm_id=lcmst_id and pm_packid=lce_packid and lce_projid=proj_id  
group by lce_packid,lce_venid,sup_name,lce_projid,lce_ponum,lcm_value,lcm_balance,proj_name,pm_packid,lcm_from,lcm_to,lcm_num,po_wo_flag";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_rpa_newrepository($id) {
        if ($id != "") {
            $sql = "select distinct ebr_packid,ebr_venid,sup_name,ebr_rpanum,ebr_projid,ebr_ponum,SUM(ebr_billvalue) as applied_ebr,
                ebr_po_wo_flag,rpa_from,rpa_to,DATEDIFF(DAY,GETDATE(),rpa_to) as validity
from swift_ebrbill_entry,vendor,swift_rpamaster,Project,swift_packagemaster
where ebr_packid=pm_packid and ebr_venid=sup_id and rpa_id=ebrmst_id and  ebr_projid=proj_id and proj_id='" . $id . "'
group by ebr_packid,ebr_venid,sup_name,ebr_rpanum,ebr_projid,ebr_ponum,ebr_po_wo_flag,rpa_from,rpa_to";
        } else {
            $sql = "select distinct ebr_packid,ebr_venid,sup_name,ebr_rpanum,ebr_projid,ebr_ponum,SUM(ebr_billvalue) as applied_ebr,
                ebr_po_wo_flag,rpa_from,rpa_to,DATEDIFF(DAY,GETDATE(),rpa_to) as validity
from swift_ebrbill_entry,vendor,swift_rpamaster,Project,swift_packagemaster
where ebr_packid=pm_packid and ebr_venid=sup_id and rpa_id=ebrmst_id and  ebr_projid=proj_id  
group by ebr_packid,ebr_venid,sup_name,ebr_rpanum,ebr_projid,ebr_ponum,ebr_po_wo_flag,rpa_from,rpa_to";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function select_rpa_repository($id) {
        if ($id != "") {
            $sql = "SELECT * FROM swift_lc_rpa,swift_filesfrom_smartsignoff where rpa_number !='' and so_pack_id=lr_packid AND lr_projid = '$id'";
        } else {
            $sql = "SELECT * FROM swift_lc_rpa,swift_filesfrom_smartsignoff where rpa_number !='' and  so_pack_id=lr_packid";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_lc_data($id) {
        $sql = "SELECT proj_id,proj_name,ps_packid,ps_planneddate as planned_date ,ps_expdate,pm_packagename,pm_revised_material_req,wo_number,po_number
            FROM swift_packagestatus,swift_packagemaster,Project,swift_filesfrom_smartsignoff
            WHERE ps_packid=pm_packid AND proj_id=pm_projid AND ps_packid = '" . $id . "' and ps_stageid = '24' and so_pack_id=ps_packid";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_rpa_data($id) {
        $sql = "SELECT proj_id,proj_name,ps_packid,ps_planneddate as planned_date ,ps_expdate,pm_packagename,pm_revised_material_req,wo_number,po_number "
                . "FROM swift_packagestatus,swift_packagemaster,Project,swift_filesfrom_smartsignoff "
                . "WHERE ps_packid=pm_packid AND proj_id=pm_projid AND ps_packid = '$id' and ps_stageid = '24' and so_pack_id=ps_packid";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi get project name
    function project_name($id) {
        $sql = "select proj_name from Project WHERE proj_id = $id";
        $query = mssql_query($sql);
        if (mssql_num_rows($query) > 0) {
            $row = mssql_fetch_array($query);
            return $row['proj_name'];
        } else {
            return "NO PROJECT";
        }
    }

    // sakthi GET package name
    function package_name($id) {
        $sql = "select pm_packagename from swift_packagemaster WHERE pm_packid = '$id'";
        $query = mssql_query($sql);
        if (mssql_num_rows($query) > 0) {
            $row = mssql_fetch_array($query);
            return $row['pm_packagename'];
        } else {
            return "NO PACKAGE";
        }
    }

    // sakthi get project name
    function cur_status_name($id) {
        $sql = "select shot_name from swift_packagestatus,swift_stage_master where ps_stageid=stage_id and active='1'  and ps_packid='$id'";
        $query = mssql_query($sql);
        if (mssql_num_rows($query) > 0) {
            $row = mssql_fetch_array($query);
            return $row['shot_name'];
        } else {
            return "NULL";
        }
    }

    //sakthi select users with particular type
    function select_user($id) {
        $sql = "select * from usermst where usertype = $id";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function select_repository($id) {
        $sql = "SELECT * FROM swift_transactions WHERE st_uid = '$id'";
        // $sql ="SELECT * FROM swift_transactions";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function get_username($id) {
        $sql = "SELECT name FROM usermst WHERE uid = '$id' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row['name'];
    }

    // sakthi
    function ops_spoc_cur_remarks($packid) {
        $sql = "SELECT ts_remarks FROM swift_techspoc WHERE ts_active= '1' AND ts_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    // sakthi
    function ops_spoc_pre_remarks($packid) {
        $sql = "SELECT ts_sentdate,ts_remarks FROM swift_techspoc WHERE ts_active= '0' AND ts_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function spoc_exp_cur_remarks($packid) {
        $sql = "SELECT txp_remarks FROM swift_techexpert WHERE txp_active= '1' AND txp_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    // sakthi
    function spoc_exp_pre_remarks($packid) {
        $sql = "SELECT txp_sentdate,txp_remarks FROM swift_techexpert WHERE txp_active= '0' AND txp_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function spoc_exp_pre_remarks_sent_back($packid) {
        $sql = "SELECT txp_sentdate,txp_remarks,txp_sendr_stageid FROM swift_techexpert WHERE txp_active= '1' AND txp_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row['txp_sendr_stageid'];
    }

    function ops_spoc_pre_remarks_sent_back($packid) {
        $sql = "SELECT ts_sentdate,ts_remarks,ts_sendr_stageid FROM swift_techspoc WHERE ts_active= '1' AND ts_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row['ts_sendr_stageid'];
    }

    // sakthi
    function technical_cur_remarks($packid) {
        $sql = "SELECT tech_remarks FROM swift_techapproval WHERE tech_status='2' AND tech_active='1' AND tech_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    // sakthi
    function technical_pre_remarks($packid) {
        $sql = "SELECT tech_remarks FROM swift_techapproval WHERE tech_status='1' AND tech_active='1' AND tech_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function exp_cto_cur_remarks($packid) {
        $sql = "SELECT cto_remarks FROM swift_techcto WHERE cto_active= '1' AND cto_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    // sakthi
    function exp_cto_pre_remarks($packid) {
        $sql = "SELECT cto_sentdate,cto_remarks FROM swift_techcto WHERE cto_active= '0' AND cto_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function ops_scm_cur_remarks($packid) {
        $sql = "SELECT sc_remarks FROM swift_SCMSPOC WHERE sc_active = '1' AND sc_packid = '$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    // sakthi
    function ops_scm_pre_remarks($packid) {
        $sql = "SELECT sc_sentdate,sc_remarks FROM swift_SCMSPOC WHERE sc_active = '0' AND sc_packid = '$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function sendtoexpertdata($pack_id) {
        $sql = "SELECT ps_packid,ps_planneddate as planned_date,revised_planned_date,ps_expdate,pm_packagename,pm_revised_material_req FROM swift_packagestatus,swift_packagemaster WHERE ps_packid=pm_packid AND ps_packid = '$pack_id' and ps_stageid = '3'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function select_technical_approve($pack_id) {
        $sql = "SELECT ps_packid,ps_planneddate as planned_date,revised_planned_date,ps_expdate,pm_packagename,pm_revised_material_req FROM swift_packagestatus,swift_packagemaster WHERE ps_packid=pm_packid AND ps_packid = '$pack_id' and ps_stageid = '27'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function ps_planget($pack_id, $stage_id) {
        $sql = "SELECT pm_packagename,pm_revised_material_req AS mat_req,revised_planned_date AS planned_date FROM swift_packagestatus,swift_packagemaster WHERE ps_stageid ='$stage_id' AND ps_packid='$pack_id' AND pm_packid=ps_packid";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function get_ss_actdate($pack_id) {
        $sql = "SELECT so_loi_date,so_package_sentdate,so_package_approved_date from  swift_filesfrom_smartsignoff WHERE so_pack_id='$pack_id'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    //    sakthi
    function sendtoctodata($pack_id) {
        $sql = "SELECT ps_packid,ps_planneddate as planned_date ,ps_expdate,revised_planned_date,pm_packagename,pm_revised_material_req FROM swift_packagestatus,swift_packagemaster WHERE ps_packid=pm_packid AND ps_packid = '$pack_id' and ps_stageid = '5'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function sendtoopsdata($pack_id) {
        $sql = "SELECT ps_packid,ps_planneddate as planned_date ,revised_planned_date,ps_expdate,pm_packagename,pm_revised_material_req FROM swift_packagestatus,swift_packagemaster WHERE ps_packid=pm_packid AND ps_packid = '$pack_id' and ps_stageid = '6'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function sendtoscmtoopsdata($pack_id) {
        $sql = "SELECT ps_packid,ps_planneddate as planned_date,revised_planned_date,ps_expdate,pm_packagename,pm_revised_material_req FROM swift_packagestatus,swift_packagemaster WHERE ps_packid=pm_packid AND ps_packid = '$pack_id' and ps_stageid = '13'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function techspoc_proj_filter() {
        $sql = "SELECT DISTINCT(proj_id),proj_name FROM Project,swift_techspoc WHERE proj_id=ts_projid";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function techexpert_proj_filter($id) {
        $sql = "SELECT DISTINCT(proj_id),proj_name FROM Project,swift_techexpert WHERE proj_id=txp_projid AND txp_recvuid='$id'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function techcto_proj_filter($id) {
        $sql = "SELECT DISTINCT(proj_id),proj_name FROM Project,swift_techCTO WHERE proj_id=cto_projid AND cto_recvuid='$id'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function scm_proj_filter($id) {
        $sql = "SELECT DISTINCT(proj_id),proj_name FROM Project,swift_SCMSPOC WHERE proj_id=sc_projid AND sc_recvuid='$id'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function po_wo_check($pack_id) {
        $sql = "SELECT * FROM Swift_po_wo_Details where pw_packid='$pack_id'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function select_planned_date($proj_id, $pack_id, $stage_id) {
        $sql = "SELECT revised_planned_date,ps_expdate FROM swift_packagestatus WHERE  ps_stageid='$stage_id' AND ps_projid='$proj_id' AND ps_packid='$pack_id'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function select_technical_approval($id, $uid) {
        if ($id != "") {
            $sql = "SELECT tech_id,tech_packid,tech_projid,tech_senderuid,tech_recvuid,tech_sendr_stageid,tech_recv_stageid,tech_sentdate,tech_planneddate,tech_remarks,
                    ps_planneddate as org_plandate,revised_planned_date as rev_planned_date,ps_expdate,ps_actualdate,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date
                    FROM swift_techapproval,swift_packagestatus,swift_packagemaster WHERE ps_packid=tech_packid AND pm_packid=tech_packid AND ps_stageid='27'  
                    AND  swift_techapproval.tech_status = '2' AND tech_active='1' AND tech_projid='$id'  AND tech_recvuid='$uid'";
        } else {
            $sql = "SELECT tech_id,tech_packid,tech_projid,tech_senderuid,tech_recvuid,tech_sendr_stageid,tech_recv_stageid,tech_sentdate,tech_planneddate,tech_remarks,
                    ps_planneddate as org_plandate,revised_planned_date as rev_planned_date,ps_expdate,ps_actualdate,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date
                    FROM swift_techapproval,swift_packagestatus,swift_packagemaster WHERE ps_packid=tech_packid AND pm_packid=tech_packid AND ps_stageid='27'  
                    AND  swift_techapproval.tech_status = '2' AND tech_active='1' AND tech_recvuid='$uid'";
        }
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_allprojects_loi() {
        $sql = "select distinct proj_id,proj_name from Project,swift_filesfrom_smartsignoff where so_proj_id=proj_id order by proj_name asc";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_files_opswoentry($id, $segment) {
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,Project  
            WHERE  proj_id=so_proj_id and stage_id=ps_stageid and  so_pack_id=pm_packid AND so_pack_id=ps_packid AND active='1' AND work_order !='3' and cat_id='" . $segment . "' AND so_proj_id= '$id'";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,Project  
            WHERE  proj_id=so_proj_id and  stage_id=ps_stageid and so_pack_id=pm_packid AND so_pack_id=ps_packid AND active='1' AND work_order !='3' and cat_id='" . $segment . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_scmspoc_repo($id) {
        if ($id != "") {
            $sql = "SELECT sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_expdate,sc_actual,
            sc_remarks,sc_status,sc_active,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,revised_planned_date as planned_date,ps_expdate,ps_actualdate
            FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND sc_status='1' AND sc_active='1' AND sc_projid= '$id'";
        } else {
            $sql = "SELECT sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_expdate,sc_actual,
            sc_remarks,sc_status,sc_active,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,revised_planned_date as planned_date,ps_expdate,ps_actualdate
            FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND sc_status='1' AND sc_active='1'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function scm_repository($pid) {
        if ($pid == "") {
            $sql = "select COUNT(*) as scm_repo
                    from swift_SCMSPOC where  sc_status='1' AND sc_active='1'  ";
        } else {
            $sql = "select COUNT(*) as scm_repo
                    from swift_SCMSPOC where  sc_status='1' AND sc_active='1'  and sc_projid='" . $pid . "' ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['scm_repo'];
        return $count;
    }

    function over_allcount($pid) {
        if ($pid == "") {
            $sql = "select count (*) as overall from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id";
        } else {
            $sql = "select count (*) as overall from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['overall'];
        return $count;
    }

    function select_smartsignoff_buyer_repo($id, $uid) {
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER  
            WHERE stage_id=ps_stageid and  so_pack_id=pm_packid AND so_pack_id=ps_packid AND active='1' 
            AND po_wo_status ='4' AND so_proj_id= '$id' and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "'";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER 
            WHERE stage_id=ps_stageid and so_pack_id=pm_packid
            AND so_pack_id=ps_packid AND active='1' AND po_wo_status ='4' and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function scmbuyer_repository($pid, $uid) {
        if ($pid == "") {
            $sql = "SELECT COUNT(*) as buyer_repo FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER 
            WHERE stage_id=ps_stageid and so_pack_id=pm_packid
            AND so_pack_id=ps_packid AND active='1' and bu_status=1 and  po_wo_status ='4' and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "'  ";
        } else {
            $sql = "SELECT COUNT(*) as buyer_repo FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER 
            WHERE stage_id=ps_stageid and so_pack_id=pm_packid
            AND so_pack_id=ps_packid AND active='1' and bu_status=1 and  po_wo_status ='4' and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "' and so_proj_id='" . $pid . "' ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['buyer_repo'];
        return $count;
    }

    function sentbackfromcto($id, $uid) {
        if ($id != "") {
            $sql = "SELECT txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,ps_planneddate as org_plandate,ps_expdate,
            ps_actualdate,txp_expdate,txp_actual,txp_remarks,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '2' AND txp_active='1' AND txp_projid = '$id' AND txp_recvuid='$uid'";
        } else {
            $sql = "SELECT txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,ps_planneddate as org_plandate,ps_expdate,
            ps_actualdate,txp_expdate,txp_actual,txp_remarks,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '2' AND txp_active='1' AND txp_recvuid='$uid'";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function checkpo($packid) {
        $sql = "select * from swift_filesfrom_smartsignoff where po_wo_status ='4' and so_pack_id='" . $packid . "' ";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $po = 1;
        } else {
            $po = 0;
        }
        return $po;
    }

    function vendor_select() {
        $sql = "select * from vendor order by sup_name";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_lcmaster() {
        $sql = "select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity 
from swift_lcmaster as a,Vendor as b where a.lcm_venid=b.sup_id";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_rpamaster() {
        $sql = "select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.rpa_to) as validity 
from swift_rpamaster as a,Vendor as b where a.rpa_venid=b.sup_id";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function changelc($lcid) {
        $sql = "select   b.sup_name,a.*, DATEDIFF(DAY,a.lcm_from,a.lcm_to) as validity 
from swift_lcmaster as a,Vendor as b where a.lcm_venid=b.sup_id and a.lcm_id='" . $lcid . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function changerpa($rpaid) {
        $sql = "select   b.sup_name,a.*, DATEDIFF(DAY,a.rpa_from,a.rpa_to) as validity 
from swift_rpamaster as a,Vendor as b where a.rpa_venid=b.sup_id and a.rpa_id='" . $rpaid . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function check_pouploaded($packid) {
        $sql = "select * from swift_podetails where po_pack_id='" . $packid . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $pocheck = 1;
        } else {
            $pocheck = 0;
        }
        return $pocheck;
    }

    function itemname($rowid) {
        $sql = "select sdesc,itemcode from dbo.swift_podetails where swid='" . $rowid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function calculate_sunday($start, $end) {
        $no = 0;
        $start = new DateTime($start);
        $end = new DateTime($end);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start, $interval, $end);
        foreach ($period as $dt) {
            if ($dt->format('N') == 7) {
                $no++;
            }
        }
        return $no;
    }

    function select_allpackagescatte() {
        $sql = "select * from swift_package_category";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
   

    function fetch_buyername($packid) {
        $sql = "select name,bu_buyer_id from swift_SCMtoBUYER,usermst where bu_packid='" . $packid . "' and bu_buyer_id=uid and bu_status>=1  ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $name = $row['name'];
        return $name;
    }

    function send_email($proj_id, $pack_id, $recvstageid, $recvid) {
        require '../PHPMailer/PHPMailerAutoload.php';
        $sql = "select proj_name,pm_packagename,stage_name,revised_planned_date from swift_packagestatus,Project,swift_packagemaster,swift_stage_master
where ps_packid=pm_packid and ps_projid=proj_id and ps_stageid=stage_id and ps_packid='" . $pack_id . "' and ps_projid='" . $proj_id . "' and ps_stageid='" . $recvstageid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $proj_name = $row['proj_name'];
        $pack_name = $row['pm_packagename'];
        $stage_name = $row['stage_name'];
        $planneddate = formatDate($row['revised_planned_date'], 'd-M-Y');

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
                                        <th style=" padding:5px;  text-align: center; background-color:#285229; color:white;  border: 1px solid #ddd;">Project Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#285229; color:white;  border: 1px solid #ddd;">Package Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#285229; color:white;  border: 1px solid #ddd;">Sent From</th>
                                        <th style=" padding:5px; text-align: center; background-color:#285229; color:white;  border: 1px solid #ddd;">Stage Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#285229; color:white;  border: 1px solid #ddd;">Stage Planned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $proj_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pack_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $_SESSION['uname'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $stage_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $planneddate . '</td>
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
        $sql = mssql_query("select * from usermst where uid='" . $recvid . "'");
        $row = mssql_fetch_array($sql);
        $email = $row['uname'];
        //    $email = 'srini.rpsm@gmail.com';
        //  $name = $row['name'];

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settingss
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            //Server settingss
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
            $mail->Password = '!Lntswc123';                      // SMTP password
//        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;
            // TCP port to connect to
            //Recipients
            $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
             $mail->addAddress($email, $name); // Add a recipient
             $mail->addAddress('uuk@lntecc.com', 'SWIFT'); // Add a recipient
            //$mail->addBCC('srini.rpsm@gmail.com'); // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            //Attachments
            // $mail->addAttachment('C:/xampp/htdocs/QA/fpdf/status_pdf/'.$filename);                    // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');// Optional name
            //Content
            $mail->isHTML(true);                                 // Set email format to HTML
            // $mail->AddEmbeddedImage('logo.png', 'logoimg'); // attach file logo.jpg, and later link to it using identfier logoimg

            $mail->Subject = 'Swift';
            $mail->Body = $message;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            $Msg = "Mail Send";
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            $Msg = "Mail Not Send";
        }
    }

    function select_ckaddon() {
        $sql = "select * from swift_checklistaddon";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function filldates($id, $pid) {
        $sql = "select * from swift_checklistaddon as A 
left join  swift_checklist_docs as b on b.clk_id=A.ck_id
where ck_projid='$pid' and clk_id='$id' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function projtype($id) {
        $sql = "select * from SwiftType and id='$id' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function select_ckstatus($eid) {
        $sql = "select * from swift_checklist_docs where ck_projid='" . $eid . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        $s = '';
        if ($num_rows > 0) {
            $sql1 = "select * from swift_checklist_docs where clk_id=10 and cd_status=1 and ck_projid='" . $eid . "'";
            $query1 = mssql_query($sql1);
            $num_rows1 = mssql_num_rows($query1);
            if ($num_rows1 > 0) {
                $s = 1;
            } else {
                $s = 0;
            }
        } else {
            $s = 2;
        }
        return $s;
    }

    function name($uid, $pid) {
        $sql = "select name,txp_remarks from swift_techexpert,usermst where txp_recvuid=uid and txp_senderuid='" . $uid . "' and txp_active=1 and txp_packid='" . $pid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function sendback_email($proj_id, $pack_id, $recvstageid, $recvid) {
        require '../PHPMailer/PHPMailerAutoload.php';
        $sql = "select proj_name,pm_packagename,stage_name,revised_planned_date from swift_packagestatus,Project,swift_packagemaster,swift_stage_master
where ps_packid=pm_packid and ps_projid=proj_id and ps_stageid=stage_id and ps_packid='" . $pack_id . "' and ps_projid='" . $proj_id . "' and ps_stageid='" . $recvstageid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $proj_name = $row['proj_name'];
        $pack_name = $row['pm_packagename'];
        $stage_name = $row['stage_name'];
        $planneddate = formatDate($row['revised_planned_date'], 'd-M-Y');
        
                $sql1 = mssql_query("select * from usermst where uid='" . $recvid . "'");
        $row1 = mssql_fetch_array($sql1);
        $emailk = $row1['uname'];
       

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

                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; Margin-bottom: 15px;">The Following files has been sent back to your flow for action.</p>
                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; ">Please use the below links to view </p>
                            <p  style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal;   Margin-bottom: 15px;"> <a href="https://swc.ltts.com/swift" target="blank">Link - SWIFT</a></p>
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                                <thead >
                                    <tr>
                                        <th style=" padding:5px;  text-align: center; background-color:#933A16; color:white;  border: 1px solid #ddd;">Project Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#933A16; color:white;  border: 1px solid #ddd;">Package Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#933A16; color:white;  border: 1px solid #ddd;">Sent From</th>
                                        <th style=" padding:5px; text-align: center; background-color:#933A16; color:white;  border: 1px solid #ddd;">Stage Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#933A16; color:white;  border: 1px solid #ddd;">Stage Planned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $proj_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pack_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $_SESSION['uname'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $stage_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $planneddate . '</td>
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

//         $email = 'srini.rpsm@gmail.com';
//         $name = $row['name'];

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settingss
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            //Server settingss
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
            $mail->Password = '!Lntswc123';                      // SMTP password
//        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;
            // TCP port to connect to
            //Recipients
            $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
             $mail->addAddress($emailk, $name); // Add a recipient
            $mail->addAddress('uuk@lntecc.com', 'SWIFT'); // Add a recipient
            //$mail->addBCC('srini.rpsm@gmail.com'); // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            //Attachments
            // $mail->addAttachment('C:/xampp/htdocs/QA/fpdf/status_pdf/'.$filename);                    // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');// Optional name
            //Content
            $mail->isHTML(true);                                 // Set email format to HTML
            // $mail->AddEmbeddedImage('logo.png', 'logoimg'); // attach file logo.jpg, and later link to it using identfier logoimg

            $mail->Subject = 'SWIFT';
            $mail->Body = $message;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $isql = mssql_query("select isnull (max(sms_id+1),1) as id from  sms_tracking");
            $row = mssql_fetch_array($isql);
            $sid = $row['id'];
            $sql = mssql_query("insert into sms_tracking (sms_id,sms_userid,sms_email,sent_date,_type)"
                    . "values('" . $sid . "','" . $recvid . "','" . $email . "',GETDATE(),'1')");
            $mail->send();
            $Msg = "Mail Send";
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            $Msg = "Mail Not Send";
        }
    }

    function send_email_tech($proj_id, $pack_id, $recvstageid, $recvid) {
        require '../PHPMailer/PHPMailerAutoload.php';
        $sql = "select cat_id,proj_name,pm_packagename,stage_name,revised_planned_date from swift_packagestatus,Project,swift_packagemaster,swift_stage_master
where ps_packid=pm_packid and ps_projid=proj_id and ps_stageid=stage_id and ps_packid='" . $pack_id . "' and ps_projid='" . $proj_id . "' and ps_stageid='" . $recvstageid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $proj_name = $row['proj_name'];
        $pack_name = $row['pm_packagename'];
        $stage_name = $row['stage_name'];
        $planneddate = formatDate($row['revised_planned_date'], 'd-M-Y');
        $segment_sql = mssql_query("select cat_id from Project where proj_id='" . $proj_id . "'");
        $sqry = mssql_fetch_array($segment_sql);
        $segment = $sqry['cat_id'];
        if ($segment == 37) {
            $cc = 'J-SRIDHAR@lntecc.com';
        } else {
            $cc = 'shankaranr@lntecc.com';
        }
          $sql1 = mssql_query("select * from usermst where uid='" . $recvid . "'");
        $row1 = mssql_fetch_array($sql1);
        $email = $row1['uname'];
     // return $email; exit();
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
                                        <th style=" padding:5px;  text-align: center; background-color:#285229; color:white;  border: 1px solid #ddd;">Project Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#285229; color:white;  border: 1px solid #ddd;">Package Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#285229; color:white;  border: 1px solid #ddd;">Sent From</th>
                                        <th style=" padding:5px; text-align: center; background-color:#285229; color:white;  border: 1px solid #ddd;">Stage Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#285229; color:white;  border: 1px solid #ddd;">Stage Planned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $proj_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pack_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $_SESSION['uname'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $stage_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $planneddate . '</td>
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
     
        
 
//        $email = 'srini.rpsm@gmail.com';
//        $name = $row['name'];

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settingss
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            //Server settingss
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
            $mail->Password = '!Lntswc123';                      // SMTP password
//        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;
            // TCP port to connect to
            //Recipients
            $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
            $mail->addAddress($email, $name); // Add a recipient
            $mail->addAddress('uuk@lntecc.com', 'SWIFT'); // Add a recipient
            //$mail->addAddress('srini.rpsm@gmail.com'); // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC($cc);
           // $mail->addBCC('srini.rpsm@gmail.com');
            //Attachments
            // $mail->addAttachment('C:/xampp/htdocs/QA/fpdf/status_pdf/'.$filename);                    // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');// Optional name
            //Content
            $mail->isHTML(true);                                 // Set email format to HTML
            // $mail->AddEmbeddedImage('logo.png', 'logoimg'); // attach file logo.jpg, and later link to it using identfier logoimg

            $mail->Subject = 'SWIFT';
            $mail->Body = $message;

            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            $Msg = "Mail Send";
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            $Msg = "Mail Not Send";
        }
    }
	 function current_status($packid) {
        $sql = "select b.name,b.usertype,c.shot_name,a.* from  dbo.swift_packagestatus as a
left join usermst as b on a.ps_userid=b.uid
left join swift_stage_master as c on a.ps_stageid=c.stage_id  
where  a.active=1  and a.ps_packid='" . $packid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        $sent_back = $row['ps_stback'];
        $utype = $row['usertype'];
        if ($sent_back == 1) {
            if ($utype == 10) {
                $sent = 'Tech SPOC';
            } else if ($utype == 11) {
                $sent = 'Tech Expert';
            } else if ($utype == 12) {
                $sent = 'Tech CTO';
            } else if ($utype == 14) {
                $sent = 'SCM SPOC';
            } else if ($utype == 15) {
                $sent = 'OM SPOC';
            } else if ($utype == 5) {
                $sent = 'OPS';
            }
            $status = 'Sent back by ' . $sent . '<br>(' . $row['name'] . ')';
        } else {
            if ($row['name'] == "") {
                $status = $row['shot_name'];
            } else {
                $status = $row['shot_name'] . '<br>(' . $row['name'] . ')';
            }
        }
        return $status;
    }

    function fetch_usertype($uid) {
        $sql = "select * from usermst where uid='$uid' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        $utype=$row['usertype'];
        return $utype;
    }

}

?>