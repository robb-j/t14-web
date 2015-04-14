<div class="heatmap-tool-page">
	
	
	
	<div class="filter-form">
		<form>
			<div class="row">
				<div class="col-xs-5">
					<p> Accounts </p>
					
					<% loop $CurrentUser.Accounts %>
						<p> <input type="checkbox" name="Accounts" value="$ID"/> $Title </p>
					<% end_loop %>
					
				</div>
				<div class="col-xs-4">
					$FromField
				</div>
				<div class="col-xs-3">
					<p> Submit </p>
				</div>
			</div>
		</form>
	</div>
	
	
	<!-- A hidden section to pass the heatPoint data to js -->
	<div class="hidden">
		<div class="all-heatmap-data">
			
			<!-- Loop each HeatPoint & put its info into the html -->
			<% loop $AllHeatPoints %>
				<div class="heat-point-$Pos">
					<div class="amount"> $Amount </div>
					<div class="latitude"> $Latitude </div>
					<div class="longitude"> $Longitude </div>
					<div class="radius"> $Radius </div>
				</div>
			<% end_loop %>
		</div>
		
	</div>
	
	
	<!-- The google map, to be filled by js -->
	<div class="googlemap" id="heatmap-map"></div>
	
</div>