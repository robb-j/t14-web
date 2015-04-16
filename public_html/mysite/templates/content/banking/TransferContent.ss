<div class="transfer-page">
	
	<div class="main-section">
		
		
		<!-- The title fo the page -->
		<h2> Make A Transfer </h2>
		
		<div class="transfer-content">
			
			
			<!-- A table to present the form -->
			<div class="data-table transfer-table">
				
				
				<!-- A row for the account coming from -->
				<div class="data-row">
					<div class="row">
						
						<div class="col-xs-4"> <p> From Account </p> </div>
						
						<div class="col-xs-8"> <p class="from-account"> $FromAccount.AccountType </p> </div>
						
					</div>
				</div>
				
				
				<!-- Draw the form, which finishes the table, uses templates/Includes/TransferForm.ss -->
				$BankTransferForm
				
			</div>
			
		</div>
	
	</div>
	
</div>