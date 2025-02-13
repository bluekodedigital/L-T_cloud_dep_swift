<?php

include_once ("config/db_con.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

$pack_id = mssql_escape(trim($_REQUEST['key']));
$projid = mssql_escape(trim($_REQUEST['proj_id']));
$uid = mssql_escape($_SESSION['uid']);
$projname = clean(mssql_escape($_REQUEST['projname']));
$packname = clean(mssql_escape($_REQUEST['packname']));
$type = $_REQUEST['type'];


$file_path = 'uploads/document/';
$file_names = array();
if ($type == '0') {
    $sql = "select distinct up_stage,stage_name from swift_comman_uploads as a 
    inner join swift_stage_master as b on a.up_stage=b.stage_id
    where a.up_projid='" . $projid . "' and a.up_packid='" . $pack_id . "' ";

    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    // $row1     = mssql_fetch_array($query);

    $team_id = 3;
    if ($num_rows > 0) { ?>
        <?php $j = 0;
        while ($rowstage = mssql_fetch_array($query)) {
            $stageid = $rowstage['up_stage'];
            // $sql = "select * from swift_expert_uploads where exp_up_projid='" . $projid . "' and exp_up_packid='" . $pack_id . "'";
            $sql = "select key_flag,up_stage,upid,up_packid,up_projid,up_filepath,up_update,
    up_filename,b.stage_name from swift_comman_uploads as a 
    inner join swift_stage_master as b on a.up_stage=b.stage_id
    where a.up_projid='" . $projid . "' and a.up_packid='" . $pack_id . "' and up_stage='" . $stageid . "'
    group by upid,up_packid,up_projid,up_filepath,up_update,up_filename,up_stage,
    b.stage_name,key_flag";

            $query = mssql_query($sql);
            $num_rows = mssql_num_rows($query);
            //echo $sql;
            $team_id = 1;

            if ($num_rows > 0) {
                $i = 0;
                while ($row = mssql_fetch_array($query)) {
                    $path = $path = $row['up_filepath'];
                    $stage_name = $rowstage['stage_name'];

                    if (file_exists($file_path . '/' . $path)) {

                        $file_names[] = '' . $path . '';
                    }
                }
            }
            $archive_file_name1 = $packname . "-$stage_name-" . $ran . ".zip";
        }
    }
} else {
    $sql = "select distinct up_stage,stage_name from swift_comman_uploads as a 
    inner join swift_stage_master as b on a.up_stage=b.stage_id
    where a.up_projid='" . $projid . "' and a.up_packid='" . $pack_id . "' and a.up_stage=$type ";

    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    // $row1     = mssql_fetch_array($query);

    $team_id = 3;
    if ($num_rows > 0) { ?>
        <?php $j = 0;
        while ($rowstage = mssql_fetch_array($query)) {
            $stageid = $rowstage['up_stage'];
            // $sql = "select * from swift_expert_uploads where exp_up_projid='" . $projid . "' and exp_up_packid='" . $pack_id . "'";
            $sql = "select key_flag,up_stage,upid,up_packid,up_projid,up_filepath,up_update,
    up_filename,b.stage_name from swift_comman_uploads as a 
    inner join swift_stage_master as b on a.up_stage=b.stage_id
    where a.up_projid='" . $projid . "' and a.up_packid='" . $pack_id . "' and up_stage='" . $stageid . "'
    group by upid,up_packid,up_projid,up_filepath,up_update,up_filename,up_stage,
    b.stage_name,key_flag";

            $query = mssql_query($sql);
            $num_rows = mssql_num_rows($query);
            //echo $sql;
            $team_id = 1;

            if ($num_rows > 0) {
                $i = 0;
                while ($row = mssql_fetch_array($query)) {
                    $path = $path = $row['up_filepath'];
                    $stage_name = $rowstage['stage_name'];

                    if (file_exists($file_path . '/' . $path)) {

                        $file_names[] = '' . $path . '';
                    }
                }
            }
            $archive_file_name1 = $packname . "-$stage_name-" . $ran . ".zip";
        }
    }
    //echo '<script>alert("Files not Found");</script>';
}


$ran = rand(6, 1000000);

//Archive name
$archive_file_name = "downloads/downloadzip/" . $projname . "-" . $packname . $ran . ".zip";


// echo $file_path;
// print_r($file_names);echo '<br>';
// echo $archive_file_name;echo '<br>';
// echo $file_path;echo '<br>';
// echo $archive_file_name1;echo '<br>';

zipFilesAndDownload($file_names, $archive_file_name, $file_path, $archive_file_name1);

function zipFilesAndDownload($file_names, $archive_file_name, $file_path, $archive_file_name1)
{

    $zip = new ZipArchive();
    //create the file and throw the error if unsuccessful
    if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
        exit("cannot open <$archive_file_name>\n");
    }
    //add each files of $file_name array to archive
    foreach ($file_names as $files) {
        $zip->addFile($file_path . $files, $files);
        //echo $file_path.$files.$files;
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