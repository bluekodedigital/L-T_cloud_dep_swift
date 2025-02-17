<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];

$result = $cls_comm->sendtoexpertdata($pack_id);
$res = json_decode($result, true);
foreach ($res as $key => $value) {
    $proj_name = $value['proj_name'];
    $pack_name = $value['pm_packagename'];
    $proj_id=$value['proj_id'];
    $planned = formatDate($value['planned'], 'd-M-Y');
    $expected = formatDate($value['expected'], 'd-M-Y');
    $actual = formatDate($value['actual'], 'd-M-Y');
    $pm_material_req = formatDate($value['pm_material_req'], 'd-M-Y');
}

echo json_encode(array(
    'proj_name' => $proj_name,
    'pack_name' => $pack_name,
    'planned' => $planned,
    'actual' => $actual,
    'expected'=>$expected,
    'pm_material_req'=>$pm_material_req,
    'proj_id'=>$proj_id     
    ));
?>
 


