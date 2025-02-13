<?php

include_once ("config/db_con.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/* define("SECOND_HOST", "BRTSSAW0045");
define("SECOND_USERNAME", "sa");
define("SECOND_PASSWORD", "05UqItHT5348");
define("SECOND_DBNAME", "lnt_track"); 
$Con2 = mssql_connect(SECOND_HOST, SECOND_USERNAME, SECOND_PASSWORD) or die("Couldn't connect to the second MSSQL Server");
$secondCon= mssql_select_db(SECOND_DBNAME, $Con2) or die("Couldn't open the second database"); */

$serverName = "bserver";
$connectionOptions = [
    "Database" => "lnt_track",
    "Uid" => "sa",
    "PWD" => "Bks&123##"
];

$Con2 = sqlsrv_connect($serverName, $connectionOptions);
if ($Con2 === false) {
    die("Database connection failed: " . print_r(sqlsrv_errors(), true));
}

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

$pack_id = mssql_escape(trim($_REQUEST['key']));
$projid = mssql_escape(trim($_REQUEST['proj_id']));
$uid = mssql_escape($_SESSION['uid']);
$projname = clean(mssql_escape($_REQUEST['projname']));
$packname = clean(mssql_escape($_REQUEST['packname']));
$type = $_REQUEST['type'];

$file_path = 'swiftv1doc/uploads/';
$file_names = array();
if ($type == '0') {

    $sql = "select * from swift_expert_uploads where exp_up_projid='" . $projid . "' and exp_up_packid='" . $pack_id . "'";
    $query = mssql_query($sql,$Con2);
    $num_rows = mssql_num_rows($query);
//echo $sql;
    $team_id = 1;

    if ($num_rows > 0) {
        $i = 0;
        while ($row = mssql_fetch_array($query)) {
            $path = $row['exp_upid'] . '_' . $row['exp_up_packid'] . '_' . $row['exp_up_projid'] . $row['exp_filepath'];


            if (file_exists($file_path . 'exp/' . $path)) {

                $file_names[] = 'exp/' . $path . '';
            }
        }
    }


    $sql = "select * from swift_om_uploads where om_up_projid='" . $projid . "' and om_up_packid='" . $pack_id . "'";
    $query = mssql_query($sql,$Con2);
    $num_rows = mssql_num_rows($query);
//echo $sql;
    $team_id = 2;
    if ($num_rows > 0) {
        while ($row = mssql_fetch_array($query)) {
            $path = $row['om_upid'] . '_' . $row['om_up_packid'] . '_' . $row['om_up_projid'] . $row['om_filepath'];
            if (file_exists($file_path . 'om/' . $path)) {

                $file_names[] = 'om/' . $path . '';
            }
        }
    }


    $sql = "select * from swift_ops_expert_uploads where oexp_up_projid='" . $projid . "' and oexp_up_packid='" . $pack_id . "'";

// echo $sql;
// exit();
$query = mssql_query($sql,$Con2);
    $num_rows = mssql_num_rows($query);
//echo $sql;
    $team_id = 3;
    if ($num_rows > 0) {

        $sql1 = "select * from [dbo].[swift_packagemaster] where pm_packid=$pack_id";
        //$qry1 = mssql_query($sql1);
        $qry1 = mssql_query($sql1,$Con2);
        $row1 = mssql_fetch_array($qry1);
        $tech_skip = $row1['tech_skip'];
        while ($row = mssql_fetch_array($query)) {
            if ($tech_skip == 0) {
                $path = $row['oexp_upid'] . '_' . $row['oexp_up_packid'] . '_' . $row['oexp_up_projid'] . $row['oexp_filepath'];
            } else {
                $path = $row['oexp_filepath'];
            }


            if (file_exists($file_path . 'op_exp/' . $path)) {

                $file_names[] = 'op_exp/' . $path . '';
            }
        }
    }
    $archive_file_name1 = $projname . "-" . $packname . $ran . ".zip";
} else if ($type == '1') {

    $sql = "select * from swift_expert_uploads where exp_up_projid='" . $projid . "' and exp_up_packid='" . $pack_id . "'";
    $query = mssql_query($sql,$Con2);
    $num_rows = mssql_num_rows($query);
    $team_id = 1;

    if ($num_rows > 0) {
        $i = 0;
        while ($row = mssql_fetch_array($query)) {
            $path = $row['exp_upid'] . '_' . $row['exp_up_packid'] . '_' . $row['exp_up_projid'] . $row['exp_filepath'];


            if (file_exists($file_path . 'exp/' . $path)) {

                $file_names[] = 'exp/' . $path . '';
            }
        }
    }
    $archive_file_name1 = $packname ."-Technical-Attachment-". $ran . ".zip";
} else if ($type == '2') {

    //echo "select * from swift_om_uploads where om_up_projid='" . $projid . "' and om_up_packid='" . $pack_id . "'";
    $sql = "select * from swift_om_uploads where om_up_projid='" . $projid . "' and om_up_packid='" . $pack_id . "'";
    $query = mssql_query($sql,$Con2);
    $num_rows = mssql_num_rows($query);
//echo $sql;
    $team_id = 2;
    if ($num_rows > 0) {
        while ($row = mssql_fetch_array($query)) {
            $path = $row['om_upid'] . '_' . $row['om_up_packid'] . '_' . $row['om_up_projid'] . $row['om_filepath'];
            //echo $file_path.'/'.$path;
            if (file_exists($file_path . 'om/' . $path)) {

                $file_names[] = 'om/' . $path . '';
            }
        }
    }
     $archive_file_name1 = $packname ."-O&M-Attachment-". $ran . ".zip";
} else if ($type == '3') {

    $sql = "select * from swift_ops_expert_uploads where oexp_up_projid='" . $projid . "' and oexp_up_packid='" . $pack_id . "'";

// echo $sql;
// exit();
$query = mssql_query($sql,$Con2);
    $num_rows = mssql_num_rows($query);
//echo $sql;
    $team_id = 3;
    if ($num_rows > 0) {

        $sql1 = "select * from [dbo].[swift_packagemaster] where pm_packid=$pack_id";
        $qry1 = mssql_query($sql1,$Con2);
        $row1 = mssql_fetch_array($qry1);
        $tech_skip = $row1['tech_skip'];
        while ($row = mssql_fetch_array($query)) {
            if ($tech_skip == 0) {
                $path = $row['oexp_upid'] . '_' . $row['oexp_up_packid'] . '_' . $row['oexp_up_projid'] . $row['oexp_filepath'];
            } else {
                $path = $row['oexp_filepath'];
            }


            if (file_exists($file_path . 'op_exp/' . $path)) {

                $file_names[] = 'op_exp/' . $path . '';
            }
        }
    }
     $archive_file_name1 = $packname ."-OPS-Attachment-". $ran . ".zip";
} else if ($type == '4') {
    if ($projid == "") {
        $sql = "select * from swift_loi_uploads where  loi_up_packid='" . $pack_id . "'";
    } else {
        $sql = "select * from swift_loi_uploads where loi_up_projid='" . $projid . "' and loi_up_packid='" . $pack_id . "'";
    }
    $query = mssql_query($sql,$Con2);
    $num_rows = mssql_num_rows($query);

    if ($num_rows > 0) {
        $i = 0;
        while ($row = mssql_fetch_array($query)) {
            $path = $row['loi_upid'] . '_' . $row['loi_up_packid'] . '_' . $row['loi_up_projid'] . $row['loi_filepath'];
             if (file_exists($file_path . 'loi/' . $path)) {

                $file_names[] = 'loi/' . $path . '';
            }
            $i++;
        }
    }
} else {
    echo '<script>alert("Files not Found");</script>';
}


$ran = rand(6, 1000000);

//Archive name
$archive_file_name = "swiftv1doc/downloads/downloadzip/" . $projname . "-" . $packname . $ran . ".zip";

zipFilesAndDownload($file_names, $archive_file_name, $file_path, $archive_file_name1);

function zipFilesAndDownload($file_names, $archive_file_name, $file_path, $archive_file_name1) {

    $zip = new ZipArchive();
    //create the file and throw the error if unsuccessful
    if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
        exit("cannot open <$archive_file_name>\n");
    }
   
    //add each files of $file_name array to archive
    foreach ($file_names as $files) {
        $zip->addFile($file_path . $files, $files);
        //echo $file_path.$files,$files;
    }

    $zip->close();
    //then send the headers to force download the zip file
    header("Content-type: application/zip");
    header("Content-Disposition: attachment; filename=$archive_file_name1");
    header("Content-length: " . filesize($archive_file_name));
    header("Pragma: no-cache");
    header("Expires: 0");

    while (ob_get_level()) {
        ob_end_clean();
    }
    readfile("$archive_file_name");    //exit;
}

?>