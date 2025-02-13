<?php


class dbcon2
{
    public function getValue()
    {
        /* //live
        define("SECOND_HOST", "BRTSSAW0045");
        define("SECOND_USERNAME", "sa");
        define("SECOND_PASSWORD", "05UqItHT5348");
        define("SECOND_DBNAME", "lnt_track");  
        //local
        // define("SECOND_HOST", "bserver");
        // define("SECOND_USERNAME", "sa");
        // define("SECOND_PASSWORD", "Bks&123##");
        // define("SECOND_DBNAME", "lnt_track");
        $Con2 = mssql_connect(SECOND_HOST, SECOND_USERNAME, SECOND_PASSWORD) or die("Couldn't connect to the second MSSQL Server");
        $secondCon = mssql_select_db(SECOND_DBNAME, $Con2) or die("Couldn't open the second database");
        return $Con2; */

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
        return $con;
    }
}
?>