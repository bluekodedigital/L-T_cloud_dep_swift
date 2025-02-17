<?php

require_once("../dbcon.php");

$doc_name = $_POST['input'];
$fildate = $_POST['doc_date'];
$date = formatDate($fildate, 'Y-m-d');
$rand = rand(100, 1000000);

if (0 < $_FILES['file']['error']) {
    echo 'Error: ' . $_FILES['file']['error'] . '<br>';
} else {
    $name = $rand . $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], '../ehs_pdf/' . $name);
    $sql = "insert into ehs_alert_docs(doc_name,created_date,ehs_file_name) "
            . "values('" . $doc_name . "','" . $date . "','" . $name . "')";
    $query = mssql_query($sql);
    if ($query) {
        echo 'success';
    }else{
        echo 'error';
    }
}
?>