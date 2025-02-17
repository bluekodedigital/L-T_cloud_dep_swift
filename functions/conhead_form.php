<?php

include_once ("../config/inc_function.php");
$csrf_token = $_REQUEST['csrf_token'];
if (isset($_SESSION['token']) && $csrf_token === $_SESSION['token']) {
if (isset($_POST['project_create'])) {
    //echo 'hi';
    extract($_POST);
    $proj_name = sanitize($_POST['proj_name']);
    $proj_shname = sanitize($_POST['proj_shrtname']);
    $location = sanitize($_POST['proj_location']);
    $address = sanitize($_POST['proj_address']);
    $catagories = sanitize($_POST['segment']);
    $h_o_remarks = sanitize($_POST['h_o_remarks']);
    $project_type = sanitize($_POST['proj_type']);
    $sdate = formatDate(str_replace('/', '-', $_POST['start_date']), 'Y-m-d h:i:s');
    $edate = formatDate(str_replace('/', '-', $_POST['end_date']), 'Y-m-d h:i:s');
    $redate = formatDate(str_replace('/', '-', $_POST['revend_date']), 'Y-m-d h:i:s');

    $client_loi = formatDate(str_replace('/', '-', $client_loi), 'Y-m-d h:i:s');
    $cont_agree = formatDate(str_replace('/', '-', $cont_agree), 'Y-m-d h:i:s');
    $kick_meet = formatDate(str_replace('/', '-', $kick_meet), 'Y-m-d h:i:s');
    $tech_comer = formatDate(str_replace('/', '-', $tech_comer), 'Y-m-d h:i:s');
    $tech_cost = formatDate(str_replace('/', '-', $tech_cost), 'Y-m-d h:i:s');
    $ace_sub = formatDate(str_replace('/', '-', $ace_sub), 'Y-m-d h:i:s');
    $ace_sheet = formatDate(str_replace('/', '-', $ace_sheet), 'Y-m-d h:i:s');

    $data = array(
        'proj_name' => $proj_name,
        'proj_shname' => $proj_shname,
        'location' => $location,
        'address' => $address,
        'catagories' => $catagories,
        'sdate' => $sdate,
        'edate' => $edate,
        'redate' => $redate,
        'h_o_remarks' => $h_o_remarks,
        'client_loi' => $client_loi,
        'cont_agree' => $cont_agree,
        'kick_meet' => $kick_meet,
        'tech_comer' => $tech_comer,
        'tech_cost' => $tech_cost,
        'ace_sub' => $ace_sub,
        'ace_sheet' => $ace_sheet,
        'proj_type' => $project_type,
    );
   //print_r($data);exit;
    $result = $super_admin->create_project($data);
//    if($result==1){
//        
//    }
    //print_r($result);
    //header('Location: ../sadmin/project_master.php');
    echo "<script>window.location.href='../project_master.php?id=$result';</script>";
} elseif (isset($_POST['project_update'])) {
      extract($_POST);
     
    $proj_id = $_POST['proj_id'];
     $proj_name = sanitize($_POST['proj_name']);
    $proj_shname = sanitize($_POST['proj_shrtname']);
    $location = sanitize($_POST['proj_location']);
    $address = sanitize($_POST['proj_address']);
    $catagories = sanitize($_POST['segment']);
     $project_type = sanitize($_POST['proj_type']);
    $sdate = formatDate(str_replace('/', '-', $_POST['start_date']), 'Y-m-d');
    $edate = formatDate(str_replace('/', '-', $_POST['end_date']), 'Y-m-d');
    $redate = formatDate(str_replace('/', '-', $_POST['revend_date']), 'Y-m-d');

    $client_loi = formatDate(str_replace('/', '-', $client_loi), 'Y-m-d h:i:s');
    $cont_agree = formatDate(str_replace('/', '-', $cont_agree), 'Y-m-d h:i:s');
    $kick_meet = formatDate(str_replace('/', '-', $kick_meet), 'Y-m-d h:i:s');
    $tech_comer = formatDate(str_replace('/', '-', $tech_comer), 'Y-m-d h:i:s');
    $tech_cost = formatDate(str_replace('/', '-', $tech_cost), 'Y-m-d h:i:s');
    $ace_sub = formatDate(str_replace('/', '-', $ace_sub), 'Y-m-d h:i:s');
    $ace_sheet = formatDate(str_replace('/', '-', $ace_sheet), 'Y-m-d h:i:s');
    
//        $sdate = $_POST['start_date'];
//        $edate = $_POST['end_date'];
//        $redate = $_POST['revend_date'];

    $h_o_remarks = $_POST['h_o_remarks'];
    $data = array(
        'proj_id' => $proj_id,
        'proj_name' => $proj_name,
        'proj_shname' => $proj_shname,
        'location' => $location,
        'address' => $address,
        'catagories' => $catagories,
        'sdate' => $sdate,
        'edate' => $edate,
        'redate' => $redate,
        'h_o_remarks' => $h_o_remarks,
        'client_loi' => $client_loi,
        'cont_agree' => $cont_agree,
        'kick_meet' => $kick_meet,
        'tech_comer' => $tech_comer,
        'tech_cost' => $tech_cost,
        'ace_sub' => $ace_sub,
        'ace_sheet' => $ace_sheet,
        'proj_type' => $project_type,
    );
   // print_r($data);exit;
    $result = $super_admin->update_project($data);

    //header('Location: ../sadmin/project_master.php');
    if($pname=='opspname'){
           echo "<script>window.location.href='../files_from_contract';</script>";
    }else{
           echo "<script>window.location.href='../project_master.php';</script>";
    }
 
} elseif (isset($_GET['del_proj_id'])) {
    $proj_id = $_GET['del_proj_id'];
    $sql = "delete from Project where proj_id='" . $proj_id . "'";
    $query = mssql_query($sql);
    echo "<script>window.location.href='../project_master.php';</script>";
} elseif (isset($_POST['stage_create'])) {
    //echo "hi";
    $stagename = sanitize($_POST['stage_new']);
    $shortname = sanitize($_POST['short_new']);
    $weightage = sanitize($_POST['weightage_new']);
    $usertype  = sanitize($_POST['user_type']);
    $senduserlist =sanitize($_POST['send_usertype']);
   // $attach_flag = $_POST['attach_flag'];
    $checked = implode(',', $_POST['send_usertype']); 
    //echo $checked;
    if (isset($_POST['attach_flag'])) {
        $attach_flag =1;
    } else {
        $attach_flag =0;
    }
    // for ($i = 0; $i < count($usertype); $i++) {
    //     $sentusers= $usertype[$i];
    // }
    $data = array(
        'stage_name' => $stagename,
        'shot_name' => $shortname,
        'weightage' => $weightage,
        'usertype' => $usertype,
        'sendback' => $checked,
        'file_attach' => $attach_flag,
    );
    
    $result = $super_admin->create_stage($data);
  
    //header('Location: ../sadmin/project_master.php');
    echo "<script>window.location.href='../stage_master';</script>";
}  else if(isset($_POST['stage_update'])){
    $stage_name = sanitize($_POST['stage_name']);
    $short_name = sanitize($_POST['short_name']);
    $weightage = sanitize($_POST['weightage']);
    $stage_id = sanitize($_POST['stage_id']);
    $usertype = sanitize($_POST['user_type_edit']);
    $checked = !empty($_POST['send_usertype_edit']) ? implode(',', $_POST['send_usertype_edit']) : ''; 
    if (isset($_POST['attach_flag_edit'])) {
        $attach_flag =1;
    } else {
        $attach_flag =0;
    }
    if($stage_id!= ""){
        $sql = "UPDATE swift_stage_master SET stage_name='".$stage_name."',shot_name='".$short_name."',weightage='".$weightage."',usertype='".$usertype."',file_attach='".$attach_flag."',sendback='".$checked."'  WHERE stage_id='".$stage_id."'";
        $query = mssql_query($sql);
        if($query){
            echo "<script>window.location.href='../stage_master';</script>";
        }else{
            echo "<script>window.location.href='../stage_master';</script>";
        }
    }else{
        echo "<script>window.location.href='../stage_master';</script>";
    }
}
}
