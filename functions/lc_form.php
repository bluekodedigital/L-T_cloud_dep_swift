<?php

include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_REQUEST['lcmst_create'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $lc_number = $lc_num;
    $lc_date = formatDate(str_replace('/', '-', $lc_date), 'Y-m-d h:i:s');
    $valid_from = formatDate(str_replace('/', '-', $from_lc), 'Y-m-d h:i:s');
    $valid_to = formatDate(str_replace('/', '-', $to_lc), 'Y-m-d h:i:s');
    $lc_value = $lc_value;
    $vendor = $vendor;
// Check LC already Exsits for selected Vendor    
    $sql = "select * from swift_lcmaster where  lcm_num='" . $lc_number . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        echo "<script>window.location.href='../lc_master?msg=0';</script>";
    } else {
        $isql = mssql_query("select isnull (max(lcm_id+1),1) as id from  swift_lcmaster");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];
        $insert = mssql_query("insert into swift_lcmaster(lcm_id,lcm_venid,lcm_num,lcm_date,lcm_from,lcm_to,lcm_value,lcm_balance,lcm_created,lcm_updated,lcm_userid,lcm_cpid,"
                . "            lcm_appname,lcm_appbank,lcm_venbank,lcm_venbankaddress,lcm_currency,lcm_forex,lcm_valueinr,lcm_incoterms,lcm_country)"
                . "            values('" . $id . "','" . $vendor . "','" . $lc_number . "','" . $lc_date . "','" . $valid_from . "','" . $valid_to . "','" . $lc_value . "','" . $lc_value . "',GETDATE(),GETDATE(),'" . $uid . "',0,"
                . "            '" . $applicant . "','" . $app_bank . "','" . $bf_bank . "','" . $bf_bank_address . "','" . $currency . "','" . $forex . "','" . $inr_val . "','" . $inco_terms . "','" . $country . "')");
    
//        echo "insert into swift_lcmaster(lcm_id,lcm_venid,lcm_num,lcm_date,lcm_from,lcm_to,lcm_value,lcm_balance,lcm_created,lcm_updated,lcm_userid,lcm_cpid"
//                . "            lcm_appname,lcm_appbank,lcm_venbank,lcm_venbankaddress,lcm_currency,lcm_forex,lcm_valueinr,lcm_incoterms,lcm_country)"
//                . "            values('" . $id . "','" . $vendor . "','" . $lc_number . "','" . $lc_date . "','" . $valid_from . "','" . $valid_to . "','" . $lc_value . "','" . $inr_val . "',GETDATE(),GETDATE(),'" . $uid . "',0,"
//                . "            '" . $applicant . "','" . $app_bank . "','" . $bf_bank . "','" . $bf_bank_address . "','" . $currency . "','" . $forex . "','" . $inr_val . "','" . $inco_terms . "','" . $country . "')";
         
    }
    if ($insert) {

        $update_lcd = mssql_query("update lc_creation_details set lcr_lcid='" . $id . "' where lcr_vid='" . $vendor . "'");
        $update_lcm = mssql_query("update lc_creation_masters set lcm_lcid='" . $id . "' where lcm_vid='" . $vendor . "'");
        if ($update_lcm) {
            echo "<script>window.location.href='../lc_master?vid=" . $vendor . "';</script>";
        }
    }
}

