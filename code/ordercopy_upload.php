<?php

include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$doc_name = sanitize($_REQUEST['doc_name']);
$mdid  = $_REQUEST['mdid'];
$sendback  = $_REQUEST['sendback'];
$pack_id  = $_REQUEST['pack_id'];
$projid   = $_REQUEST['projid'];
$uid      = $_SESSION['uid'];


$isql = mssql_query("select isnull (max(df_id+1),1) as id from  swift_distributor_files");
$row = mssql_fetch_array($isql);
$id = $row['id'];

//check revisions 
$ck_sql = mssql_query("select * from swift_distributor_files where df_packid='" . $pack_id . "' and df_projid ='" . $projid . "'");
$ck_numrows = mssql_num_rows($ck_sql);
$exp_rev = 'rev 0.' . $ck_numrows;


$rand = $id . '_' . $pack_id . '_' . $projid;

$ext = substr(strrchr($_FILES['file']['name'], "."), 1);
if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
} else if ($ext == 'msg') {
    echo '.msg format not supported';
} else {
    $name = $rand . $_FILES['file']['name'];
    //echo $stageid;
    $name1 = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/order_document/' . $name);
    $sql = "insert into swift_distributor_files(df_id,df_projid,df_packid,df_uid,df_update,df_filename,df_filepath,df_active,df_mail_disid,send_back) "
        . "values('" . $id . "','" . $projid . "','" . $pack_id . "','" . $mdid . "',GETDATE(),'" . $doc_name . "','" . $name . "','1','" . $mdid . "','" . $sendback . "' )";
    $query = mssql_query($sql);
    if ($query) {
        echo 'success';
    }
}
