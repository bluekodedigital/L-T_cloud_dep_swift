<?php

include_once("../config/inc_function.php");
session_start();
$pack_id = mssql_escape($_POST['key']);
$from = mssql_escape($_POST['from']);
$tostage = mssql_escape($_POST['to']);

if ($tostage == '') {

    $to = '0';
} else {
    $to = $tostage;
}
;
$result = $cls_comm->sendtoexpertdata($pack_id, $from, $to);
$result5 = $cls_user->swift_techDocMst();
//print_r($result);
$res = json_decode($result, true);
if ($_SESSION['milcom'] == '1') {
    $mil = "1";
} else {
    $mil = "";
}
foreach ($res as $key => $value) {
    $planned_date = formatDate($value['revised_planned_date'], 'd-M-Y');
    $mat_req_date = formatDate($value['pm_revised_material_req'], 'd-M-Y');
    $current_stage = $value['stage_name'];
    $next_stage = $value['next_stage'];
    $from_remark = $value['to_remark'];
    $file_attach = $value['file_attach'];
    // $usertype = "'" . $value['sendback'] . "'";
    $usertype = "'" . $value['usertype'] . "'";

    $sendback = $value['sendback'];

    $from_uid = $value['from_uid'];
    $values = explode(',', $sendback);
    $quotedValues = array();

    foreach ($values as $val) {
        $quotedValues[] = "'" . $val . "'";
    }

    $sendbackWithQuotes = implode(',', $quotedValues);
   // echo $sendbackWithQuotes;
    $result3 = $cls_comm->select_allstages($sendbackWithQuotes);
    $result2 = $cls_comm->select_user($usertype, $mil);

    $result4 = $cls_comm->select_smartsignoff_val($pack_id);

    //print_r($result2);
    //print_r($result4['hpc_app']);
    $remark = "<span id='less' data-toggle='tooltip' data-original-title='Remarks' style=' cursor: pointer;' ><span style='font-weight: bolder'> Remarks : </span>$from_remark</span> ";

    if ($value['ps_expdate'] == "") {
        $exp_date = date('Y-m-d');
    } else {
        $exp_date = $value['ps_expdate'];
        $exp_date = $value['ps_expdate'];
    }
    $exp_date = formatDate($exp_date, 'd-M-Y');


    $pm_packagename = $value['pm_packagename'];
}
echo json_encode(
    array(
        'planned_date' => $planned_date,
        //    'mat_req_date' => $mat_req_date,
        'mat_req_date' => $exp_date,
        'pm_packagename' => sanitize_decode($pm_packagename),
        'current_stage' => sanitize_decode($current_stage),
        'next_stage' => $next_stage,
        'file_attach' => $file_attach,
        'exp_date' => $exp_date,
        'remark' => sanitize_decode($remark),
        'userlist' => $result2,
        'stagelist' => $result3,
        'hpc_app' => $result4['hpc_app'],
        'sendback' => $sendback,
        'from_uid' => $from_uid,
        'doclist' => $result5,
    )
);
?>