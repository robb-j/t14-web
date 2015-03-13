<form $FormAttributes>
	
	<div class="data-row">
		<div class="row">
			
			<div class="col-xs-4"> <p> To Account </p> </div>
			
			<div class="col-xs-8"> 
				$Fields.dataFieldByName(AccountTo)
			</div>
			
		</div>
		
	</div>
	
	<div class="data-row">
		<div class="row">
			
			<div class="col-xs-4"> <p> Amount </p> </div>
			
			<div class="col-xs-8"> 
				$Fields.dataFieldByName(Amount)
			</div>
			
		</div>
		
	</div>
	
	
	$Fields.dataFieldByName(SecurityID)
	$Fields.dataFieldByName(AccountFrom)
	$Fields.dataFieldByName(UserID)
	
	
	<% if $Message %>
		<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
		<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	
	
	<div class="data-row last-row">
		
		<% loop $Actions %> $Field <% end_loop %>
		
		
		<a href="banking/account/$FromAccount.ID" />
		
	</div>
</form>