<?php

$output_dir = "../uploads/op_exp/";
if (isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name'])) {
    $fileName = trim($_POST['name']);
    $fileName = str_replace("..", ".", $fileName); //required. if somebody is trying parent folder files	
    echo $filePath = $output_dir . $fileName;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    echo "Deleted File " . $fileName . "<br>";
}


?>
