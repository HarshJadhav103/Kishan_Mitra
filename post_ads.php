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

if(isset($_POST['submit']))
{	
	$title = $_POST['title'];
	$commodity = $_POST['commodity'];
	$price = $_POST['price'];
	$unit = $_POST['unit'];
	$description = $_POST['description'];
	
	$city = $_POST['city'];
	$state = $_POST['state'];
	$country = $_POST['country'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$status = "ACTIVE";
	
	// Count # of uploaded files in array
	$total = count($_FILES['images']['name']);
	$paths = "";
	$query="select * from ads where user_id = '".$_COOKIE['user']."'";
	$result = mysqli_query($conn,$query);
	$count = mysqli_num_rows($result);		
	$count++;
	$subcount = 1;
	date_default_timezone_set("Asia/Kolkata");
	$date = date("d-m-Y").",".date("l").",".date("h:i A");
	
	// Loop through each file
	for( $i=0 ; $i < $total ; $i++ ) {

	  //Get the temp file path
	  $tmpFilePath = $_FILES['images']['tmp_name'][$i];

	  //Make sure we have a file path
	  if ($tmpFilePath != ""){
		//Setup our new file path
		$newFilePath = "ads_images/" . decrypt($_COOKIE["user"]) . $count . "_" . $subcount . $_FILES['images']['name'][$i];
		
		//Upload the file into the temp dir
		if(move_uploaded_file($tmpFilePath, $newFilePath)) {
			if($subcount == 1)
			{
				$paths = $newFilePath;
			}else
			{			
				$paths = $paths . ", " . $newFilePath;
			}	
		}
	  }	  
	  $subcount++;
	}
	$query="INSERT INTO ads (user_id, title, commodity, price, unit, description, images, city, state, country, latitude, longitude, status, date) VALUES ('".$_COOKIE['user']."','".$title."','".$commodity."','".$price."','".$unit."','".$description."','".$paths."','".$city."','".$state."','".$country."','".$latitude."','".$longitude."','".$status."','".$date."')";		
	$result = mysqli_query($conn,$query);	
	if($result)
	{
			echo "<script>alert('Ad Posted Successfully'); window.history.go(-3);</script>";
	}else{
		echo "<script>alert('Error Occured'); window.history.go(-3);</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include("head.php"); ?>
	  <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
	  <style>
		/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		  -webkit-appearance: none;
		  margin: 0;
		}

		/* Firefox */
		input[type=number] {
		  -moz-appearance: textfield;
		}
		.mapouter{
		  text-align:right;height:100%;width:100%;
		}
		.gmap_canvas {
		  overflow:hidden;background:none!important;height:200px;width:100%;
		}	
		</style>
      <!--<link rel="stylesheet" type="text/css" href="assets/css/summernote.css">-->
   </head>
   <body onload="getLocation()">
      <?php include("navbar.php"); ?>
      </header>
      <div class="page-header" style="background: url(assets/img/banner1.jpg); padding: 90px 0 10px;">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="breadcrumb-wrapper">
                     <h2 class="product-title">Post you Ads</h2>
                     <ol class="breadcrumb">
                        <li><a href="index.php">Home /</a></li>
                        <li class="current">Post you Ads</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
      </div>
	  <form method="post" action="" id="form" enctype="multipart/form-data">
      <div id="content" class="section-padding">
         <div class="container">
            <div class="row">               
               <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="row page-content">
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <div class="inner-box">
                           <div class="dashboard-box">
                              <h2 class="dashbord-title">Ad Detail</h2>
                           </div>
                           <div class="dashboard-wrapper">
                              <div class="form-group mb-3">
                                 <label class="control-label">Ad Title <span style="color: red;">*</span></label>
                                 <input class="form-control input-md" id="title" name="title" placeholder="Title" type="text" required>
                              </div>
                              <div class="form-group mb-3 tg-inputwithicon">
                                 <label class="control-label">Commodity <span style="color: red;">*</span></label>
                                 <div class="tg-select form-control">
                                    <select name="commodity" required id="commodity">
											<?php include("options.php"); ?>
									</select>
                                 </div>
                              </div>
                              <div class="form-group mb-3">
                                 <label class="control-label">Price <span style="color: red;">*</span></label>
                                 <input class="form-control input-md" id="price" name="price" placeholder="Enter price" type="number" required>								                                  
                              </div>
							  <div class="form-group mb-3 tg-inputwithicon">
                                 <label class="control-label">Unit <span style="color: red;">*</span></label>
                                 <div class="tg-select form-control">
                                    <select name="unit" required id="unit">             
									   <option value="" selected="selected" disabled>Select</option>									
                                       <option value="Gram">Gram</option>
                                       <option value="Kilogram">Kilogram</option>
                                       <option value="Quintal">Quintal</option>
                                       <option value="Tonne">Tonne</option>                                       
                                    </select>
                                 </div>
                              </div>
                              <div class="form-group md-3">
                                 <section id="editor">
                                    <div id="summernote">
                                       <label class="control-label">Description <span style="color: red;">*</span></label>
                                       <textarea class="form-control" placeholder="Add Details" id="description" name="description" rows="7" data-error="Write your message" required></textarea>
                                    </div>
                                 </section>
                              </div>
                              <label class="tg-fileuploadlabel" for="tg-photogallery">                              
                              <span class="btn btn-common">Select Files *</span> 
							  <span id="max">Maximum 4 image files are allowed</span>							  
                              <input id="tg-photogallery" class="tg-fileinput" type="file" name="images[]" multiple accept="image/*" required>                              
								<div class="row text-center">
								<div class="col-sm-6">
								<img id="one" width="100%" height="250px" style="display: none; padding: 10px;" src="#" alt="your image" />
								</div>
								<div class="col-sm-6">
								<img id="two" width="100%" height="250px" style="display: none; padding: 10px;" src="#" alt="your image" />
								</div>
								<div class="col-sm-6">
								<img id="three" width="100%" height="250px" style="display: none; padding: 10px;" src="#" alt="your image" />
								</div>
								<div class="col-sm-6">
								<img id="four" width="100%" height="250px" style="display: none; padding: 10px;" src="#" alt="your image" />							  
								</div>
								</div>									  							  							  						
							  </label>							  
                           </div>							
                        </div>
                     </div>					 
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                        <div class="inner-box">
                           <div class="tg-contactdetail">
                              <div class="dashboard-box">
                                 <h2 class="dashbord-title">CONFIRM YOUR LOCATION</h2>
                              </div>
                              <div class="dashboard-wrapper">  
                                 <div class="mapouter" id="map" style="margin-bottom: 10px; display:none;">
									<div class="gmap_canvas"><iframe width="100%" height="200px" id="gmap_canvas" src=""
									frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
									</div>
								</div>
								<div class="form-group mb-3">
                                    <label id="location_label" class="control-label">Address</label>
                                    <input class="form-control input-md" id="autocomplete" onFocus="geolocate()" name="address" placeholder="Search City, Area or Neighbourhood" type="text">
								</div>
								<div class="form-group mb-3">
                                    <label class="control-label">City</label>
                                    <input class="form-control input-md" id="locality" name="city" type="text" readonly="true" required>
								</div>								
								<div class="form-group mb-3">
                                    <label class="control-label">State <span style="color: red;">*</span></label>
                                    <input class="form-control input-md" id="administrative_area_level_1" name="state" type="text" readonly="true" required>
								</div>
								<div class="form-group mb-3">
                                    <label class="control-label">Country <span style="color: red;">*</span></label>
                                    <input class="form-control input-md" id="country" name="country" type="text" readonly="true" required>
								</div>
								<input id="lat" name="latitude" type="hidden">
								<input id="long" name="longitude" type="hidden">                                 
                                 <div class="text-center">
									<button class="btn btn-common" value="submit" name="submit" onclick="check()">Post Ad</button>
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
	  </form>
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
		function check()
		{			
			if(document.getElementById("title").value == "" || document.getElementById("commodity").value == "" || document.getElementById("price").value == "" || document.getElementById("unit").value == "" || document.getElementById("description").value == "" ||document.getElementById("administrative_area_level_1").value == "" || document.getElementById("country").value == "" || document.getElementById("tg-photogallery").files.length == 0)
			{
				alert("Fields with * mark are mandatory");
			}else
			{
				document.getElementById("form").submit();
			}
		}		
		$(function(){
			files = document.getElementById("tg-photogallery");
            files.addEventListener("change", function () {				
				document.getElementById("max").innerHTML = "";
               var $fileUpload = $("input[type='file']");
               if (parseInt($fileUpload.get(0).files.length) > 4){
                  alert("Maximum 4 files are allowed");
               }else
			   {	
					const images = ["one", "two", "three", "four"];
				   var file = files.files;
				  if (file) {	
					for(var i = 0; i < 4; i++)
					  {						  
						  document.getElementById(images[i]).style.display = "none";
						  document.getElementById(images[i]).src = "";
					  }
					  for(var i = 0; i < file.length; i++)
					  {
						  if(file[i].type.includes("image")==true)
						  {
							  document.getElementById(images[i]).style.display = "block";
							document.getElementById(images[i]).src = URL.createObjectURL(file[i]);
						  }else
						  {
							  alert("Only Image files are allowed");
							  break;
						  }
					  }
				  }
			   }
            });
         });		 			
	  </script>	
	  <script>
		window.onload = () => {
			const text = document.querySelectorAll('.disclaimer')  
			for (const el of text) {  
				el.parentNode.removeChild(el);  
			}
		}
	  </script>  
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvRwR3-fGr8AsnMdzmQVkgCdlWhqUiCG0&libraries=places&callback=initAutocomplete" async defer></script>
      <!--<script>
         $('#summernote').summernote({
             height: 250, // set editor height
             minHeight: null, // set minimum height of editor
             maxHeight: null, // set maximum height of editor
             focus: false // set focus to editable area after initializing summernote
         });
         </script>-->
   </body>
</html>