<?php echo "Email Sent";
?>
<?php

require_once 'PHPMailer/PHPMailerAutoload.php';

define('GUSER', 'bisma@laraveldevelopers.co'); // GMail username
define('GPWD', 'Bisma2015'); // GMail password
DEFINE('WEBSITE_URL', 'http://localhost');

function smtpmailer($to, $from, $from_name, $subject, $body) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'a2plcpnl0869.prod.iad2.secureserver.net'; //smtp.gmail.com';
	$mail->Port = 465; //465; 
	$mail->Username = GUSER;  
	$mail->Password = GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	$mail->AddAttachment('HackFest-1.0-BA-Details.pdf', $name = 'HackFest-1.0-BA-Details.pdf',  $encoding = 'base64', $type = 'application/pdf');

	if(!$mail->Send())
	{
		$error = 'Mail error: '.$mail->ErrorInfo; 
		echo $error;
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}

?>
<?php 
$email="bisma.ayaz@yahoo.com";
 echo "Sending Email to ".$email."<br>";
 $message = "Dear Participant,
 
Thank you once again for being a part of HackFest 1.0. It is a pleasure to have you on board.

To confirm your registration, please follow any one of the following steps:
1) Send the amount via easypaisa directly to our Treasurer Mr. Mohsin Khan. His details are as follows:

Contact No.: 0333 3707820

CNIC: 4210190067577
2) In case of any difficulty in sending the amount, you can contact our Brand Ambassadors and give them the money in cash, they're details can be found in the attachment. They'll forward it to us on your behalf. You are requested to ask them for a written receipt confirming the payment and send us a picture of that receipt.
A confirmation receipt will be sent to you once we've received your payment. You are kindly requested to bring the receipt with you on the day of the event.
We sincerely thank you for your time and interest. May the cloud be ever in your favour!

Regards,

Seemal Saeed
Head of Registration
IEEE WIE NEDUET AG";

   if (smtpmailer($email, 'ieeewie.neduet@gmail.com', 'IEEE WIE NEDUET AG', 'HackFest 1.0 | Registeration Procedure', $message)) {
echo "Mail Sent Successfully"."<br>";}
else { echo "Problem in Sending Email"."<br>"; }

?>
