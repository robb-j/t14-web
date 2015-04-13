<div class="account-page">
	
	
	<!-- A hidden section to pass the atm data to js -->
	<div class="hidden">
		<div class="all-atm-data">
			
			<!-- Loop each ATM & put its info into the html -->
			<% loop $AllAtms %>
				<div class="atm-item-$Pos">
					<div class="title"> $Title </div>
					<div class="cost"> $Cost </div>
					<div class="latitude"> $Latitude </div>
					<div class="longitude"> $Longitude </div>
				</div>
			<% end_loop %>
		</div>
		
	</div>
	
	
	<!-- The google map, to be filled by js -->
	<div class="googlemap" id="atm-map"></div>
	
</div>