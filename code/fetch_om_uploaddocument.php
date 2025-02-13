<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_REQUEST['key'];
$projid = $_REQUEST['proj_id'];
$uid = $_SESSION['uid'];

$sql = "select * from swift_om_uploads where om_up_projid='" . $projid . "' and om_up_packid='" . $pack_id . "' and om_up_uid ='" . $uid . "'";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
// echo $sql; 
if ($num_rows > 0) {
    $i = 0;
    while ($row = mssql_fetch_array($query)) {
        $path = $row['om_upid'] . '_' . $row['om_up_packid'] . '_' . $row['om_up_projid']. $row['om_filepath'];
        ?>
        <tr>
            <td class=" text-center"> <?php echo $i + 1; ?></td>
            <td class=" text-center"> <?php echo $row['om_filename']; ?></td>
            <td class=" text-center"><a href="uploads/om/<?php echo $path; ?>" class=" text-purple" target="_blank"> <?php echo $row['om_filepath']; ?> </a></td>
            <td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_omupload('<?php echo $row['om_upid']; ?>','<?php echo $row['om_up_projid']; ?>','<?php echo $row['om_up_packid']; ?>');"><i class="fas fa-trash"></i></span></td>

        </tr>
        <?php $i++;
    }
} else {
    ?>

    <tr>
        <td colspan="4" class=" text-center"> No Data Available</td>

    </tr>
<?php }
?>