<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];

$result = $cls_comm->sendtospocdata($pack_id);
$res = json_decode($result, true);

foreach ($res as $key => $value) {
    $proj_name = $value['proj_name'];
    $pack_name = $value['pm_packagename'];
    $proj_id = $value['proj_id'];
    $planned = date('d-M-Y', strtotime($value['planned']));
//    $expected = date('d-M-Y', strtotime($value['expected']));
    if ($value['ps_expdate'] == "" || $value['ps_expdate'] ==NULL) {
        $exp_date = date('Y-m-d');
    } else {
        $exp_date = $value['ps_expdate'];
    }
    $expected = date('d-M-Y', strtotime($exp_date));
    $actual = date('d-M-Y', strtotime($value['actual']));
    $pm_material_req = date('d-M-Y', strtotime($value['ps_expdate']));
//     $pm_material_req = date('d-M-Y', strtotime($value['pm_revised_material_req']));
}
echo json_encode(array(
    'proj_name' => $proj_name,
    'pack_name' => $pack_name,
    'planned' => $planned,
    'actual' => $actual,
    'expected' => $expected,
    'pm_material_req' => $pm_material_req,
    'proj_id' => $proj_id
));
?>
 


