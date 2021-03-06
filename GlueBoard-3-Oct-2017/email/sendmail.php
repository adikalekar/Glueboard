<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Modify the path in the require statement below to refer to the 
// location of your Composer autoload.php file.
require 'vendor/autoload.php';
function sendmail($To,$Message,$Subject) {
// Instantiate a new PHPMailer 
$mail = new PHPMailer(True);

// Tell PHPMailer to use SMTP
$mail->isSMTP();

// Replace sender@example.com with your "From" address. 
// This address must be verified with Amazon SES.
$mail->setFrom('alerts@digitalfly.net');

// Replace recipient@example.com with a "To" address. If your account 
// is still in the sandbox, this address must be verified.
// Also note that you can include several addAddress() lines to send
// email to multiple recipients.
//$mail->addAddress($To);
    
$to_array = explode(',', $To);
foreach($to_array as $address)
{
    $mail->addAddress($address);
}

// Replace smtp_username with your Amazon SES SMTP user name.
$mail->Username = 'AKIAJIEAUSIFA2O3DCLQ';

// Replace smtp_password with your Amazon SES SMTP password.
$mail->Password = 'AtgyZR66XBPtEPqXiKD0pSvTIUtr6DPe1FLDjWrwCexN';
    
// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
//$mail->addCustomHeader('X-SES-CONFIGURATION-SET', 'ConfigSet');
 
// If you're using Amazon SES in a region other than US West (Oregon), 
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP  
// endpoint in the appropriate region.
$mail->Host = 'email-smtp.us-east-1.amazonaws.com';

// The port you will connect to on the Amazon SES SMTP endpoint.
$mail->Port = 465;

// The subject line of the email
$mail->Subject = $Subject;

// The HTML-formatted body of the email
$mail->Body = $Message;

// Tells PHPMailer to use SMTP authentication
$mail->SMTPAuth = true;

// Enable SSL encryption
$mail->SMTPSecure = 'ssl';

// Tells PHPMailer to send HTML-formatted email
$mail->isHTML(true);
//$mail->SMTPDebug = true;
// The alternative email body; this is only displayed when a recipient
// opens the email in a non-HTML email client. The \r\n represents a 
// line break.
$mail->AltBody = "Email Test\r\nThis email was sent through the 
    Amazon SES SMTP interface using the PHPMailer class.";

if(!$mail->send()) {
    return "Email not sent. " . $mail->ErrorInfo . PHP_EOL;
} else {
    return "Email sent successfully!" . PHP_EOL;
}
}
?>