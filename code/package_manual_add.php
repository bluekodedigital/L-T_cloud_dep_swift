<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");
$uid = $_SESSION['uid'];
$projid = mssql_escape($_POST['projid']);
$m_package = mssql_escape($_POST['m_package']);
$sql_check = "select * from solution where sol_name='" . $m_package . "' and sol_projid='" . $projid . "' ";
$qry_check = mssql_query($sql_check);
$num_rows = mssql_num_rows($qry_check);
if ($num_rows > 0) {


    $row = mssql_fetch_array($qry_check);
    $sol_id = $row['sol_id'];
    echo $sol_id;
    exit();
} else {
    $sql = "insert into solution(sol_name,sol_projid,sol_dept_id,sale_value,ace_value,swift_packid) values('" . $m_package . "','" . $projid . "','','','','')";
    $query = mssql_query($sql);
    $sql = "select * from solution where sol_name='" . $m_package . "' and sol_projid='" . $projid . "' ";
    $qry = mssql_query($sql);
    $row = mssql_fetch_array($qry);
    $sol_id = $row['sol_id'];
}




if ($query) {
    echo $sol_id;
} else {
    echo 0;
}
?>