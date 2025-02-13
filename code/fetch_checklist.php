<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id = $_REQUEST['key'];
$projid = $_REQUEST['proj_id'];
$uid = $_SESSION['uid'];

$sql = "select * from swift_checklist_docs where clk_id='" . $id . "' and ck_projid='" . $projid . "' and cd_uid ='" . $uid . "'";
$query = mssql_query($sql);
$num_rows = mssql_num_rows($query);
// echo $sql; 
if ($num_rows > 0) {
    $i = 0;
    while ($row = mssql_fetch_array($query)) {
        $path =$row['cd_attah'];
        ?>
        
          
<span class="badge badge-primary text-center"><a href="uploads/checklists/<?php echo $path; ?>" class=" text-white" target="_blank"><i class="fas fa-eye"></i></a></span>
            <!--<td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_omupload('<?php echo $row['om_upid']; ?>','<?php echo $row['om_up_projid']; ?>','<?php echo $row['om_up_packid']; ?>');"><i class="fas fa-trash"></i></span></td>-->

       
        <?php $i++;
    }
} else {
    ?>

    
<?php }
?>