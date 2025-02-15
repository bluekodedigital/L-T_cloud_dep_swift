<html>
<head>
  <meta http-equiv="refresh" content="30">
</head>
<body>
<?php
include_once('../dbcon.php');

require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.bluekode.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'info@bluekode.com';                 // SMTP username
$mail->Password = 'bks@1234';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to

$mail->setFrom('info@bluekode.com', 'Bluekode');
//$mail->addAddress('info@bluekode.com');     // Add a recipient
$mail->addAddress('srininov8@gmail.com');               // Name is optional
$mail->addReplyTo('info@bluekode.com', 'Bluekode');
//$mail->addBCC('srniwemade@gmail.com');

 $mail->addAttachment('../attachment/today/report.xls');         // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
 $mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Warrenty Report';
$mail->Body    = 'Please find the <b>attachment!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) 
{
    echo 'Message could not be sent.';
    echo 'Mailer Error:'.$mail->ErrorInfo;
}
else
{
    echo 'Message has been sent Successfully !!';
}
?>
</body>
</html>