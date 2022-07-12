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
if(isset($_GET['id']))
{
	$query = "select * from ads where id = '".$_GET['id']."'";
	$result = mysqli_query($conn, $query);
	$data = mysqli_fetch_array($result);	
}

if($data['user_id']==$_COOKIE['user'])
{
	echo "<script>alert('It is your own ad. Visit your ad section.'); window.history.go(-1);</script>";
}

//find current user id
$query = "select * from users where email = '".$_COOKIE['user']."'";
$fire = mysqli_query($conn, $query);
$thisuser = mysqli_fetch_array($fire);
$buyer = $thisuser['id'];

$query = "select * from users where email = '".$data['user_id']."'";
$fire = mysqli_query($conn, $query);
$otheruser = mysqli_fetch_array($fire);
$seller = $otheruser['id'];
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
                     <h2 class="product-title">Details</h2>
                     <ol class="breadcrumb">
                        <li><a href="index.php">Home /</a></li>
                        <li class="current">Details</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="section-padding">
         <div class="container">
            <div class="product-info row">
               <div class="col-lg-8 col-md-12 col-xs-12">
                  <div class="ads-details-wrapper">
                     <div id="owl-demo" class="owl-carousel owl-theme">
                        <?php $string = $data['images']; $str_arr = explode (",", $string); for($i = 0; $i < count($str_arr); $i++) {?>
						<div class="item">
                           <div class="product-img" style="height: 450px;"> <img class="img-fluid" style="height: 100%; width:100%" src="<?php echo $str_arr[$i]; ?>" alt=""> </div>
                           <span class="price"><?php echo "₹ " .$data['price']; ?></span> 
                        </div>                        
						<?php } ?>
                     </div>
                  </div>
                  <div class="details-box">
                     <div class="ads-details-info">
                        <h2><?php echo $data['title']; ?></h2>
                        <div class="details-meta"> <span><a href="#"><i class="lni-alarm-clock"></i> <?php $string = $data['date']; $date = explode (",", $string); echo $date[0]; ?> </a></span> <span><a href="#"><i class="lni-map-marker"></i> <?php echo $data["state"]; ?></a></span></div>
                        <p class="mb-4"><?php echo $data['description']; ?></p>                        
                     </div>
                     <div class="tag-bottom">
                        <div class="float-left">
                           <ul class="advertisement">
                              <li>
                                 <p><strong><i class="lni-folder"></i> Commodity: </strong><?php echo $data['commodity']; ?></p>
                              </li>                              
                           </ul>
                        </div>                        
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-md-6 col-xs-12">
                  <aside class="details-sidebar">
                     <div class="widget">
                        <h4 class="widget-title">Ad Posted By</h4>
                        <div class="agent-inner">
                           <div class="mb-4">
                              <object style="border:0; height: 230px; width: 100%;" data="https://maps.google.com/maps?q=<?php echo $data["latitude"].",".$data["longitude"]; ?>&t=&z=13&ie=UTF8&iwloc=&output=embed"></object>
                           </div>
                           <div class="agent-title">
						   <?php 
								$query = "select * from users where email = '".$data['user_id']."'";
								$userdata = mysqli_query($conn, $query);
								$user = mysqli_fetch_array($userdata);								
							  ?>
                              <div class="agent-photo">
                                 <img src="<?php echo $user['profile_picture']; ?>" alt="">
                              </div>
                              <div class="agent-details">							  
                                 <h3><?php echo $user['firstname']." ".$user['lastname']; ?></h3>
                                 <span><i class="lni-phone-handset"></i><a href="tel:+91<?php echo $user["number"]; ?>"><?php echo $user["number"]; ?></a></span> 
                              </div>
                           </div>                           
                           <p>If you are intrested in the product then you may start a chat with the seller.</p>
                           <div class="text-center">
						   <a href="chat.php?chat=<?php echo $_GET['id']; ?>&seller=<?php echo $seller; ?>&buyer=<?php echo $buyer; ?>" class="btn btn-common fullwidth mt-4">Chat</a>
						   </div>
                        </div>
                     </div>                     
                  </aside>
               </div>
            </div>
         </div>
      </div>      
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