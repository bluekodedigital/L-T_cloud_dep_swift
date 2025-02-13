<?php

// Connexion à la base de données
include 'config/inc.php';
//echo $_POST['title'];
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])){
	
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];

	$sql = "INSERT INTO events(title, start, _end, color) values ('$title', '$start', '$end', '$color')";
	//$req = $bdd->prepare($sql);
	//$req->execute();
	$query = mssql_query($sql);
        if($query){
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
           echo  $sql;
        }
	
////	$query = $bdd->prepare( $sql );
//	if ($query == true) {
////	 print_r($bdd->errorInfo());
//	echo 'Erreur execute';
//	}
// 	$sth = $query;
//	if ($sth == false) {
////	 print_r($query->errorInfo());
//	 die ('Erreur execute');
//	}

}


	
?>
