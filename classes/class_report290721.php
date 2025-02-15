<?php

class Report {

    function techspoc_dash($pid) {
        if ($pid == "") {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id";
        } else {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
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

    function techspoc_dash11($pid, $segment) {
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

    function om_dash($pid) {
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

    function repo_files_fortechspoc($pid) {
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

    function repo_files_fortechspoc_initiated($pid, $segment) {
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

    function om_count_cleared($pid, $segment) {
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

    function ops_count_cleared($pid,$segment) {
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

    function scm_underfinal($pid, $segment) {
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

    function scm_underfinal_porgress($pid) {
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

    function app_completed($pid, $segment) {
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

    function app_completedfinal($pid, $segment) {
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

    function final_status($pid) {
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

    function repo_dash($pid, $stage) {
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

    function repo_dash11($pid, $stage, $segment) {
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

    function repo_dash1($pid, $stage) {
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

    function repo_dash2($pid, $stage, $segment) {
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

    function get_packid($pid) {
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

    function get_deviations($pack_id, $stageid, $projid) {
        $sql = " select top 1 (isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0)) as daysdif from  swift_packagestatus 
 where ps_packid='$pack_id'  and ps_actualdate !='' and ps_stageid < '$stageid' and 
'$stageid' <= (select ps_stageid from swift_packagestatus where active=1 and ps_packid='$pack_id' and ps_projid='$projid') and ps_projid='$projid' 
order by ps_stageid DESC ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function fetch_buyername($packid) {
        $sql = "select name,bu_buyer_id from swift_SCMtoBUYER,usermst where bu_packid='" . $packid . "' and bu_buyer_id=uid and bu_status IN(0,1,2)  ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $name = $row['name'];
        return $name;
    }

    function team_reamrks($proj_id, $pack_id, $team_id) {
        if ($team_id == 1) {  //technical team
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

        $query = mssql_query($sql);
        $nrow = mssql_num_rows($query);
        if ($nrow > 0) {
            $row = mssql_fetch_array($query);
            if ($team_id == 1) {
                if (trim($row['txp_remarks']) != "") {
                    echo "<b>Techo Spoc Remarks</b> - " . date('d-M-Y', strtotime($row['txp_sentdate']));
                    echo "<br>";
                    echo $row['txp_remarks'];
                    echo "<br><br>";
                }
                if (trim($row['cto_remarks']) != "") {
                    echo "<b>Techo Expert Remarks</b> - " . date('d-M-Y', strtotime($row['cto_sentdate']));
                    echo "<br>";
                    echo $row['cto_remarks'];
                    echo "<br><br>";
                }
                if (trim($row['ctops_remarks']) != "") {
                    echo "<b>Techo CTO Remarks</b>- " . date('d-M-Y', strtotime($row['ctops_sentdate']));
                    echo "<br>";
                    echo $row['ctops_remarks'];
                }
            } else if ($team_id == 2) {
                if (trim($row['omop_remarks']) != "") {
                    echo "<b>OM Remarks</b> -" . date('d-M-Y', strtotime($row['omop_sentdate']));
                    echo "<br>";
                    echo $row['omop_remarks'];
                }
            } else if ($team_id == 3) {
                if (trim($row['sc_remarks']) != "") {
                    echo "<b>OPS Remarks</b> -" . date('d-M-Y', strtotime($row['sc_sentdate']));
                    echo "<br>";
                    echo $row['sc_remarks'];
                }
            }
        }
    }
    function prev_reamrks($stage, $pack_id,$uname){
        $sql ="select * from  dbo.swift_transactions where st_stageid='".$stage."' and st_packid='".$pack_id."'";
        $query = mssql_query($sql);

        $msg='';

        while ($row = mssql_fetch_array($query)) {
            $remarks =$row['st_remarks'];
            if( $remarks == ""){
                $remarks= '-';

            }
            $msg.='<b>Remarks</b> -' . date('d-M-Y', strtotime($row['st_actual']));
            $msg.='<br>';
            $msg.=$remarks;
            $msg.='<br>';
        }
        echo $msg;
    }

    function select_allprojects_seg($segment) {
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

    function select_allprojects_seg1($segment) {
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
    function select_allprojects_seg1_swift($segment) {
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

    function techspoc_dash1($pid, $segment) {
        if ($pid == "") {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1 $segment
 and ps_stageid=stage_id";
        } else {
            $sql = "select distinct ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1 $segment
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

    function get_weightage($pack_id, $stageid, $projid) {
        $sql = "select  sum(weightage) as weightage from  swift_packagestatus,swift_stage_master 
 where ps_packid='$pack_id'  and ps_actualdate !='' and ps_stageid < '$stageid' and stage_id=ps_stageid and 
'$stageid' <= (select ps_stageid from swift_packagestatus 
where active=1 and ps_packid='$pack_id' and ps_projid='$projid') and ps_projid='$projid' 
group by ps_projid";

        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $weightage = $row['weightage'];
        return $weightage;
    }

    function package_report($pack_id, $stageid, $projid) {
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

    function load_package_report($proj_id, $seg) {
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

    function select_user1($uid) {
        $sql = "select uid,name,proj_ids,uname from usermst as A
                inner join project_spec_access as B ON B.proj_uid=A.uid
                where usertype in(6) and A.uid='".$uid."' ";
         $query = mssql_query($sql);
         $row = mssql_fetch_array($query);         
         return $row;
    }

    // by sakthi
    function loi_detail1($pack_id) {
        // $sql = "SELECT * from swift_filesfrom_smartsignoff where so_pack_iD='" . $pack_id . "' and loi_number is not null ";
        $sql = "SELECT top 1 * from swift_filesfrom_smartsignoff as sfs
        left join swift_transactions as st on sfs.so_pack_id=st.st_packid 
        where sfs.so_pack_id='" . $pack_id . "' and sfs.loi_number is not null and st.st_stageid=18";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function loi_attach($pack_id) {
        $sql = "select * from swift_loi_uploads	where loi_up_packid='".$pack_id."'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }


    function get_ss_actdate($pack_id) {
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

}

?>
