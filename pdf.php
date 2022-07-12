<?php
if(isset($_GET['file']))
{
	$file = $_GET['file'];
}
?>
<html>
<body>
<embed type="application/pdf" src="<?php echo $file; ?>" width="100%" height="100%">
</body>
</html>