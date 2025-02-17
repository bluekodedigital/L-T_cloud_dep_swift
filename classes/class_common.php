<?php

class Common
{

    function select_segment($seg)
    {
        if ($seg == '') {
            $cond = " where seg_pid!=38";
        } else {
            $cond = " where seg_pid=" . $seg . "";
        }
        echo $sql = "select * from segment_master $cond";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    /* 	function view_date($id) {
		$id=$id;
		
        $sql = "select revised_planned_date from swift_packagestatus where ps_stageid='$id'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row[];
        }
        $res = json_encode($result);
        return $res;
    } */
    function stage_master()
    {

        $stagemaster = "select * from swift_stage_master order by display_order asc";
        $stage_query = mssql_query($stagemaster);
        $results = array();
        while ($row = mssql_fetch_assoc($stage_query)) {
            $results[] = $row;
        }
        $res = json_encode($results);
        return $res;
    }
    function WorkFlowStage_master($Did)
    {

        $stagemaster = "select * from swift_workflow_details as a
         left join swift_stage_master as b on a.stage_id=b.stage_id
         where a.mst_id = $Did  and a.stage_id!=1 order by a.Did ";
        $stage_query = mssql_query($stagemaster);
        $results = array();
        while ($row = mssql_fetch_assoc($stage_query)) {
            $results[] = $row;
        }
        $res = json_encode($results);
        return $res;
    }
    function workflow_details()
    {

        $stagemaster = "select * from swift_workflow_Master";
        $stage_query = mssql_query($stagemaster);
        $results = array();
        while ($row = mssql_fetch_assoc($stage_query)) {
            $results[] = $row;
        }
        $res = json_encode($results);
        return $res;
    }

    function select_allprojects($seg)
    {
        if ($seg == '') {
            $cond = " where cat_id!=38";
        } else {
            $cond = " where cat_id=" . $seg . "";
        }
        $sql = "select * from Project $cond order by proj_name ASC";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_projects($id)
    {
        $sql = "select * from Project where proj_id = $id";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_segment_id($id)
    {
        $sql = "select * from segment_master where seg_pid='" . $id . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function datechange($date)
    {
        $date = date_create($date);
        $date = date_format($date, "d-M-y");
        return $date;
    }

    function select_table($table)
    {
        $sql = "select * from $table";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_project_notpackage($pid, $segment)
    {
        if ($pid == "") {
            $sql = "select * from Project,usermst where package_status in(0,1) and creator_id=uid  and cat_id='" . $segment . "' order by Project.proj_id DESC";
        } else {
            $sql = "select * from Project,usermst where package_status in(0,1) and creator_id=uid and cat_id='" . $segment . "' and Project.proj_id='" . $pid . "' order by Project.proj_id DESC";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_allpackages($pid, $segment)
    {
        if ($pid == "") {
            //  $sql = "select pm_packid,pm_projid,proj_name,pm_packagename,pm_createdate,pm_material_req,pm_revised_material_req,pm_leadtime,pm_userid 
            //     from swift_packagemaster,Project where proj_id=pm_projid and cat_id='" . $segment . "'";
                $sql = "select pm_packid,pm_projid,proj_name,pm_packagename,pm_createdate,pm_material_req,pm_revised_material_req,pm_leadtime,pm_userid 
                from swift_packagemaster,Project where proj_id=pm_projid ";
        } else {
             $sql = "select pm_packid,pm_projid,proj_name,pm_packagename,pm_createdate,pm_material_req,pm_revised_material_req,pm_leadtime,pm_userid 
                from swift_packagemaster,Project where proj_id=pm_projid  and proj_id='" . $pid . "'";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_packcount($pid,$packid) {
        if ($pid == "") {
             $sql = "select count(st_id) as row_count from swift_transactions where st_packid='$packid'";
        } else {
            $sql = "select count(st_id) as row_count from swift_transactions where st_packid='$packid' and st_projid='$pid' ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['row_count'];
        return $count;
    }

    function sendtospoc($segment)
    {
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

    function sendtospocdata($pack_id)
    {
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

    function select_allprojects_seg($segment)
    {
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
    function dash_filter($seg)
    {
        if ($seg != '') {
            $cond = " and cat_id=38";
        } else {
            $cond = "  and cat_id!=38";
        }
        $sql = "SELECT  distinct proj_id,proj_name FROM project,swift_packagestatus WHERE proj_id=ps_projid " . $cond . "";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function sendtospoc_projfilter($pid, $segment)
    {
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

    function select_allomproject($segment)
    {
        if ($segment != '') {
            $cond = " AND cat_id='" . $segment . "'";
        } else {
            $cond = "";
        }
        $sql = "select distinct proj_id,ps_projid,proj_name from swift_packagestatus,Project where proj_id=ps_projid $cond";
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
    function select_stages($id)
    {
        $sql = "select * from swift_stage_master where stage_id = $id";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    //Uma
    function select_allstages($sendback)
    {
        $sql = "select * from swift_stage_master where stage_id in($sendback)";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    //Uma
    function getusername_stage($packid, $stageid, $pid)
    {

        //$sql = "select * from usermst where usertype in('" . $usertype . "') and active = 1";
          $sql = " select uid,name from swift_stage_master as a 
        inner join usermst as u on u.usertype=a.usertype 
        where a.stage_id='$stageid'  and  u.active = 1";
        // echo   $sql = " select uid,name from swift_stage_master as a 
        // inner join swift_packagestatus as b on b.ps_stageid=a.stage_id 
        // inner join usermst as u on u.usertype=a.usertype and b.ps_userid=u.uid
        // where a.stage_id='$stageid' and ps_packid='$packid' and ps_projid='$pid' and  u.active = 1";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
     function getusername_backstage($packid, $stageid, $pid)
    {

        //$sql = "select * from usermst where usertype in('" . $usertype . "') and active = 1";
        //   $sql = " select uid,name from swift_stage_master as a 
        // inner join usermst as u on u.usertype=a.usertype 
        // where a.stage_id='$stageid'  and  u.active = 1";
            $sql = " select uid,name from swift_stage_master as a 
        inner join swift_packagestatus as b on b.ps_stageid=a.stage_id 
        inner join usermst as u on u.usertype=a.usertype and b.ps_userid=u.uid
        where a.stage_id='$stageid' and ps_packid='$packid' and ps_projid='$pid' and  u.active = 1";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi 
    function select_swift_workflow($id, $segment)
    {
        // if ($segment != "") {
        //     $cond = " AND cat_id in($segment)";
        // } else {
        //     $cond = " AND cat_id!='38'";
        // }
         $senduserid  = $_SESSION['uid'];
        $usertype    = $_SESSION['usertype'];
        if ($usertype == 2) {
            $where = "and to_stage_id='13'";
        } else {
            $where = '';
        }
        if ($id != "") {
            //   echo  $sql = "SELECT ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ps_planneddate as org_plandate,ps_expdate,
            //     ps_actualdate,ts_expdate,ts_actual,ts_remarks,ts_status,ts_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date
            //     FROM swift_techspoc,swift_packagestatus,swift_packagemaster,Project WHERE ts_status = '0' AND ts_active = '1' AND ps_stageid = '3' and ts_packid=ps_packid and ts_packid=pm_packid AND ts_projid= '$id' and ts_packid=pm_packid and proj_id=ts_projid and cat_id in($segment)";
            $sql = "SELECT  d.proj_type,c.hold_on,(isnull(DATEDIFF(DAY,ps_actualdate,GETDATE()),0)) as nodays,ps_stback,pm_stages,cs_packid,cs_projid,from_uid,to_uid,from_stage_id,to_stage_id, ps_planneddate as 
            org_plandate,ps_expdate, ps_actualdate,cs_actual,cs_created_date as cs_sentdate, from_remark,to_remark, 
            cs_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req
             as mat_req_date,lt_flag  from swift_workflow_CurrentStage as a
             inner join swift_packagestatus as b on a.cs_packid=b.ps_packid and a.cs_projid=b.ps_projid
             inner join swift_packagemaster as c on c.pm_packid=b.ps_packid and a.cs_projid=c.pm_projid
             inner join Project as d on a.cs_projid=d.proj_id 
             where  to_stage_id=ps_stageid and cs_active = '0' and  to_uid = '$senduserid'  and  cs_projid= $id $where";
        } else {
           $sql = "SELECT   d.proj_type,c.hold_on,(isnull(DATEDIFF(DAY,ps_actualdate,GETDATE()),0)) as nodays,ps_stback,pm_stages,cs_packid,cs_projid,from_uid,to_uid,from_stage_id,to_stage_id, ps_planneddate as 
            org_plandate,ps_expdate, ps_actualdate,cs_actual,cs_created_date as cs_sentdate, from_remark,to_remark, 
            cs_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req
             as mat_req_date,lt_flag  from swift_workflow_CurrentStage as a
             inner join swift_packagestatus as b on a.cs_packid=b.ps_packid and a.cs_projid=b.ps_projid
             inner join swift_packagemaster as c on c.pm_packid=b.ps_packid and a.cs_projid=c.pm_projid
             inner join Project as d on a.cs_projid=d.proj_id 
             where  to_stage_id=ps_stageid and cs_active = '0' and  to_uid = '$senduserid' $where";
        }
       //print_r($sql);
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_swiftsendback_workflow($id, $segment)
    {

        $senduserid = $_SESSION['uid'];
        if ($id != "") {
            //   echo  $sql = "SELECT ts_id,ts_packid,ts_projid,ts_senderuid,ts_recvuid,ts_sendr_stageid,ts_recv_stageid,ts_sentdate,ps_planneddate as org_plandate,ps_expdate,
            //     ps_actualdate,ts_expdate,ts_actual,ts_remarks,ts_status,ts_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date
            //     FROM swift_techspoc,swift_packagestatus,swift_packagemaster,Project WHERE ts_status = '0' AND ts_active = '1' AND ps_stageid = '3' and ts_packid=ps_packid and ts_packid=pm_packid AND ts_projid= '$id' and ts_packid=pm_packid and proj_id=ts_projid and cat_id in($segment)";
            $sql = "SELECT   d.proj_type,c.hold_on,(isnull(DATEDIFF(DAY,ps_actualdate,GETDATE()),0)) as nodays,ps_stback,pm_stages,cs_packid,cs_projid,from_uid,to_uid,from_stage_id,to_stage_id, ps_planneddate as 
            org_plandate,ps_expdate, ps_actualdate,cs_actual,cs_created_date as cs_sentdate, from_remark,to_remark, 
            cs_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req
             as mat_req_date,lt_flag  from swift_workflow_CurrentStage as a
             inner join swift_packagestatus as b on a.cs_packid=b.ps_packid and a.cs_projid=b.ps_projid
             inner join swift_packagemaster as c on c.pm_packid=b.ps_packid and a.cs_projid=c.pm_projid
             inner join Project as d on a.cs_projid=d.proj_id 
             where  to_stage_id=ps_stageid and cs_active = '1' and  to_uid = '$senduserid'  and  cs_projid= $id  ";
        } else {
            // echo   $sql = "SELECT proj_type, hold_on,(isnull(DATEDIFF(DAY,ps_actualdate,GETDATE()),0)) as nodays,ps_stback,pm_stages,cs_packid,cs_projid,from_uid,to_uid,from_stage_id,to_stage_id, ps_planneddate as
            // org_plandate,ps_expdate, ps_actualdate,cs_actual,cs_created_date as cs_sentdate, from_remark,to_remark,
            // cs_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req 
            // as mat_req_date FROM swift_workflow_CurrentStage, swift_packagestatus,swift_packagemaster,Project 
            // WHERE cs_active = '1' and to_stage_id =ps_stageid and to_uid = '$senduserid' and cs_packid=ps_packid  
            // AND  cs_packid=pm_packid AND cs_packid=pm_packid AND proj_id=cs_projid ";
             $sql = "SELECT   d.proj_type,c.hold_on,(isnull(DATEDIFF(DAY,ps_actualdate,GETDATE()),0)) as nodays,ps_stback,pm_stages,cs_packid,cs_projid,from_uid,to_uid,from_stage_id,to_stage_id, ps_planneddate as 
            org_plandate,ps_expdate, ps_actualdate,cs_actual,cs_created_date as cs_sentdate, from_remark,to_remark, 
            cs_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req
             as mat_req_date,lt_flag  from swift_workflow_CurrentStage as a
             inner join swift_packagestatus as b on a.cs_packid=b.ps_packid and a.cs_projid=b.ps_projid
             inner join swift_packagemaster as c on c.pm_packid=b.ps_packid and a.cs_projid=c.pm_projid
             inner join Project as d on a.cs_projid=d.proj_id 
             where  to_stage_id=ps_stageid and cs_active = '1' and  to_uid = '$senduserid' ";
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
    function select_swift_repository($id, $uid, $seg)
    {

        if ($seg != '') {
            $cond = " and cat_id=38";
        } else {
            $cond = " and cat_id!=38";
        }
        if ($id != "") {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' AND ts_projid= '$id'";
            $sql = "SELECT distinct e.proj_type,cs_packid,cs_projid,ps_stageid,to_uid,from_uid,to_stage_id,from_stage_id,
            cs_created_date,ps_planneddate as org_plandate, ps_expdate,ps_actualdate,cs_expdate, ps_stageid,cs_actual,
             to_remark,cs_active,revised_planned_date as rev_planned_date, pm_material_req as schedule_date,
             pm_revised_material_req as mat_req_date
             from swift_repository as a
            inner join swift_packagestatus as b on a.rs_packid=b.ps_packid and a.rs_projid=b.ps_projid
            inner join swift_packagemaster as c on a.rs_packid=c.pm_packid and a.rs_projid=c.pm_projid
            inner join swift_workflow_CurrentStage d on a.rs_packid=d.cs_packid and a.rs_projid=d.cs_projid
            inner join project as e on a.rs_projid=e.proj_id WHERE 
                    active = '1' and rs_projid= '$id' $cond AND (rs_to_uid='$uid' OR rs_from_uid='$uid') ";
        } else {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' ";
            //   echo  $sql = "SELECT  rsid,rs_packid,rs_projid,rs_to_uid,rs_from_uid,
            // rs_to_stage,rs_from_stage,rs_created_date,ps_planneddate 
            // as org_plandate, ps_expdate,ps_actualdate,rs_expdate,ps_stageid,rs_actual,
            // rs_to_remark,rs_active,revised_planned_date as rev_planned_date,
            // pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            // FROM swift_repository,swift_packagestatus,swift_packagemaster,project WHERE 
            //  active = '1' and rs_packid=ps_packid 
            // AND rs_packid=pm_packid AND pm_projid=proj_id AND rs_to_uid='$uid' $cond";
             $sql = "SELECT distinct e.proj_type,cs_packid,cs_projid,ps_stageid,to_uid,from_uid,to_stage_id,from_stage_id,
             cs_created_date,ps_planneddate as org_plandate, ps_expdate,ps_actualdate,cs_expdate, ps_stageid,cs_actual,
              to_remark,cs_active,revised_planned_date as rev_planned_date, pm_material_req as schedule_date,
              pm_revised_material_req as mat_req_date
              from swift_repository as a
             inner join swift_packagestatus as b on a.rs_packid=b.ps_packid and a.rs_projid=b.ps_projid
             inner join swift_packagemaster as c on a.rs_packid=c.pm_packid and a.rs_projid=c.pm_projid
             inner join swift_workflow_CurrentStage d on a.rs_packid=d.cs_packid and a.rs_projid=d.cs_projid
             inner join project as e on a.rs_projid=e.proj_id WHERE active = '1'   $cond AND (rs_to_uid='$uid' OR rs_from_uid='$uid')";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    //distributor
    function select_swift_distributor($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " and cat_id=38";
        } else {
            $cond = " and cat_id!=38";
        }
        if ($id != "") {
             $sql = "SELECT distinct c.proj_type,a.pw_packid,a.pw_projid,proj_name,pm_packagename,po_no,po_approved_on,wo_no,wo_approved_on
            from Swift_po_wo_Details as a
            inner join project as c on a.pw_projid=c.proj_id
            inner join swift_packagemaster as d on a.pw_packid=d.pm_packid
            where po_complete=1 and  pw_projid= '$id' order by a.pw_packid desc ";
        } else {
            $sql = "SELECT distinct c.proj_type,a.pw_packid,a.pw_projid,proj_name,pm_packagename,po_no,po_approved_on,wo_no,wo_approved_on
            from Swift_po_wo_Details as a
            inner join project as c on a.pw_projid=c.proj_id
            inner join swift_packagemaster as d on a.pw_packid=d.pm_packid
            where po_complete=1  order by a.pw_packid desc";
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
    function select_techexpert_workflow($id, $uid)
    {
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
    function select_techexpert_repository($id, $uid, $seg)
    {
        if ($seg == '') {
            $cond = " AND cat_id!='38'";
        } else {
            $cond = " AND cat_id='38'";
        }
        if ($id != "") {
            $sql = "SELECT txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,ps_planneddate as org_plandate,ps_expdate,ps_stageid,
            ps_actualdate,txp_expdate,txp_actual,txp_remarks,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            FROM swift_techexpert,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND pm_projid=proj_id AND txp_status = '1' AND txp_active='1' AND txp_projid = '$id' AND txp_recvuid='$uid' $cond";
        } else {
            $sql = "SELECT txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,ps_planneddate as org_plandate,ps_expdate,ps_stageid,
            ps_actualdate,txp_expdate,txp_actual,txp_remarks,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            FROM swift_techexpert,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND pm_projid=proj_id AND txp_status = '1' AND txp_active='1' AND txp_recvuid='$uid' $cond";
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
    function select_techCTO_workflow($id)
    {
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

    function select_techCTO_repository($id)
    {
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
    function select_scmspoc($id, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_expdate,sc_actual,
            sc_remarks,sc_status,sc_active,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,revised_planned_date as planned_date,ps_expdate,ps_actualdate
            FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND pm_projid=proj_id AND sc_status='0' AND sc_active='1' AND sc_projid= '$id' $cond";
        } else {
            $sql = "SELECT sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_expdate,sc_actual,
            sc_remarks,sc_status,sc_active,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,revised_planned_date as planned_date,ps_expdate,ps_actualdate
            FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND pm_projid=proj_id  AND sc_status='0' AND sc_active='1' $cond";
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
    function select_frombuyer($id, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = "  AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT bu_id,bu_packid,bu_projid,bu_buyer_id as sender_id,bu_sentdate,bu_ace_value,bu_sales_value,sb_remarks,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate
            FROM swift_SCMtoBUYER,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '13' AND bu_packid=ps_packid AND bu_packid=pm_packid AND pm_projid=proj_id AND bu_status='2' AND bu_projid= '$id' $cond";
        } else {
            $sql = "SELECT bu_id,bu_packid,bu_projid,bu_buyer_id as sender_id,bu_sentdate,bu_ace_value,bu_sales_value,sb_remarks,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate
            FROM swift_SCMtoBUYER,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '13' AND bu_packid=ps_packid AND bu_packid=pm_packid AND pm_projid=proj_id AND bu_status='2' $cond";
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
    function select_smartsignoff($id, $uid, $utype, $seg)
    {
        if ($seg != '') {
            $cond1 = " AND cat_id='38'";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($utype == '20') {
            $cond = "";
        } else {
            $cond = " and bu_buyer_id='" . $uid . "'";
        }

        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER,Project  
            WHERE stage_id=ps_stageid and  so_pack_id=pm_packid AND so_pack_id=ps_packid AND pm_projid=proj_id AND ps_stageid=20
            AND (so_hw_sw=2 and po_wo_status ='0' or so_hw_sw=3 and po_wo_status ='2' ) AND so_proj_id= '$id' and bu_packid=so_pack_id " . $cond . " " . $cond1 . "";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER,Project
            WHERE stage_id=ps_stageid and so_pack_id=pm_packid AND pm_projid=proj_id and ps_stageid=20
            AND (so_hw_sw=2 and po_wo_status ='0' or so_hw_sw=3 and po_wo_status ='2' ) and  so_pack_id=ps_packid and bu_packid=so_pack_id " . $cond . " " . $cond1 . "";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_smartsignoff1($id, $uid, $utype, $seg)
    {
        if ($seg != '') {
            $cond1 = " AND cat_id='38'";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        // if ($utype == '20') {
        //     $cond = "";
        // } else {
        //     $cond = " and bu_buyer_id='" . $uid . "'";
        // }
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER,project,swift_workflow_CurrentStage
            WHERE stage_id=ps_stageid and  so_pack_id=pm_packid AND pm_projid=proj_id AND so_pack_id=ps_packid and to_uid=$uid and ps_stageid=15  and cs_packid=ps_packid
             AND so_proj_id= '$id' and bu_packid=so_pack_id  " . $cond1 . "";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER,project,swift_workflow_CurrentStage 
            WHERE stage_id=ps_stageid and so_pack_id=pm_packid AND pm_projid=proj_id  and to_uid=$uid and cs_packid=ps_packid and  so_pack_id=ps_packid and ps_stageid=15  AND po_wo_status !='4' and bu_packid=so_pack_id  " . $cond1 . "";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_swiftpo($pid, $uid, $seg)
    {
        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($pid == "") {
            $sql = "SELECT proj_type,cs_created_date,po_wo_status,pw_id,pm_packid,pm_projid,from_uid,proj_name,pm_packagename,ps_stageid,stage_name,revised_planned_date as planned_date,GETDATE() as actual,
            ps_expdate,pm_material_req  as schedule_date ,pm_revised_material_req as mat_req_date from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            inner join swift_packagemaster as c on a.pw_packid = c.pm_packid and a.pw_projid=c.pm_projid
            inner join swift_stage_master as g on g.stage_id=14 
            where  a.flag=1 and a.emr_flag=1 and  d.active='1' and to_uid='$uid' and  ( a.po_wo_status ='1'or a.po_wo_status ='3') ";
        } else {
            $sql = "SELECT proj_type,cs_created_date,po_wo_status,pw_id,pm_packid,pm_projid,from_uid,proj_name,pm_packagename,ps_stageid,stage_name,revised_planned_date as planned_date,GETDATE() as actual,
            ps_expdate,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as  p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            inner join swift_packagemaster as c on a.pw_packid = c.pm_packid and a.pw_projid=c.pm_projid
            inner join swift_stage_master as g on g.stage_id=14 
            where  a.flag=1 and a.emr_flag=1 and  d.active='1' and to_uid='$uid'
            AND so_proj_id= '$pid' $cond1  and  ( a.po_wo_status ='1'or a.po_wo_status ='3') ";
        }


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_swiftpo_app($pid, $uid, $seg)
    {
        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($pid == "") {
            $sql = "SELECT ps_remarks,cs_created_date,po_wo_status,pw_id,pm_packid,pm_projid,from_uid,proj_name,pm_packagename,ps_stageid,stage_name,revised_planned_date as planned_date,GETDATE() as actual,
            ps_expdate,pm_material_req  as schedule_date ,pm_revised_material_req as mat_req_date from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            inner join swift_packagemaster as c on a.pw_packid = c.pm_packid and a.pw_projid=c.pm_projid
            inner join swift_stage_master as g on g.stage_id=15 
            where  a.flag=2 and a.emr_flag=1 and  d.active='1' and to_uid='$uid' and  ( a.po_wo_status ='1'or a.po_wo_status ='3') ";
        } else {
            $sql = "SELECT ps_remarks,cs_created_date,po_wo_status,pw_id,pm_packid,pm_projid,from_uid,proj_name,pm_packagename,ps_stageid,stage_name,revised_planned_date as planned_date,GETDATE() as actual,
            ps_expdate,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as  p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            inner join swift_packagemaster as c on a.pw_packid = c.pm_packid and a.pw_projid=c.pm_projid
            inner join swift_stage_master as g on g.stage_id=15 
            where  a.flag=2 and a.emr_flag=1 and  d.active='1' and to_uid='$uid'
            AND so_proj_id= '$pid' $cond1  and  ( a.po_wo_status ='1'or a.po_wo_status ='3') ";
        }


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_swiftwo_app($pid, $uid, $seg)
    {
        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($pid == "") {
            $sql = "SELECT proj_type,cs_created_date,po_wo_status,pw_id,pm_packid,pm_projid,from_uid,proj_name,pm_packagename,ps_stageid,stage_name,revised_planned_date as planned_date,GETDATE() as actual,
            ps_expdate,pm_material_req  as schedule_date ,pm_revised_material_req as mat_req_date from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            inner join swift_packagemaster as c on a.pw_packid = c.pm_packid and a.pw_projid=c.pm_projid
            inner join swift_stage_master as g on g.stage_id=15 
            where  a.wo_flag=2  and  d.active='1' and to_uid='$uid' and  ( a.po_wo_status ='2'or a.po_wo_status ='3') ";
        } else {
            $sql = "SELECT proj_type,cs_created_date,po_wo_status,pw_id,pm_packid,pm_projid,from_uid,proj_name,pm_packagename,ps_stageid,stage_name,revised_planned_date as planned_date,GETDATE() as actual,
            ps_expdate,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as  p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            inner join swift_packagemaster as c on a.pw_packid = c.pm_packid and a.pw_projid=c.pm_projid
            inner join swift_stage_master as g on g.stage_id=15 
            where  a.wo_flag=2  and  d.active='1' and to_uid='$uid'
            AND so_proj_id= '$pid' $cond1  and  ( a.po_wo_status ='2'or a.po_wo_status ='3') ";
        }


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_swiftwo($pid, $uid, $seg)
    {
        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($pid == "") {
            $sql = "SELECT proj_type,cs_created_date,po_wo_status,pw_id,pm_packid,pm_projid,from_uid,proj_name,pm_packagename,ps_stageid,stage_name,revised_planned_date as planned_date,GETDATE() as actual,
            ps_expdate,pm_material_req  as schedule_date ,pm_revised_material_req as mat_req_date from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            inner join swift_packagemaster as c on a.pw_packid = c.pm_packid and a.pw_projid=c.pm_projid
            inner join swift_stage_master as g on g.stage_id=14 
            where  a.wo_flag=1 and d.active='1' and to_uid='$uid' and  ( a.po_wo_status ='2'or a.po_wo_status ='3') ";
        } else {
            $sql = "SELECT proj_type,cs_created_date,po_wo_status,pw_id,pm_packid,pm_projid,from_uid,proj_name,pm_packagename,ps_stageid,stage_name,revised_planned_date as planned_date,GETDATE() as actual,
            ps_expdate,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as  p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            inner join swift_packagemaster as c on a.pw_packid = c.pm_packid and a.pw_projid=c.pm_projid
            inner join swift_stage_master as g on g.stage_id=14 
            where  a.wo_flag=1  and  d.active='1' and to_uid='$uid'
            AND so_proj_id= '$pid' $cond1  and  ( a.po_wo_status ='2'or a.po_wo_status ='3') ";
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
    function select_lc($id)
    {
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
    function select_rpa($id)
    {
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
    function select_lc_repository($id)
    {
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

    function select_lc_newrepository($id)
    {
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

    function select_rpa_newrepository($id)
    {
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
    function select_rpa_repository($id)
    {
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

    function get_lc_data($id)
    {
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

    function get_rpa_data($id)
    {
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
    function project_name($id)
    {
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
    function package_name($id)
    {
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
    function cur_status_name($id)
    {
        $sql = "select shot_name from swift_packagestatus,swift_stage_master where ps_stageid=stage_id and active='1'  and ps_packid='$id'";
        $query = mssql_query($sql);
        if (mssql_num_rows($query) > 0) {
            $row = mssql_fetch_array($query);
            return $row['shot_name'];
        } else {
            return "NULL";
        }
    }
    function cur_status_dist($packid, $projid, $to_dist)
    {
        $sql = "select flag,count(flag) as fcount
        from Swift_Mail_Details where md_packid='$packid' and md_projid='$projid' 
        and md_id<=$to_dist group by flag order by flag desc";
        $query = mssql_query($sql);
        $result = array();
        $row = mssql_fetch_array($query);
        return $row;
        // $res = json_encode($result);
        // return $res;
    }
    function cur_status_distflow($packid, $projid)
    {
        $sql = "SELECT * from Swift_Disributor_status where ds_packid='$packid' and ds_projid='$projid' ";
        $query = mssql_query($sql);
        $result = array();
        $row = mssql_fetch_array($query);
        return $row;
        // $res = json_encode($result);
        // return $res;
    }
    function cur_status_distname($packid, $projid, $to_dist)
    {
        $sql = "SELECT * from Swift_Mail_Details where md_packid='$packid' and md_projid='$projid' and md_id='$to_dist' ";
        $query = mssql_query($sql);
        $result = array();
        $row = mssql_fetch_array($query);
        return $row;
        // $res = json_encode($result);
        // return $res;
    }


    function logday($packid, $projid, $from_dist)
    {
        $sql = "SELECT approved_date from Swift_Disributor_status where ds_packid='$packid' and ds_projid='$projid' and from_dist='$from_dist'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        // $result = array();
        // while ($row = mssql_fetch_array($query)) {
        //     $result[] = $row;
        // }
        // $res = json_encode($result);
        return $row;
    }
    function nextstage($packid, $projid,$md_id)
    {
         $sql = "SELECT dl_date as approved_on,dl_flag,to_md_id
        from Swift_Disributor_log where dl_packid=$packid and dl_projid=$projid and to_md_id='$md_id' order by dl_flag desc";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        // $result = array();
        // while ($row = mssql_fetch_array($query)) {
        //     $result[] = $row;
        // }
        // $res = json_encode($result);
        return $row;
    }
    function cur_status_supp($packid, $projid)
    {
        $sql = "SELECT contact_name,md_id,approved_on,send_back
        from Swift_Mail_Details where md_packid='$packid' and md_projid='$projid' 
        and flag>0 and  send_back=1 order by md_id desc ";
        $query = mssql_query($sql);
        $result = array();
        $row = mssql_fetch_array($query);
        return $row;
        // $res = json_encode($result);
        // return $res;
    }
    
    function status_order($packid, $projid)
    {
        $sql = "SELECT * from Swift_Buyer_approve where ba_packid='$packid' and ba_projid='$projid'  ";
        $query = mssql_query($sql);
        $result = array();
        $row = mssql_fetch_array($query);
        return $row;
        // $res = json_encode($result);
        // return $res;
    }
    function send_flag($packid, $projid)
    {
        $sql = "SELECT send_back
        from Swift_Disributor_log where dl_packid='$packid' and dl_projid='$projid' 
        order by md_id desc ";
        $query = mssql_query($sql);
        $result = array();
        $row = mssql_fetch_array($query);
        return $row;
        // $res = json_encode($result);
        // return $res;
    }
    function doc_dist($md_id)
    {
        $sql = "select df_filename,df_filepath  from swift_distributor_files where df_mail_disid='$md_id' order by df_id asc ";
        $query = mssql_query($sql);
        $result = array();
        $row = mssql_fetch_array($query);
        return $row;
        // $res = json_encode($result);
        // return $res;
    }
    //sakthi select users with particular type
    function select_user($id, $mil)
    {
        if ($mil == '1') {
            $cond = " and milcom_app='1'";
        } else {
            $cond = " and milcom_app!='1'";
        }
        $sql = "select * from usermst where usertype = $id and active=1 order by name asc";
       //echo $sql ;
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function select_repository($id)
    {
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
    function get_username($id)
    {
        $sql = "SELECT name FROM usermst WHERE uid = '$id' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row['name'];
    }

    // sakthi
    function ops_spoc_cur_remarks($packid)
    {
        $sql = "SELECT ts_remarks FROM swift_techspoc WHERE ts_active= '1' AND ts_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    // sakthi
    function ops_spoc_pre_remarks($packid)
    {
        $sql = "SELECT ts_sentdate,ts_remarks FROM swift_techspoc WHERE ts_active= '0' AND ts_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function spoc_exp_cur_remarks($packid)
    {
        $sql = "SELECT txp_remarks FROM swift_techexpert WHERE txp_active= '1' AND txp_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    // sakthi
    function spoc_exp_pre_remarks($packid)
    {
        $sql = "SELECT txp_sentdate,txp_remarks FROM swift_techexpert WHERE txp_active= '0' AND txp_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function spoc_exp_pre_remarks_sent_back($packid)
    {
        $sql = "SELECT txp_sentdate,txp_remarks,txp_sendr_stageid FROM swift_techexpert WHERE txp_active= '1' AND txp_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row['txp_sendr_stageid'];
    }

    function ops_spoc_pre_remarks_sent_back($packid)
    {
        $sql = "SELECT ts_sentdate,ts_remarks,ts_sendr_stageid FROM swift_techspoc WHERE ts_active= '1' AND ts_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row['ts_sendr_stageid'];
    }

    // sakthi
    function technical_cur_remarks($packid)
    {
        $sql = "SELECT tech_remarks FROM swift_techapproval WHERE tech_status='2' AND tech_active='1' AND tech_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    // sakthi
    function technical_pre_remarks($packid)
    {
        $sql = "SELECT tech_remarks FROM swift_techapproval WHERE tech_status='1' AND tech_active='1' AND tech_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function exp_cto_cur_remarks($packid)
    {
        $sql = "SELECT cto_remarks FROM swift_techcto WHERE cto_active= '1' AND cto_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    // sakthi
    function exp_cto_pre_remarks($packid)
    {
        $sql = "SELECT cto_sentdate,cto_remarks FROM swift_techcto WHERE cto_active= '0' AND cto_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function ops_scm_cur_remarks($packid)
    {
        $sql = "SELECT sc_remarks FROM swift_SCMSPOC WHERE sc_active = '1' AND sc_packid = '$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    // sakthi
    function ops_scm_pre_remarks($packid)
    {
        $sql = "SELECT sc_sentdate,sc_remarks FROM swift_SCMSPOC WHERE sc_active = '0' AND sc_packid = '$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function sendtoexpertdata($pack_id, $from, $to)
    {
        $sql = "SELECT sendback,ps_packid,ps_planneddate as planned_date,revised_planned_date,ps_expdate,
       pm_packagename,pm_revised_material_req,stage_name,(select stage_name from swift_stage_master 
       where stage_id=$to ) as next_stage,(select usertype from swift_stage_master 
       where stage_id=$to ) as usertype,from_remark,to_remark,file_attach ,from_uid
       FROM swift_packagestatus,swift_packagemaster,swift_stage_master,swift_workflow_CurrentStage
       WHERE ps_packid=pm_packid AND stage_id=ps_stageid AND cs_packid=ps_packid  AND ps_packid = '$pack_id' and ps_stageid = '$from'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function sendtobackdata($pack_id, $from, $to)
    {
        $sql = "SELECT sendback,ps_packid,ps_planneddate as planned_date,revised_planned_date,ps_expdate,
       pm_packagename,pm_revised_material_req,stage_name,(select stage_name from swift_stage_master 
       where stage_id=$from ) as next_stage,(select usertype from swift_stage_master 
       where stage_id=$from ) as usertype,from_remark,to_remark,file_attach ,from_uid
       FROM swift_packagestatus,swift_packagemaster,swift_stage_master,swift_workflow_CurrentStage
       WHERE ps_packid=pm_packid AND stage_id=ps_stageid AND cs_packid=ps_packid  AND ps_packid = '$pack_id' and ps_stageid = '$to'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function get_stagenames($pack_id, $from, $to)
    {
        $sql = "SELECT  (select stage_name from swift_stage_master 
       where stage_id=$from ) as cur_stage,(select stage_name from swift_stage_master 
       where stage_id=$to ) as next_stage
       FROM swift_packagestatus,swift_packagemaster,swift_stage_master,swift_workflow_CurrentStage
       WHERE ps_packid=pm_packid AND stage_id=ps_stageid AND cs_packid=ps_packid  AND ps_packid = '$pack_id' and active=1";
      //print_r($sql);
       $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function select_smartsignoff_val($pack_id)
    {
        // $sql = "SELECT hpc_app from swift_filesfrom_smartsignoff
        // WHERE so_pack_id = '$pack_id' ";
        // $query = mssql_query($sql);
        // $result = array();
        // while ($row = mssql_fetch_array($query)) {
        //     $result[] = $row;
        // }
        // $res = json_encode($result);
        // return $res;
        $sql = "SELECT hpc_app FROM swift_filesfrom_smartsignoff where so_pack_id='$pack_id'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function sendbackdata($pack_id, $from, $to)
    {
        $sql = "SELECT ps_packid,ps_planneddate as planned_date,revised_planned_date,ps_expdate,
       pm_packagename,pm_revised_material_req,stage_name,(select stage_name from swift_stage_master 
       where stage_id=$to ) as next_stage,(select usertype from swift_stage_master 
       where stage_id=$to ) as usertype,from_remark,to_remark,file_attach ,from_uid
       FROM swift_packagestatus,swift_packagemaster,swift_stage_master,swift_workflow_CurrentStage
       WHERE ps_packid=pm_packid AND stage_id=ps_stageid AND cs_packid=ps_packid  AND ps_packid = '$pack_id' and ps_stageid = '$from'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    // sakthi
    function select_technical_approve($pack_id)
    {
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
    function ps_planget($pack_id, $stage_id)
    {
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
    function get_ss_actdate($pack_id)
    {
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
    function sendtoctodata($pack_id, $from)
    {
        $sql = "SELECT ps_packid,ps_planneddate as planned_date ,ps_expdate,revised_planned_date,pm_packagename,pm_revised_material_req FROM swift_packagestatus,swift_packagemaster WHERE ps_packid=pm_packid AND ps_packid = '$pack_id' and ps_stageid = '$from'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
  

    // sakthi
    function sendtoopsdata($pack_id)
    {
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
    function sendtoscmtoopsdata($pack_id)
    {
        $sql = "SELECT ps_packid,ps_planneddate as planned_date,revised_planned_date,ps_expdate,pm_packagename,pm_revised_material_req FROM swift_packagestatus,swift_packagemaster WHERE ps_packid=pm_packid AND ps_packid = '$pack_id' and ps_stageid = '13'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function techspoc_proj_filter($seg)
    {
        if ($seg != '') {
            $cond = " and cat_id=38";
        } else {
            $cond = " and cat_id!=38";
        }
        $sql = "SELECT DISTINCT(proj_id),proj_name FROM Project,swift_techspoc WHERE proj_id=ts_projid " . $cond . "";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function techexpert_proj_filter($id, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id=$seg";
        } else {
            $cond = " and cat_id!=38";
        }
        $sql = "SELECT DISTINCT(proj_id),proj_name FROM Project,swift_techexpert WHERE proj_id=txp_projid AND txp_recvuid='$id' $cond";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function techcto_proj_filter($id, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = "  and cat_id!=38";
        }
        $sql = "SELECT DISTINCT(proj_id),proj_name FROM Project,swift_techCTO WHERE proj_id=cto_projid AND cto_recvuid='$id' $cond";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function scm_proj_filter($id, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = "  and cat_id!=38";
        }
        $sql = "SELECT DISTINCT(proj_id),proj_name FROM Project,swift_SCMSPOC WHERE proj_id=sc_projid AND sc_recvuid='$id' $cond";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function po_wo_check($pack_id)
    {
        $sql = "SELECT * FROM Swift_po_wo_Details where pw_packid='$pack_id'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function distributor_check($pack_id, $projid)
    {
        $sql = "SELECT * FROM Swift_Mail_Details where md_packid='$pack_id' and md_projid='$projid' and flag>0  order by md_id asc ";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function distributor_files($pack_id, $projid)
    {
        /// $sql = "SELECT * FROM swift_distributor_files where df_packid='$pack_id' and df_projid='$projid' and send_back=1 ";
        $sql = " SELECT a.*,b.remark from swift_distributor_files as a
        left join Swift_Disributor_log as b on a.df_mail_disid=b.md_id
        where a.send_back=1 and  df_packid='$pack_id' and df_projid='$projid' ";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }


    function select_planned_date($proj_id, $pack_id, $stage_id)
    {
        $sql = "SELECT revised_planned_date,ps_expdate FROM swift_packagestatus WHERE  ps_stageid='$stage_id' AND ps_projid='$proj_id' AND ps_packid='$pack_id'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function select_technical_approval($id, $uid)
    {
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

    function select_allprojects_loi($seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " and cat_id!=38";
        }
        $sql = "select distinct proj_id,proj_name from Project,swift_filesfrom_smartsignoff where so_proj_id=proj_id $cond order by proj_name asc";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_files_opswoentry($id, $segment)
    {
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,shot_name as stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,Project  
            WHERE  proj_id=so_proj_id and stage_id=ps_stageid and  so_pack_id=pm_packid AND so_pack_id=ps_packid AND active='1' AND work_order !='3' and cat_id='" . $segment . "' AND so_proj_id= '$id'";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,shot_name as stage_name,
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

    function select_scmspoc_repo($id, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = "  and cat_id!=38";
        }
        if ($id != "") {
            $sql = "SELECT sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_expdate,sc_actual,
            sc_remarks,sc_status,sc_active,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,revised_planned_date as planned_date,ps_expdate,ps_actualdate
            FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND pm_projid=proj_id AND sc_status='1' AND sc_active='1' AND sc_projid= '$id' $cond";
        } else {
            $sql = "SELECT sc_id,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_expdate,sc_actual,
            sc_remarks,sc_status,sc_active,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,revised_planned_date as planned_date,ps_expdate,ps_actualdate
            FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster,Project WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND pm_projid=proj_id AND sc_status='1' AND sc_active='1' $cond";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function scm_repository($pid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = "  and cat_id!=38";
        }
        if ($pid == "") {
            $sql = "select COUNT(*) as scm_repo
                    from swift_SCMSPOC,Project where sc_projid=proj_id AND sc_status='1' AND sc_active='1' $cond ";
        } else {
            $sql = "select COUNT(*) as scm_repo
                    from swift_SCMSPOC where sc_projid=proj_id AND sc_status='1' AND sc_active='1'  and sc_projid='" . $pid . "' $cond";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['scm_repo'];
        return $count;
    }

    function over_allcount($pid)
    {
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

    function select_smartsignoff_buyer_repo($id, $uid, $utype, $seg)
    {
        if ($seg != '') {
            $cond1 = " AND cat_id='38'";
        } else {
            $cond1 = "  and cat_id!=38";
        }

        if ($utype == 20) {
            $cond = "";
        } else {
            $cond = " and bu_buyer_id='" . $uid . "'";
        }
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER,Project 
            WHERE stage_id=ps_stageid and  so_pack_id=pm_packid AND so_pack_id=ps_packid AND pm_projid=proj_id AND active='1' 
            AND po_wo_status ='4' AND so_proj_id= '$id' and bu_packid=so_pack_id  " . $cond . " " . $cond1 . "";
        } else {

            $sql = "SELECT distinct bu_buyer_id,so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER,Project
            WHERE stage_id=ps_stageid and so_pack_id=pm_packid AND pm_projid=proj_id 
            AND so_pack_id=ps_packid AND active='1' AND po_wo_status ='4' and bu_packid=so_pack_id " . $cond . " " . $cond1 . "";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function scmbuyer_repository($pid, $uid, $utype, $seg)
    {
        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " and cat_id!=38";
        }
        if ($utype == '20') {
            $cond = "";
        } else {
            $cond = " and bu_buyer_id='" . $uid . "'";
        }
        if ($pid == "") {
            $sql = "SELECT COUNT(*) as buyer_repo FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER,Project 
            WHERE stage_id=ps_stageid and so_pack_id=pm_packid AND pm_projid=proj_id
            AND so_pack_id=ps_packid AND active='1' and bu_status=1 and  po_wo_status ='4' and bu_packid=so_pack_id $cond $cond1";
        } else {
            $sql = "SELECT COUNT(*) as buyer_repo FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,swift_SCMtoBUYER,Project 
            WHERE stage_id=ps_stageid and so_pack_id=pm_packid AND pm_projid=proj_id
            AND so_pack_id=ps_packid AND active='1' and bu_status=1 and  po_wo_status ='4' and bu_packid=so_pack_id $cond and so_proj_id='" . $pid . "' $cond1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['buyer_repo'];
        return $count;
    }

    function sentbackfromcto($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = "  and cat_id!=38";
        }
        if ($id != "") {
            $sql = "SELECT txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,ps_planneddate as org_plandate,ps_expdate,
            ps_actualdate,txp_expdate,txp_actual,txp_remarks,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            FROM swift_techexpert,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '5' AND txp_packid=ps_packid AND pm_projid=proj_id AND  txp_packid=pm_packid AND txp_status = '2' AND txp_active='1' AND txp_projid = '$id' AND txp_recvuid='$uid'";
        } else {
            $sql = "SELECT txp_id,txp_packid,txp_projid,txp_senderuid,txp_recvuid,txp_sendr_stageid,txp_recv_stageid,txp_sentdate,ps_planneddate as org_plandate,ps_expdate,
            ps_actualdate,txp_expdate,txp_actual,txp_remarks,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date 
            FROM swift_techexpert,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '5' AND txp_packid=ps_packid AND pm_projid=proj_id AND txp_packid=pm_packid AND txp_status = '2' AND txp_active='1' AND txp_recvuid='$uid'";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function checkpo($packid)
    {
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

    function vendor_select()
    {
        $sql = "select * from vendor order by sup_name";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_lcmaster()
    {
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

    function select_rpamaster()
    {
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

    function changelc($lcid)
    {
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

    function changerpa($rpaid)
    {
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

    // function check_pouploaded($packid)
    // {
    //     $sql = "select * from swift_podetails where po_pack_id='" . $packid . "'";
    //     $query = mssql_query($sql);
    //     $num_rows = mssql_num_rows($query);
    //     if ($num_rows > 0) {
    //         $pocheck = 1;
    //     } else {
    //         $pocheck = 0;
    //     }
    //     return $pocheck;
    // }
    function check_pouploaded($packid)
    {
        $sql = "select * from swift_po_master where po_pack_id='" . $packid . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $pocheck = 1;
        } else {
            $pocheck = 0;
        }
        return $pocheck;
    }

    function itemname($rowid)
    {
        $sql = "select sdesc,itemcode from dbo.swift_podetails where swid='" . $rowid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function po_master($rowid)
    {
        $sql = "SELECT po_mat_desc,po_mat_code from swift_po_master where po_id='" . $rowid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function calculate_sunday($start, $end)
    {
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

    function select_allpackagescatte()
    {
        $sql = "select * from swift_package_category";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_swiftpacktype()
    {
        $sql = "select * from SwiftType";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    //For Work Flow By uma
    function select_AllWorkFlow()
    {
        $sql = "select * from swift_workflow_master where active=1";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    //For Work Flow By uma
    function select_AllUsertype()
    {
        $sql = "select * from user_type_master";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_stageone()
    {
        $sql = "select top 10 * from swift_stage_master order by stage_id asc";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_stagetwo()
    {
        $sql = "select * from swift_stage_master where stage_id>=11 order by stage_id asc";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_RevUsertype()
    {
        $sql = "select * from rev_back_user_type";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function fetch_buyername($packid)
    {
        $sql = "select name,bu_buyer_id from swift_SCMtoBUYER,usermst where bu_packid='" . $packid . "' and bu_buyer_id=uid and bu_status>=1  ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $name = $row['name'];
        return $name;
    }

    function send_email($proj_id, $pack_id, $recvstageid, $recvid, $remarks, $sendstageid)
    {
        require '../PHPMailer/PHPMailerAutoload.php';
        $sql = "select proj_name,pm_packagename,stage_name,shot_name,revised_planned_date from swift_packagestatus,Project,swift_packagemaster,swift_stage_master
where ps_packid=pm_packid and ps_projid=proj_id and ps_stageid=stage_id and ps_packid='" . $pack_id . "' and ps_projid='" . $proj_id . "' and ps_stageid='" . $recvstageid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $proj_name = $row['proj_name'];
        $pack_name = $row['pm_packagename'];
        //        $stage_name = $row['stage_name'];
        $stage_name = $row['shot_name'];
        $planneddate = formatDate($row['revised_planned_date'], 'd-M-Y');

        $getstage_name = mssql_query("select * from dbo.swift_stage_master where stage_id='" . $sendstageid . "'");
        $getrow = mssql_fetch_array($getstage_name);
        $sender_stage_name = $getrow['shot_name'];

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
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $proj_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pack_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $_SESSION['name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $sender_stage_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $remarks . '</td>
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
        $usertype = $row['usertype'];

        //    $email = 'srini.rpsm@gmail.com';
        //  $name = $row['name'];

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settingss
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            //Server settingss
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com;';                      // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'weblntswcdigital@gmail.com';       // SMTP username
            $mail->Password = '!Lntswc123';                      // SMTP password
            //        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;
            // TCP port to connect to
            //Recipients
            $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
            if ($usertype == 5) {
                $sql = "select uname from usermst,ops_mailsetting where ops_toemail=uid  and ops_projid='$proj_id'";
                $query = mssql_query($sql);
                $num_rows1 = mssql_num_rows($query);
                if ($num_rows1 > 0) {
                    while ($row1 = mssql_fetch_array($query)) {
                        $ops_email = $row1['uname'];
                        $mail->addAddress($ops_email); // Name is optional 
                    }
                } else {
                    $mail->addAddress($email, $name); // Add a recipient
                }
            } else {
                $mail->addAddress($email, $name); // Add a recipient
            }
            if ($usertype = 5) {
                $sql = "select uname from usermst,ops_mailsetting where ops_cc=uid  and ops_projid='$proj_id'";
                $query = mssql_query($sql);
                $num_rows = mssql_num_rows($query);
                if ($num_rows > 0) {
                    while ($row1 = mssql_fetch_array($query)) {
                        $ops_email = $row1['uname'];
                        $mail->addCC($ops_email); // Name is optional 
                    }
                } else {
                    $mail->addCC('uuk@lntecc.com', 'SWIFT');
                }
            }

            //    $mail->addAddress('uuk@lntecc.com', 'Smart Signoff'); // Add a recipient
            //$mail->addAddress('srini.rpsm@gmail.com'); // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
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

    function select_ckaddon()
    {
        $sql = "select * from swift_checklistaddon";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function filldates($id, $pid)
    {
        $sql = "select * from swift_checklistaddon as A 
left join  swift_checklist_docs as b on b.clk_id=A.ck_id
where ck_projid='$pid' and clk_id='$id' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function projtype($id) {
         $sql = "SELECT * from SwiftType Where id='$id' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }


    function select_ckstatus($eid)
    {
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

    // function name($uid, $pid)
    // {
    //    echo $sql = "select name,txp_remarks from swift_techexpert,usermst where txp_recvuid=uid and txp_senderuid='" . $uid . "' and txp_active=1 and txp_packid='" . $pid . "'";
    //     $query = mssql_query($sql);
    //     $row = mssql_fetch_array($query);
    //     return $row;
    // }
    function newname($uid, $pid)
    {
        $sql = "select name,rs_to_remark as txp_remarks from swift_repository,usermst where rs_to_uid=uid and rs_to_uid='" . $uid . "' and rs_packid='" . $pid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function sendback_email($proj_id, $pack_id, $recvstageid, $recvid, $remarks, $sendstageid)
    {
        require '../PHPMailer/PHPMailerAutoload.php';
        $sql = "select proj_name,pm_packagename,stage_name,shot_name,revised_planned_date from swift_packagestatus,Project,swift_packagemaster,swift_stage_master
where ps_packid=pm_packid and ps_projid=proj_id and ps_stageid=stage_id and ps_packid='" . $pack_id . "' and ps_projid='" . $proj_id . "' and ps_stageid='" . $recvstageid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $proj_name = $row['proj_name'];
        $pack_name = $row['pm_packagename'];
        //        $stage_name = $row['stage_name'];
        $stage_name = $row['shot_name'];
        $planneddate = formatDate($row['revised_planned_date'], 'd-M-Y');

        $sql1 = mssql_query("select * from usermst where uid='" . $recvid . "'");
        $row1 = mssql_fetch_array($sql1);
        $emailk = $row1['uname'];
        $getstage_name = mssql_query("select * from dbo.swift_stage_master where stage_id='" . $sendstageid . "'");
        $getrow = mssql_fetch_array($getstage_name);
        $sender_stage_name = $getrow['shot_name'];



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
                                        <th style=" padding:5px;  text-align: center; background-color:#933a16; color:white;  border: 1px solid #ddd;">Project Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#933a16; color:white;  border: 1px solid #ddd;">Package Name</th>
                                         
                                        <th style=" padding:5px; text-align: center; background-color:#933a16; color:white;  border: 1px solid #ddd;">Received From</th>
                                        <th style=" padding:5px; text-align: center; background-color:#933a16; color:white;  border: 1px solid #ddd;">Remarks</th>
                                        <th style=" padding:5px; text-align: center; background-color:#933a16; color:white;  border: 1px solid #ddd;">Action to be Done</th>
                                        <th style=" padding:5px; text-align: center; background-color:#933a16; color:white;  border: 1px solid #ddd;">Stage Planned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $proj_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pack_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $_SESSION['name'] . '</td>
                                        
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $remarks . '</td>
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
            // $mail->addAddress('uuk@lntecc.com', 'Smart Signoff'); // Add a recipient
            // $mail->addAddress('srini.rpsm@gmail.com'); // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('uuk@lntecc.com', 'SWIFT');
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

    function send_email_tech($proj_id, $pack_id, $recvstageid, $recvid, $remarks, $sendstageid)
    {
        require '../PHPMailer/PHPMailerAutoload.php';
        $sql = "select cat_id,proj_name,pm_packagename,stage_name,shot_name,revised_planned_date from swift_packagestatus,Project,swift_packagemaster,swift_stage_master
where ps_packid=pm_packid and ps_projid=proj_id and ps_stageid=stage_id and ps_packid='" . $pack_id . "' and ps_projid='" . $proj_id . "' and ps_stageid='" . $recvstageid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $proj_name = $row['proj_name'];
        $pack_name = $row['pm_packagename'];
        //        $stage_name = $row['stage_name'];
        $stage_name = $row['shot_name'];
        $planneddate = formatDate($row['revised_planned_date'], 'd-M-Y');
        $segment_sql = mssql_query("select cat_id from Project where proj_id='" . $proj_id . "'");
        $sqry = mssql_fetch_array($segment_sql);
        $segment = $sqry['cat_id'];


        $getstage_name = mssql_query("select * from dbo.swift_stage_master where stage_id='" . $sendstageid . "'");
        $getrow = mssql_fetch_array($getstage_name);
        $sender_stage_name = $getrow['shot_name'];

        if ($segment == 37) {
            $cc = 'J-SRIDHAR@lntecc.com';
        } else {
            $cc = 'shankaranr@lntecc.com';
        }
        $sql1 = mssql_query("select * from usermst where uid='" . $recvid . "'");
        $row1 = mssql_fetch_array($sql1);
        $email = $row1['uname'];

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
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $proj_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $pack_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $_SESSION['name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $sender_stage_name . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $remarks . '</td>
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
            $mail->Host = 'smtp.gmail.com;';                      // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
            $mail->Password = '!Lntswc123';                      // SMTP password
            //        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;
            // TCP port to connect to
            //Recipients
            $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
            $mail->addAddress($email, $name); // Add a recipient
            //$mail->addAddress('uuk@lntecc.com', 'SWIFT'); // Add a recipient
            //$mail->addAddress('srini.rpsm@gmail.com'); // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');

            $sqlccs1 = mssql_query("select * from swiftCcMailSetting where   ccExceptProjid in (0) and ccSegid=$segment and ccActive=1");
            $cc_numr1 = mssql_num_rows($sqlccs1);
            if ($cc_numr1 > 0) {
                while ($cc_row1 = mssql_fetch_array($sqlccs1)) {
                    $mail->addCC($cc_row1['ccMail'], 'SWIFT'); // Add a recipient
                }
            }

            $sqlccs2 = mssql_query("select * from swiftCcMailSetting where ccExceptProjid in ($proj_id)  and ccSegid=$segment and ccActive=1");
            $cc_numr2 = mssql_num_rows($sqlccs2);
            if ($cc_numr2 > 0) {
                while ($cc_row2 = mssql_fetch_array($sqlccs2)) {
                    $mail->addCC($cc_row2['ccMail'], 'SWIFT'); // Add a recipient
                }
            }
            //            $mail->addCC($cc);
            $mail->addCC('uuk@lntecc.com', 'SWIFT');
            $mail->addBCC('srini.rpsm@gmail.com', 'SWIFT');
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

    //   function current_status_name($id) {
    //        $sql = "select shot_name from swift_packagestatus,swift_stage_master where ps_stageid=stage_id and active='1'  and ps_packid='$id'";
    //        $query = mssql_query($sql);
    //        if (mssql_num_rows($query) > 0) {
    //            $row = mssql_fetch_array($query);
    //            return $row['shot_name'];
    //        } else {
    //            return "NULL";
    //        }
    //    }
    function current_status($packid,$projid)
    {
         $sql = "select d.name as sname,b.name,b.usertype,c.shot_name,(isnull(DATEDIFF(DAY,a.ps_actualdate,GETDATE()),0)) as nodays,ps_stback, a.* from  dbo.swift_packagestatus as a
        left join usermst as b on a.ps_userid=b.uid
        left join swift_stage_master as c on a.ps_stageid=c.stage_id  
        left join usermst as d on a.ps_sbuid=d.uid
        where  a.active=1  and a.ps_packid='" . $packid . "' and a.ps_projid='" . $projid . "' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        $sent_back = $row['ps_stback'];
        $utype = $row['usertype'];
        if ($sent_back == 1) {
            $sent   = $row['shot_name'];
            $status = 'Sent back by ' . $sent . '<br>(' . $row['sname'] . ' / ' . $row['nodays'] . ' Days )';
        } else {
            $status = $row['shot_name'] . '<br>(' . $row['name'] . ' / ' . $row['nodays'] . ' Days )';
        }
        return $status;
    }

    function fetch_usertype($uid)
    {
        $sql = "select * from usermst where uid='$uid' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        $utype = $row['usertype'];
        return $utype;
    }
    function fetch_usertype_v1($uid) {
        $con = new dbcon2();
        $dbcon1 = $con->getValue();
        $sql = "select * from usermst where uid='$uid' ";
        $query = mssql_query($sql,$dbcon1);
        $row = mssql_fetch_assoc($query);
        $utype=$row['usertype'];
        return $utype;
    }

    function sentbackfromreviewer($id, $uid, $seg)
    {
        if ($seg != "") {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT pm_stages,cs_packid,cs_projid,from_uid,to_uid,from_stage_id,to_stage_id, ps_planneddate
         as org_plandate,ps_expdate, ps_actualdate,cs_actual,cs_created_date as cs_sentdate, from_remark,
         to_remark, cs_active,revised_planned_date as rev_planned_date,pm_material_req 
         as schedule_date,pm_revised_material_req as mat_req_date FROM swift_workflow_CurrentStage, 
         swift_packagestatus,swift_packagemaster,Project WHERE cs_active = '1' and to_stage_id =ps_stageid and to_uid = '$uid' 
         and cs_packid=ps_packid and cs_packid=pm_packid AND proj_id=cs_projid and cs_projid = '$id' $cond  ";
        } else {
              $sql = "SELECT pm_stages,cs_packid,cs_projid,from_uid,to_uid,from_stage_id,to_stage_id, ps_planneddate
          as org_plandate,ps_expdate, ps_actualdate,cs_actual,cs_created_date as cs_sentdate, from_remark,
          to_remark, cs_active,revised_planned_date as rev_planned_date,pm_material_req 
          as schedule_date,pm_revised_material_req as mat_req_date FROM swift_workflow_CurrentStage, 
          swift_packagestatus,swift_packagemaster,Project WHERE cs_active = '1' and to_stage_id =ps_stageid and to_uid = '$uid' 
          and cs_packid=ps_packid and cs_packid=pm_packid AND proj_id=cs_projid $cond";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function pack_details($packid, $projid)
    {
        $sql = "SELECT a.pm_packagename,b.proj_name FROM swift_packagemaster  as a
        inner join project as b on b.proj_id =a.pm_projid
        where pm_packid='$packid' and pm_projid='$projid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function check_dist_log($packid, $projid, $md_id)
    {
        $sql = "SELECT count(md_id) as logcount  FROM Swift_Disributor_log 
        where dl_packid=$packid and dl_projid=$projid and md_id=$md_id";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function check_status($packid, $projid)
    {
        $sql = "SELECT ds_id  FROM Swift_Disributor_status 
        where ds_packid=$packid and ds_projid=$projid";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function check_dist_sendlog($packid, $projid, $md_id)
    {
        $sql = "SELECT count(md_id) as logcount  FROM Swift_Disributor_log 
        where dl_packid=$packid and dl_projid=$projid and md_id=$md_id and send_back=1 ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function check_Mail_flag($packid, $projid, $md_id)
    {
        $sql12 = "SELECT flag,send_back  FROM Swift_Mail_Details 
        where md_packid=$packid and md_projid=$projid and md_id=$md_id ";
        $query1 = mssql_query($sql12);
        $row123   = mssql_fetch_array($query1);
        //print_r($row123);die;
        return $row123;
        // $query = mssql_query($sql);
        // $result = array();
        // while ($row = mssql_fetch_array($query)) {
        //     $result[] = $row;
        //     print_r($result);
        // }
        // $res = json_encode($result);
        // return $res;
    }
    //For WorkFlow
    function Send_MailNew($projid, $packid, $milcom, $from, $to)
    {
        //$url = 'http://127.0.0.1:8000/api/LinkSend';
        $url  = 'https://swc.ltts.com/lnt_email_services/api/LinkSend';
        $data = array(
            'projid' => $projid,
            'packid' => $packid,
            'milcom'   => $milcom,
            'from'   => $from,
            'to'   => $to,
        );
        print_r($data);
        $encodedData = json_encode($data);  
        $curl = curl_init($url);
       // print_r($encodedData);
        $data_string = urlencode(json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($curl);
        // print $result;
        // die();
// if(curl_errno($curl)) {
//     $error_message = curl_error($curl);
//     echo "cURL error: " . $error_message;
// }

        curl_close($curl);
       
    }
    //For Distributor Process
    function Send_Mail_Dist($projid, $packid, $md_id)
    {
        //$url = 'http://127.0.0.1:8000/api/LinkSendToDist';
         $url  = 'https://swc.ltts.com/lnt_email_services/api/LinkSendToDist';
        $data = array(
            'projid' => $projid,
            'packid' => $packid,
            'mdid'   => $md_id,
        );

        $encodedData = json_encode($data);
        $curl = curl_init($url);
        $data_string = urlencode(json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($curl);
        curl_close($curl);
       //  print $result;exit;
    }
    //By OEM 
    //For Distributor Process
    function Send_Mail_OEM($projid, $packid, $md_id)
    {
        // $url = 'http://127.0.0.1:8000/api/LinkSendToBuyer';
        $url  = 'https://swc.ltts.com/lnt_email_services/api/LinkSendToBuyer';
        $data = array(
            'projid' => $projid,
            'packid' => $packid,
            'mdid'   => $md_id,
        );

        $encodedData = json_encode($data);
        $curl = curl_init($url);
        $data_string = urlencode(json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($curl);
        curl_close($curl);
        // print $result;
        // die;
    }
    function Distributer($projid, $packid)
    {

        $sql = "SELECT * from Swift_Mail_Details  WHERE md_projid='$projid' and md_packid='$packid' and flag> 0 ";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_project_type($id) {
       
        $where = '';
        $proj_type = isset($_SESSION['proj_type']) ? trim($_SESSION['proj_type']) : '';
        $result = array();
        if($proj_type != ''){
            
        //echo "<pre>"; print_R("select * from SwiftType $where"); exit;
            if($proj_type != 0){
                $where = "WHERE id = $proj_type";
            }
             $sql = "select * from SwiftType $where";
            $query = mssql_query($sql);
            while ($row = mssql_fetch_array($query)) {
                $result[] = $row;
            }
        }
        $res = json_encode($result);
        return $res;
    }
}
