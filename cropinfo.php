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

$query = "select * from crop_info";
$fire = mysqli_query($conn, $query);

if(isset($_GET['submit']))
{
	$mydir = "Crop Information/".$_GET['crop']."/";	
	$myfiles = scandir($mydir);		
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include("head.php");?>	  
   </head>
   <body>
      <?php include("navbar.php"); ?>
      <div id="hero-area">
         <div class="overlay"></div>
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-12 col-lg-6 col-xs-12 text-center">
                  <div class="contents-ctg">
                     <div class="search-bar col-12">
                        <div class="search-inner">
                           <form class="search-form" method="GET" action="" style="margin-bottom: 0px;">                                                           
                              <div class="row">
								<div class="col-lg-8 col-md-12 col-sm-12">
									  <div class="form-group inputwithicon" style="width: 100%;">
										 <i class="lni-menu" style="background-color: white;"></i>
										 <div class="select">
											<select id="crop" name="crop" required>
											<option value="" selected="selected" disabled>Select Crop</option>
											<?php
												while($data = mysqli_fetch_array($fire)){												
													echo "<option value='".$data['crop_name']."'>".$data['crop_name']."</option>";													
												}
											?>											
											</select>
										 </div>
									  </div>
								  </div>								  
								</div>								
								<button class="btn btn-common col-lg-4 col-sm-12" type="submit" style="width: 100%;" value="submit" name="submit"><i class="lni-search"></i> Search Now</button>							  																							
						   </form>						   																																																																	
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </header>	  
	  <?php if(isset($_GET['submit']) and $myfiles[2] != null){ ?>
		  <section class="login section-padding">
			   <div class="container">
				  <div class="row justify-content-center">
					 <div class="col-lg-4 col-md-12 col-xs-12">
						<div class="login-form login-area">
						   <h3>
							  <?php echo $_GET['crop']." "; ?>Information	
						   </h3>
						   <form role="form" class="login-form">							  
							  <?php for ($i = 2; $i < count($myfiles); $i++) { ?>
							  <div class="form-group">
								 <div class="input-icon">									
									<a href="pdf.php?file=<?php echo $mydir.$myfiles[$i]; ?>"><input class="form-control" style="padding-left:0px; text-align: center;" value="<?php echo $myfiles[$i]; ?>" readonly></a>
								 </div>
							  </div>							  		
							  <?php } ?> 							  
						   </form>
						</div>
					 </div>					 
				  </div>
			   </div>
			</section>
			
	  <?php } else {?>
			<div class="main-container section-padding">
			<div class="container">
			<div class="row">  
			<?php if(isset($_GET['submit']) and $myfiles[2]==null){ echo "No records found"; } else { echo "Search above to see results"; }?>
			</div>
			</div>
			</div>
	  <?php }?>

	  
      <?php include("footer.php"); ?>
      <a href="#" class="back-to-top"> <i class="lni-chevron-up"></i> </a>
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