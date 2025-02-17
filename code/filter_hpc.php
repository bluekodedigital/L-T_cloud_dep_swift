<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$hpc = $_POST['key'];
$pid = $_POST['proj_id'];
if($_SESSION['milcom']==1)
{
 $seg='38';   
}else
{
   $seg="";  
}
?>
<table id="zero_config" class="table table-bordered display compact">
    <thead>
        <tr>
            <th>Project</th>
            <th>Package</th> 
            <th>Received FROM</th>
            <th>ORG Schedule</th>
            <th>Material Req</th>
            <th>Stage Planned</th>
            <th>Stage Expected</th> 
<!--                                        <th>Stage Actual</th>                                         -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $uid = $_SESSION['uid'];
         $utype = $_SESSION['usertype'];
        $result = $cls_user->files_from_smartsignloi_filter($pid,$uid,$hpc,$utype,$seg);
//                                    print_r($result);
        $res = json_decode($result, true);
        foreach ($res as $key => $value) {
            if ($value['ps_expdate'] == "") {
                $exp_date = date('Y-m-d');
            } else {
                $exp_date = $value['ps_expdate'];
            }
            ?>
            <tr>
                <td><?php echo $value['proj_name'] ?></td>
                <td>
                    <?php if (strtotime($value['planned']) > strtotime($value['actual'])) { ?>
                        <div class="notify pull-left">
                            <span class="heartbit greenotify" ></span>
                            <span class="point greenpoint" ></span>
                        </div>

                    <?php } elseif (strtotime($value['planned']) < strtotime($value['actual'])) { ?>
                        <div class="notify pull-left">
                            <span class="heartbit"></span>
                            <span class="point" ></span>
                        </div>
                    <?php } elseif (strtotime($value['planned']) == strtotime($value['actual'])) { ?>
                        <div class="notify pull-left">
                            <span class="heartbit bluenotify"></span>
                            <span class="point bluepoint" ></span>
                        </div>
                    <?php }
                    ?>
                    <?php echo $value['pm_packagename'] ?></td>
                <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">Smart Signoff <br> (<?php echo formatDate($value['so_package_approved_date'], 'd-M-Y'); ?>)</span></td>
                <td><?php echo formatDate($value['pm_material_req'], 'd-M-Y'); ?></td>
                <td><?php echo formatDate($value['pm_revised_material_req'], 'd-M-Y'); ?></td>
                <td><?php echo formatDate($value['planned'], 'd-M-Y'); ?></td>
                <td><?php // echo formatDate($value['actual'], 'd-M-Y');      ?>
                    <div class="input-group" id="expdiv" style=" float: left;">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="icon-calender"></i></span>
                        </div>
                        <input type="text" value="<?php echo formatDate($exp_date, 'd-M-Y'); ?>"  class="mydatepicker" id="dasexpected_date<?php echo $value['so_pack_id'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                    </div>
                    <div class=" saveexp" style=" float: right;">
                        <span   class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['so_pack_id'] ?>', '18')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                            <i class="fas fa-save"></i>
                        </span>
                    </div>

                </td>
    <!--                                            <td><?php // echo formatDate($value['actual'], 'd-M-Y');       ?></td>-->
                <td>                                               
                    <span onclick="filesfrom_smartsign_loi('<?php echo $value['so_pack_id'] ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages">
                        <i class="fas fa-paper-plane"></i> 
                    </span>
                </td>
            </tr>

        <?php }
        ?>


    </tbody>

</table>