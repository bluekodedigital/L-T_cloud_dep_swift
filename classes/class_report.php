<?php
include('db_con2.php');
class Report
{
    // private $secondCon;

    function techspoc_dash($pid, $seg = '')
    {

        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = "";
        }
        if ($pid == "") {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id $cond";
        } else {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id and proj_id='" . $pid . "' $cond";
        }
        //echo $sql; die;
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }


    function dash2($pid, $segment)
    {

        $con = new dbcon2();
        $result = $con->getValue();
        $where = "";
        $uid = $_SESSION['uid'];
        if ($_SESSION['usertype'] != 0) {
            $where = "u.uid =$uid";
        }
        //print_r($result);

        //    define("SECOND_HOST", "192.168.0.133");
        //    define("SECOND_USERNAME", "sa");
        //    define("SECOND_PASSWORD", "Bks&123#");
        //    define("SECOND_DBNAME", "lnt_track_prd");
        //    $this->secondCon = mssql_connect(SECOND_HOST, SECOND_USERNAME, SECOND_PASSWORD) or die("Couldn't connect to the second MSSQL Server");
        //    mssql_select_db(SECOND_DBNAME, $this->secondCon) or die("Couldn't open the second database");   
        if ($pid == "") {

            // $sql = "SELECT ps_userid,proj_id,ps_packid,pm_packagename,proj_name,proj_type,stage_name,ps_stageid,ps_stback,
            // isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
            // (isnull(DATEDIFF(DAY,a.ps_actualdate,GETDATE()),0)) as nodays, revised_planned_date as 
            // planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time,shot_name,
            // u.name as sname,u.name,proj_name,
            // (select ps_actualdate from  swift_packagestatus where ps_packid=c.pm_packid and ps_stageid=12) as  ss_app_actualdate,
            // (select ps_planneddate from  swift_packagestatus where ps_packid=c.pm_packid and ps_stageid=12) as  ss_app_plandate,
            // (select ps_actualdate from swift_packagestatus where ps_packid=c.pm_packid and ps_stageid=15) as  po_actdate,
            // (select ps_planneddate from swift_packagestatus where ps_packid=c.pm_packid and ps_stageid=15) as  po_planneddate
            // from swift_packagestatus as a
            // inner join Project as b on a.ps_projid=b.proj_id
            // inner join swift_packagemaster as c on a.ps_packid=c.pm_packid and a.ps_projid=c.pm_projid
            // inner join swift_stage_master as d on a.ps_stageid=d.stage_id
            // inner join usermst as u on a.ps_userid=u.uid 

            // where $where  order by pm_packid desc";

            $sql = "WITH RankedPackages AS (
                        SELECT ps_userid, b.proj_id, ps_packid,pm_packid, pm_packagename, proj_name, b.proj_type, stage_name, ps_stageid, ps_stback,
                            ISNULL(DATEDIFF(DAY, revised_planned_date, ps_actualdate), 0) AS daysdif,
                            ISNULL(DATEDIFF(DAY, a.ps_actualdate, GETDATE()), 0) AS nodays,
                            revised_planned_date AS planned, ps_expdate, ps_actualdate AS actual,
                            pm_revised_material_req, pm_revised_lead_time, shot_name, u.name AS sname, u.name,
                            (SELECT TOP 1 ps_actualdate FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 12) AS ss_app_actualdate,
                            (SELECT TOP 1 ps_planneddate FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 12) AS ss_app_plandate,
                            (SELECT TOP 1 ps_actualdate FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 15) AS po_actdate,
                            (SELECT TOP 1 ps_planneddate FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 15) AS po_planneddate,
                            ROW_NUMBER() OVER (PARTITION BY a.ps_packid ORDER BY a.ps_stageid DESC) AS rn -- Rank by stage id for each package
                        FROM swift_packagestatus AS a
                        INNER JOIN Project AS b ON a.ps_projid = b.proj_id
                        INNER JOIN swift_packagemaster AS c ON a.ps_packid = c.pm_packid AND a.ps_projid = c.pm_projid
                        INNER JOIN swift_stage_master AS d ON a.ps_stageid = d.stage_id
                        INNER JOIN usermst AS u ON a.ps_userid = u.uid
                        
                    )
                    SELECT *
                    FROM RankedPackages
                    WHERE rn = 1 
                    ORDER BY pm_packid DESC";
        } else {
            $sql = "WITH RankedPackages AS (
                        SELECT ps_userid, proj_id, ps_packid,pm_packid, pm_packagename, proj_name, proj_type, stage_name, ps_stageid, ps_stback,
                            ISNULL(DATEDIFF(DAY, revised_planned_date, ps_actualdate), 0) AS daysdif,
                            ISNULL(DATEDIFF(DAY, a.ps_actualdate, GETDATE()), 0) AS nodays,
                            revised_planned_date AS planned, ps_expdate, ps_actualdate AS actual,
                            pm_revised_material_req, pm_revised_lead_time, shot_name, u.name AS sname, u.name,
                            (SELECT TOP 1 ps_actualdate FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 12) AS ss_app_actualdate,
                            (SELECT TOP 1 ps_planneddate FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 12) AS ss_app_plandate,
                            (SELECT TOP 1 ps_actualdate FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 15) AS po_actdate,
                            (SELECT TOP 1 ps_planneddate FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 15) AS po_planneddate,
                            ROW_NUMBER() OVER (PARTITION BY a.ps_packid ORDER BY a.ps_stageid DESC) AS rn -- Rank by stage id for each package
                        FROM swift_packagestatus AS a
                        INNER JOIN Project AS b ON a.ps_projid = b.proj_id
                        INNER JOIN swift_packagemaster AS c ON a.ps_packid = c.pm_packid AND a.ps_projid = c.pm_projid
                        INNER JOIN swift_stage_master AS d ON a.ps_stageid = d.stage_id
                        INNER JOIN usermst AS u ON a.ps_userid = u.uid
                        WHERE  proj_id=$pid
                    )
                    SELECT *
                    FROM RankedPackages
                    WHERE rn = 1 
                    ORDER BY pm_packid DESC ";
        }
        $query = mssql_query($sql, $result);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function techspoc_dash11($pid, $segment)
    {
        if ($pid == "") {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id $segment";
        } else {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id and proj_id='" . $pid . "' $segment";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function om_dash($pid)
    {
        if ($pid == "") {
            $sql = "select distinct proj_id,ps_packid,pm_packagename,proj_name,stage_name,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_material_req,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id";
        } else {
            $sql = "select proj_id,ps_packid,pm_packagename,proj_name,stage_name,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_material_req,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_files_fortechspoc($pid)
    {
        if ($pid == "") {
            $sql = "select COUNT(*) as files_techspoc
                    from swift_packagemaster,Project where proj_id=pm_projid  and tech_status=0";
        } else {
            $sql = "select COUNT(*) as files_techspoc
                    from swift_packagemaster,Project where proj_id=pm_projid  and pm_projid='" . $pid . "' and tech_status=0";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['files_techspoc'];
        return $count;
    }

    function repo_files_fortechspoc_initiated($pid, $segment)
    {
        if ($pid == "") {
            $sql = "select COUNT(*) as files_techspoc
                    from swift_packagemaster,Project where proj_id=pm_projid  and tech_status=1 $segment";
        } else {
            $sql = "select COUNT(*) as files_techspoc
                    from swift_packagemaster,Project where proj_id=pm_projid  and pm_projid='" . $pid . "' and tech_status=1 $segment";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['files_techspoc'];
        return $count;
    }

    function om_count_cleared($pid, $segment)
    {
        if ($pid == "") {
            $sql = "select COUNT(*) as total from swift_OandM,Project where om_active=1 and om_status=1 and proj_id=om_projid  $segment";
        } else {
            $sql = "select COUNT(*) as total from swift_OandM,Project where om_active=1 and om_status=1 and proj_id=om_projid  and proj_id='" . $pid . "' $segment";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['total'];
        return $count;
    }

    function ops_count_cleared($pid, $segment)
    {
        //        if ($pid == "") {
        //            $sql = "select COUNT(*) as total from swift_SCMSPOC,Project where sc_active=1 and sc_status=1 and proj_id=sc_projid ";
        //        } else {
        //            $sql = "select COUNT(*) as total from swift_SCMSPOC,Project where sc_active=1 and sc_status=1 and proj_id=sc_projid  and proj_id='" . $pid . "'";
        //        }
        if ($pid == "") {
            $sql = "select COUNT(ps_packid) as total  from swift_packagestatus,Project where ps_stageid in(8,9) and active =1 and ps_projid=proj_id $segment ";
        } else {
            $sql = "select COUNT(ps_packid) as total  from swift_packagestatus,Project where ps_stageid in(8,9) and active =1 and ps_projid=proj_id  and ps_projid='" . $pid . "' $segment";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['total'];
        return $count;
    }

    function scm_underfinal($pid, $segment)
    {
        if ($pid == "") {
            $sql = "select count(*) as total from swift_SCMtoBUYER,Project  where bu_status in (1,0) and bu_proid=proj_id $segment ";
        } else {
            $sql = "select count(*) as total from swift_SCMtoBUYER,Project where bu_status in (1,0) and bu_projid='" . $pid . "' and bu_proid=proj_id $segment ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $num_rows = mssql_num_rows($query);
        if ($num_rows == '') {
            $count = 0;
        } else {
            $count = $row['total'];
        }

        return $count;
    }

    function scm_underfinal_porgress($pid)
    {
        if ($pid == "") {
            $sql = "select count(*) as total from swift_SCMtoBUYER where bu_status=0 ";
        } else {
            $sql = "select count(*) as total from swift_SCMtoBUYER where bu_status=0 and bu_projid='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $num_rows = mssql_num_rows($query);
        if ($num_rows == '') {
            $count = 0;
        } else {
            $count = $row['total'];
        }

        return $count;
    }

    function app_completed($pid, $segment)
    {
        if ($pid != "") {
            $sql = "select distinct a.sol_id from solution as a,Quote_Approval as b ,Project as c
where a.sol_id= b.Sol_id and sol_projid='" . $pid . "' and swift_packid!='' and b.Status=1  and c.proj_id=a.sol_projid $segment";
            //            $sql = "select distinct a.sol_id from solution as a,Quote_Approval as b 
            //where a.sol_id= b.Sol_id and sol_projid='" . $pid . "' and swift_packid!='' and b.Status=1 ";
        } else {
            $sql = "select distinct a.sol_id from solution as a,Quote_Approval as b 
where a.sol_id= b.Sol_id and swift_packid!='' and b.Status=1";
            $sql = "select distinct a.sol_id from solution as a,Quote_Approval as b ,Project as c
where a.sol_id= b.Sol_id  and swift_packid!='' and b.Status=1  and c.proj_id=a.sol_projid $segment ";
        }
        $query = mssql_query($sql);
        $count = mssql_num_rows($query);
        return $count;
    }

    function app_completedfinal($pid, $segment)
    {
        if ($pid != "") {
            $sql = "select distinct a.sol_id from solution as a,Project as c,Quote_Approval as b 
where a.sol_id= b.Sol_id  and swift_packid!='' and b.Status in (1,0)  $segment   and a.sol_projid=c.proj_id and a.sol_projid='" . $pid . "' ";
            //            $sql = "select distinct a.sol_id from solution as a,Quote_Approval as b 
            //where a.sol_id= b.Sol_id and sol_projid='" . $pid . "' and swift_packid!='' and b.Status in (1,0) ";
        } else {
            //            $sql = "select distinct a.sol_id from solution as a,Quote_Approval as b 
            //where a.sol_id= b.Sol_id and swift_packid!='' and b.Status in (1,0)";
            $sql = "select distinct a.sol_id from solution as a,Project as c,Quote_Approval as b 
where a.sol_id= b.Sol_id  and swift_packid!='' and b.Status in (1,0)  $segment  and a.sol_projid=c.proj_id ";
        }
        $query = mssql_query($sql);
        $count = mssql_num_rows($query);
        return $count;
    }
    function app_completedpackage($pid, $segment, $packid, $stageid)
    {
        if ($pid != "") {
            $sql = "select * from swift_transactions where st_packid=$packid and st_stageid=$stageid    $segment and st_projid='" . $pid . "' ";
        } else {
            $sql = "select * from swift_transactions where st_packid=$packid and st_stageid=$stageid    $segment  ";
        }
        $query = mssql_query($sql);
        $count = mssql_num_rows($query);
        return $count;
    }
    function ttl_tech_completed($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as techcount  from swift_transactions where  st_stageid=6  and st_status = 0    $segment and st_projid='" . $pid . "' ";
        } else {
            echo $sql = " SELECT count(distinct st_packid) as techcount  from swift_transactions where  st_stageid=6  and st_status = 0    $segment  ";
        }
        $query = mssql_query($sql);
        $count = mssql_num_rows($query);
        return $count;
    }


    function final_status($pid)
    {
        if ($pid != "") {
            $sql = "select distinct(select COUNT(*) as on_track from swift_packagestatus as a 
where active=1 and  ps_projid='" . $pid . "' and DATEDIFF(DAY,revised_planned_date,ps_actualdate) <=0) as on_track,
(select COUNT(*) as delayed   from swift_packagestatus as a 
where  active=1 and  ps_projid='" . $pid . "' and  DATEDIFF(DAY,revised_planned_date,ps_actualdate) >=1 and DATEDIFF(DAY,revised_planned_date,ps_actualdate) <=15) as delayed,
(select COUNT(*) as critical from swift_packagestatus as a
where active=1 and  ps_projid='" . $pid . "' and DATEDIFF(DAY,revised_planned_date,ps_actualdate) >15) as critical 
from  swift_packagestatus where ps_projid='" . $pid . "'  group by ps_projid";
        } else {
            $sql = "select distinct(select COUNT(*) as on_track from swift_packagestatus as a 
where active=1  and DATEDIFF(DAY,revised_planned_date,ps_actualdate) <=0) as on_track,
(select COUNT(*) as delayed   from swift_packagestatus as a 
where  active=1 and  DATEDIFF(DAY,revised_planned_date,ps_actualdate) >=1 and DATEDIFF(DAY,revised_planned_date,ps_actualdate) <=15) as delayed,
(select COUNT(*) as critical from swift_packagestatus as a
where active=1   and DATEDIFF(DAY,revised_planned_date,ps_actualdate) >15) as critical 
from  swift_packagestatus   group by ps_projid";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function repo_dash($pid, $stage)
    {
        if ($pid == "") {
            $sql = "select distinct ps_userid, proj_id,ps_packid,pm_packagename,proj_name,stage_name,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1 and ps_stageid in($stage)
 and ps_stageid=stage_id";
        } else {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1 and ps_stageid in($stage)
 and ps_stageid=stage_id and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_dash11($pid, $stage, $segment)
    {
        if ($pid == "") {
            $sql = "select distinct ps_userid, proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1 and ps_stageid in($stage)
 and ps_stageid=stage_id $segment";
        } else {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1 and ps_stageid in($stage)
 and ps_stageid=stage_id and proj_id='" . $pid . "' $segment";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_dash1($pid, $stage)
    {
        if ($pid == "") {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1 and ps_packid in(select distinct a.swift_packid from solution as a,Quote_Approval as b 
where a.sol_id= b.Sol_id and swift_packid!='' and b.Status=0 )
 and ps_stageid=stage_id";
        } else {
            $sql = "select distinct ps_userid, proj_id,ps_packid,pm_packagename,proj_name,stage_name,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1 and ps_packid in(select distinct a.swift_packid from solution as a,Quote_Approval as b 
where a.sol_id= b.Sol_id and swift_packid!='' and b.Status=0 )
 and ps_stageid=stage_id and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_dash2($pid, $stage, $segment)
    {

        if ($pid == "") {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1 and ps_packid in(select distinct a.swift_packid from solution as a,Quote_Approval as b 
where a.sol_id= b.Sol_id and swift_packid!='' and b.Status=0 $segment)
 and ps_stageid=stage_id";
        } else {
            $sql = "select distinct ps_userid, proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1 and ps_packid in(select distinct a.swift_packid from solution as a,Quote_Approval as b 
where a.sol_id= b.Sol_id and swift_packid!='' and b.Status=0 )
 and ps_stageid=stage_id and proj_id='" . $pid . "' $segment";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_packid($pid)
    {
        if ($pid == "") {
            $sql = "select distinct a.swift_packid from solution as a,Quote_Approval as b 
where a.sol_id= b.Sol_id and swift_packid!='' and b.Status=1";
        } else {
            $sql = "select distinct a.swift_packid from solution as a,Quote_Approval as b 
where a.sol_id= b.Sol_id and swift_packid!='' and b.Status=1 and Proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        $k = 0;
        while ($row = mssql_fetch_assoc($query)) {
            $result[$k] = $row['swift_packid'];
            $k++;
        }

        return $result;
    }

    function get_deviations($pack_id, $stageid, $projid)
    {

        $sql = " select top 1 (isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0)) as daysdif from  swift_packagestatus 
 where ps_packid='$pack_id'  and ps_actualdate !='' and ps_stageid <= '$stageid' and 
'$stageid' <= (select ps_stageid from swift_packagestatus where active=1 and ps_packid='$pack_id' and ps_projid='$projid') and ps_projid='$projid' 
order by ps_stageid DESC ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function get_deviations_version1($pack_id, $stageid, $projid)
    {
        $con = new dbcon2();
        $dbcon1 = $con->getValue();
        $sql = " select top 1 (isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0)) as daysdif from  swift_packagestatus 
 where ps_packid='$pack_id'  and ps_actualdate !='' and ps_stageid <= '$stageid' and 
'$stageid' <= (select ps_stageid from swift_packagestatus where active=1 and ps_packid='$pack_id' and ps_projid='$projid') and ps_projid='$projid' 
order by ps_stageid DESC ";
        $query = mssql_query($sql, $dbcon1);
        $row = mssql_fetch_array($query);
        return $row;
    }


    function fetch_buyername($packid)
    {
        $sql = "select name,bu_buyer_id from swift_SCMtoBUYER,usermst where bu_packid='" . $packid . "' and bu_buyer_id=uid and bu_status IN(0,1,2)  ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $name = $row['name'];
        return $name;
    }

    function team_reamrks($proj_id, $pack_id, $team_id)
    {
        // if ($team_id == 1) {  //technical team
        //     $sql = "SELECT * FROM swift_techspoc 
        //     LEFT JOIN swift_techexpert ON ts_packid=txp_packid AND ts_projid=txp_projid AND txp_status='1' AND txp_active='1'
        //     LEFT JOIN swift_techCTO ON ts_packid=cto_packid AND ts_projid=cto_projid AND cto_status='1' AND cto_active='1'
        //     LEFT JOIN swift_CTOtoOPS ON ctops_packid=cto_packid AND ctops_projid=ts_projid AND ctops_status='1' AND ctops_active='1'
        //     WHERE ts_projid='" . $proj_id . "' AND ts_packid='" . $pack_id . "' AND ts_status='1' AND ts_active='1'";
        // } else if ($team_id == 2) { // o&m team
        //     $sql = "SELECT * FROM swift_OMtoOPs WHERE omop_projid='" . $proj_id . "' AND omop_packid='" . $pack_id . "' AND omop_status in (0,1) AND omop_active='1'";
        // } else if ($team_id == 3) { //operation team
        //     $sql = "SELECT * FROM swift_SCMSPOC WHERE sc_projid='$proj_id' AND sc_packid='$pack_id' AND sc_active='1'";
        // }

        $sql = "select a.*,c.shot_name from swift_transactions as a
         left join swift_workflow_CurrentStage as b on a.st_packid=b.cs_packid
         left join swift_stage_master  as c on c.stage_id=b.to_stage_id
         where st_packid=$pack_id and st_projid=$proj_id";

        $query = mssql_query($sql);
        $nrow = mssql_num_rows($query);
        if ($nrow > 0) {
            $row = mssql_fetch_array($query);
            // if ($team_id == 1) {
            if (trim($row['st_remarks']) != "") {
                echo "<b>Techo Spoc Remarks</b> - " . formatDate($row['st_sentdate'], 'd-M-Y');
                echo "<br>";
                echo $row['st_remarks'];
                echo "<br><br>";
            }

            //}
        }
    }
    function team_reamrksv1($proj_id, $pack_id, $team_id)
    {
        if ($team_id == 1) { //technical team
            $sql = "SELECT * FROM swift_techspoc 
            LEFT JOIN swift_techexpert ON ts_packid=txp_packid AND ts_projid=txp_projid AND txp_status='1' AND txp_active='1'
            LEFT JOIN swift_techCTO ON ts_packid=cto_packid AND ts_projid=cto_projid AND cto_status='1' AND cto_active='1'
            LEFT JOIN swift_CTOtoOPS ON ctops_packid=cto_packid AND ctops_projid=ts_projid AND ctops_status='1' AND ctops_active='1'
            WHERE ts_projid='" . $proj_id . "' AND ts_packid='" . $pack_id . "' AND ts_status='1' AND ts_active='1'";
        } else if ($team_id == 2) { // o&m team
            $sql = "SELECT * FROM swift_OMtoOPs WHERE omop_projid='" . $proj_id . "' AND omop_packid='" . $pack_id . "' AND omop_status in (0,1) AND omop_active='1'";
        } else if ($team_id == 3) { //operation team
            $sql = "SELECT * FROM swift_SCMSPOC WHERE sc_projid='$proj_id' AND sc_packid='$pack_id' AND sc_active='1'";
        }
    }
    function prev_reamrkslist($projid, $pack_id)
    {

        $sql = "select a.*,c.shot_name from swift_transactions as a
        left join swift_workflow_CurrentStage as b on a.st_packid=b.cs_packid
        left join swift_stage_master  as c on c.stage_id=a.st_stageid
        where st_packid=$pack_id and st_projid=$projid order by a.st_stageid";
        // $sql = "select * from  dbo.swift_transactions where st_projid='" . $projid . "' and st_packid='" . $pack_id . "' order by st_id ASC";
        $query = mssql_query($sql);

        $msg = '';

        while ($row = mssql_fetch_array($query)) {
            $remarks = $row['st_remarks'];
            $shot_name = $row['shot_name'];
            if ($remarks == "") {
                $remarks = '-';
            }
            $msg .= $shot_name;
            $msg .= '  - </b>' . formatDate($row['st_actual'], 'd-M-Y');
            $msg .= ':';
            $msg .= $remarks;
            $msg .= '<br>';
        }
        echo $msg;
    }
    function prev_reamrks($stage, $pack_id, $uname)
    {
        $sql = "select * from  dbo.swift_transactions where st_stageid='" . $stage . "' and st_packid='" . $pack_id . "'";
        $query = mssql_query($sql);

        $msg = '';

        while ($row = mssql_fetch_array($query)) {
            $remarks = $row['st_remarks'];
            if ($remarks == "") {
                $remarks = '-';
            }
            $msg .= '<b>Remarks</b> -' . formatDate($row['st_actual'], 'd-M-Y');
            $msg .= '';
            $msg .= $remarks;
            $msg .= '';
        }
        echo $msg;
    }
    //    function prev_reamrks1($stage, $pack_id,$uname){
    //        $sql ="select * from  dbo.swift_transactions where st_stageid='".$stage."' and st_packid='".$pack_id."'";
    //        $query = mssql_query($sql);
    //
    //        $msg='';
    //
    //        while ($row = mssql_fetch_array($query)) {
    //            $remarks =$row['st_remarks'];
    //            if( $remarks == ""){
    //                $remarks= '-';
    //
    //            }
    //            $msg.='<b>'.$uname.' - Remarks</b> -' . formatDate($row['st_actual'], 'd-M-Y');
    //            $msg.='<br>';
    //            $msg.=$remarks;
    //            $msg.='<br>';
    //        }
    //        echo $msg;
    //    }

    function select_allprojects_seg($segment)
    {
        if ($segment != "") {
            $sql = "select * from Project where cat_id='" . $segment . "' order by proj_name ASC";
        } else {
            $sql = "select * from Project   order by proj_name ASC";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_allprojects_seg1($segment)
    {
        if ($segment != "") {
            $sql = "select * from Project where  $segment order by proj_name ASC";
        } else {
            $sql = "select * from Project   order by proj_name ASC";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_filterprojects_seg2($seg,  $type)
    {
        $where = "";
        $$where2 = "";
        $uid = $_SESSION['uid'];
        //echo $_SESSION['usertype'];
        if ($_SESSION['usertype'] != 0) {
            $where = "and pa.uid =$uid";
            //echo $where;
        }
        // if($seg!=''){
        //   //$where1=" WHERE pa.uid = $uid and pa.seg_id=$seg ";
        //    $where1=" WHERE pa.uid = $uid ";
        // }
        if ($type != '') {
            if ($type != '-') {
                $where2 .= " and p.proj_type=$type";
            }
        }

        $sql = "select distinct p.proj_id,p.proj_name from project_assign as pa 
        inner join Project as p on (pa.proj_id = p.proj_id) $where $where2 
        order by p.proj_name ASC";
        // echo $sql;
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function select_allprojects_seg1_swift($segment)
    {
        if ($segment != "") {
            $sql = "select distinct pm_projid,b.* from  swift_packagemaster as a,Project as b where a.pm_projid=b.proj_id   $segment order by b.proj_name ASC";
        } else {
            $sql = " select distinct pm_projid,b.* from  swift_packagemaster as a,Project as b where a.pm_projid=b.proj_id   order by b.proj_name ASC";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function main_dash1($pid, $segment)
    {
        $where = "";
        $uid = $_SESSION['uid'];
        if ($_SESSION['usertype'] != 0) {
            $where = "and pa.uid =$uid";
        }
        if ($pid == "") {
            $sql = "WITH RankedPackageStatus AS (
                    SELECT ps_packid,ps_projid,ps_userid,ps_stageid,ps_actualdate,ps_planneddate,ps_expdate,ps_stback,revised_planned_date,
                        ROW_NUMBER() OVER (PARTITION BY ps_packid, ps_projid ORDER BY ps_actualdate DESC) AS row_num
                    FROM swift_packagestatus
                    )
                    SELECT DISTINCT c.pm_packid,ut.type_name AS dept,rps.ps_userid,b.proj_id,rps.ps_packid,c.pm_packagename,b.proj_name,b.proj_type,d.stage_name,rps.ps_stageid,rps.ps_stback,
                    ISNULL(DATEDIFF(DAY, rps.revised_planned_date, rps.ps_actualdate), 0) AS daysdif,
                    ISNULL(DATEDIFF(DAY, rps.ps_actualdate, GETDATE()), 0) AS nodays,rps.revised_planned_date AS planned,rps.ps_expdate,rps.ps_actualdate AS actual,
                    c.pm_revised_material_req,c.pm_revised_lead_time,shot_name,u.name AS sname,b.proj_name,
                        (SELECT MAX(ps_actualdate)  FROM swift_packagestatus  WHERE ps_packid = c.pm_packid AND ps_stageid = 12) AS ss_app_actualdate,
                        (SELECT MAX(ps_planneddate) FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 12) AS ss_app_plandate,
                        (SELECT MAX(ps_actualdate)  FROM swift_packagestatus  WHERE ps_packid = c.pm_packid AND ps_stageid = 15) AS po_actdate,
                        (SELECT MAX(ps_planneddate) FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 15) AS po_planneddate
                    FROM swift_packagemaster AS c
                    INNER JOIN Project AS b ON c.pm_projid = b.proj_id
                    INNER JOIN RankedPackageStatus AS rps ON c.pm_packid = rps.ps_packid AND c.pm_projid = rps.ps_projid AND rps.row_num = 1
                    LEFT JOIN swift_workflow_CurrentStage AS cs ON c.pm_packid = cs.cs_packid AND c.pm_projid = cs.cs_projid
                    LEFT JOIN swift_stage_master AS d ON cs.to_stage_id = d.stage_id
                    LEFT JOIN usermst AS u ON cs.to_uid = u.uid
                    LEFT JOIN user_type_master AS ut ON ut.id = d.usertype
                    LEFT JOIN project_assign AS pa ON c.pm_projid = pa.proj_id
                    WHERE c.pm_wfid != '' $where  
                    ORDER BY c.pm_packid DESC";
        } else {
            $sql = "WITH RankedPackageStatus AS (
                    SELECT ps_packid,ps_projid,ps_userid,ps_stageid,ps_actualdate,ps_planneddate,ps_expdate,ps_stback,revised_planned_date,
                        ROW_NUMBER() OVER (PARTITION BY ps_packid, ps_projid ORDER BY ps_actualdate DESC) AS row_num
                    FROM swift_packagestatus
                    )
                    SELECT DISTINCT c.pm_packid,ut.type_name AS dept,rps.ps_userid,b.proj_id,rps.ps_packid,c.pm_packagename,b.proj_name,b.proj_type,d.stage_name,rps.ps_stageid,rps.ps_stback,
                    ISNULL(DATEDIFF(DAY, rps.revised_planned_date, rps.ps_actualdate), 0) AS daysdif,
                    ISNULL(DATEDIFF(DAY, rps.ps_actualdate, GETDATE()), 0) AS nodays,rps.revised_planned_date AS planned,rps.ps_expdate,rps.ps_actualdate AS actual,
                    c.pm_revised_material_req,c.pm_revised_lead_time,shot_name,u.name AS sname,b.proj_name,
                        (SELECT MAX(ps_actualdate)  FROM swift_packagestatus  WHERE ps_packid = c.pm_packid AND ps_stageid = 12) AS ss_app_actualdate,
                        (SELECT MAX(ps_planneddate) FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 12) AS ss_app_plandate,
                        (SELECT MAX(ps_actualdate)  FROM swift_packagestatus  WHERE ps_packid = c.pm_packid AND ps_stageid = 15) AS po_actdate,
                        (SELECT MAX(ps_planneddate) FROM swift_packagestatus WHERE ps_packid = c.pm_packid AND ps_stageid = 15) AS po_planneddate
                    FROM swift_packagemaster AS c
                    INNER JOIN Project AS b ON c.pm_projid = b.proj_id
                    INNER JOIN RankedPackageStatus AS rps ON c.pm_packid = rps.ps_packid AND c.pm_projid = rps.ps_projid AND rps.row_num = 1
                    LEFT JOIN swift_workflow_CurrentStage AS cs ON c.pm_packid = cs.cs_packid AND c.pm_projid = cs.cs_projid
                    LEFT JOIN swift_stage_master AS d ON cs.to_stage_id = d.stage_id
                    LEFT JOIN usermst AS u ON cs.to_uid = u.uid
                    LEFT JOIN user_type_master AS ut ON ut.id = d.usertype
                    LEFT JOIN project_assign AS pa ON c.pm_projid = pa.proj_id
                    WHERE c.pm_wfid != '' $where  and b.proj_id='" . $pid . "'
                    ORDER BY c.pm_packid DESC";
            //    echo $sql = "SELECT distinct pm_packid, ut.type_name as dept,ps_userid,b.proj_id,ps_packid,pm_packagename,proj_name,b.proj_type,stage_name,ps_stageid,ps_stback,
            //     isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
            //     (isnull(DATEDIFF(DAY,a.ps_actualdate,GETDATE()),0)) as nodays, revised_planned_date as 
            //     planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time,shot_name,
            //     u.name as sname,u.name,proj_name,
            //     (select MAX(ps_actualdate) from  swift_packagestatus where ps_packid=c.pm_packid and ps_stageid=12) as  ss_app_actualdate,
            //     (select MAX(ps_planneddate) from  swift_packagestatus where ps_packid=c.pm_packid and ps_stageid=12) as  ss_app_plandate,
            //     (select MAX(ps_actualdate) from swift_packagestatus where ps_packid=c.pm_packid and ps_stageid=15) as  po_actdate,
            //     (select MAX(ps_planneddate) from swift_packagestatus where ps_packid=c.pm_packid and ps_stageid=15) as  po_planneddate
            //     from swift_packagestatus as a
            //     inner join Project as b on a.ps_projid=b.proj_id
            //     inner join swift_packagemaster as c on a.ps_packid=c.pm_packid and a.ps_projid=c.pm_projid
            //     inner join swift_workflow_CurrentStage as cs on a.ps_packid=cs.cs_packid and a.ps_projid=cs.cs_projid
            //     inner join swift_stage_master as d on cs.to_stage_id=d.stage_id
            //     inner join usermst as u on cs.to_uid=u.uid 
            //     inner join user_type_master as ut on ut.id=d.usertype
            //     inner join project_assign as pa on a.ps_projid=pa.proj_id 
            //     where pm_wfid!='' $where  and b.proj_id='" . $pid . "' order by pm_packid desc ";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_weightage($pack_id, $stageid, $projid)
    {
        echo $sql = "select  sum(weightage) as weightage from  swift_packagestatus,swift_stage_master 
 where ps_packid='$pack_id'  and ps_actualdate !='' and ps_stageid < '$stageid' and stage_id=ps_stageid and 
'$stageid' <= (select ps_stageid from swift_packagestatus 
where active=1 and ps_packid='$pack_id' and ps_projid='$projid') and ps_projid='$projid' 
group by ps_projid";

        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $weightage = $row['weightage'];
        return $weightage;
    }

    function package_report($pack_id, $stageid, $projid)
    {
        $sql = "select  sum(weightage) as weightage from  swift_packagestatus,swift_stage_master 
 where ps_packid='$pack_id'  and ps_actualdate !='' and ps_stageid < '$stageid' and stage_id=ps_stageid and 
'$stageid' <= (select ps_stageid from swift_packagestatus 
where active=1 and ps_packid='$pack_id' and ps_projid='$projid') and ps_projid='$projid' 
group by ps_projid";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function load_package_report($proj_id, $seg)
    {
        if ($proj_id == "") {
            $sql = "select SUBSTRING(pm_packagename, 1, 20) as package,
(select sum (weightage) from swift_stage_master where stage_id < ps_stageid ) as complete,
(select sum (weightage) from swift_stage_master where stage_id >=  ps_stageid ) as incomplete
from swift_packagestatus ,swift_stage_master,Project,swift_packagemaster 
where  stage_id=ps_stageid and   active=1   and ps_projid=proj_id  and  pm_packid=ps_packid $seg";
        } else {
            $sql = "select SUBSTRING(pm_packagename, 1, 5) as package,
(select sum (weightage) from swift_stage_master where stage_id < ps_stageid ) as complete,
(select sum (weightage) from swift_stage_master where stage_id >=  ps_stageid ) as incomplete
from swift_packagestatus ,swift_stage_master,swift_packagemaster  
where  stage_id=ps_stageid and ps_projid='" . $proj_id . "' and  pm_packid=ps_packid  and  active=1";
        }

        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $result = array();
            while ($row = mssql_fetch_assoc($query)) {
                $result[] = $row;
            }
            $res = json_encode($result);
            return $res;
        }
    }

    function select_user1($uid)
    {
        $sql = "select uid,name,proj_ids,uname from usermst as A
                inner join project_spec_access as B ON B.proj_uid=A.uid
                where usertype in(6) and A.uid='" . $uid . "' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }


    // by sakthi
    function loi_detail1($pack_id)
    {
        // $sql = "SELECT * from swift_filesfrom_smartsignoff where so_pack_iD='" . $pack_id . "' and loi_number is not null ";
        // $sql = "SELECT top 1 * from swift_filesfrom_smartsignoff as sfs
        // left join Swift_LOI_Details as loi on loi.loi_packid=sfs.so_pack_id 
        // left join swift_transactions as st on sfs.so_pack_id=st.st_packid 
        // where sfs.so_pack_id='" . $pack_id . "' and sfs.loi_number is not null and st.st_stageid=14";
        $sql = " SELECT a.*,pm_packid,to_remark,pm_projid,proj_name,pm_packagename,stage_name,revised_planned_date as planned,GETDATE() as actual,
        ps_expdate,pm_material_req,pm_revised_material_req from  Swift_po_wo_Details as a 
        inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
        inner join Project  as  p on p.proj_id=a.pw_projid 
        inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
        inner join swift_packagemaster as c on a.pw_packid = c.pm_packid and a.pw_projid=c.pm_projid
        inner join swift_stage_master as g on g.stage_id=14 
        where  a.emr_flag=1 and  d.active='1' and pm_packid='$pack_id' 
       and  ( a.po_wo_status ='1'or a.po_wo_status ='3')";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function loi_attach($pack_id)
    {
        $sql = "select * from swift_loi_uploads	where loi_up_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }


    function get_ss_actdate($pack_id)
    {
        $sql = "SELECT *
         from  swift_filesfrom_smartsignoff WHERE so_pack_id='$pack_id'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function get_userSeg($uid)
    {
        $sql = "select * from usermst where uid='" . $uid . "' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    function get_deviations_latest($pack_id, $stageid, $projid)
    {
        $sql = " select top 1 (isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0)) as daysdif from  swift_packagestatus 
 where ps_packid='$pack_id'  and ps_actualdate !='' and ps_stageid <= '$stageid' and 
'$stageid' <= (select ps_stageid from swift_packagestatus where active=1 and ps_packid='$pack_id' and ps_projid='$projid') and ps_projid='$projid' 
order by ps_stageid DESC ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
}
