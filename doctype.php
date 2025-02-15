<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';
$segment = $_SESSION['swift_dep'];
$generate_token= generate_token();
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
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium te/Internal </h5>
xt-uppercase mb-0">Doc Type Bid            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">                
               
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Doc Type Bid/Internal </li>
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
                                <form class="needs-validation" novalidate method="post" action="functions/documentsetting.php" autocomplete="off">
                                    
                                    <div class="form-row">
                                         <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />

                                        <input type="hidden" name="dt_id" id="dt_id" value="">
                                        <div class="col-md-12 mb-12">
                                            <label for="dt_doctype">Doc Type Code</label>
                                            <input type="text"   class="form-control" maxlength="3" id="dt_doctype"  name="dt_doctype" placeholder="Doc Type Code" value="" required>
                                            <div class="invalid-feedback">

                                            </div>
                                           

                                        </div>
                                        <div class="col-md-12 mb-12">
                                            <label for="dt_docname">Doc Type Name</label>
                                            <input type="text"   class="form-control" maxlength="200" id="dt_docname"  name="dt_docname" placeholder="Doc Type Name" value="" required>
                                            <div class="invalid-feedback">

                                            </div>
                                           

                                        </div>

                                         
                                    </div>  <br> 
                                    <button class="btn btn-success" style=" display: none;" type="submit" id="dt_update" name="dt_update">Update</button>
                                    <button class="btn btn-primary" type="submit" id="dt_create" name="dt_create">Submit</button>
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
                        <i class="fa fa-exclamation-triangle"></i> Doc Type Bid/Internal already exsists
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    </div>
                <?php } else if($msg == '0'){ ?>
                      <div class="alert alert-danger alert-rounded">  
                        <i class="fa fa-exclamation-triangle"></i> Doc Type Bid/Internal  already exsists
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
                        <h4 class="card-title">Doc Type Bid/Internal</h4>
                        <div class=" pull-right" id="proj_button"><button class="btn btn-primary" type="button" onclick="create_newproj();" ><i class="icon-plus"></i> &nbsp;Create New</button></div>


                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered border">
                                <thead>
                                    <tr>
                                        <th>Si No</th>
                                        <th>Doc Type Code</th>                             
                                        <th>Doc Type Name</th>                             
                                                                                
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $super_admin->select_doctype();
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $value['dt_doctype'] ?></td>                                             
                                            <td><?php echo $value['dt_docname'] ?></td>                                             
                                             
                                            <td>
                                                <span onclick="view_docmst('<?php echo $value['dt_id']; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  style=" cursor: pointer;" data-toggle="tooltip" ><i class="fas fa-edit"></i> Edit</span>
                                              <!--<a href="functions/package_category_form?catid=<?php // echo $value['pc_id']; ?>">-->  
                                                  <span onclick="delete_docmst('<?php echo $value['dt_id']; ?>')" class="badge badge-pill badge-danger font-medium text-white ml-1"  style=" cursor: pointer;" data-toggle="tooltip" >
                                                     <i class="fas fa-trash"></i> Delete
                                                
                                                </span>
                                              <!--</a>-->

                                            </td>
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
<script src="code/js/docsetting.js" type="text/javascript"></script>
<script>
                                                function create_newproj() {
                                                    $('#package_create').show()
                                                }
                                                function cancelpackage() {
                                                    $('#package_create').hide()
                                                }
</script>