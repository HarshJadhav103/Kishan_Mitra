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
   
   if($_GET['option']=="all")
   {
	   $query = "select * from chat where (user_from = '".$_COOKIE['user']."' or user_to ='".$_COOKIE['user']."') and start_point ='1'"; 
	   $message_result = mysqli_query($conn, $query); 
	   $total = mysqli_num_rows($message_result);
		
   }else if($_GET['option']=="buying")
   {
	   $query = "select * from chat where user_from = '".$_COOKIE['user']."' and start_point ='1'";   
	   $message_result = mysqli_query($conn, $query);   
	   $total = mysqli_num_rows($message_result);
   }else if($_GET['option']=="selling")
   {
	   $query = "select * from chat where user_to ='".$_COOKIE['user']."' and start_point ='1'";   
	   $message_result = mysqli_query($conn, $query);   
	   $total = mysqli_num_rows($message_result);
   }else
   {
	   $query = "select * from chat where (user_from = '".$_COOKIE['user']."' or user_to ='".$_COOKIE['user']."') and start_point ='1'";   
	   $message_result = mysqli_query($conn, $query);   
	   $total = mysqli_num_rows($message_result);
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
                     <h2 class="product-title">Messages</h2>
                     <ol class="breadcrumb">
                        <li><a href="index.php">Home /</a></li>
                        <li class="current">Messages</li>
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
                  <div class="page-content">
                     <div class="inner-box">
                        <div class="dashboard-box">
                           <h2 class="dashbord-title">Messages</h2>
                        </div>
                        <div class="dashboard-wrapper" >
                           <nav class="nav-table">
                              <ul>
                                 <li <?php if($_GET['option']=="all") { echo "class='active'"; } ?>><a href="messages.php?option=all">ALL <?php if($_GET['option']=="all") {echo "(".$total.")";} ?></a></li>
                                 <li <?php if($_GET['option']=="buying") { echo "class='active'"; } ?>><a href="messages.php?option=buying">BUYING <?php if($_GET['option']=="buying") {echo "(".$total.")";} ?></a></li>
                                 <li <?php if($_GET['option']=="selling") { echo "class='active'"; } ?>><a href="messages.php?option=selling">SELLING <?php if($_GET['option']=="selling") {echo "(".$total.")";} ?></a></li>
                              </ul>
                           </nav>
                           <div class="dashboard-wrapper">
                              <form class="row offers-messages">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                 <div class="offers-box" style="width: 100%; border-right: none;">
                                    <div class="dashboardboxtitle">
                                       <h2>User</h2>
                                    </div>
                                    <ul class="offers-user-online">
									<?php while( $message = mysqli_fetch_assoc($message_result) ){
										if($message['user_from']==$_COOKIE['user'])
										{
											$message['user_from'] = $message['user_to'];
										}	
										$query = "select * from users where email = '".$message['user_from']."'";
										$userdata = mysqli_query($conn, $query);
										$user = mysqli_fetch_array($userdata);
										
										$query = "select * from ads where id = '".$message['ad_id']."'";
										$ad_data = mysqli_query($conn, $query);
										$ad = mysqli_fetch_array($ad_data);
										
										$query = "select * from users where email = '".$_COOKIE['user']."'";
										$mydata = mysqli_query($conn, $query);
										$myinfo = mysqli_fetch_array($mydata);
										
										if($ad['user_id']==$_COOKIE['user'])
										{
											$url = "chat.php?chat=".$message['ad_id']."&seller=".$myinfo['id']."&buyer=".$user['id'];
										}else
										{
											$url = "chat.php?chat=".$message['ad_id']."&seller=".$user['id']."&buyer=".$myinfo['id'];
										}											
										
									?>									
                                       <li class="offerer">
										<a href="<?php echo $url; ?>">
                                          <figure>
                                             <img style="height: 50px; width: 50px;" src="<?php echo $user['profile_picture']; ?>" alt="">
                                          </figure>
                                          <span class="bolticon"></span>
                                          <div class="user-name">
                                             <h3><?php echo $user['firstname']." ".$user['lastname']; ?></h3>
                                             <h4><?php echo $ad['title']; ?></h4>
                                          </div>
										</a>
									  </li> 									  
									<?php } ?>                                                                            
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
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