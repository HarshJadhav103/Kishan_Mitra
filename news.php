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
                     <h2 class="product-title">News</h2>
                     <ol class="breadcrumb">
                        <li><a href="index.php">Home /</a></li>
                        <li class="current">News</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="content" class="section-padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-xs-12">
                  <div class="blog-post">
                     <div class="post-thumb">
                        <a href="#"><img class="img-fluid" src="assets/img/blog/blog1.jpg" alt=""></a>
                        <div class="hover-wrap"></div>
                     </div>
                     <div class="post-content">
                        <div class="meta">
                           <span class="meta-part"><a href="#"><i class="lni-user"></i> Clasified</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-alarm-clock"></i> June 21, 2020</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-folder"></i> Sticky</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-comments-alt"></i> 1 Comments</a></span>
                        </div>
                        <h2 class="post-title"><a href="single-post.html">Eum Iriure Dolor Duis Autem</a></h2>
                        <div class="entry-summary">
                           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis soluta libero molestiae, id reiciendis ipsum consequuntur odit sapiente accusantium odio. Esse nemo quos quaerat illo! Enim saepe impedit distinctio, placeat. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptatum dolores mollitia consequatur velit, veritatis in pariatur ducimus numquam ipsa iusto! Rem eveniet dolorum, quisquam neque beatae quas ea tenetur!</p>
                        </div>                        
                     </div>
                  </div>
                  <div class="blog-post">
                     <div class="post-thumb">
                        <a href="#"><img class="img-fluid" src="assets/img/blog/blog2.jpg" alt=""></a>
                        <div class="hover-wrap"></div>
                     </div>
                     <div class="post-content">
                        <div class="meta">
                           <span class="meta-part"><a href="#"><i class="lni-user"></i> Clasified</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-alarm-clock"></i> June 21, 2020</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-folder"></i> Sticky</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-comments-alt"></i> 1 Comments</a></span>
                        </div>
                        <h2 class="post-title"><a href="single-post.html">Consectetuer Adipiscing Elit</a></h2>
                        <div class="entry-summary">
                           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis soluta libero molestiae, id reiciendis ipsum consequuntur odit sapiente accusantium odio. Esse nemo quos quaerat illo! Enim saepe impedit distinctio, placeat. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptatum dolores mollitia consequatur velit, veritatis in pariatur ducimus numquam ipsa iusto! Rem eveniet dolorum, quisquam neque beatae quas ea tenetur!</p>
                        </div>                        
                     </div>
                  </div>
                  <div class="blog-post">
                     <div class="post-thumb">
                        <a href="#"><img class="img-fluid" src="assets/img/blog/blog3.jpg" alt=""></a>
                        <div class="hover-wrap"></div>
                     </div>
                     <div class="post-content">
                        <div class="meta">
                           <span class="meta-part"><a href="#"><i class="lni-user"></i> Clasified</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-alarm-clock"></i> June 21, 2020</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-folder"></i> Sticky</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-comments-alt"></i> 1 Comments</a></span>
                        </div>
                        <h2 class="post-title"><a href="single-post.html">Et Leggings Fanny Pack</a></h2>
                        <div class="entry-summary">
                           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis soluta libero molestiae, id reiciendis ipsum consequuntur odit sapiente accusantium odio. Esse nemo quos quaerat illo! Enim saepe impedit distinctio, placeat. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptatum dolores mollitia consequatur velit, veritatis in pariatur ducimus numquam ipsa iusto! Rem eveniet dolorum, quisquam neque beatae quas ea tenetur!</p>
                        </div>                        
                     </div>
                  </div>
                  <div class="blog-post video-post">
                     <div class="post-thumb">
                        <div class="video-wrapper">
                           <iframe width="100%" height="315" src="https://www.youtube.com/embed/qighCE8WfBk" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                     </div>
                     <div class="post-content">
                        <div class="meta">
                           <span class="meta-part"><a href="#"><i class="lni-user"></i> Clasified</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-alarm-clock"></i> June 21, 2020</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-folder"></i> Sticky</a></span>
                           <span class="meta-part"><a href="#"><i class="lni-comments-alt"></i> 1 Comments</a></span>
                        </div>
                        <h2 class="post-title"><a href="single-post.html">Exercitation Photo Booth</a></h2>
                        <div class="entry-summary">
                           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis soluta libero molestiae, id reiciendis ipsum consequuntur odit sapiente accusantium odio. Esse nemo quos quaerat illo! Enim saepe impedit distinctio, placeat. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate voluptatum dolores mollitia consequatur velit, veritatis in pariatur ducimus numquam ipsa iusto! Rem eveniet dolorum, quisquam neque beatae quas ea tenetur!</p>
                        </div>                        
                     </div>
                  </div>
                  <div class="pagination-bar">
                     <nav>
                        <ul class="pagination">
                           <li class="page-item"><a class="page-link active" href="#">1</a></li>
                           <li class="page-item"><a class="page-link" href="#">2</a></li>
                           <li class="page-item"><a class="page-link" href="#">3</a></li>
                           <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                     </nav>
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