<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';
$segment = $_SESSION['swift_dep'];
$generate_token = generate_token();
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
} else {
    $pid = "";
}
?>
<style>

    .card-body {
        flex: 1 1 auto;
        padding: 1.57rem;
    }
</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Package Category Master</h5>
            </div>
            <!-- <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">                
                <select class="custom-select" name="proj_Filter" id="proj_Filter" onchange="proj_Filter(this.value, '4')" required="">
                    <option value="">--Select Project--</option>
                    <?php
                    $result = $cls_comm->select_allprojects_seg($segment);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id'] ) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div> -->
            <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Package Category Master</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="page-content container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->

        <div class="row" id="package_create" style="display: none;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="tab_select">
                        <!-- <h4 class="card-title">Package Creation Form</h4> -->

                        <div class="tab-content border p-4" style=" margin-top: 3%">

                            <div class="row" >
                                <form class="needs-validation" novalidate method="post" action="functions/package_category_form.php" autocomplete="off">
                                    <input type="hidden" name="page_name" value="masters">
                                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />

                                    <div class="form-row">

                                        <div class="col-md-6 mb-6">
                                            <label for="proj_name">Package Category Name</label>
                                            <input type="text" list="browsers" class="form-control" id="pack_cat_name"  name="pack_cat_name" placeholder="package Name" value="" required>
                                            <div class="invalid-feedback">

                                            </div>
                                            <datalist id="browsers">
                                                <?php
                                                $result = $cls_comm->select_allpackagescatte();
                                                $res = json_decode($result, true);
                                                foreach ($res as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value['pc_pack_cat_name'] ?>"><?php echo $value['pc_pack_cat_name'] ?></option>
                                                <?php } ?>
                                            </datalist>

                                        </div>

                                        <div class="col-md-6 mb-6">
                                            <label for="start_date">Lead Time in Days</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="lead_time" name="lead_time" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="" placeholder="Lead Time in Days">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                    </div>  <br>                       
                                    <button class="btn btn-primary" type="submit" name="package_cat_create">Submit</button>
                                    <button class="btn btn-warning" type="reset" name="reset">Clear</button>
                                    <button class="btn btn-danger" type="button" id="cancelbtn" onclick="cancelpackage()" name="cancel_form">Cancel</button>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <i class="fa fa-exclamation-triangle"></i> Package Category Alreday Exists
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
                        <h4 class="card-title">Package Category Master</h4>
                        <div class=" pull-right" id="proj_button"><button class="btn btn-primary" type="button" onclick="create_newproj();" ><i class="icon-plus"></i> &nbsp;Create New</button></div>
                

                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered border">
                                <thead>
                                    <tr>
                                        <th>Si No</th>
                                        <th>Package Category</th>                             
                                        <th>Lead Time</th>                                       
<!--                                        <th>Action</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_allpackagescatte();
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $key+1; ?></td>
                                            <td><?php echo $value['pc_pack_cat_name'] ?></td>                                             
                                            <td><?php echo $value['pc_leadtime']; ?></td>
                                            <!--<td><span onclick="view_reports('<?php echo $value['pc_id']; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="View Details"><i class="fas fa-eye"></i> View</span></td>-->
                                        </tr> 
                                    <?php }
                                    ?>


                                </tbody>

                            </table>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <?php
    include_once('layout/foot_banner.php');
    ?>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script src="code/js/ops.js" type="text/javascript"></script>
<script>
                            function create_newproj() {
                                $('#package_create').show()
                            }
                            function cancelpackage() {
                                $('#package_create').hide()
                            }
</script>