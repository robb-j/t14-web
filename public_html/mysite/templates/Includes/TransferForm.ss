<form $FormAttributes>
	
	<div class="data-row">
		<div class="row">
			
			<div class="col-xs-4"> <p> To Account </p> </div>
			
			<div class="col-xs-8"> 
				<div class="account-to-field">
					$Fields.dataFieldByName(AccountTo)
				</div>
			</div>
			
		</div>
		
	</div>
	
	<div class="data-row">
		<div class="row">
			
			<div class="col-xs-4"> <p> Amount </p> </div>
			
			<div class="col-xs-8"> 
				<div class="amount-field">
					$Fields.dataFieldByName(Amount)
				</div>
			</div>
			
		</div>
		
	</div>
	
	<div class="hidden-fields">
		$Fields.dataFieldByName(SecurityID)
		$Fields.dataFieldByName(AccountFrom)
		$Fields.dataFieldByName(UserID)
	</div>
	
	
	<% if $Message %>
		<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
		<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	
	
	<div class="data-row last-row">
		
		<div class="form-buttons">
			
			<div class="transfer-form-button">
				<% loop $Actions %>
					$Field
				<% end_loop %>
			</div>
		</div>
		
	</div>
</form>