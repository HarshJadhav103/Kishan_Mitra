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
                     <h2 class="product-title">My Favorites</h2>
                     <ol class="breadcrumb">
                        <li><a href="index.php">Home /</a></li>
                        <li class="current">My Favorites</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="content" class="section-padding">
         <div class="container">
            <div class="row">
               <!--<div class="col-sm-12 col-md-4 col-lg-3 page-sidebar">
                  <aside>
                     <div class="sidebar-box">
                        <div class="user">
                           <figure>
                              <a href="#"><img src="assets/img/author/img1.jpg" alt=""></a>
                           </figure>
                           <div class="usercontent">
                              <h3>Hello William!</h3>
                              <h4>Administrator</h4>
                           </div>
                        </div>
                        <nav class="navdashboard">
                           <ul>
                              <li>
                                 <a href="dashboard.html">
                                 <i class="lni-dashboard"></i>
                                 <span>Dashboard</span>
                                 </a>
                              </li>
                              <li>
                                 <a href="account-profile-setting.html">
                                 <i class="lni-cog"></i>
                                 <span>Profile Settings</span>
                                 </a>
                              </li>
                              <li>
                                 <a href="account-myads.html">
                                 <i class="lni-layers"></i>
                                 <span>My Ads</span>
                                 </a>
                              </li>
                              <li>
                                 <a href="offermessages.html">
                                 <i class="lni-envelope"></i>
                                 <span>Offers/Messages</span>
                                 </a>
                              </li>
                              <li>
                                 <a href="payments.html">
                                 <i class="lni-wallet"></i>
                                 <span>Payments</span>
                                 </a>
                              </li>
                              <li>
                                 <a class="active" href="account-favourite-ads.html">
                                 <i class="lni-heart"></i>
                                 <span>My Favourites</span>
                                 </a>
                              </li>
                              <li>
                                 <a href="privacy-setting.html">
                                 <i class="lni-star"></i>
                                 <span>Privacy Settings</span>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                 <i class="lni-enter"></i>
                                 <span>Logout</span>
                                 </a>
                              </li>
                           </ul>
                        </nav>
                     </div>                    
                  </aside>
               </div>-->
               <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="page-content">
                     <div class="inner-box">
                        <div class="dashboard-box">
                           <h2 class="dashbord-title">My Favourites</h2>
                        </div>
                        <div class="dashboard-wrapper">
                           <nav class="nav-table">
                              <ul>
                                 <li class="active"><a href="#">Featured (12)</a></li>
                              </ul>
                           </nav>
                           <table class="table table-responsive dashboardtable tablemyads">
                              <thead>
                                 <tr>                                    
                                    <th>Photo</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Ad Status</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr data-category="active">                                    
                                    <td class="photo"><img class="img-fluid" src="assets/img/product/img2.jpg" alt=""></td>
                                    <td data-title="Title">
                                       <h3>Jvc Haebr80b In-ear Sports Headphones</h3>
                                       <span>Ad ID: ng3D5hAMHPajQrM</span>
                                    </td>
                                    <td data-title="Category">Electronics</td>
                                    <td data-title="Ad Status"><span class="adstatus adstatusactive">Active</span></td>
                                    <td data-title="Price">
                                       <h3>$189</h3>
                                    </td>
                                    <td data-title="Action">
                                       <div class="btns-actions">
                                          <a class="btn-action btn-view" href="#"><i class="lni-eye"></i></a>
                                          <a class="btn-action btn-edit" href="#"><i class="lni-pencil"></i></a>
                                          <a class="btn-action btn-delete" href="#"><i class="lni-trash"></i></a>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr data-category="inactive">                                    
                                    <td class="photo"><img class="img-fluid" src="assets/img/product/img3.jpg" alt=""></td>
                                    <td data-title="Title">
                                       <h3>Furniture Straps 4-Pack, TV Anti-Tip Metal Wall </h3>
                                       <span>Ad ID: ng3D5hAMHPajQrM</span>
                                    </td>
                                    <td data-title="Category">Real Estate</td>
                                    <td>
                                       <span class="adstatus adstatusinactive">Inactive</span>
                                    </td>
                                    <td data-title="Price">
                                       <h3>$69</h3>
                                    </td>
                                    <td data-title="Action">
                                       <div class="btns-actions">
                                          <a class="btn-action btn-view" href="#"><i class="lni-eye"></i></a>
                                          <a class="btn-action btn-edit" href="#"><i class="lni-pencil"></i></a>
                                          <a class="btn-action btn-delete" href="#"><i class="lni-trash"></i></a>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr data-category="sold">                                    
                                    <td class="photo"><img class="img-fluid" src="assets/img/product/img4.jpg" alt=""></td>
                                    <td data-title="Title">
                                       <h3>Apple iPhone X, Fully Unlocked 5.8", 64 GB - Black</h3>
                                       <span>Ad ID: ng3D5hAMHPajQrM</span>
                                    </td>
                                    <td data-title="Category">Mobile</td>
                                    <td data-title="Ad Status"><span class="adstatus adstatussold">Sold</span></td>
                                    <td data-title="Price">
                                       <h3>$89</h3>
                                    </td>
                                    <td data-title="Action">
                                       <div class="btns-actions">
                                          <a class="btn-action btn-view" href="#"><i class="lni-eye"></i></a>
                                          <a class="btn-action btn-delete" href="#"><i class="lni-trash"></i></a>
                                       </div>
                                    </td>
                                 </tr>                                                                  
                                 <tr data-category="expired">                                    
                                    <td class="photo"><img class="img-fluid" src="assets/img/product/img7.jpg" alt=""></td>
                                    <td data-title="Title">
                                       <h3>Essential Phone 8GB Unlocked with Dual Camera</h3>
                                       <span>Ad ID: ng3D5hAMHPajQrM</span>
                                    </td>
                                    <td data-title="Category">Mobile</td>
                                    <td data-title="Ad Status"><span class="adstatus adstatusexpired">Expired</span></td>
                                    <td data-title="Price">
                                       <h3>$89</h3>
                                    </td>
                                    <td data-title="Action">
                                       <div class="btns-actions">
                                          <a class="btn-action btn-view" href="#"><i class="lni-eye"></i></a>
                                          <a class="btn-action btn-edit" href="#"><i class="lni-pencil"></i></a>
                                          <a class="btn-action btn-delete" href="#"><i class="lni-trash"></i></a>
                                       </div>
                                    </td>
                                 </tr>                                 
                                 <tr data-category="deleted">                                    
                                    <td class="photo"><img class="img-fluid" src="assets/img/product/img10.jpg" alt=""></td>
                                    <td data-title="Title">
                                       <h3>Apple iMac Pro 27" All-in-One Desktop, Space Gray</h3>
                                       <span>Ad ID: ng3D5hAMHPajQrM</span>
                                    </td>
                                    <td data-title="Category">Apple iMac</td>
                                    <td data-title="Ad Status"><span class="adstatus adstatusdeleted">Deleted</span></td>
                                    <td data-title="Price">
                                       <h3>$389</h3>
                                    </td>
                                    <td data-title="Action">
                                       <div class="btns-actions">
                                          <a class="btn-action btn-view" href="#"><i class="lni-eye"></i></a>
                                          <a class="btn-action btn-edit" href="#"><i class="lni-pencil"></i></a>
                                          <a class="btn-action btn-delete" href="#"><i class="lni-trash"></i></a>
                                       </div>
                                    </td>
                                 </tr>
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