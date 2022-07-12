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

$query = "select * from ads";
$fire = mysqli_query($conn, $query);
$ads = mysqli_num_rows($fire);

$query = "select * from users";
$fire = mysqli_query($conn, $query);
$members = mysqli_num_rows($fire);
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
                     <h2 class="product-title">About Us</h2>
                     <ol class="breadcrumb">
                        <li><a href="index.php">Home /</a></li>
                        <li class="current">About Us</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <section id="about" class="section-padding">
         <div class="container">
            <div class="row">
               <div class="col-md-6 col-lg-6 col-xs-12">
                  <div class="about-wrapper">
                     <h2 class="intro-title">Why We Are Unique</h2>
                     <p class="intro-desc">We provide cutting edge technology platform to meet farmer's need of business. This leads us to a simple solution of common stage for farmers and merchants.</p>
                     <a href="post_ads.php" class="btn btn-common btn-lg">Add Listing</a>
                  </div>
               </div>
               <div class="col-md-6 col-lg-6 col-xs-12">
                  <img class="img-fluid" src="assets/img/about/about.png" alt="">
               </div>
            </div>
         </div>
      </section>
      <section class="counter-section section-padding">
         <div class="container">
            <div class="row">
               <div class="col-md-4 col-sm-6 work-counter-widget">
                  <div class="counter">
                     <div class="icon"><i class="lni-layers"></i></div>
                     <h2 class="counterUp"><?php echo $ads; ?></h2>
                     <p>Ad Posted</p>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6 work-counter-widget">
                  <div class="counter">
                     <div class="icon"><i class="lni-users"></i></div>
                     <h2 class="counterUp"><?php echo $members; ?></h2>
                     <p>Members</p>
                  </div>
               </div>
               <div class="col-md-4 col-sm-6 work-counter-widget">
                  <div class="counter">
                     <div class="icon"><i class="lni-leaf"></i></div>
                     <h2 class="counterUp">300</h2>
                     <p>Commodities Listed</p>
                  </div>
               </div>               
            </div>
         </div>
      </section>
      <section class="services section-padding">
         <div class="container">
            <div class="row">
               <div class="col-md-6 col-lg-4 col-xs-12">
                  <div class="services-item wow fadeInRight" data-wow-delay="0.2s">
                     <div class="icon">
                        <i class="lni-book"></i>
                     </div>
                     <div class="services-content">
                        <h3><a href="#">Post Ads</a></h3>
                        <p>Get worldwide exposure in just few clicks</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-lg-4 col-xs-12">
                  <div class="services-item wow fadeInRight" data-wow-delay="0.4s">
                     <div class="icon">
                        <i class="lni-leaf"></i>
                     </div>
                     <div class="services-content">
                        <h3><a href="#">Crop Information</a></h3>
                        <p>Get in-depth information about crops</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-lg-4 col-xs-12">
                  <div class="services-item wow fadeInRight" data-wow-delay="0.6s">
                     <div class="icon">
                        <i class="lni lni-stats-up"></i>
                     </div>
                     <div class="services-content">
                        <h3><a href="#">Commodity Index</a></h3>
                        <p>Instantly access live price of commodity</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-lg-4 col-xs-12">
                  <div class="services-item wow fadeInRight" data-wow-delay="0.8s">
                     <div class="icon">
                        <i class="lni-world"></i>
                     </div>
                     <div class="services-content">
                        <h3><a href="#">News Update</a></h3>
                        <p>New update related to Indian agriculture</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-lg-4 col-xs-12">
                  <div class="services-item wow fadeInRight" data-wow-delay="1s">
                     <div class="icon">
                        <i class="lni-bubble"></i>
                     </div>
                     <div class="services-content">
                        <h3><a href="#">Messages</a></h3>
                        <p>Chat feature to get intrested traders connect faster</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-lg-4 col-xs-12">
                  <div class="services-item wow fadeInRight" data-wow-delay="1.2s">
                     <div class="icon">
                        <i class="lni-check-box"></i>
                     </div>
                     <div class="services-content">
                        <h3><a href="#">Insurance</a></h3>
                        <p>Purchase crop insurance with our business partners</p>
                     </div>
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
   </body>
</html>