<?php

class Count {  

    function select_techspoc_workflow_count($id,$segment) {
        if ($id != "") {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' AND ts_projid= '$id'";
            $sql = "SELECT count(ts_id) as count FROM swift_techspoc,swift_packagestatus,Project WHERE ts_status = '0' 
           AND ts_active = '1' AND ps_stageid = '3' and ts_packid=ps_packid AND ts_projid= '$id'  and ts_projid=proj_id and cat_id in($segment)";
        } else {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' ";
            $sql = "SELECT count(ts_id) as count  FROM swift_techspoc,swift_packagestatus,Project WHERE ts_status = '0' 
           AND ts_active = '1' AND ps_stageid = '3' AND ts_packid=ps_packid  and ts_projid=proj_id and cat_id in($segment)";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function select_techspoc_repository_count($id,$segment) {
        if ($id != "") {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' AND ts_projid= '$id'";
            $sql = "SELECT count(ts_id) as count FROM swift_techspoc,swift_packagestatus,Project WHERE ts_status = '1' 
           AND ts_active = '1' AND ps_stageid = '3' and ts_packid=ps_packid AND ts_projid= '$id' and ts_projid=proj_id and cat_id in($segment)";
        } else {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' ";
            $sql = "SELECT count(ts_id) as count  FROM swift_techspoc,swift_packagestatus,Project WHERE ts_status = '1' 
           AND ts_active = '1' AND ps_stageid = '3' AND ts_packid=ps_packid and ts_projid=proj_id and cat_id in($segment)";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function tech_expert_workflow_count($id, $uid) {
        if ($id != "") {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '0' AND txp_active='1' AND txp_projid = '$id' AND txp_recvuid='$uid'";
        } else {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '0' AND txp_active='1' AND txp_recvuid='$uid'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function tech_expert_repository_count($id, $uid) {
        if ($id != "") {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert WHERE txp_status = '1' AND txp_active='1' AND txp_projid = '$id' AND txp_recvuid='$uid'";
        } else {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert WHERE txp_status = '1' AND txp_active='1' AND txp_recvuid='$uid'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function files_for_technical_approval_count($id,$uid) {
        if ($id != "") {
            $sql = "SELECT count(tech_id) as count FROM swift_techapproval,swift_packagestatus,swift_packagemaster WHERE ps_packid=tech_packid AND pm_packid=tech_packid AND ps_stageid='27'  AND  swift_techapproval.tech_status = '2' AND tech_active='1' AND tech_projid='$id' AND tech_recvuid='$uid'";
        } else {
            $sql = "SELECT count(tech_id) as count FROM swift_techapproval,swift_packagestatus,swift_packagemaster WHERE ps_packid=tech_packid AND pm_packid=tech_packid AND ps_stageid='27'  AND  swift_techapproval.tech_status = '2' AND tech_active='1' AND tech_recvuid='$uid'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function tech_cto_workflow_count($id) {
        if ($id != "") {
            $sql = "SELECT count(cto_id) as count FROM Project,swift_packagemaster,swift_techCTO,swift_packagestatus 
            WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '0' AND cto_active = '1' AND ps_stageid='6' AND cto_projid='$id'";
        } else {
            $sql = "SELECT count(cto_id) as count FROM Project,swift_packagemaster,swift_techCTO,swift_packagestatus 
            WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '0' AND cto_active = '1' AND ps_stageid='6'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
     function tech_cto_workflow_countM($id,$uid) {
        if ($id != "") {
            $sql = "SELECT count(cto_id) as count FROM Project,swift_packagemaster,swift_techCTO,swift_packagestatus 
            WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '0' AND cto_active = '1' AND ps_stageid='6' AND cto_projid='$id' AND cto_recvuid='$uid'";
        } else {
            $sql = "SELECT count(cto_id) as count FROM Project,swift_packagemaster,swift_techCTO,swift_packagestatus 
            WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '0' AND cto_active = '1' AND ps_stageid='6' AND cto_recvuid='$uid'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function tech_cto_repository_count($id) {
        if ($id != "") {
            $sql = "SELECT count(cto_id) as count FROM swift_techCTO,swift_packagestatus,swift_packagemaster,Project WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '1' AND cto_active = '1' AND ps_stageid='6' AND cto_projid='$id'";
        } else {
            $sql = "SELECT count(cto_id) as count FROM swift_techCTO,swift_packagestatus,swift_packagemaster,Project WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '1' AND cto_active = '1' AND ps_stageid='6'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
     function tech_cto_repository_countM($id,$uid) {
        if ($id != "") {
            $sql = "SELECT count(cto_id) as count FROM swift_techCTO,swift_packagestatus,swift_packagemaster,Project WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '1' AND cto_active = '1' AND ps_stageid='6' AND cto_projid='$id' AND cto_recvuid='$uid'";
        } else {
            $sql = "SELECT count(cto_id) as count FROM swift_techCTO,swift_packagestatus,swift_packagemaster,Project WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '1' AND cto_active = '1' AND ps_stageid='6' AND cto_recvuid='$uid'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function scm_workflow_count($id) {
        if ($id != "") {
            $sql = "SELECT count(sc_id) as count FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND sc_status='0' AND sc_active='1' AND sc_projid= '$id'";
        } else {
            $sql = "SELECT count(sc_id) as count FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND sc_status='0' AND sc_active='1'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function files_from_buyer_count($id) {
        if ($id != "") {
            $sql = "SELECT count(bu_id) as count FROM swift_SCMtoBUYER,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '13' AND bu_packid=ps_packid AND bu_packid=pm_packid AND bu_status='2' AND bu_projid= '$id'";
        } else {
            $sql = "SELECT count(bu_id) as count FROM swift_SCMtoBUYER,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '13' AND bu_packid=ps_packid AND bu_packid=pm_packid AND bu_status='2'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function select_smartsignoff_count($id, $uid) {
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT  count(so_id) as count
FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_SCMtoBUYER 
WHERE so_pack_id=pm_packid AND so_pack_id=ps_packid AND active='1' and (so_hw_sw=2 and po_wo_status ='0' or so_hw_sw=3 and po_wo_status ='2' ) 
and bu_packid=so_pack_id and bu_status=1 and bu_buyer_id='" . $uid . "' and so_proj_id= '$id' and emr_status=1";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT  count(so_id) as count
FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_SCMtoBUYER 
WHERE so_pack_id=pm_packid AND so_pack_id=ps_packid AND active='1' and (so_hw_sw=2 and po_wo_status ='0' or so_hw_sw=3 and po_wo_status ='2' ) 
and bu_packid=so_pack_id and bu_status=1 and bu_buyer_id='" . $uid . "' and emr_status=1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
    
    function select_smartsignoff_count1($id, $uid) {
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT  count(so_id) as count
FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_SCMtoBUYER 
WHERE so_pack_id=pm_packid AND so_pack_id=ps_packid AND active='1' and (so_hw_sw=2 and po_wo_status ='1' or so_hw_sw=3 and po_wo_status ='3' )
and bu_packid=so_pack_id and bu_status=1 and bu_buyer_id='" . $uid . "' and so_proj_id= '$id'";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT  count(so_id) as count
FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_SCMtoBUYER 
WHERE so_pack_id=pm_packid AND so_pack_id=ps_packid AND active='1' and (so_hw_sw=2 and po_wo_status ='1' or so_hw_sw=3 and po_wo_status ='3' )
and bu_packid=so_pack_id and bu_status=1 and bu_buyer_id='" . $uid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function loi_update_count($id, $uid) {
        if ($id != "") {
            $sql = "select  count(distinct so_pack_id) as count 
from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master,swift_SCMtoBUYER   
where proj_id=so_proj_id and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "' and
so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=18 
and stage_id=18  and so_status=0 and bu_status=1 and so_proj_id= '$id' ";
        } else {
            $sql = "select  count(distinct so_pack_id) as count 
from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master,swift_SCMtoBUYER   
where proj_id=so_proj_id and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "' and
so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=18 
and stage_id=18  and so_status=0 and bu_status=1 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function select_lc_count($id) {
        if ($id != "") {
            $sql = "SELECT count(cm_id) as count FROM swift_checklist_mapping,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '24' AND cm_pack_id=ps_packid AND cm_pack_id=pm_packid AND cm_lc='1' AND lc_complete = '0' AND cm_proj_id = '$id'";
        } else {
            $sql = "SELECT count(cm_id) as count FROM swift_checklist_mapping,swift_packagestatus,swift_packagemaster
            WHERE ps_stageid = '24' AND cm_pack_id=ps_packid AND cm_pack_id=pm_packid AND cm_lc='1' AND lc_complete = '0'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function select_rpa_count($id) {
        if ($id != "") {
            $sql = "SELECT count(cm_id) as count FROM swift_checklist_mapping,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '24' AND cm_pack_id=ps_packid AND cm_pack_id=pm_packid AND cm_rpa='1' AND RPA_complete = '0' AND cm_proj_id = '$id'";
        } else {
            $sql = "SELECT count(cm_id) as count FROM swift_checklist_mapping,swift_packagestatus,swift_packagemaster
            WHERE ps_stageid = '24' AND cm_pack_id=ps_packid AND cm_pack_id=pm_packid AND cm_rpa='1' AND RPA_complete = '0'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function select_lc_repository_count($id) {
        if ($id != "") {
            $sql = "SELECT count(lr_id) as count FROM swift_lc_rpa where lc_number !='' AND lr_projid = '$id'";
        } else {
            $sql = "SELECT count(lr_id) as count FROM swift_lc_rpa where lc_number !=''";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function select_rpa_repository_count($id) {
        if ($id != "") {
            $sql = "SELECT count(lr_id) as count FROM swift_lc_rpa where rpa_number !='' AND lr_projid = '$id'";
        } else {
            $sql = "SELECT count(lr_id) as count FROM swift_lc_rpa where rpa_number !=''";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function days_left($date, $col_name) {
        $sql = "SELECT DATEDIFF(DAY,GETDATE(),$col_name) as days FROM swift_lc_rpa";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function tech_expert_workflow_fromcto($id, $uid) {
        if ($id != "") {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '2' AND txp_active='1' AND txp_projid = '$id' AND txp_recvuid='$uid'";
        } else {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '2' AND txp_active='1' AND txp_recvuid='$uid'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function ttl_package($pid,$segment) {
        if ($pid != "") {
//            $sql = "select COUNT(*) as ttl_package from swift_packagemaster where pm_projid='" . $pid . "'";
            $sql = "select COUNT(*) as ttl_package  from swift_packagemaster,Project  where pm_projid =proj_id  $segment and pm_projid='" . $pid . "' ";
        } else {
//            $sql = "select COUNT(*) as ttl_package from swift_packagemaster ";
               $sql = "select COUNT(*) as ttl_package  from swift_packagemaster,Project  where pm_projid =proj_id $segment";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['ttl_package'];
        return $rowcount;
    }

    function ttl_tech_cleared($pid,$segment) {
//        if ($pid != "") {
//            $sql = "select COUNT(*) as ttl_tech_cleared from swift_techCTO where cto_status = '1' and cto_active='1' and cto_projid='" . $pid . "'";
//        } else {
//            $sql = "select COUNT(*) as ttl_tech_cleared from swift_techCTO where cto_status = '1' and cto_active='1' ";
//        }
        if ($pid != "") {
//            $sql = "select COUNT(ps_packid) as ttl_tech_cleared from swift_packagestatus where ps_stageid in(2,3,4,5,6) and active =1 and ps_projid='".$pid."'";
            $sql = "select COUNT(ps_packid) as ttl_tech_cleared from swift_packagestatus ,Project
where ps_stageid in(2,3,4,5,6) and active =1  and ps_projid=proj_id  $segment and  ps_projid='".$pid."'";
        } else {
//            $sql = "select COUNT(ps_packid) as ttl_tech_cleared from swift_packagestatus where ps_stageid in(2,3,4,5,6) and active =1 ";
             $sql = "select COUNT(ps_packid) as ttl_tech_cleared from swift_packagestatus ,Project
where ps_stageid in(2,3,4,5,6) and active =1  and ps_projid=proj_id  $segment  ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['ttl_tech_cleared'];
        return $rowcount;
    }

    function scm_cleared($pid) {
        if ($pid != "") {
            $sql = "select COUNT(*) as ttl_scm_cleared from swift_SCMSPOC where sc_status=1 and sc_active=1 and sc_projid='" . $pid . "'";
        } else {
            $sql = "select COUNT(*) as ttl_scm_cleared from swift_SCMSPOC where sc_status=1 and sc_active=1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['ttl_scm_cleared'];
        return $rowcount;
    }

    function app_inprogress($pid,$segment) {
//        if ($pid != "") {
//            $sql = "select distinct a.sol_id from solution as a,Quote_Approval as b 
//where a.sol_id= b.Sol_id and sol_projid='" . $pid . "' and swift_packid!='' and b.Status=0 ";
//        } else {
//            $sql = "select distinct a.sol_id from solution as a,Quote_Approval as b 
//where a.sol_id= b.Sol_id and swift_packid!='' and b.Status=0";
//        }
//        if ($pid != "") {
//            $sql = "select count(*) as inscmcount from swift_SCMSPOC,swift_SCMtoBUYER where bu_packid=sc_packid and bu_status in(0,1,2)";
//        } else {
//            $sql = "select count(*) as inscmcount from swift_SCMSPOC,swift_SCMtoBUYER where bu_packid=sc_packid and bu_status in(0,1,2)";
//        }
        if ($pid != "") {
//            $sql = "select count(*) as inscmcount from swift_SCMtoBUYER where  bu_status in(0,1,2) and bu_projid='".$pid."'";
            $sql = "select count(*) as inscmcount from swift_SCMtoBUYER,Project where  bu_status in(0,1,2) 
                    and proj_id=bu_projid  $segment  and bu_projid='".$pid."'";
        } else {
//            $sql = "select count(*) as inscmcount from swift_SCMtoBUYER where bu_status in(0,1,2)";
             $sql = "select count(*) as inscmcount from swift_SCMtoBUYER,Project where  bu_status in(0,1,2) 
                    and proj_id=bu_projid  $segment ";
        }
        $query = mssql_query($sql);
           $row = mssql_fetch_array($query);
        $count = $row['inscmcount'];
        return $count;
    }

    function po_completed($pid,$segment) {
        if ($pid != "") {
            $sql = "select COUNT(*) as po_completed from swift_filesfrom_smartsignoff,Project
where po_wo_status='4' and so_proj_id='" . $pid . "' and proj_id=so_proj_id $segment";
        } else {
            $sql = "select COUNT(*) as po_completed from swift_filesfrom_smartsignoff,Project
where po_wo_status='4' and proj_id=so_proj_id $segment";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['po_completed'];
        return $rowcount;
    }

    function po_progress($pid) {
        if ($pid != "") {
            $sql = "select COUNT(*) as po_completed from swift_filesfrom_smartsignoff,solution
where po_wo_status!='4' and swift_packid=so_pack_id and so_proj_id='" . $pid . "'";
        } else {
            $sql = "select COUNT(*) as po_completed from swift_filesfrom_smartsignoff,solution
where po_wo_status!='4' and swift_packid=so_pack_id";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['po_completed'];
        return $rowcount;
    }

    function wo_completed($pid,$segment) {
        if ($pid != "") {
            $sql = "select COUNT(*) as wo_completed from swift_filesfrom_smartsignoff,Project
where po_wo_status='3' and so_proj_id='" . $pid . "' and proj_id=so_proj_id $segment";
        } else {
            $sql = "select COUNT(*) as wo_completed from swift_filesfrom_smartsignoff,Project
where po_wo_status='3' and proj_id=so_proj_id $segment";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['wo_completed'];
        return $rowcount;
    }

    function wo_progress($pid) {
        if ($pid != "") {
            $sql = "select COUNT(*) as wo_completed from swift_filesfrom_smartsignoff,solution
where po_wo_status!='3' and swift_packid=so_pack_id and so_proj_id='" . $pid . "'";
        } else {
            $sql = "select COUNT(*) as wo_completed from swift_filesfrom_smartsignoff,solution
where po_wo_status!='3' and swift_packid=so_pack_id";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['wo_completed'];
        return $rowcount;
    }

    function mtr_received($pid,$segment) {
        if ($pid != "") {
            $sql = "select  distinct swe_packid  as manf_comlpeted from swift_poentrysave,swift_podetails,Project
where swid=sweid and sqty=isnull(mrqty,0) and po_proj_id='" . $pid . "' and proj_id=po_proj_id $segment ";
        } else {
            $sql = "select  distinct swe_packid  as manf_comlpeted from swift_poentrysave,swift_podetails,Project
where swid=sweid and sqty=isnull(mrqty,0) and proj_id=po_proj_id $segment  ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = mssql_num_rows($query);
        $rowcount = $row['manf_comlpeted'];
        if ($count == "") {
            $rowcount = 0;
        }
        return $count;
    }

    function mtr_progress($pid) {
        if ($pid != "") {
            $sql = "select  distinct swe_packid as manf_progress from swift_poentrysave,swift_podetails
where swid=sweid and sqty!=isnull(mrqty,0) and po_proj_id='" . $pid . "'";
        } else {
            $sql = "select  distinct swe_packid as manf_progress from swift_poentrysave,swift_podetails
where swid=sweid and sqty!=isnull(mrqty,0) ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = mssql_num_rows($query);
        $rowcount = $row['manf_progress'];
        if ($count == "") {
            $rowcount = 0;
        }
        return $count;
    }

    function manf_completed($pid,$segment) {
        if ($pid != "") {
            $sql = "select  distinct swe_packid  as manf_comlpeted from swift_poentrysave,swift_podetails,Project
where swid=sweid and sqty=isnull(mqty,0) and po_proj_id='" . $pid . "' and proj_id=po_proj_id $segment";
        } else {
            $sql = "select  distinct swe_packid  as manf_comlpeted from swift_poentrysave,swift_podetails,Project
where swid=sweid and sqty=isnull(mqty,0) and proj_id=po_proj_id $segment";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = mssql_num_rows($query);
        $rowcount = $row['manf_comlpeted'];
        if ($count == "") {
            $rowcount = 0;
        }
        return $count;
    }

    function manf_progress($pid) {
        if ($pid != "") {
            $sql = "select  distinct swe_packid as manf_progress from swift_poentrysave,swift_podetails
where swid=sweid and sqty!=isnull(mqty,0) and po_proj_id='" . $pid . "'";
        } else {
            $sql = "select  distinct swe_packid as manf_progress from swift_poentrysave,swift_podetails
where swid=sweid and sqty!=isnull(mqty,0) ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = mssql_num_rows($query);
        $rowcount = $row['manf_progress'];
        if ($count == "") {
            $rowcount = 0;
        }
        return $count;
    }

    function app_yettoinitiated($pid) {
        if ($pid != "") {
            $sql = "select count(sol_id) as yetoini from solution where swift_packid!='' and sol_projid='" . $pid . "' and sol_id not in (select distinct Sol_id from Quote_Approval)";
        } else {
            $sql = "select count(sol_id) as yetoini from solution where swift_packid!=''   and sol_id not in (select distinct Sol_id from Quote_Approval)";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = mssql_num_rows($query);
        if ($count == '') {
            $count = 0;
        } else {
            $count = $row['yetoini'];
        }
        return $count;
    }

    function partial($pid) {
        if ($pid != "") {
            $sql = "select count(distinct po_pack_id) as partial  from dbo.swift_podetails as a ,swift_poentrysave as b
where a.swid=b.sweid  and po_proj_id='" . $pid . "'";
        } else {
            $sql = "select count(distinct po_pack_id) as partial  from dbo.swift_podetails as a ,swift_poentrysave as b
where a.swid=b.sweid ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = mssql_num_rows($query);
        if ($count == '') {
            $count = 0;
        } else {
            $count = $row['partial'];
        }
        return $count;
    }

    function deliverd($pid) {
        if ($pid != "") {
            $sql = "select count(distinct po_pack_id) as delivered  from dbo.swift_podetails as a ,swift_poentrysave as b
where a.swid=b.sweid and a.sqty=b.mqty and po_proj_id='" . $pid . "'";
        } else {
            $sql = "select count(distinct po_pack_id) as delivered  from dbo.swift_podetails as a ,swift_poentrysave as b
where a.swid=b.sweid and a.sqty=b.mqty";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = mssql_num_rows($query);
        if ($count == '') {
            $count = 0;
        } else {
            $count = $row['delivered'];
        }
        return $count;
    }

}

?>
