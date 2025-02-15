<?php

include_once ("../config/inc_function.php");
error_reporting(1);
session_start();
$csrf_token = $_REQUEST['csrf_token'];


if (isset($_SESSION['token']) && $csrf_token === $_SESSION['token']) {
if (isset($_REQUEST['dt_create'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_doctype where dt_doctype='" . filterText($dt_doctype) . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {

        echo "<script>window.location.href='../doctype?msg=0';</script>";
    } else {
        $isql = mssql_query("select isnull (max(dt_id+1),1) as id from  swift_doctype");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];

        $sql = mssql_query("insert into swift_doctype(dt_id,dt_doctype,dt_active,dt_docname)"
                . "values('" . $id . "','" . sanitize($dt_doctype). "',1,'".sanitize($dt_docname)."')");
        if ($sql) {

            echo "<script>window.location.href='../doctype';</script>";
        }
    }
}
if (isset($_REQUEST['dt_update'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_doctype where dt_id='" . $dt_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $update = mssql_query("update swift_doctype set dt_doctype='" . sanitize($dt_doctype) . "',dt_docname='".sanitize($dt_docname)."'  where dt_id='" . $dt_id . "' ");
        if ($update) {
            echo "<script>window.location.href='../doctype';</script>";
        }
    } else {
        echo "<script>window.location.href='../doctype?msg=1';</script>";
    }
}
if (isset($_REQUEST['id'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $dt_id = $_REQUEST['id'];
    $sql = "select * from  swift_doctype where dt_id='" . $dt_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $delete = mssql_query("delete from swift_doctype where dt_id='" . $dt_id . "' ");
        if ($delete) {
            echo "<script>window.location.href='../doctype';</script>";
        }
    } else {
        echo "<script>window.location.href='../doctype?msg=1';</script>";
    }
}

if (isset($_REQUEST['tc_create'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_temcode where tc_teamcode='" . filterText($tc_teamcode) . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {

        echo "<script>window.location.href='../teamcode?msg=0';</script>";
    } else {
        $isql = mssql_query("select isnull (max(tc_id+1),1) as id from  swift_temcode");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];

        $sql = mssql_query("insert into swift_temcode(tc_id,tc_teamcode,tc_active,tc_teamname)"
                . "values('" . $id . "','" . sanitize($tc_teamcode) . "',1,'".sanitize($tc_teamname)."')");
        if ($sql) {

            echo "<script>window.location.href='../teamcode';</script>";
        }
    }
}
if (isset($_REQUEST['tc_update'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_temcode where tc_id='" . $tc_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $update = mssql_query("update swift_temcode set tc_teamcode='" . sanitize($tc_teamcode) . "',tc_teamname='".sanitize($tc_teamname)."'  where tc_id='" . $tc_id . "' ");
        if ($update) {
            echo "<script>window.location.href='../teamcode';</script>";
        }
    } else {
        echo "<script>window.location.href='../teamcode?msg=1';</script>";
    }
}if (isset($_REQUEST['tcid'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $tc_id = $_REQUEST['tcid'];
    $sql = "select * from  swift_temcode where tc_id='" . $tc_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $delete = mssql_query("delete from swift_temcode where tc_id='" . $tc_id . "' ");
        if ($delete) {
            echo "<script>window.location.href='../teamcode';</script>";
        }
    } else {
        echo "<script>window.location.href='../teamcode?msg=1';</script>";
    }
}

// Document Set CODE

if (isset($_REQUEST['dc_create'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_docsetcode where dc_setcode='" . filterText($dc_setcode) . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {

        echo "<script>window.location.href='../setcode?msg=0';</script>";
    } else {
        $isql = mssql_query("select isnull (max(dc_id+1),1) as id from  swift_docsetcode");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];

        $sql = mssql_query("insert into swift_docsetcode(dc_id,dc_setcode,dc_active,dc_setname)"
                . "values('" . $id . "','" . $dc_setcode . "',1,'".sanitize($dc_setname)."')");
        if ($sql) {

            echo "<script>window.location.href='../setcode';</script>";
        }
    }
}
if (isset($_REQUEST['dc_update'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_docsetcode where dc_id='" . $dc_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $update = mssql_query("update swift_docsetcode set dc_setcode='" . $dc_setcode . "',dc_setname='".sanitize($dc_setname)."'  where dc_id='" . $dc_id . "' ");
        if ($update) {
            echo "<script>window.location.href='../setcode';</script>";
        }
    } else {
        echo "<script>window.location.href='../setcode?msg=1';</script>";
    }
}if (isset($_REQUEST['dcid'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $dc_id = $_REQUEST['dcid'];
    $sql = "select * from  swift_docsetcode where dc_id='" . $dc_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $delete = mssql_query("delete from swift_docsetcode where dc_id='" . $dc_id . "' ");
        if ($delete) {
            echo "<script>window.location.href='../setcode';</script>";
        }
    } else {
        echo "<script>window.location.href='../setcode?msg=1';</script>";
    }
}
// system code part
if (isset($_REQUEST['sc_create'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_systemcode where sc_code='" . filterText($sc_code) . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        echo "<script>window.location.href='../systemcode?msg=0';</script>";
    } else {
        $isql = mssql_query("select isnull (max(sc_id+1),1) as id from  swift_systemcode");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];

        $sql = mssql_query("insert into swift_systemcode(sc_id,sc_code,sc_active,sc_name)"
                . "values('" . $id . "','" . $sc_code . "',1,'".sanitize($sc_name)."')");
        if ($sql) {

            echo "<script>window.location.href='../systemcode';</script>";
        }
    }
}
if (isset($_REQUEST['sc_update'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_systemcode where sc_id='" . $sc_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $update = mssql_query("update swift_systemcode set sc_code='" . $sc_code . "',sc_name='".sanitize($sc_name)."'  where sc_id='" . $sc_id . "' ");
        if ($update) {
            echo "<script>window.location.href='../systemcode';</script>";
        }
    } else {
        echo "<script>window.location.href='../systemcode?msg=1';</script>";
    }
}if (isset($_REQUEST['scid'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sc_id = $_REQUEST['scid'];
    $sql = "select * from  swift_systemcode where sc_id='" . $sc_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $delete = mssql_query("delete from swift_systemcode where sc_id='" . $sc_id . "' ");
        if ($delete) {
            echo "<script>window.location.href='../systemcode';</script>";
        }
    } else {
        echo "<script>window.location.href='../systemcode?msg=1';</script>";
    }
}
}
?>