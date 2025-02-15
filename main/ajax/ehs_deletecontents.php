<?php

require_once("../dbcon.php");
$id=$_POST['id'];
$sql="delete from ehs_alert_docs where ehs_docid='".$id."'";
$query= mssql_query($sql);
if ($query) {
    echo 'success';
}else{
    echo 'error';
}
?>