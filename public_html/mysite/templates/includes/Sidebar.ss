<div class="sidebar-outer">
	
	
	
	<!-- A Welcom message -->
	<div class="sidebar-section">
		<div class="welcome-message">
			<p> Hello, $CurrentUser.FirstName </p>
		</div>
	</div>
	
	
	<!-- The section of accounts for the user -->
	<div class="sidebar-section">
		
		
		<h3> My Accounts </h3>
		
		
		<div class="accounts-table">
			
			<% loop $CurrentUser.Accounts %>
				<div class="account-row">
					
					<div class="row">
						<div class="col-xs-8">
							<p> $AccountType </p>
						</div>
						
						<div class="col-xs-4">
							<p> $Balance </p>
						</div>
					</div>
					
				</div>
			<% end_loop %>
			
		</div>
		
	</div>
	
	
</div>