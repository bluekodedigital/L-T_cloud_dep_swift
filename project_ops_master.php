<?php
include 'config/inc.php';
if (isset($_GET['id'])) {
    $eid = $_GET['id'];
} else {
    $eid = "";
}
if (isset($_GET['del'])) {
    
}
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
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
                <h5 class="font-medium text-uppercase mb-0">Project Master</h5>
            </div>
            <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Project Master</li>
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

        <div class="row" id="project_create" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Validation Form</h4>-->
                        <form class="needs-validation" method="post" action="functions/conhead_form.php">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="proj_name">Project Short name</label>
                                    <input type="text" class="form-control" id="proj_name"  name="proj_name" placeholder="Project Name" value="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="proj_shrtname">Project name</label>
                                    <input type="text" class="form-control" id="proj_shrtname" name="proj_shrtname" placeholder="Short Name" value="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="segment">Project Segment</label>
                                    <select class="custom-select" name="segment" id="segment" required="">
                                        <option value="">--Select Segment--</option>
                                        <?php
                                        $result = $cls_comm->select_segment();
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['seg_pid'] ?>"><?php echo $value['seg_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="proj_location">Project Location</label>
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="proj_location" name="proj_location" placeholder="Project Location" aria-describedby="inputGroupPrepend" required>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="proj_address">Project Address</label>
                                    <input type="text" class="form-control" id="proj_address" name="proj_address" placeholder="Project Address" value="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>



                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="start_date">Start Date</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                        <input type="text" class="form-control mydatepicker" id="start_date" name="start_date" required="" placeholder="dd/mmm/yyyy">

                                    </div>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="end_date">End Date</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                        <input type="text" class="form-control mydatepicker" id="end_date" name="end_date" required="" placeholder="dd/mmm/yyyy">

                                    </div>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="revend_date">Revised End Date</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                        <input type="text" class="form-control mydatepicker" id="revend_date" name="revend_date" required="" placeholder="dd/mmm/yyyy">

                                    </div>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="handing_over_remarks">Handing Over Remarks</label>
                                    <input type="text" class="form-control" id="handing_over_remarks" name="h_o_remarks" placeholder="Handing Over Remarks" value="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                            </div> 



                            <div class=" col-md-12 mb-3" style="">
                                <div class=" col-md-8 mb-3" style=" float: left;     margin-left: -15px;   border: 1px solid black;">

                                    <div class=" row" style=" padding: 2px;">
                                        <div class="col-md-4 mb-3">
                                            <label for="start_date">Client LOI</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="client_loi" name="client_loi"   placeholder="dd/mmm/yyyy">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="end_date">Contract Agreement</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="cont_agree" name="cont_agree"  placeholder="dd/mmm/yyyy">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="revend_date">Kick Off Meeting</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="kick_meet" name="kick_meet"   placeholder="dd/mmm/yyyy">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="start_date">Techno Commercial Handing Over to Operations</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="tech_comer" name="tech_comer"  placeholder="dd/mmm/yyyy">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="end_date">Tender Costing Handing Over to Operations</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="tech_cost" name="tech_cost"   placeholder="dd/mmm/yyyy">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <div class=" col-md-4 mb-3" style=" float: right; height: 13.45em; border: 1px solid black;">

                                    <div class="col-md-12 mb-3" style=" padding: 2px;">
                                        <label for="start_date">ACE Sheet Submission</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="ace_sub" name="ace_sub"   placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="end_date">ACE Sheet Approved</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="ace_sheet" name="ace_sheet"   placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>


                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit" name="project_create">Submit</button>
                            <button class="btn btn-warning" type="reset" name="reset">Clear</button>
                            <button class="btn btn-danger" type="button" id="cancelbtn" onclick="cancelproj()" name="cancel_form">Cancel</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <?php if ($eid != "") { ?>

            <div class="row" id="project_edit">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!--                        <h4 class="card-title">Validation Form</h4>-->
                            <form class="needs-validation" method="post" action="functions/conhead_form.php">
                                <input type="hidden" id="pname" name="pname" value="opspname">

                                <?php
                                $result = $cls_comm->select_projects($eid);
                              
                                $res = json_decode($result, true);
                                foreach ($res as $key => $value) {
                                    ?>
                                    <div class=" col-md-12 mb-3" style="    margin-left: -7px;   border: 1px solid #b2c0ce;     padding: 10px;">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="proj_name">Project Short name</label>
                                                <input type="text" readonly class="form-control" id="proj_name"  name="proj_name"  value="<?php echo $value['proj_name'] ?>" required>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="proj_shrtname">Project name</label>
                                                <input type="text" readonly class="form-control" id="proj_shrtname" name="proj_shrtname" value="<?php echo $value['shortcode'] ?>" required>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="segment">Project Segment</label>
                                                <select  readonly class="custom-select" name="segment" id="segment" required="">
                                                    <option value="">--Select Segment--</option>
                                                    <?php
                                                    $result = $cls_comm->select_segment();
                                                    $res = json_decode($result, true);
                                                    foreach ($res as $key => $val) {
                                                        if ($val['seg_pid'] == $value['cat_id']) {
                                                            $msg = "selected";
                                                        } else {
                                                            $msg = "";
                                                        }
                                                        ?>
                                                        <option value="<?php echo $val['seg_pid'] ?>" <?php echo $msg ?>><?php echo $val['seg_name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="proj_location">Project Location</label>
                                                <div class="input-group">

                                                    <input type="text" readonly class="form-control" id="proj_location" name="proj_location"  value="<?php echo $value['location'] ?>" required>
                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <label for="proj_address">Project Address</label>
                                                <input type="text" readonly class="form-control" id="proj_address" name="proj_address" value="<?php echo $value['address'] ?>" required>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="start_date">Start Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <?php
                                                    $sdate = date_create($value['proj_created_date']);
                                                    $sdate = date_format($sdate, "d/M/y");
                                                    if($sdate=='01/Jan/70')
                                                        {
                                                         $sdate="";   
                                                        }else
                                                        {
                                                         $sdate=$sdate;   
                                                        }
                                                    ?>
                                                    <input type="text" readonly class="form-control mydatepicker" id="start_date" name="start_date" required="" value="<?php echo $sdate ?>">

                                                </div>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="end_date">End Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <?php
                                                    $edate = date_create($value['proj_edate']);
                                                    $edate = date_format($edate, "d/M/y");
                                                      if($edate=='01/Jan/70')
                                                        {
                                                         $edate="";   
                                                        }else
                                                        {
                                                         $edate=$edate;   
                                                        }
                                                    ?>
                                                    <input type="text" readonly class="form-control mydatepicker" id="end_date" name="end_date" required="" value="<?php echo $edate ?>">

                                                </div>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="revend_date">Revised End Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <?php
                                                    $rdate = date_create($value['proj_revised_edate']);
                                                    $rdate = date_format($rdate, "d/M/y");
                                                       if($rdate=='01/Jan/70')
                                                        {
                                                         $rdate="";   
                                                        }else
                                                        {
                                                         $rdate=$rdate;   
                                                        }
                                                    ?>
                                                    <input type="text" class="form-control mydatepicker" id="revend_date" name="revend_date" required="" value="<?php echo $rdate ?>">

                                                </div>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="handing_over_remarks">Handing Over Remarks</label>
                                                <input type="text" readonly class="form-control" id="handing_over_remarks" name="h_o_remarks" value="<?php echo $value['hand_over_remarks'] ?>" required>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>

                                        </div>   
                                    </div>
                                    <div class=" col-md-12 mb-3" style="">
                                        <div class=" col-md-8 mb-3" style=" float: left;     margin-left: -22px;   border: 1px solid #b2c0ce; padding: 10px;">

                                            <div class=" row" style=" padding: 10px;">
                                                <div class="col-md-4 mb-3">
                                                    <label for="start_date">Client LOI Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                        </div>
                                                        <?php
                                                        
                                                        $client_loi = date_create($value['client_loi']);
                                                        $client_loi = date_format($client_loi, "d/M/y");
                                                        if($client_loi=='01/Jan/70')
                                                        {
                                                         $client_loi="";   
                                                        }else
                                                        {
                                                         $client_loi=$client_loi;   
                                                        }
                                                        
                                                        ?>
                                                        <input type="hidden" value="<?php echo $value['client_loi']."-".$client_loi;  ?>">
                                                        <input type="text" readonly value="<?php echo $client_loi; ?>" class="form-control mydatepicker" id="client_loi" name="client_loi"   placeholder="dd/mmm/yyyy">

                                                    </div>
                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="end_date">Contract Agreement Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                        </div>
                                                        <?php
                                                        $cont_agree = date_create($value['cont_agree']);
                                                        $cont_agree = date_format($cont_agree, "d/M/y");
                                                             if($cont_agree=='01/Jan/70')
                                                        {
                                                         $cont_agree="";   
                                                        }else
                                                        {
                                                         $cont_agree=$cont_agree;   
                                                        }
                                                        ?>
                                                        <input type="text" readonly value="<?php echo $cont_agree; ?>" class="form-control mydatepicker" id="cont_agree" name="cont_agree"  placeholder="dd/mmm/yyyy">

                                                    </div>
                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3" style=" display: none;">
                                                    <label for="revend_date">Kick Off Meeting Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                        </div>
                                                        <?php
                                                        $kick_meet = date_create($value['kick_meet']);
                                                        $kick_meet = date_format($kick_meet, "d/M/y");
                                                           if($kick_meet=='01/Jan/70')
                                                        {
                                                         $kick_meet="";   
                                                        }else
                                                        {
                                                         $kick_meet=$kick_meet;   
                                                        }
                                                        ?>
                                                        <input type="text" readonly value="<?php echo $kick_meet; ?>" class="form-control mydatepicker" id="kick_meet" name="kick_meet"   placeholder="dd/mmm/yyyy">

                                                    </div>
                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3" style=" display: none;">
                                                    <label for="start_date">Techno Commercial Handing Over to Operations</label>
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                        </div>
                                                        <?php
                                                        $tech_comer = date_create($value['tech_comer']);
                                                        $tech_comer = date_format($tech_comer, "d/M/y");
                                                          if($tech_comer=='01/Jan/70')
                                                        {
                                                         $tech_comer="";   
                                                        }else
                                                        {
                                                         $tech_comer=$tech_comer;   
                                                        }
                                                        ?>
                                                        <input type="text" readonly value="<?php echo $tech_comer; ?>" class="form-control mydatepicker" id="tech_comer" name="tech_comer"  placeholder="dd/mmm/yyyy">

                                                    </div>
                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="end_date">Tender Costing Hand Over to Ops</label>
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                        </div>
                                                        <?php
                                                        $tech_cost = date_create($value['tech_cost']);
                                                        $tech_cost = date_format($tech_cost, "d/M/y");
                                                          if($tech_cost=='01/Jan/70')
                                                        {
                                                         $tech_cost="";   
                                                        }else
                                                        {
                                                         $tech_cost=$tech_cost;   
                                                        }
                                                        ?>
                                                        <input type="text" readonly value="<?php echo $tech_cost; ?>" class="form-control mydatepicker" id="tech_cost" name="tech_cost"   placeholder="dd/mmm/yyyy">

                                                    </div>
                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class=" col-md-4 mb-3" style=" float: right; height: 16em; border: 1px solid #b2c0ce; padding: 17px;     margin-right: -0.8%;">


                                            <div class="col-md-12 mb-3">
                                                <label for="start_date">ACE Submission</label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <?php
                                                    $ace_sub = date_create($value['ace_sub']);
                                                    $ace_sub = date_format($ace_sub, "d/M/y");
                                                     if($ace_sub=='01/Jan/70')
                                                        {
                                                         $ace_sub="";   
                                                        }else
                                                        {
                                                         $ace_sub=$ace_sub;   
                                                        }
                                                    
                                                    ?>
                                                    <input type="text" value="<?php echo $ace_sub; ?>" class="form-control mydatepicker" id="ace_sub" name="ace_sub"   placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="end_date">ACE Approved  </label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <?php
                                                    $ace_sheet = date_create($value['ace_sheet']);
                                                    $ace_sheet = date_format($ace_sheet, "d/M/y");
                                                       if($ace_sheet=='01/Jan/70')
                                                        {
                                                         $ace_sheet="";   
                                                        }else
                                                        {
                                                         $ace_sheet=$ace_sheet;   
                                                        }
                                                    ?>
                                                    <input type="text" value="<?php echo $ace_sheet; ?>" class="form-control mydatepicker" id="ace_sheet" name="ace_sheet"   placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <input type="hidden" name="proj_id" id="proj_id" value="<?php echo $eid ?>">
                                <?php } ?>                     
                                <button class="btn btn-primary" type="submit" name="project_update">Update</button>
                                <!-- <button class="btn btn-warning" type="reset" name="reset">Clear</button> -->
                                <button class="btn btn-danger" type="button" id="cancelbtn" onclick="proj_editclose()" name="cancel_form">Cancel</button>
                                <br><br>
                                <div class=" col-md-12 mb-3"  style=" float: left; margin-left: -7px; ">
                                    <div class=" col-md-12 mb-3" >
                                        <span class="pull-left">Handing over Start Date: <span class="badge badge-success orange"><?php
                                                $filldates = $cls_comm->filldates(1, $eid);
                                                if ($filldates['cd_date'] != "") {
                                                    echo formatDate($filldates['cd_date'], 'd-M-Y');
                                                }
                                                ?></span></span>
                                        <span class="pull-right"> Handing over End Date:<label class="badge badge-success brown"> <?php
                                                $filldates = $cls_comm->filldates(10, $eid);
                                                if ($filldates['cd_date'] != "") {
                                                    echo formatDate($value['cd_date'], 'd-M-Y');
                                                }
                                                ?></label></span>
                                    </div>
                                    <table class=" table table-bordered">
                                        <thead>
                                        <th> S.No</th>
                                        <th> Documents</th>
                                        <th>Handing Over Completed</th>
                                        <th>Date of Handing Over</th>
                                        <th>Attachments</th>
                                        <th>Status</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = $cls_comm->select_ckaddon();
                                            $res = json_decode($result, true);
                                            foreach ($res as $key => $value) {
                                                $filldates = $cls_comm->filldates($value['ck_id'], $eid);
                                                ?>
                                                <tr>
                                                    <td><?php echo $key + 1; ?></td>
                                                    <td><?php echo $value['ck_name']; ?></td>
                                                    <td>
                                                        <?php if ($filldates['cd_completed'] != "") { ?>
                                                            <div class="form-check form-check-inline ">
                                                                <?php if ($filldates['cd_completed'] == 1) { ?>
                                                                    <div class="custom-control custom-radio ">
                                                                        <input type="radio" class="custom-control-input pointer ra_but<?php echo $value['ck_id']; ?>" value="1" disabled="" checked id="customControlValidation1<?php echo $value['ck_id']; ?>" name="radioname<?php echo $value['ck_id']; ?>">
                                                                        <label class="custom-control-label" onclick="handover_show('<?php echo $value['ck_id']; ?>')" for="customControlValidation1<?php echo $value['ck_id']; ?>">Yes</label>
                                                                    </div>

                                                                <?php } if ($filldates['cd_completed'] == 0) { ?>

                                                                    <div class="custom-control custom-radio" style="margin-left:18% !important;">
                                                                        <input type="radio" class="custom-control-input pointer ra_but<?php echo $value['ck_id']; ?>" disabled value="0" checked id="customControlValidation2<?php echo $value['ck_id']; ?>" name="radioname<?php echo $value['ck_id']; ?>">
                                                                        <label class="custom-control-label" onclick="handover_hide('<?php echo $value['ck_id']; ?>')" for="customControlValidation2<?php echo $value['ck_id']; ?>">No</label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } else { ?>
                                                            <!--                                                            <div class="form-check form-check-inline ">
                                                                                                                            <div class="custom-control custom-radio ">
                                                                                                                                <input type="radio" class="custom-control-input pointer ra_but<?php echo $value['ck_id']; ?>" value="1" id="customControlValidation1<?php echo $value['ck_id']; ?>" name="radioname<?php echo $value['ck_id']; ?>">
                                                                                                                                <label class="custom-control-label" onclick="handover_show('<?php echo $value['ck_id']; ?>')" for="customControlValidation1<?php echo $value['ck_id']; ?>">Yes</label>
                                                                                                                            </div>
                                                                                                                            <div class="custom-control custom-radio" style="margin-left:18% !important;">
                                                                                                                                <input type="radio" class="custom-control-input pointer ra_but<?php echo $value['ck_id']; ?>" value="0" id="customControlValidation2<?php echo $value['ck_id']; ?>" name="radioname<?php echo $value['ck_id']; ?>">
                                                                                                                                <label class="custom-control-label" onclick="handover_hide('<?php echo $value['ck_id']; ?>')" for="customControlValidation2<?php echo $value['ck_id']; ?>">No</label>
                                                                                                                            </div>
                                                                                                                        </div>-->
                                                        <?php }
                                                        ?>

                                                    </td>
                                                    <td> 
                                                        <?php if ($filldates['cd_date'] != "") { ?>
                                                            <input type="text" disabled="" value="<?php formatDate($value['cd_date'], 'd-M-Y'); ?>" style="    width: 65%;" class="mydatepicker " id="date_hover<?php echo $value['ck_id']; ?>" name="date_hover<?php echo $value['ck_id']; ?>"   placeholder="dd/mmm/yyyy">

                                                        <?php } else { ?>
                                                            <input type="text" style="    width: 65%;" class="mydatepicker none" id="date_hover<?php echo $value['ck_id']; ?>" name="date_hover<?php echo $value['ck_id']; ?>"   placeholder="dd/mmm/yyyy">

                                                        <?php }
                                                        ?>


                                                    </td>

                                                    <td class=" doc_view<?php echo $value['ck_id']; ?>">
                                                        <?php if ($filldates['cd_attah'] != "" || $filldates['cd_date'] != "") { ?>
                                                            <?php if ($filldates['cd_attah'] != "") { ?> 
                                                                <span class="badge badge-primary text-center"><a href="uploads/checklists/<?php echo $filldates['cd_attah']; ?>" class=" text-white" target="_blank"><i class="fas fa-eye"></i></a></span>

                                                                <?php
                                                            } else {
                                                                echo 'NA';
                                                            }
                                                            ?>
                                                            <?php if ($filldates['cd_status'] == "0") { ?>
                                                                <span class="badge badge-danger text-center pointer" onclick="sent_back('<?php echo $value['ck_id']; ?>')"><i class="fas fa-arrow-left"></i> Sent Back</span>
                                                                <span class="badge badge-primary text-center pointer" onclick="accept_ck('<?php echo $value['ck_id']; ?>')"><i class="fas fa-paper-plane"></i> Approve</span>

                                                            <?php }
                                                            ?>

                                                        <?php } else { ?>
                                                        <?php }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($filldates['cd_status'] == "1") { ?>
                                                            <span class="badge badge-success text-center pointer">  Completed</span>
                                                        <?php } else if ($filldates['cd_status'] == "2") { ?>
                                                            <span class="badge badge-warning text-center pointer">  Sent Back</span>
                                                        <?php }
                                                        ?>                                  
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <h4 class="card-title">Project Master</h4>
                        <div class=" pull-right" id="proj_button"><button class="btn btn-primary" type="button" onclick="create_newproj();" ><i class="icon-plus"></i> &nbsp;Create New</button></div>

                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered table-striped border">
                                <thead>
                                    <tr>
                                        <th >Project Name</th>

                                        <th>Location</th>
                                        <!--<th>Address</th>-->
                                        <th>Segments</th>
                                        <th>Start</th>
                                        <th>End </th>
                                        <th>Revised</th>
                                        <th>Hand. Over. Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_allprojects();
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $value['proj_name']; ?></td>                                         
                                            <td><?php echo $value['location'] ?></td>
                                            <!--<td><?php // echo $value['address']                       ?></td>-->
                                            <td><?php echo $value['catagories'] ?></td>
                                            <td><?php echo formatDate($value['proj_created_date'], 'd-M-Y'); ?> </td>
                                            <td><?php echo formatDate($value['proj_edate'], 'd-M-Y'); ?></td>
                                            <td><?php echo formatDate($value['proj_revised_edate'], 'd-M-Y'); ?> </td>
                                            <td><label  class="badge badge-pill badge-success font-medium text-white ml-1" onclick="swal('<?php echo $value['hand_over_remarks'] ?>');"><i class=" mdi mdi-comment-check-outline"> </i> View</label></td>
                                            <!-- <td>a</td> -->
                                            <td>
                                                <a href="?id=<?php echo $value['proj_id'] ?>" onclick="return confirm('Are you sure want to Edit this project?')"><i class="mdi mdi-pencil"></i></a>  
                                                <a href="functions/conhead_form?del_proj_id=<?php echo $value['proj_id'] ?>" onclick="return confirm('Are you sure want to delete this project?')"><i class="mdi mdi-delete-forever"></i></a>  
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


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script>
    function create_newproj() {
        $('#project_create').show();
    }
    function cancelproj() {
        $('#project_create').hide();
    }
    function proj_editclose() {
        $('#project_edit').hide();
    }
    function accept_ck(id) {
//        alert(id);
        var person = prompt("Please enter your Remarks", "");
        if (person != null) {
            var projid = $('#proj_id').val();
            $.post("code/accept_ck.php", {projid: projid, id: id, remarks: person}, function (data) {
                if ($.trim(data) == 'success') {
                    alert('saved');
                    window.location.reload(true);
                }

            });
        }

    }
    function sent_back(id) {
        var person = prompt("Please enter your Remarks", "");
        if (person != null) {
            var projid = $('#proj_id').val();
            $.post("code/sent_back_ck.php", {projid: projid, id: id, remarks: person}, function (data) {
                if ($.trim(data) == 'success') {
                    alert('sent back sucessfully');
                  window.location.reload(true);
                }

            });
        }
    }
</script>