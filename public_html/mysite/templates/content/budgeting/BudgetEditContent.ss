<div class="budget-edit-page">
	
	<div class="main-section">
		
		
		<!-- The Title -->
		<h2> Edit Your Budget </h2>
		
		
		<!-- Display a form error if there was one -->
		<% if $ErrorMessage %>
			<div class="form-message message-fail">
				<p> There was an error: $ErrorMessage </p>
			</div>
		<% end_if %>
		
		
		<!-- Display a message if it was successfuly deleted -->
		<% if $SuccessMessage  %>
			<div class="form-message message-success">
				<p> $SuccessMessage </p>
			</div>
		<% end_if %>
		
		<!-- A Table for each Groups -->
		<div class="data-table">
			
			
			<!-- A Row for each of the User's Group -->
			<% loop $CurrentUser.Groups %>
				<div class="data-row <%if Last%>last-row<%end_if%>">
					<div class="row">
						
						<% if $Top.DeleteID == $ID %>
							
							<!-- If this is the one being deleted, show the confirm and cancel options -->
							<div class="col-xs-6"> <p> $Title </p> </div>
							<div class="col-xs-3"> <a href="budgeting/edit/DeleteGroup?group=$ID" class="control-button cb-red cb-small cb-no-mar"> Confirm </a></div>
							<div class="col-xs-3"> <a href="budgeting/edit" class="control-button cb-white cb-small cb-no-mar"> Cancel </a></div>
							
						<% else %>
							
							<!-- Otherwise, show just edit & delete buttons -->
							<div class="col-xs-6"> <p> $Title </p> </div>
							<div class="col-xs-3"> <a href="budgeting/edit/group/$ID" class="control-button cb-white cb-small cb-no-mar"> Edit </a></div>
							<div class="col-xs-3"> <a href="budgeting/edit?delete=$ID" class="control-button cb-red cb-small cb-no-mar"> Delete </a></div>
							
						<% end_if %>
						
					</div>
				</div>
			<% end_loop %>
			
		</div>
		
		<br/>
		
		<div class="row">
			
			<% if $Top.Reset %>
				
				<p class="centered"> This will reset the balances of your categories giving you a fresh start </p>
				
				<br/>
				
				<div class="col-xs-2 col-xs-offset-3">
					<a href="budgeting/edit" class="control-button cb-white"> Cancel </a>
				</div>
				
				<div class="col-xs-4">
					<a href="budgeting/edit/ResetBudget" class="control-button cb-green"> Reset </a>
				</div>
				
			<% else %>
				
				<div class="col-xs-4 col-xs-offset-4">
					<a href="budgeting/edit?reset" class="control-button cb-white"> Reset Budget </a>
				</div>
				
			<% end_if %>
			
		</div>
		
		<div class="row">
			
			<!-- A button to go back -->
			<div class="col-xs-3 col-xs-offset-3">
				<a href="budgeting/" class="control-button cb-white"> Back </a>
			</div>
			
			
			<!-- A button to create a group -->
			<div class="col-xs-3">
				<a href="budgeting/edit/group/new" class="control-button cb-green"> Create Group </a>
			</div>
		</div>
		
	</div>
</div>
		