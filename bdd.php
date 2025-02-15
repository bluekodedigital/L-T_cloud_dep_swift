<?php


//define("HOST", ".\MSSQLSERVER2008");
//define("USERNAME","sa");
//define("PASSWORD","Bl^3sh@)1#");
//define("DBNAME","lnt_track");


//define("HOST", "192.168.0.18");
//define("USERNAME", "sa");
//define("PASSWORD", "Bks&123#");
//define("DBNAME", "lnt_track"); 


/* define("HOST", "BRTSSAW0045");
define("USERNAME", "sa");
define("PASSWORD", "05UqItHT5348");
define("DBNAME", "lnt_track_prd");


$con = mssql_connect(HOST, USERNAME, PASSWORD) or die("Couldn't connect to MSSQL Server");
//print_r($con);
$db = mssql_select_db(DBNAME, $con) or die("Couldn't open database"); */

$serverName = "bserver";
$connectionOptions = [
    "Database" => "lnt_track",
    "Uid" => "sa",
    "PWD" => "Bks&123##"
];

$con = sqlsrv_connect($serverName, $connectionOptions);
if ($con === false) {
    die("Database connection failed: " . print_r(sqlsrv_errors(), true));
}
?>