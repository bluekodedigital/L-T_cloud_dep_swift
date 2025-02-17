<?php
include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = mssql_escape($_REQUEST['key']);
$projid = mssql_escape($_REQUEST['proj_id']);
$uid = mssql_escape($_SESSION['uid']);

$sql = "select distinct up_stage,stage_name from swift_comman_uploads as a 
inner join swift_stage_master as b on a.up_stage=b.stage_id
where a.up_projid='" . $projid . "' and a.up_packid='" . $pack_id . "' ";

$query    = mssql_query($sql);
$num_rows = mssql_num_rows($query);
// $row1     = mssql_fetch_array($query);
$team_id = 3;
if ($num_rows > 0) {  ?>
    <?php $j = 0;
    while ($rowstage = mssql_fetch_array($query)) {
        $stageid =  $rowstage['up_stage'];
    ?>
        <table class="table1 table-bordered text-center" stye="width: 100%; !important;">
            <thead>
                <th>SI.No</th>
                 <th>Key</th>
                <th>Date</th>
                <th>Doc Type</th>
                <th>File Name</th>
                <!-- <th>Action</th> -->
            </thead>
            <center style="width:100%;"><b> <?php echo $rowstage['stage_name']; ?> - Attachments:</b>
                <img class="pointer" src="images/remarks.png" onclick="  new PNotify({
                title: 'Over All Remarks',
                text: '<?php $remarks = $cls_report->prev_reamrkslist($projid, $pack_id); ?>',
                type: 'info',                  
                buttons: {
                    closer: true,
                    sticker: true
                },
            });"> <small style="cursor:pointer;"><span class="badge badge-pill badge-success font-12 text-white ml-1" id="expndate" onclick="downloadall(<?php echo $stageid; ?>);">Download</span></small>
            </center>
            <tbody>
                <?php $i = 0;
                $sql2 = "select rev,key_flag,up_stage,upid,up_packid,up_projid,up_filepath,up_update,
                  up_filename,b.stage_name from swift_comman_uploads as a 
                  inner join swift_stage_master as b on a.up_stage=b.stage_id
                  where a.up_projid='" . $projid . "' and a.up_packid='" . $pack_id . "' and up_stage='" . $stageid . "'
                  group by upid,up_packid,up_projid,up_filepath,up_update,up_filename,up_stage,key_flag,rev,
                  b.stage_name";
                $query2    = mssql_query($sql2);
                while ($row = mssql_fetch_array($query2)) {
                    $path = $row['up_filepath'];
                    //echo  $path;
                    $key = $row['key_flag'];
                    if ($key == 1) {
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
                    //  echo  $doc_name;
                ?>
                    <tr <?php echo $hight_light; ?>>
                        <td class=" text-center"> <?php echo $i + 1; ?></td>
                        <td>
                           <input disabled type="checkbox" <?php echo $check; ?> id="keyattach_flag<?php echo $i?>" name="keyattach_flag<?php echo $i?>" onclick="add_keyflag('<?php echo $i?>','<?php echo $row['upid']; ?>', '<?php echo $row['up_projid']; ?>', '<?php echo $row['up_packid']; ?>','<?php echo $row['up_stage']; ?>');">
                           <label for="keyattach_flag<?php echo $i?>"> </label>
                        </td>
                        <td class=" text-center">
                        
                                        
                             <?php echo formatDate($row['up_update'], 'd-M-Y'); ?></td>
                        <td class=" text-center"> <?php echo $row['up_filename']; ?></td>
                        <td class=" text-center"><a href="uploads/document/<?php echo $path; ?>" class=" text-purple" target="_blank"><?php echo $path; ?></a></td>
                        <!-- <td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_opsupload('<?php echo $row['upid']; ?>', '<?php echo $row['up_projid']; ?>', '<?php echo $row['up_packid']; ?>','<?php echo $row['up_stage']; ?>');"><i class="fas fa-trash"></i></span></td> -->

                        <!--<td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_omupload('<?php echo $row['upid']; ?>', '<?php echo $row['up_projid']; ?>', '<?php echo $row['up_packid']; ?>');"><i class="fas fa-trash"></i></span></td>-->
                       
                        <!-- <td class=" text-center"> <span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_opsupload1('<?php echo $row['upid']; ?>', '<?php echo $row['up_projid']; ?>', '<?php echo $row['up_packid']; ?>','<?php echo $row['up_stage']; ?>');"><i class="fas fa-trash"></i></span></td> -->
                 
                    </tr>
            <?php
                    $i++;
                }
                $j++;
            }
            ?>
            </tbody>
        </table>
    <?php } else {  ?>

    <?php } ?>