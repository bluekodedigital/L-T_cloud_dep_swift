<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];

$result = $cls_comm->ps_planget($pack_id, 11);
$res = json_decode($result, true);
foreach ($res as $key => $value) {
    $ps_plandate = formatDate($value['planned_date'], 'd-M-Y');
}

$result = $cls_comm->ps_planget($pack_id, 12);
$res = json_decode($result, true);
foreach ($res as $key => $value) {
    $pa_plandate = formatDate($value['planned_date'], 'd-M-Y');
}

$result = $cls_comm->ps_planget($pack_id, 13);
$res = json_decode($result, true);

foreach ($res as $key => $value) {
    $loi_plandate = formatDate($value['planned_date'], 'd-M-Y');
    $pack_name = $value['pm_packagename'];
    $mat_req = formatDate($value['mat_req'], 'd-M-Y');
}
$loi_number = "";
$result = $cls_report->get_ss_actdate($pack_id);
$res = json_decode($result, true);
foreach ($res as $key => $value) {
    $ps_actdate = formatDate($value['so_package_sentdate'], 'd-M-Y');
    $pa_actdate = formatDate($value['so_package_approved_date'], 'd-M-Y');
    $loi_number = $value['loi_number'];

    // if ($value['so_hw_sw'] == 1) {
    //     $po_wo = 'WO';
    // } else if ($value['so_hw_sw'] == 2) {
    //     $po_wo = 'PO';
    // } else {
    //     $po_wo = 'PO+WO';
    // }
    // if ($value['so_loi_date'] == '') {
    //     $loi_actdate = "-";
    // } else {
    //     $loi_actdate = formatDate($value['so_loi_date'], 'd-M-Y');
    // }
}
$loi_result1 = $cls_report->loi_detail1($pack_id);
$res1 = json_decode($loi_result1, true);

foreach ($res1 as $key => $value1) {
    $loi_number = $value1['loi_number'];
    $loi_actdate = formatDate($value1['loi_date'], 'd-M-Y');
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
    'ps_plandate' => $ps_plandate,
    'pa_plandate' => $pa_plandate,
    'loi_plandate' => $loi_plandate,
    'ps_actdate' => $ps_actdate,
    'pa_actdate' => $pa_actdate,
    'loi_actdate' => $loi_actdate,
    'pack_name' => sanitize_decode($pack_name),
    'mat_req' => $mat_req,
    'loi_number' => sanitize_decode($loi_number),
    'loi_remarks' => sanitize_decode($loi_remarks),
    'po_wo_app' => $po_wo,
));
?>