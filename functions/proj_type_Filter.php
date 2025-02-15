<?php

include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$proj_type = mssql_escape($_POST['key']);
$segment = $_SESSION['swift_dep'];
//$segment = $_SESSION['tech_dep'];
$depid = $_SESSION['deptid'];
$usertype = $_SESSION['usertype'];
$uid = $_SESSION['uid'];
// if ($depid == 33) {
//     $segment = 'and cat_id=33';
//     $segment1 = 'cat_id=33';
// } else if ($depid == 35) {
//     $segment = 'and cat_id=35';
//     $segment1 = 'cat_id=35';
// } else if ($depid == 36) {
//     $segment = 'and cat_id=36';
//     $segment1 = 'cat_id=36';
// } else if ($depid == 37) {
//     $segment = 'and cat_id=37';
//     $segment1 = 'cat_id=37';
// } else if ($depid == 38) {
//     $segment = 'and cat_id=38';
//     $segment1 = 'cat_id=38';
// } else {
//     if ($usertype == '6') {
//         $result = $cls_report->select_user1($uid);
//         $prosps_id = $result['proj_ids'];
//         $segment = ' and proj_id in(' . $prosps_id . ')';
//         $segment1 = 'proj_id in(' . $prosps_id . ')';
//     } else {
//         $segment = '';
//         $segment1 = '';
//     }
// }

if($_SESSION['milcom']!='1')
{
    if($usertype!=0){
        $seg = $segment ;
    }else{
        $seg='';
    }
}else{
    $seg = 38 ;
}


echo $proj_type;
$result = $cls_report->select_filterprojects_seg2( $seg,  $proj_type);

echo json_encode(
    array(
        'projectlist' => $result,
    )
);
?>