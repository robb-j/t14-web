<div class="account-page">
	
	
	<!-- The Accounts Detail section -->
	<div class="accounts-section main-section">
		
		
		<!-- The Heading -->
		<div
		class="row">
			
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
								<div class="accountdetail-name"><p > $Account.AccountType </p></div>
							</div>
							
							<!-- Information of the account-->
							<div class="col-xs-3">
								<div class="accountdetail-information"> <p> Balance </p> <p> Overdraft </p> <p> Available </p> </div>
							</div>
							
							<!-- Full details of balance of account-->
							<div class="col-xs-3">
								<div class="accountdetail-balance"> 
								<p class="$CurrencyClass($Account.Balance)"> $Account.Balance </p> 
								<p class="$CurrencyClass($Account.OverdraftLimit)"> $Account.OverdraftLimit </p> 
								<p class="$CurrencyClass($AvailableBalance)"> $AvailableBalance </p> 
								</div>
							</div>
							
						</div>
					
				</div>
				
		</div>
		
	</div>
	
	<!-- The Transactions Section -->
	<div class="accountdetailtransactions-section main-section">
		
		<!-- The Heading -->
		<h2> TRANSACTIONS </h2>
		
		<!-- The Drop Down Bar -->
		<div class="dropdown">
		<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
			Select a statement
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			<% loop $Account.Transactions %>
				<div class="transaction-dropdownMenu data-row <% if Last %>last-row<% end_if %>">
				<li role="presentation"><a role="menuitem" tabindex="-1" href="banking/account/{$Top.Account.ID}/{$Date.Format(n)}/{$Date.Format(y)}"> $Date.Long </a></li>
				</div>
			<% end_loop %>
		</ul>
		</div>

		<!-- The List of Transactions -->
		<div class="transaction-table data-table">

			<!-- Loop through the account's transactions -->

			<% loop $FilteredTransactions %>

				<div class="transaction-row data-row <% if Last %>last-row<% end_if %>">

					<div class="row">
						
						<!-- The date of the transaction on the left -->
						<div class="col-xs-4">
							<div class="transaction-date"><p> $Date.Long </p></div>
						</div>
							
						<!-- The payee in the middle, aligned to the left -->
						<div class="col-xs-6">
							<div class="transaction-payee"><p> $Payee </p></div>
						</div>
					
						<!-- The amount on the right -->
						<div class="col-xs-2">
						<div class="transaction-amount"><p class="$Top.CurrencyClass($Amount)"> $Amount </p></div>
						</div>
						
					</div>
							
				</div>
			<% end_loop %>
			
		</div>
	</div>

</div>