<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];

$result = $cls_comm->get_lc_data($pack_id);
$res = json_decode($result, true);

foreach ($res as $key => $value) {
    $planned_date = formatDate($value['planned_date'], 'd-M-Y');
    $mat_req_date = formatDate($value['pm_revised_material_req'], 'd-M-Y');
    $expected_date = formatDate($value['ps_expdate'], 'd-M-Y');
    $proj_name = $value['proj_name'];
    $pm_packagename = $value['pm_packagename'];
    $po_num = $value['po_number'];
    $wo_num = $value['wo_number'];
}
echo json_encode(array(
    'planned_date' => $planned_date,
//    'mat_req_date' => $mat_req_date,
    'mat_req_date' => $expected_date,
    'proj_name' => $proj_name,
    'packagename' => $pm_packagename,
    'po_num' => $po_num,
    'wo_num' => $wo_num,
));
?>