<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];

$result = $cls_comm->get_rpa_data($pack_id);
$res = json_decode($result, true);

foreach ($res as $key => $value) {
    $planned_date = date('d-M-Y', strtotime($value['planned_date']));
    $mat_req_date = date('d-M-Y', strtotime($value['pm_revised_material_req']));
    $expected_date = date('d-M-Y', strtotime($value['ps_expdate']));
    $proj_name = $value['proj_name'];
    $pm_packagename = $value['pm_packagename'];
    $po_num = $value['po_number'];
    $wo_num = $value['wo_number'];
}
echo json_encode(array(
    'planned_date1' => $planned_date,
    //    'mat_req_date' => $mat_req_date,
    'mat_req_date1' => $expected_date,
    'proj_name1' => $proj_name,
    'packagename1' => $pm_packagename,
    'po_num' => $po_num,
    'wo_num' => $wo_num,
));
?>