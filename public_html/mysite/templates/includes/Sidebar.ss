<div class="sidebar">
	
	
	<!-- A Welcom message -->
	<div class="sidebar-section">
		<div class="welcome-message">
			<h3> Hello, $CurrentUser.FirstName </h3>
			<p class="sidebar-link">
				<a href="AccountController/Logout"> Not you? Log out </a>
			</p>
		</div>
	</div>
	
	
	<!-- The section of accounts for the user -->
	<div class="sidebar-section">
		
		
		<h3> Accounts </h3>
		
		
		<div class="accounts-table">
			
			<% loop $CurrentUser.Accounts %>
				<div class="sidebar-row">
					
					<div class="row">
						<div class="col-xs-7">
							<p> $AccountType </p>
						</div>
						
						<div class="col-xs-5">
							<p class="item-right money"> $Balance </p>
						</div>
					</div>
					
				</div>
			<% end_loop %>
			
		</div>
		
		
		<p class="sidebar-link">
			<a href="banking"> My Accounts </a>
		</p>
		
	</div>
	

</div>