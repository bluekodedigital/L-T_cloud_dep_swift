<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$package_details = $cls_user->package_details($pack_id);
$vendor_details = $cls_user->vendor_details($pack_id);
$check_poc = $cls_user->check_poc($pack_id);
$poc = $check_poc['cm_poc_required'];

$deviations = $package_details['daysdif'];
$expdelivery = formatDate($package_details['pm_revised_material_req'] . ' +' . $deviations . 'days', 'd-M-Y');
?>
<div class="modal-header" style="margin-top: 0px;">                          
    <h4 class="modal-title" id="exampleModalLabel1"><?php echo $package_details['proj_name']; ?> - <small><?php echo $package_details['pm_packagename']; ?></small></h4> 
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="row">
    <div class="container-fluid" >
        <div class=" col-md-6" id="pd">
            <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="pdate"><?php echo formatDate($package_details['pm_revised_material_req'], 'd-M-y'); ?></span></small>                           
        </div>
        <div class=" col-md-6" id="ps" >
            <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mtred"><?php echo $expdelivery; ?></span></small>                          
        </div>
    </div>
</div>
<div class="modal-body">
    <div class=" offset-md-1 col-md-9" >
        <table class=" table table-bordered">
            <thead>
                <tr>
                    <th>Stage Name</th>
                    <th>Delay in Days</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fetch_delays = $cls_user->fetch_delays($pack_id);
                $delay = json_decode($fetch_delays, true);
                foreach ($delay as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $value['shot_name']; ?></td>
                        <td class=" text-danger"> + <?php echo $value['delay']; ?></td>
                    </tr> 
                <?php }
                ?>

            </tbody>
        </table>

    </div>

</div>
<div class="modal-footer">                               
    <!--<button type="submit" id="create_emr" name="create_emr" class="btn btn btn-rounded btn-outline-primary mr-2 btn-sm"><i class="fa fa-paper-plane mr-1"></i> Submit</button>-->
</div>