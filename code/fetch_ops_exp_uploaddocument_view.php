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

$pack_id = $_REQUEST['key'];
$projid = $_REQUEST['proj_id'];
$uid = $_SESSION['uid'];
$utype = $_SESSION['usertype'];
$rid = $_POST['rid'];

$sql = "select * from swift_ops_expert_uploads where oexp_up_projid='" . $projid . "' and oexp_up_packid='" . $pack_id . "'";

// echo $sql;
// exit();
$query = mssql_query($sql,$Con2);
$num_rows = mssql_num_rows($query);
//echo $sql;
$team_id=3;
if ($num_rows > 0) {
    $i = 0;
    ?>
<center style="width:100%;"><b>Attachments Files: </b> 
    <img class="pointer" src="images/remarks.png" id="opbatchremark"   onclick="  new PNotify({
            title: 'OPS Remarks',
            text: '<?php  $remarks = $cls_report->team_reamrksv1($projid, $pack_id, $team_id); ?>',
            type: 'info',
            buttons: {
                closer: true,
                sticker: true
            },
                });"> <small style="cursor:pointer;float:right;"><span class="badge badge-pill badge-success font-12 text-white ml-1" id="expndate" onclick="downloadallv1('3');">Download</span></small> </center>
    <table  class="table1 table-bordered text-center">
        <thead>
        <th>SI.No</th>
        
        <th>Date</th>
        <th>Version</th>
        <th>Doc No</th>
        <th>File Name</th>
        <?php if ($rid == 1) { ?>
            <!-- <th>Action</th> -->
        <?php }
        ?>
    </thead>
    <tbody >


        <?php
        $sql1 ="select * from [dbo].[swift_packagemaster] where pm_packid=$pack_id";
        $qry1 = mssql_query($sql1,$Con2);
        $row1 = mssql_fetch_array($qry1);
        $tech_skip = $row1['tech_skip'];
        while ($row = mssql_fetch_array($query)) {
            if($tech_skip == 0){
                 $path = $row['oexp_upid'] . '_' . $row['oexp_up_packid'] . '_' . $row['oexp_up_projid'] . $row['oexp_filepath'];
            }else{
                 $path =  $row['oexp_filepath'];
            }
           
           
            if($row['oexp_rev'] != ""){
                 $doc_name = $row['oexp_filename'].'-'.sprintf("%'.03d\n",  $i + 1).' '.$row['oexp_rev'];
            }else{
                 $doc_name = $row['oexp_filename'];
            }
            ?>
            <tr>
                <td class=" text-center"> <?php echo $i + 1; ?></td>
                <td class=" text-center"> <?php echo date('d-M-Y',strtotime($row['oexp_update'])); ?></td>
                   <td class=" text-center"> <?php echo $row['oexp_rev'];  ?></td>
                <td class=" text-center"> <?php echo $doc_name;  ?></td>
                <td class=" text-center"><a href="swiftv1doc/uploads/op_exp/<?php echo $path; ?>" class=" text-purple" target="_blank"> <?php echo $doc_name; ?> </a></td>
                <?php if ($rid == 1) { ?>
                <!-- <td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_opsupload('<?php echo $row['oexp_upid']; ?>', '<?php echo $row['oexp_up_projid']; ?>', '<?php echo $row['oexp_up_packid']; ?>');"><i class="fas fa-trash"></i></span></td> -->

        <?php }
        ?>

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