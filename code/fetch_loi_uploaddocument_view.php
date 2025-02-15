<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_REQUEST['key'];
$projid = trim($_REQUEST['proj_id']);
$uid = $_SESSION['uid'];
if($projid == ""){
    $sql = "select * from swift_loi_uploads where  loi_up_packid='" . $pack_id . "'";
}else{
    $sql = "select * from swift_loi_uploads where loi_up_projid='" . $projid . "' and loi_up_packid='" . $pack_id . "'";
}

// echo $sql;
// exit();
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);

if ($num_rows > 0) {
    $i = 0;
    ?>
    <center>  <b> LOI Attachments:</b> <small style="cursor:pointer;float:right;"><span class="badge badge-pill badge-success font-12 text-white ml-1" id="expndate" onclick="downloadall('13');">Download</span></small></center>
    <table  class="table1 table-bordered text-center">
        <thead>
        <th>SI.No</th>
        <th>Doc Name</th>
        <th>File Name</th>
        <!--<th>Action</th>-->
    </thead>
    <tbody >


        <?php
        while ($row = mssql_fetch_array($query)) {
            $path = $row['loi_upid'] . '_' . $row['loi_up_packid'] . '_' . $row['loi_up_projid'] . $row['loi_filepath'];
            ?>
            <tr>
                <td class=" text-center"> <?php echo $i + 1; ?></td>
                <td class=" text-center"> <?php echo $row['loi_filename']; ?></td>
                <td class=" text-center"><a href="uploads/loi/<?php echo $path; ?>" class=" text-purple" target="_blank"> <?php echo $row['loi_filepath']; ?> </a></td>
                <!--<td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_loiupload('<?php echo $row['loi_upid']; ?>', '<?php echo $row['loi_up_projid']; ?>', '<?php echo $row['loi_up_packid']; ?>');"><i class="fas fa-trash"></i></span></td>-->

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