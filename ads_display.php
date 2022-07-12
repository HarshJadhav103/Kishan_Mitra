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

if(isset($_GET['submit']))
{
	$commodity = $_GET['commodity'];
	$keyword = $_GET['keyword'];
	$location = $_GET['location'];
	$latitude = $_GET['latitude'];
	$longitude = $_GET['longitude'];	
	$status = "ACTIVE";	
	$url = "?keyword=$commodity&location=$location&latitude=$latitude&longitude=$longitude&commodity=$commodity&submit=$submit";
	if($latitude == "" || $longitude == "")
	{
		echo "<script>alert('Please enter valid location'); window.location = 'index.php';</script>";
	}else
	{		
		$query="SELECT *, ( 6371 * acos( cos( radians('".$latitude."') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('".$longitude."') ) + sin( radians('".$latitude."') ) * sin( radians( latitude ) ) ) ) AS distance FROM ads WHERE ((title LIKE '%".$keyword."%' or description LIKE '%".$keyword."%' or commodity LIKE '%".$keyword."%' and status='".$status."') or (commodity='".$commodity."' and status='".$status."')) and user_id != '".$_COOKIE['user']."' ORDER by distance ASC";			
		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);
		if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
		$no_of_records_per_page = 12;
        $offset = ($pageno-1) * $no_of_records_per_page;		
		$total_pages = ceil($count / $no_of_records_per_page);
		
		$query="SELECT *, ( 6371 * acos( cos( radians('".$latitude."') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('".$longitude."') ) + sin( radians('".$latitude."') ) * sin( radians( latitude ) ) ) ) AS distance FROM ads WHERE ((title LIKE '%".$keyword."%' or description LIKE '%".$keyword."%' or commodity LIKE '%".$keyword."%' and status='".$status."') or (commodity='".$commodity."' and status='".$status."')) and user_id != '".$_COOKIE['user']."' ORDER by distance ASC LIMIT " . $offset . ','  . $no_of_records_per_page;			
		$result = mysqli_query($conn,$query);	
	}
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
               <div class="col-md-12 col-lg-9 col-xs-12 text-center">
                  <div class="contents-ctg">
                     <div class="search-bar">
                        <div class="search-inner">
                           <form class="search-form" method="get" action="" id="form" style="margin-bottom: 0px;">
                              <div class="form-group inputwithicon"> <i class="lni-tag" style="background-color: white;"></i>
                                 <input type="text" name="keyword" class="form-control" placeholder="Enter Product Keyword" required value="<?php echo $keyword; ?>"> 
                              </div>
                              <div class="form-group inputwithicon">
                                 <i class="lni-target" onclick="getLocation()" style="background-color: white;"></i>
                                 <div class="select">
                                    <input type="text" class="form-control" id="autocomplete" onFocus="geolocate()" name="location" placeholder="Location" required value="<?php echo $location; ?>">
									<input id="lat" name="latitude" type="hidden" value="<?php echo $latitude; ?>">
									<input id="long" name="longitude" type="hidden" value="<?php echo $longitude; ?>">
                                 </div>
                              </div>
                              <div class="form-group inputwithicon">
                                 <i class="lni-menu"></i>
                                 <div class="select">
                                    <select name="commodity" required id="commodity">
									   <?php include("options.php"); ?>
									   <?php if($commodity!=""){ ?>
									   <option value="<?php echo $commodity ?>" selected><?php echo $commodity; ?></option>
									   <?php } ?>
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
      <div class="main-container section-padding">
         <div class="container">
            <div class="row">               
               <div class="col-lg-12 col-md-12 col-xs-12 page-content">
			   <?php if($count>0){ ?>
                  <div class="product-filter">
                     <div class="short-name"> <span>Showing (<?php $start=$pageno; $start = ($start-1) * 12 + 1; $end = ($start + 12)-1; if($end>$count){ $end=$count; } echo $start ."-". $end; ?> products of <?php echo $count; ?> products)</span> </div>
                     <div class="Show-item">
                        <span>Short By</span>
                        <form class="woocommerce-ordering" method="post">
                           <label>
                              <select name="order" class="orderby">
                                 <option selected="selected" value="relevance">Relevance</option>                                 
                                 <option value="hightolow">Price High to Low</option>
                                 <option value="lowtohigh">Price Low to High</option>                                 
                              </select>
                           </label>
                        </form>
                     </div>                     
                  </div>
                  <div class="adds-wrapper">
                     <div class="tab-content">
                        <div id="grid-view" class="tab-pane fade active show">
                           <div class="row">						   
						   <?php while($data = mysqli_fetch_assoc($result))
								{
									$query = "select * from users where email = '".$data['user_id']."'";
									$userdata = mysqli_query($conn, $query);
									$user = mysqli_fetch_array($userdata);
							   ?>
                              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                 <div class="featured-box">
                                    <figure style="height: 200px;">
                                       <div class="homes-tag featured"><?php echo $data["commodity"]; ?></div>
                                       <!--<div class="homes-tag rent"><i class="lni-heart"></i> 202</div>-->
                                       <span class="price-save">
                                       ₹<?php echo $data["price"]." per ".$data["unit"]; ?> 
                                       </span>
                                       <a href="ads_details.php?id=<?php echo $data["id"]; ?>"><img class="img-fluid" style="height: 100%; width:100%;" src="<?php $string = $data['images']; $str_arr = explode (",", $string); echo $str_arr[0]; ?>" alt=""></a>
                                    </figure>
                                    <div class="content-wrapper">
                                       <div class="feature-content">
                                          <h4><a href="ads_details.php?id=<?php echo $data["id"]; ?>"><?php echo $data["title"]; ?></a></h4>
                                          <p class="listing-tagline"><?php echo substr($data["description"],0,25)."..."; ?></p>
                                          <div class="meta-tag">
                                             <div class="listing-review"> <span class="review-avg"><?php echo $data["city"];?></span></div>
                                             <div class="user-name"><i class="lni-user"></i><?php echo $user['firstname']; ?></div>
                                             <div class="listing-category"><i class="lni-list"></i> <?php echo $data["commodity"]; ?></div>
                                          </div>
                                       </div>
                                       <div class="listing-bottom clearfix"><i class="lni-map-marker"></i> <?php echo $data["state"]." ".round($data["distance"],2)."Kms "; ?> <a href="ads_details.php?id=<?php echo $data["id"]; ?>" class="float-right">View Details</a> </div>
                                    </div>
                                 </div>
                              </div>
							<?php }?>                              
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="pagination-bar">
                     <nav>
                        <ul class="pagination justify-content-center">
                           <li class="page-item"><a <?php if($_GET["btn"]=="first"){ echo "class='page-link active'"; }else{ echo "class='page-link'"; }?> href="<?php echo $url."&btn=first"; ?>&pageno=1">First</a></li>
                           <li class="page-item" <?php if($pageno <= 1){ echo "style='display: none;'"; } ?>>
							<a <?php if($_GET["btn"]=="prev"){ echo "class='page-link active'"; }else{ echo "class='page-link'"; }?> href="<?php if($pageno <= 1){ echo $url . "&pageno=1&btn=prev"; } else { echo $url."&pageno=".($pageno - 1)."&btn=prev"; } ?>">Prev</a>
							</li>
							<li class="page-item" <?php if($pageno >= $total_pages){ echo "style='display: none;'"; } ?>>
							<a <?php if($_GET["btn"]=="next"){ echo "class='page-link active'"; }else{ echo "class='page-link'"; }?> href="<?php if($pageno >= $total_pages){ echo $url . "&pageno=&btn=next" . $total_pages; } else { echo $url."&pageno=".($pageno + 1)."&btn=next"; } ?>">Next</a>
							</li>						   
                           <li class="page-item"><a <?php if($_GET["btn"]=="last"){ echo "class='page-link active'"; }else{ echo "class='page-link'"; }?> href="<?php echo $url."&btn=last"; ?>&pageno=<?php echo $total_pages; ?>">Last</a></li>
                        </ul>
                     </nav>
                  </div>
				  <?php }else{ echo "No Ads available related to your search"; } ?>
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