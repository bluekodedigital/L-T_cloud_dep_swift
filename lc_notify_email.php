<?php
// error_reporting(1);
include 'config/inc.php';
require 'PHPMailer/PHPMailerAutoload.php';

class createTest {

// Pendings files Received from OPS
    function get_pendings($due) {
//         $sql = "select d.lcm_num,a.*,b.sol_name,c.proj_name, DATEDIFF(DAY,GETDATE(),d.lcm_to) as validity,
// DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date) AS DateAdd,lcr_supply_date,
// DATEDIFF(DAY,GETDATE(),(DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date))) as payment_due
// from  lc_creation_details as a,solution as b,Project as c,swift_lcmaster as d
// where a.lcr_packid=b.sol_id and a.lcr_projid=c.proj_id  and a.lcr_lcid=d.lcm_id and 
// d.lcm_id= a.lcr_lcid and isnull(lcr_supply,0) >0 and 
// DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date) ='" . $due . "'";
$sql = "select d.lcm_num,a.*,b.sol_name,c.proj_name, DATEDIFF(DAY,GETDATE(),d.lcm_to) as validity,
DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date) AS DateAdd,lcr_supply_date,
DATEDIFF(DAY,GETDATE(),(DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date))) as payment_due
from  lc_creation_details as a,solution as b,Project as c,swift_lcmaster as d
where a.lcr_packid=b.sol_id and a.lcr_projid=c.proj_id  and 
d.lcm_id= a.lcr_lcid and isnull(lcr_supply,0) >0 and  
DATEDIFF(DAY,GETDATE(),(DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date))) >='" . $due . "'
and 
DATEDIFF(DAY,GETDATE(),(DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date))) <='" . $due . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }  
    function get_pendings_formonth() {
        $sql = "select d.lcm_num,a.*,b.sol_name,c.proj_name, DATEDIFF(DAY,GETDATE(),d.lcm_to) as validity,
DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date) AS DateAdd,lcr_supply_date,
DATEDIFF(DAY,GETDATE(),(DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date))) as payment_due
from  lc_creation_details as a,solution as b,Project as c,swift_lcmaster as d
where a.lcr_packid=b.sol_id and a.lcr_projid=c.proj_id  and 
d.lcm_id= a.lcr_lcid and isnull(lcr_supply,0) >0 and  
DATEDIFF(DAY,GETDATE(),(DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date))) >=0
and 
DATEDIFF(DAY,GETDATE(),(DATEADD(day, (convert(int,lcr_payterms)), lcr_supply_date))) <=30";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

    function send_mail($today_pending, $day) {
        $message = '<div width="100%" style="background: #f8f8f8;  font-family:verdana; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
    <div style="max-width: 100%;  font-size: 12px">
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: -30px">
            <tbody>
                <tr>
                    <td style="vertical-align: top; " align="center">
                        <!-- <img src="../images/logo-dark.png" alt="Eliteadmin Responsive web app kit" style="border:none" height="100px;" width="100px"> -->
                    </td>
                </tr>
            </tbody>
        </table><br>  <div style=" background: #fff;  font-family: calibri; font-size: 16px; font-weight: normal; font-size: 16px;">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;" >
                <tbody>
                    <tr>
                        <td><b>Dear Sir/Madam,</b>

                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; Margin-bottom: 15px;">The Following POs/LOIs are due for Payment in  ' . $day . ' Days , Please take necessary action for Payment..</p>
                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; ">Please use the below links to view </p>
                            <p  style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal;   Margin-bottom: 15px;"> <a href="https://swc.ltts.com/swift/lc" target="blank">Link - LC Track</a></p>';

        $message .= '<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px" class="handsontable">
                                <thead >
                                
                                    <tr>
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;">LC Number</th> 
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;">PO Number</th> 
                                        <th style=" padding:5px;  text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;">Project</th>
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;">Package</th>                                                         
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;">PO Value</th>                  
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;  ">PO Type</th>
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;  ">Payterms</th>
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;">Supply value</th>
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;">Supply Date</th>
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;">Supply Exchange Rate</th>
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;">Payment Due in Days</th>
                                        <th style=" padding:5px; text-align: center; background-color:#2F5496; color:#fff;  border: 1px solid #ddd;">Payment Due Date</th>
                                      </tr>
                                </thead>
                                <tbody>';


        foreach ($today_pending as $key => $value) {
            if ($value['lcr_potype'] == 1) {
                $potype = "Import";
            } else {
                $potype = "Domestic";
            }
            if ($value['payment_due'] == 0) {
                $payment_due = "Expired (Today)";
                $color = 'color: red';
            } else {
                $payment_due = $value['payment_due'] . " Days";
                $color = '';
            }

            $message .= '  <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $value['lcm_num'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $value['lcr_ponumber'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $value['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $value['sol_name'] . '</td>                                                                       
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> ' . number_format($value['lcr_povalue'], 2) . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd; max-width:300px">' . $potype . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $value['lcr_payterms'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . number_format($value['lcr_supply'], 2) . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . date('d-M-Y', strtotime($value['lcr_supply_date'])) . '</td>                                       
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . number_format($value['lcr_supply_exchange'], 2) . '</td>                                       
                                        <td style=" text-align: center;  border: 1px solid #ddd; ' . $color . ';">' . $payment_due . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . date('d-M-Y', strtotime($value['DateAdd'])) . '</td>
                    </tr>';
        }

        $message .= '   </tbody>
                            </table><br>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Regards,</p>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><b>LC - Track</b></p>

                            <p style="font-family:calibri;color:lightgray;font-size:14px">This is Auto generated mail hence Please do not reply</p>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>';

        $message .= '<div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
            <p> Powered by Bluekode
                <br>
        </div>
    </div>
</div>';

        // echo $message;

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
//Server settingss
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
//Server settingss
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
            $mail->Password = '!Lntswc123';                      // SMTP password
//        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;
// TCP port to connect to
//Recipients
            $mail->setFrom('weblntswcdigital@gmail.com', 'LC - Track');
// $mail->addAddress($emailk, $name); // Add a recipient
//            $mail->addAddress('uuk@lntecc.com', 'SWIFT'); // Add a recipient
            $mail->ClearAddresses();

          
           $mail->addAddress('uuk@lntecc.com', ''); // Name is optional
             $mail->addBCC('srini.rpsm@gmail.com', ''); // Name is optional
//            $mail->addAddress('info@bluekode.com', ''); // Name is optional
//          $mail->addAddress('srini.ksss@gmail.com'); // Name is optional
// $mail->addReplyTo('info@example.com', 'Information');
//            $mail->addCC('srini.rpsm@gmail.com');
//        $mail->addCC('uuk@lntecc.com');
//            $mail->addCC('uuk@lntecc.com');
//$mail->addBCC('bcc@example.com');
//Attachments
// $mail->addAttachment('C:/xampp/htdocs/QA/fpdf/status_pdf/'.$filename);                    // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');// Optional name
//Content
            $mail->isHTML(true);                                 // Set email format to HTML
// $mail->AddEmbeddedImage('logo.png', 'logoimg'); // attach file logo.jpg, and later link to it using identfier logoimg

            $mail->Subject = 'LC - Track';
            $mail->Body = $message;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//        $isql = mssql_query("select isnull (max(sms_id+1),1) as id from  sms_tracking");
//        $row = mssql_fetch_array($isql);
//        $sid = $row['id'];
//        $sql = mssql_query("insert into sms_tracking (sms_id,sms_userid,sms_email,sent_date,_type)"
//                . "values('" . $sid . "','" . $recvid . "','" . $name . "',GETDATE(),'1')");
            $mail->send();
            $Msg = "Mail Send";
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            $Msg = "Mail Not Send";
        }
    }

}

