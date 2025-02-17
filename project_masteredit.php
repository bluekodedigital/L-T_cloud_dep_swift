<?php
include_once '../config/inc.php';
$proj_id = $_POST['proj_id'];
$sql = "select * from Project where proj_id='" . $proj_id . "'";
$query = mssql_query($sql);
$row = mssql_fetch_array($query);
$proj_name = $row['proj_name'];
$short=$row['shortcode'];
$pro_id = $row['proj_id'];
$sdate = formatDate($row['proj_created_date'], 'd-m-Y');
$edate = formatDate($row['proj_edate'], 'd-m-Y');
$redate = formatDate($row['proj_revised_edate'], 'd-m-Y');
$catagories=$row['catagories'];
$location=$row['location'];
$address=$row['address']; 
echo json_encode(array(
    'proj_name' => $proj_name,
    'short'=>$short,
    'proj_id' => $pro_id,
    'sdate' => $sdate,
    'edate' => $edate,
    'redate' => $redate,
    'catagories' => $catagories,
    'location' => $location,
    'address' => $address   
));
?>
