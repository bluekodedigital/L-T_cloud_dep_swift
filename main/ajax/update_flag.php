<?php
require_once("../dbcon.php");
$id=$_POST['key'];
$status=$_POST['status'];
$sql="update banner_img set img_status='".$status."' where img_id='".$id."'";
$query= mssql_query($sql);
if ($query) {
    echo 1;
}else{
    echo 0;
}
?>