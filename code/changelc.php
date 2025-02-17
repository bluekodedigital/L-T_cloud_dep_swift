<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$lc_id = $_POST['key'];

$result = $cls_lc->changelc($lc_id);
//$result = $cls_comm->changelc($lc_id);
$res = json_decode($result, true);

 $getPoVal = $cls_lc->getPoVal($lc_id);
$poval = $getPoVal['poVal'];

foreach ($res as $key => $value) {
    $lcm_venid = $value['lcm_venid'];
    $lcm_num = $value['lcm_num'];
    $lcm_value = $value['lcm_value'];
    $balance = $value['lcm_balance'];
    $lcm_date = formatDate($value['lcm_date'], 'd-M-Y');
    $lcm_from = formatDate($value['lcm_from'], 'd-M-Y');
    $lcm_to = formatDate($value['lcm_to'], 'd-M-Y');
    $lcm_cpid = 0;
    $lcm_appname = $value['lcm_appname'];
    $lcm_appbank = $value['lcm_appbank'];
    $lcm_venbank = $value['lcm_venbank'];
    $lcm_venbankaddress = $value['lcm_venbankaddress'];
    $lcm_currency = $value['lcm_currency'];
    $lcm_forex = $value['lcm_forex'];
    $lcm_valueinr = $value['lcm_valueinr'];
    $lcm_incoterms = $value['lcm_incoterms'];
    $lcm_country = $value['lcm_country'];
}

echo json_encode(array(
    'lcm_venid' => $lcm_venid,
    'lcm_num' => $lcm_num,
    'lcm_value' => $lcm_value,
    'lcm_balance' => $lcm_balance,
    'lcm_date' => $lcm_date,
    'lcm_from' => $lcm_from,
    'lcm_to' => $lcm_to,
    'lcm_cpid' => $lcm_cpid,
    'lcm_appname' => $lcm_appname,
    'lcm_appbank' => $lcm_appbank,
    'lcm_venbank' => $lcm_venbank,
    'lcm_venbankaddress' => $lcm_venbankaddress,
    'lcm_currency' => $lcm_currency,
    'lcm_forex' => $lcm_forex,
    'lcm_valueinr' => $lcm_valueinr,
    'lcm_incoterms' => $lcm_incoterms,
    'lcm_country' => $lcm_country,
    'poval' => $poval
));
?>
 


