<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rpa_id = $_POST['key'];

$result = $cls_comm->changerpa($rpa_id);
$res = json_decode($result, true);

foreach ($res as $key => $value) {
    $lcm_venid = $value['rpa_venid'];
    $lcm_num = $value['rpa_num'];   
    $lcm_date = formatDate($value['rpa_date'], 'd-M-Y');
    $lcm_from= formatDate($value['rpa_from'], 'd-M-Y');
    $lcm_to = formatDate($value['rpa_to'], 'd-M-Y');
    $rpa_bank=$value['rpa_bank'];  
 
}

echo json_encode(array(
    'lcm_venid' => $lcm_venid,
    'lcm_num' => $lcm_num,    
    'lcm_date' => $lcm_date,
    'lcm_from' => $lcm_from,
    'lcm_to' => $lcm_to,
    'rpa_bank'=>$rpa_bank
));
?>
 


