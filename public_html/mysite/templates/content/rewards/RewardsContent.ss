<div class="rewards-page">
	
	
	<!-- The Overview section -->
	<div class="rewards-info-section main-section">
		
		<h2> Overview </h2>		
		
		<div class="row">
			
			<!-- The Info side -->
			<div class="col-xs-7">
				
				<div class="account-table data-table">
					
					<div class="data-row last-row small-row">
						
						<div class="row">
							
							<div class="col-xs-6">
								<p> Points: </p>
							</div>
							
							<div class="col-xs-6">
								<p class="$Top.CurrencyClass($BudgetedAmount) right"> $CurrentUser.Points </p>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			
			
			<!-- A empty space between the two sides -->
			<div class="col-xs-1"></div>
			
			
			<!-- The Buttons side -->
			<div class="col-xs-4">
				
				<a class="control-button cb-green" href="rewards/claim"> Claim A Reward </a>
				
				<% if $CurrentUser.NumberOfSpins %>
					<a class="control-button cb-green" href="rewards/spin"> Take A Spin ($CurrentUser.NumberOfSpins)</a>
				<% end_if %>
				
			</div>
			
		</div>
		
	</div>
		
	
	
	<!-- Add a Seciton for recent rewards -->
	<div class="recent-rewards-section main-section">
		
		
		<!-- The Title of the Group -->
		<h2> Your Recent Rewards </h2>
		
		<div class="data-table">
			
			<% if $RecentRewards.Count %>
			
				<!-- Add a row to the table for each Category in the Group -->
				<% loop $RecentRewards %>
					
					<div class="data-row small-row <% if Last %>last-row<% end_if %>">
						
						<div class="row">
							
							<!-- The Title of the Category -->
							<div class="col-xs-3"> <p class="light-text"> $Date.Nice </p> </div>
							
							
							<!-- The Balance of the Category, formatted as a currency -->
							<div class="col-xs-9"> <p> $Reward.Title </p></div>
							
						</div>
					</div>
				<% end_loop %>
				
			<% else %>
				
				<!-- Display a message if there are no rewards -->
				<div class="data-row small-row last-row">
					<p> No recent rewards, <a class="link-obvious" href="rewards/claim"> claim one here </a> </p>
				</div>
				
			<% end_if %>
		
		</div>
		
	</div>
	
	
	<!-- Add a Seciton for recent points -->
	<div class="recent-rewards-section main-section">
		
		
		<!-- The Title of the Group -->
		<h2> Your Recent Points </h2>
		
		<div class="data-table">
			
			<% if $RecentPoints.Count %>
			
				<!-- Add a row to the table for each PointGain object -->
				<% loop $RecentPoints %>
					
					<div class="data-row small-row <% if Last %>last-row<% end_if %>">
						
						<div class="row">
							
							<!-- When it happened -->
							<div class="col-xs-3"> <p class="light-text"> $Date.Nice </p> </div>
							
							
							<!-- The reason tehy got points -->
							<div class="col-xs-7"> <p> $Title </p></div>
							
							
							<!-- How many points they got -->
							<div class="col-xs-2"> <p class="currency-green"> $Points </p></div>
							
						</div>
					</div>
				<% end_loop %>
				
			<% else %>
				
				<!-- display a message if there are no points receieved -->
				<div class="data-row small-row last-row">
					<p> No recent points, earn them from budgeting and using spins </p>
				</div>
				
			<% end_if %>
		
		</div>
		
	</div>
	
</div>