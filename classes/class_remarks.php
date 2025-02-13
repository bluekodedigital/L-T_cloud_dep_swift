<?php

class Remarks {
    // sakthi
    function ops_spoc_cur_remarks($packid){
        $sql = "SELECT ts_remarks FROM swift_techspoc WHERE ts_active= '1' AND ts_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    // sakthi
    function ops_spoc_pre_remarks($packid){
        $sql = "SELECT ts_sentdate,ts_remarks FROM swift_techspoc WHERE ts_active= '0' AND ts_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    // sakthi
    function spoc_exp_cur_remarks($packid){
        $sql = "SELECT txp_remarks FROM swift_techexpert WHERE txp_active= '1' AND txp_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    // sakthi
    function spoc_exp_pre_remarks($packid){
        $sql = "SELECT txp_sentdate,txp_remarks FROM swift_techexpert WHERE txp_active= '0' AND txp_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    // sakthi
    function exp_cto_cur_remarks($packid){
        $sql = "SELECT cto_remarks FROM swift_techcto WHERE cto_active= '1' AND cto_packid='$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    // sakthi
    function exp_cto_pre_remarks($packid){
        $sql = "SELECT cto_sentdate,cto_remarks FROM swift_techcto WHERE cto_active= '0' AND cto_packid='$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    // sakthi
    function ops_scm_cur_remarks($packid){
        $sql = "SELECT sc_remarks FROM swift_SCMSPOC WHERE sc_active = '1' AND sc_packid = '$packid'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }
    // sakthi
    function ops_scm_pre_remarks($packid){
        $sql = "SELECT sc_sentdate,sc_remarks FROM swift_SCMSPOC WHERE sc_active = '0' AND sc_packid = '$packid'";
        $query = mssql_query($sql);
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    
}

?>