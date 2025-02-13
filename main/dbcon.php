<?php
$Server = "BRTSSAW0045";
$User = "sa";
$Pass = "05UqItHT5348";
$myDB = "bks_crm";

$con = mssql_pconnect($Server, $User, $Pass) or die("Couldn't connect to SQL Server on $Server");
$db =  mssql_select_db($myDB, $con) or die("Couldn't open database $myDB");
