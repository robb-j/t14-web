<div class="categorise-page">
	
	<div class="main-section">
		
		
		<!-- Display the title, depending to if they have payments to categorise -->
		<% if $NewPayments %>
			<h2> Categorise Payments </h2>
		<% else %>
			<h2> No New Payments! </h2>
		<% end_if %>
		
		
		<% if $HasCategorisde %>
			<div class="form-message message-success">
				<p> You're payments were successfully categorised </p>
			</div>
		<% end_if %>
		
		<% if $HasNewSpin %>
			<div class="form-message message-success">
				<p> You've been awarded a spin! <a class="link-obvious" href="rewards/claim/"> Use it here </a> </p>
			</div>
		<% end_if %>
		
		<% if $FormError %>
			<div class="form-message message-success">
				<p> You're payments were successfully categorised </p>
			</div>
		<% end_if %>
	
		
		<form class="categorise-form" method="POST" action="CategoriseController/CategoriseForm" enctype="application/x-www-form-urlencoded">
			
			<div class="data-table transfer-table">
				
				<!-- Add the security ID for 'security' -->
				<input type="hidden" name="SecurityID" value="$SecurityID"/>
				<input type="hidden" name="UserID" value="$CurrentUser.ID"/>
				
				
				<!-- For each payments, add a row to the table -->
				<% loop $NewPayments %>
					
					<div class="data-row small-row <% if Last %> last-row <% end_if %>">
						<div class="row">
							
							<div class="col-xs-3"> <p> $Payee </p> </div>
							
							<div class="col-xs-4"> <p class="$Top.CurrencyClass($Amount)"> $Top.FormatCurrency($Amount) </p> </div>
							
							<div class="col-xs-5">
								<select class="form-control" name="categorise[$ID]">
									<option value="none" selected="selected"> Pick A Category </option>
									<% loop $Top.CurrentUser.Groups %>
										<optgroup label="$Title">
											
											<% loop $Categories %>
												<option value="$ID"> $Title </option>
											<% end_loop %>
											
										</optgroup>
									<% end_loop %>
									
								</select>
							</div>
							
						</div>
					</div>
					
				<% end_loop %>
				
			</div>
			
			<div class="form-actions">
				<input class="control-button cb-white" type="submit" name="action_cancelCategorise" value="Cancel" class="action"/>
				<input class="control-button cb-green" type="submit" name="action_submitCategorise" value="Save" class="action"/>
			</div>
			
		</form>
		
	</div>


</div>