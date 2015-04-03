<div class="budget-edit-page">
	
	<div class="main-section">
		
		
		<!-- The Title -->
		<h2> Edit Your Budget </h2>
		
		
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
		
		<!-- A button to add new categories -->
		<div class="row">
			<div class="col-xs-4 col-xs-offset-4">
				<a href="budgeting/edit/group/new" class="control-button cb-green"> Create Group </a>
			</div>
		</div>
		
	</div>
</div>
		