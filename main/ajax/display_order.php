<?php
require_once("../dbcon.php");
$id=$_POST['key'];
$order=trim($_POST['order']);
$active=$_POST['active'];
$check="select * from banner_img where dis_order='".$order."' and img_id !='".$id."' ";
$qry=mssql_query($check);
$num_rows= mssql_num_rows($qry);
if($num_rows>0){
    echo 2;
}else{
    $sql = "update banner_img set dis_order='" . $order . "',active='" . $active . "' where img_id='" . $id . "'";
    $query = mssql_query($sql);
    if ($query) {
        echo 1;
    } else {
        echo 0;
    }
}

?>