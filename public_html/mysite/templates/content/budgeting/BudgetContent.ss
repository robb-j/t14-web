<div class="budget-page">
	
	
	<!-- The Overview section -->
	<div class="budget-info-section main-section">
		
		<h2> Overview </h2>		
		
		<div class="row">
			
			<!-- The Info side -->
			<div class="col-xs-7">
				
				<div class="account-table data-table">
					
					<div class="data-row small-row">
						<div class="row">
							<div class="col-xs-6"> <p> Budgeted: </p> </div>
							<div class="col-xs-6"> <p class="currency-green right"> $Top.FormatCurrency($BudgetedAmount) </p> </div>
						</div>
					</div>
					
					<div class="data-row small-row">
						<div class="row">
							<div class="col-xs-6"> <p> Total Spent: </p> </div>
							<div class="col-xs-6"> <p class="currency-red right"> $Top.FormatCurrency($BudgetSpent) </p> </div>
						</div>
					</div>
					
					<div class="data-row last-row small-row">
						<div class="row">
							<div class="col-xs-6"> <p> Remaining: </p> </div>
							<div class="col-xs-6"> <p class="$Top.CurrencyClass($BudgetLeft) right"> $Top.FormatCurrency($BudgetLeft) </p> </div>
						</div>
					</div>
				</div>
			</div>
			
			
			<!-- A empty space between the two sides -->
			<div class="col-xs-1"></div>
			
			
			<!-- The Buttons side -->
			<div class="col-xs-4">
				
				<% if $NumNewPayments %>
					<a class="control-button cb-green cb-top" href="budgeting/categorise"> New Payments ($NumNewPayments) </a>
				<% end_if %>
				
				<a class="control-button cb-light cb-top" href="budgeting/edit"> Edit Budget </a>
				
			</div>
			
		</div>
		
	</div>
		
	
	
	<!-- Add a Seciton & Table for each Budgrt Group -->
	<% loop $CurrentUser.Groups %>
		
		<div class="group-section main-section">
			
			
			<!-- The Title of the Group -->
			<h2> $Title </h2>
			
			<div class="group-table data-table">
				
				
				<!-- If there are categories, add a header -->
				<% if $Categories.count %>
					
					<div class="data-row header-row">
						<div class="row">
							
							<!-- Add headings to the table -->
							<div class="col-xs-6"> <p > Category </p> </div>
							<div class="col-xs-3"> <p class="right"> Budgeted </p> </div>
							<div class="col-xs-3"> <p class="right"> Remaining </p> </div>
							
						</div>
					</div>
				<% end_if %>
				
				
				<!-- Add a row to the table for each Category in the Group -->
				<% loop $Categories %>
					
					<div class="category-row data-row small-row <% if Last %>last-row<% end_if %>">
						
						<div class="row">
							
							<!-- The Title of the Category -->
							<div class="col-xs-6"> <p> $Title </p> </div>
							
							
							<!-- The Budget for the Category, formatted as a currency -->
							<div class="col-xs-3"> <p class="$Top.CurrencyClass($Budgeted) right"> $Top.FormatCurrency($Budgeted) </p></div>
							
							
							<!-- The Balance for the Category, formatted as a currency -->
							<div class="col-xs-3"> <p class="$Top.CurrencyClass($Remaining) right"> $Top.FormatCurrency($Remaining) </p></div>
							
						</div>
						
					</div>
					
				<% end_loop %>
			
			</div>
			
		</div>
		
	<% end_loop %>
	
</div>