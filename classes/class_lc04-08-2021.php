<?php

class Lc {

    function credit_period() {
        $sql = "select * from swift_credit_periods";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_bank() {
        $sql = "select * from swift_bank_details";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_currency() {
        $sql = "select * from currency_master";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function vendor_select() {
        $sql = "select * from vendor order by sup_name";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function vendor_select_by_vendor($vid) {
        $sql = "select * from vendor where sup_id='" . $vid . "' order by sup_name";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_lcmaster($vid) {
        if ($vid == "") {
            $sql = " select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*
                 from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e
                 where a.lcm_venid=b.sup_id  and a.lcm_appbank=d.bid and a.lcm_currency=e.id";
        } else {
            $sql = " select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*
                 from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e
                 where a.lcm_venid=b.sup_id  and a.lcm_appbank=d.bid and a.lcm_currency=e.id and lcm_venid='" . $vid . "'";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_lcmaster_bylc($lc) {

        $sql = " select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*
                 from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e
                 where a.lcm_venid=b.sup_id  and a.lcm_appbank=d.bid and a.lcm_currency=e.id and a.lcm_id='" . $lc . "'";


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function changelc($lcid) {
        $sql = "select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*
                 from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e
                 where a.lcm_venid=b.sup_id  and a.lcm_appbank=d.bid and a.lcm_currency=e.id and a.lcm_id='" . $lcid . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function count_lc($id) {
        $sql = " select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*
                 from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e
                 where a.lcm_venid=b.sup_id and a.lcm_appbank=d.bid and a.lcm_currency=e.id";
        $query = mssql_query($sql);
        $row = mssql_num_rows($query);

        return $row;
    }
    function getPoVal($id) {
        $sql = "  select sum(lcr_povalue) as poVal from lc_creation_details where lcr_lcid ='".$id."'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);

        return $row;
    }

    function select_lc($vid) {
        $sql = " select distinct s_qid,b.vq_venid,b.vq_solid,c.sol_name,c.swift_packid,sum(vq_quoteamt) as po_value,d.proj_name,e.vqd_paytrm,d.proj_id from Quote_status as a, 
                    vendorquotemst as b,solution as c,Project as d,vendorquotedetl e where a.s_qid = b.vq_doc_id and b.vq_solid =c.sol_id and
                     c.sol_projid=d.proj_id and e.vqd_docid=a.s_qid and b.vq_venid='" . $vid . "'
                    group by s_qid,b.vq_venid,b.vq_solid,c.sol_name,c.swift_packid,d.proj_name,e.vqd_paytrm,d.proj_id ";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_lc_creation($vid) {
        $sql = " select distinct s_qid,b.vq_venid,b.vq_solid,c.sol_name,c.swift_packid,sum(vq_quoteamt) as po_value,d.proj_name,e.vqd_paytrm,d.proj_id from Quote_status as a, 
                    vendorquotemst as b,solution as c,Project as d,vendorquotedetl e where a.s_qid = b.vq_doc_id and b.vq_solid =c.sol_id and
                     c.sol_projid=d.proj_id and e.vqd_docid=a.s_qid and b.vq_venid='" . $vid . "'   
                    group by s_qid,b.vq_venid,b.vq_solid,c.sol_name,c.swift_packid,d.proj_name,e.vqd_paytrm,d.proj_id ";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

//    function select_lc_creation($vid) {
//        $sql = " select distinct s_qid,b.vq_venid,b.vq_solid,c.sol_name,c.swift_packid,sum(vq_quoteamt) as po_value,d.proj_name,e.vqd_paytrm,d.proj_id from Quote_status as a, 
//                    vendorquotemst as b,solution as c,Project as d,vendorquotedetl e where a.s_qid = b.vq_doc_id and b.vq_solid =c.sol_id and
//                     c.sol_projid=d.proj_id and e.vqd_docid=a.s_qid and b.vq_venid='" . $vid . "'  and a.s_qid not in(select lcr_qid from lc_creation_details where lcr_vid='" . $vid . "')
//                    group by s_qid,b.vq_venid,b.vq_solid,c.sol_name,c.swift_packid,d.proj_name,e.vqd_paytrm,d.proj_id ";
//
//        $query = mssql_query($sql);
//        $result = array();
//        while ($row = mssql_fetch_array($query)) {
//            $result[] = $row;
//        }
//        $res = json_encode($result);
//        return $res;
//    }

    function select_created_pos($vid) {
        $sql = " select a.lcr_qid,a.lcr_vid,a.lcr_projid,a.lcr_packid,a.lcr_uid,a.lcr_povalue,a.lcr_potype,
                a.lcr_payterms,a.lcr_update,a.lcr_ponumber,b.sol_name,c.proj_name
                from  lc_creation_details as a,solution as b,Project as c
                where a.lcr_packid=b.sol_id and a.lcr_projid=c.proj_id and a.lcr_vid='" . $vid . "'";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_created_pos_by_lc($lc) {
        $sql = " select a.*,b.sol_name,c.proj_name
                from  lc_creation_details as a,solution as b,Project as c
                where a.lcr_packid=b.sol_id and a.lcr_projid=c.proj_id and a.lcr_lcid='" . $lc . "'";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_lc($lc) {

        $sql = " select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*
                 from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e
                 where a.lcm_venid=b.sup_id  and a.lcm_appbank=d.bid and a.lcm_currency=e.id and lcm_id='" . $lc . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;
    }

    function select_lcmaster_bydue($days) {
        $sql = "select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*
              from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e
              where a.lcm_venid=b.sup_id  and a.lcm_appbank=d.bid and a.lcm_currency=e.id and DATEDIFF(DAY,GETDATE(),a.lcm_to) >='" . $days . "'";


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_lcmaster_bydue_filter($days) {
        $sql = " select distinct d.lcm_id,d.lcm_num
 from lc_creation_details as a,solution as b,Project as c,swift_lcmaster as d where a.lcr_packid=b.sol_id 
 and a.lcr_projid=c.proj_id and d.lcm_id= a.lcr_lcid and isnull(lcr_supply,0) >0 
 and DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date) ='" . $days . "'";


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_lcmaster_bydue_filter_all() {
        $sql = " select distinct d.lcm_id,d.lcm_num
 from lc_creation_details as a,solution as b,Project as c,swift_lcmaster as d where a.lcr_packid=b.sol_id 
 and a.lcr_projid=c.proj_id and d.lcm_id= a.lcr_lcid and isnull(lcr_supply,0) >0 ";


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_created_pos_by_lc_due($lc) {
        $sql = " select a.*,b.sol_name,c.proj_name, DATEDIFF(DAY,GETDATE(),d.lcm_to) as validity
                from  lc_creation_details as a,solution as b,Project as c,swift_lcmaster as d
                where a.lcr_packid=b.sol_id and a.lcr_projid=c.proj_id and a.lcr_lcid='" . $lc . "' and d.lcm_id= a.lcr_lcid and isnull(lcr_supply,0) >0 ";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_created_pos_by_lc_due_latest($lc, $days) {
        if ($days == 'all') {
            $sql = " select a.*,b.sol_name,c.proj_name, DATEDIFF(DAY,GETDATE(),d.lcm_to) as validity,
DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date) AS DateAdd,lcr_supply_date,
DATEDIFF(DAY,GETDATE(),(DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date))) as payment_due
from  lc_creation_details as a,solution as b,Project as c,swift_lcmaster as d
where a.lcr_packid=b.sol_id and a.lcr_projid=c.proj_id and a.lcr_lcid='" . $lc . "' and 
d.lcm_id= a.lcr_lcid and isnull(lcr_supply,0) >0 ";
        } else {
            $sql = " select a.*,b.sol_name,c.proj_name, DATEDIFF(DAY,GETDATE(),d.lcm_to) as validity,
DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date) AS DateAdd,lcr_supply_date,
DATEDIFF(DAY,GETDATE(),(DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date))) as payment_due
from  lc_creation_details as a,solution as b,Project as c,swift_lcmaster as d
where a.lcr_packid=b.sol_id and a.lcr_projid=c.proj_id and a.lcr_lcid='" . $lc . "' and 
d.lcm_id= a.lcr_lcid and isnull(lcr_supply,0) >0 and 
DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date) ='" . $days . "'";
        }


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_banks() {
        $sql = "select * from [dbo].[swift_bank_details]";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_credits() {
        $sql = "select * from [dbo].[swift_credit_periods]";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function get_paid($lc_id) {
        $sql1 = "select sum(lph_payment) as total_payment from lc_payment_history where  lph_lcid='" . $lc_id . "' ";
        $qret = mssql_query($sql1);
        $row = mssql_fetch_array($qret);
        $total_payment = $row['total_payment'];
        return $total_payment;
    }

    function select_lcmaster_report($vid) {
        if ($vid == "") {
            $sql = " select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*,f.*
from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e,lc_creation_masters as f
where a.lcm_venid=b.sup_id and a.lcm_appbank=d.bid and a.lcm_currency=e.id and a.lcm_id=f.lcm_lcid";
        } else {
              $sql = " select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*,f.*
from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e,lc_creation_masters as f
where a.lcm_venid=b.sup_id and a.lcm_appbank=d.bid and a.lcm_currency=e.id and a.lcm_id=f.lcm_lcid and lcm_venid='" . $vid . "'";


//             $sql = " select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*,f.*
// from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e,lc_creation_masters as f
// where a.lcm_venid=b.sup_id and a.lcm_cpid=c.cp_id and a.lcm_appbank=d.bid and a.lcm_currency=e.id and a.lcm_id=f.lcm_lcid and lcm_venid='" . $vid . "'";
        }

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_lcmaster_report_das($vid) {

        $sql = " select b.sup_name,a.*, DATEDIFF(DAY,GETDATE(),a.lcm_to) as validity,d.*,e.*,f.*
from swift_lcmaster as a,Vendor as b, swift_bank_details as d,currency_master as e,lc_creation_masters as f
where a.lcm_venid=b.sup_id  and a.lcm_appbank=d.bid and a.lcm_currency=e.id and a.lcm_id=f.lcm_lcid and lcm_venid='" . $vid . "'";


        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_package() {
        $sql = "select * from solution";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_country() {
        $sql = "select * from country_list";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_supply_payment_report($vid) {
        if ($vid == "") {
            $sql = "select b.lcr_ponumber,c.lcm_num,d.sup_name,a.*,
 (select max(lc_pydate) from lc_payment_update_detls as e where e.lc_pyqid=a.lc_sup_qid  and e.lc_pylcid=a.lc_sup_lcid ) as paymet_date,
 (select sum(lc_pyval) from lc_payment_update_detls as e where e.lc_pyqid=a.lc_sup_qid  and e.lc_pylcid=a.lc_sup_lcid ) as paymet_value,
 (select max(lph_exchange) from lc_payment_history as e where c.lcm_id=e.lph_lcid  ) as paymet_exrate,
 b.lcr_povalue 
 from lc_supply_updation as a 
 left join lc_creation_details as b on b.lcr_id = a.lc_sup_qid  
 left join swift_lcmaster as c on c.lcm_id=a.lc_sup_lcid
 left join Vendor as d on d.sup_id = b.lcr_vid";
        } else {
            $sql = "select b.lcr_ponumber,c.lcm_num,d.sup_name,a.*,
 (select max(lc_pydate) from lc_payment_update_detls as e where e.lc_pyqid=a.lc_sup_qid  and e.lc_pylcid=a.lc_sup_lcid ) as paymet_date,
 (select sum(lc_pyval) from lc_payment_update_detls as e where e.lc_pyqid=a.lc_sup_qid  and e.lc_pylcid=a.lc_sup_lcid ) as paymet_value,
 (select max(lph_exchange) from lc_payment_history as e where c.lcm_id=e.lph_lcid  ) as paymet_exrate,
 b.lcr_povalue 
 from lc_supply_updation as a 
 left join lc_creation_details as b on b.lcr_id = a.lc_sup_qid  
 left join swift_lcmaster as c on c.lcm_id=a.lc_sup_lcid
 left join Vendor as d on d.sup_id = b.lcr_vid where d.sup_id ='" . $vid . "' ";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_supply_payment_report_view($lc) {
        if ($lc == "") {
            $sql = "select b.lcr_ponumber,c.lcm_num,d.sup_name,a.*,
 (select max(lc_pydate) from lc_payment_update_detls as e where e.lc_pyqid=a.lc_sup_qid  and e.lc_pylcid=a.lc_sup_lcid ) as paymet_date,
 (select sum(lc_pyval) from lc_payment_update_detls as e where e.lc_pyqid=a.lc_sup_qid  and e.lc_pylcid=a.lc_sup_lcid ) as paymet_value,
  (select max(lph_exchange) from lc_payment_history as e where c.lcm_id=e.lph_lcid  ) as paymet_exrate,

 b.lcr_povalue 
 from lc_supply_updation as a 
 left join lc_creation_details as b on b.lcr_id = a.lc_sup_qid  
 left join swift_lcmaster as c on c.lcm_id=a.lc_sup_lcid
 left join Vendor as d on d.sup_id = b.lcr_vid";
        } else {
            $sql = "select b.lcr_ponumber,c.lcm_num,d.sup_name,a.*,
 (select max(lc_pydate) from lc_payment_update_detls as e where e.lc_pyqid=a.lc_sup_qid  and e.lc_pylcid=a.lc_sup_lcid ) as paymet_date,
 (select sum(lc_pyval) from lc_payment_update_detls as e where e.lc_pyqid=a.lc_sup_qid  and e.lc_pylcid=a.lc_sup_lcid ) as paymet_value,
 (select max(lph_exchange) from lc_payment_history as e where c.lcm_id=e.lph_lcid  ) as paymet_exrate,
 b.lcr_povalue 
 from lc_supply_updation as a 
 left join lc_creation_details as b on b.lcr_id = a.lc_sup_qid  
 left join swift_lcmaster as c on c.lcm_id=a.lc_sup_lcid
 left join Vendor as d on d.sup_id = b.lcr_vid where c.lcm_id ='" . $lc . "' ";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function select_supply_payment_log($lc) {
        if ($lc == "") {
            $sql = "select   b.lcr_ponumber,c.lcm_num,d.sup_name,e.lc_pydatetime ,e.lc_pydate,lc_pyval,b.lcr_povalue  
 from lc_supply_updation as a 
 left join lc_creation_details as b on b.lcr_id = a.lc_sup_qid  
 left join swift_lcmaster as c on c.lcm_id=a.lc_sup_lcid
 left join Vendor as d on d.sup_id = b.lcr_vid
 left join lc_payment_update_detls as e on e.lc_pyqid  = a.lc_sup_qid ";
        } else {
            $sql = " select   b.lcr_ponumber,c.lcm_num,d.sup_name,e.lc_pydatetime,e.lc_pydate,lc_pyval,b.lcr_povalue  
 from lc_supply_updation as a 
 left join lc_creation_details as b on b.lcr_id = a.lc_sup_qid  
 left join swift_lcmaster as c on c.lcm_id=a.lc_sup_lcid
 left join Vendor as d on d.sup_id = b.lcr_vid
 left join lc_payment_update_detls as e on e.lc_pyqid  = a.lc_sup_qid  where c.lcm_id='" . $lc . "' ";
        }
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function lc_dasboard() {

        $sql = " select g.sup_name,lcr_payterms AS credit_days,b.sol_name,h.bank_name, e.currency_hname,c.proj_name,c.proj_jobcode,a.lcr_ponumber,a.lcr_povalue,d.lcm_num,a.lcr_supply,
d.lcm_value,d.lcm_from,d.lcm_to,lcr_supply_date,d.lcm_value-a.lcr_supply as balance_ship,
(select sum(lc_pyval) from lc_payment_update_detls as f where f.lc_pylcid = a.lcr_lcid and f.lc_pyqid =a.lcr_id ) as paid_value
from  lc_creation_details as a 
left join solution as b on a.lcr_packid=b.sol_id
left join Project as c on c.proj_id=a.lcr_projid
left join swift_lcmaster as d on d.lcm_id = a.lcr_lcid
left join currency_master as e on e.id=d.lcm_currency
left join Vendor as g on g.sup_id= lcr_vid
left join swift_bank_details as h on h.bid= d.lcm_appbank
order by g.sup_name ASC ";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function lc_dasboard_graph() {

        $sql = " select   sup_name as Vendor,lcm_value as LC_Value,sum(lcr_supply) as supply ,sum(paid_value) as paid from (select g.sup_name,lcr_payterms AS credit_days,b.sol_name,h.bank_name, e.currency_hname,c.proj_name,c.proj_jobcode,a.lcr_ponumber,a.lcr_povalue,d.lcm_num,a.lcr_supply,
d.lcm_value,d.lcm_from,d.lcm_to,lcr_supply_date,d.lcm_value-a.lcr_supply as balance_ship,
(select sum(lc_pyval) from lc_payment_update_detls as f where f.lc_pylcid = a.lcr_lcid and f.lc_pyqid =a.lcr_id ) as paid_value
from  lc_creation_details as a 
left join solution as b on a.lcr_packid=b.sol_id
left join Project as c on c.proj_id=a.lcr_projid
left join swift_lcmaster as d on d.lcm_id = a.lcr_lcid
left join currency_master as e on e.id=d.lcm_currency
left join Vendor as g on g.sup_id= lcr_vid
left join swift_bank_details as h on h.bid= d.lcm_appbank
 ) X
group by sup_name,lcm_value";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_assoc($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function lc_dasboard_graph1() {

        $sql = " select   sup_name as Vendor,FlOOR(lcm_value/100000) as LC_Value,FlOOR(sum(lcr_supply)/100000) as supply ,FlOOR(sum(paid_value)/100000) as paid from (select g.sup_name,lcr_payterms AS credit_days,b.sol_name,h.bank_name, e.currency_hname,c.proj_name,c.proj_jobcode,a.lcr_ponumber,a.lcr_povalue,d.lcm_num,a.lcr_supply,
d.lcm_value,d.lcm_from,d.lcm_to,lcr_supply_date,d.lcm_value-a.lcr_supply as balance_ship,
(select sum(lc_pyval) from lc_payment_update_detls as f where f.lc_pylcid = a.lcr_lcid and f.lc_pyqid =a.lcr_id ) as paid_value
from  lc_creation_details as a 
left join solution as b on a.lcr_packid=b.sol_id
left join Project as c on c.proj_id=a.lcr_projid
left join swift_lcmaster as d on d.lcm_id = a.lcr_lcid
left join currency_master as e on e.id=d.lcm_currency
left join Vendor as g on g.sup_id= lcr_vid
left join swift_bank_details as h on h.bid= d.lcm_appbank
 ) X
group by sup_name,lcm_value order by lcm_value DESC ";

        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_assoc($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }
    function getForex($id){
        $sql = "  select * from  swift_lcmaster where lcm_id='" . $id . "'";
        $query = mssql_query($sql);
        $row = mssql_fetch_array($query);
        return $row;

    }

}

?>