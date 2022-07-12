<?php
error_reporting(0);
//Check login status
session_id("session1");
session_start();
if(!isset($_SESSION[$_COOKIE["user"]]))
{
	session_write_close();
	header("location: login.php");
}else
{	
	session_id("session1");
	session_start();
	unset($_SESSION[$_COOKIE["user"]]);
	session_write_close();
	setcookie("user", "", time() - (86400 * 30 * 30), "/");
	echo"<script>
		alert('Logged out successfully');
		window.location = 'login.php';
		</script>";	
}
?>