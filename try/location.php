<!DOCTYPE html>
<html>
<head>
<style>
.mapouter{
  text-align:right;height:100%;width:100%;
}
.gmap_canvas {
  overflow:hidden;background:none!important;height:1000px;width:100%;
}
</style>
</head>
<body onload="getLocation()">
<div class="mapouter">
    <div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src=""
        frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
	</div>
</div>
  
<p>Click the button to get your coordinates.</p>

<button onclick="getLocation()">Try It</button>

<p id="demo"></p>

<script>
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);		
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  var path = "https://maps.google.com/maps?q=" + position.coords.latitude + "," + position.coords.longitude + "&t=&z=13&ie=UTF8&iwloc=&output=embed";
  document.getElementById("gmap_canvas").src = path;
  x.innerHTML = "Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude;
}
</script>

</body>
</html>
