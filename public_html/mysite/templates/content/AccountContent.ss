<div class="account-page">
	
	
	<!-- The Accounts section -->
	<div class="accounts-section main-section">
		
		
		<!-- The Heading & Transfer button -->
		<div class="row">
			
			<!-- The Heading on the left -->
			<div class="col-xs-9"> <h2> My Accounts </h2></div>
			
		</div>
		
		
		<!-- The Table of Accounts -->
		<div class="account-table data-table">
			
			
			<!-- Loop through the user's accounts -->
			<% loop $CurrentUser.Accounts %>
			
				<div class="account-row data-row <% if Last %>last-row<% end_if %>">
					
					<!-- Make this link to the account page -->
					<a href="banking/account/$ID">
						<div class="row">
							
							<!-- The name of the Account -->
							<div class="col-xs-9">
								<div class="account-name"><p> $AccountType </p></div>
							</div>
							
							<!-- The Balance of the account on the right -->
							<div class="col-xs-3">
								<div class="account-balance"><p class="$Top.CurrencyClass($Balance) right"> $Top.FormatCurrency($Balance) </p></div>
							</div>
						</div>
					</a>
					
					
				</div>
				
			<% end_loop %>
		</div>
		
	</div>
	
	
	<!-- The New Products Section -->
	<div class="products-section main-section">
		
		<!-- The Heading -->
		<h2> New Products </h2>
		
		<!-- The table of new products for the given user -->
		<div class="products-table data-table">
			
			<% loop $NewProducts %>
				
				<div class="data-row <% if Last %>last-row<% end_if %>">
					
					<a href="banking/product/$ID">
						
						<p> $Title </p>
					</a>
					
				</div>
				
				
			<% end_loop %>
			
			
		</div>
	</div>
	
</div>