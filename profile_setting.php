<?php
error_reporting(0);
include("connection.php");
include("encryptdecrypt.php");
//Check login status
session_id("session1");
session_start();
if(!isset($_SESSION[$_COOKIE["user"]]))
{
	session_write_close();
	header("location: login.php");
}

$query = "select * from users where email='".$_COOKIE['user']."'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_array($result);

if(isset($_POST['done']))
{	
	$tmpFilePath = $_FILES['image']['tmp_name'];

	//Make sure we have a file path
	if ($tmpFilePath != ""){
		//Setup our new file path
		$newFilePath = "profile_images/" . $_COOKIE["user"] . $_FILES['image']['name'];

		//Upload the file into the temp dir
		if(move_uploaded_file($tmpFilePath, $newFilePath))
		{			
			$query = "update users set profile_picture = '".$newFilePath."' where email = '".$_COOKIE['user']."'";
			$fire = mysqli_query($conn, $query);
			if($fire)
			{
				echo "<script>alert('Profile image updates successfully'); window.history.go(-2);</script>";
			}
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include("head.php"); ?>
   </head>
   <body>
      <?php include("navbar.php"); ?>
      </header>
      <div class="page-header" style="background: url(assets/img/banner1.jpg); padding: 90px 0 10px;">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="breadcrumb-wrapper">
                     <h2 class="product-title">Profile Settings</h2>
                     <ol class="breadcrumb">
                        <li><a href="index.php">Home /</a></li>
                        <li class="current">Profile Settings</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="content" class="section-padding">
         <div class="container">
            <div class="row">               
               <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="row page-content">                     
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="inner-box">
						<form enctype="multipart/form-data" method="POST" action="" id="form">
                           <div class="tg-contactdetail">
                              <div class="dashboard-box">
                                 <h2 class="dashbord-title">Contact Detail</h2>
                              </div>							  
                              <div class="dashboard-wrapper">                                 
                                 <div class="form-group mb-3">
                                    <label class="control-label">First Name*</label>
                                    <input class="form-control input-md" name="name" disabled type="text" value="<?php echo $user['firstname']; ?>">
                                 </div>
                                 <div class="form-group mb-3">
                                    <label class="control-label">Last Name*</label>
                                    <input class="form-control input-md" name="name" disabled type="text" value="<?php echo $user['lastname']; ?>">
                                 </div>
                                 <div class="form-group mb-3">
                                    <label class="control-label">Phone*</label>
                                    <input class="form-control input-md" name="phone" disabled type="text" value="<?php echo $user['number']; ?>">
                                 </div>
								 <div class="form-group mb-3">
                                    <label class="control-label">Email*</label>
                                    <input class="form-control input-md" name="email" disabled type="text" value="<?php echo $user['email']; ?>"> 
                                 </div>
								<label class="tg-fileuploadlabel" for="tg-photogallery">                              
									<span class="btn btn-common">Select Files *</span> 
										<input id="tg-photogallery" class="tg-fileinput" onchange="showimage()" type="file" name="image" accept="image/*" required>                              
											<div class="row text-center">
												<div class="col-sm-6 col-lg-8">
												<img id="one" width="100%" height="250px" style="display: block; padding: 10px;" src="<?php echo $user['profile_picture']; ?>" alt="your image" />
											</div>
										</div>
									</div>									  							  							  						
								</label>
								 <div class="text-center">
                                 <button class="btn btn-common" value="done" name="done" onclick="submit()" style="margin-bottom: 10px;">UPDATE</button>
								 </div>
                              </div>
						  </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
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
        function showimage()
		{
			files = document.getElementById("tg-photogallery");
			var file = files.files;
			document.getElementById("one").src = URL.createObjectURL(file[0]);			
			document.getElementById("one").style.display = "block";	
		}			
		
		function submit()
		{
			document.getElementById("form").submit();
		}
	  </script>	  
   </body>
</html>