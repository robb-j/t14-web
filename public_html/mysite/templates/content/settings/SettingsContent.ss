<div class="settings-page">
	
	<form class="banking-form" method="POST" action="SettingsController/NotificationForm" enctype="application/x-www-form-urlencoded">
		
		<input type="hidden" name="SecurityID" value="$SecurityID"/>
		
		<div class="main-section">
			
			<h2> Notifications </h2>
			
			<% if $SuccessMessage %>
				<div class="form-message message-success">
					<p> $SuccessMessage </p>
				</div>
			<% end_if %>
			
			<div class="data-table">
				
				<div class="data-row small-row">
					<p>
						<input type="checkbox" name="NewProductUpdate" <% if $CurrentUser.NewProductUpdate %> checked <% end_if %>>						
						Notify me about new products 
					</p>
				</div>
				
				<div class="data-row small-row">
					<p>
						<input type="checkbox" name="MonthlyDigest" <% if $CurrentUser.MonthlyEmail %> checked <% end_if %>>						
						Email me about my account activity every month 
					</p>
				</div>
				
				<div class="data-row small-row last-row">
					
					<div class="row">
						<div class="col-xs-2">
							<p> My Email </p>
						</div>
						<div class="col-xs-10">
							<p><input class="form-control" type="text" name="Email" placeholder="Email" value="$CurrentUser.Email"> </p>
						</div>
					</div>
					
				</div>
			</div>
			
			
			<div class="form-actions">
				<input class="control-button cb-white" type="submit" name="action_cancelForm" value="Cancel">
				<input class="control-button cb-green" type="submit" name="action_submitForm" value="Save">
			</div>
			
			
		</div>
		
	</form>
</div>