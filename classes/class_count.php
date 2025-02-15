<?php

class Count
{

    function select_techspoc_workflow_count($id, $segment)
    {
        // echo $segment;

        // if ($segment != "") {
        //     $cond = " AND cat_id in($segment)";
        // } else {
        //     $cond = " AND cat_id!='38'";
        // }
        $senduserid = $_SESSION['uid'];
        if ($id != "") {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' AND ts_projid= '$id'";
            //     $sql = "SELECT count(ts_id) as count FROM swift_techspoc,swift_packagestatus,Project WHERE ts_status = '0' 
            //    AND ts_active = '1' AND ps_stageid = '3' and ts_packid=ps_packid AND ts_projid= '$id'  and ts_projid=proj_id and cat_id in($segment)";
            $sql = "SELECT COUNT(cs_packid) AS count 
            from swift_workflow_CurrentStage as a 
            inner join swift_packagestatus as b on a.cs_packid=b.ps_packid 
            and a.cs_projid=b.ps_projid inner join swift_packagemaster as c on c.pm_packid=b.ps_packid 
            and a.cs_projid=c.pm_projid inner join Project as d on a.cs_projid=d.proj_id
            where to_stage_id=ps_stageid and cs_active = '0' and to_uid = '$senduserid'  cs_projid= '$id' ";
        } else {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' ";
            //         $sql = "SELECT count(cs_packid) as count FROM swift_workflow_CurrentStage,swift_packagestatus,Project WHERE 
            // cs_active = '0' and to_uid = '$senduserid' and ps_stageid=to_stage_id  and cs_packid=ps_packid AND cs_projid=proj_id ";
            $sql = "SELECT COUNT(cs_packid) AS count 
    from swift_workflow_CurrentStage as a 
    inner join swift_packagestatus as b on a.cs_packid=b.ps_packid 
    and a.cs_projid=b.ps_projid inner join swift_packagemaster as c on c.pm_packid=b.ps_packid 
    and a.cs_projid=c.pm_projid inner join Project as d on a.cs_projid=d.proj_id
    where to_stage_id=ps_stageid and cs_active = '0' and to_uid = '$senduserid'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
    function select_Loi_workflow_count($id, $segment)
    {
        $senduserid = $_SESSION['uid'];
        if ($id != "") {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' AND ts_projid= '$id'";
            //     $sql = "SELECT count(ts_id) as count FROM swift_techspoc,swift_packagestatus,Project WHERE ts_status = '0' 
            //    AND ts_active = '1' AND ps_stageid = '3' and ts_packid=ps_packid AND ts_projid= '$id'  and ts_projid=proj_id and cat_id in($segment)";
            $sql = "SELECT count(cs_packid) as count FROM swift_workflow_CurrentStage,swift_packagestatus,Project WHERE 
    cs_active = '0' and to_uid = '$senduserid' and ps_stageid=to_stage_id  and cs_packid=ps_packid  AND cs_projid= '$id'  and cs_projid=proj_id and ps_stageid=13";
        } else {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' ";
            $sql = "SELECT count(cs_packid) as count FROM swift_workflow_CurrentStage,swift_packagestatus,Project WHERE 
    cs_active = '0' and to_uid = '$senduserid' and ps_stageid=to_stage_id  and cs_packid=ps_packid AND cs_projid=proj_id and ps_stageid=13";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function select_repository_count($id, $segment)
    {
        $userid = $_SESSION['uid'];
        // if ($segment != "") {
        //     $cond = " AND cat_id in($segment)";
        // } else {
        //     $cond = " AND cat_id!='38'";
        // }
        if ($id != "") {

            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' AND ts_projid= '$id'";
            $sql = " SELECT COUNT(DISTINCT a.rs_packid) AS count 
            FROM swift_repository AS a 
            INNER JOIN swift_packagestatus AS b ON a.rs_packid = b.ps_packid AND a.rs_projid = b.ps_projid 
            INNER JOIN swift_packagemaster AS c ON a.rs_packid = c.pm_packid AND a.rs_projid = c.pm_projid 
            INNER JOIN project AS e ON c.pm_projid = e.proj_id 
            WHERE (a.rs_to_uid = '$userid' OR a.rs_from_uid = '$userid') and  rs_projid= '$id'";
        } else {
            // $sql ="SELECT * FROM swift_techspoc WHERE ts_status = '0' AND ts_active = '1' ";
            //         $sql = " SELECT count(distinct rs_packid) as count FROM swift_repository,swift_packagestatus,swift_packagemaster,project 
            //    WHERE active = '1' and rs_packid=ps_packid AND rs_packid=pm_packid AND pm_projid=proj_id 
            //     AND (rs_to_uid='$userid' OR rs_from_uid='$userid')  ";
            $sql = " SELECT COUNT(DISTINCT a.rs_packid) AS count 
             FROM swift_repository AS a 
             INNER JOIN swift_packagestatus AS b ON a.rs_packid = b.ps_packid AND a.rs_projid = b.ps_projid 
             INNER JOIN swift_packagemaster AS c ON a.rs_packid = c.pm_packid AND a.rs_projid = c.pm_projid 
             INNER JOIN project AS e ON c.pm_projid = e.proj_id 
             WHERE (a.rs_to_uid = '$userid' OR a.rs_from_uid = '$userid')  ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function tech_expert_workflow_count($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '0' AND txp_active='1' AND proj_id=pm_projid AND txp_projid = '$id' AND txp_recvuid='$uid' " . $cond . "";
        } else {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert,swift_packagestatus,swift_packagemaster WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND txp_status = '0' AND txp_active='1' AND txp_recvuid='$uid'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function tech_expert_repository_count($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='$seg'";
        } else {
            $cond = "  AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert,project WHERE txp_projid=proj_id AND txp_status = '1' AND txp_active='1' AND txp_projid = '$id' AND txp_recvuid='$uid' $cond";
        } else {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert,project WHERE txp_projid=proj_id AND txp_status = '1' AND txp_active='1' AND txp_recvuid='$uid' $cond";
        }

        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function files_for_technical_approval_count($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(tech_id) as count FROM swift_techapproval,swift_packagestatus,swift_packagemaster,project WHERE ps_packid=tech_packid AND pm_packid=tech_packid AND pm_projid=projid AND ps_stageid='27'  AND  swift_techapproval.tech_status = '2' AND tech_active='1' AND tech_projid='$id' AND tech_recvuid='$uid' " . $cond . "";
        } else {
            $sql = "SELECT count(tech_id) as count FROM swift_techapproval,swift_packagestatus,swift_packagemaster,project WHERE ps_packid=tech_packid AND pm_packid=tech_packid AND pm_projid=projid AND ps_stageid='27'  AND  swift_techapproval.tech_status = '2' AND tech_active='1' AND tech_recvuid='$uid' " . $cond . "";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function tech_cto_workflow_count($id)
    {
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

    function tech_cto_workflow_countM($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = "  AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(cto_id) as count FROM Project,swift_packagemaster,swift_techCTO,swift_packagestatus 
            WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '0' AND cto_active = '1' AND ps_stageid='6' AND cto_projid='$id' AND cto_recvuid='$uid' $cond";
        } else {
            $sql = "SELECT count(cto_id) as count FROM Project,swift_packagemaster,swift_techCTO,swift_packagestatus 
            WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '0' AND cto_active = '1' AND ps_stageid='6' AND cto_recvuid='$uid' $cond";
        }

        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function tech_cto_repository_count($id)
    {
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

    function tech_cto_repository_countM($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(cto_id) as count FROM swift_techCTO,swift_packagestatus,swift_packagemaster,Project WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '1' AND cto_active = '1' AND ps_stageid='6' AND cto_projid='$id' AND cto_recvuid='$uid' $cond";
        } else {
            $sql = "SELECT count(cto_id) as count FROM swift_techCTO,swift_packagestatus,swift_packagemaster,Project WHERE cto_projid=proj_id AND cto_packid=pm_packid AND ps_packid=cto_packid AND  cto_status = '1' AND cto_active = '1' AND ps_stageid='6' AND cto_recvuid='$uid' $cond";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function scm_workflow_count($id, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(sc_id) as count FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster,Project WHERE ps_stageid = '13' and sc_packid=ps_packid AND pm_projid=proj_id AND sc_packid=pm_packid AND sc_status='0' AND sc_active='1' AND sc_projid= '$id' $cond";
        } else {
            $sql = "SELECT count(sc_id) as count FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '13' and sc_packid=ps_packid  AND pm_projid=proj_id AND sc_packid=pm_packid AND sc_status='0' AND sc_active='1' $cond";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function files_from_buyer_count($id, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id=$seg";
        } else {
            $cond = " AND cat_id!='38'";
        }

        if ($id != "") {
            $sql = "SELECT count(bu_id) as count FROM swift_SCMtoBUYER,swift_packagestatus,swift_packagemaster,Project WHERE ps_stageid = '13' AND pm_projid=proj_id AND bu_packid=ps_packid AND bu_packid=pm_packid AND bu_status='2' AND bu_projid= '$id' $cond";
        } else {
            $sql = "SELECT count(bu_id) as count FROM swift_SCMtoBUYER,swift_packagestatus,swift_packagemaster,Project WHERE ps_stageid = '13' AND pm_projid=proj_id  AND bu_packid=ps_packid AND bu_packid=pm_packid AND bu_status='2' $cond";
        }

        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function select_smartsignoff_count($id, $uid, $utype, $seg)
    {

        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT  count(so_id) as count
FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_SCMtoBUYER,project ,swift_workflow_CurrentStage
WHERE so_pack_id=pm_packid AND pm_projid=proj_id AND so_pack_id=ps_packid AND active='1' and  po_wo_status ='3' 
and bu_packid=so_pack_id and bu_status=1 and so_proj_id= '$id' $cond1";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT  count(so_id) as count
FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_SCMtoBUYER,Project ,swift_workflow_CurrentStage
WHERE so_pack_id=pm_packid AND pm_projid=proj_id AND so_pack_id=ps_packid AND active='1'  po_wo_status ='3'
and bu_packid=so_pack_id and bu_status=1  $cond1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function select_smartsignoff_count1($id, $uid, $utype, $seg)
    {
        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }

        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT  count(so_id) as count
FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_SCMtoBUYER,project ,swift_workflow_CurrentStage
WHERE so_pack_id=pm_packid AND pm_projid=proj_id AND so_pack_id=ps_packid AND active='1' and (so_hw_sw=2 and po_wo_status ='1' or so_hw_sw=3 and po_wo_status ='3' )
and bu_packid=so_pack_id and bu_status=1 and ps_stageid=15 and so_proj_id= '$id' $cond1";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT  count(so_id) as count
FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_SCMtoBUYER,Project ,swift_workflow_CurrentStage
WHERE so_pack_id=pm_packid AND pm_projid=proj_id AND so_pack_id=ps_packid AND active='1' and (so_hw_sw=2 and po_wo_status ='1' or so_hw_sw=3 and po_wo_status ='3')
and bu_packid=so_pack_id and bu_status=1 and ps_stageid=15  $cond1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function loi_update_count($id, $uid, $utype, $seg)
    {
        if ($seg != '') {
            $cond1 = " AND cat_id='" . $seg . "'";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($utype == 20) {
            $cond = "";
        } else {
            $cond = " and bu_buyer_id='" . $uid . "'";
        }

        if ($id != "") {
            $sql = "select  count(distinct so_pack_id) as count 
from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master,swift_SCMtoBUYER   
where proj_id=so_proj_id and bu_packid=so_pack_id and
so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=13 
and stage_id=13  and so_status=0 and bu_status=1 and so_proj_id= '$id' $cond $cond1";
        } else {
            $sql = "select  count(distinct so_pack_id) as count 
from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master,swift_SCMtoBUYER   
where proj_id=so_proj_id and bu_packid=so_pack_id  and
so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=13 
and stage_id=13  and so_status=0 and bu_status=1  $cond $cond1";
        }


        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function select_lc_count($id)
    {
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

    function select_rpa_count($id)
    {
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

    function select_lc_repository_count($id)
    {
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

    function select_rpa_repository_count($id)
    {
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

    function days_left($date, $col_name)
    {
        $sql = "SELECT DATEDIFF(DAY,GETDATE(),$col_name) as days FROM swift_lc_rpa";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function tech_expert_workflow_fromcto($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND pm_projid=proj_id AND txp_status = '2' AND txp_active='1' AND txp_projid = '$id' AND txp_recvuid='$uid' " . $cond . "";
        } else {
            $sql = "SELECT count(txp_id) as count FROM swift_techexpert,swift_packagestatus,swift_packagemaster,project WHERE ps_stageid = '5' AND txp_packid=ps_packid AND txp_packid=pm_packid AND pm_projid=proj_id AND txp_status = '2' AND txp_active='1' AND txp_recvuid='$uid'  " . $cond . "";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function ttl_package($pid, $segment)
    {
        if ($pid != "") {
            //            $sql = "select COUNT(*) as ttl_package from swift_packagemaster where pm_projid='" . $pid . "'";
            $sql = "select * from swift_packagemaster,Project  where pm_projid =proj_id  $segment and pm_projid='" . $pid . "' and pm_stages!=''";
        } else {
            //            $sql = "select COUNT(*) as ttl_package from swift_packagemaster ";
            $sql = "select * from swift_packagemaster,Project  where pm_projid =proj_id $segment and pm_stages!='' ";
        }
        $query = mssql_query($sql);
        // $row = mssql_fetch_array($query);
        // $rowcount = $row['ttl_package'];
        // return $rowcount;
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function ttl_tech_cleared($pid, $segment)
    {
        //        if ($pid != "") {
        //            $sql = "select COUNT(*) as ttl_tech_cleared from swift_techCTO where cto_status = '1' and cto_active='1' and cto_projid='" . $pid . "'";
        //        } else {
        //            $sql = "select COUNT(*) as ttl_tech_cleared from swift_techCTO where cto_status = '1' and cto_active='1' ";
        //        }
        if ($pid != "") {
            //            $sql = "select COUNT(ps_packid) as ttl_tech_cleared from swift_packagestatus where ps_stageid in(2,3,4,5,6) and active =1 and ps_projid='".$pid."'";
            $sql = "select distinct COUNT(ps_packid) as ttl_tech_cleared from swift_packagestatus ,Project
where ps_stageid in(2,3,4,5,6) and active =1  and ps_projid=proj_id  $segment and  ps_projid='" . $pid . "'";
        } else {
            //            $sql = "select COUNT(ps_packid) as ttl_tech_cleared from swift_packagestatus where ps_stageid in(2,3,4,5,6) and active =1 ";
            $sql = "select distinct COUNT(ps_packid) as ttl_tech_cleared from swift_packagestatus ,Project
where ps_stageid in(2,3,4,5,6) and active =1  and ps_projid=proj_id  $segment  ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['ttl_tech_cleared'];
        return $rowcount;
    }
    function ttl_tech_completed($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as techcount  from swift_transactions
             where  st_stageid=6  and st_status = 0    $segment and st_projid='" . $pid . "' ";

        } else {
            $sql = " SELECT count(distinct st_packid) as techcount  from swift_transactions 
            where  st_stageid=6  and st_status = 0    $segment  ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['techcount'];
        //echo $count = mssql_num_rows($query);
        return $count;
    }
    function ops_received_count($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT distinct count(ps_packid) as ops  from dbo.swift_stage_master as a 
                     left join swift_packagestatus as b on b.ps_stageid=a.stage_id
                     where usertype=5 and ps_packid!='' and st_projid='" . $pid . "' ";
        } else {
            $sql = " SELECT distinct count(ps_packid) as ops from dbo.swift_stage_master as a 
                     left join swift_packagestatus as b on b.ps_stageid=a.stage_id
                     where usertype=5 and ps_packid!=''";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['ops'];
        //echo $count = mssql_num_rows($query);
        return $count;
    }
    function tech_com_count($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT distinct count(ps_packid) as tech  from dbo.swift_stage_master as a 
                     left join swift_packagestatus as b on b.ps_stageid=a.stage_id
                     where usertype=10 and ps_packid!='' and st_projid='" . $pid . "' ";
        } else {
            $sql = " SELECT distinct count(ps_packid) as tech from dbo.swift_stage_master as a 
                     left join swift_packagestatus as b on b.ps_stageid=a.stage_id
                     where usertype=10 and ps_packid!=''";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['tech'];
        //echo $count = mssql_num_rows($query);
        return $count;
    }
    function scm_cleared($pid)
    {
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

    function app_inprogress($pid, $segment)
    {
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
                    and proj_id=bu_projid  $segment  and bu_projid='" . $pid . "'";
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

    function ops_completed($pid, $segment)
    {
        if ($pid != "") {
            $sql = "SELECT count(distinct st_packid) as opscount  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            WHERE  stage_id=2 and st_packid!='' and st_status = 0 
            and st_projid='" . $pid . "' ";

        } else {
            $sql = " SELECT count(distinct st_packid) as opscount  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where  stage_id=2 and st_packid!='' and st_status = 0 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['opscount'];
        return $count;
    }
    function tech_completed($pid, $segment)
    {
        if ($pid != "") {
            $sql = "SELECT count(distinct st_packid) as tech  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            
            where stage_id in(3,4,5,6)  and st_packid!='' and st_status = 0  and st_projid='" . $pid . "' ";

        } else {
            $sql = " SELECT count(distinct st_packid) as tech  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(3,4,5,6) and st_packid!='' and st_status = 0 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['tech'];
        return $count;
    }
    function om_completed($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as om  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(7,8) and st_packid!='' and st_status = 0 and st_projid='" . $pid . "' ";
        } else {
            $sql = " SELECT count(distinct st_packid) as om  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(7,8) and st_packid!='' and st_status = 0 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['om'];
        return $count;
    }

    function ops_om_completed($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as om  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(22) and st_packid!='' and st_status = 0 and st_projid='" . $pid . "' ";
        } else {
            $sql = " SELECT count(distinct st_packid) as om  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(22) and st_packid!='' and st_status = 0 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['om'];
        return $count;
    }
    function scm_com_count($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as scm  from swift_transactions  as a 
             INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(9) and st_packid!='' and st_status = 0 and st_projid='" . $pid . "' ";

        } else {
            $sql = " SELECT count(distinct st_packid) as scm  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(9)and st_packid!='' and st_status = 0 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['scm'];
        return $count;
    }
    function scm_sendback($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as scm  from swift_transactions  as a 
             INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(9) and st_packid!='' and st_status = 1 and st_projid='" . $pid . "' ";

        } else {
            $sql = " SELECT count(distinct st_packid) as scm  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(9)and st_packid!='' and st_status = 1 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['scm'];
        return $count;
    }
    function buyer_com_count($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as buyer  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(10) and st_packid!='' and st_status = 0 and st_projid='" . $pid . "' ";

        } else {
            $sql = " SELECT count(distinct st_packid) as buyer  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(10)  and st_packid!='' and st_status = 0 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['buyer'];
        return $count;
    }
    function ss_count($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as buyer  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(12)  and st_packid!='' and st_status = 0 and st_projid='" . $pid . "' ";

        } else {
            $sql = " SELECT count(distinct st_packid) as buyer  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(12) and st_packid!='' and st_status = 0 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['buyer'];
        return $count;
    }

    function loi_count($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as loi  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id =13 and st_packid!='' and st_status = 0 and st_projid='" . $pid . "' ";

        } else {
            $sql = " SELECT count(distinct st_packid) as loi  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id =13 and st_packid!='' and st_status = 0 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['loi'];
        return $count;
    }
    function powo_count($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as loi  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(15)  and st_packid!='' and st_status = 0 and st_projid='" . $pid . "' ";

        } else {
            $sql = " SELECT count(distinct st_packid) as loi  from swift_transactions  as a 
            INNER JOIN swift_stage_master as b on b.stage_id=a.st_stageid
            INNER JOIN swift_packagemaster as c on c.pm_packid=a.st_packid and pm_stages!=''
            where stage_id in(15) and st_packid!='' and st_status = 0 ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['loi'];
        return $count;
    }
    function scm_completed($pid, $segment)
    {
        if ($pid != "") {
            $sql = " SELECT count(distinct st_packid) as opscount  from swift_transactions where  st_stageid in(12)  and st_status = 0    $segment and st_projid='" . $pid . "' ";

        } else {
            $sql = " SELECT count(distinct st_packid) as opscount  from swift_transactions where  st_stageid in(12)  and st_status = 0    $segment  ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['opscount'];
        return $count;
    }


    function po_completed($pid, $segment)
    {
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

    function po_progress($pid)
    {
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

    function wo_completed($pid, $segment)
    {
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

    function wo_progress($pid)
    {
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

    function mtr_received($pid, $segment)
    {
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

    function mtr_progress($pid)
    {
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

    function manf_completed($pid, $segment)
    {
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

    function manf_progress($pid)
    {
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

    function app_yettoinitiated($pid)
    {
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

    function partial($pid)
    {
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

    function deliverd($pid)
    {
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

    function tech_reviewer_workflow_count($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(techRev_id) as count FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '0' AND techRev_active = '1' AND ps_stageid='5' AND techRev_projid='$id' AND techRev_recvuid='$uid' $cond";
        } else {
            $sql = "SELECT count(techRev_id) as count FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '0' AND techRev_active = '1' AND ps_stageid='5' AND techRev_recvuid='$uid' $cond";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }

    function tech_reviewer_repository_count($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(techRev_id) as count FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '1' AND techRev_active = '1' AND ps_stageid='5' AND techRev_projid='$id' AND techRev_recvuid='$uid' $cond";
        } else {
            $sql = "SELECT count(techRev_id) as count FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '1' AND techRev_active = '1' AND ps_stageid='5' AND techRev_recvuid='$uid' $cond";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
    function swift_sendback_count($id, $uid, $seg)
    {
        // if ($seg != "") {
        //     $cond = " AND cat_id='38'";
        // } else {
        //     $cond = " AND cat_id!='38'";
        // }
        if ($id != "") {
            $sql = "SELECT COUNT(*) AS count
            FROM (
                SELECT   d.proj_type,c.hold_on,(isnull(DATEDIFF(DAY,ps_actualdate,GETDATE()),0)) as nodays,ps_stback,pm_stages,cs_packid,cs_projid,from_uid,to_uid,from_stage_id,to_stage_id, ps_planneddate as 
                org_plandate,ps_expdate, ps_actualdate,cs_actual,cs_created_date as cs_sentdate, from_remark,to_remark, 
                cs_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req
                as mat_req_date,lt_flag  
                FROM swift_workflow_CurrentStage as a
                INNER JOIN swift_packagestatus as b ON a.cs_packid=b.ps_packid AND a.cs_projid=b.ps_projid
                INNER JOIN swift_packagemaster as c ON c.pm_packid=b.ps_packid AND a.cs_projid=c.pm_projid
                INNER JOIN Project as d ON a.cs_projid=d.proj_id  and b.ps_projid=d.proj_id 
                WHERE  cs_active = '1' AND to_uid = '$uid'  AND ps_stback=1 AND cs_projid = '$id'
            ) AS subquery";
           
        } else {
            // $sql = "SELECT count(cs_packid) as count FROM swift_workflow_CurrentStage,swift_packagestatus,swift_packagemaster,project 
            // WHERE   ps_stback=1 and cs_packid=ps_packid AND cs_packid=pm_packid AND  
            // cs_active='1' AND pm_projid=proj_id AND to_uid='$uid' AND ps_stback=1 AND active=1 ";

            $sql = "SELECT COUNT(*) AS count
            FROM (
                SELECT   d.proj_type,c.hold_on,(isnull(DATEDIFF(DAY,ps_actualdate,GETDATE()),0)) as nodays,ps_stback,pm_stages,cs_packid,cs_projid,from_uid,to_uid,from_stage_id,to_stage_id, ps_planneddate as 
                org_plandate,ps_expdate, ps_actualdate,cs_actual,cs_created_date as cs_sentdate, from_remark,to_remark, 
                cs_active,revised_planned_date as rev_planned_date,pm_material_req as schedule_date,pm_revised_material_req
                as mat_req_date,lt_flag  
                FROM swift_workflow_CurrentStage as a
                INNER JOIN swift_packagestatus as b ON a.cs_packid=b.ps_packid AND a.cs_projid=b.ps_projid
                INNER JOIN swift_packagemaster as c ON c.pm_packid=b.ps_packid AND a.cs_projid=c.pm_projid
                INNER JOIN Project as d ON a.cs_projid=d.proj_id  and b.ps_projid=d.proj_id 
                WHERE  cs_active = '1' AND to_uid = '$uid'  AND ps_stback=1
            ) AS subquery ";
        }

        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
    function tech_reviewer_workflow_countfromcto($id, $uid, $seg)
    {
        if ($seg != '') {
            $cond = " AND cat_id='38'";
        } else {
            $cond = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(techRev_id) as count FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '2' AND techRev_active = '1' AND ps_stageid='5' AND techRev_projid='$id' AND techRev_recvuid='$uid' $cond";
        } else {
            $sql = "SELECT count(techRev_id) as count FROM Project,swift_packagemaster,swift_techReviewer,swift_packagestatus 
            WHERE techRev_projid=proj_id AND techRev_packid=pm_packid AND ps_packid=techRev_packid AND  techRev_status = '2' AND techRev_active = '1' AND ps_stageid='5' AND techRev_recvuid='$uid' $cond";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
    function files_from_loiemr($id, $uid, $utype, $seg)
    {

        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(pw_id) as count  from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as  p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            where  a.flag=0 and a.emr_flag=1 and  d.active='1' and to_uid='$uid'
            AND proj_id= '$id' $cond1  and  ( a.po_wo_status ='1'or a.po_wo_status ='3') ";
        } else {
            $sql = "SELECT count(pw_id) as count  from  Swift_po_wo_Details as a 
        inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
        inner join Project  as  p on p.proj_id=a.pw_projid 
        inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
        where  a.flag=0 and a.emr_flag=1 and  d.active='1' and to_uid='$uid' and  ( a.po_wo_status ='1'or a.po_wo_status ='3') 
         $cond1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
    function files_from_loipo($id, $uid, $utype, $seg)
    {

        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(pw_id) as count  from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as  p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            where  a.flag=1  and a.emr_flag=1 and  d.active='1' and to_uid='$uid'
            AND proj_id= '$id' $cond1  and  ( a.po_wo_status ='1'or a.po_wo_status ='3') ";
        } else {
            $sql = "SELECT count(pw_id) as count  from  Swift_po_wo_Details as a 
        inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
        inner join Project  as  p on p.proj_id=a.pw_projid 
        inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
        where  a.flag=1  and a.emr_flag=1 and  d.active='1' and to_uid='$uid' and  ( a.po_wo_status ='1'or a.po_wo_status ='3') 
         $cond1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
    function files_from_loipo_approval($id, $uid, $utype, $seg)
    {

        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(pw_id) as count  from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as  p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            where  a.flag=2 and a.emr_flag=1 and  d.active='1' and to_uid='$uid'
            AND so_proj_id= '$id' $cond1  and  ( a.po_wo_status ='1'or a.po_wo_status ='3') ";
        } else {
            $sql = "SELECT count(pw_id) as count  from  Swift_po_wo_Details as a 
        inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
        inner join Project  as  p on p.proj_id=a.pw_projid 
        inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
        where  a.flag=2 and a.emr_flag=1 and  d.active='1' and to_uid='$uid' and  ( a.po_wo_status ='1'or a.po_wo_status ='3') 
         $cond1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
    function files_from_wo($id, $uid, $utype, $seg)
    {

        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(pw_id) as count  from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as  p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            where  a.wo_flag=1 and  d.active='1'
            AND proj_id= '$id' $cond1  and  ( a.po_wo_status ='2'or a.po_wo_status ='3') ";
        } else {
            $sql = "SELECT count(pw_id) as count  from  Swift_po_wo_Details as a 
        inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
        inner join Project  as  p on p.proj_id=a.pw_projid 
        inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
        where  a.wo_flag=1 and  d.active='1' and  ( a.po_wo_status ='2'or a.po_wo_status ='3') 
         $cond1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
    function files_from_wo_approval($id, $uid, $utype, $seg)
    {

        if ($seg != '') {
            $cond1 = " AND cat_id=$seg";
        } else {
            $cond1 = " AND cat_id!='38'";
        }
        if ($id != "") {
            $sql = "SELECT count(pw_id) as count  from  Swift_po_wo_Details as a 
            inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
            inner join Project  as  p on p.proj_id=a.pw_projid 
            inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
            where  a.wo_flag=2  and  d.active='1' and to_uid='$uid'
            AND so_proj_id= '$id' $cond1  and  ( a.po_wo_status ='2'or a.po_wo_status ='3') ";
        } else {
            $sql = "SELECT count(pw_id) as count  from  Swift_po_wo_Details as a 
        inner join swift_workflow_CurrentStage as b on a.pw_packid=b.cs_packid and b.cs_projid=a.pw_projid
        inner join Project  as  p on p.proj_id=a.pw_projid 
        inner join swift_packagestatus  as d on d.ps_packid = a.pw_packid  and d.ps_projid=a.pw_projid
        where  a.wo_flag=2 and  d.active='1' and to_uid='$uid' and  ( a.po_wo_status ='2'or a.po_wo_status ='3') 
         $cond1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $rowcount = $row['count'];
        return $rowcount;
    }
}