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
$query = "select * from users where email = '".$_COOKIE['user']."'";
$userdata = mysqli_query($conn, $query);
$user = mysqli_fetch_array($userdata);

$query = "select * from ads order by id desc LIMIT 10";
$ads = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include("head.php"); ?>
   </head>
   <body>
      <?php include("navbar.php"); ?>
      <div id="hero-area">
         <div class="overlay"></div>
         <div class="container">
            <div class="row justify-content-center">			
               <div class="col-md-12 col-lg-9 col-xs-12 text-center">
                  <div class="contents" style="padding: 100px 0 100px">			
<img class="col-4" src="assets/img/farmer.png">
<img class="col-4" src="assets/img/logo.svg">
                     <h1 class="head-title" style="margin-top: 10px;">Welcome <span class="year"><?php echo $user['firstname']." ".$user['lastname']; ?></span></h1>
                     <div id="google_translate_element"></div>
					 <p>Buy and sell agricultural commodities, get exposure to country wide traders and ease of business</p>
                     <div class="search-bar">
                        <div class="search-inner">                          
						   <form class="search-form" method="get" action="ads_display.php" id="form" style="margin-bottom: 0px;">
                              <div class="form-group inputwithicon"> <i class="lni-tag" style="background-color: white;"></i>
                                 <input type="text" name="keyword" class="form-control" placeholder="Enter Product Keyword" required> 
                              </div>
                              <div class="form-group inputwithicon">
                                 <i class="lni-target" onclick="getLocation()" style="background-color: white;"></i>
                                 <div class="select">
                                    <input type="text" class="form-control" id="autocomplete" onFocus="geolocate()" name="location" placeholder="Location" required>
									<input id="lat" name="latitude" type="hidden">
									<input id="long" name="longitude" type="hidden">
                                 </div>
                              </div>
                              <div class="form-group inputwithicon">
                                 <i class="lni-menu"></i>
                                 <div class="select">
                                    <select name="commodity" required id="commodity">
									   <?php include("options.php"); ?>
									</select>
                                 </div>
                              </div>
                              <button class="btn btn-common col-lg-2 col-sm-12" style="width: 100%;" value="submit" name="submit" onclick="submitform()"><i class="lni-search"></i> Search Now</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </header>
      <section id="categories" class="section-padding">
         <div class="container">
            <div class="row">
               <div class="col-12 text-center">
                  <div class="heading">
                     <h1 class="section-title">Services We Provide</h1>
                     <h4 class="sub-title">Find right here </h4>
                  </div>
               </div>              
               <div class="col-lg-4 col-md-6 col-xs-12">
                  <a href="post_ads.php">
                     <div class="category-icon-item lis-bg2">
                        <div class="icon-box" style="padding: 10px">
                           <div class="icon">
                              <i class="lni-clipboard"></i>
                           </div>
                           <h4>Free Ads Posting</h4>
                           <p class="categories-listing"></p>
                        </div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-4 col-md-6 col-xs-12">
                  <a href="messages.php?option=all">
                     <div class="category-icon-item lis-bg3">
                        <div class="icon-box" style="padding: 10px">
                           <div class="icon">
                              <i class="lni-bubble"></i>
                           </div>
                           <h4>Messages</h4>                           
                        </div>
                     </div>
                  </a>
               </div>                         
               <div class="col-lg-4 col-md-6 col-xs-12">
                  <a href="news.php">
                     <div class="category-icon-item lis-bg6">
                        <div class="icon-box" style="padding: 10px">
                           <div class="icon">
                              <i class="lni-world"></i>
                           </div>
                           <h4>News Updates</h4>                           
                        </div>
                     </div>
                  </a>
               </div>               
               <div class="col-lg-4 col-md-6 col-xs-12">
                  <a href="commodity_index.php">
                     <div class="category-icon-item lis-bg8">
                        <div class="icon-box" style="padding: 10px">
                           <div class="icon">
                              <i class="lni lni-stats-up"></i>
                           </div>
                           <h4>Commodity Index</h4>                           
                        </div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-4 col-md-6 col-xs-12">
                  <a href="cropinfo.php">
                     <div class="category-icon-item lis-bg9">
                        <div class="icon-box" style="padding: 10px">
                           <div class="icon">
                              <i class="lni-leaf"></i>
                           </div>
                           <h4>Crop Information</h4>
                        </div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-4 col-md-6 col-xs-12">
                  <a href="insurance.php">
                     <div class="category-icon-item lis-bg10">
                        <div class="icon-box" style="padding: 10px">
                           <div class="icon">
                              <i class="lni-check-box"></i>
                           </div>
                           <h4>Insurance Services</h4>                           
                        </div>
                     </div>
                  </a>
               </div>                          
            </div>
         </div>
      </section>
      <section class="featured section-padding">
         <div class="container">
            <div class="row">
               <div class="col-12 text-center">
                  <div class="heading">
                     <h1 class="section-title">Latest Products</h1>
                     <h4 class="sub-title">Discover & connect with top-rated local businesses</h4>
                  </div>
               </div>
			   <?php while($ad = mysqli_fetch_array($ads)){ ?>
               <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">			   
                  <div class="featured-box">
                     <figure style="height: 200px;">  
                        <a href="ads_details.php?id=<?php echo $ad['id']; ?>"><img class="img-fluid" style="height: 100%; width:100%;" src="<?php $string = $ad['images']; $str_arr = explode (",", $string); echo $str_arr[0]; ?>" alt=""></a>
                     </figure>
                     <div class="content-wrapper">
                        <div class="feature-content">
                           <h4><a href="ads_details.php?id=<?php echo $ad['id']; ?>"><?php echo substr($ad["description"],0,25)."..."; ?></a></h4>
                           <p class="listing-tagline"><?php echo substr($ad["description"],0,25)."..."; ?></p>
                           <div class="meta-tag">
                              <div class="listing-review">
                                 <span class="review-avg"><?php echo $ad['city']; ?></span>
                                 ₹<?php echo " ".$ad['price']."/".$ad['unit']; ?>
                              </div>                              
                              <div class="listing-category">
                                 <i class="lni-list"></i><?php echo " ".$ad['commodity']; ?> 
                              </div>
                           </div>
                        </div>
                        <div class="listing-bottom clearfix">
                           <i class="lni-map-marker"></i> <?php echo $ad['state']; ?>
                           <a href="ads_details.php?id=<?php echo $ad['id']; ?>" class="float-right">View Details</a>
                        </div>
                     </div>
                  </div>			   
               </div>
			   <?php } ?>
            </div>
         </div>
      </section>      
      <section class="works section-padding">
         <div class="container">
            <div class="row">
               <div class="col-12 text-center">
                  <div class="heading">
                     <h1 class="section-title">How It Works?</h1>
                     <h4 class="sub-title">Discover & connect with local businesses</h4>
                  </div>
               </div>
               <div class="col-lg-4 col-md-4 col-xs-12">
                  <div class="works-item">
                     <div class="icon-box">
                        <i class="lni-users"></i>
                     </div>
                     <p>Create an Account</p>
                  </div>
               </div>
               <div class="col-lg-4 col-md-4 col-xs-12">
                  <div class="works-item">
                     <div class="icon-box">
                        <i class="lni-bookmark-alt"></i>
                     </div>
                     <p>Post Free Ad</p>
                  </div>
               </div>
               <div class="col-lg-4 col-md-4 col-xs-12">
                  <div class="works-item">
                     <div class="icon-box">
                        <i class="lni-thumbs-up"></i>
                     </div>
                     <p>Deal Done</p>
                  </div>
               </div>
               <hr class="works-line">
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
	  <script src="assets/js/location.js"></script>
	  <script>

    var placeSearch, autocomplete;

    function getLocation() {	
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    }

    function showPosition(position) {		
        const latlng = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
        };
        document.getElementById('lat').value = position.coords.latitude;
        document.getElementById('long').value = position.coords.longitude;
        const geocoder = new google.maps.Geocoder();
        geocoder
            .geocode({
                location: latlng
            })
            .then((response) => {
                if (response.results[0]) {
                    const marker = new google.maps.Marker({
                        position: latlng,
                    });                     												
                    document.getElementById('autocomplete').value=response.results[1].formatted_address;
                    // Get each component of the address from the place details
                    // and fill the corresponding field on the form.
                    for (var i = 0; i < response.results[1].address_components.length; i++) {
                        var addressType = response.results[1].address_components[i].types[0];
                    }
                } else {
                    window.alert("No results found");
                }
            })
    }
	
		function submitform()
		{
			document.getElementById("form").submit();
		}
		$(document).keypress(
		function(event){
			if (event.which == '13') {
			  event.preventDefault();
			}
		});
	  </script>
	  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvRwR3-fGr8AsnMdzmQVkgCdlWhqUiCG0&libraries=places&callback=initAutocomplete" async defer></script>
   </body>
</html>