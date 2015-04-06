<div class="Claim-page">
	
	
	<!-- The Overview section -->
	<div class="Claim-info-section main-section">
		
		<h2> Overview </h2>		
		
		<div class="row">
			
			<!-- The points section -->
			<div class="col-xs-7">
				
				<div class="points-table data-table">
					
					<div class="data-row last-row small-row">
						
						<div class="row">
							
							<div class="col-xs-6">
								<p> My Points: </p>
							</div>
							
							<div class="col-xs-6">
								<p class="$Top.CurrencyClass($BudgetedAmount) right"> $CurrentUser.Points </p>
							</div>
							
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
		
	
	
	<!-- Rewards section -->
	<div class="Rewards-section main-section">
		
		
		<!-- The Offers -->
		<h2> Offers </h2>
		
		<div class="data-table">
			
			<% if $Rewards.Count %>
			
				<!-- Add a row to the table for each Category in the Group -->
				<% loop $Rewards %>
					
					<div class="data-row small-row <% if Last %>last-row<% end_if %>">
						
						<div class="row">
							
							
										
							<!-- Name of the reward -->
							<div class="col-xs-3"> <p> <% if $Cost <= $Top.CurrentUser.Points %> <a href="ClaimController/TestFunction">$Title </a><% else %>$Title <% end_if %> </p></div>
							
							<!-- Description of the reward -->
							<div class="col-xs-8"> <p> $Description </p></div>
							
							<!-- Number of points needed -->

							<div class="col-xs-1"> <p class="currency-green"> $Cost </p></div>

							
						</div>
					</div>
				<% end_loop %>
				
			<% else %>
				
				<!-- Display a message if there are no offers to claim -->
				<div class="data-row small-row last-row">
					<p> No available offers </p>
				</div>
				
			<% end_if %>
		
		</div>
		
	</div>
	
</div>