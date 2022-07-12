<?php
include('smtp/PHPMailerAutoload.php');
$otp = rand(100000, 999999);
$from = "mobizone.web.mob@gmail.com";
$to = "lkh2lozhe6@thejoker5.com";		
$subject = "hello"; 
$message = "Dear User,\n\n OTP to create an account is $otp.\n\n with regards,\n Kisan Mitra Team";		

$status = smtp_mailer($to,$subject,$message);
echo $status;

if (strpos($status, 'Sent') !== false) {
    echo "<script>alert('OTP sent to your email address');</script>";
}else
{
	echo "<script>alert('OTP not sent'); window.location = 'login.php;</script>";
}
function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->SMTPDebug  = 3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "mobizone.web.mob@gmail.com";
	$mail->Password = "intercityssipproject";
	$mail->SetFrom("mobizone.web.mob@gmail.com", "Kisan Mitra");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		return 'Sent';
	}
}
?>