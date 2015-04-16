<div class="account-page">
	
	
	<!-- The Accounts section -->
	<div class="accounts-section main-section">
		
		<h2> My Accounts </h2>
		
		<!-- The Table of Accounts -->
		<div class="account-table data-table">
			
			
			<!-- Loop through the user's accounts -->
			<% loop $CurrentUser.Accounts %>
			
				<div class="account-row data-row <% if Last %>last-row<% end_if %>">
					
					<!-- Make this link to the account page -->
					<a href="banking/account/$ID">
						<div class="row">
							
							<!-- The name of the Account -->
							<div class="col-xs-8">
								<div class="account-name"><p> $AccountType </p></div>
							</div>
							
							<!-- The Balance of the account on the right -->
							<div class="col-xs-4">
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
				
				<a href="banking/product/$ID">
					<div class="data-row <% if Last %>last-row<% end_if %>">				
						
						<div class="row">
							<div class="col-xs-12">
								<p> $Title </p>
							</div>
						</div>
					</div>
				</a>
				
				
			<% end_loop %>
			
			
		</div>
	</div>
	
</div>