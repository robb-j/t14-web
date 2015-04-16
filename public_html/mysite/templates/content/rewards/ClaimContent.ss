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
		
		
		<!-- The offers title -->
		<h2> Offers </h2>
		
		
		<!-- Display a form error if there was one -->
		<% if $ErrorMessage %>
			<div class="form-message message-fail">
				<p> $ErrorMessage </p>
			</div>
		<% end_if %>
		
		
		<!-- Display a message if it was successfuly chosen -->
		<% if $SuccessMessage  %>
			<div class="form-message message-success">
				<p> $SuccessMessage </p>
			</div>
		<% end_if %>
		
		
		<!-- A Table of the offers available -->
		<div class="data-table">
			
			<% if $Rewards.Count %>
			
				<!-- Add a row for each reward -->
				<% loop $Rewards %>
					
					
					<!-- If the chosen item, add a confirm and cancel button -->
					<% if $Top.ChooseID == $ID %>
						
						<div class="data-row small-row <% if Last %>last-row<% end_if %>">
							<div class="row">
								<div class="col-xs-3"> <p> $Title </p></div>
								<div class="col-xs-3"> <p> Are you sure? </p></div>
								<div class="col-xs-3"> <a href="rewards/claim/TakeReward?choose=$ID" class="control-button cb-green cb-small cb-no-mar"> Confirm </a></div>
								<div class="col-xs-3"> <a href="rewards/claim" class="control-button cb-white cb-small cb-no-mar"> Cancel </a></div>
							</div>
						</div> 
							
					<% else %>
					
						<!-- If a normal row, add a link to it to choose it -->
						<a href="rewards/claim?choose=$ID">
							<div class="data-row small-row <% if Last %>last-row<% end_if %>">
								<div class="row">
									<div class="col-xs-3"> <p> <% if $Cost <= $Top.CurrentUser.Points %> $Title <% else %>$Title <% end_if %> </p></div>
									<div class="col-xs-8"> <p> $Description </p></div>
									<div class="col-xs-1"> <% if $Cost <= $Top.CurrentUser.Points %> <p class="currency-green"> $Cost </p> <% else %> <p> $Cost </p> <% end_if %> </div>
								</div>
							</div>
						</a>
							
					<% end_if %>
							
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