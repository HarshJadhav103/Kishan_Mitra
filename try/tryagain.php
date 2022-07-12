<?php
include('array_list.php');

if(isset($_POST['submit']))
{
	$commodity = $_POST['commodity_input'];
	$district = $_POST['district_name'];
	$market = $_POST['market_name'];
	$state = $_POST['indian_all_states'];	
	$ch = curl_init();

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
			echo "Minimum Price:". $data['min_price'] ."<br>";
			echo "Modal Price:". $data['modal_price'] ."<br>";
			echo "Maximum Price:". $data['max_price'] ."<br>";			
			echo "Commodity:". $data['commodity'] ."<br>";
			echo "Market:". $data['market'] ."<br>";
			echo "District:". $data['district'] ."<br>";
			echo "State:". $data['state'] ."<br>";
			
		};
	}
	curl_close($ch);
}
?>
<html>
	<body>
		<form method="POST" action="">
			<select id="commodity_input" name="commodity_input">
			<option value="" selected="selected" disabled>Select Commodity</option>
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
			</select>
						
			<select id="indian_all_states" name="indian_all_states">
			<option value="" selected="selected" disabled>Select State</option>
			<?php
				asort($indian_all_states);
				foreach(array_unique($indian_all_states) as $cname){
					echo "<option value='".$cname."'>".$cname."</option>";
				}
			?>
			</select>
			
			<select id="district_name" name="district_name">
			<option value="" selected="selected" disabled>Select District</option>
			<?php
				asort($district_name);
				foreach(array_unique($district_name) as $cname){
					echo "<option value='".$cname."'>".$cname."</option>";
				}
			?>
			</select>

			<select id="market_name" name="market_name">
			<option value="" selected="selected" disabled>Select Market</option>
			<?php
				asort($market_name);
				foreach(array_unique($market_name) as $cname){
					echo "<option value='".$cname."'>".$cname."</option>";
				}
			?>
			</select>					
			
			<input type="submit" name="submit" value="submit">
		</form>
	</body>
</html>




