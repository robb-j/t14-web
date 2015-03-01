<div class="account-page">
	
	
	<!-- The Accounts section -->
	<div class="accounts-section">
		
		
		<!-- The Heading & Transfer button -->
		<div class="row">
			
			<!-- The Heading on the left -->
			<div class="col-xs-10"> <h2> My Accounts </h2></div>
			
			<!-- The Transfer button to the right -->
			<div class="col-xs-2"><a href="banking/transfer"> Transfer </a></div>
			
		</div>
		
		
		<!-- The Table of Accounts -->
		<dvi class="account-table section">
			
			
			<!-- Loop through the user's accounts -->
			<% loop $CurrentUser.Accounts %>
			
				<div class="account-row">
					
					<!-- Make this link to the account page -->
					<a href="banking/account/$ID">
						<div class="row">
							
							<!-- The name of the Account -->
							<div class="col-xs-10">
								<div class="account-name"> $AccountType </div>
							</div>
							
							<!-- The Balance of the account on the right -->
							<div class="col-xs-2">
								<div class="account-balance"> $Balance </div>
							</div>
						</div>
					</a>
					
					
				</div>
				
			<% end_loop %>
		</div>
		
	</div>
	
	
	<!-- The New Products Section -->
	<div class="products-section">
		
		<!-- The Heading -->
		<h2> New Products </h2>
		
		<!-- The table of new products for the given user -->
		<div class="products-table section">
			
			<% loop $CurrentUser.NewProducts %>
				
				<a href="banking/product/$ID">
					$Title
				</a>
				
			<% end_loop %>
			
		</div>
	</div>
	
</div>