<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$proj_id = $_POST['key'];
$seg = $_POST['seg'];
if ($proj_id == "") {
    $sql = "select pm_packagename as package,
(select sum (weightage) from swift_stage_master where stage_id < ps_stageid ) as complete,
(select sum (weightage) from swift_stage_master where stage_id >=  ps_stageid ) as incomplete
from swift_packagestatus ,swift_stage_master,Project,swift_packagemaster 
where  stage_id=ps_stageid and   active=1   and ps_projid=proj_id  and  pm_packid=ps_packid $seg";
} else {
    $sql = "select pm_packagename as package,
(select sum (weightage) from swift_stage_master where stage_id < ps_stageid ) as complete,
(select sum (weightage) from swift_stage_master where stage_id >=  ps_stageid ) as incomplete
from swift_packagestatus ,swift_stage_master,swift_packagemaster  
where  stage_id=ps_stageid and ps_projid='" . $proj_id . "' and  pm_packid=ps_packid  and  active=1";
}

$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);

if ($num_rows > 0) {


    $result = array();
    while ($row = mssql_fetch_assoc($query)) {
        $result[] = $row;
    }
    $res = json_encode($result);
    echo $res;


     
}
?>