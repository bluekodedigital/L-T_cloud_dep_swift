<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$doc_name = $_REQUEST['doc_name'];
$pack_id = $_REQUEST['pack_id'];
$projid = $_REQUEST['projid'];
$uid=$_SESSION['uid'];

$isql = mssql_query("select isnull (max(exp_upid+1),1) as id from  swift_expert_uploads");
$row = mssql_fetch_array($isql);
$id = $row['id'];

//check revisions 
$ck_sql= mssql_query("select * from swift_expert_uploads where exp_up_packid='".$pack_id."' and exp_up_projid ='".$projid."'");
$ck_numrows = mssql_num_rows($ck_sql);
$exp_rev= 'rev 0.'.$ck_numrows;


$rand = $id.'_'.$pack_id . '_' . $projid;
$ext = substr(strrchr($_FILES['file']['name'], "."), 1);
if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}else if($ext == 'msg'){
    echo '.msg format not supported';
} else {
    $name = $rand . $_FILES['file']['name'];
    $name1=$_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], '../uploads/op_exp/' . $name);
    $sql = "insert into swift_expert_uploads(exp_upid,exp_up_projid,exp_up_packid,exp_up_uid,exp_update,exp_filename,exp_filepath,exp_upactive,exp_rev) "
            . "values('" . $id . "','" . $projid . "','" . $pack_id . "','".$uid."',GETDATE(),'" . $doc_name . "','" . $name . "','1','".$exp_rev."')";
    $query = mssql_query($sql);
    if ($query) { 
        echo 'success';

    }
}
?>