<div class="account-page">
	
	
	<!-- The Accounts Detail section -->
	<div class="accounts-section main-section">
		
		
		<!-- The Heading -->
		<div class="row">
			
			<!-- The Heading on the left -->
			<div class="col-xs-9"> <h2> Information </h2></div>
			
			
			<!-- Add a transfer button -->
			<div class="col-xs-3">
				<div class="light-button"> <a href="banking/transfer/$Account.ID"> Transfer </a> </div>
			</div>
			
		</div>
		
		<!-- The Table of Accounts -->
		<div class="accountdetail-table data-table">
			
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
							
							<!-- Full details of balance of account-->
							<div class="col-xs-3">
								<div class="accountdetail-balance"> <p> $Account.Balance </p> <p> $Account.OverdraftLimit </p> <p id="Available"></p> </div>
							</div>
							
							<script>
								document.getElementById("Available").innerHTML = $Account.Balance + $Account.OverdraftLimit;
							</script>
							
						</div>
					
				</div>
				
		</div>
		
	</div>
	
	<!-- The Transactions Section -->
	<div class="accountdetailtransactions-section main-section">
		
		<!-- The Heading -->
		<h2> TRANSACTIONS $MyFuction() </h2>
		
		<!-- The Drop Down Bar -->
		<div class="dropdown">
		<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
			Select a statement
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something here</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
		</ul>
		</div>
	
		<!-- The List of Transactions -->
		<div class="transaction-table data-table">
			
			
			<!-- Loop through the account's transactions -->
			<% loop $Account.Transactions %>
			
				<div class="transaction-row data-row <% if Last %>last-row<% end_if %>">
					
					<div class="row">
							
						<!-- The date of the transaction on the left -->
						<div class="col-xs-4">
							<div class="transaction-date"><p> $Date </p></div>
						</div>
							
						<!-- The payee in the middle, aligned to the left -->
						<div class="col-xs-6">
							<div class="transaction-payee"><p> $Payee </p></div>
						</div>
					
						<!-- The amount on the right -->
						<div class="col-xs-2">
							<div class="transaction-amount"><p id="changetogreen"> $Amount </p></div>
						</div>
						
						<script>
						if ($Amount > 0) {
							var balance = document.getElementById("changetogreen");
							balance.style.color = 'green';
						}
						</script>
						
					</div>
							
				</div>
				
			<% end_loop %>
		</div>
	</div>

</div>