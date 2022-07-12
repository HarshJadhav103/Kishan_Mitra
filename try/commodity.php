<?php
$ch = curl_init();

$url = "https://api.data.gov.in/resource/9ef84268-d588-465a-a308-a864a43d0070?api-key=579b464db66ec23bdd00000143935365cb0043b9664912f40378b98b&format=json&offset=0&limit=1&filters[state]=Gujarat&filters[district]=Rajkot";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec($ch);

if($e = curl_error($ch))
{
	echo $e;
}else
{
	$decoded = json_decode($resp, true);
	print_r($decoded);
}
curl_close($ch);
?>






