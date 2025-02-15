<?php
ob_start();
// error_reporting(1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("../config/inc_function.php");
$csrf_token = $_REQUEST['csrf_token'];
if (isset($_SESSION['token']) && $csrf_token === $_SESSION['token']) {

if (isset($_POST['submit'])) {

	$cat_name = sanitize($_POST['workflow_name']);
	// if (isset($_POST['active_flag'])) {
    //     $active_flag =1;
    // } else {
    //     $active_flag =0;
    // }
	$uid = $_SESSION['uid'];
	$view_query = "select * from swift_workflow_Master where workflow_Master='$cat_name' and active=1";
	$view_result = mssql_query($view_query);
	if (mssql_num_rows($view_result) > 1) {
		echo "<script>alert('already data is here')</script>";
	} else {
		
		$sql_query = "INSERT INTO swift_workflow_Master(workflow_Master,active,created_date,userid) VALUES('$cat_name',1,'" . date('Y-m-d h:i:s') . "','$uid')";
		$sql_result = mssql_query($sql_query);



		if (isset($_POST['stage'])) {
			//print_r($_POST['stage']);
			$sql_id = "SELECT * FROM swift_workflow_Master WHERE Id=(SELECT MAX(Id) FROM swift_workflow_Master)";
			$sql_result_id = mssql_query($sql_id);
			$row = mssql_fetch_array($sql_result_id);
			$mst_id = $row['Id'];


			$stage_id = array_values(array_filter($_POST['stage']));
			$details  = array_values(array_filter($_POST['details']));
			$checkbox1 = $_POST['check'];
			$checkcount = array();

			$checkcount = array_values(array_filter($_POST['check']));
			// print_r($stage_id);echo "<br>";
			// print_r($details);echo "<br>";
			// print_r($checkcount);echo "<br>";
			// die;
			// $chk="";  
			// foreach($checkbox1 as $chk1)  
			//    {  
			//     echo $chk1;
			//    } 
			//echo count($checkbox1);
			for ($i = 0; $i < count($checkcount); $i++) {

				$stage = $checkbox1[$i];
				$details1 = $details[$i];
				$sql_query_details = "INSERT INTO swift_workflow_Details(mst_id,stage_id,target_day,active,created_date,userid) 
				VALUES($mst_id,'" . $stage . "','" . $details1 . "',1,'".date('Y-m-d h:i:s')."','$uid')";

				$sql_query_details_result = mssql_query($sql_query_details);
				
				// if (!isset($_POST['check'][$i])) {
				// 	echo "Not selected!";echo "<br>";
				// } else {
				// 	echo $stage_id[$i];
				// 	echo "true!";echo "<br>";
				// 	$sql_query_details = "INSERT INTO swift_workflow_Details(mst_id,stage_id,target_day,active,created_date,userid) VALUES($mst_id,'" . $stage_id[$i] . "','" . $details[$i] . "',1,'" . date('Y-m-d h:i:s') . "','$uid')";
				// 	$sql_query_details_result = mssql_query($sql_query_details);
				// }

			}
			header('location:../workflowmaster.php');
		}
	}
}
}
// if (isset($_REQUEST['package_wf_update'])) {
// 	extract($_REQUEST);
// 	$uid = $_SESSION['uid'];
// 	$did = $_REQUEST['did'];
// 	$stage_id = $_POST['stage'];
// 			$details  = $_POST['details'];
// 			$checkbox1 = $_POST['check'];
// 			// $chk="";  
// 			// foreach($checkbox1 as $chk1)  
// 			//    {  
// 			//     echo $chk1;
// 			//    } 
// 			//echo count($checkbox1);
// 			for ($i = 0; $i < count($checkbox1); $i++) {
// 				$stage = $checkbox1[$i];
// 				//$details = $details[$i];
// 	 		$update = mssql_query("update swift_workflow_Details set target_day='" . $details[$i] . "' ,create_date=GETDATE() where stage_id='" . $stage . "' ");
// 	        $sql_query_details_result = mssql_query($sql_query_details);
// 	// $stage_id = $_POST['stage'];
// 	// $details  = $_POST['details'];
// 	// $checkbox1 = $_POST['check'];
// 	// $sql = "select * from  swift_workflow_Details where Did='" . $did . "'";
// 	// $query = mssql_query($sql);
// 	// $num_rows = mssql_num_rows($query);
// 	// if ($num_rows > 0) {
// 	// 	for ($i = 0; $i < count($checkbox1); $i++) {
// 	// 		$stage = $checkbox1[$i];
// 	// 		$update = mssql_query("update swift_workflow_Details set target_day='" . $details[$i] . "' ,create_date=GETDATE() where Did='" . $did . "' ");
// 	// 	}
// 	 }
// }
