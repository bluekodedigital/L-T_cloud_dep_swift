<?php

// include_once ("../config/inc_function.php");
// if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// $pack_id = mssql_escape($_POST['pack_id']);
// $stageid = mssql_escape($_POST['stageid']);
// $projectid = mssql_escape($_POST['projectid']);

// $result = $cls_comm->getusername_stage($pack_id, $stageid, $projectid);
// $result2 = $cls_comm->getusername_backstage($pack_id, $stageid, $projectid);

// //$res = json_encode($result, true);
// $res2 = json_encode($result2, true);

// echo $uid = $res2[0]['uid'];
// $uname = $res2[0]['name'];
// echo json_encode(array(
//     'uid' => $uid,
//     'userlist' => $result
// ));
// die;



include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = mssql_escape($_POST['pack_id']);
$stageid = mssql_escape($_POST['stageid']);
$projectid = mssql_escape($_POST['projectid']);

$result2  = $cls_comm->getusername_stage($pack_id, $stageid, $projectid);
$result1  = $cls_comm->getusername_backstage($pack_id, $stageid, $projectid);
$res = json_decode($result1, true);
$uid = $res[0]['uid'];
$uname = $res[0]['name'];
echo json_encode(array(
    'uid' => $uid,
    'userlist' => $result2

));
?>
