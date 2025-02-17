<?php

class User {

    function files_fromcontracts($pid, $segment) {
        if ($pid == "") {
            $sql = "select count(*) as filefrmcontract from Project where package_status=0 and cat_id='" . $segment . "'";
        } else {
            $sql = "select count(*) as filefrmcontract from Project where proj_id='" . $pid . "' and package_status=0 and cat_id='" . $segment . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['filefrmcontract'];
        return $count;
    }

    function files_fortechspoc($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as files_techspoc
                    from swift_packagemaster,Project where proj_id=pm_projid and cat_id='" . $segment . "' and tech_status=0";
        } else {
            $sql = "select COUNT(*) as files_techspoc
                    from swift_packagemaster,Project where proj_id=pm_projid and cat_id='" . $segment . "' and pm_projid='" . $pid . "' and tech_status=0";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['files_techspoc'];
        return $count;
    }

    function files_fromctodas($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as ctocount
                    from swift_CTOtoOPS,Project 
                    where proj_id=ctops_projid and cat_id='" . $segment . "' and ctops_status=0  and ctops_active=1";
        } else {
            $sql = "select COUNT(*) as ctocount
                    from swift_CTOtoOPS,Project 
                    where proj_id=ctops_projid and cat_id='" . $segment . "'  and ctops_status=0 and ctops_active=1 and proj_id='" . $pid . "' ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['ctocount'];
        return $count;
    }

    function files_from_omdas($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as ctocount
                    from swift_OMtoOPs,Project 
                    where proj_id=omop_projid and cat_id='" . $segment . "' and omop_status=0  and omop_active=1";
        } else {
            $sql = "select COUNT(*) as ctocount
                    from swift_OMtoOPs,Project 
                    where proj_id=omop_projid and cat_id='" . $segment . "'  and omop_status=0 and omop_active=1 and proj_id='" . $pid . "' ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['ctocount'];
        return $count;
    }

    function files_fromcto($pid, $segment) {
        if ($pid == "") {
            $sql = "select  name,ctops_packid,ctops_projid,ctops_recvuid,ctops_recv_stageid,proj_name,ctops_remarks,ctops_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,ps_expdate, pm_createdate as expected,GETDATE() as actual,stage_name 
                    from usermst,swift_CTOtoOPS,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=ctops_projid and
                    ctops_packid=pm_packid and ctops_packid=ps_packid  and ps_stageid=ctops_recv_stageid  
                    and stage_id=ctops_recv_stageid and cat_id='" . $segment . "'   and uid=ctops_senderuid and ctops_active=1 and ctops_status=0";
        } else {
            $sql = "select  name,ctops_packid,ctops_projid,ctops_recvuid,ctops_recv_stageid,proj_name,ctops_remarks,ctops_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,ps_expdate, pm_createdate as expected,GETDATE() as actual,stage_name 
                    from usermst,swift_CTOtoOPS,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=ctops_projid and
                    ctops_packid=pm_packid and ctops_packid=ps_packid and ctops_projid='" . $pid . "' and ps_stageid=ctops_recv_stageid  
                    and stage_id=ctops_recv_stageid and cat_id='" . $segment . "' and proj_id='" . $pid . "' and uid=ctops_senderuid and ctops_active=1 and ctops_status=0";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_fromctoajax($pack_id) {
        $sql = "select  name,ctops_packid,ctops_projid,ctops_recvuid,ctops_recv_stageid,proj_name,ctops_remarks,
                pm_packagename,pm_revised_material_req,revised_planned_date as planned,ps_expdate,GETDATE()  as expected,GETDATE() as actual,stage_name 
                from usermst,swift_CTOtoOPS,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=ctops_projid and
                ctops_packid=pm_packid and ctops_packid=ps_packid and ctops_packid='" . $pack_id . "' and ps_stageid=ctops_recv_stageid and pm_packid='" . $pack_id . "'
                and stage_id=ctops_recv_stageid  and ps_packid='" . $pack_id . "' and uid=ctops_senderuid and ctops_active=1 and ctops_status=0";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function cto_to_opsremarks($pack_id) {
        $sql = "select ctops_remarks from swift_CTOtoOPS where ctops_active=1 and ctops_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function cto_to_opsprevremarks($pack_id) {
        $sql = "select ctops_sentdate,ctops_remarks from swift_CTOtoOPS where ctops_active=0 and  ctops_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $result = array();
            while ($row = mssql_fetch_array($query)) {
                $result[] = $row;
            }
            $res = json_encode($result);
        } else {
            $res = 0;
        }
        return $res;
    }

    function files_from_om($pid, $segment) {
        if ($pid == "") {
            $sql = "select  name,omop_packid,omop_projid,omop_recvuid,omop_recv_stageid,proj_name,omop_remarks,ps_expdate,omop_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,stage_name 
                    from usermst,swift_OMtoOPs,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=omop_projid and
                    omop_packid=pm_packid and omop_packid=ps_packid  and ps_stageid=omop_recv_stageid  
                    and stage_id=omop_recv_stageid and cat_id='" . $segment . "'   and uid=omop_senderuid and omop_active=1 and omop_status=0";
        } else {
            $sql = "select  name,omop_packid,omop_projid,omop_recvuid,omop_recv_stageid,proj_name,omop_remarks,ps_expdate,omop_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,stage_name 
                    from usermst,swift_OMtoOPs,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=omop_projid and
                    omop_packid=pm_packid and omop_packid=ps_packid and omop_projid='" . $pid . "' and ps_stageid=omop_recv_stageid  
                    and stage_id=omop_recv_stageid and cat_id='" . $segment . "' and proj_id='" . $pid . "' and uid=omop_senderuid and omop_active=1 and omop_status=0";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_from_om_ajax($pack_id) {
        $sql = "select  name,omop_packid,omop_projid,omop_recvuid,omop_recv_stageid,proj_name,omop_remarks,
pm_packagename,pm_revised_material_req,revised_planned_date as planned,ps_expdate, GETDATE() as expected,GETDATE() as actual,stage_name 
from usermst,swift_OMtoOPs,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=omop_projid and
omop_packid=pm_packid and omop_packid=ps_packid and omop_packid='" . $pack_id . "' and ps_stageid=omop_recv_stageid and pm_packid='" . $pack_id . "'
and stage_id=omop_recv_stageid  and ps_packid='" . $pack_id . "' and uid=omop_senderuid and omop_active=1 and omop_status=0";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function om_to_opsremarks($pack_id) {
        $sql = "select omop_remarks from swift_OMtoOPs where omop_active=1 and omop_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function om_to_opsprevremarks($pack_id) {
        $sql = "select omop_sentdate,omop_remarks from swift_OMtoOPs where omop_active=0 and  omop_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $result = array();
            while ($row = mssql_fetch_array($query)) {
                $result[] = $row;
            }
            $res = json_encode($result);
        } else {
            $res = 0;
        }
        return $res;
    }

    function files_inom($pid, $segment) {
        if ($pid == "") {
            $sql = "select  distinct name,om_packid,om_projid,om_recvuid,om_recv_stageid,proj_name,om_remarks,om_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,ps_expdate, pm_createdate as expected,GETDATE() as actual,stage_name 
                    from usermst,swift_OandM,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=om_projid and
                    om_packid=pm_packid and om_packid=ps_packid  and ps_stageid=om_recv_stageid  
                    and stage_id=om_recv_stageid  and uid=om_senderuid and om_active=1 and om_status=0";
        } else {
            $sql = "select  distinct name,om_packid,om_projid,om_recvuid,om_recv_stageid,proj_name,om_remarks,om_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,ps_expdate, pm_createdate as expected,GETDATE() as actual,stage_name 
                    from usermst,swift_OandM,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=om_projid and
                    om_packid=pm_packid and om_packid=ps_packid and om_projid='" . $pid . "' and ps_stageid=om_recv_stageid  
                    and stage_id=om_recv_stageid   and proj_id='" . $pid . "' and uid=om_senderuid and om_active=1 and om_status=0";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_inom_ajax($pack_id) {
        $sql = "select  distinct name,om_packid,om_projid,om_recvuid,om_recv_stageid,proj_name,om_remarks,
pm_packagename,pm_revised_material_req,revised_planned_date as planned, GETDATE() as expected,ps_expdate,GETDATE() as actual,stage_name 
from usermst,swift_OandM,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=om_projid and
om_packid=pm_packid and om_packid=ps_packid and om_packid='" . $pack_id . "' and ps_stageid=om_recv_stageid and pm_packid='" . $pack_id . "'
and stage_id=om_recv_stageid  and ps_packid='" . $pack_id . "' and uid=om_senderuid and om_active=1 and om_status=0";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function op_to_omremarks($pack_id) {
        $sql = "select om_remarks from swift_OandM where om_active=1 and om_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function op_to_omprevremarks($pack_id) {
        $sql = "select om_sentdate,om_remarks from swift_OandM where om_active=0 and  om_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $result = array();
            while ($row = mssql_fetch_array($query)) {
                $result[] = $row;
            }
            $res = json_encode($result);
        } else {
            $res = 0;
        }
        return $res;
    }

    function files_from_scm($pid, $segment) {
        if ($pid == "") {
            $sql = "select  name,scop_packid,scop_projid,scop_recvuid,scop_recv_stageid,proj_name,scop_remarks,ps_expdate,scop_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,stage_name 
                    from usermst,swift_SCMtoOPS,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=scop_projid and
                    scop_packid=pm_packid and scop_packid=ps_packid  and ps_stageid=scop_recv_stageid  
                    and stage_id=scop_recv_stageid and cat_id='" . $segment . "' and uid=scop_senderuid and scop_active=1 and scop_status=0";
        } else {
            $sql = "select  name,scop_packid,scop_projid,scop_recvuid,scop_recv_stageid,proj_name,scop_remarks,ps_expdate,scop_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,stage_name 
                    from usermst,swift_SCMtoOPS,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=scop_projid and
                    scop_packid=pm_packid and scop_packid=ps_packid and scop_projid='" . $pid . "' and ps_stageid=scop_recv_stageid  
                    and stage_id=scop_recv_stageid and cat_id='" . $segment . "' and proj_id='" . $pid . "' and uid=scop_senderuid and scop_active=1 and scop_status=0";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_from_scm_ajax($pack_id) {
        $sql = "select  name,scop_packid,scop_projid,scop_recvuid,scop_recv_stageid,proj_name,scop_remarks,ps_expdate,
pm_packagename,pm_revised_material_req,revised_planned_date as planned, GETDATE()  as expected,GETDATE() as actual,stage_name 
from usermst,swift_SCMtoOPS,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=scop_projid and
scop_packid=pm_packid and scop_packid=ps_packid and scop_packid='" . $pack_id . "' and ps_stageid=scop_recv_stageid and pm_packid='" . $pack_id . "'
and stage_id=scop_recv_stageid  and ps_packid='" . $pack_id . "' and uid=scop_senderuid and scop_active=1 and scop_status=0";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function scm_to_opsremarks($pack_id) {
        $sql = "select scop_remarks from swift_SCMtoOPS where scop_active=1 and scop_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function scm_to_opsprevremarks($pack_id) {
        $sql = "select scop_sentdate,scop_remarks from swift_SCMtoOPS where scop_active=0 and  scop_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $result = array();
            while ($row = mssql_fetch_array($query)) {
                $result[] = $row;
            }
            $res = json_encode($result);
        } else {
            $res = 0;
        }
        return $res;
    }

    function files_from_scmdas($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as scmcount
                    from swift_SCMtoOPS,Project 
                    where proj_id=scop_projid and cat_id='" . $segment . "' and scop_status=0  and scop_active=1";
        } else {
            $sql = "select COUNT(*) as scmcount
                    from swift_SCMtoOPS,Project 
                    where proj_id=scop_projid and cat_id='" . $segment . "'  and scop_status=0 and scop_active=1 and proj_id='" . $pid . "' ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['scmcount'];
        return $count;
    }

    function files_from_smartdas($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as smartcount
                    from swift_filesfrom_smartsignoff,Project 
                    where proj_id=so_proj_id and cat_id='" . $segment . "' and so_status=1";
        } else {
            $sql = "select COUNT(*) as smartcount
                    from swift_filesfrom_smartsignoff,Project 
                    where proj_id=so_proj_id and cat_id='" . $segment . "'  and so_status=1 and proj_id='" . $pid . "' ";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['smartcount'];
        return $count;
    }

    function files_from_smartsign($pid, $segment) {
        if ($pid == "") {
            $sql = "select so_pack_id,so_proj_id,proj_name,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,ps_expdate, pm_createdate as expected,GETDATE() as actual,stage_name 
                    from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=so_proj_id and
                    so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=19 
                    and stage_id=19 and cat_id='" . $segment . "' and so_status=1";
        } else {
            $sql = "select so_pack_id,so_proj_id,proj_name,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,ps_expdate, pm_createdate as expected,GETDATE() as actual,stage_name 
                    from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=so_proj_id and
                    so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=19 
                    and stage_id=19 and cat_id='" . $segment . "' and proj_id='" . $pid . "' and so_status=1";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_from_smartsign_ajax($pack_id) {
        $sql = "select distinct so_pack_id,so_proj_id,proj_name,ps_expdate,
                    pm_packagename,pm_revised_material_req,revised_planned_date as planned, GETDATE() as expected,GETDATE() as actual,stage_name 
                    from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=so_proj_id and
                    so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=19 
                    and stage_id=19  and so_status=1 and so_pack_id='" . $pack_id . "'";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_from_techappdas($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as techcount
                    from swift_techapproval,Project 
                    where proj_id=tech_projid and cat_id='" . $segment . "' and tech_active=1 and swift_techapproval.tech_status in('3')";
        } else {
            $sql = "select COUNT(*) as techcount
                    from swift_techapproval,Project 
                    where proj_id=tech_projid and cat_id='" . $segment . "' and  tech_active=1 and swift_techapproval.tech_status in('3')and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['techcount'];
        return $count;
    }

    function files_from_techappdas_co($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as techcount
                    from swift_techapproval,Project 
                    where proj_id=tech_projid and cat_id='" . $segment . "' and tech_active=1 and swift_techapproval.tech_status in('0','1')";
        } else {
            $sql = "select COUNT(*) as techcount
                    from swift_techapproval,Project 
                    where proj_id=tech_projid and cat_id='" . $segment . "' and  tech_active=1 and swift_techapproval.tech_status in('0','1')and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['techcount'];
        return $count;
    }

    function files_for_techapp($pid, $segment) {
        if ($pid == "") {
            $sql = "select  distinct swift_techapproval.tech_status,name,tech_packid,tech_projid,tech_recvuid,tech_recv_stageid,proj_name,tech_remarks,tech_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,ps_expdate as expected,GETDATE() as actual,stage_name,stage_id 
                    from usermst,swift_techapproval,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=tech_projid and
                    tech_packid=pm_packid and tech_packid=ps_packid  and ps_stageid=tech_recv_stageid  
                    and stage_id=tech_recv_stageid and cat_id='" . $segment . "' and uid=tech_senderuid and tech_active=1 and swift_techapproval.tech_status in('3') ";
        } else {
            $sql = "select  distinct swift_techapproval.tech_status,name,tech_packid,tech_projid,tech_recvuid,tech_recv_stageid,proj_name,tech_remarks,tech_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, ps_expdate as expected,GETDATE() as actual,stage_name,stage_id 
                    from usermst,swift_techapproval,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=tech_projid and
                    tech_packid=pm_packid and tech_packid=ps_packid  and ps_stageid=tech_recv_stageid and tech_projid='" . $pid . "'  
                    and stage_id=tech_recv_stageid and cat_id='" . $segment . "' and uid=tech_senderuid and tech_active=1 and  proj_id='" . $pid . "' and swift_techapproval.tech_status in('0','1','3')";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_fortechapp_ajax($pack_id, $flag) {
        $sql = "select  name,tech_packid,tech_projid,tech_recvuid,tech_recv_stageid,proj_name,tech_remarks,
pm_packagename,pm_revised_material_req,revised_planned_date as planned, ps_expdate as expected,GETDATE() as actual,stage_name 
from usermst,swift_techapproval,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=tech_projid and
tech_packid=pm_packid and tech_packid=ps_packid and tech_packid='" . $pack_id . "' and ps_stageid=tech_recv_stageid and pm_packid='" . $pack_id . "'
and stage_id=tech_recv_stageid  and ps_packid='" . $pack_id . "' and uid=tech_senderuid and tech_active=1 and swift_techapproval.tech_status='" . $flag . "'";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function tech_appremarks($pack_id, $flag) {
        $sql = "select tech_remarks from swift_techapproval where tech_active=1 and tech_packid='" . $pack_id . "' and tech_status='" . $flag . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function tech_app_prevremarks($pack_id, $flag) {
        $sql = "select tech_sentdate,tech_remarks from swift_techapproval where tech_active=0 and  tech_packid='" . $pack_id . "' and tech_status='1'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $result = array();
            while ($row = mssql_fetch_array($query)) {
                $result[] = $row;
            }
            $res = json_encode($result);
        } else {
            $res = 0;
        }
        return $res;
    }

    function files_for_poentry($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as techcount
                    from swift_techapproval,Project 
                    where proj_id=tech_projid and cat_id='" . $segment . "' and tech_active=1 and swift_techapproval.tech_status =4";
        } else {
            $sql = "select COUNT(*) as techcount
                    from swift_techapproval,Project 
                    where proj_id=tech_projid and cat_id='" . $segment . "' and  tech_active=1 and swift_techapproval.tech_status =4 and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['techcount'];
        return $count;
    }

    function files_for_podetailsentry($pid, $segment) {
        if ($pid == "") {
            $sql = "select  distinct swift_techapproval.tech_status,name,tech_packid,tech_projid,tech_recvuid,tech_recv_stageid,proj_name,tech_remarks,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,stage_name,ps_expdate
                    from usermst,swift_techapproval,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=tech_projid and
                    tech_packid=pm_packid and tech_packid=ps_packid  and ps_stageid=tech_recv_stageid  
                    and stage_id=tech_recv_stageid and cat_id='" . $segment . "' and uid=tech_senderuid and tech_active=1 and swift_techapproval.tech_status in('4') ";
        } else {
            $sql = "select  distinct swift_techapproval.tech_status,name,tech_packid,tech_projid,tech_recvuid,tech_recv_stageid,proj_name,tech_remarks,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,stage_name,ps_expdate 
                    from usermst,swift_techapproval,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=tech_projid and
                    tech_packid=pm_packid and tech_packid=ps_packid  and ps_stageid=tech_recv_stageid and tech_projid='" . $pid . "'  
                    and stage_id=tech_recv_stageid and cat_id='" . $segment . "' and uid=tech_senderuid and tech_active=1 and  proj_id='" . $pid . "' and swift_techapproval.tech_status in('4')";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function check_cusinvolved($pack_id) {
        $sql = "select * from swift_checklist_mapping where  cm_pack_id='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function get_po_details($pack_id) {
        $sql = "select * from dbo.swift_podetails AS A
                left outer join swift_poentrysave AS B on A.swid=B.sweid where po_pack_id='" . $pack_id . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_packdetails($pack_id) {
        $sql = "select pm_packagename,proj_name from swift_packagemaster,Project where pm_projid=proj_id and pm_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function view_reports($pid, $segment) {
        if ($pid == "") {
            $sql = "select ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,isnull(DATEDIFF(DAY,revised_planned_date,ps_actualdate),0) as daysdif,ps_sbuid,ps_stback,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_material_req,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id and cat_id='" . $segment . "'";
        } else {
            $sql = "select ps_userid,proj_id,ps_packid,pm_packagename,proj_name,stage_name,ps_stageid,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as daysdif,ps_sbuid,ps_stback,
 revised_planned_date as planned,ps_expdate, ps_actualdate as acutal,pm_material_req,pm_revised_material_req,pm_revised_lead_time
 from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
 where proj_id=ps_projid and ps_packid=pm_packid and  active=1
 and ps_stageid=stage_id and cat_id='" . $segment . "' and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_firstrow($pack_id) {
        $sql = " select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days  from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11',14,'15')
 and a.ps_stageid <=15 order by ps_stageid ASC ";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_secondrow($pack_id, $poc) {
        if ($poc == 0) {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','24','25')
 and a.ps_stageid >=14 and a.ps_stageid<=25 order by ps_stageid ASC ";
        } else {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','24')
 and a.ps_stageid >=14 and a.ps_stageid<=25 order by ps_stageid ASC ";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_secondrow_wo($pack_id, $poc) {
        if ($poc == 0) {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','24','25','20','21')
 and a.ps_stageid >=14 and a.ps_stageid<=25 order by ps_stageid ASC ";
        } else {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','24','20','21')
 and a.ps_stageid >=14 and a.ps_stageid<=25 order by ps_stageid ASC ";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_secondrow_po($pack_id, $poc) {
        if ($poc == 0) {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','24','25','22','23')
 and a.ps_stageid >=14 and a.ps_stageid<=25 order by ps_stageid ASC ";
        } else {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','24','22','23')
 and a.ps_stageid >=14 and a.ps_stageid<=25 order by ps_stageid ASC ";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_table($pack_id, $poc) {
        if ($poc == 0) {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days  from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','15','24')
 order by ps_stageid ASC ";
        } else {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days  from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','15','24')
 order by ps_stageid ASC ";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_thirdrow($pack_id, $poc) {
        if ($poc == 0) {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','27','26')
 and a.ps_stageid >25 and a.ps_stageid<=34 order by ps_stageid ASC ";
        } else {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15')
 and a.ps_stageid >25 and a.ps_stageid<=34 order by ps_stageid ASC ";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_thirdrow_wo($pack_id, $poc) {
        if ($poc == 0) {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','27','26','20','21','28','29','30','31','32','33','34')
 and a.ps_stageid >25 and a.ps_stageid<=34 order by ps_stageid ASC ";
        } else {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','22','23','28','29','30','31','32','33','34')
 and a.ps_stageid >25 and a.ps_stageid<=34 order by ps_stageid ASC ";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function repo_thirdrow_po($pack_id, $poc) {
        if ($poc == 0) {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','27','26','20','21','28','29','30','31','32','33','34')
 and a.ps_stageid >25 and a.ps_stageid<=34 order by ps_stageid ASC ";
        } else {
            $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as days from swift_packagestatus as a,swift_stage_master as b 
 where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','12','15','22','23','28','29','30','31','32','33','34')
 and a.ps_stageid >25 and a.ps_stageid<=34 order by ps_stageid ASC ";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function package_details($pack_id) {
        $sql = "select a.*,b.stage_name,shot_name,c.pm_revised_material_req,c.pm_revised_lead_time,c.pm_packagename,d.proj_name,
           DATEDIFF(DAY,a.revised_planned_date,a.ps_actualdate) as daysdif,ps_expdate
from swift_packagestatus as a,swift_stage_master as b, swift_packagemaster as c,Project as d
where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.active=1 and a.ps_packid=c.pm_packid and d.proj_id=a.ps_projid
order by ps_stageid ASC ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function vendor_details($pack_id) {
        $sql = "select distinct Quote_id,c.vq_venid,d.sup_name from Quote_Approval as a,solution as b,vendorquotemst as c,Vendor as d 
where a.Sol_id=b.sol_id and a.Quote_id=c.vq_doc_id and c.vq_venid=d.sup_id and b.swift_packid='" . $pack_id . "' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function get_app_quote($qid) {
        $sql = "select distinct qc_qudocid,qc_type,vq_venid,vq_solid,sup_code,sup_name,sol_name,sol_projid,proj_name,
                (select sum (qc_amt) as total from qc_mst where qc_qudocid='" . $qid . "') as total,
                (select sum (qcd_rate) as cost from qc_detl,qc_mst where qcd_id=qc_id and qc_qudocid='" . $qid . "') as cost
                 from qc_mst,vendorquotemst,vendor,solution,Project
                 where vq_doc_id=qc_qudocid and qc_qudocid='" . $qid . "' and sup_id=vq_venid and sol_id=vq_solid and sol_projid=proj_id  ";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_final_app_quote($qid) {
        $sql = "select distinct vq_oem, qc_qudocid,vq_venid,vq_solid,vq_refno,sup_name,sup_Address,sup_Phone,sup_Email,sup_Contact,sup_Mobile,sup_GSTIN,sol_name,sol_projid,proj_name,
                 (select sum (qc_amt) as total from qc_mst where qc_qudocid='" . $qid . "') as total 
                 from qc_mst,vendorquotemst,vendor,solution,Project,vendorquotedetl 
                 where vq_doc_id=qc_qudocid and qc_qudocid='" . $qid . "' and sup_id=vq_venid and sol_id=vq_solid "
                . "and sol_projid=proj_id and vq_doc_id=vqd_docid ";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_qcmst($qid) {
        $sql = "select qc_id,qcd_desc,qcd_qty,qcd_unit,qcd_rate,qcd_tax,qcd_rem,qc_amt,qc_scpe_qty,remark  from qc_mst,qc_detl where qcd_id= qc_id and qc_qudocid='" . $qid . "' order by qcd_rate DESC ";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_buyer() {
        $sql = "SELECT * FROM usermst WHERE usertype= '2'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function total_packages($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as packcount from swift_packagemaster,Project where proj_id=pm_projid  and cat_id='" . $segment . "'";
        } else {
            $sql = "select COUNT(*) as packcount from swift_packagemaster,Project where proj_id=pm_projid and cat_id='" . $segment . "'   and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['packcount'];
        return $count;
    }

    function get_acual($pack_id) {

        $sql = "select * from dbo.swift_packagestatus where ps_packid='" . $pack_id . "' and ps_stageid=33";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $actual = $row['ps_actualdate'];
        if ($actual == "" || $actual == "NULL") {
            $actualdate = "-";
        } else {
            $actualdate = formatDate($actual, 'd-M-Y');
        }
        echo $actualdate;
    }

    function om_count($pid) {
        if ($pid == "") {
            $sql = "select COUNT(*) as total from swift_OandM,Project where om_active=1 and om_status=0 and proj_id=om_projid ";
        } else {
            $sql = "select COUNT(*) as total from swift_OandM,Project where om_active=1 and om_status=0 and proj_id=om_projid  and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['total'];
        return $count;
    }

    function ops_count($pid, $segment) {
//        if ($pid == "") {
//            $sql = "select COUNT(*) as total  from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
// where proj_id=ps_projid and ps_packid=pm_packid and  active=1 and ps_stageid in(7,10,8,9,12,14,19,22,23,25,26,28)
// and ps_stageid=stage_id  ";
//        } else {
//            $sql = "select COUNT(*) as total  from swift_packagestatus,Project,swift_packagemaster,swift_stage_master 
// where proj_id=ps_projid and ps_packid=pm_packid and  active=1 and ps_stageid in(7,10,8,9,12,14,19,22,23,25,26,28)
// and ps_stageid=stage_id and proj_id='" . $pid . "' ";
//        }
        if ($pid == "") {
//            $sql = "select count(*) from solution where swift_packid in(select pm_packid from dbo.swift_packagemaster) ";
            $sql = "select count(*) from solution where swift_packid in
(select pm_packid from dbo.swift_packagemaster,Project where pm_projid=proj_id $segment )";
        } else {
//            $sql = "select count(*) from solution where swift_packid in(select pm_packid from dbo.swift_packagemaster where pm_projid='" . $pid . "'  ) ";
            $sql = "select count(*) from solution where swift_packid in
(select pm_packid from dbo.swift_packagemaster,Project where pm_projid=proj_id $segment and pm_projid='" . $pid . "' )";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['total'];
        return $count;
    }

    function om_repo($pid) {
        if ($pid == "") {
            $sql = "select COUNT(*) as total from swift_OandM,Project where om_active=1 and om_status=1 and proj_id=om_projid ";
        } else {
            $sql = "select COUNT(*) as total from swift_OandM,Project where om_active=1 and om_status=1 and proj_id=om_projid  and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['total'];
        return $count;
    }

    function files_inopsrepo($pid) {
        if ($pid == "") {
            $sql = "select   name,om_packid,om_projid,om_recvuid,om_recv_stageid,proj_name,om_remarks,om_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,ps_expdate,ps_actualdate,stage_name 
                    from usermst,swift_OandM,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=om_projid and
                    om_packid=pm_packid and om_packid=ps_packid  and ps_stageid=om_recv_stageid  
                    and stage_id=om_recv_stageid  and uid=om_senderuid and om_active=1 and om_status=1";
        } else {
            $sql = "select   name,om_packid,om_projid,om_recvuid,om_recv_stageid,proj_name,om_remarks,om_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,ps_expdate,ps_actualdate,stage_name 
                    from usermst,swift_OandM,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=om_projid and
                    om_packid=pm_packid and om_packid=ps_packid and om_projid='" . $pid . "' and ps_stageid=om_recv_stageid  
                    and stage_id=om_recv_stageid   and proj_id='" . $pid . "' and uid=om_senderuid and om_active=1 and om_status=1";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_from_smartsignloi($pid, $uid) {
        if ($pid == "") {
            $sql = "select distinct bu_buyer_id,so_pack_id,so_proj_id,proj_name,ps_expdate,so_package_approved_date,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,stage_name,hpc_app  
                    from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master,swift_SCMtoBUYER  
                    where proj_id=so_proj_id and so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=18 
                    and stage_id=18  and so_status=0 and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "'";
        } else {
            $sql = "select distinct bu_buyer_id,so_pack_id,so_proj_id,proj_name,ps_expdate,so_package_approved_date,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,stage_name,hpc_app  
                    from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master,swift_SCMtoBUYER  
                    where proj_id=so_proj_id and so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=18 
                    and stage_id=18  and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "' and proj_id='" . $pid . "' and so_status=0";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_from_smartsignloi_ajax($pack_id) {
        $sql = "select distinct so_pack_id,so_proj_id,proj_name,ps_expdate,
                    pm_packagename,pm_revised_material_req,revised_planned_date as planned, GETDATE() as expected,GETDATE() as actual,stage_name,hpc_app 
                    from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=so_proj_id and
                    so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=18
                    and stage_id=18  and so_status=0 and so_pack_id='" . $pack_id . "'";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_for_emrcreation($pid, $segment) {
        if ($pid == "") {
            $sql = "select pm_packid,pm_projid,proj_name,pm_packagename,stage_name,revised_planned_date as planned,GETDATE() as actual,ps_expdate,pm_material_req,pm_revised_material_req
from  swift_packagemaster,Project,swift_packagestatus,swift_stage_master
where pm_projid=proj_id and ps_stageid=stage_id and ps_packid=pm_packid and emr_status=0  and stage_id=19 and cat_id='" . $segment . "'";
        } else {
            $sql = "select pm_packid,pm_projid,proj_name,pm_packagename,stage_name,revised_planned_date as planned,GETDATE() as actual,ps_expdate,pm_material_req,pm_revised_material_req
from  swift_packagemaster,Project,swift_packagestatus,swift_stage_master
where pm_projid=proj_id and ps_stageid=stage_id and ps_packid=pm_packid and emr_status=0  and stage_id=19 and cat_id='" . $segment . "' and proj_id='" . $pid . "'";
        }


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_for_emrcreation_afterloi($pid, $segment) {
        if ($pid == "") {
            $sql = "select pm_packid,pm_projid,proj_name,pm_packagename,stage_name,revised_planned_date as planned,GETDATE() as actual,ps_expdate,pm_material_req,pm_revised_material_req
from  swift_packagemaster,Project,swift_packagestatus,swift_stage_master
where pm_projid=proj_id and ps_stageid=stage_id and ps_packid=pm_packid and emr_status=3  and stage_id=19 and cat_id='" . $segment . "'";
        } else {
            $sql = "select pm_packid,pm_projid,proj_name,pm_packagename,stage_name,revised_planned_date as planned,GETDATE() as actual,ps_expdate,pm_material_req,pm_revised_material_req
from  swift_packagemaster,Project,swift_packagestatus,swift_stage_master
where pm_projid=proj_id and ps_stageid=stage_id and ps_packid=pm_packid and emr_status=3  and stage_id=19 and cat_id='" . $segment . "' and proj_id='" . $pid . "'";
        }


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function filesforemr_ajax($pack_id) {
        $sql = "SELECT pm_packid,pm_projid,proj_name,pm_packagename,stage_name,revised_planned_date as planned,GETDATE() as actual,ps_expdate,pm_material_req,pm_revised_material_req
from  swift_packagemaster,Project,swift_packagestatus,swift_stage_master
where pm_projid=proj_id and ps_stageid=stage_id and ps_packid=pm_packid and emr_status='3'  and stage_id=19 and pm_packid='" . $pack_id . "' ";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_emrcreationcount($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as emr_count
                    from swift_packagemaster,Project where proj_id=pm_projid and cat_id='" . $segment . "' and emr_status=0";
        } else {
            $sql = "select COUNT(*) as emr_count
                    from swift_packagemaster,Project where proj_id=pm_projid and cat_id='" . $segment . "' and pm_projid='" . $pid . "' and emr_status=0";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['emr_count'];
        return $count;
    }

    function files_emrcreationcount_afterloi($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as emr_count
                    from swift_packagemaster,Project where proj_id=pm_projid and cat_id='" . $segment . "' and emr_status=3";
        } else {
            $sql = "select COUNT(*) as emr_count
                    from swift_packagemaster,Project where proj_id=pm_projid and cat_id='" . $segment . "' and pm_projid='" . $pid . "' and emr_status=3";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['emr_count'];
        return $count;
    }

    function files_for_emrrepo($pid, $segment) {
        if ($pid == "") {
            $sql = "select emr_number,emr_remarks,pm_packid,pm_projid,proj_name,pm_packagename,stage_name,revised_planned_date as planned,GETDATE() as actual,ps_expdate,emr_createddate,pm_material_req,pm_revised_material_req
from  swift_packagemaster,Project,swift_packagestatus,swift_stage_master,swift_emrcreation
where pm_projid=proj_id and ps_stageid=stage_id and ps_packid=pm_packid and emr_status=1 and emr_packid=pm_packid
 and stage_id=19 and cat_id='" . $segment . "'";
        } else {
            $sql = "select emr_number,emr_remarks,pm_packid,pm_projid,proj_name,pm_packagename,stage_name,revised_planned_date as planned,GETDATE() as actual,ps_expdate,emr_createddate,pm_material_req,pm_revised_material_req
from  swift_packagemaster,Project,swift_packagestatus,swift_stage_master,swift_emrcreation
where pm_projid=proj_id and ps_stageid=stage_id and ps_packid=pm_packid and emr_status=1 and emr_packid=pm_packid
 and stage_id=19 and cat_id='" . $segment . "' and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function files_for_workoder_count($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as wo_count
from swift_filesfrom_smartsignoff,Project where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=3";
        } else {
            $sql = "select COUNT(*) as wo_count
from swift_filesfrom_smartsignoff,Project where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=3 and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['wo_count'];
        return $count;
    }

    function files_for_workoder_entry_count($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order in (0,1)";
        } else {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order in (0,1) and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['wos_count'];
        return $count;
    }

    function files_for_workoder_entry_count_user($pid, $segment, $uid) {
        if ($pid == "") {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project,swift_SCMSPOC  where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order in (0,1) and sc_packid=so_pack_id and sc_active=1 and sc_senderuid='" . $uid . "'";
        } else {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project,swift_SCMSPOC  where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order in (0,1) and proj_id='" . $pid . "' and sc_packid=so_pack_id and sc_active=1 and sc_senderuid='" . $uid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['wos_count'];
        return $count;
    }

    function files_for_wodate_entry_count($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=0";
        } else {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=0 and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['wos_count'];
        return $count;
    }

    function files_for_woapp_entry_count($pid, $segment) {
        if ($pid == "") {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=1";
        } else {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=1 and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['wos_count'];
        return $count;
    }

    function files_for_wodate_entry_count_user($pid, $segment, $uid) {
        if ($pid == "") {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project,swift_SCMSPOC where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=0 and sc_packid=so_pack_id and sc_active=1 and sc_senderuid='" . $uid . "' and so_status=1";
        } else {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project,swift_SCMSPOC where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=0 and proj_id='" . $pid . "' and sc_packid=so_pack_id and sc_active=1 and sc_senderuid='" . $uid . "' and so_status=1";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['wos_count'];
        return $count;
    }

    function files_for_woapp_entry_count_user($pid, $segment, $uid) {
        if ($pid == "") {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project,swift_SCMSPOC where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=1 and sc_packid=so_pack_id and sc_active=1 and sc_senderuid='" . $uid . "'";
        } else {
            $sql = "select COUNT(*) as wos_count
from swift_filesfrom_smartsignoff,Project,swift_SCMSPOC where so_proj_id=proj_id and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=1 and proj_id='" . $pid . "' and sc_packid=so_pack_id and sc_active=1 and sc_senderuid='" . $uid . "'";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['wos_count'];
        return $count;
    }

    function files_forwoentry($pid, $segment) {
        if ($pid == "") {
            $sql = "select proj_id,proj_name,pm_packagename,pm_packid,wo_number from swift_filesfrom_smartsignoff,Project,swift_packagemaster 
where so_proj_id=proj_id and so_pack_id=pm_packid and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=3 ";
        } else {
            $sql = "select proj_id,proj_name,pm_packagename,pm_packid,wo_number from swift_filesfrom_smartsignoff,Project,swift_packagemaster 
where so_proj_id=proj_id and so_pack_id=pm_packid and cat_id='" . $segment . "' and  so_hw_sw in(1,3) and work_order=3  and proj_id='" . $pid . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_completed($pid) {

        $sql = "select wo_ttlcompleted   from swift_wocreation where  wo_packid='" . $pid . "'";

        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $count = $row['wo_ttlcompleted'];
        if ($count == "") {
            $count = 0;
        }
        return $count;
    }

    function emr_check($packname) {
        $emr = mssql_query("select * from swift_emrcreation where emr_packid='" . $packname . "'");
        $num_rows = mssql_num_rows($emr);
        if ($num_rows > 0) {
            $row = mssql_fetch_array($emr);
            $emr = $row['emr_number'];
        } else {
            $emr = '';
        }
        return $emr;
    }

    function files_for_techapp_clearance($pid, $segment) {
        if ($pid == "") {
            $sql = "select  distinct swift_techapproval.tech_status,name,tech_packid,tech_projid,tech_recvuid,tech_recv_stageid,proj_name,tech_remarks,tech_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, ps_expdate as expected,GETDATE() as actual,stage_name,stage_id 
                    from usermst,swift_techapproval,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=tech_projid and
                    tech_packid=pm_packid and tech_packid=ps_packid  and ps_stageid=tech_recv_stageid  
                    and stage_id=tech_recv_stageid and cat_id='" . $segment . "' and uid=tech_senderuid and tech_active=1 and swift_techapproval.tech_status in('0','1') ";
        } else {
            $sql = "select  distinct swift_techapproval.tech_status,name,tech_packid,tech_projid,tech_recvuid,tech_recv_stageid,proj_name,tech_remarks,tech_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, ps_expdate as expected,GETDATE() as actual,stage_name,stage_id 
                    from usermst,swift_techapproval,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=tech_projid and
                    tech_packid=pm_packid and tech_packid=ps_packid  and ps_stageid=tech_recv_stageid and tech_projid='" . $pid . "'  
                    and stage_id=tech_recv_stageid and cat_id='" . $segment . "' and uid=tech_senderuid and tech_active=1 and  proj_id='" . $pid . "' and swift_techapproval.tech_status in('0','1','3')";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function manuclr($pack_id) {
        $sql = "select ps_packid,ps_stageid,revised_planned_date as planned,ps_expdate as expected from swift_packagestatus,swift_stage_master 
where ps_stageid=stage_id and ps_stageid=29 and ps_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function insclr($pack_id) {
        $sql = "select ps_packid,ps_stageid,revised_planned_date as planned,ps_expdate as expected from swift_packagestatus,swift_stage_master 
where ps_stageid=stage_id and ps_stageid=30 and ps_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function mdcclr($pack_id) {
        $sql = "select ps_packid,ps_stageid,revised_planned_date as planned,ps_expdate as expected from swift_packagestatus,swift_stage_master 
where ps_stageid=stage_id and ps_stageid=31 and ps_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function cusclr($pack_id) {
        $sql = "select ps_packid,ps_stageid,revised_planned_date as planned,ps_expdate as expected from swift_packagestatus,swift_stage_master 
where ps_stageid=stage_id and ps_stageid=32 and ps_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function mtrecvclr($pack_id) {
        $sql = "select ps_packid,ps_stageid,revised_planned_date as planned,ps_expdate as expected from swift_packagestatus,swift_stage_master 
where ps_stageid=stage_id and ps_stageid=33 and ps_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function mrnclr($pack_id) {
        $sql = "select ps_packid,ps_stageid,revised_planned_date as planned,ps_expdate as expected from swift_packagestatus,swift_stage_master 
where ps_stageid=stage_id and ps_stageid=34 and ps_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function files_for_podetailsalter($pid, $segment) {
        if ($pid == "") {
            $sql = "select distinct proj_name,po_pack_id,pm_packagename,po_number,pm_revised_material_req,count(*) as count ,SUM(sqty) as total_Qty,((SUM(mqty)/SUM(sqty))*100) as manuQty,((SUM(iqty)/SUM(sqty))*100) as insQty,
((SUM(mdccqty)/SUM(sqty))*100) as mdccQty,((SUM(cclr_qty)/SUM(sqty))*100) as cclrQty,
((SUM(mrqty)/SUM(sqty))*100) as mrecQty
from swift_podetails as a
left join swift_poentrysave as b on a.swid=b.sweid
left join swift_packagemaster as c on c.pm_packid=a.po_pack_id
left join Project as d on d.proj_id=a.po_proj_id 
where  cat_id='" . $segment . "'  
group by proj_name, pm_packagename,po_number,pm_revised_material_req,po_pack_id";
        } else {
            $sql = "select distinct proj_name,po_pack_id,pm_packagename,po_number,pm_revised_material_req,count(*) as count ,SUM(sqty) as total_Qty,((SUM(mqty)/SUM(sqty))*100) as manuQty,((SUM(iqty)/SUM(sqty))*100) as insQty,
((SUM(mdccqty)/SUM(sqty))*100) as mdccQty,((SUM(cclr_qty)/SUM(sqty))*100) as cclrQty,
((SUM(mrqty)/SUM(sqty))*100) as mrecQty
from swift_podetails as a
left join swift_poentrysave as b on a.swid=b.sweid
left join swift_packagemaster as c on c.pm_packid=a.po_pack_id
left join Project as d on d.proj_id=a.po_proj_id 
where  cat_id='" . $segment . "' and proj_id='" . $pid . "'
group by proj_name, pm_packagename,po_number,pm_revised_material_req,po_pack_id";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function fetch_lcnumber($ven_id) {
        $sql = "select * from  swift_lcmaster where lcm_venid='" . $ven_id . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function fetch_rpanumber($ven_id) {
        $sql = "select * from  swift_rpamaster where rpa_venid='" . $ven_id . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function check_vendorlc($ven_id) {
        $sql = "select * from  swift_lcmaster where lcm_venid='" . $ven_id . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $vencheck = 1;
        } else {
            $vencheck = 0;
        }
        return $vencheck;
    }

    function get_povalue($pack_id) {
        $sql = "select SUM(srate) as povalue from swift_podetails where po_pack_id='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function get_wovalue($pack_id) {
        $sql = "select wo_value as povalue from  dbo.swift_filesfrom_smartsignoff where so_pack_id='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function check_vendorrpa($ven_id) {
        $sql = "select * from  swift_rpamaster where rpa_venid='" . $ven_id . "'";
        $query = mssql_query($sql);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $vencheck = 1;
        } else {
            $vencheck = 0;
        }
        return $vencheck;
    }

    function total_ebrvalue($ven_id, $flag) {
        $sql = "select isnull(SUM(ebr_billvalue),0) as total from swift_ebrbill_entry where ebr_venid='" . $ven_id . "' and ebr_po_wo_flag='" . $flag . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function check_poc($pack_id) {
        $sql = "select isnull(cm_poc_required,1) as cm_poc_required from swift_checklist_mapping where cm_pack_id='" . $pack_id . "' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function filesforemr_ajaxrepo($pack_id) {
        $sql = "select pm_packid,pm_projid,proj_name,pm_packagename,stage_name,revised_planned_date as planned,GETDATE() as actual,ps_expdate,pm_material_req,pm_revised_material_req
from  swift_packagemaster,Project,swift_packagestatus,swift_stage_master
where pm_projid=proj_id and ps_stageid=stage_id and ps_packid=pm_packid and emr_status=1  and stage_id=19 and pm_packid='" . $pack_id . "' ";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function fetch_delays($pack_id) {
        $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as delay  
from swift_packagestatus as a,swift_stage_master as b 
where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid not in('4','7','10','11','13','15') 
and  DATEDIFF(DAY,revised_planned_date,ps_actualdate)>0
order by ps_stageid ASC  ";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function expe_delidate($pack_id) {
        $sql = "select a.*,b.stage_name,shot_name,DATEDIFF(DAY,revised_planned_date,ps_actualdate) as delay  
from swift_packagestatus as a,swift_stage_master as b 
where a.ps_stageid=b.stage_id and a.ps_packid='" . $pack_id . "' and a.ps_stageid =33 ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function get_actualreceive($pack_id, $stageid) {
        if ($stageid == 1) {
            $sql = " select top 1* from  swift_packagestatus 
 where ps_packid='$pack_id'  and ps_actualdate !='' and ps_stageid <= '" . $stageid . "' and 
'$stageid' <= (select ps_stageid from swift_packagestatus where active=1 and ps_packid='$pack_id')  
 order by ps_stageid DESC";
        } else {
            $sql = "select top 1* from  swift_packagestatus 
 where ps_packid='$pack_id'  and ps_actualdate !='' and ps_stageid < '" . $stageid . "' and 
'$stageid' <= (select ps_stageid from swift_packagestatus where active=1 and ps_packid='$pack_id')  
 order by ps_stageid DESC";
        }
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $num_rows = mssql_num_rows($query);
        if ($num_rows > 0) {
            $x = $row['ps_actualdate'];
        } else {
            $x = 0;
        }
        return $x;
    }

    function get_omremarks($packid) {
        $sql = " select distinct omop_remarks,omop_sentdate from swift_OMtoOPs where omop_packid='" . $packid . "' and omop_active=1 order by omop_sentdate DESC";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function files_from_smartsignloi_filter($pid, $uid, $hpc) {
        if ($pid == "") {
            $sql = "select distinct bu_buyer_id,so_pack_id,so_proj_id,proj_name,ps_expdate,so_package_approved_date,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,stage_name,hpc_app  
                    from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master,swift_SCMtoBUYER  
                    where proj_id=so_proj_id and so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=18 
                    and stage_id=18  and so_status=0 and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "' and hpc_app ='" . $hpc . "'";
        } else {
            $sql = "select distinct bu_buyer_id,so_pack_id,so_proj_id,proj_name,ps_expdate,so_package_approved_date,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,stage_name,hpc_app  
                    from swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,Project,swift_stage_master,swift_SCMtoBUYER  
                    where proj_id=so_proj_id and so_pack_id=pm_packid and so_pack_id=ps_packid  and ps_stageid=18 
                    and stage_id=18  and bu_packid=so_pack_id and bu_buyer_id='" . $uid . "' and proj_id='" . $pid . "' and so_status=0 and hpc_app ='" . $hpc . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_loidetails($getid) {
        $sql = "select * from [dbo].[swift_filesfrom_smartsignoff] where so_id='" . $getid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function check_user($getid, $uid) {
        $sql = "select * from swift_filesfrom_smartsignoff,swift_SCMSPOC where so_id='" . $getid . "' and sc_packid=so_pack_id and sc_active=1 and sc_senderuid='" . $uid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function fetch_uname($uid) {
        $sql = "select * from usermst where uid='$uid' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        $uname = $row['name'];
        return $uname;
    }

    function select_files_opswoentry($id, $segment) {
        if ($id != "") {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff where po_wo_status !='4' AND so_proj_id= '$id'";
            $sql = "SELECT so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,shot_name as stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,Project  
            WHERE  proj_id=so_proj_id and stage_id=ps_stageid and  so_pack_id=pm_packid AND so_pack_id=ps_packid AND active='1' AND work_order !='3' and so_status=1 and cat_id='" . $segment . "' AND so_proj_id= '$id'";
        } else {
            // $sql = "SELECT * FROM swift_filesfrom_smartsignoff WHERE po_wo_status !='4'";
            $sql = "SELECT so_id,so_loi_date,so_proj_id,so_pack_id,so_hw_sw,so_commercial_close_date,so_package_sentdate,so_package_approved_date,so_status,ps_stageid,shot_name as stage_name,
            revised_planned_date as planned_date,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,ps_remarks
            FROM swift_filesfrom_smartsignoff,swift_packagemaster,swift_packagestatus,swift_stage_master,Project  
            WHERE  proj_id=so_proj_id and  stage_id=ps_stageid and so_pack_id=pm_packid AND so_pack_id=ps_packid AND active='1' AND work_order !='3' and so_status=1 and cat_id='" . $segment . "'";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_wodate($packid, $stage) {
        $sql = "select * from [dbo].[swift_packagestatus] where ps_packid='" . $packid . "' and ps_stageid in ($stage)";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);

        return $row;
    }

    function get_po_wo_app($pack_id) {
        $sql = "select * from  [dbo].[swift_filesfrom_smartsignoff] where so_pack_id='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        return $row;
    }

    function current_status($packid) {
        $sql = "select d.name as sname,b.name,b.usertype,c.shot_name,(isnull(DATEDIFF(DAY,a.ps_actualdate,GETDATE()),0)) as nodays, a.* from  dbo.swift_packagestatus as a
left join usermst as b on a.ps_userid=b.uid
left join swift_stage_master as c on a.ps_stageid=c.stage_id  
left join usermst as d on a.ps_sbuid=d.uid
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
            } else if ($utype == 2) {
                $sent = 'Buyer';
            } else if ($utype == 5) {
                $sent = 'OPS';
            }
            $status = 'Sent back by ' . $sent . '<br>(' . $row['sname'] . ' / ' . $row['nodays'] . ' Days )';
        } else {


            if ($row['name'] == "") {
                $status = $row['shot_name'] . '<br>(' . $row['name'] . ' / ' . $row['nodays'] . ' Days )';
            } else {
                $status = $row['shot_name'] . '<br>(' . $row['name'] . ' / ' . $row['nodays'] . ' Days )';
            }
        }
        return $status;
    }

    function check_hpc($pack_id) {
        $sql = "select * from  [dbo].[swift_filesfrom_smartsignoff] where so_pack_id='" . $pack_id . "' and hpc_app=1 and so_status=1 ";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        $num_rows = mssql_num_rows($query);
        return $num_rows;
    }

    function get_approver_name($pack_id) {
        $sql = "select distinct b.Sol_id,b.Quote_id,d.name,e.dep_name,f.hpc_app,f.so_status from solution as a,Quote_Approval as b,Quote_status as c,
        usermst as d ,Department as e,swift_filesfrom_smartsignoff as f
        where a.sol_id=b.Sol_id and c.s_qid= b.Quote_id  and c.sender_uid= d.uid and c.staus=1 and 
        d.deptid = e.dep_id and a.swift_packid = f.so_pack_id  and a.swift_packid='" . $pack_id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        return $row;
    }

    function package_fetch($pid) {
        if ($pid == "all") {
            $sql = "select * from swift_packagemaster";
        } else {
            $sql = "select * from swift_packagemaster where pm_projid='" . $pid . "'";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function fetch_buyername($packid) {
        $sql = "select distinct name,bu_buyer_id from swift_SCMtoBUYER,usermst where bu_packid='" . $packid . "' and bu_buyer_id=uid and bu_status IN(0,1,2,3)  ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $name = $row['name'];
        return $name;
    }

    function fetch_alldatils($packid) {
        $sql = "select distinct s_qid,b.vq_venid,b.vq_solid,c.sol_name,c.swift_packid,sum(vq_quoteamt) as po_value,d.proj_name,e.vqd_paytrm,d.proj_id,f.sup_name from Quote_status as a, 
                    vendorquotemst as b,solution as c,Project as d,vendorquotedetl as e, Vendor as f,swift_packagemaster as g where a.s_qid = b.vq_doc_id and b.vq_solid =c.sol_id and
                     c.sol_projid=d.proj_id and e.vqd_docid=a.s_qid  and f.sup_id=b.vq_venid  and c.swift_packid = g.pm_packid and c.swift_packid ='" . $packid . "'   
                    group by s_qid,b.vq_venid,b.vq_solid,c.sol_name,c.swift_packid,d.proj_name,e.vqd_paytrm,d.proj_id ,f.sup_name ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function current_status_1($packid) {
        $sql = "select d.name as sname,b.name,b.usertype,c.shot_name,(isnull(DATEDIFF(DAY,a.ps_actualdate,GETDATE()),0)) as nodays, a.* from  dbo.swift_packagestatus as a
left join usermst as b on a.ps_userid=b.uid
left join swift_stage_master as c on a.ps_stageid=c.stage_id  
left join usermst as d on a.ps_sbuid=d.uid
where  a.active=1  and a.ps_packid='" . $packid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        $sent_back = $row['ps_stback'];
        $utype = $row['usertype'];

        if ($sent_back == 1) {
            $sql = "select * from usermst where uid='" . $row['ps_sbuid'] . "' ";
            $query = mssql_query($sql);
            $row = mssql_fetch_assoc($query);
            $fetch_usertype = $row['usertype'];
//            $fetch_usertype = $cls_comm->fetch_usertype($row['ps_sbuid']);
        } else {
            $sql = "select * from usermst where uid='" . $row['ps_userid'] . "' ";
            $query = mssql_query($sql);
            $row = mssql_fetch_assoc($query);
            $fetch_usertype = $row['usertype'];
//            $fetch_usertype = $cls_comm->fetch_usertype($row['ps_userid']);
        }
        if ($fetch_usertype == 2) {
            $status = 'SCM';
        } else if ($fetch_usertype == 14) {
            $status = 'OPS';
        } else if ($fetch_usertype == 5) {
            $status = 'OPS';
        } else if ($fetch_usertype == 10) {
            $status = 'TECHNICAL';
        } else if ($fetch_usertype == 11) {
            $status = 'TECHNICAL';
        } else if ($fetch_usertype == 12) {
            $status = 'TECHNICAL';
        } else if ($fetch_usertype == 15) {
            $status = 'O&M';
        }


        return $status;
    }

    function get_techsignoffdate($packid, $stage) {
        $sql = "select * from [dbo].[swift_packagestatus] where ps_packid='" . $packid . "' and ps_stageid='" . $stage . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        return $row;
    }

    function smart_approve($packid, $status) {
        if ($status == "1") {
            $sql = "select distinct b.Sol_id,b.Quote_id,d.name,e.dep_name,f.hpc_app,f.so_status,c.s_date from solution as a,Quote_Approval as b,Quote_status as c,
        usermst as d ,Department as e,swift_filesfrom_smartsignoff as f
        where a.sol_id=b.Sol_id and c.s_qid= b.Quote_id  and c.sender_uid= d.uid and c.staus in(0,1) and 
        d.deptid = e.dep_id and a.swift_packid = f.so_pack_id  and a.swift_packid='" . $packid . "'";
        } else {
            $sql = "select distinct b.Sol_id,b.Quote_id,d.name as sender,e.dep_name as sender_dep,c.s_date,c.staus,g.name as receiver 
from solution as a,Quote_Approval as b,Quote_status as c,usermst as d,Department as e,usermst as g
where a.sol_id=b.Sol_id and c.s_qid= b.Quote_id  and c.sender_uid= d.uid and c.staus in (0) and g.deptid=c.rcvr_dept_id and
d.deptid = e.dep_id    and a.swift_packid='" . $packid . "'   ";
        }

        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        return $row;
    }

    function system_details($packid) {
        $sql = "select * from swift_filesfrom_smartsignoff as a 
                left join swift_emrcreation as b on b.emr_packid =a.so_pack_id where  a.so_pack_id ='" . $packid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        return $row;
    }

    function target_date($packid) {
        $sql = "select * from swift_targetdates where  sm_pack_id ='" . $packid . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_assoc($query);
        return $row;
    }

}

?>