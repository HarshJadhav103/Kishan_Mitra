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
	$query = "select * from ads where user_id = '".$_COOKIE['user']."'";
	$ad_data = mysqli_query($conn, $query);
	$count = mysqli_num_rows($ad_data);
}else if($_GET['option']=="active")
{
	$query = "select * from ads where user_id = '".$_COOKIE['user']."' and status = '".'ACTIVE'."'";	
	$ad_data = mysqli_query($conn, $query);
	$count = mysqli_num_rows($ad_data);
}
else if($_GET['option']=="sold")
{
	$query = "select * from ads where user_id = '".$_COOKIE['user']."' and status = '".'SOLD'."'";	
	$ad_data = mysqli_query($conn, $query);
	$count = mysqli_num_rows($ad_data);
}
else if($_GET['option']=="expired")
{
	$query = "select * from ads where user_id = '".$_COOKIE['user']."' and status = '".'EXPIRED'."'";
	$ad_data = mysqli_query($conn, $query);
	$count = mysqli_num_rows($ad_data);
}
else if($_GET['option']=="deleted")
{
	$query = "select * from ads where user_id = '".$_COOKIE['user']."' and status = '".'DELETED'."'";
	$ad_data = mysqli_query($conn, $query);
	$count = mysqli_num_rows($ad_data);
}else{
	$query = "select * from ads where user_id = '".$_COOKIE['user']."'";
	$ad_data = mysqli_query($conn, $query);
	$count = mysqli_num_rows($ad_data);
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
                     <h2 class="product-title">My Ads</h2>
                     <ol class="breadcrumb">
                        <li><a href="index.php">Home /</a></li>
                        <li class="current">My Ads</li>
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
                           <h2 class="dashbord-title">My Ads</h2>
                        </div>
                        <div class="dashboard-wrapper">
                           <nav class="nav-table">
                              <ul>
                                 <li <?php if($_GET['option']=="all") { echo "class='active'"; } ?>><a href="myads.php?option=all">ALL Ads<?php if($_GET['option']=="all") {echo " (".$count.")";} ?></a></li>                                 
                                 <li <?php if($_GET['option']=="active") { echo "class='active'"; } ?>><a href="myads.php?option=active">Active<?php if($_GET['option']=="active") {echo " (".$count.")";} ?></a></li>
								 <li <?php if($_GET['option']=="sold") { echo "class='active'"; } ?>><a href="myads.php?option=sold">Sold<?php if($_GET['option']=="sold") {echo " (".$count.")";} ?></a></li>
                                 <li <?php if($_GET['option']=="expired") { echo "class='active'"; } ?>><a href="myads.php?option=expired">Expired<?php if($_GET['option']=="expired") {echo " (".$count.")";} ?></a></li>
								 <li <?php if($_GET['option']=="deleted") { echo "class='active'"; } ?>><a href="myads.php?option=deleted">Deleted<?php if($_GET['option']=="deleted") {echo " (".$count.")";} ?></a></li>
                              </ul>
                           </nav>
                           <table class="table table-responsive dashboardtable tablemyads">
                              <thead>
                                 <tr>         									
                                    <th>Photo</th>
                                    <th>Title</th>
                                    <th>Commodity</th>
                                    <th>Ad Status</th>
                                    <th>Price</th>
                                    <th>Action</th>									
                                 </tr>
                              </thead>
                              <tbody>      
								<?php while($data = mysqli_fetch_array($ad_data)){ ?>								
                                 <tr data-category="active">                                    
                                    <td class="photo"><img class="img-fluid" src="<?php $string = $data['images']; $str_arr = explode (",", $string); echo $str_arr[0]; ?>" alt=""></td>
                                    <td data-title="Title">
                                       <h3><?php echo $data['title']; ?></h3>
                                       <span>Ad ID: <?php echo $data['id']; ?></span>
                                    </td>
                                    <td data-title="Category"><?php echo $data['commodity']; ?></td>
                                    <td data-title="Ad Status"><span class="adstatus adstatusactive"><?php echo $data['status']; ?></span></td>
                                    <td data-title="Price">
                                       <h3>₹ <?php echo $data['price']; ?></h3>
                                    </td>
                                    <td data-title="Action">
                                       <div class="btns-actions">
                                          <a class="btn-action btn-view" href="#"><i class="lni-eye"></i></a>
                                          <a class="btn-action btn-edit" href="#"><i class="lni-pencil"></i></a>
                                          <a class="btn-action btn-delete" href="#"><i class="lni-trash"></i></a>
                                       </div>
                                    </td>
                                 </tr>
								<?php } ?>                                  
                              </tbody>
                           </table>
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