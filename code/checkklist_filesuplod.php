<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$doc_name = $_REQUEST['doc_name'];
$projid = $_REQUEST['projid'];
$uid = $_SESSION['uid'];
$clk_id = $_REQUEST['id'];
$complete = $_REQUEST['complete'];
$date = date('Y-m-d', strtotime($_REQUEST['date']));

$isql = mssql_query("select isnull (max(cd_id+1),1) as id from  swift_checklist_docs");
$row = mssql_fetch_array($isql);
$id = $row['id'];

$rand = $id . '_' . $projid;

$ext = substr(strrchr($_FILES['file']['name'], "."), 1);
if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}else if($ext == 'msg'){
    echo '.msg format not supported';
} else {
    $name = $rand . $_FILES['file']['name'];
    $name1 = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/checklists/' . $name);
    $check = mssql_query("select * from swift_checklist_docs  where clk_id='" . $clk_id . "' and ck_projid='" . $projid . "' and cd_uid ='" . $uid . "' ");
    $num_rows = mssql_num_rows($check);
    if($num_rows>0) {
        $sql="update swift_checklist_docs set cd_date='".$date."' ,cd_attah='".$name."',cd_status='0' where clk_id='" . $clk_id . "' and ck_projid='" . $projid . "' and cd_uid ='" . $uid . "' ";
        $query = mssql_query($sql);
    } else {
        $sql = "insert into swift_checklist_docs(cd_id,clk_id,ck_projid,cd_uid,cd_completed,cd_date,cd_attah,cd_status) "
                . "values('" . $id . "','" . $clk_id . "','" . $projid . "','" . $uid . "','" . $complete . "','" . $date . "','" . $name . "','0')";
        $query = mssql_query($sql);
    }

    if ($query) {
        echo 'success';
    }
}
?>