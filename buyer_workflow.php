<?php
  include_once('layout/header.php');
  include_once('layout/nav.php');
  include_once('layout/leftsidebar.php');
  ?>
  <style>
  #modeltable.display thead th {
    padding: 8px 18px 8px 10px;
    border: 1px solid black;
    font-weight: bold;
    cursor: pointer;
    /* background-color:#2cabe3; */
    background-color:#0284c0;
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
        <h5 class="font-medium text-uppercase mb-0">Buyer Work Flow</h5>
      </div>
      <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
          <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buyer Work Flow</li>
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
                    <th>Current Status</th> 
                    <th>Sent</th>
                    <th>Sent Date</th>
                    <th>Planned</th>
                    <th>Actual</th>
                    <th>Remarks</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Tiger Nixon</td>
                    <td>
                      <div class="notify pull-left">
                        <span class="heartbit"></span>
                        <span class="point" ></span>
                      </div>
                      Package Name
                    </td>
                    <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Current Status</span></td>
                    <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Sent from</span></td>
                    <td>2011/04/25</td>
                    <td>2011/04/25</td>
                    <td>2011/04/25</td>
                    <td><label class="badge badge-pill badge-success font-medium text-white ml-1"    data-toggle="tooltip"  data-original-title="CTO Remarks" style=" cursor: pointer;" 
                      onclick="swal('This is the remarks from CTO');"><i class="fas fa-inbox"></i> Remarks</label></td>
                    <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-paper-plane"></i> </span>
                    <span class="badge badge-pill badge-primary font-medium text-white ml-1"  alt="default" data-toggle="modal" data-target="#model_edit" class="model_img img-fluid" ><i class="fas fa-pencil-alt"></i></span>
                        <span class="badge badge-pill badge-primary font-medium text-white ml-1"  alt="default" data-toggle="modal" data-target="#model_view" class="model_img img-fluid" ><i class="fas fa-eye"></i></span>
                    </td>
                  </tr>
                  <tr>
                    <td>Tiger Nixon</td>
                    <td>
                      <div class="notify pull-left">
                        <span class="heartbit greenotify" ></span>
                        <span class="point greenpoint" ></span>
                      </div>
                      Package Name
                    </td>
                    <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Current Status</span></td>
                    <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Sent from</span></td>
                    <td>2011/04/25</td>
                    <td>2011/04/25</td>
                    <td>2011/04/25</td>
                    <td><label class="badge badge-pill badge-success font-medium text-white ml-1"    data-toggle="tooltip"  data-original-title="CTO Remarks" style=" cursor: pointer;" 
                      onclick="swal('This is the remarks from CTO');"><i class="fas fa-inbox"></i> Remarks</label></td>
                    <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-paper-plane"></i> </span>
                    <span class="badge badge-pill badge-primary font-medium text-white ml-1"  alt="default" data-toggle="modal" data-target="#model_edit" class="model_img img-fluid" ><i class="fas fa-pencil-alt"></i></span>
                        <span class="badge badge-pill badge-primary font-medium text-white ml-1"  alt="default" data-toggle="modal" data-target="#model_view" class="model_img img-fluid" ><i class="fas fa-eye"></i></span>
                    </td>
                  </tr>
                  <tr>
                    <td>Tiger Nixon</td>
                    <td>
                      <div class="notify pull-left">
                        <span class="heartbit bluenotify"></span>
                        <span class="point bluepoint" ></span>
                      </div>
                      Package Name
                    </td>
                    <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Current Status</span></td>
                    <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Sent from</span></td>
                    <td>2011/04/25</td>
                    <td>2011/04/25</td>
                    <td>2011/04/25</td>
                    <td><label class="badge badge-pill badge-success font-medium text-white ml-1"    data-toggle="tooltip"  data-original-title="CTO Remarks" style=" cursor: pointer;" 
                      onclick="swal('This is the remarks from CTO');"><i class="fas fa-inbox"></i> Remarks</label></td>
                    <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-paper-plane"></i> </span>
                    <span class="badge badge-pill badge-primary font-medium text-white ml-1"  alt="default" data-toggle="modal" data-target="#model_edit" class="model_img img-fluid" ><i class="fas fa-pencil-alt"></i></span>
                        <span class="badge badge-pill badge-primary font-medium text-white ml-1"  alt="default" data-toggle="modal" data-target="#model_view" class="model_img img-fluid" ><i class="fas fa-eye"></i></span>
                    </td>
                  </tr>
                  <tr>
                    <td>Tiger Nixon</td>
                    <td>
                      <div class="notify pull-left">
                        <span class="heartbit"></span>
                        <span class="point" ></span>
                      </div>
                      Package Name
                    </td>
                    <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Current Status</span></td>
                    <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Sent from</span></td>
                    <td>2011/04/25</td>
                    <td>2011/04/25</td>
                    <td>2011/04/25</td>
                    <td><label class="badge badge-pill badge-success font-medium text-white ml-1"    data-toggle="tooltip"  data-original-title="CTO Remarks" style=" cursor: pointer;" 
                      onclick="swal('This is the remarks from CTO');"><i class="fas fa-inbox"></i> Remarks</label></td>
                    <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-paper-plane"></i> </span>
                    <span class="badge badge-pill badge-primary font-medium text-white ml-1"  alt="default" data-toggle="modal" data-target="#model_edit" class="model_img img-fluid" ><i class="fas fa-pencil-alt"></i></span>
                        <span class="badge badge-pill badge-primary font-medium text-white ml-1"  alt="default" data-toggle="modal" data-target="#model_view" class="model_img img-fluid" ><i class="fas fa-eye"></i></span>
                    </td>
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
              <h4 class="modal-title" id="exampleModalLabel1">Project - <small>Package Name</small></h4>
              <div class="row" id="daterow">
                <div class=" col-md-6" id="pd">
                  <small>Planned Date:- <span class="badge badge-pill badge-dark font-medium text-white ml-1"><?php echo date('d-M-y'); ?></span></small>                           
                </div>
                <div class=" col-md-6" id="ps">
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
              </div>
              <div class="row">
                <label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left"    data-toggle="tooltip"  data-original-title="O&M  Remarks" style=" cursor: pointer;" 
                  onclick="swal({html: true, title: 'Remarks', text: 'This is the remarks from O&M'});"><i class="fas fa-inbox"></i> O&M Remarks</label>
                <label class="badge badge-pill badge-dark font-medium text-white ml-1 pull-left"    data-toggle="tooltip"  data-original-title="O&M  Previous Remarks" style=" cursor: pointer;" 
                  onclick="swal({html: true, title: 'CTO Remarks', text: '<?php echo $msg; ?>'});"><i class="fas fa-inbox"></i> Prev. O&M  Remarks</label>
              </div>
              <div class="row">    
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

      <div class="modal fade bs-example-modal-lg" id="model_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="width:116%;margin-left:-8%;margin-top:-2%; ">
                <div class="modal-header">
                    <h6 class="modal-title" id="myLargeModalLabel">PO Details Entry</h6> 
                    <h3 style=" margin-left:35%; font-size: 16px; text-transform: uppercase; ">Project name</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" style="height:500px">
                        <table class="table table-bordered display compact" id="modeltable">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th colspan="4">Package name Name</th>
                                    <th colspan="4">Po Number</th>
                                </tr>
                                <tr>
                                    <th>S.No</th>
                                    <th>Description</th>
                                    <th>Po Qty</th>
                                    <th>Bal Qty</th>
                                    <th>Manufacture Clear Qty</th>
                                    <th>Ins Qty</th>
                                    <th>MDCC Qty</th>
                                    <th>Mat Rec Qty</th>
                                </tr>
                            </thead>
                            <tbody class="border border-info">
                                <?php for($i=1;$i<=30;$i++){?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo "desc" . $i?></td>
                                    <td><?php echo $i+10?></td>
                                    <td></td>
                                    <td  style=" text-align: center;"><input type="text" style="width:100px" id="mqty"  contenteditable="true" value=""></td>
                                    <td  style=" text-align: center;"><input type="text" style="width:100px" id="iqty"  value=""> </td> 
                                    <td  style=" text-align: center;"><input type="text" style="width:100px"  id="mdccqty" value=""></td>
                                    <td  style=" text-align: center;"> <input type="text" style="width:100px"  id="cclr_qty" value=""></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade bs-example-modal-lg" id="model_view" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="width:116%;margin-left:-8%;margin-top:-2%;">
                <div class="modal-header">
                    <h6 class="modal-title" id="myLargeModalLabel">PO Details Entry</h6> 
                    <h3 style=" margin-left:35%; font-size: 16px; text-transform: uppercase; ">Project name</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" style="height:500px">
                        <table class="table table-bordered display compact" id="modeltable">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th colspan="6">Package name Name</th>
                                    <th colspan="5">Po Number</th>
                                </tr>
                                <tr>
                                    <th>S.No</th>
                                    <th>Description</th>
                                    <th>Item Code</th>
                                    <th>Rate</th>
                                    <th>Po Qty</th>
                                    <th>View</th>
                                    <th>Manufacture Clear Qty</th>
                                    <th>Ins Qty</th>
                                    <th>MDCC Qty</th>
                                    <th>Custom Clr. Qty</th>
                                    <th>Mat Rec Qty</th>
                                </tr>
                            </thead>
                            <tbody class="border border-info">
                                <?php for($i=1;$i<=30;$i++){?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo "desc" . $i?></td>
                                    <td><?php echo "Code" . $i?></td>
                                    <td><?php echo $i+1000?></td>
                                    <td><?php echo $i+10?></td>
                                    <td><label class="badge badge-pill badge-info font-medium text-white ml-1 pull-left" data-toggle="modal" data-target="#myModal1"><i  class=" fa fa-eye"></i></label></td>
                                    <td style="text-align:center"></td>
                                    <td style="text-align:center"></td>
                                    <td style="text-align:center"></td>
                                    <td style="text-align:center"></td>
                                    <td style="text-align:center"></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="myModal1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content" style="width:120%;">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel1">Entry Dates</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-bordered display compact" id="modeltable">
                  <thead class="bg-info text-white">
                      <tr>
                          <th>SI.No</th>
                          <th>Actions</th>
                          <th>Qty</th>
                          <th>Date</th>
                      </tr>
                  </thead>
                  <tbody class="border border-info">
                      <?php for($i=1;$i<=5;$i++){?>
                      <tr>
                          <td><?php echo $i?></td>
                          <td><?php echo "desc" . $i?></td>
                          <td><?php echo $i+10?></td>
                          <td>25-09-2019</td>
                      </tr>
                      <?php }?>
                  </tbody>
              </table>
          </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-danger btn-rounded"  data-dismiss="modal"> &times; Close</button>
              <!-- <button type="button" class="btn btn-outline-success btn-rounded">Allocate</button> -->
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