<?php

require_once('bdd.php');
if (isset($_POST['delete']) && isset($_POST['id'])) {


    $id = $_POST['id'];

    $sql = "DELETE FROM events WHERE id = $id";
    $query = mssql_query($sql);
} elseif (isset($_POST['title']) && isset($_POST['color']) && isset($_POST['id'])) {

    $id = $_POST['id'];
    $title = $_POST['title'];
    $color = $_POST['color'];

    $sql = "UPDATE events SET  title = '$title', color = '$color' WHERE id = $id ";
    $query = mssql_query($sql);
}
header('Location: admin');
?>
