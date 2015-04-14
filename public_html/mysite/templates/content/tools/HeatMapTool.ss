<div class="account-page">
	
	
	<!-- A hidden section to pass the heatPoint data to js -->
	<div class="hidden">
		<div class="all-heatMap-data">
			
			<!-- Loop each HeatPoint & put its info into the html -->
			<% loop $AllHeatPoints %>
				<div class="heatPoint-item-$Pos">
					<div class="amount"> $ </div>
					<div class="latitude"> $ </div>
					<div class="longitude"> $ </div>
				</div>
			<% end_loop %>
		</div>
		
	</div>
	
	
	<!-- The google map, to be filled by js -->
	<div class="googlemap" id="heatPoint-map"></div>
	
</div>