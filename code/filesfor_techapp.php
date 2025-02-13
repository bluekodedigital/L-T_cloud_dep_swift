<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$flag=$_POST['flag'];

$result = $cls_user->files_fortechapp_ajax($pack_id,$flag);
$res = json_decode($result, true);
//print_r($result);

foreach ($res as $key => $value) {
    $proj_name = $value['proj_name'];
    $pack_name = $value['pm_packagename'];
    $proj_id=$value['tech_projid'];
    $planned = date('d-M-Y', strtotime($value['planned']));
    
     if ($value['expected'] == "") {
        $exp_date = date('Y-m-d');
    } else {
        $exp_date = $value['expected'];
    }
        $expected = date('d-M-Y', strtotime($exp_date));
//    $expected = date('d-M-Y', strtotime($value['expected']));
    $actual = date('d-M-Y', strtotime($value['actual']));
    $pm_material_req = date('d-M-Y', strtotime($value['pm_revised_material_req']));
}
echo json_encode(array(
    'proj_name' => $proj_name,
    'pack_name' => $pack_name,
    'planned' => $planned,
    'actual' => $actual,
    'expected'=>$expected,
//    'pm_material_req'=>$pm_material_req,
    'pm_material_req'=>$expected,
    'proj_id'=>$proj_id     
    ));
?>
 


