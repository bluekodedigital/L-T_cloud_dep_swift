<?php
include 'config/inc.php';
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    $pid = "";
}
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
?>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">RPA Master</h5>
            </div>
            <div class="col-lg-3 col-md-3" style=" display: none;">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->techspoc_proj_filter();
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id'] ) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-8 col-md-8 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="finance">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">RPA Master</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- Start Page Content -->
        <!-- Row -->

        <div class="row" id="project_create">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Validation Form</h4>-->
                        <form class="needs-validation" method="post" action="functions/rpa_form" autocomplete="off">
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="segment">Select Vendor</label>
                                    <select class="custom-select" name="vendor" id="vendor" required="" onchange="fetch_vendorcode(this.value)">
                                        <option value="">--Select Vendor--</option>
                                        <?php
                                        $result = $cls_comm->vendor_select();
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['sup_id'] ?>"><?php echo $value['sup_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="proj_name">RPA Number</label>
                                    <input type="text" class="form-control" readonly="" id="rpa_num"  name="rpa_num" placeholder="RPA Number" value="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                 <div class="col-md-3 mb-3">
                                    <label for="proj_shrtname">Bank Name</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="bank_name" name="bank_name" required="" placeholder="Bank Name">

                                    </div>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="proj_shrtname">RPA Date</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                        <input type="text" class="form-control mydatepicker" id="rpa_date" name="rpa_date" required="" placeholder="dd/mmm/yyyy">

                                    </div>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>



                            </div>

                            <div class="form-row">                            
                                <div class="col-md-3 mb-3">
                                    <label for="start_date">Validity Date</label>
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text " class="form-control mydatepicker" id="from_rpa" name="from_rpa" placeholder="dd/mmm/yyyy"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-info b-0 text-white">TO</span>
                                        </div>
                                        <input type="text" class="form-control mydatepicker" id="to_rpa" name="to_rpa" placeholder="dd/mmm/yyyy"/>
                                    </div>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>

                                <input type="hidden" value="" id="rpaid" name="rpaid">
                            </div>  
                            <button style=" display: none;" class="btn btn-success" type="submit" id="rpamst_update" name="rpamst_update">Update</button>
                            <button class="btn btn-primary" type="submit" id="rpamst_create" name="rpamst_create">Submit</button>
                            <button class="btn btn-warning" type="reset" name="reset">Clear</button>
                            <button class="btn btn-danger" type="button" id="cancelbtn" onclick="cancelproj()" name="cancel_form">Cancel</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- End Row -->
        <div class="form-group row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];
                } else {
                    $msg = '';
                }if ($msg == '0') {
                    ?>
                    <div class="alert alert-danger alert-rounded">  
                        <i class="fa fa-exclamation-triangle"></i> Same RPA number already exists 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    </div>
                <?php } else if ($msg == '1') { ?>
                    <div class="alert alert-danger alert-rounded">  
                        <i class="fa fa-exclamation-triangle"></i>RPA number does not exists 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    </div>
                <?php }
                ?>
            </div>
        </div>
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Vendor</th>
                                        <th>RPA Number</th>
                                        <th>BANK Name</th>
                                        <th>RPA Date</th>
                                        <th>Validity</th>
                                        <th>Days Left</th>
                                                                             
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_rpamaster();
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $value['sup_name']; ?></td>                                       
                                            <td><?php echo $value['rpa_num']; ?></td>
                                            <td><?php echo $value['rpa_bank']; ?></td>
                                            <td><?php echo formatDate($value['rpa_date'], 'd-M-y'); ?></td>                                            
                                            <td>
                                                <span class="badge badge-pill badge-primary font-medium text-white ml-1"  style=" cursor: pointer;" >
                                                    From:- <?php echo formatDate($value['rpa_from'], 'd-M-y'); ?>
                                                </span>
                                                <span class="badge badge-pill badge-danger font-medium text-white ml-1"  style=" cursor: pointer;" >
                                                    To:- <?php echo formatDate($value['rpa_to'], 'd-M-y'); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $daycount = $value['validity'];
                                                if ($daycount <= 7) {
                                                    $alert = "";
                                                    $point = "";
                                                } elseif ($daycount > 7) {
                                                    $alert = "greenotify";
                                                    $point = "greenpoint";
                                                }
                                                ?>
                                                <div class="notify pull-left">
                                                    <span class="heartbit <?php echo $alert; ?>"></span>
                                                    <span class="point <?php echo $point ?>" ></span>
                                                </div>
                                                <?php echo $value['validity']; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-pill badge-danger font-medium text-white ml-1" onclick="changerpa('<?php echo $value['rpa_id']; ?>')"    style=" cursor: pointer;" > <i class=" fas fa-pencil-alt"></i></span>
                                            </td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>
<script src="code/js/finance.js" type="text/javascript"></script>
<script src="code/js/technical.js" type="text/javascript"></script>
<script>
                                                    function getlc(a, b) {
                                                        var getid = a;
                                                        var pack_id = b;
                                                        $("#lc_row_id").val(getid);
                                                        $("#lc_pack_id").val(pack_id);
                                                        $.post("functions/getlcdatas.php", {key: pack_id}, function (data) {
                                                            var planned_date = JSON.parse(data).planned_date;
                                                            var mat_req_date = JSON.parse(data).mat_req_date;
                                                            var proj_name = JSON.parse(data).proj_name;
                                                            var packagename = JSON.parse(data).packagename;
                                                            var po_num = JSON.parse(data).po_num;
                                                            var wo_num = JSON.parse(data).wo_num;
                                                            $('#planned_date').html(planned_date);
                                                            $('#mat_req_date').html(mat_req_date);
                                                            $("#proj").html(proj_name);
                                                            $("#pack").html(packagename);
                                                            $("#lpo_number").val(po_num);
                                                            $("#lwo_number").val(wo_num);
                                                        });
                                                    }

                                                    function swift_proj(Proid) {
                                                        window.location.href = "lc_page?pid=" + Proid;
                                                    }

</script>


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 