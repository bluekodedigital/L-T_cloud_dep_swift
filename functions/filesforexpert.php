<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = mssql_escape($_POST['key']);
$result = $cls_comm->sendtoexpertdata($pack_id);
$res = json_decode($result, true);

foreach ($res as $key => $value) {
    $planned_date = formatDate($value['revised_planned_date'], 'd-M-Y');
    $mat_req_date = formatDate($value['pm_revised_material_req'], 'd-M-Y');
   
    if ($value['ps_expdate'] == "") {
        $exp_date = date('Y-m-d');
    } else {
        $exp_date = $value['ps_expdate'];
    }
    $exp_date = formatDate($exp_date, 'd-M-Y');
   
    
    $pm_packagename = $value['pm_packagename'];
}
echo json_encode(array(
    'planned_date' => $planned_date,
//    'mat_req_date' => $mat_req_date,
    'mat_req_date' => $exp_date,
    'pm_packagename' => $pm_packagename,
    'exp_date' => $exp_date
));
?>