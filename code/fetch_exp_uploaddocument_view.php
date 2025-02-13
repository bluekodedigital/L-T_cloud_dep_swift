<?php
include_once ("../config/inc_function.php");
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

// print_r($secondCon);
$pack_id = mssql_escape($_REQUEST['key']);
$projid = mssql_escape($_REQUEST['proj_id']);
$uid = mssql_escape($_SESSION['uid']);

$sql = "select * from swift_expert_uploads where exp_up_projid='" . $projid . "' and exp_up_packid='" . $pack_id . "'";
$query = mssql_query($sql,$Con2);
$num_rows = mssql_num_rows($query);
// echo $num_rows;
$team_id = 1;

if ($num_rows > 0) {
    $i = 0;
    ?>
    <center style="width:100%;"><b>Attachments:</b> <img class="pointer" src="images/remarks.png" onclick="  new PNotify({
                title: 'Technical Remarks',
                text: '<?php  $remarks = $cls_report->team_reamrksv1($projid, $pack_id, $team_id); ?>',
                type: 'info',                  
                buttons: {
                    closer: true,
                    sticker: true
                }
            });" > <small style="cursor:pointer;"><span class="badge badge-pill badge-success font-12 text-white ml-1" id="expndate" onclick="downloadallv1('1');">Download</span></small> </center>
     
    <table  class="table1 table-bordered text-center">
        <thead>
        <th>SI.No</th>
        <th>Date</th>
        <th>Doc Type</th>
        <th>File Name</th>
        <!--<th>Action</th>-->
    </thead>
    <tbody >


        <?php
        while ($row = mssql_fetch_array($query)) {
            $path = $row['exp_upid'] . '_' . $row['exp_up_packid'] . '_' . $row['exp_up_projid'] . $row['exp_filepath'];
            ?>
            <tr>
                <td class=" text-center"> <?php echo $i + 1; ?></td>
                <td class=" text-center"> <?php echo formatDate($row['exp_update'], 'd-M-Y'); ?></td>
                <td class=" text-center"> <?php echo $row['exp_filename']; ?></td>
                <td class=" text-center"><a href="swiftv1doc/uploads/exp/<?php echo $path; ?>" class=" text-purple" target="_blank"> <?php echo $row['exp_filepath']; ?> </a></td>
                <!--<td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_omupload('<?php echo $row['exp_upid']; ?>', '<?php echo $row['exp_up_projid']; ?>', '<?php echo $row['exp_up_packid']; ?>');"><i class="fas fa-trash"></i></span></td>-->

            </tr>
            <?php
            $i++;
        }
        ?> 
    </tbody>
    </table>
    <?php
} else {
    ?>

<?php }
?>