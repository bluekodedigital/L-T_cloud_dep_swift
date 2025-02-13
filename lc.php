<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("config/db_con.php");
?>
<?php
if (isset($_POST['btn_login'])) {
    $uname = $_POST['Username'];
    $paswd = $_POST['Password'];
//    $uname = filterText($_POST['Username']);
//    $paswd = filterText($_POST['Password']);
    $uname = mssql_escape($uname);
    $paswd = mssql_escape($paswd);
    $select_query = "select * from usermst where uname = '" . $uname . "' and upwd = '" . $paswd . "' and active='1' and usertype !=16 ";

    $sel_query = mssql_query($select_query);
    $data = mssql_fetch_array($sel_query);
    $count = mssql_num_rows($sel_query);

    if ($count > 0) {
        $_SESSION['uname'] = $data['uname'];
        $_SESSION['usertype'] = $data['usertype'];
        $_SESSION['uid'] = $data['uid'];
        $_SESSION['deptid'] = $data['deptid'];
        $_SESSION['name'] = $data['name'];
        $_SESSION['user_ini'] = $data['user_ini'];
        $_SESSION['swift_dep'] = $data['swift_dep'];
        $_SESSION['tech_seg'] = $data['tech_seg'];
        $_SESSION['report_access'] = $data['report_access'];
        $_SESSION['swift'] = 'swift';

        if ($data['usertype'] == '13' && $count == 1) {
            echo "<script>window.location.href='finance';</script>";
        } else {
            echo "<script>window.location.href='lc.php?msg=0';</script>";
        }
    } else {
        // echo "<script>alert('The username or password you have entered is incorrect.');</script>";
        echo "<script>window.location.href='lc.php?msg=0';</script>";
    }
} else {
    if (isset($_SESSION['swift']) != "") {
        $uname = $_SESSION['uname'];
        $usertype = $_SESSION['usertype'];
        $uid = $_SESSION['uid'];
        $deptid = $_SESSION['deptid'];
        $name = $_SESSION['name'];
        $user_ini = $_SESSION['user_ini'];
        $swift_dep = $_SESSION['swift_dep'];
        $tech_seg = $_SESSION['tech_seg'];
        $report_access = $_SESSION['report_access'];
        if ($usertype == '13') {
            echo "<script>window.location.href='finance';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" href="images/logo-dark.png" sizes="16x16" /> 
        <title> L&T LC Track</title>
        <!-- Custom CSS -->
        <link href="dist/css/style.min.css" rel="stylesheet">
        <!-- <link href="style.css" rel="stylesheet"> -->
        <style>
            body{
                background-image: url("images/bg2.jpg");
            }
            #swiftlogo{
                animation: shake1 5s;
                animation-iteration-count: 1s;
            }
            .loc_logo{
                animation: shake 20s;
                animation-iteration-count: infinite;
                /*                position: absolute;
                                height:20% !important;
                                width: 50%;*/
            }
            .lc {
                position: absolute;
                font-size: 60px !important;
                left: 16%;
                top: 15%;
                animation: shake 20s;
                animation-iteration-count: infinite;
            }
            .logos img:hover{
                animation: stop;
            }

            @keyframes shake {
                0% { transform: translate(1px, 10px) rotate(10deg); }
                10% { transform: translate(-10px, -2px) rotate(-11deg); }
                20% { transform: translate(-30px, 0px) rotate(11deg); }
                30% { transform: translate(30px, 2px) rotate(10deg); }
                40% { transform: translate(10px, -1px) rotate(11deg); }
                50% { transform: translate(-10px, 2px) rotate(-11deg); }
                60% { transform: translate(-30px, 1px) rotate(10deg); }
                70% { transform: translate(30px, 1px) rotate(-11deg); }
                80% { transform: translate(-10px, -1px) rotate(11deg); }
                90% { transform: translate(10px, 2px) rotate(10deg); }
                100% { transform: translate(10px, -2px) rotate(-11deg); }
            }
            @keyframes shake1 {
                0% { transform: translate(1px, 1px) rotate(10deg); }
                10% { transform: translate(-1px, -2px) rotate(-11deg); }
                20% { transform: translate(-3px, 0px) rotate(11deg); }
            }
        </style>
    </head>

    <body>
        <div class="main-wrapper">
            <div class="preloader">
                <div class="lds-ripple">
                    <div class="lds-pos"></div>
                    <div class="lds-pos"></div>
                </div>
            </div>
            <!-- <div class="stars"></div> -->
            <!-- <div class="twinkling"></div> -->
            <!-- <div class="clouds"></div> -->
            <div class="logos" style="position:absolute;   background-image: url('images/finance.jpg');  background-repeat: no-repeat;  background-attachment: fixed;background-size: cover; height: 100%; width:100%; overflow-y: hidden; text-align: center; ">
                <h1 class="font-medium mb-3 lc">Letter of Credit</h1>
                <img src="images/loc.png" alt="Pineapple" class="Pineapple" style="z-index: 999;    margin-top: 15%;    margin-left: -33%; border-radius: 1%;">
                <!--<img src="images/loc_logo.png" alt="Pineapple" class="loc_logo" style="z-index: 999;    margin-top: 6%;    margin-left: -33%;    width: 60%;">-->
            </div>
            <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">

                <div class="auth-box on-sidebar" style="position: fixed;">
                    <div id="loginform" style="margin-top:100px">
                        <div class="logo">
                            <span class="db"><img src="images/logo_latest.png"   alt="logo" style="width:100%; margin-top:-50%"/></span>
                            <br><br>
                            <br><br>
                            <h5 class="font-medium mb-3">Sign In to LC Track</h5>
                        </div>
                        <!-- Form -->

                        <div class="row">
                            <div class="col-12"> 
                                <form class="form-horizontal mt-3" id="loginform" method="post"  >
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" placeholder="Username" name="Username" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                        </div>
                                        <input type="password" class="form-control form-control-lg" placeholder="Password" name="Password" aria-label="Password" aria-describedby="basic-addon1">
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
                                                    <i class="fa fa-exclamation-triangle"></i> Username Or Password Incorrect
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                                </div>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <div class="col-xs-12 pb-3">
                                            <button class="btn btn-block btn-lg btn-info" type="submit" name="btn_login">Log In</button>
                                        </div>
                                    </div>
                                    <!--<img src="images/SWIFTlogo.png" id="swiftlogo" alt="logo">-->
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- All Required js -->
        <!-- ============================================================== -->
        <script src="assets/libs/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
        <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- ============================================================== -->
        <!-- This page plugin js -->
        <!-- ============================================================== -->
        <script>
            $('[data-toggle="tooltip"]').tooltip();
            $(".preloader").fadeOut();
            // ============================================================== 
            // Login and Recover Password 
            // ============================================================== 
            $('#to-recover').on("click", function () {
                $("#loginform").slideUp();
                $("#recoverform").fadeIn();
            });
            $("body").on("contextmenu", "img", function (e) {
                return false;
            });
        </script>
    </body>
</html>