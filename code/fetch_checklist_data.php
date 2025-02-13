<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id = $_REQUEST['key'];
$projid = $_REQUEST['proj_id'];
$uid = $_SESSION['uid'];

$sql = "select * from swift_checklist_docs where clk_id='" . $id . "' and ck_projid='" . $projid . "' and cd_uid ='" . $uid . "'";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
// echo $sql; 
if ($num_rows > 0) {

    while ($row = mssql_fetch_array($query)) {
        $complete=$row['complete'];
        ?>
       <?php
    }
    echo $complete;
    
} else {
    ?>


<?php }
?>