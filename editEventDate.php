<?php

// Connexion à la base de données
include 'config/inc.php';

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])) {


    $id = $_POST['Event'][0];
    $start = $_POST['Event'][1];
    $end = $_POST['Event'][2];

    $sql = "UPDATE events SET  start = '$start', _end = '$end' WHERE id = $id ";
    $query = mssql_query($sql);
    if ($query) {
        echo 'OK';
    }
}
// header('Location: '.$_SERVER['HTTP_REFERER']);
?>
