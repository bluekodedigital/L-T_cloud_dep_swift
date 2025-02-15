<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("config/db_con.php");
?>
<?php
$encoded_mail = isset($_GET['uname']) ? $_GET['uname'] : null;

if ($encoded_mail !== null) {
    $uname = base64_decode($encoded_mail);
    $uname = sanitize_input($uname);
    $select_query = "select * from usermst where uname = '" . $uname . "'  and active='1'";
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

            echo "<script>window.location.href='https://swc.ltts.com/swift_ad/logout';</script>";
        }
    } else {

        echo "<script>window.location.href='https://swc.ltts.com/swift_ad/logout';</script>";
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
    } else {
        echo "<script>window.location.href='swift.php?msg=0';</script>";
    }
}
?>


