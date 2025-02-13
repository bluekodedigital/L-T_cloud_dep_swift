<?php
// Check if IN_APPLICATION constant is defined
// if (!defined('IN_APPLICATION')) {
//     // Redirect the user or terminate the script
//     header('HTTP/1.1 403 Forbidden');
//     exit('Direct access not allowed.');
// }
include_once ("../config/inc_function.php");
require '../PHPMailer/PHPMailerAutoload.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$email = trim(mssql_escape($_POST['key']));
$string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$string_shuffled = str_shuffle($string);
$password = substr($string_shuffled, 1, 6);

$sql = "select * from usermst where uname = '" . $email . "'";
$query = mssql_query($sql);
//echo $sql;
$num_rows = mssql_num_rows($query);
if ($num_rows > 0) {
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
        </table>
        <div style=" background: #fff;  font-family: calibri; font-size: 16px; font-weight: normal; font-size: 16px;">
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td><b>Dear Sir/Madam,</b>

                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; Margin-bottom: 15px;">Your OTP for Reset Your Password is</p>
                            <p style=" margin-left: 5%; font-family: calibri; font-size: 16px; font-weight: normal; ">OTP : ' . $password . ' </p>
                            
                            <br>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Regards,</p>
                            <p style="font-family: calibri; font-size: 16px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><b>Swift</b></p>

                            <p style="font-family:calibri;color:lightgray;font-size:14px">This is Auto generated mail hence Please do not reply</p>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
            <p> Powered by Bluekode
                <br>
        </div>
    </div>
</div>';

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settingss
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        //Server settingss
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com;';                      // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
//        $mail->Username = 'srini.rpsm@gmail.com';             // SMTP username
//        $mail->Password = '!Mekala@123';                      // SMTP password
        $mail->Username = 'weblntswcdigital@gmail.com';             // SMTP username
        // $mail->Password = '!Lntswc123'; 
        $mail->Password = 'qzthucjhsdezbdlu';                       // SMTP password
//        $mail->SMTPSecure = 'ssl';                          // Enable TLS encryption, `ssl` also accepted
//        $mail->Port = 587;
        $mail->Port = 25;
        // TCP port to connect to
        //Recipients
        $mail->setFrom('weblntswcdigital@gmail.com', 'SWIFT');
        $mail->addAddress($email); // Add a recipient
        //$mail->addAddress('uuk@lntecc.com', 'SWIFT'); // Add a recipient
//        $mail->addAddress('srini.rpsm@gmail.com'); // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
//        $mail->addCC($cc);
        //$mail->addBCC('bcc@example.com');
        //Attachments
        // $mail->addAttachment('C:/xampp/htdocs/QA/fpdf/status_pdf/'.$filename);                    // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');// Optional name
        //Content
        $mail->isHTML(true);                                 // Set email format to HTML
        // $mail->AddEmbeddedImage('logo.png', 'logoimg'); // attach file logo.jpg, and later link to it using identfier logoimg

        $mail->Subject = 'SWIFT | RESET PASSWORD';
        $mail->Body = $message;

        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

        $_SESSION['otp'] = $password;
        $_SESSION['otp_email'] = $email;
        $Msg = "Mail Send";
        echo $Msg;
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        $Msg = "Mail Not Send";
        echo $Msg;
    }
} else {
    echo 0;
}
?>