<?php //require_once("dbcon.php");
?>
<!DOCTYPE html>
<html>
<title>L & T SWC Digital</title>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex" />
    <meta name="google-site-verification" content="PeiSj-CnBpMDV3ADnC6KU85H-1zBvocDWpbLmJbY8_8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,700,300,200,100,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC:400,700' rel='stylesheet' type='text/css'>
    <link rel="icon" href="image/favicon.png" type="image/gif" sizes="16x16">
</head>
<link rel="stylesheet" href="style.css">

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="navbar navbar-inverse navbar-fixed-top opaque-navbar">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navMain">
                            <span class="glyphicon glyphicon-chevron-right" style="color:white;"></span>
                        </button>
                        <img class="logo-image" src="image/logo_latest.png" alt="">
                        <ul class="nav navbar-nav navbar-right">
                        <li>
                                <a>
                                    <img src="image/tech_innerv.png" onclick="tech_alert();" alt="" style=" position: relative; height:85px; width:100px; right: 267px !important; cursor:pointer" />
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <a>
                            <img src="image/EHS1_new.png" onclick="open_alert();" alt="" style=" position: relative;width: 16%;height: 80px;float: right; left: 100px !important; cursor:pointer" />
                        </a>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="blue-text">
                                <a href="#" target="blank">
                                    <!-- <img src="image/logo-hotspot.png" alt=" "  style="position: relative;left: 700px;width: 29%;margin-top: -79px; cursor:pointer" />-->
                                    <img src="image/LTTS Blue Logo.png" alt=" " style="position: relative;left: 764px;width: 30%;margin-top: -105px; cursor:pointer" />
                                </a>

                            </li>
                            <!-- <li>
                                <a>
                                    <img src="image/tech_innerv.png" onclick="tech_alert();" alt="" style=" position: relative; height:85px; width:100px; top: -94px !important;right: -1094px !important; cursor:pointer" />
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <section class="banner1">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php
                        // $sql = "select * from banner_img where img_status=1 order by dis_order ASC";
                        // $query = mssql_query($sql);
                        // $i = 0;
                        // while ($row1 = mssql_fetch_array($query)) {
                        ?>
                        <li data-target="#myCarousel" data-slide-to="<?php //echo $i + 1; 
                                                                        ?>" class="<?php //echo $row1['active']; 
                                                                                    ?>"></li>
                        <!--                            <li data-target="#myCarousel" data-slide-to="1"></li>
                                                                <li data-target="#myCarousel" data-slide-to="2"></li>-->
                        <?php
                        // $i++;
                        // }
                        ?>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <?php
                        // $sql = "select * from banner_img where img_status=1 order by dis_order ASC";
                        // $query = mssql_query($sql);
                        // $i = 0;
                        // while ($row1 = mssql_fetch_array($query)) {
                        ?>
                        <div class="item <?php //echo $row1['active']; 
                                            ?>">
                            <a href="#"> <img src="image/<?php //echo $row1['img_path']; 
                                                            ?>" alt="Los Angeles" style="width:100%;"></a>
                            <div class="carousel-caption">
                                <!--<h3><a href="" data-toggle="modal" data-target="#myModal">Digital Overview</a></h3>-->
                                <h3><a href="image/All SWC Initiatives_revised.pdf" target="_blank">Digital Overview</a></h3>
                            </div>
                        </div>
                        <?php
                        //     $i++;
                        // }
                        ?>
                        <!--                            <div class="item">
                                                                <a href="#"><img src="image/banner-3.jpg" alt="New york" style="width:100%;"></a>
                                                                <div class="carousel-caption">
                                                                    <h3><a href="#" data-toggle="modal" data-target="#myModal">Digital Overview</a></h3>
                                                                </div>
                                                            </div>
                                                            <div class="item">
                                                                <a href="#"><img src="image/banner-2.jpg" alt="Chicago" style="width:100%;"></a>
                                                                <div class="carousel-caption">
                                                                    <h3><a href="#" data-toggle="modal" data-target="#myModal">Digital Overview</a></h3>
                                                                </div>
                                                            </div>-->
                    </div>
                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </section>
        </div>
        <div class="row top-iocnsection">
            <h3 class="swc-content">Smart World - Digital Initiatives</h3>
            <!--<h3 class="swc-content"  style="margin-top:-50px"><marquee class="text-danger" style="font-size:20px; color:red; font-weight:bolder;">Your Subscription has been Expired!! You are in Grace Period!!</marquee> </h3>-->

            <div class="row hex-section">
                <div class="container-fluid">
                    <table cellpadding="0px" cellspacing="0px" style="margin-left: auto;margin-right: auto;">
                        <tbody>
                            <tr>
                                <td valign="middle" style="padding-top:15px;padding-bottom:10px;">
                                    <div class="col-md-4  col-4-hex1" style="width: auto;margin-right: -6%;margin-left: 4%;padding-right: 0px;padding-left: 0px;">
                                        <ol class="even">
                                            <!--AD SWIFT-->
                                            <li class='hex' data-toggle="popover" data-html="true" title="Swift Version-2">
                                                <a href="https://swc.ltts.com/swift_Ad" target="_blank" onclick='#'>
                                                    <img src="image/swift_logo.png" alt="" class="bule-image3-new1999swift">
                                                </a>
                                                <p style="margin: 69px 0px 0px -40px;"><a onclick="saveProj('swiftv2');" href="https://swc.ltts.com/swift_Ad" target="_blank">SWIFT-V2</a></p>
                                            </li>
                                            <!--AD SmartSignOff-->
                                            <li class='hex' data-toggle="popover" data-html="true" title="SmartSignOff Version-2">
                                                <a href="https://swc.ltts.com/smartsignoff_Ad" target="_blank" onclick='#'>
                                                    <img src="image/SmartSignOff1.png" alt="" / class="bule-image3-new1999">
                                                </a>
                                                <p style="margin: 69px 0px 0px -40px;"><a onclick="saveProj('smartsignoff_Ad');" href="https://swc.ltts.com/smartsignoff_Ad" target="_blank">Smartsignoff-V2</a></p>
                                            </li>
                                        </ol>
                                        <ol class="odd">
                                            <li class="hex">

                                                <a href="https://swc.ltts.com/csti_Ad" target="_blank" onclick="saveProj('CSTI');"> <img src="image/csti2.png" alt="" / class="bule-image3-new-csti1"> </a>
                                                <p style="margin: 75px 0px 0px -37px;"><a href="https://swc.ltts.com/csti_Ad" target="_blank" onclick="saveProj('CSTI');">SWC CSTI</a></p>
                                            </li>

                                            <li class='hex' data-toggle="popover" data-html="true" title="INMS" data-content=" ">
                                                <a onclick="saveProj('INMS');" href="https://swc.ltts.com/inms_Ad" target="_blank">
                                                    <img src="image/INMS_LOGO.png" alt="" class="bule-image3-new5_inms">
                                                </a>
                                                <p style="margin: 81px 0px 0px -40px"><a onclick="saveProj('INMS');" href="https://swc.ltts.com/inms_Ad" target="_blank">INMS Solution</a></p>
                                            </li>

                                            <li class='hex' data-toggle="popover" data-html="true" title="Quality Check" data-content=" <ul><li>
                                                    Enables on-the-spot quality parameter capture thru mobile app.</li>
                                                    <li>Streamlined workflow. </li>
                                                    <li> Transparent and audit ready .</li></ul>">
                                                <a onclick="saveProj('I-Attend');" href="https://swc.ltts.com/iattend_Ad" target="_blank">
                                                    <img src="image/iattend.png" alt="" class="bule-image4" style="width: 102px;margin-left: -5px;margin-top: 18px;">
                                                </a>
                                                <p onclick="saveProj('I-Attend');" style="margin: 81px 0px 0px -40px"><a href="https://swc.ltts.com/iattend_Ad" target="_blank"></a></p>
                                            </li>
                                        </ol>
                                        <ol class="even">
                                            <li class='hex' data-toggle="popover" data-html="true" title="Inventory Tracking" data-content="<ul> <li>Track every single movement of material right from the supplier stage till the installation at site.</li> <li> Record and monitor the flow and optimize.</li> <li> Spot the bottleneck and highlight.</li>">
                                                <a href="https://swc.ltts.com/inventory_Ad" target="_blank"><img src="image/Inventory-Tracking.png" alt="" / class="bule-image3-top"></a>
                                                <p style="margin: 71px 0px 0px -41px;"><a href="https://swc.ltts.com/inventory_Ad" target="_blank">i-Smart Inventory 2.0</a></p>
                                            </li>
                                            <li class="hex">
                                                <a href="https://swc.ltts.com/smartpro_Ad" target="_blank" onclick="saveProj('SmartPro');"> <img src="image/smartpro1.png" alt="" / class=" bule-image3-new1-smartpro"> </a>
                                                <p style="margin: 80px 0px 0px -34px;"><a href="https://swc.ltts.com/smartpro_Ad" target="_blank" onclick="saveProj('SmartPro');">SmartPro</a></p>
                                            </li>


                                        </ol>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <!-- <div class="container-fluid blue-section" style="margin-top:0px">
            <div class="row" style="    background: #096ab9;">
                <a href="https://lntcon.sharepoint.com/sites/SWC/SitePages/TechSolution_Home.aspx" target="_blank">
                    <div class="col-md-2 list2" style="width:20%;">
                        <div class="list1">
                            <img src="image/icon-1.png" alt="Chicago" class="icon-image1"><br>
                            SWC Tech Solution Portal
                        </div>
                    </div>
                </a>
                <a href="https://www.lntswcdigital.com/dfl" target="_blank">
                    <div class="col-md-2 list2" style="width:20%;">
                        <div class="list1">
                            <img src="image/icon-3.png" alt="Chicago" class="icon-image1"><br>
                            Debarred Firm List
                        </div>
                    </div>
                </a>
                <a href="https://www.lntswcdigital.com/glossary" target="_blank">
                    <div class="col-md-2 list3" style="width:21%;">
                        <div class="list1">
                            <img src="image/icon-4.png" alt="Chicago" class="icon-image1"><br>
                            Glossary<br>
                            (Technical Abbreviation Dictionary)
                        </div>
                    </div>
                </a>
                <a href="https://lntcon.sharepoint.com/sites/SWC/Corporate%20Centre/Risk%20Management/Due%20Diligence" target="_blank">
                    <div class="col-md-2 list2" style="width:20%;">
                        <div class="list1">
                            <img src="image/icon-5.png" alt="Chicago" class="icon-image1"><br>
                            Due Diligence Report
                        </div>
                    </div>
                </a>
                <a href="statistic.php" target="_blank">
                    <div class="col-md-2 list4" style="width:19%;">
                        <div class="list1">
                            <img src="image/icon-6.png" alt="Chicago" class="icon-image1"><br>
                            Digital App Usage Statistics
                        </div>
                    </div>
                </a>
            </div>
        </div> -->
    <br>
    <footer class="footer-color">
        <p class="w3-medium">
        <div class="pageWidth">
            <div id="sub-footer">
                <div class=" mk-grid">
                    <span class="mk-footer-copyright">
                        Copyright © <script type="text/JavaScript">
                            document.write(new Date().getFullYear());</script>. | All Rights Reserved | <a class="orange" href="privacypolicy.php" target="_blank">Privacy Policy</a>
                    </span>
                </div>
                <div class="clearboth"></div>
            </div>
        </div>
        </p>
    </footer>
    <div id="myModal2" class="modal fade" role="dialog" style="margin-top:15%;margin-right:2%;">
        <div class="modal-dialog" style="width:50%">
            <!-- Modal content-->
            <div class="modal-content" style="">
                <div class="row">
                    <button type="button" class="close" data-dismiss="modal" style="background:000;    margin-right:0px;">&times;</button>
                    <div class="col-md-5" style="color:white;background:#003F72;text-align:center;font-size: 20px;margin-left:-3%;padding-bottom:11%">
                        <p style="margin-top:36%">O&M Monitoring GIS Application</p>
                    </div>
                    <div class="row" style="background-color:white;">
                        <div class="col-md-5" style="margin-top:12%;">

                            <!--<a href="
                                                                        http://gis.lntecc.com/GujaratCSITMS/login.aspx?ReturnUrl=%2fGujaratCSITMS%2fdefault.aspx" target=_blank> -->

                            <a href="https://geospatial.lntecc.com/GujaratCSITMS" target=_blank>
                                <p style="font-size:135%;text-align:left;margin-top:-17%;margin-left:20%;">GUJARAT CSITMS&nbsp;&nbsp;-</p>
                            </a>
                            <a href="http://stargps365.com" target=_blank>
                                <p style="font-size:135%;text-align:right;margin-top:-38px;margin-right:-31%;">GPS TRACKER</p>
                            </a>

                            <!-- <br>
                                        <a href="http://stargps365.com" target=_blank>
                                           <p style="font-size:135%;text-align:center;margin-top:4px;">GPS TRACKER</p>
                                        </a>-->
                            <br>
                            <a href="http://gis.lntecc.com/VadodaraEye/Login.aspx?ReturnUrl=%2fVadodaraEye%2fdefault.aspx" target=_blank>
                                <p style="font-size:135%;text-align:center;margin-top:2%;margin-left:-6%;">VADODARA EYE</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bs-example-modal-sm" id="myModal_validate" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" style=" width: 50%">
            <div class="modal-content">
                <div class="modal-header" style="color:white;background:#003F72;text-align:center;font-family:  BankGothic Md BT;font-size: 33px;">
                    <button type="button" class="close" style="background:white;" data-dismiss="modal" onclick="validate_close();"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="bank" id="myModalLabel">EHS Validate User</h4>
                </div>
                <div class="modal-body" id="Add_new" style=" height:auto; overflow-y: scroll; overflow-x: hidden;">
                    <form>
                        <div class="form-group" style=" float:left; ">
                            <label class="control-label "> User Name<span class="required">*</span></label>
                            <div class="">
                                <input type="text" class="" name="ehs_name" id="ehs_name" placeholder="User Name" required>
                            </div>
                        </div>&nbsp; &nbsp;&nbsp;
                        <div class="form-group" style=" float:left; margin-left:20px;">
                            <label class="control-label "> Password<span class="required">*</span></label>
                            <div class="">
                                <input type="password" class="" name="ehs_pass" id="ehs_pass" placeholder="Password" required>
                            </div>
                        </div> &nbsp;&nbsp;&nbsp;

                        <div class="form-group" style=" float:left; margin-left:20px; margin-top:20px;">
                            <div class="">
                                <input type="ADD" class="btn btn-success" onclick="validate_user_profile()" value="Validate">
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bs-example-modal-sm" id="myModal_alert" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="color:white;background:#003F72;text-align:center;font-family:  BankGothic Md BT;font-size: 33px;">
                    <button type="button" class="close" style="background:white;" data-dismiss="modal" onclick=" modal_close_alert()"><span aria-hidden="true">×</span>
                    </button>
                    <h3 class="bank" id="myModalLabel" onclick="load_alert()" style="cursor:pointer">EHS Alert<i class=" glyphicon glyphicon-plus" onclick="add_new()" title="add new ehs alert" style=" float:left;   cursor:pointer;"></i></h3>
                    <h5 class="bank" style=" float:right;  margin-top:-30px; margin-right:120px; cursor:pointer">
                        <?php
                        $year = mssql_query("select distinct year(created_date) as year from ehs_alert_docs order by year(created_date) DESC");
                        while ($y = mssql_fetch_array($year)) {
                            echo '<span onclick="filteryear(' . $y['year'] . ')">' . $y['year'] . '|' . '</span>';
                        }
                        ?>
                    </h5>
                </div>
                <div class="modal-body" id="qte_content" style=" height: 25em; overflow-y: scroll; overflow-x: hidden;">
                    <table id="example" class="table">
                        <thead>
                            <tr>
                                <th>S.No </th>
                                <th>Name </th>
                                <th>Date </th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody id="ehs_alert_body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bs-example-modal-sm" id="myModal_alertaddnew" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" style=" width: 90%">
            <div class="modal-content">
                <div class="modal-header" style="color:white;background:#003F72;text-align:center;font-family:  BankGothic Md BT;font-size: 33px;">
                    <button type="button" class="close" style="background:white;" data-dismiss="modal" onclick="modal_close();"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="bank" id="myModalLabel">EHS Add New Alert</h4>
                </div>
                <div class="modal-body" id="Add_new" style=" height: 30em; overflow-y: scroll; overflow-x: hidden;">
                    <form>
                        <div class="form-group" style=" float:left; margin-left:200px;padding-right:30px; ">
                            <label class="control-label "> Date<span class="required">*</span></label>
                            <div class="">
                                <input type="date" class="" name="doc_date" id="doc_date" placeholder=" Date" required>
                            </div>
                        </div>
                        <div class="form-group" style=" float:left; ">
                            <label class="control-label "> Name<span class="required">*</span></label>
                            <div class="">
                                <input type="text" class="" name="doc_name" id="doc_name" placeholder=" Document Name" required>
                            </div>
                        </div>
                        <div class="form-group" style=" float:left; margin-left:25px;">
                            <label class="control-label "> Upload PDF<span class="required">*</span></label>
                            <div class="" style=" margin-top:3px;">
                                <input type="file" class="" name="file" id="file" required>
                            </div>
                        </div>
                        <div class="form-group" style=" float:left; margin-left:-30px; margin-top:15px;">
                            <div class="">
                                <input type="ADD" class="btn btn-success" onclick="upload_ehs()" value="ADD">
                            </div>
                        </div>
                    </form>
                    <br>
                    <table id="example" class="table">
                        <thead>
                            <tr>
                                <th>S.No </th>
                                <th>Name </th>
                                <th>Date </th>
                                <th>View</th>
                                <th>Trash</th>

                            </tr>
                        </thead>
                        <tbody id="ehs_body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width:50%">
            <!-- Modal content-->
            <div class="modal-header" style="color:white;background:#003F72;text-align:center;font-family:  BankGothic Md BT;font-size: 33px;width:560px;">
                <button type="button" class="close" data-dismiss="modal" style="background:white;">&times;</button>
                <p>Covid19 India</p>
            </div>
            <iframe id="cartoonVideo" width="560" height="315" src="image/slide1.mp4" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
    <div id="myModal1" class="modal fade" role="dialog" style="margin-top:15%;margin-right:2%;">
        <div class="modal-dialog" style="width:50%">
            <!-- Modal content-->
            <div class="row">
                <button type="button" class="close" data-dismiss="modal" style="background:000;margin-right:72px;">&times;</button>
                <div class="col-md-5" style="color:white;background:#003F72;text-align:center;font-size: 20px;margin-left:-3%;padding-bottom:11%">
                    <p style="margin-top:36%">Project Monitoring</p>
                </div>
                <div class="row" style="background-color:white;width:92%;">
                    <h4 style="    margin-right: 152px;
                                margin-top: 20px;
                                float: right;font-size: 25px;font-weight:bold"> Path</h4>
                    <div class="col-md-5" style="margin-top:12%;">
                        <a href="https://www.lntecc.com/" target=_blank>
                            <p style="font-family:  BankGothic Md BT;font-size:135%;text-align:center;margin-top:-24%;margin-left:20px;">
                                EIP (www.lntecc.com) <i class="fa fa-arrow-right"></i> <br />
                                Project Management <i class="fa fa-arrow-right"></i> <br />
                                Dashboard <i class="fa fa-arrow-right"></i> <br />
                                Procube
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal3" class="modal fade" role="dialog" style="margin-top:15%;margin-right:2%;">
        <div class="modal-dialog" style="width:50%">
            <!-- Modal content-->
            <div class="modal-content" style="">
                <div class="row">
                    <button type="button" class="close" data-dismiss="modal" style="background:000;    margin-right:21px;">&times;</button>
                    <div class="col-md-5" style="color:white;background:#003F72;text-align:center;font-size: 20px;margin-left:-3%;padding-bottom:11%">
                        <p style="margin-top:24%"><img src="image/Inventory-Tracking.png" style="width:20%;">Barcode Inventory Tracking</p>
                    </div>
                    <div class="row" style="background-color:white;width:92%;">
                        <h4 style=" margin-right: 195px;
                                    margin-top: 20px;
                                    float: right;font-size: 25px;font-weight:bold"></h4>
                        <div class="col-md-5" style="margin-top:12%;">
                            <a href="http://www.lntecc.com/" target=_blank>
                                <ul style="margin-top:-24%;margin-left:20px;font-size:16px;">
                                    <li style="width:352px;"> Track Every Single Movement of Material Right From The Supplier
                                        Stage Till The Installation At the Sight.
                                    </li>
                                    <li style="width:300px;">Record And Monitor The Flow And Optimize</li>
                                    <li style="width:300px;">Spot the bottleNeck and Highlight</li>
                                </ul>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once 'techinnerv/tech_innervmodals.php';
    ?>

    </div>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        // var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        // (function(){
        // var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        // s1.async=true;
        // s1.src='https://embed.tawk.to/613f015fd326717cb6812003/1fff1qo9h';
        // s1.charset='UTF-8';
        // s1.setAttribute('crossorigin','*');
        // s0.parentNode.insertBefore(s1,s0);
        // })();
    </script>
    <!--End of Tawk.to Script-->
