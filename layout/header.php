<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['uname']) && !isset($_SESSION['usertype'])) {
    header("location: index");
    exit;
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" href="images/logo-dark.png" sizes="16x16" />
    <title> L&T Swift</title>
    <!-- chartist CSS -->
    <link href="assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!--c3 CSS -->
    <link href="assets/libs/morris.js/morris.css" rel="stylesheet">
    <link href="assets/extra-libs/c3/c3.min.css" rel="stylesheet">

    <!-- chartist CSS -->

    <link href="dist/js/pages/chartist/chartist-init.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="assets/libs/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" />
    <link href="assets/extra-libs/calendar/calendar.css" rel="stylesheet" />
    <!-- This page plugin CSS -->
    <link href="assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

    <link rel="stylesheet" type="text/css" href="assets/extra-libs/datatables.net-bs4/css/datatableButtons.css"
        rel="stylesheet" type="text/css" />

    <!-- needed css -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="assets/new_style.css" rel="stylesheet" type="text/css" />
    <!-- p notify -->
    <link href="vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="assets/pnotify/dist/pnotify.brighttheme.css" rel="stylesheet" type="text/css" />
    <link href="assets/pnotify/dist/pnotify.css" rel="stylesheet" type="text/css" />
    <link href="assets/pnotify/dist/pnotify.buttons.css" rel="stylesheet" type="text/css" />
    <link href="assets/pnotify/dist/pnotify.nonblock.css" rel="stylesheet" type="text/css" />
    <link href="assets/pnotify/dist/pnotify.material.css" rel="stylesheet" type="text/css" />
    <link href="assets/pnotify/dist/pnotify.mobile.css" rel="stylesheet" type="text/css" />
    <link href="https://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css" rel="stylesheet">
    <link href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css" rel="stylesheet">



</head>

<body>
    <!--        <div class="row" style="position: absolute; z-index: 9999; margin-left: 50%">            
            <center> <marquee class="text-danger" style="font-size:20px;; font-weight:bolder;">Your Subscription Expired!!! Your Grace Period Till 17.09.2020!!!</marquee> 
            </center>
        </div>-->
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>