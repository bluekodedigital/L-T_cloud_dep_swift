<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$pid = $_POST['proj_id'];

$sql = "select * from  swift_packagemaster where pm_packid='" . $pack_id . "' and pm_projid='" . $pid . "'";
$query = mssql_query($sql);

$sql2 = "select * from Project where proj_id='" . $pid . "'";
$qry = mssql_query($sql2);
$row2 = mssql_fetch_array($qry);
$proj_type = $row2['proj_type'];


$sql3 = "select * from swift_workflow_CurrentStage where cs_packid='" . $pack_id . "'";
$qry3 = mssql_query($sql3);
$row3 = mssql_fetch_array($qry3);
$uid = $row3['to_uid'];


while ($row = mssql_fetch_array($query)) {
    $pack_name = $row['pm_packagename'];
    $pack_category = $row['pm_catid'];
    $work_flow = $row['pm_wfid'];
    $org_date = formatDate($row['pm_material_req'], 'd-M-Y');
    $mt_req = formatDate($row['pm_revised_material_req'], 'd-M-Y');
    $lead_time = $row['pm_revised_lead_time'];
    $remarks = $row['pm_remarks'];
}
echo json_encode(array( 
    'pack_name' => sanitize_decode($pack_name),
    'pack_category' => $pack_category,
    'org_date' => $org_date,
    'mt_req' => $mt_req,
    'lead_time' => $lead_time,
    'remarks' => sanitize_decode($remarks),
    'proj_type' => $proj_type,
    'work_flow' => $work_flow,
    'uid' => $uid

    
));
?>
 


