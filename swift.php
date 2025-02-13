<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("config/db_con.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="images/logo-dark.png" /> 
        <title>L&T Tracking </title>

        <!-- Bootstrap -->
        <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="build/css/custom.min.css" rel="stylesheet">

        <style>
            @font-face {
                font-family: bankgothic;
                src: url(font/bankgothic_md_bt.ttf);
            }
            .bank{
                font-family: bankgothic;
            }

            .circle{
                border: 2px solid white;
                border-radius: 50%;
                width: 350px;
                height:350px;
                padding: 50px;
                background-color: #75A0CD;
            }
            .circle1{
                border: 2px solid white;
                border-radius: 50%;
                width:250px;
                height:250px;
                padding: 50px;
                background-color:#BCD0E9;
            }
            .circle2{
                border: 2px solid white;
                border-radius: 50%;
                width: 150px;
                height:150px;
                padding: 50px;
                background-color:#75A0CD;
            }
            .circle3{
                border: 2px solid white;
                border-radius: 50%;
                width: 50px;
                height:50px;
                background-color:#42719D;

            }
            .watermark {
                width: 300px;
                height: 100px;
                display: block;
                position: relative;
            }

            .watermark::after {
                content: "";
                background:url('images/Procurement Track.png');
                opacity: 0.2;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                position: absolute;
                z-index: -1;   
            }
            .incline-line{
                width: 50%;
                margin: auto;
                margin-top: -5%;
                margin-bottom: 5%;
                transform: rotate(-90deg);
                border-color: purple;
            }
            .scm{
                position: relative; 
                height: 240px; 
                width:44px; 
                left:280px; 
                top:-60px; 
                border-left: 1px solid #5A9AD7; 
                border-top: 1px solid #5A9AD7;
                transform: skewX(-40deg);
            }
            .operation{
                position: relative; 
                height: 195px; 
                width:44px; 
                left:300px; 
                top:-230px; 
                border-left: 1px solid #5A9AD7; 
                border-top: 1px solid #5A9AD7;
                transform: skewX(-40deg);
            }
            .finance{
                position: relative; 
                height:150px; 
                width:38px; 
                left:325px; 
                top:-360px; 
                border-left: 1px solid #5A9AD7; 
                border-top: 1px solid #5A9AD7;
                transform: skewX(-40deg);
            }
            .bu{
                position: relative; 
                height:100px; 
                width:42px; 
                left:340px; 
                top:-435px; 
                border-left: 1px solid #5A9AD7; 
                border-top: 1px solid #5A9AD7;
                transform: skewX(-40deg);
            } 
            .proposal{
                margin-left: 75px;
                margin-top: 35px;
                height: 42em;
                padding-top:180px; 
                padding-left: 40px;
                padding-bottom: 100px;
                border:  2px solid #5A9AD7;
                border-radius: 15%;
                background-color:#DEEAF6;
            }
            .btn-primary{
                background-color:#012060;
                width: 150px;
                border: none;
                font-size: 1em;
                font-family: verdana;
                border:1px solid white;

            }
            #bckimage{
                position: absolute;
                left:  0px;
                top:20%;
                width: 100%;
                height: 80%;

            }


        </style>
    </style>
</head>

