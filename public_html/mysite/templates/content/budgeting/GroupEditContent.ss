<div class="group-edit-page">
	
	<div class="main-section">
		
		
		<!-- Display the title depending on the context -->
		<% if $Mode == edit %>
			<h2> Edit Group: $Group.Title </h2>
		<% else %>
			<h2> New Group </h2>
		<% end_if %>
		
		
		<% if $ErrorMessage %>
			<div class="form-message message-fail">
				<p> $ErrorMessage </p>
			</div>
		<% end_if %>
		
		<% if $SuccessMessage %>
			<div class="form-message message-success">
				<p> $SuccessMessage </p>
			</div>
		<% end_if %>
		
		
		<!-- The form to submit the data -->
		<form class="banking-form group-edit-form" method="POST" action="GroupEditController/GroupEditForm" enctype="application/x-www-form-urlencoded">
			
			
			<!-- Hidden values to get info back to the controller -->
			<input type="hidden" name="SecurityID" value="$SecurityID"/>
			<input type="hidden" name="UserID" value="$Top.CurrentUser.ID"/>
			<input type="hidden" name="GroupID" value="$Group.ID"/>
			<input type="hidden" name="Mode" value="$Mode"/>
			
			
			<!-- The table of data, hide seperators to meak smoother when adding/removing rows -->
			<div class="data-table no-separators">
				
				<div class="data-row small-row">
					<div class="row">
						<div class="col-xs-3">
							<p> Group Name </p>
						</div>
						
						<div class="col-xs-9">
							<input class="form-control" type="text" name="GroupName" value="$Group.Title" placeholder="Group Name" />
						</div>
					</div>
				</div>
				
				
				<!-- For each existing category, add a row to the table -->
				<% if $Mode = edit %>
					<% loop $Group.Categories %>
						<div class="data-row small-row <% if Last %>last-row<% end_if %>">
							<div class="row">
								
								<!-- The Name Field-->
								<div class="col-xs-7">
									<input class="form-control" name="CategoryNames[$ID]" value="$Title"/>
								</div>
								
								
								<!-- The Budget Field -->
								<div class="col-xs-3">
									<div class="input-group">
										<div class="input-group-addon">£</div>
										<input class="form-control" name="CategoryBudgets[$ID]" value="$Balance"/>
									</div>
								</div>
								
								
								<!-- A Button to delete this Category -->
								<div class="col-xs-2">
									<a href="#" data-category="$ID" data-type="existing" class="category-delete control-button cb-small cb-no-mar cb-red"> X </a>
								</div>
								
							</div>
						</div>	
					<% end_loop %>
				<% end_if %>
				
				
				<!-- Holders for js insererted html -->
				<div class="inserted-categories"></div>
				<div class="removed-categories"></div>
				
			</div>
			
			
			<!-- A button to add new categories -->
			<div class="row">
				<div class="col-xs-4 col-xs-offset-4">
					<a href="#" class="add-category control-button cb-green cb-small"> Add Category </a>
				</div>
			</div>
			
			
			<!-- The action buttons for the form -->
			<div class="form-actions">
				<input class="control-button cb-white" type="submit" name="action_cancelEdit" value="Cancel"/>
				<input class="control-button cb-green" type="submit" name="action_submitEdit" value="Save"/>
			</div>
			
		</form>
	</div>
</div>