<form $FormAttributes>
	
	$Fields.dataFieldByName(SecurityID)
	
	<div class="data-row">
		<div class="row">
			
			<div class="col-xs-4"> <p> Transfer To </p> </div>
			
			<div class="col-xs-8"> 
				$Fields.dataFieldByName(Test)
			</div>
			
		</div>
		
	</div>
	
	
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