<?php

##############################
////include filesize
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
##############################
//$up_excel = $_POST['up_excel'];

$date = date('Y-m-d H:i:s');
$packid = $_REQUEST['packid'];
$projid = $_REQUEST['projid'];
$ponum = $_REQUEST['ponum'];

$sql = "select distinct Quote_id from Quote_Approval as a,solution as b where a.Sol_id=b.sol_id and b.swift_packid='$packid'";
$query = mssql_query($sql);
$row = mssql_fetch_array($query);
$qid = $row['Quote_id'];

date_default_timezone_set('Asia/Kolkata');
$uid = $_SESSION['uid'];
$filename = $_FILES["file"]["tmp_name"];
if ($_FILES["file"]["size"] > 0) {
    $file = fopen($filename, "r");
    $data = array();
    //data from csv file
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
        $data[] = $emapData;
    }
    ini_set('max_execution_time', 300);
    $count = count($data);
    // echo $count;
    for ($y = 1; $y < $count; $y++) {
        $itemcode = trim($data[$y][0]);
        $desc = trim($data[$y][1]);
        $qty = trim($data[$y][2]);
        $rate = trim($data[$y][3]);

        // Check Empty Field in CSV
        if ($itemcode == '') {
            echo 0;
            exit();
        } else if ($desc == '') {
            echo 1;
            exit();
        } else if ($qty == '') {
            echo 2;
            exit();
        } else if ($rate == '') {
            echo 3;
            exit();
        }
    }
    $po_value = 0;
    for ($x = 1; $x < $count; $x++) {
        $itemcode = trim($data[$x][0]);
        $desc = trim($data[$x][1]);
        $qty = trim($data[$x][2]);
        $rate = trim($data[$x][3]);
        $po_value += $rate;
        $sql1 = "select MAX(swid)+1 as swid from swift_podetails";
        $query1 = mssql_query($sql1);
        $row1 = mssql_fetch_array($query1);
        if ($row1['swid'] == '' || $row1['swid'] == NULL) {
            $id = 1;
        } else {
            $id = $row1['swid'];
        }
        $sql = "insert into swift_podetails (swid,sw_qte,po_number,itemcode,sdesc,sqty,srate,upload_date,upload_user,po_pack_id,po_proj_id)"
                . "values('" . $id . "','" . $qid . "','" . $ponum . "','" . $itemcode . "','" . $desc . "','" . $qty . "','" . $rate . "','" . $date . "','" . $uid . "','" . $packid . "','" . $projid . "')";
        $query = mssql_query($sql);
    }
    $update=mssql_query("update swift_podetails set povalue='".$po_value."' where sw_qte='".$qid."'");    

    fclose($file);
    echo $po_value;
} else {
    echo "Error";
}
?>