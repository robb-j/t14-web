<div class="sidebar">
	
	
	<!-- A Welcome message -->
	<div class="sidebar-section">
		<div class="welcome-message">
			<h3> Hello, $CurrentUser.FirstName </h3>
			<p class="sidebar-link">
				<a href="AccountController/Logout"> Not you? Log out </a>
			</p>
		</div>
	</div>
	
	
	<!-- A section for the User's Accounts -->
	<div class="sidebar-section">
		
		<h3> Accounts </h3>
		
		<div class="accounts-table">
			
			<% loop $CurrentUser.Accounts %>
				<div class="sidebar-row">
					
					<div class="row">
						<div class="col-xs-7">
							<p> <a class="link-subtle" href="banking/account/$ID"> $AccountType </a></p>
						</div>
						
						<div class="col-xs-5">
							<p class="right $MainController.CurrencyClass($Balance)"> $MainController.FormatCurrency($Balance) </p>
						</div>
					</div>
					
				</div>
			<% end_loop %>
			
		</div>
		
		<p class="sidebar-link"> <a href="banking"> My Accounts </a> </p>
	</div>
	
	
	
	<!-- A Section for the user's budget -->
	<div class="sidebar-section">
		
		<h3> Budget </h3>
		
		<div class="budget-table">
			
			<% loop $CurrentUser.Groups %>
				<div class="sidebar-row">
					
					<div class="row">
						<div class="col-xs-7">
							<p> $Title </p>
						</div>
						
						<div class="col-xs-5">
							<p class="right $Top.CurrencyClass($Balance)" > $Top.FormatCurrency($Balance) </p>
						</div>
					</div>
					
				</div>
			<% end_loop %>
			
		</div>
		
		<p class="sidebar-link"> <a href="budgeting"> My Budget </a> </p>
	</div>
	
	
	
	<!-- A Section for the user's Rewards & Points -->
	<div class="sidebar-section">
		<h3> Points & Rewards </h3>
		
		<div class="sidebar-row">
			<div class="row">
				<div class="col-xs-7"> <p> Points </p> </div>
				<div class="col-xs-5"> <p class="right currency-green"> $CurrentUser.Points </p> </div>
			</div>
		</div>
		
		<div class="sidebar-row">
			<div class="row">
				<div class="col-xs-7"> <p> Spins </p> </div>
				<div class="col-xs-5"> <p class="right"> $CurrentUser.NumberOfSpins </p> </div>
			</div>
		</div>
		
	</div>
	
	
	<!-- A Section for extra tools -->
	<div class="sidebar-section">
		<h3> Tools </h3>
		
		<p class="sidebar-link"> <a href="tools/atms"> Find An ATM </a> </p>
		<p class="sidebar-link"> <a href="tools/heatmap"> HeatMap </a> </p>
	</div>
	

</div>