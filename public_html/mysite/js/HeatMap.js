/*
 *	Created by Rob A, Apr 2015
 */
(function($) {
	$(document).ready(function(){
		
		
		
		/*
			Add the clear button to date fields
		*/
		$(".from-date-clear").click(function(e) {
			
			e.preventDefault();
			$(".from-datepicker").val("");
		});
		
		$(".to-date-clear").click(function(e) {
			
			e.preventDefault();
			$(".to-datepicker").val("");
		});
		
		
		
		/*
			Make the clear button uncheck all the accounts
		*/
		$(".toggle-account-selection").click(function(e) {
			
			e.preventDefault();
			
			var isOn = $(".toggle-account-selection").data("toggle") !== 'false';
			$(".toggle-account-selection").data("toggle", isOn? "false" : "true");
			$(".account-check input").prop("checked", isOn);
		});
		
		
		
		
		
		/*
			Setting up the Map
		*/
		
		// Setup the map's properties
		var mapProp = {
			center: new google.maps.LatLng( 54.979187, -1.614661),
			zoom: 15,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		
		// Create the map
		var map = new google.maps.Map(document.getElementById("heatmap-map"), mapProp);
		var allHeatMessages = [];
		var allHeatPoints = [];
		var infoWindow = new google.maps.InfoWindow();
		
		
		// Loop through each bit of atm data
		$(".all-heatmap-data").children().each(function(i) {
			
			// Extract the title, cost & position
			var radius = $(this).children(".radius").text();
			var amount = parseFloat($(this).children(".amount").text());
			var lat = parseFloat($(this).children(".latitude").text());
			var lon = parseFloat($(this).children(".longitude").text());
			
			
			// Store the atm for later use
			allHeatMessages.push({
				amount: amount
			});
			
			
			// Create a marker to show the location of the ATM
			var position = new google.maps.LatLng(lat, lon);
			var marker = new google.maps.Marker({
				position: position,
				map: map,
				title: "",
			});
			
			allHeatPoints.push({
				location: position,
				weight: amount
			});
			
			
			// Listen for a click on the marker
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				
				// Format & display a message from the atm, on request
				return function() {
					var message = "<h5> Spent: &pound" + allHeatMessages[i].amount.toFixed(2) + "</h5>";
					infoWindow.setContent(message);
					infoWindow.open(map, marker);
				};
			})(marker, i));
			
		});
		
		
		
		var pointArray = new google.maps.MVCArray(allHeatPoints);
		
		
		heatmap = new google.maps.visualization.HeatmapLayer({
			data: pointArray
		});
		
		heatmap.set('radius', 0.0004);
		heatmap.set('dissipating', false);
		
		heatmap.setMap(map);
		
		
	});

})(jQuery);