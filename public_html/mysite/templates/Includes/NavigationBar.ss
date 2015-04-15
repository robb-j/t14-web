<div class="navigation-bar">
   <div class="navigation-bar-inner">
	   
		<div class="row">
			
			
			<div class="col-xs-1"> </div>
			
			
			<!-- try just make it 1 and 2 left-->
			<div class="col-xs-2">
				<div class="horse-logo">
					<p>
						<a href="banking">
							<img class="logo" src="mysite/images/logo.png" alt="Lloyd's logo" >
						</a>
					</p>
				</div>
			</div>	
		
			<div class="col-xs-9">
				
				<div id="nav-text">Lloyd's Banking Group</div>
				
				<div class="nav-links">
					<a href='banking' <% if $Current == banking %>id="current"<% end_if %>>Banking</a>
					<a href='budgeting' <% if $Current == budgeting %>id="current"<% end_if %>>Budgeting</a>
					<a href='rewards' <% if $Current == rewards %>id="current"<% end_if %>>Rewards</a>
					<a href='tools' <% if $Current == tools %>id="current"<% end_if %>>Tools</a>
					<a href='help' <% if $Current == help %>id="current"<% end_if %>>Help</a>	
					<a href='settings' <% if $Current == settings %>id="current"<% end_if %>>Settings</a>	
				</div>
			</div>

        </div>
    </div>
</div>