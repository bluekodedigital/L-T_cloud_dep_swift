<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];

$loi_result1 = $cls_report->loi_detail1($pack_id);
$res1 = json_decode($loi_result1, true);
$loi_number = "";
$so_loi_date = "";
$loi_remarks = "";
foreach ($res1 as $key => $value1) {
    $loi_number = $value1['loi_number'];
    $so_loi_date = formatDate($value1['loi_date'], 'd-M-Y');
    $loi_remarks = $value1['to_remark'];
    if ($value1['po_wo_status'] == 1) {
        $po_wo = 'PO';
    } else if ($value1['po_wo_status']== 2) {
        $po_wo = 'WO';
    } else {
        $po_wo = 'PO+WO';
    }
    $proj_name = $value1['proj_name'];
    $pack_name = $value1['pm_packagename'];
    $proj_id = $value1['pm_projid'];
    $planned = formatDate($value1['planned'], 'd-M-Y');
//    $expected = formatDate($value['expected'], 'd-M-Y');

    if ($value1['ps_expdate'] == "") {
        $exp_date = date('Y-m-d');
    } else {
        $exp_date = $value1['ps_expdate'];
    }
    $expected = formatDate($exp_date, 'd-M-Y');
//    $expected = formatDate($value['ps_expdate'], 'd-M-Y');
    $actual = formatDate($value1['actual'], 'd-M-Y');
    $pm_material_req = formatDate($value1['pm_revised_material_req'], 'd-M-Y');
}



echo json_encode(array(
    'proj_name' => sanitize_decode($proj_name),
    'pack_name' => sanitize_decode($pack_name),
    'planned' => $planned,
    'actual' => $actual,
    'expected' => $expected,
    // 'pm_material_req'=>$pm_material_req,
    'pm_material_req' => $expected,
    'proj_id' => $proj_id,
    'loi_number' => sanitize_decode($loi_number),
    'so_loi_date' => $so_loi_date,
    'loi_remarks' => sanitize_decode($loi_remarks),
    'po_wo_app' => $po_wo,
        // 'loi_filename'=>$loi_filename,
        // 'loi_filepath'=>$loi_filepath
));
