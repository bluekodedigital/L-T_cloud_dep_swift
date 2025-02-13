<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['expert'])){
    $pack_id = mssql_escape($_REQUEST['key']);
    $projid = mssql_escape($_REQUEST['proj_id']);
    $expert = mssql_escape($_REQUEST['expert']);
    $uid = mssql_escape($_SESSION['uid']);

    $sql = "select * from swift_expert_uploads where exp_up_projid='" . $projid . "' and exp_up_packid='" . $pack_id . "' and exp_up_uid ='" . $uid . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    // echo $sql; 
    if ($num_rows > 0) {
        ?>
        <table  class="table1 table-bordered text-center">
            <thead>
                <th>SI.No</th>
                <th>Doc Type</th>
                <th>File Name</th>
                <th>Action</th>
            </thead>
            <tbody >
        <?php
        $i = 0;
        while ($row = mssql_fetch_array($query)) {
            $path = $row['exp_upid'] . '_' . $row['exp_up_packid'] . '_' . $row['exp_up_projid']. $row['exp_filepath'];
            ?>
            <tr>
                <td class=" text-center"> <?php echo $i + 1; ?></td>
                <td class=" text-center"> <?php echo $row['exp_filename']; ?></td>
                <td class=" text-center"><a href="uploads/exp/<?php echo $path; ?>" class=" text-purple" target="_blank"> <?php echo $row['exp_filepath']; ?> </a>   </td>
                <td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_expupload1('<?php echo $row['exp_upid']; ?>','<?php echo $row['exp_up_projid']; ?>','<?php echo $row['exp_up_packid']; ?>');"><i class="fas fa-trash"></i></span></td>

            </tr>
            <?php $i++;
        }
        ?>
        </tbody>
    </table>
        <?php 
    } else {
    ?>

    <tr>
        <td colspan="4" class=" text-center"> No Data Available</td>

    </tr>
    <?php
    }
}else{
    $pack_id = $_REQUEST['key'];
    $projid = $_REQUEST['proj_id'];
    $uid = $_SESSION['uid'];

    $sql = "select * from swift_expert_uploads where exp_up_projid='" . $projid . "' and exp_up_packid='" . $pack_id . "' and exp_up_uid ='" . $uid . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    // echo $sql; 
    if ($num_rows > 0) {
        $i = 0;
        while ($row = mssql_fetch_array($query)) {
            $path = $row['exp_upid'] . '_' . $row['exp_up_packid'] . '_' . $row['exp_up_projid']. $row['exp_filepath'];
            ?>
            <tr>
                <td class=" text-center"> <?php echo $i + 1; ?></td>
                <td class=" text-center"> <?php echo $row['exp_filename']; ?></td>
                <td class=" text-center"><a href="uploads/exp/<?php echo $path; ?>" class=" text-purple" target="_blank"> <?php echo $row['exp_filepath']; ?> </a></td>
                <td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_expupload('<?php echo $row['exp_upid']; ?>','<?php echo $row['exp_up_projid']; ?>','<?php echo $row['exp_up_packid']; ?>');"><i class="fas fa-trash"></i></span></td>

            </tr>
            <?php $i++;
        }
    } else {
    ?>

    <tr>
        <td colspan="4" class=" text-center"> No Data Available</td>

    </tr>
<?php }
}
?>