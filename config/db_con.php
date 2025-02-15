<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_PARSE); // E_ERROR | E_PARSE

// Session configuration (only set if session is not active)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
}

// Database connection using sqlsrv_connect
$serverName = "10.15.3.40";
$connectionOptions = [
    "Database" => "lnt_track_v2",
    "Uid" => "sa",
    "PWD" => "Bl@kode.1?"
];

$con = sqlsrv_connect($serverName, $connectionOptions);
if ($con === false) {
    die("Database connection failed: " . print_r(sqlsrv_errors(), true));
}


function mssql_escape($data)
{
    return str_replace("'", "''", $data);
}

function mssql_escape1($data)
{
    return str_replace("'", "''", $data);
}

function mssql_escape_html($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

function filterText($str)
{
    $str = trim(strip_tags($str));
    $str = mssql_escape($str);
    return $str;
}

function money_FormatIndia($num) {

    $explrestunits = "";
    $num = preg_replace('/,+/', '', $num);
    $words = explode(".", $num);
    $des = "00";
    if (count($words) <= 2) {
        $num = $words[0];
        if (count($words) >= 2) {
            $des = $words[1];
        }
        if (strlen($des) < 2) {
            $des = "$des0";
        } else {
            $des = substr($des, 0, 2);
        }
    }
    if (strlen($num) > 3) {
        $lastthree = substr($num, strlen($num) - 3, strlen($num));
        $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for ($i = 0; $i < sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if ($i == 0) {
                $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i] . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }
    return "$thecash"; // writes the final format where $currency is the currency symbol.
}
date_default_timezone_set('Asia/Kolkata');
$baseUrl = 'http://192.168.0.51/swift/';


function generate_token()
{
    $token = base64_encode(random_bytes(32));
    setcookie("token", $token, 0, '/', '', false, true); // HTTPOnly token
    $_SESSION['token'] = $token;
    return $token;
}

function sanitize($field)
{
    $field = str_replace("&", "&amp;", $field);
    $field = str_replace("=", "", $field);
    $find = ['>', '<', "'", '"', "/"];
    $replace = ["&gt;", "&lt;", "&apos;", "&quot;", "&sol;"];
    $field = str_replace($find, $replace, $field);
    return htmlspecialchars($field, ENT_QUOTES, 'UTF-8');
}

function sanitize_decode($field)
{
    $replace = ['>', '<', "'", '"', "/"];
    $find = ["&gt;", "&lt;", "&apos;", "&quot;", "&sol;"];
    $field = str_replace($find, $replace, htmlspecialchars_decode($field, ENT_QUOTES));
    return str_replace("&amp;", "&", $field);
}

  function mssql_query($query){
    global $con; // Makes $con accessible within the function
    if (!$con) {
        die("Database connection not established.");
    }
    $options = ["Scrollable" => SQLSRV_CURSOR_STATIC];
    $result = sqlsrv_query($con, $query, [], $options);
    if ($result === false) {
        die("Query execution failed: " . print_r(sqlsrv_errors(), true));
    }
    return $result;
}

function mssql_fetch_array($resource, $fetchType = SQLSRV_FETCH_ASSOC) {
    if (!$resource) {
        die("Invalid resource provided to mssql_fetch_array.");
    }

    $result = sqlsrv_fetch_array($resource, $fetchType);
    if ($result === false && ($errors = sqlsrv_errors())) {
        die("Fetching data failed: " . print_r($errors, true));
    }

    return $result;
}

function mssql_num_rows($resource) {
    if (!$resource) {
        die("Invalid resource provided to mssql_num_rows.");
    }

    $rowCount = sqlsrv_num_rows($resource);
    if ($rowCount === false) {
        die("Failed to retrieve row count: " . print_r(sqlsrv_errors(), true));
    }

    return $rowCount;
}

function mssql_fetch_assoc($resource) {
    // Validate the resource
    if (!$resource) {
        die("Invalid resource provided to mssql_fetch_assoc.");
    }

    // Fetch the next row as an associative array
    $row = sqlsrv_fetch_array($resource, SQLSRV_FETCH_ASSOC);
    // Check for errors
    if ($row === false && sqlsrv_errors()) {
        die("Failed to fetch associative array: " . print_r(sqlsrv_errors(), true));
    }

    return $row; // Returns the row or null if no more rows
}

function formatDate($date, $format = 'd-M-Y') {
    if ($date instanceof DateTime) {
        return $date->format($format);
    } elseif (is_array($date) && isset($date['date'])) {
        return date($format, strtotime($date['date']));
    } elseif (is_object($date) && isset($date->date)) {
        return date($format, strtotime($date->date));
    } elseif (is_string($date)) {
        return date($format, strtotime($date));
    }
    return '';
}
?>