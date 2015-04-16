<div class="heatmap-tool">
	
	
	
	<div class="filter-form">
		<form class="banking-form" method="POST" action="HeatMapController/FilterForm" enctype="application/x-www-form-urlencoded">
			
			
			<!-- Show the error message is there is one -->
			<% if $ErrorMessage %>
				<div class="form-message message-fail">
					<p> $ErrorMessage </p>
				</div>
			<% end_if %>
			
			
			<!-- The fields of the form -->
			<div class="row">
				<div class="col-xs-5">
					<h3> Accounts </h3>
					
					<!-- Show a checkboc for each account -->
					<% loop $CurrentUser.Accounts %>
						<p class="account-check"> <input type="checkbox" name="Accounts[$Pos]" value="$ID" $Top.IsChecked($ID)  /> $Title </p>
					<% end_loop %>
					
					<!-- A button to toggle all the accounts, overridden in js/HeatMap.js -->
					<p> <a href="#" class="toggle-account-selection" data-toggle="true"> Toggle Accounts </a></p>
					
				</div>
				<div class="col-xs-4">
					
					<h3> Dates </h3>
					
					
					<!-- A date field for 'from'  -->
					<div class="input-group">
						<div class="input-group-addon">From</div>
						<input type="text" class="from-datepicker form-control" placeholder="01 Jan 2000" name="FromDate" value="$FromDate">
						<div class="input-group-addon"> <a href="#" class="from-date-clear "> x </a> </div>
					</div>
					
					
					<!-- A date field for 'to' -->
					<div class="input-group">
						<div class="input-group-addon">To</div>
						<input type="text" class="to-datepicker form-control" placeholder="$CurrentDate" name="ToDate" value="$ToDate">
						<div class="input-group-addon"> <a href="#" class="to-date-clear"> x </a> </div>
					</div>
				</div>
				
				
				<!-- The actions of the form -->
				<div class="col-xs-3">
					<div class="actions">
						<input class="control-button cb-white cb-fill cb-small" type="submit" name="action_clearFilter" value="Clear" class="action"/>
						<input class="control-button cb-light cb-fill cb-small" type="submit" name="action_filterHeatmap" value="Filter" class="action"/>
					</div>
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