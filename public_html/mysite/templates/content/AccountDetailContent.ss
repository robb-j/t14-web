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
			
				<div class="account-detail">
					
						<div class="row">
							
							<!-- The name of the Account -->
							<div class="col-xs-6">
								<div class="accountdetail-name"><p> $Account.AccountType </p></div>
							</div>
							
							<!-- Information of the account-->
							<div class="col-xs-3">
								<div class="accountdetail-information"> <p> Balance </p> <p> Overdraft </p> <p> Available </p> </div>
							</div>
							
							<script>
								document.getElementById("Available").innerHTML = $Account.Balance + $Account.OverdraftLimit;
							</script>
							
							<!-- Full details of balance of account-->
							<div class="col-xs-3">
								<div class="accountdetail-balance"> <p> $Account.Balance </p> <p> $Account.OverdraftLimit </p> <p id="Available"></p> </div>
							</div>
							
						</div>
					
				</div>
				
		</div>
		
	</div>
	
	
	<!-- The New Products Section -->
	<div class="products-section main-section">
		
		<!-- The Heading -->
		<h2> TRANSACTIONS </h2>
		
	</div>
	
</div>