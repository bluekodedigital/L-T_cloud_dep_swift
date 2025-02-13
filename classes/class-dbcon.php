<?php
class dbcon{
	
	function __construct()
	{
		$this->con= mssql_connect(HOST,USERNAME,PASSWORD) or die ("mssql is not connected");
		$this->query = mssql_select_db(DBNAME,$this->con);
	}

}


?>