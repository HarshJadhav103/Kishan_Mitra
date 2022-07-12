<?php
error_reporting(0);
include("connection.php");
include("encryptdecrypt.php");
require 'smtp/PHPMailerAutoload.php';
$status = "getotp";
if(isset($_POST['getotp']))
{
	$status = "checkotp";
	//insert datat	
	$email = $_POST['email'];
	
	//Check for alreay existing data
	$query="select * from users where email = '$email'";		
	$result=mysqli_query($conn,$query);
	$data = mysqli_fetch_array($result);
	$check = mysqli_num_rows($result);
	if($check == 1)
	{		
		$otp = rand(100000, 999999);
		$from = "mobizone.web.mob@gmail.com";
		$to = $email;
		
		$subject = "OTP for email Verification"; 
		$message = "Dear ".$data['firstname'].",<br><br> OTP to change password is $otp.<br><br> with regards,<br> Kisan Mitra Team";
		
		$mail = new PHPMailer(); 
		//$mail->SMTPDebug  = 3;
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
		$mail->Body =$message;
		$mail->AddAddress($to);
		$mail->SMTPOptions=array('ssl'=>array(
			'verify_peer'=>false,
			'verify_peer_name'=>false,
			'allow_self_signed'=>false
		));
		if(!$mail->Send()){
			echo "<script>alert('OTP not sent'); window.location = 'login.php';</script>";
		}else{
			echo "<script>alert('OTP sent to your email address');</script>";
		}
	}else
	{
		echo "<script>alert('No such user available');</script>";
	}
}
if(isset($_POST['submit_OTP']))
{
	$status = "newpass";
	$original_otp = $_POST['orgotp'];
	$user_opt = $_POST['userotp'];
	$email = $_POST['email'];
	
	if($original_otp != $user_opt)
	{
		echo "<script>alert('Wrong OTP'); window.location = 'login.php';</script>";
	}
}
if(isset($_POST['change_password']))
{
	//change password	
	$email = $_POST['email'];
	$newpass = encrypt($_POST['password']);
	$query="update users set password = '$newpass' where email='$email'";
	$result=mysqli_query($conn,$query);
	if($result)
	{
		echo "<script>alert('Password changed sucessfully'); window.location = 'login.php';</script>";
	}else
	{
		echo "<script>alert('Error occured'); window.location = 'login.php';</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include("head.php"); ?>
</head>
<body>

<div class="page-header" style="background: url(assets/img/banner1.jpg);">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="breadcrumb-wrapper">
					<h2 class="product-title">Forgot Password</h2>
					<ol class="breadcrumb">
					<li><a href="#">Home /</a></li>
					<li class="current">Forgot Password</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>


<section class="section-padding">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-5 col-md-12 col-xs-12">
				<div class="forgot login-area">
					<h3>
					Forgot Password
					</h3>
					<form role="form" class="login-form" id="otp_form" method="POST" action=""  style="display: <?php if($status == "getotp"){ echo "block"; }else{ echo "none"; } ?>;">
						<div class="form-group">
							<div class="input-icon">
							<i class="icon lni-user"></i>
							<input type="text" id="email" class="form-control" name="email" placeholder="Email" required>
							</div>
						</div>
						<div class="text-center">
							<button class="btn btn-common log-btn" name="getotp" onclick="done()">GET OTP</button>
						</div>
						<div class="form-group mt-4">
							<ul class="form-links">							
							<li class="float-right"><a href="login.php">Back to Login</a></li>
							</ul>
						</div>
					</form>
					<form role="form" class="login-form" method="POST" action="" style="display: <?php if($status == "checkotp"){ echo "block"; }else{ echo "none"; } ?>;">
						<div class="form-group">
							<div class="input-icon">
							<i class="icon lni-lock"></i>
							<input type="text" id="otp" class="form-control" name="userotp" placeholder="Enter OTP" required>
							</div>
						</div>
						<input type="hidden" name="email" value="<?php echo $email; ?>">
						<input type="hidden" name="orgotp" value="<?php echo $otp; ?>">
						<div class="text-center">
							<button class="btn btn-common log-btn" id="submit_OTP" name="submit_OTP">SUBMIT OTP</button>
						</div>
						<div class="form-group mt-4">
							<ul class="form-links">							
							<li class="float-right"><a href="login.php">Back to Login</a></li>
							</ul>
						</div>
					</form>
					<form role="form" class="login-form" method="POST" action="" style="display: <?php if($status == "newpass"){ echo "block"; }else{ echo "none"; } ?>;">
						<div class="form-group">
							<div class="input-icon">
							<i class="icon lni-lock"></i>
							<input type="password" id="password" class="form-control" name="password" placeholder="New Password" onkeyup='check();' required>
							</div>
						</div>
						<div class="form-group">
							<div class="input-icon">
							<i class="icon lni-lock"></i>
							<input type="password" id="confirm_password" class="form-control" name="repassword" placeholder="Retype Password" onkeyup='check();' required>
							</div>
							<span id='message'></span>
						</div>
						<input type="hidden" name="email" value="<?php echo $email; ?>">					
						<div class="text-center">
							<button class="btn btn-common log-btn" id="change_password" name="change_password" disabled="disabled">Change Password</button>
						</div>
						<div class="form-group mt-4">
							<ul class="form-links">							
							<li class="float-right"><a href="login.php">Back to Login</a></li>
							</ul>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>


<?php include("footer.php"); ?>


<a href="#" class="back-to-top">
<i class="lni-chevron-up"></i>
</a>

<div id="preloader">
<div class="loader" id="loader-1"></div>
</div>


<script src="assets/js/jquery-min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.counterup.min.js"></script>
<script src="assets/js/waypoints.min.js"></script>
<script src="assets/js/wow.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/jquery.slicknav.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/form-validator.min.js"></script>
<script src="assets/js/contact-form-script.min.js"></script>
<script src="assets/js/summernote.js"></script>
<script>
var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('confirm_password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Matching';
	document.getElementById('change_password').removeAttribute('disabled');
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Not matching';
	document.getElementById('change_password').setAttribute('disabled', 'disabled');
  }
}

function done() {
	document.getElementById("preloader").style.display = "block";
	document.getElementById("otp_form").submit();
}
</script>
</body>
</html>