<?php
if (isset($_POST['btn_login'])) {
    $uname = mssql_escape($_POST['username']);
    $paswd = mssql_escape($_POST['password']);
    $uname = stripslashes($uname);
    $paswd = stripslashes($paswd);
    if (Stripos($uname, "'") !== FALSE) {
        //echo  $uname;
    } else if (Stripos($uname, "'") !== FALSE) {
        //echo  $uname;
    } else {
        $uname = ($uname);
        $paswd = ($paswd);
    }




    //$project_id = $_POST['project_id'];
    //$paswd = base64_encode($paswd);
     $select_query = "select * from usermst where uname = '" . $uname . "' and upwd = '" . $paswd . "' and active='1'";

    $sel_query = mssql_query($select_query);
    $data = mssql_fetch_array($sel_query);
    $count = mssql_num_rows($sel_query);
    if ($count > 0) {

        $_SESSION['uname'] = $data['uname'];
        $_SESSION['upwd'] = $data['upwd'];
        $_SESSION['usertype'] = $data['usertype'];
        $_SESSION['uid'] = $data['uid'];
        $_SESSION['deptid'] = $data['deptid'];
        $_SESSION['name'] = $data['name'];
        $_SESSION['user_ini'] = $data['user_ini'];
        $_SESSION['swift_dep'] = $data['swift_dep'];
        $_SESSION['report_access'] = $data['report_access'];
        

        if ($data['usertype'] == '2' && $count == 1) {
            echo "<script>window.location.href='swift/s_dashboard1.php';</script>";
        } elseif ($data['usertype'] == '5' && $count == 1) {
            echo "<script>window.location.href='swift/s_dashboard1.php';</script>";
        } elseif ($data['usertype'] == '3' && $count == 1 && $data['swift_dep'] == 1) {
            echo "<script>window.location.href='swift/s_dashboard1.php';</script>";
        } elseif ($data['usertype'] == '6' && $count == 1) {
            echo "<script>window.location.href='swift/s_dashboard1.php';</script>";
        }elseif ($data['usertype'] == '7' && $count == 1) {
            echo "<script>window.location.href='swift/s_dashboard1.php';</script>";
        } else {
            // echo "<script>alert('The username or password you have entered is incorrect.');</script>";
            echo "<script>window.location.href='swift.php?msg=0';</script>";
        }
    } else {
        // echo "<script>alert('The username or password you have entered is incorrect.');</script>";
        echo "<script>window.location.href='swift.php?msg=0';</script>";
    }
}
?>
<body class="bg-white"  style=" overflow-y: hidden;"  >
    <div>
        <div class="row">
            <div class="pull-left"  style="margin-top: 15px; " >

                <img src="images/logo.png" alt="" style="height: 80px; padding: 10px;"/>

            </div>
            <div class="pull-right"  style=" padding-right: 10px; " >

                <img src="images/SWIFT logo.png" alt="" style="height: 130px;  padding-right: 10px;"/>

            </div>
        </div>
        <img id="bckimage" src="images/ban.png" alt=""  />
        <div class="container body">


            <div class="main_container">
                <div class=" col-lg-6 col-md-6 col-sm-6"   >


                </div>


                <div class=" col-md-6" style=" margin-left: 0px; margin-top: 120px;" >

                    <div style="position: absolute; left: 50px; width: 420px; height: 250px;    background-color: #002060; opacity: 0.8; filter: alpha(opacity=80);"></div>
                    <br>
                    <form class=" " id="login" method="post" style=" ">   
                        <div  class=" col-md-12" >
                            <div  class=" bank col-md-6 " style=" padding-top: 25px; padding-bottom: 10px; padding-left: 90px; font-size: 20px;color:white; ">
                                User Name
                            </div>
                            <div class=" col-md-3"  style=" padding-top: 20px;  padding-bottom: 40px; margin-left: -90px;">

                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required="" />

                            </div>

                        </div>

                        <div  class=" col-md-12" >
                            <div class=" bank col-md-6"  style=" padding-top: 5px; padding-bottom: 10px; padding-left: 100px; color:white; font-size: 20px; ">

                                Password
                            </div>
                            <div  class=" col-md-3" style="  padding-bottom: 10px; margin-left: -90px;">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="" />
                            </div>
                        </div>
                        <div  class=" col-md-12" >
                            <div class=" col-md-4"  style=" padding-top: 15px; padding-bottom: 10px; padding-left: 160px; font-size: 20px;; font-weight:bolder;">

                                <button id="btn_login" name="btn_login" class="btn btn-primary"> Login </button>
                            </div>


                        </div>
                        <div  class=" col-md-12" >
                            <div class=" col-md-12"  style="font-weight:bolder;">

                                <?php
                                if (isset($_GET['msg'])) {
                                    $msg = $_GET['msg'];
                                } else {
                                    $msg = '';
                                } if ($msg == '0') {
                                    ?>
                                    <center> <span class=" text-danger">Username or Password Incorrect</span></center>
                                    <?php } ?>
                            </div>


                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
