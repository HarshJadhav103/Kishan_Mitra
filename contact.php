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
                     <h2 class="product-title">Contact Us</h2>
                     <ol class="breadcrumb">
                        <li><a href="index.php">Home /</a></li>
                        <li class="current">Contact Us</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <section id="google-map-area">
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14678.924075182784!2d72.5949187!3d23.1069404!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x748d0828c02cf9fa!2sVishwakarma%20Government%20Engineering%20College!5e0!3m2!1sen!2sin!4v1626360234745!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
               </div>
            </div>
         </div>
      </section>
      <section id="content" class="section-padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 col-md-8 col-xs-12">
                  <form id="contactForm" class="contact-form" data-toggle="validator">
                     <h2 class="contact-title">
                        Send Message Us
                     </h2>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="row">
                              <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                 <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required data-error="Please enter your name">
                                    <div class="help-block with-errors"></div>
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                 <div class="form-group">
                                    <input type="email" class="form-control" id="email" placeholder="Email" required data-error="Please enter your email">
                                    <div class="help-block with-errors"></div>
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                 <div class="form-group">
                                    <input type="text" class="form-control" id="msg_subject" name="subject" placeholder="Subject" required data-error="Please enter your subject">
                                    <div class="help-block with-errors"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <textarea class="form-control" placeholder="Message" rows="7" data-error="Write your message" required></textarea>
                                    <div class="help-block with-errors"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <button type="submit" id="submit" class="btn btn-common">Submit Now</button>
                           <div id="msgSubmit" class="h3 text-center hidden"></div>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="col-lg-4 col-md-4 col-xs-12">
                  <div class="information mb-4">
                     <h3>Address</h3>
                     <div class="contact-datails">
                        <p>Vishwakarma Government Engineering College<br>Chandkheda, Ahmedabad, Gujarat</p>
                     </div>
                  </div>
                  <div class="information">
                     <h3>Contact Info</h3>
                     <div class="contact-datails">
                        <ul class="list-unstyled info">
                           <li>
                              <span>Address : </span>
                              Vishwakarma Government Engineering College<br>Chandkheda, Ahmedabad, Gujarat
                           </li>
                           <li>
                              <span>Email : </span>
                              <p>kisanmitrasupport@gmail.com</p>
                           </li>
                           <li>
                              <span>Phone : </span>
                              <p>+91 9876543210</p>
                           </li>
                        </ul>
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
      <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-min.js"></script>
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