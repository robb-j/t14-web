<div class="account-page">
	
	
	<!-- The Accounts Detail section -->
	<div class="accounts-section main-section">
		
		
		<!-- The Heading -->
		<div class="row">
			
			<!-- The Heading on the left -->
			<div class="col-xs-9"> <h2> INFORMATION </h2></div>
			
		</div>
		
		
		<!-- The Table of Accounts -->
		<div class="account-table data-table">
			
			
			<!-- Loop through the user's accounts -->
			<% loop $CurrentUser.Accounts %>
			
				<div class="account-row data-row <% if Last %>last-row<% end_if %>">
					
						<div class="row">
							
							<!-- The name of the Account -->
							<div class="col-xs-06">
								<div class="accountdetail-name"><p> $AccountType</p></div>
							</div>
							
							<!-- Information of the account-->
							<div class="col-xs-03">
								<div class="accountdetail-information"> <p> Balance </p> <p> Overdraft </p> <p> Available </p> </div>
							</div>
							
							<!-- Information of the account-->
							<div class="col-xs-03">
								<div class="accountdetail-balance"><p> $Balance </p></div>
							</div>
						</div>
					
					
				</div>
				
			<% end_loop %>
		</div>
		
	</div>
	
	
	<!-- The New Products Section -->
	<div class="products-section main-section">
		
		<!-- The Heading -->
		<h2> TRANSACTIONS </h2>
		
	</div>
	
</div>