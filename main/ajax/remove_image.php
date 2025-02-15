<?php
require_once("../dbcon.php");
$id=$_POST['key']; 
$sql="delete from banner_img  where img_id='".$id."'";
$query= mssql_query($sql);
if ($query) {
    echo 1;
}else{
    echo 0;
}
?>