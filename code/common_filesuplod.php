<?php

include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$doc_name = $_REQUEST['doc_name'];
$stageid  = $_REQUEST['stage'];
$pack_id  = $_REQUEST['pack_id'];
$projid   = $_REQUEST['projid'];
$uid      = $_SESSION['uid'];
$attach_flag  = $_REQUEST['key'];

$isql = mssql_query("select isnull (max(upid+1),1) as id from  swift_comman_uploads");
$row = mssql_fetch_array($isql);
$id = $row['id'];

//check revisions 
$ck_sql = mssql_query("select * from swift_comman_uploads where up_packid='" . $pack_id . "' and up_projid ='" . $projid . "'");
$ck_numrows = mssql_num_rows($ck_sql);
$exp_rev = 'rev 0.' . $ck_numrows;


$rand = $id . '_' . $pack_id . '_' . $projid;

$ext = substr(strrchr($_FILES['file']['name'], "."), 1);
if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
} else if ($ext == 'msg') {
    echo '.msg format not supported';
} else {
    $name = $rand .'_'. $_FILES['file']['name'];
    //echo $stageid;
    $name1 = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/document/' . $name);
     $sql = "insert into swift_comman_uploads(upid,up_projid,up_packid,up_uid,up_update,up_filename,up_filepath,upactive,rev,up_stage,key_flag) "
        . "values('" . $id . "','" . $projid . "','" . $pack_id . "','" . $uid . "',GETDATE(),'" . $doc_name . "','" . $name . "','1','" . $exp_rev . "','" . $stageid . "','" . $attach_flag . "')";
    $query = mssql_query($sql);
    if ($query) {
        echo 'success';
    }
}
