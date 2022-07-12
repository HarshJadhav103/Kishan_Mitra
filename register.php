<?php
error_reporting(0);
include("connection.php");
include("encryptdecrypt.php");
require 'smtp/PHPMailerAutoload.php';
$status = "getnumber";
//Check login status
session_id("session1");
session_start();
if(isset($_SESSION[$_COOKIE["user"]]))
{
	session_write_close();
	header("location: index.php");
}

if(isset($_POST['submit']))
{
	$status="checkotp";
	$email = $_POST['email'];
	$mobile = $_POST['number'];
	$password = $_POST['password'];
	
	//Check for alreay existing data	
	$query="select * from users where number = '$mobile' OR email = '$email'";		
	$result=mysqli_query($conn,$query);
	$check = mysqli_num_rows($result);
	if($check>0)
	{
		echo "<script>alert('Mobile or Email already exists.'); window.location = 'login.php';</script>";
	}else
	{	
		$otp = rand(100000, 999999);
		$from = "mobizone.web.mob@gmail.com";
		$to = $email;		
		$subject = "OTP for email Verification"; 
		$message = "Dear User, <br><br> OTP to create an account is $otp.<br><br> with regards,<br> Kisan Mitra Team";
		
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
	}
}
if(isset($_POST['submit_OTP']))
{	
	$status = "details";
	$original_otp = $_POST['orgotp'];
	$user_opt = $_POST['userotp'];
	$email = $_POST['email'];
	$mobile = $_POST['number'];
	$password = $_POST['pass'];
	
	if($original_otp != $user_opt)
	{
		echo "<script>alert('Wrong OTP'); window.location = 'login.php';</script>";
	}	
}

if(isset($_POST['create_account']))
{
	//Insert New User Data					
	$mobile = $_POST['number'];
	$email = $_POST['email'];
	$password = encrypt($_POST['pass']);
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$gender = $_POST['gender'];
	$profile_picture = "assets/img/avtar.png";
	$query="Insert into users (number,email,password,firstname,lastname,gender,profile_picture) values('".$mobile."','".$email."','".$password."','".$firstname."','".$lastname."','".$gender."','".$profile_picture."')";							
	$insert=mysqli_query($conn,$query);
	if($insert)
	{	
		setcookie("user", $email, time() + (86400 * 30 * 30), "/");		
		$_COOKIE["user"]=$email;
		session_id("session1");
		session_start();
		$_SESSION[$_COOKIE["user"]]=$_COOKIE["user"];
		session_write_close();
		echo "<script>alert('Account Created Successfully'); window.location = 'index.php';</script>";
	}else
	{
		echo "<script>alert('Error occured. Try again')</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include("head.php"); ?>
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
</head>
<body>
<div class="page-header" style="background: url(assets/img/banner1.jpg);">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="breadcrumb-wrapper">
					<h2 class="product-title">Join Us</h2>
					<ol class="breadcrumb">
					<li><a href="#">Home /</a></li>
					<li class="current">Register</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>


<section class="register section-padding">
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-5 col-md-12 col-xs-12">
			<div class="register-form login-area">
				<h3>
					Register
				</h3>
			<form class="login-form" action="" id="otp_form" method="POST" style="display: <?php if($status == "getnumber"){ echo "block"; }else{ echo "none"; } ?>;">
				<div class="form-group">
					<div class="input-icon">
					<i class="lni-mobile"></i>
					<input type="text" pattern="^\d{10}$" maxlength="10" class="form-control" id="mobile" name="number" placeholder="Mobile Number" required>
					</div>
				</div>
				<div class="form-group">
					<div class="input-icon">
					<i class="lni-envelope"></i>
					<input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
					</div>
				</div>
				<div class="form-group">
					<div class="input-icon">
					<i class="lni-lock"></i>
					<input type="password" class="form-control" name="password" id="password" placeholder="Set Password" onkeyup='check(this.value)' required>
					</div>
				</div>
				<div class="form-group">
					<div class="input-icon">
					<i class="lni-lock"></i>
					<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Retype Password" onkeyup='check(this.value)' required>
					</div>
					<span id='message'></span>
				</div>				
				<div class="form-group mb-3">
					<div class="text-center">
					<button class="btn btn-common log-btn" id="submit_button" name="submit" disabled="disabled" onclick="done(this.value)">GET OTP</button>
					</div>
				</div>
				<div class="form-group mt-4">
					<ul class="form-links">
					<li class="float-left"><a href="login.php">Already have an account?</a></li>					
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
				<input type="hidden" name="number" value="<?php echo $mobile; ?>">
				<input type="hidden" name="pass" value="<?php echo $password; ?>">
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
			<form role="form" class="login-form" method="POST" action="" style="display: <?php if($status == "details"){ echo "block"; }else{ echo "none"; } ?>;">
				<div class="form-group">
					<div class="input-icon">
					<i class="icon lni-user"></i>
					<input type="text" id="firstname" class="form-control" name="firstname" placeholder="Firstname" required>
					</div>
				</div>
				<div class="form-group" style="margin-bottom: 20px;">
					<div class="input-icon">
					<i class="icon lni-user"></i>
					<input type="text" id="lastname" class="form-control" name="lastname" placeholder="Lastname" required>
					</div>
				</div>			
				<div class="form-group mb-3">
					<strong>Gender</strong>
					<div class="tg-selectgroup">
						<span class="tg-radio">
							<input id="tg-sameuser" type="radio" name="gender" value="Male" required>
							<label for="tg-sameuser">Male</label>
						</span>
						<span class="tg-radio" style="margin-left: 20px;">
							<input id="tg-someoneelse" type="radio" name="gender" value="Female">
							<label for="tg-someoneelse">Female</label>
						</span>
					</div>
				</div>
				<input type="hidden" name="email" value="<?php echo $email; ?>">				
				<input type="hidden" name="number" value="<?php echo $mobile; ?>">
				<input type="hidden" name="pass" value="<?php echo $password; ?>">
				<div class="text-center">
					<button class="btn btn-common log-btn" id="create_account" name="create_account">CREATE ACCOUNT</button>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
var check = (function($) {
  if (document.getElementById('password').value ==
    document.getElementById('confirm_password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Matching';
	document.getElementById('submit_button').removeAttribute('disabled');
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Not matching';
	document.getElementById('submit_button').setAttribute('disabled', 'disabled');
  }
});
</script>
<script>
var done = (function($) {
	let mobileNumber = document.getElementById("mobile").value;
	mobilestatus = validateMobile(mobileNumber);	
	if(mobilestatus == true)
	{
		let emailAdress = document.getElementById("email").value;
		emailstatus = validateEmail(emailAdress);
		if(emailstatus == true)
		{
			document.getElementById("preloader").style.display = "block";
			document.getElementById("otp_form").submit();	
		}else{
			alert('Please enter a valid email address');
		}
	}else{
		alert('Please enter a valid moile number');
	}		
});
</script>
<script>
function validateEmail (emailAdress)
{
  let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (emailAdress.match(regexEmail)) {
    return true; 
  } else {
    return false; 
  }
}

function validateMobile (mobileNumber)
{
  let regexMobile = /^\d{10}$/;
  if (mobileNumber.match(regexMobile)) {
    return true; 
  } else {
    return false; 
  }
}
</script>
</body>
</html>