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

//get chats
if($_GET['chat'] != null)
{
	$ad_id = $_GET['chat'];
}else
{
	$ad_id = $_POST['chat'];
}
//find current user id
$query = "select * from users where email = '".$_COOKIE['user']."'";
$fire = mysqli_query($conn, $query);
$thisuser = mysqli_fetch_array($fire);

if($_GET['seller'] != $thisuser['id'] and $_GET['buyer'] != $thisuser['id'])
{
	echo "<script>alert('You can not see this chat'); window.history.go(-1);</script>";
}

//find ad details
$query="select * from ads where id = '".$ad_id."'";		
$result=mysqli_query($conn,$query);
$result_data = mysqli_fetch_array($result);

if(isset($_GET['seller']) and $_GET['seller']==$thisuser['id'] and isset($_GET['buyer']) and $_GET['buyer']!=$thisuser['id'])
{		
	$query="select * from users where id = '".$_GET['buyer']."'";		
	$result=mysqli_query($conn,$query);
	$buyerdata = mysqli_fetch_array($result);		
	$seller = $_COOKIE['user'];		
	$buyer = $buyerdata['email'];	
}else{			
	$seller = $result_data['user_id'];
	$buyer = $_COOKIE['user'];
}

$query = "select * from chat where ad_id = '$ad_id' and (( user_to = '".$seller."' and user_from = '".$buyer."') or ( user_to = '".$buyer."' and user_from = '".$seller."' )) order by id ASC";				
$chat_result = mysqli_query($conn, $query);	

$query = "select * from users where id = '".$_GET['seller']."'";	
$sellerdata = mysqli_query($conn, $query);
$sellerinfo = mysqli_fetch_array($sellerdata);

$query = "select * from users where id = '".$_GET['buyer']."'";	
$buyerdata = mysqli_query($conn, $query);
$buyerinfo = mysqli_fetch_array($buyerdata);
	
if($seller == $_COOKIE['user'])
{		
	$myimage = $sellerinfo['profile_picture'];				
	$othersimage = $buyerinfo['profile_picture'];
	$userto = $buyerinfo['email'];		
}else
{
	$myimage = $buyerinfo['profile_picture'];
	$othersimage = $sellerinfo['profile_picture'];
	$userto = $sellerinfo['email'];		
}




if(isset($_POST["submit"]))
{
	$message=$_POST['message'];		
	if($message == null)
	{
		echo "<script>alert('Message can not be empty');</script>";
	}else
	{
		$ad_id = $_POST['chat'];
		$user_from = $_COOKIE['user'];			
		$user_to = $_POST['userto'];	
				
		$query="select * from chat where ad_id = '".$ad_id."' and (user_from = '".$_COOKIE['user']."' or user_to = '".$_COOKIE['user']."')";						
		$result=mysqli_query($conn,$query);
		$result_row = mysqli_num_rows($result);		
		$start = $result_row;		
		
		if($start <= 0)
		{
			$query = "select * from ads where id = '".$ad_id."'";			
			$execute = mysqli_query($conn, $query);
			$final = mysqli_fetch_array($execute);
			$user_to = $final['user_id'];
			
			date_default_timezone_set("Asia/Kolkata");
			$datetime = date("d-m-Y").", ".date("h:i A");
			
			$query="Insert into chat (ad_id,user_from,user_to,message,datetime, start_point) values('".$ad_id."','".$user_from."','".$user_to."','".$message."','".$datetime."', '1')";						
			$insert=mysqli_query($conn,$query);
			if($insert)
			{
				echo "<script>window.history.go(-1);</script>";
			}
		}else{
			date_default_timezone_set("Asia/Kolkata");
			$datetime = date("d-m-Y").", ".date("h:i A");
			
			$query="Insert into chat (ad_id,user_from,user_to,message,datetime) values('".$ad_id."','".$user_from."','".$user_to."','".$message."','".$datetime."')";								
			$insert=mysqli_query($conn,$query);
			if($insert)
			{
				echo "<script>window.history.go(-1);</script>";
			}
		}			
	}		
}		

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <?php include("head.php"); ?>
   </head>
   <body onload="clearchat()">
      <?php include("navbar.php"); ?>
      </header>
      <div class="page-header" style="background: url(assets/img/banner1.jpg); padding: 90px 0 10px;">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="breadcrumb-wrapper">
                     <h2 class="product-title"><?php echo $result_data['title']." by ".$sellerinfo['firstname']." ".$sellerinfo['lastname']; ?></h2>
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
                           <div class="dashboard-wrapper">                                                               
								<form class="row offers-messages" method="post" action="" id="form">
									 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="chat-message-box" style="width: 100%;">
										   <div class="dashboardboxtitle">
											  <h2>Chat Messages</h2>
										   </div> 
										<?php while($chat = mysqli_fetch_assoc($chat_result)){
												if($chat['user_from']==$_COOKIE['user'])
												{
										?>
										   <div class="memessage readmessage">
											  <figure>
												 <img src="<?php echo $myimage; ?>" alt="">
											  </figure>
											  <div class="description">                                             
												 <div class="text-right">													
													<p><?php echo $chat['message']; ?></p>
													<div class="date"><?php echo $chat['datetime']; ?></div>
												 </div>
											  </div>
										   </div>
												<?php }else{?>
										   <div class="memessage readmessage">
											  <figure style="float: left; left: 0;">
												 <img src="<?php echo $othersimage; ?>" alt="">
											  </figure>
											  <div class="description" style="margin-left: 0px;">                                             
												 <div class="text-left">													
													<p><?php echo $chat['message']; ?></p>
													<div class="date"><?php echo $chat['datetime']; ?></div>
												 </div>
											  </div>
										   </div> 
												<?php }
												} ?>
										</div>
										<div class="replay-box">
										   <textarea class="form-control" name="message" id="message" placeholder="Type Here & Press Enter" required></textarea>                                       
										</div>									
										<div class="icon-box">
											  <input type="hidden" name="chat" value="<?php echo $_GET['chat']; ?>">
											<input type="hidden" name="userto" value="<?php echo $userto; ?>">											  
											  <button class="btn btn-common" style="float: right; margin-top: 10px;" value="submit" name="submit" onclick="messagesubmit()">SEND</button>
									   </div>
									 </div>  									
								</form>								 
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
	  <script>					
		var interval = setInterval(function() {
		if(document.readyState === 'complete') {
		clearInterval(interval);
		init();
		}    
		}, 100);
		function init()
		{
			$(document).scrollTop($(document).height());
			document.getElementById("message").value = "";
			let bannerNode = document.querySelector('[alt="www.000webhost.com"]').parentNode.parentNode;
			bannerNode.parentNode.removeChild(bannerNode);
		}
	  </script>			
	  <script>				
			function messagesubmit()
			{
				document.getElementById("submit").value = "submit";				
				document.getElementById("form").submit();
			}
	  </script>
   </body>
</html>