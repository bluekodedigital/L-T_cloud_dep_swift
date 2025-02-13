<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];

$result = $cls_comm->ps_planget($pack_id, 11);
$res = json_decode($result, true);
foreach ($res as $key => $value) {
    $ps_plandate = date('d-M-Y', strtotime($value['planned_date']));
}

$result = $cls_comm->ps_planget($pack_id, 12);
$res = json_decode($result, true);
foreach ($res as $key => $value) {
    $pa_plandate = date('d-M-Y', strtotime($value['planned_date']));
}

$result = $cls_comm->ps_planget($pack_id, 13);
$res = json_decode($result, true);

foreach ($res as $key => $value) {
    $loi_plandate = date('d-M-Y', strtotime($value['planned_date']));
    $pack_name = $value['pm_packagename'];
    $mat_req = date('d-M-Y', strtotime($value['mat_req']));
}
$loi_number = "";
$result = $cls_report->get_ss_actdate($pack_id);
$res = json_decode($result, true);
foreach ($res as $key => $value) {
    $ps_actdate = date('d-M-Y', strtotime($value['so_package_sentdate']));
    $pa_actdate = date('d-M-Y', strtotime($value['so_package_approved_date']));
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
    //     $loi_actdate = date('d-M-Y', strtotime($value['so_loi_date']));
    // }
}
$loi_result1 = $cls_report->loi_detail1($pack_id);
$res1 = json_decode($loi_result1, true);

foreach ($res1 as $key => $value1) {
    $loi_number = $value1['loi_number'];
    $loi_actdate = date('d-M-Y', strtotime($value1['loi_date']));
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
    $planned = date('d-M-Y', strtotime($value1['planned']));
//    $expected = date('d-M-Y', strtotime($value['expected']));

    if ($value1['ps_expdate'] == "") {
        $exp_date = date('Y-m-d');
    } else {
        $exp_date = $value1['ps_expdate'];
    }
    $expected = date('d-M-Y', strtotime($exp_date));
//    $expected = date('d-M-Y', strtotime($value['ps_expdate']));
    $actual = date('d-M-Y', strtotime($value1['actual']));
    $pm_material_req = date('d-M-Y', strtotime($value1['pm_revised_material_req']));
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