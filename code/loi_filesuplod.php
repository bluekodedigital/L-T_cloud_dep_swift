<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$doc_name = $_REQUEST['doc_name'];
$pack_id = $_REQUEST['pack_id'];
$projid = $_REQUEST['projid'];
$uid=$_SESSION['uid'];

$isql = mssql_query("select isnull (max(loi_upid+1),1) as id from  swift_loi_uploads");
$row = mssql_fetch_array($isql);
$id = $row['id'];

$rand = $id.'_'.$pack_id . '_' . $projid;

$ext = substr(strrchr($_FILES['file']['name'], "."), 1);
if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}else if($ext == 'msg'){
    echo '.msg format not supported';
} else {
    $name = $rand . $_FILES['file']['name'];
    $name1=$_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/loi/' . $name);
    $sql = "insert into swift_loi_uploads(loi_upid,loi_up_projid,loi_up_packid,loi_up_uid,loi_update,loi_filename,loi_filepath,loi_upactive) "
            . "values('" . $id . "','" . $projid . "','" . $pack_id . "','".$uid."',GETDATE(),'" . $doc_name . "','" . $name1 . "','1')";
    $query = mssql_query($sql);
    if ($query) {
        echo 'success';
    }
}
?>