</body>

</html>
<script src="techinnerv/tech_innerv.js" type="text/javascript"></script>
<script>
    /*
     **********************************************************
     * OPAQUE NAVBAR SCRIPT
     **********************************************************
     */

    // Toggle tranparent navbar when the user scrolls the page

    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) /*height in pixels when the navbar becomes non opaque*/ {
            $('.opaque-navbar').addClass('opaque');
        } else {
            $('.opaque-navbar').removeClass('opaque');
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            placement: 'top',
            trigger: 'hover'

        });

    });
</script>
<script>
    $(document).ready(function() {
        /* Get iframe src attribute value i.e. YouTube video url
         and store it in a variable */
        var url = $("#cartoonVideo").attr('src');

        /* Assign empty url value to the iframe src attribute when
         modal hide, which stop the video playing */
        $("#myModal").on('hide.bs.modal', function() {
            $("#cartoonVideo").attr('src', '');
        });

        /* Assign the initially stored url back to the iframe src
         attribute when modal is displayed again */
        $("#myModal").on('show.bs.modal', function() {
            $("#cartoonVideo").attr('src', url);
        });
    });
</script>




<script type="text/javascript">
    function saveProj(modn) {
        var mod = modn;
        var req = $.ajax({
            type: "post",
            url: "ajax/insertproj.php",
            data: {
                mod: mod
            }
        });
    }

    function add_new() {
        validate_user();
    }

    function modal_close() {
        $('#myModal_alertaddnew').hide();
    }

    function modal_close_alert() {
        $('#myModal_alert').hide();
    }

    function upload_ehs() {
        var doc = $('#doc_name').val();
        var file = $('#file').val();
        var doc_date = $('#doc_date').val();

        if (doc_date === '') {
            alert('Please select date');
        } else if (doc === '') {
            alert('Please fill document name');
        } else if (file === '') {
            alert('Please upload file');
        } else {

            var formData = new FormData();
            formData.append('file', $('#file')[0].files[0]);
            formData.append('input', doc);
            formData.append('doc_date', doc_date);
            $.ajax({
                url: 'ajax/ehs_upload.php',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(data) {
                    //console.log(data);
                    //alert(data);
                    if ($.trim(data) === 'success') {
                        alert('Document added successfully');
                        load_data();
                    } else {
                        alert('Uploading Error');
                    }


                }
            });

        }
    }

    function load_data() {
        $.ajax({
            url: 'ajax/ehs_fetchcontents.php',
            type: 'POST',
            success: function(data) {

                document.getElementById("ehs_body").innerHTML = data;

            }
        });
    }

    function delete_ehs(id) {
        $.ajax({
            url: 'ajax/ehs_deletecontents.php',
            type: 'POST',
            data: 'id=' + id,
            success: function(data) {
                if ($.trim(data) === 'success') {
                    load_data();
                } else {
                    alert(data);
                }
            }
        });
    }

    function open_alert() {
        $('#myModal_alert').show();
        load_alert();
    }

    function load_alert() {
        $.ajax({
            url: 'ajax/ehs_fetchcontentsalert.php',
            type: 'POST',

            success: function(data) {

                document.getElementById("ehs_alert_body").innerHTML = data;

            }
        });
    }

    function validate_user() {
        $('#myModal_alert').hide();
        $('#myModal_validate').show();

    }

    function validate_user_profile() {
        var name = $('#ehs_name').val();
        var pass = $('#ehs_pass').val();
        $.ajax({
            url: 'ajax/ehs_validate_user.php',
            type: 'POST',
            data: 'name=' + name + '&pass=' + pass,
            success: function(data) {
                //alert(data);
                if ($.trim(data) === 'success') {
                    $('#myModal_alertaddnew').show();
                    $('#myModal_validate').hide();
                    load_data();
                    $('#myModal_alert').hide();
                } else {
                    alert('Username or Password Incorrect');
                }

            }
        });
    }

    function validate_close() {
        $('#myModal_validate').hide();
    }

    function filteryear(yr) {
        //alert(yr);
        document.getElementById("ehs_alert_body").innerHTML = '';
        $.ajax({
            url: 'ajax/ehs_fetchcontentbyyear.php',
            type: 'POST',
            data: 'year=' + yr,
            success: function(data) {

                document.getElementById("ehs_alert_body").innerHTML = data;

            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        /* Get iframe src attribute value i.e. YouTube video url
         and store it in a variable */
        var url = $("#cartoonVideo").attr('src');

        /* Assign empty url value to the iframe src attribute when
         modal hide, which stop the video playing */
        $("#myModal").on('hide.bs.modal', function() {
            $("#cartoonVideo").attr('src', '');
        });

        /* Assign the initially stored url back to the iframe src
         attribute when modal is displayed again */
        $("#myModal").on('show.bs.modal', function() {
            $("#cartoonVideo").attr('src', url);
        });
    });
</script>