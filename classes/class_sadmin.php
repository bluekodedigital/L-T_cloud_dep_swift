<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Superadmin {

    function create_project($data) {
        $sdate = $data['sdate'];
        $edate = $data['edate'];
        $redate = $data['redate'];
        // $sdate = date('Y-m-d H:i:s', strtotime($data['sdate']));
        // $edate = date('Y-m-d H:i:s', strtotime($data['edate']));
        // $redate =date('Y-m-d H:i:s', strtotime($data['redate']));
        $catagories = $data['catagories'];
        $creator_id = $_SESSION['uid'];

        $sql = "select * from segment_master where seg_pid='" . $catagories . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $catname = $row['seg_name'];
            $cat_id = $row['seg_pid'];
        }
        $no_value = 0;

        $sql = "insert into Project(proj_name,proj_created_date,proj_edate,proj_revised_edate,catagories,location,address,shortcode,cat_id,hand_over_remarks,creator_id,package_status,createdat,client_loi,cont_agree,kick_meet,tech_comer,tech_cost,ace_sub,ace_sheet,proj_jobcode,proj_type) "
                . "values('" . $data['proj_name'] . "','" . $sdate . "','" . $edate . "','" . $redate . "','" . $catname . "',"
                . " '" . $data['location'] . "','" . $data['address'] . "','" . $data['proj_shname'] . "','" . $cat_id . "','" . $data['h_o_remarks'] . "','" . $creator_id . "','" . $no_value . "','" . date('Y-m-d H:i:s') . "',"
                . " '" . $data['client_loi'] . "','" . $data['cont_agree'] . "','" . $data['kick_meet'] . "','" . $data['tech_comer'] . "','" . $data['tech_cost'] . "','" . $data['ace_sub'] . "','" . $data['ace_sheet'] . "','" . $data['proj_jobcode'] . "','" . $data['proj_type'] . "')";
        $query = mssql_query($sql);
        $sql1 = "select top 1 * from Project order by proj_id DESC ";
        $quer = mssql_query($sql1);
        $row = mssql_fetch_array($quer);
        $id=$row['proj_id'];
        return $id;
    }

    function update_project($data) {
        $sdate = $data['sdate'];
        $edate = $data['edate'];
        $redate = $data['redate'];
        $catagories = $data['catagories'];

        $sql = "select * from segment_master where seg_pid='" . $catagories . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $catname = $row['seg_name'];
            $cat_id = $row['seg_pid'];
        }
        $sql = "update Project set proj_name='" . $data['proj_name'] . "',proj_created_date='" . $sdate . "',proj_edate='" . $edate . "',proj_revised_edate='" . $redate . "',catagories='" . $catname . "',location='" . $data['location'] . "',address='" . $data['address'] . "',shortcode='" . $data['proj_shname'] . "',cat_id='" . $cat_id . "',"
                . "client_loi= '" . $data['client_loi'] . "',cont_agree= '" . $data['cont_agree'] . "',kick_meet= '" . $data['kick_meet'] . "',tech_comer= '" . $data['tech_comer'] . "',tech_cost= '" . $data['tech_cost'] . "',ace_sub='" . $data['ace_sub'] . "',ace_sheet='" . $data['ace_sheet'] . "',hand_over_remarks='" . $data['h_o_remarks'] . "',proj_jobcode='".$data['proj_jobcode']."',proj_type='".$data['proj_type']."' where proj_id='" . $data['proj_id'] . "' ";

        $query = mssql_query($sql);
    }

    function create_stage($data) {

        $sql = "SELECT MAX(stage_id) as id FROM swift_stage_master;";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        $id = $row['id'] + 1;
         $sql = "insert into swift_stage_master(stage_id,stage_name,flag,display_order,shot_name,weightage,usertype,file_attach,sendback)
                values('" . $id . "','" . $data['stage_name'] . "','1','" . $id . "','" . $data['shot_name'] . "','" . $data['weightage'] . "','" . $data['usertype'] . "','" . $data['file_attach'] . "','" .$data['sendback']. "')";
                $query = mssql_query($sql);
    }

    function disp_order_change($data) {
        $sql = "update swift_stage_master set display_order='" . $data['display_order'] . "' where stage_id='" . $data['stage_id'] . "' ";
        $query = mssql_query($sql);
    }
     function select_doctype() {
        $sql = "select * from swift_doctype where dt_active=1";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
     function select_teamcode() {
        $sql = "select * from swift_temcode where tc_active=1";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
     function select_docset() {
        $sql = "select * from swift_docsetcode where dc_active=1";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
     function select_systemcode() {
        $sql = "select * from swift_systemcode where sc_active=1";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function job_code($id) {
        $sql = "select * from Project WHERE proj_id = $id";
        $query = mssql_query($sql);
        if (mssql_num_rows($query) > 0) {
            $row = mssql_fetch_array($query);
            return $row['proj_jobcode'];
        } else {
            return "NO JOB CODE FOUND";
        }
    }
    function select_technical_checklist(){
        $sql = "select * from swift_technical_checklist";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function get_docname($id){
        $sql = "select * from swift_technical_checklist where tcl_id='".$id."'";
        $query = mssql_query($sql);
         $row = mssql_fetch_array($query);
       
        echo $row['tcl_name'];
    }
    function get_history($pack_id,$cid){
        $sql = "select * from swift_technical_cklist_history where stc_cklid='".$cid."' and stc_packid ='".$pack_id."' ";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);       
        return $row;
    }
//    function get_history($pack_id,$uid,$cid){
//        $sql = "select * from swift_technical_cklist_history where stc_cklid='".$cid."' and stc_packid ='".$pack_id."' and stc_uid='".$uid."'";
//        $query = mssql_query($sql);
//        $row = mssql_fetch_array($query);       
//        return $row;
//    }

}
