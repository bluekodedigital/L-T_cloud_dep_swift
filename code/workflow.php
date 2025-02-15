<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$mst_id = $_REQUEST['key'];
$sql = "select * from   swift_workflow_Master where Id='" . $mst_id . "' and active=1";
$sql2 = "select a. did,a.target_day,a.stage_id,b.stage_name from  swift_workflow_details as a 
inner join swift_stage_master as b on a.stage_id=b.stage_id where  mst_id='" . $mst_id . "' and active=1 order by Did";
$query = mssql_query($sql);
$query2 = mssql_query($sql2);
$daysDetails = $query2;
$result = array();
while ($row2 = mssql_fetch_array($query2)) {
    $target_day = $row2['target_day'];
    $stage_id = $row2['stage_id'];
    $stage_name = $row2['stage_name'];
    $Did = $row2['Did'];
    $result[] = array(
        "days" => $target_day,
        "stage_id" => $stage_id,
        "did" => $Did,
        "stage_name"=>$stage_name

    );
    // $result = array();

}
// Sort the result array by 'did'
// usort($result, function ($a, $b) {
//     return $a['did'] > $b['did'] ? 1 : -1;
// });
//print_r($result);
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
    $row = mssql_fetch_array($query);
    $workflowname = $row['workflow_Master'];
    $active = $row['active'];
    // $master = $row['workflow_Master'];
    echo json_encode(
        array(
            'name' => sanitize_decode($workflowname),
            'active' => $active,
            'days' => $result,
        )
    );
}
?>