/*
 *	Created by Rob A, Apr 2015
 */
(function($) {
	$(document).ready(function(){
		
		
		// Setup the map's properties
		var mapProp = {
			center: new google.maps.LatLng(54.979187, -1.614661),
			zoom: 12,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		
		// Create the map
		var map = new google.maps.Map(document.getElementById("atm-map"), mapProp);
		var allAtms = [];
		var infoWindow = new google.maps.InfoWindow();
		
		
		// Loop through each bit of atm data
		$(".all-atm-data").children().each(function(i) {
			
			// Extract the title, cost & position
			var title = $(this).children(".title").text();
			var cost = parseFloat($(this).children(".cost").text());
			var lat = parseFloat($(this).children(".latitude").text());
			var lon = parseFloat($(this).children(".longitude").text());
			
			
			// Store the atm for later use
			allAtms.push({
				title: title,
				cost: cost,
				lat: lat,
				lon: lon
			});
			
			
			// Create a marker to show the location of the ATM
			var position = new google.maps.LatLng(lat, lon);
			var marker = new google.maps.Marker({
				position: position,
				map: map,
				title: title,
			});
			
			
			// Listen for a click on the marker
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				
				// Format & display a message from the atm, on request
				return function() {
					
					var message = "<h3>" + allAtms[i].title + "</h3><p> Cost: Free </p>";
					
					if (allAtms[i].cost > 0) {
						message = "<h3>" + allAtms[i].title + "</h3><p> Cost: &pound" + allAtms[i].cost.toFixed(2) + "</p>";
					}
					
					infoWindow.setContent(message);
					infoWindow.open(map, marker);
				};
			})(marker, i));
		});
		
	});

})(jQuery);