<?php
include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_REQUEST['key'];
$projid = $_REQUEST['proj_id'];
$mdid = $_REQUEST['mdid'];
$uid = $_SESSION['uid'];
$utype = $_SESSION['usertype'];


$sql = "select * from swift_distributor_files  
where df_projid='" . $projid . "' and df_packid='" . $pack_id . "'
 and df_mail_disid='" . $mdid . "' ";

$sql2 = "select * from swift_distributor_files  
 where df_projid='" . $projid . "' and df_packid='" . $pack_id . "'
  and df_mail_disid='" . $mdid . "' ";
// echo $sql;
// exit();
$query1    = mssql_query($sql);
$query     = mssql_query($sql2);
$num_rows  = mssql_num_rows($query1);
$row1      = mssql_fetch_array($query);
if ($num_rows > 0) {
    $i = 0;
?>
    <center style="width:100%;"><b> Attachments:</b>
    </center>

    <table class="table1 table-bordered text-center" style="width: 83% !important;">
        <thead>
            <th>SI.No</th>
            <th>Date</th>
            <th>Doc No</th>
            <th>File Name</th>
            <?php if ($num_rows > 0) { ?>
                <th>Action</th>
            <?php }
            ?>
        </thead>
        <tbody>
            <?php
            while ($row    = mssql_fetch_array($query1)) {
                $path =  $row['df_filepath'];
                $doc_name = $row['df_filename'];
                $df_id = $row['df_id'];
            ?>
                <tr>
                    <td class=" text-center"> <?php echo $i + 1; ?></td>
                    <td class=" text-center"> <?php echo formatDate($row['df_update'], 'd-M-Y'); ?></td>
                    <td class=" text-center"> <?php echo $doc_name;  ?></td>
                    <td class=" text-center"><a href="uploads/order_document/<?php echo $path; ?>" class=" text-purple" target="_blank"> <?php echo $doc_name; ?> </a></td>
                    <?php if ($df_id > 0) { ?>
                        <td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_orderupload('<?php echo $row['df_id']; ?>', '<?php echo $row['df_projid']; ?>', '<?php echo $row['df_packid']; ?>','<?php echo $mdid; ?>');"><i class="fas fa-trash"></i></span></td>
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