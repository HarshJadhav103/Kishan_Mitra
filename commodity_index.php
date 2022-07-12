<?php
error_reporting(0);
include("connection.php");
include("encryptdecrypt.php");
include('array_list.php');
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
	$commodity = $_GET['commodity_input'];
	$district = $_GET['district_name'];
	$market = $_GET['market_name'];
	$state = $_GET['indian_all_states'];	
	$ch = curl_init();

	if($district == "District" or $market == "Market" or $state == "State")
	{
		$url = "https://api.data.gov.in/resource/9ef84268-d588-465a-a308-a864a43d0070?api-key=579b464db66ec23bdd00000143935365cb0043b9664912f40378b98b&format=json&offset=0&limit=500&filters[commodity]=$commodity";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$resp = curl_exec($ch);

		if($e = curl_error($ch))
		{
			echo $e;
		}else
		{
			$decoded = json_decode($resp, true);
			$a = $decoded['records'];
			$max_price = array();
			foreach ($a as $key => $row)
			{
				$max_price[$key] = $row['max_price'];
			}
			array_multisort($max_price, SORT_DESC, $a);			
			$min_price1 = $a[0]['min_price'];
			$modal_price = $a[0]['modal_price'];
			$max_price = $a[0]['max_price'];			
			$commodity = $a[0]['commodity'];
			$market = $a[0]['market'];
			$district = $a[0]['district'];
			$state = $a[0]['state'];
			
			
			$min_price = array();
			foreach ($a as $key => $row)
			{
				$min_price[$key] = $row['min_price'];
			}
			array_multisort($min_price, SORT_ASC, $a);
			$min_price2 = $a[1]['min_price'];
			$modal_price2 = $a[1]['modal_price'];
			$max_price2 = $a[1]['max_price'];			
			$commodity2 = $a[1]['commodity'];
			$market2 = $a[1]['market'];
			$district2 = $a[1]['district'];
			$state2 = $a[1]['state'];
			
		}
		curl_close($ch);
	}else
	{
		$url = "https://api.data.gov.in/resource/9ef84268-d588-465a-a308-a864a43d0070?api-key=579b464db66ec23bdd00000143935365cb0043b9664912f40378b98b&format=json&offset=0&limit=1&filters[state]=$state&filters[district]=$district&filters[commodity]=$commodity&filters[market]=$market";		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$resp = curl_exec($ch);

		if($e = curl_error($ch))
		{
			echo $e;
		}else
		{
			$decoded = json_decode($resp, true);
			foreach ($decoded['records'] as $data)
			{
				$min_price1 = $data['min_price'];
				$modal_price = $data['modal_price'];
				$max_price = $data['max_price'];			
				$commodity = $data['commodity'];
				$market = $data['market'];
				$district = $data['district'];
				$state = $data['state'];				
			};
		}
		curl_close($ch);
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
               <div class="col-md-12 col-lg-12 col-xs-12 text-center">
                  <div class="contents-ctg">
                     <div class="search-bar">
                        <div class="search-inner">
                           <form class="search-form" method="GET" action="" style="margin-bottom: 0px;">                                                           
                              <div class="row">
								<div class="col-lg-3">
									  <div class="form-group inputwithicon" style="width: 100%;">
										 <i class="lni-menu" style="background-color: white;"></i>
										 <div class="select">
											<select id="commodity_input" name="commodity_input" required>
											<option value="Commodity" selected="selected" disabled>Commodity</option>
											<?php
												asort($commodity_name);
												foreach(array_unique($commodity_name) as $cname){
													if ($type == $cname){
														echo "<option selected='selected' value='".$cname."'>".$cname."</option>";
													}else{
														echo "<option value='".$cname."'>".$cname."</option>";
													}
												}
											?>
											<?php if($commodity!=""){ ?>
											   <option value="<?php echo $commodity ?>" selected><?php echo $commodity; ?></option>
										    <?php } ?>
											</select>
										 </div>
									  </div>
								  </div>
								  <div class="col-lg-3">
									  <div class="form-group inputwithicon" style="width: 100%;">
										 <i class="lni-menu" style="background-color: white;"></i>
										 <div class="select">
											<select id="indian_all_states" name="indian_all_states" required>											
											<option value="State" selected="selected">State</option>
											<?php
												asort($indian_all_states);
												foreach(array_unique($indian_all_states) as $cname){
													echo "<option value='".$cname."'>".$cname."</option>";
												}
											?>
											<?php if($state!=""){ ?>
											   <option value="<?php if(!isset($min_price2)) { echo $state; }else{ echo "State"; } ?>" selected><?php if(!isset($min_price2)) { echo $state; }else{ echo "State"; }  ?></option>
										    <?php } ?>
											</select>
										 </div>
									  </div>
								  </div>
								  <div class="col-lg-2">
									  <div class="form-group inputwithicon" style="width: 100%;">
										 <i class="lni-menu" style="background-color: white;"></i>
										 <div class="select">
											<select id="district_name" name="district_name" required>
											<option value="District" selected="selected">District</option>
											<?php
												asort($district_name);
												foreach(array_unique($district_name) as $cname){
													echo "<option value='".$cname."'>".$cname."</option>";
												}
											?>
											<?php if($district!=""){ ?>
												<option value="<?php if(!isset($min_price2)) { echo $district; }else{ echo "District"; } ?>" selected><?php if(!isset($min_price2)) { echo $district; }else{ echo "District"; }  ?></option>
										    <?php } ?>
											</select>
										 </div>
									  </div>
								  </div>
								  <div class="col-lg-2">
									  <div class="form-group inputwithicon" style="width: 100%;">
										 <i class="lni-menu" style="background-color: white;"></i>
										 <div class="select">
											<select id="market_name" name="market_name" required>
											<option value="Market" selected="selected">Market</option>
											<?php
												asort($market_name);
												foreach(array_unique($market_name) as $cname){
													echo "<option value='".$cname."'>".$cname."</option>";
												}
											?>
											<?php if($state!=""){ ?>
											   <option value="<?php if(!isset($min_price2)) { echo $market; }else{ echo "Market"; } ?>" selected><?php if(!isset($min_price2)) { echo $market; }else{ echo "Market"; }?></option>
										    <?php } ?>
											</select>
										 </div>
									  </div>
								  </div>
								</div>								
								<button class="btn btn-common col-lg-2 col-sm-12" type="submit" style="width: 100%;" value="submit" name="submit"><i class="lni-search"></i> Search Now</button>							  																							
						   </form>						   																																																																	
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      </header>	  
	  <?php if(isset($_GET['submit']) and $min_price1 != null){ ?>
		  <section class="login section-padding">
			   <div class="container">
				  <div class="row justify-content-center">
					 <div class="col-lg-5 col-md-12 col-xs-12">
						<div class="login-form login-area">
						   <h3>
							  DETAILS	
						   </h3>
						   <form role="form" class="login-form">
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "Maximum Price: ".$max_price; ?>" readonly>
								 </div>
							  </div>							  
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "Modal Price: ".$modal_price; ?>" readonly>
								 </div>
							  </div>
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "Minimum Price: ".$min_price1; ?>" readonly>
								 </div>
							  </div>
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "Commodity: ".$commodity; ?>" readonly>
								 </div>
							  </div>
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "Market: ".$market; ?>" readonly>
								 </div>
							  </div>
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "District: ".$district; ?>" readonly>
								 </div>
							  </div>
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "State: ".$state; ?>" readonly>
								  </div>
							  </div>							  
						   </form>
						</div>
					 </div>
					 <?php if(isset($min_price2)) { ?>
					 <div class="col-lg-5 col-md-12 col-xs-12">
						<div class="login-form login-area">
						   <h3>
							  DETAILS	
						   </h3>
						   <form role="form" class="login-form">
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "Minimum Price: ".$min_price2; ?>" readonly>
								 </div>
							  </div>							 								  
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "Modal Price: ".$modal_price2; ?>" readonly>
								 </div>
							  </div>	
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "Maximum Price: ".$max_price2; ?>" readonly>
								 </div>
							  </div>							  
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "Commodity: ".$commodity2; ?>" readonly>
								 </div>
							  </div>
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "Market: ".$market2; ?>" readonly>
								 </div>
							  </div>
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "District: ".$district2; ?>" readonly>
								 </div>
							  </div>
							  <div class="form-group">
								 <div class="input-icon">									
									<input class="form-control" style="text-align: center;" value="<?php echo "State: ".$state2; ?>" readonly>
								  </div>
							  </div>							  
						   </form>
						</div>
					 </div>
					 <?php } ?>
				  </div>
			   </div>
			</section>	  
	  <?php } else {?>
			<div class="main-container section-padding">
			<div class="container">
			<div class="row">  
			<?php if(isset($_GET['submit']) and $min_price==null){ echo "No records found"; } else { echo "Search above to see results"; }?>
			</div>
			</div>
			</div>
	  <?php }?>

	  
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