$createTest = new createTest;
?>
<style>
    .handsontable th,
    .handsontable td {
        border-right: 1px solid red;
        border-bottom: 1px solid red;
        height: 22px;
        line-height: 21px;
        padding: 0 4px 0 4px; 
        background-color: #FFF;
        font-size: 12px;
        vertical-align: top;
        overflow: hidden;
    }
</style>
<?php

$today = date('Y-m-d');
$five = date('Y-m-d', strtotime($today . '+5 days'));
$ten = date('Y-m-d', strtotime($today . '+10 days'));
$thirty = date('Y-m-d', strtotime($today . '+30 days'));


// $get_today_pendings = $createTest->get_pendings($today);
// $today_pending = json_decode($get_today_pendings, true);

// $get_five_pendings = $createTest->get_pendings($five);
// $five_pending = json_decode($get_five_pendings, true);

// $get_ten_pendings = $createTest->get_pendings($ten);
// $ten_pending = json_decode($get_ten_pendings, true);

// $get_thirty_pendings = $createTest->get_pendings($thirty);
// $thirty_pending = json_decode($get_thirty_pendings, true);

$get_pendings_formonth = $createTest->get_pendings_formonth();
$pendings_formonth = json_decode($get_pendings_formonth, true);
 


// if (sizeof($today_pending) > 0) {
//     $send_mail = $createTest->send_mail($today_pending, '0');
// }
// if (sizeof($five_pending) > 0) {
//     $send_mail = $createTest->send_mail($five_pending, '5');
// }
// if (sizeof($ten_pending) > 0) {
//     $send_mail = $createTest->send_mail($ten_pending, '18');
// }
// if (sizeof($thirty_pending) > 0) {
//     $send_mail = $createTest->send_mail($thirty_pending, '30');
// }
if (sizeof($pendings_formonth) > 0) {
    $send_mail = $createTest->send_mail($pendings_formonth, '30');
}

?>


