<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$proj_id = $_POST['key'];
$seg = $_POST['seg'];
if ($proj_id == "") {
    $sql = "select ps_packid,
(select sum (weightage) from swift_stage_master where stage_id < ps_stageid ) as completed,
(select sum (weightage) from swift_stage_master where stage_id >=  ps_stageid ) as incompleted
from swift_packagestatus ,swift_stage_master,Project 
where  stage_id=ps_stageid and   active=1   and ps_projid=proj_id $seg";
} else {
    $sql = "select ps_packid,
(select sum (weightage) from swift_stage_master where stage_id < ps_stageid ) as completed,
(select sum (weightage) from swift_stage_master where stage_id >=  ps_stageid ) as incompleted
from swift_packagestatus ,swift_stage_master  
where  stage_id=ps_stageid and ps_projid='" . $proj_id . "' and  active=1";
}

$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
$incomplete = 0;
$complete = 0;
if ($num_rows > 0) {
    while ($row = mssql_fetch_array($query)) {
        $incomplete += $row['incompleted'];
        $complete += $row['completed'];
    }
    $incomplete = $incomplete / $num_rows;
    $complete = $complete / $num_rows;

    echo json_encode(array(
        'incomplete' => $incomplete,
        'complete' => $complete,
    ));
}
?>