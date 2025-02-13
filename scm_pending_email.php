<?php

// include 'config/inc.php';
include_once("config/db_con.php");
require 'PHPMailer/PHPMailerAutoload.php';

class createTest {

// Pendings files Received from OPS
    function pending_files_recevied_from_cto() {
        $sql = "SELECT a.name,b.name as pen,sc_id,proj_name,pm_packagename,sc_packid,sc_projid,sc_senderuid,sc_recvuid,sc_sendr_stageid,sc_recv_stageid,sc_sentdate,sc_planneddate,sc_expdate,sc_actual,
            sc_remarks,sc_status,sc_active,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,revised_planned_date as planned,ps_expdate,ps_actualdate,shot_name
            FROM swift_SCMSPOC,swift_packagestatus,swift_packagemaster,usermst as a, usermst as b,Project, swift_stage_master 
            WHERE ps_stageid = '13' and sc_packid=ps_packid AND sc_packid=pm_packid AND sc_status='0' AND sc_active='1' and
            sc_projid=proj_id  and a.uid=sc_senderuid and b.uid=sc_recvuid and sc_recv_stageid=stage_id and    DATEDIFF(DAY,sc_sentdate,GETDATE())>3";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

// Pendings files sent back by buyer
    function pending_files_recevied_from_buyer() {
        $sql = "SELECT a.name,b.name as pen,proj_name,pm_packagename,bu_id,bu_packid,bu_projid,bu_buyer_id as sender_id,bu_sentdate,bu_ace_value,bu_sales_value,sb_remarks,
            revised_planned_date as planned,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,shot_name
            FROM swift_SCMtoBUYER,swift_packagestatus,swift_packagemaster,usermst as a, usermst as b,Project, swift_stage_master 
            WHERE ps_stageid = '13' AND bu_packid=ps_packid AND bu_packid=pm_packid AND bu_status='2' 
            and bu_projid=proj_id  and a.uid=bu_senderuid and b.uid=bu_buyer_id and stage_id=13";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

//  pending_files_pennding_with_buyer
    function pending_files_pennding_with_buyer() {
        $sql = "SELECT a.name,b.name as pen,proj_name,pm_packagename,bu_id,bu_packid,bu_projid,bu_buyer_id as sender_id,bu_sentdate,bu_ace_value,bu_sales_value,sb_remarks,
            revised_planned_date as planned,pm_material_req as schedule_date,pm_revised_material_req as mat_req_date,ps_expdate,ps_actualdate,shot_name
            FROM swift_SCMtoBUYER,swift_packagestatus,swift_packagemaster,usermst as a, usermst as b,Project, swift_stage_master 
            WHERE ps_stageid = '13' AND bu_packid=ps_packid AND bu_packid=pm_packid AND bu_status='0' 
            and bu_projid=proj_id  and a.uid=bu_senderuid and b.uid=bu_buyer_id and stage_id=13";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
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

$segment = 28;

$sql = mssql_query("select * from usermst where deptid='" . $segment . "'");
$row = mssql_fetch_array($sql);
$name = $row['uname'];
$recvid = $row['uid'];
//echo $name . '<br>';

$get_opstoom = $createTest->pending_files_recevied_from_cto();
$opstoom = json_decode($get_opstoom, true);
$get_omtoscm = $createTest->pending_files_recevied_from_buyer();
$omtoscm = json_decode($get_omtoscm, true);
$get_scmtops = $createTest->pending_files_pennding_with_buyer();
$scmtops = json_decode($get_scmtops, true);
//    $get_vendraw = $createTest->Vend_Drawing_Submission($segment);
//    $vendraw = json_decode($get_vendraw, true);
//    $get_ops_call = $createTest->ops_calltovendor($segment);
//    $opscall = json_decode($get_ops_call, true);

if (sizeof($opstoom) > 0 || sizeof($omtoscm) > 0 || sizeof($scmtops) > 0) {

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

                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; Margin-bottom: 15px;">The Following files are pending with SCM department work flow.</p>
                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; ">Please use the below links to view </p>
                            <p  style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal;   Margin-bottom: 15px;"> <a href="https://swc.ltts.com/swift" target="blank">Link - SWIFT</a></p>';

    $message .= '<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px" class="handsontable">
                                <thead >
                                
                                    <tr>
                                       <th style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Project Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Package Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Received From</th>                  
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Pending with</th>                  
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;  ">Remarks</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Next Stage Name</th>
                                        <th style=" padding:5px; text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Stage Planned</th>
                                      </tr>
                                </thead>
                                <tbody>';
    if (sizeof($opstoom) > 0) {
        $message .= '<tr >
                                <td colspan="7" style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Files for SCM SPOC </td>
                                </tr>';

        foreach ($opstoom as $key => $optom) {


            $message .= '  <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optom['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optom['pm_packagename'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> ENG - ' . $optom['name'] . '<br>(' . date('d-M-Y', strtotime($optom['sc_sentdate'])) . ')' . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> ' . $optom['pen'] . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd; max-width:300px">' . $optom['sc_remarks'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">SCM SPOC to Buyer / OPS</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . date('d-M-Y', strtotime($optom['planned'])) . '</td>
                    </tr>';
        }
    }
    if (sizeof($omtoscm) > 0) {
        $message .= '<tr >
                                <td colspan="7" style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Files Sent Back by Buyers </td>
                                </tr>';

        foreach ($omtoscm as $key => $optoscm) {


            $message .= '  <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optoscm['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optoscm['pm_packagename'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> Buyer - ' . $optoscm['pen'] . '<br>(' . date('d-M-Y', strtotime($optoscm['bu_sentdate'])) . ')' . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> ' . $optoscm['name'] . 'SCM SPOC </td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd; max-width:300px">' . $optoscm['sb_remarks'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">SCM SPOC to Buyer / OPS</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . date('d-M-Y', strtotime($optoscm['planned'])) . '</td>
                    </tr>';
        }
    }
    if (sizeof($scmtops) > 0) {
        $message .= '<tr >
                                <td colspan="7" style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Files Pending with Buyers </td>
                                </tr>';

        foreach ($scmtops as $key => $optoscm1) {


            $message .= '  <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optoscm1['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optoscm1['pm_packagename'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> SCM SPOC - ' . $optoscm1['name'] . '<br>(' . date('d-M-Y', strtotime($optoscm1['bu_sentdate'])) . ')' . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> Buyer -' . $optoscm1['pen'] . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd; max-width:300px">-</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">Buyer Acceptance</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . date('d-M-Y', strtotime($optoscm1['planned'])) . '</td>
                    </tr>';
        }
    }




    $message .= '   </tbody>
                            </table><br>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Regards,</p>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><b>Swift</b></p>

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

    //echo $message;

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
//Server settingss
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
//Server settingss
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com;';                      // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
        $mail->Password = '!Lntswc123';                       // SMTP password
        //$mail->SMTPSecure = 'tls';                          // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 25;
        // TCP port to connect to
        //Recipients
          $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
// $mail->addAddress($emailk, $name); // Add a recipient
//            $mail->addAddress('uuk@lntecc.com', 'SWIFT'); // Add a recipient
        // $mail->ClearAddresses();
  
        // $mail->addAddress($name); // Name is optional
         $mail->addAddress('SYED-MOINUDDIN@lntecc.com'); // Name is optional
// $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('srini.rpsm@gmail.com');
        $mail->addCC('uuk@lntecc.com');
		    // $mail->addCC('info@bluekode.com');
//            $mail->addCC('uuk@lntecc.com');
//$mail->addBCC('bcc@example.com');
//Attachments
// $mail->addAttachment('C:/xampp/htdocs/QA/fpdf/status_pdf/'.$filename);                    // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');// Optional name
//Content
        $mail->isHTML(true);                                 // Set email format to HTML
// $mail->AddEmbeddedImage('logo.png', 'logoimg'); // attach file logo.jpg, and later link to it using identfier logoimg

        $mail->Subject = 'SWIFT';
        $mail->Body = $message;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $isql = mssql_query("select isnull (max(sms_id+1),1) as id from  sms_tracking");
        $row = mssql_fetch_array($isql);
        $sid = $row['id'];
        $sql = mssql_query("insert into sms_tracking (sms_id,sms_userid,sms_email,sent_date,_type)"
                . "values('" . $sid . "','" . $recvid . "','" . $name . "',GETDATE(),'1')");
        $mail->send();
        $Msg = "Mail Send";
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        $Msg = "Mail Not Send";
    }
}
?>


