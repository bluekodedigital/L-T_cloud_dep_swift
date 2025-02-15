<?php
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
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Files from CTO/O&M/SCM</h5>
            </div>
            <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Files from CTO/O&M/SCM</li>
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



        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>Sent</th>
                                        <th>Sent Date</th>
                                        <th>Planned Date</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td><div class="notify pull-left">
                                                <span class="heartbit"></span>
                                                <span class="point" ></span>
                                            </div>Package Name</td>
                                        <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Sent from</span></td>
                                        <td>25-Jun-2019</td>
                                        <td>25-Jun-2019</td>
                                        <td><label class="badge badge-pill badge-success font-medium text-white ml-1"    data-toggle="tooltip"  data-original-title="CTO Remarks" style=" cursor: pointer;" 
                                                   onclick="swal('This is the remarks from CTO');"><i class="fas fa-inbox"></i> Remarks</label></td>
                                        <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-paper-plane"></i> </span></td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td><div class="notify pull-left">
                                                <span class="heartbit greenotify" ></span>
                                                <span class="point greenpoint" ></span>
                                            </div>Package Name</td>
                                        <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Sent from</span></td>
                                        <td>25-Jun-2019</td>
                                        <td>25-Jun-2019</td>
                                        <td><label class="badge badge-pill badge-success font-medium text-white ml-1"    data-toggle="tooltip"  data-original-title="CTO Remarks" style=" cursor: pointer;" 
                                                   onclick="swal('This is the remarks from CTO');"><i class="fas fa-inbox"></i> Remarks</label></td>
                                        <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-paper-plane"></i> </span></td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td><div class="notify pull-left">
                                                <span class="heartbit bluenotify"></span>
                                                <span class="point bluepoint" ></span>
                                            </div>Package Name</td>
                                        <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Sent from</span></td>
                                        <td>25-Jun-2019</td>
                                        <td>25-Jun-2019</td>
                                        <td><label class="badge badge-pill badge-success font-medium text-white ml-1"    data-toggle="tooltip"  data-original-title="CTO Remarks" style=" cursor: pointer;" 
                                                   onclick="swal('This is the remarks from CTO');"><i class="fas fa-inbox"></i> Remarks</label></td>
                                        <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-paper-plane"></i> </span></td>
                                    </tr>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td><div class="notify pull-left">
                                                <span class="heartbit"></span>
                                                <span class="point" ></span>
                                            </div>Package Name</td>
                                        <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Sent from</span></td>
                                        <td>25-Jun-2019</td>
                                        <td>25-Jun-2019</td>
                                        <td><label class="badge badge-pill badge-success font-medium text-white ml-1"    data-toggle="tooltip"  data-original-title="CTO Remarks" style=" cursor: pointer;" 
                                                   onclick="swal('This is the remarks from CTO');"><i class="fas fa-inbox"></i> Remarks</label></td>
                                        <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-paper-plane"></i> </span></td>
                                    </tr>



                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <!-- sample modal content -->                     
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style=" width: 120%;">
                        <div class="modal-header" style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1"><span>Project -</span> <small>Package Name</small></h4> 

                            <div class="row" id="daterow">
                                <div class=" col-md-4" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-dark font-medium text-white ml-1"><?php echo date('d-M-y'); ?></span></small>                           
                                </div>
                                 <div class=" col-md-4" id="mr">
                                    <small>Material Required:- <span class="badge badge-pill badge-danger font-medium text-white ml-1"><?php echo date('d-M-y'); ?></span></small>                           
                                </div>
                                <div class=" col-md-4" id="ps">
                                    <small>Received From:- <span class="badge badge-pill badge-primary font-medium text-white ml-1">SCM</span></small>                          
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form>  
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="expected_date">Expected</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="end_date" name="expected_date" required="" placeholder="dd/mm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="actual_date">Actual</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="revend_date" name="actual_date" required="" placeholder="dd/mm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                </div>      
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="message-text1"></textarea>
                                </div>
                            </form>
                            <?php
                            $msg = '';
                            for ($i = 0; $i <= 5; $i++) {
                                $msg .= 'Date:-' .'This is the remarks from CTO\n';
                            }
                            //echo $msg;
                            ?>
                            
                            <div class="row">
                                <label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left"    data-toggle="tooltip"  data-original-title="CTO Remarks" style=" cursor: pointer;" 
                                       onclick="swal({html: true, title: 'Remarks', text: 'This is the remarks from CTO'});"><i class="fas fa-inbox"></i> CTO Remarks</label>
                                <label class="badge badge-pill badge-dark font-medium text-white ml-1 pull-left"    data-toggle="tooltip"  data-original-title="CTO Previous Remarks" style=" cursor: pointer;" 
                                       onclick="swal({html: true, title: 'CTO Remarks', text: '<?php echo $msg; ?>'});"><i class="fas fa-inbox"></i> Prev. CTO Remarks</label>
                            </div> <div class="row">
                                <label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left"    data-toggle="tooltip"  data-original-title="O&M  Remarks" style=" cursor: pointer;" 
                                       onclick="swal({html: true, title: 'Remarks', text: 'This is the remarks from O&M'});"><i class="fas fa-inbox"></i> O&M Remarks</label>
                                <label class="badge badge-pill badge-dark font-medium text-white ml-1 pull-left"    data-toggle="tooltip"  data-original-title="O&M  Previous Remarks" style=" cursor: pointer;" 
                                       onclick="swal({html: true, title: 'CTO Remarks', text: '<?php echo $msg; ?>'});"><i class="fas fa-inbox"></i> Prev. O&M  Remarks</label>
                            </div> <div class="row">    
                                <label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left"    data-toggle="tooltip"  data-original-title="SCM  Remarks" style=" cursor: pointer;" 
                                       onclick="swal({html: true, title: 'Remarks', text: 'This is the remarks from SCM'});"><i class="fas fa-inbox"></i> SCM Remarks</label>
                                <label class="badge badge-pill badge-dark font-medium text-white ml-1 pull-left"    data-toggle="tooltip"  data-original-title="SCM  Previous Remarks" style=" cursor: pointer;" 
                                       onclick="swal({html: true, title: 'CTO Remarks', text: '<?php echo $msg; ?>'});"><i class="fas fa-inbox"></i> Prev. SCM Remarks</label>       
                            </div>
                        </div>
                        <div class="modal-footer">

                            <a href="javacript:void(0)" id="sent_back_cto" class="btn-rounded btn btn-outline-danger btn-sm" data-toggle="tooltip"  data-original-title="Send Back to Tech CTO"><i class="ti-close mr-1"></i> Send Back To Tech SPOC</a>
                            <a href="javacript:void(0)"  class="btn btn btn-rounded btn-outline-success mr-2 btn-sm" data-toggle="tooltip"  data-original-title="Send to O&M"><i class="ti-check mr-1"></i>Send to O&M</a>
                            <a href="javacript:void(0)"  class="btn btn btn-rounded btn-outline-primary mr-2 btn-sm" data-toggle="tooltip"  data-original-title="Send to O&M"><i class="ti-check mr-1"></i>Send to SCM</a>

<!--                            <button type="submit" class="btn btn-danger"><i class="fas fa-paper-plane"></i> Send to CTO</button>
<button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send to Tech SPOC</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

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
 