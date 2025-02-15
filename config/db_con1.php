<?php 

//define("HOST","118.91.233.199");
//define("USERNAME","crmadmin");
//define("PASSWORD","Crm@123?");
//define("DBNAME","bks_crm");

//define("HOST1","118.91.233.199");
//define("USERNAME1","sa");
//define("PASSWORD1","Bl^3sh@)1#");
//define("DBNAME1","bks_crm");

//define("HOST","118.91.233.152");
//define("USERNAME","sa");
//define("PASSWORD","Bl^3sh@)1#");
//define("DBNAME","lnt_track");

/* $Server1 = "BRTSSAW0045";
$User1 = "sa";
$Pass1 = "05UqItHT5348";
$myDB1 = "bks_crm";

 
//define("HOST","118.91.233.199");
//define("USERNAME","sa");
//define("PASSWORD","Bl^3sh@)1#");
//define("DBNAME","lnt_track");
$con1 = mssql_connect($Server1, $User1, $Pass1);
$db1 =  mssql_select_db($myDB1, $con1) or die("Couldn't open database $myDB1"); */

$serverName = "bserver";
$connectionOptions = [
    "Database" => "lnt_track",
    "Uid" => "sa",
    "PWD" => "Bks&123##"
];

$con1 = sqlsrv_connect($serverName, $connectionOptions);
if ($con1 === false) {
    die("Database connection failed: " . print_r(sqlsrv_errors(), true));
}
?>