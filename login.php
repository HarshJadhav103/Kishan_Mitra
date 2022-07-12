<?php
error_reporting(0);
include("connection.php");
include("encryptdecrypt.php");
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
	$username = $_POST['username'];
	$password = encrypt($_POST['password']);

	//Check for alreay existing data
	$query="select * from users where (number = '$username' AND password = '$password') OR (email = '$username' AND password = '$password')";		
	$result=mysqli_query($conn,$query);
	$data = mysqli_fetch_array($result);
	$check = mysqli_num_rows($result);
	if($check==1)
	{
		setcookie("user", $data['email'], time() + (86400 * 30 * 30), "/");		
		$_COOKIE["user"] = $data['email'];		
		session_id("session1");
		session_start();
		$_SESSION[$_COOKIE["user"]]=$_COOKIE["user"];
		session_write_close();
		header("location: index.php");
	}else
	{
		echo "<script>alert('Data entered is incorrect');</script>";
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
					<h2 class="product-title">Login</h2>
					<ol class="breadcrumb">
					<li><a href="index.html">Home /</a></li>
					<li class="current">Login</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>


<section class="login section-padding">
<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-5 col-md-12 col-xs-12">			
			<div class="login-form login-area">
			<h3>
				Login Now
			</h3>
			<div class="text-center" style="margin-top: 10px;" id="google_translate_element"></div>
			<form role="form" class="login-form" action="" method="POST">
				<div class="form-group">
					<div class="input-icon">
					<i class="lni-user"></i>
					<input type="text" id="sender-email" class="form-control" name="username" placeholder="Mobile Number or Email" required>
					</div>
				</div>
				<div class="form-group">
					<div class="input-icon">
					<i class="lni-lock"></i>
					<input type="password" class="form-control" name="password" placeholder="Password" required>
					</div>
				</div>
				<div class="form-group mb-3">
					<div class="text-center">
					<button class="btn btn-common log-btn" name="submit">Submit</button>
					</div>
				</div>
				<div class="form-group mt-4">
					<ul class="form-links">
					<li class="float-left"><a href="register.php">Don't have an account?</a></li>
					<li class="float-right"><a href="forgot_password.php">Forgot Password</a></li>
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
</body>

</html>