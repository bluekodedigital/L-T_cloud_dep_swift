<?php
include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_REQUEST['key'];
$projid = $_REQUEST['proj_id'];
$stage = $_REQUEST['stage'];
$uid = $_SESSION['uid'];
$utype = $_SESSION['usertype'];
$rid = $_POST['rid'];

$sql = "select *,b.stage_name from swift_comman_uploads as a 
inner join swift_stage_master as b on a.up_stage=b.stage_id
where a.up_projid='" . $projid . "' and a.up_packid='" . $pack_id . "' and stage_id='" . $stage . "' ";

$sql2 = "select *,b.stage_name from swift_comman_uploads as a 
inner join swift_stage_master as b on a.up_stage=b.stage_id
where a.up_projid='" . $projid . "' and a.up_packid='" . $pack_id . "' and stage_id='" . $stage . "' ";

//echo $sql;
// exit();
$query1    = mssql_query($sql);
$query     = mssql_query($sql2);
$num_rows  = mssql_num_rows($query1);
$row1      = mssql_fetch_array($query);

$team_id = 3;
if ($num_rows > 0) {
    $i = 0;
?>
    <center style="width:100%;"><b> <?php echo $row1['stage_name']; ?> - Attachments:</b>
        <img class="pointer" src="images/remarks.png" onclick="  new PNotify({
                title: 'Remarks',
                text: '<?php $remarks = $cls_report->team_reamrks($projid, $pack_id, $team_id); ?>',
                type: 'info',                  
                buttons: {
                    closer: true,
                    sticker: true
                },
            });"> <small style="cursor:pointer;"><span class="badge badge-pill badge-success font-12 text-white ml-1" id="expndate" onclick="downloadall(<?php echo $stage; ?>);">Download</span></small>
    </center>

    <table class="table1 table-bordered text-center" stye="width: 100%; !important;">
        <thead>
            <th>SI.No</th>
            <th>Key</th>
            <th>Date</th>
            <!-- <th>Version</th> -->
            <th>Doc Type</th>
            <th>File Name</th>
            <?php if ($rid == 1) { ?>
                <!-- <th>Action</th> -->
            <?php }
            ?>
        </thead>
        <tbody>
            <?php
            $sql12 = "select * from [dbo].[swift_packagemaster] where pm_packid=$pack_id";
            $qry1 = mssql_query($sql12);
            $row12 = mssql_fetch_array($qry1);
            $tech_skip = $row12['tech_skip'];
            while ($row    = mssql_fetch_array($query1)) {
                if ($tech_skip == 0) {
                    $path = $row['upid'] . '_' . $row['up_packid'] . '_' . $row['up_projid'] . $row['up_filepath'];
                } else {
                    $path =  $row['up_filepath'];
                }
                
                if ($row['key_flag']== 1) {
                    $hight_light = 'style="background: #fffdd0;"';
                     $check='Checked';
                } else {
                    $hight_light = '';
                     $check='';
                }
                if ($row['rev'] != "") {
                    $doc_name = $row['up_filename'] . '-' . sprintf("%'.03d\n",  $i + 1) . ' ' . $row['rev'];
                } else {
                    $doc_name = $row['up_filename'];
                }
            ?>
                <tr <?php echo $hight_light; ?>>
                    <td class=" text-center"> <?php echo $i + 1; ?></td>
                    <td>
                           <input type="checkbox" <?php echo $check; ?> id="keyattach_flags<?php echo $i?>" name="keyattach_flag<?php echo $i?>" onclick="add_keyflag2('<?php echo $i?>','<?php echo $row['upid']; ?>', '<?php echo $row['up_projid']; ?>', '<?php echo $row['up_packid']; ?>','<?php echo $row['up_stage']; ?>');">
                           <label for="keyattach_flags<?php echo $i?>"> </label>
                        </td>
                    <td class=" text-center"> <?php echo date('d-M-Y', strtotime($row['up_update'])); ?></td>
                    <!-- <td class=" text-center"> <?php echo $row['rev'];  ?></td> -->
                    <td class=" text-center"> <?php echo $row['up_filename']; ?></td>
                    <td class=" text-center"><a href="uploads/document/<?php echo $path; ?>" class=" text-purple" target="_blank"> <?php echo $path; ?></a></td>
                    <?php if ($rid == 1) { ?>
                        <!-- <td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_opsupload('<?php echo $row['upid']; ?>', '<?php echo $row['up_projid']; ?>', '<?php echo $row['up_packid']; ?>','<?php echo $row['up_stage']; ?>');"><i class="fas fa-trash"></i></span></td> -->
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