if (isset($_REQUEST['lcmst_update'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $lc_number = $lc_num;
    $lc_date = formatDate(str_replace('/', '-', $lc_date), 'Y-m-d h:i:s');
    $valid_from = formatDate(str_replace('/', '-', $from_lc), 'Y-m-d h:i:s');
    $valid_to = formatDate(str_replace('/', '-', $to_lc), 'Y-m-d h:i:s');
    $lc_value = $lc_value;
    $vendor = $vendor;
// Check LC already Exsits for selected Vendor    
    $sql = "select * from swift_lcmaster where  lcm_num='" . $lc_number . "' and lcm_id='" . $lcid . "' ";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $update = mssql_query("update swift_lcmaster set lcm_venid='" . $vendor . "',lcm_date='" . $lc_date . "',lcm_from='" . $valid_from . "',lcm_to='" . $valid_to . "',lcm_value='" . $lc_value . "',lcm_updated=GETDATE(),lcm_userid='" . $uid . "',"
                . "lcm_appname='" . $applicant . "',lcm_appbank='" . $app_bank . "',lcm_venbank='" . $bf_bank . "',lcm_venbankaddress='" . $bf_bank_address . "',lcm_currency='" . $currency . "',lcm_forex='" . $forex . "',lcm_valueinr='" . $inr_val . "',lcm_incoterms='" . $inco_terms . "',lcm_country='" . $country . "'"
                . "where lcm_num='" . $lc_number . "' and lcm_id='" . $lcid . "' ");
    } else {
        if ($page == 1) {
            echo "<script>window.location.href='../lc_extension';</script>";
        } else {
            echo "<script>window.location.href='../lc_master?vid=" . $vendor . "';</script>";
        }
    }
    if ($update) {
        $update_lcd = mssql_query("update lc_creation_details set lcr_lcid='" . $lcid . "' where lcr_vid='" . $vendor . "'");
        $update_lcm = mssql_query("update lc_creation_masters set lcm_lcid='" . $lcid . "' where lcm_vid='" . $vendor . "'");
        if ($update_lcm) {

            if ($page == 1) {
                echo "<script>window.location.href='../lc_extension';</script>";
            } else {
                echo "<script>window.location.href='../lc_master?vid=" . $vendor . "';</script>";
            }
//            echo "<script>window.location.href='../lc_master?vid=" . $vendor . "';</script>";
        }
    }
}


if (isset($_REQUEST['dt_create'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_bank_details where bank_name='" . filterText($dt_doctype) . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    
    if ($num_rows > 0) {

        echo "<script>window.location.href='../bank_master?msg=0';</script>";
    } else {
        $isql = mssql_query("select isnull (max(bid+1),1) as id from  swift_bank_details");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];

        $sql = mssql_query("insert into swift_bank_details(bid,bank_name,bank_address)"
                . "values('" . $id . "','" . $dt_doctype . "','" . $dt_docname . "')");
       
        
        if ($sql) {

            echo "<script>window.location.href='../bank_master';</script>";
        }
    }
}
if (isset($_REQUEST['dt_update'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_bank_details where bid='" . $dt_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $update = mssql_query("update swift_bank_details set bank_name='" . $dt_doctype . "',bank_address='" . $dt_docname . "'  where bid='" . $dt_id . "' ");
        if ($update) {
            echo "<script>window.location.href='../bank_master';</script>";
        }
    } else {
        echo "<script>window.location.href='../bank_master?msg=1';</script>";
    }
}
if (isset($_REQUEST['id'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $dt_id = $_REQUEST['id'];
    $sql = "select * from  swift_bank_details where bid='" . $dt_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $delete = mssql_query("delete from swift_bank_details where bid='" . $dt_id . "' ");
        if ($delete) {
            echo "<script>window.location.href='../bank_master';</script>";
        }
    } else {
        echo "<script>window.location.href='../bank_master?msg=1';</script>";
    }
}

if (isset($_REQUEST['tc_create'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_credit_periods where cp_period='" . filterText($tc_teamcode) . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {

        echo "<script>window.location.href='../cp_master?msg=0';</script>";
    } else {
        $isql = mssql_query("select isnull (max(cp_id+1),1) as id from  swift_credit_periods");
        $row = mssql_fetch_array($isql);
        $id = $row['id'];

        $sql = mssql_query("insert into swift_credit_periods(cp_id,cp_period)"
                . "values('" . $id . "','" . $tc_teamcode . "')");
        if ($sql) {

            echo "<script>window.location.href='../cp_master';</script>";
        }
    }
}
if (isset($_REQUEST['tc_update'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $sql = "select * from  swift_credit_periods where cp_id='" . $tc_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $update = mssql_query("update swift_credit_periods set cp_period='" . $tc_teamcode . "'  where cp_id='" . $tc_id . "' ");
        if ($update) {
            echo "<script>window.location.href='../cp_master';</script>";
        }
    } else {
        echo "<script>window.location.href='../cp_master?msg=1';</script>";
    }
}if (isset($_REQUEST['tcid'])) {
    extract($_REQUEST);
    $uid = $_SESSION['uid'];
    $tc_id = $_REQUEST['tcid'];
    $sql = "select * from  swift_credit_periods where cp_id='" . $tc_id . "'";
    $query = mssql_query($sql);
    $num_rows = mssql_num_rows($query);
    if ($num_rows > 0) {
        $delete = mssql_query("delete from swift_credit_periods where cp_id='" . $tc_id . "' ");
        if ($delete) {
            echo "<script>window.location.href='../cp_master';</script>";
        }
    } else {
        echo "<script>window.location.href='../cp_master?msg=1';</script>";
    }
}
?>