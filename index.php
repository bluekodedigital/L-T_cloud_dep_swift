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

    $uname = sanitize($uname);
    $paswd = sanitize($paswd);
    $select_query = "select * from usermst where uname = '" . $uname . "' and upwd = '" . $paswd . "' and active='1'";

    $sel_query = mssql_query($select_query);
    $data = mssql_fetch_array($sel_query);
    $count = mssql_num_rows($sel_query);

    if ($count > 0) {
        $_SESSION['uname'] = $data['uname'];
        $_SESSION['usertype'] = $data['usertype'];

        $select_type = "select * from user_type_master where id = '" . $data['usertype'] . "'";

        $sel_type = mssql_query($select_type);
        $deptname = mssql_fetch_array($sel_type);
        $_SESSION['depname'] = $deptname['type_name'];

        $_SESSION['uid'] = $data['uid'];
        $_SESSION['deptid'] = $data['deptid'];
        $_SESSION['name'] = $data['name'];
        $_SESSION['user_ini'] = $data['user_ini'];
        $_SESSION['swift_dep'] = $data['swift_dep'];
        $_SESSION['tech_seg'] = $data['tech_seg'];
        $_SESSION['report_access'] = $data['report_access'];
        $_SESSION['swift'] = 'swift';
        $_SESSION['milcom'] = $data['milcom_app'];
        $_SESSION['proj_type'] = $data['proj_type'];
        if ($data['usertype'] == '0' && $count == 1) {
            echo "<script>window.location.href='dashboard';</script>";
        } else if ($data['usertype'] == '2' && $count == 1) {
            echo "<script>window.location.href='buyer_dash';</script>";
        } elseif ($data['usertype'] == '5' && $count == 1) {
            echo "<script>window.location.href='ops_dashboard';</script>";
        } else if ($data['usertype'] == '21' && $count == 1) {
            echo "<script>window.location.href='site_ops_dash';</script>";
        } else if ($data['usertype'] == '9' && $count == 1) {
            echo "<script>window.location.href='project_master';</script>";
        
        } elseif ($count == 1) {
            echo "<script>window.location.href='swift_workflow';</script>";
        } else {

            echo "<script>window.location.href='index.php?msg=0';</script>";
        }


    } else {

        echo "<script>window.location.href='index.php?msg=0';</script>";
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
        $_SESSION['milcom'] = $data['milcom_app'];

    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <base href="https://swc.ltts.com/swiftv2/"> -->
    <title> L&T Swift </title>
    <link rel="icon" href="images/logo-dark.png" sizes="16x16">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,500;0,600;1,200&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login4.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

</head>

<body>

    <div class="help">
        <img src="images/Picture2.png" alt="" height="60px;">


    </div>
    <div class="image">

        <img src="images/img1.png" alt="">


    </div>
    <div class="red">
        SWIFT
        <h4>Supply & Works Integrated </br>
            <h4>Finishing on Time
            </h4>

    </div>

    <div class="container">
        <div class="main-box">
            <h1>Log in</h1>
            <form id="loginform" method="post">




                <div class="input-box">
                    <span class=""><box-icon type='solid' name='envelope'></box-icon></span>
                    <input type="text" name="Username" required placeholder="Username">
                    <!-- <label for="">Username</label> -->
                </div>
                <div class="input-box">
                    <span class=""><box-icon type='solid' name='envelope'></box-icon></span>
                    <input type="password" name="Password" id="" required placeholder="Password" autocomplete="off">
                    <!-- <label for="">Password</label> -->
                </div>
                <div class="check">
                    <!-- <label for=""><input type="checkbox">Remember me</label> -->
                    <!-- <a href="forgot_password">Forget Password?</a> -->
                </div>
                <div class="col-md-12">
                    <?php
                    if (isset($_GET['msg'])) {
                        $msg = $_GET['msg'];
                    } else {
                        $msg = '';
                    }
                    if ($msg == '0') {
                        ?>
                        <div class="alert alert-danger alert-rounded">
                            <i class='fa fa-exclamation-triangle'></i> Username Or Password Incorrect
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                                    aria-hidden="true">×</span> </button>
                        </div>
                    <?php }
                    ?>
                </div>
                <button type="submit" class="btn" name="btn_login">Log In</button>
            </form>
        </div>
    </div>
    <div class="menu">

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