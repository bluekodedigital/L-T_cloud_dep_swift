<?php

include_once("config/db_con.php");
require 'PHPMailer/PHPMailerAutoload.php';

class createTest {

// Pendings files Received from CTO
    function pending_files_recevied_from_cto($segment) {
        $sql = "select  a.name,b.name as pen,ctops_packid,ctops_projid,ctops_recvuid,ctops_recv_stageid,proj_name,ctops_remarks,ctops_sentdate,
                pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,ps_expdate, pm_createdate as expected,GETDATE() as actual,shot_name 
                from usermst as a,usermst as b,  swift_CTOtoOPS,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=ctops_projid and
                ctops_packid=pm_packid and ctops_packid=ps_packid  and ps_stageid=ctops_recv_stageid  
                and stage_id=ctops_recv_stageid  and a.uid=ctops_senderuid and ctops_active=1 and ctops_status=0 
                and b.uid=ctops_recvuid and DATEDIFF(DAY,ctops_sentdate,GETDATE())>3  and cat_id='" . $segment . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

// Pendings files Received from OM
    function pending_files_recevied_from_om($segment) {
        $sql = "select  a.name,b.name as pen,omop_packid,omop_projid,omop_recvuid,omop_recv_stageid,proj_name,omop_remarks,ps_expdate,omop_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,shot_name 
                    from usermst as a,usermst as b,swift_OMtoOPs,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=omop_projid and
                    omop_packid=pm_packid and omop_packid=ps_packid  and ps_stageid=omop_recv_stageid  
                    and stage_id=omop_recv_stageid  and a.uid=omop_senderuid and omop_active=1 and omop_status=0 
                    and b.uid=omop_recvuid and    DATEDIFF(DAY,omop_sentdate,GETDATE())>3  and cat_id='" . $segment . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

// Pendings files Received from SCM Sent Back
    function pending_files_recevied_from_scm($segment) {
        $sql = " select  a.name,b.name as pen,scop_packid,scop_projid,scop_recvuid,scop_recv_stageid,proj_name,scop_remarks,ps_expdate,scop_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, pm_createdate as expected,GETDATE() as actual,shot_name 
                    from usermst as a, usermst as b,swift_SCMtoOPS,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=scop_projid and
                    scop_packid=pm_packid and scop_packid=ps_packid  and ps_stageid=scop_recv_stageid  
                    and stage_id=scop_recv_stageid  and a.uid=scop_senderuid and scop_active=1 and scop_status=0
                    and b.uid=scop_recvuid and  DATEDIFF(DAY,scop_sentdate,GETDATE())>2  and cat_id='" . $segment . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

// Pendings files for  Vend Drawing Submission 
    function Vend_Drawing_Submission($segment) {
        $sql = " select  distinct swift_techapproval.tech_status,a.name,b.name as pen,tech_packid,tech_projid,tech_recvuid,tech_recv_stageid,proj_name,tech_remarks,tech_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned, ps_expdate as expected,GETDATE() as actual,shot_name,stage_id 
                    from usermst as a , usermst as b ,swift_techapproval,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=tech_projid and
                    tech_packid=pm_packid and tech_packid=ps_packid  and ps_stageid=tech_recv_stageid  
                    and stage_id=tech_recv_stageid  and a.uid=tech_senderuid and tech_active=1 and swift_techapproval.tech_status in('0','1')
                    and b.uid=tech_recvuid  and cat_id='" . $segment . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

// Pendings files for  Vend Drawing Submission 
    function ops_calltovendor($segment) {
        $sql = "   select  distinct swift_techapproval.tech_status,a.name,b.name as pen,tech_packid,tech_projid,tech_recvuid,tech_recv_stageid,proj_name,tech_remarks,tech_sentdate,
                    pm_packagename,pm_material_req,pm_revised_material_req,revised_planned_date as planned,ps_expdate as expected,GETDATE() as actual,shot_name,stage_id 
                    from usermst as a, usermst as b ,swift_techapproval,swift_packagemaster,swift_packagestatus,Project,swift_stage_master where proj_id=tech_projid and
                    tech_packid=pm_packid and tech_packid=ps_packid  and ps_stageid=tech_recv_stageid  
                    and stage_id=tech_recv_stageid and a.uid=tech_senderuid and tech_active=1 and swift_techapproval.tech_status in('3') 
                    and b.uid=tech_recvuid  and cat_id='" . $segment . "'";
        $query = mssql_query($sql);
        $result = array();
        while ($row = mssql_fetch_array($query)) {
            $result[] = $row;
        }
        $res = json_encode($result);
        return $res;
    }

// Get segment
    function get_segment() {
        $sql = "select * from dbo.segment_master where seg_pid in(33,36,37)";
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

$get_segment = $createTest->get_segment();
$segment = json_decode($get_segment, true);
foreach ($segment as $key => $value) {

    $segment = $value['seg_pid'];

    $sql = mssql_query("select * from usermst where deptid='" . $segment . "'");
    $row = mssql_fetch_array($sql);
    $name = $row['uname'];
    $recvid= $row['uid'];
//    echo $name . '<br>';

    $get_opstoom = $createTest->pending_files_recevied_from_cto($segment);
    $opstoom = json_decode($get_opstoom, true);
    $get_omtoscm = $createTest->pending_files_recevied_from_om($segment);
    $omtoscm = json_decode($get_omtoscm, true);
    $get_scmtops = $createTest->pending_files_recevied_from_scm($segment);
    $scmtops = json_decode($get_scmtops, true);
    $get_vendraw = $createTest->Vend_Drawing_Submission($segment);
    $vendraw = json_decode($get_vendraw, true);
    $get_ops_call = $createTest->ops_calltovendor($segment);
    $opscall = json_decode($get_ops_call, true);

    if (sizeof($opstoom) > 0 || sizeof($omtoscm) > 0 || sizeof($scmtops) > 0 || sizeof($vendraw) > 0 || sizeof($opscall) > 0) {

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

                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; Margin-bottom: 15px;">The Following files are pending with Operation department work flow.</p>
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
                                <td colspan="7" style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Files from Technical</td>
                                </tr>';

            foreach ($opstoom as $key => $optom) {


                $message .= '  <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optom['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optom['pm_packagename'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> ENG - ' . $optom['name'] . '<br>(' . formatDate($optom['ctops_sentdate'], 'd-M-Y') . ')' . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> ' . $optom['pen'] . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd; max-width:300px">' . $optom['ctops_remarks'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optom['shot_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . formatDate($optom['planned'], 'd-M-Y') . '</td>
                    </tr>';
            }
        }
        if (sizeof($omtoscm) > 0) {


            $message .= '<tr >
                                <td colspan="7" style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Files from OM</td>
                                </tr>';
            foreach ($omtoscm as $key => $optoscm) {
                $message .= '  <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optoscm['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optoscm['pm_packagename'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> O&M - ' . $optoscm['name'] . '<br>(' . formatDate($optoscm['omop_sentdate'], 'd-M-Y') . ')' . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> ' . $optoscm['pen'] . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd; max-width:300px">' . $optoscm['omop_remarks'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $optoscm['shot_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . formatDate($optoscm['planned'], 'd-M-Y') . '</td>
                    </tr>';
            }
        }
        if (sizeof($scmtops) > 0) {

            $message .= '<tr >
                    <td colspan="7" style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">SCM - Sent Back Files</td>
                </tr>';
            foreach ($scmtops as $key => $scmtops) {
                $message .= '  <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $scmtops['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $scmtops['pm_packagename'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> SCM - ' . $scmtops['name'] . '<br>(' . formatDate($scmtops['scop_sentdate'], 'd-M-Y') . ')' . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> ' . $scmtops['pen'] . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd; max-width:300px">' . $scmtops['scop_remarks'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $scmtops['shot_name'] . '/ SCM / Technical' . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . formatDate($scmtops['planned'], 'd-M-Y') . '</td>
                    </tr>';
            }
        }
        if (sizeof($vendraw) > 0) {

            $message .= '<tr >
                    <td colspan="7" style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">Vendor Drawing Submission</td>
                </tr>';
            foreach ($vendraw as $key => $vendraw) {
                $message .= '  <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $vendraw['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $vendraw['pm_packagename'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> OPS - ' . $vendraw['name'] . '<br>(' . formatDate($vendraw['tech_sentdate'], 'd-M-Y') . ')' . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> ' . $vendraw['pen'] . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd; max-width:300px">' . $vendraw['tech_remarks'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $vendraw['shot_name'] . ' </td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . formatDate($vendraw['planned'], 'd-M-Y') . '</td>
                    </tr>';
            }
        }
        if (sizeof($opscall) > 0) {

            $message .= '<tr >
                    <td colspan="7" style=" padding:5px;  text-align: center; background-color:#F5BB05; color:#000;  border: 1px solid #ddd;">OPS Call to Vendor</td>
                </tr>';
            foreach ($opscall as $key => $opscall) {
                $message .= '  <tr>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $opscall['proj_name'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . $opscall['pm_packagename'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> OPS - ' . $opscall['name'] . '<br>(' . formatDate($opscall['tech_sentdate'], 'd-M-Y') . ')' . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> ' . $opscall['name'] . '</td>                               
                                        <td style=" text-align: center;  border: 1px solid #ddd; max-width:300px">' . $opscall['tech_remarks'] . '</td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;"> Ops to Vendor  </td>
                                        <td style=" text-align: center;  border: 1px solid #ddd;">' . formatDate($opscall['planned'], 'd-M-Y') . '</td>
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
            $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
            $mail->Password = '!Lntswc123';                      // SMTP password
//        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
            $mail->Port =25;
// TCP port to connect to
//Recipients
            $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
// $mail->addAddress($emailk, $name); // Add a recipient
//            $mail->addAddress('uuk@lntecc.com', 'SWIFT'); // Add a recipient
            $mail->ClearAddresses();
            $mail->addAddress($name); // Name is optional
//          $mail->addAddress('srini.ksss@gmail.com'); // Name is optional
// $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('srini.rpsm@gmail.com');
            $mail->addCC('uuk@lntecc.com');
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
}
?>


