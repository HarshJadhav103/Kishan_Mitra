var placeSearch, autocomplete;
      var componentForm = {               
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name',        
      };
	  
	  function getLocation() {
		  if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);		
		  }
		}

		function showPosition(position) {
		  var path = "https://maps.google.com/maps?q=" + position.coords.latitude + "," + position.coords.longitude + "&t=&z=13&ie=UTF8&iwloc=&output=embed";
		  document.getElementById("gmap_canvas").src = path;
			document.getElementById("map").style.display = "block";
			document.getElementById('location_label').innerHTML = 'Use Current Address OR Search Below';
			const latlng = {
			lat: position.coords.latitude,
			lng: position.coords.longitude,
		  };  
		  document.getElementById('lat').value = position.coords.latitude;
		    document.getElementById('long').value = position.coords.longitude;
		  const geocoder = new google.maps.Geocoder();
		  geocoder
			.geocode({ location: latlng })
			.then((response) => {
			  if (response.results[0]) {				
				const marker = new google.maps.Marker({
				  position: latlng,				  
				});																		
					// Get each component of the address from the place details
					// and fill the corresponding field on the form.
					for (var i = 0; i < response.results[1].address_components.length; i++) {
					  var addressType = response.results[1].address_components[i].types[0];
					  if (componentForm[addressType]) {
						var val = response.results[1].address_components[i][componentForm[addressType]];
						document.getElementById(addressType).value = val;			
					  }
					}
			  } else {
				window.alert("No results found");
			  }
			})
		}

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
 console.log(place.geometry.location);
		  console.log(place.geometry.location.lat());
		  console.log(place.geometry.location.lng());
		    document.getElementById('lat').value = place.geometry.location.lat();
		    document.getElementById('long').value = place.geometry.location.lng();        
			var path = "https://maps.google.com/maps?q=" + place.geometry.location.lat() + "," + place.geometry.location.lng() + "&t=&z=13&ie=UTF8&iwloc=&output=embed";
		    document.getElementById("gmap_canvas").src = path;
			document.getElementById("map").style.display = "block";
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;			
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }