<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
//header("location:https://swc.ltts.com/logout");
// header("location: https://swc.ltts.com/swift_ad/logout");
header("location:index.php");
