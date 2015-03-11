  <div class="navigation-bar">
   <div class="navigation-bar-inner">
		<div class="row">
			<div class="col-xs-1">
			</div>
			<!-- try just make it 1 and 2 left-->
			<div class="col-xs-2" id="logo">
				<a href="#"><img src="mysite/images/logo.png"   
				alt="Lloyd's logo" ></a>
			</div>	
		
			<div class="col-xs-6" id="links">
			<div id="nav-text">Lloyd's Banking Group</div>
			
				<a href='banking' <% if $Current == banking %>id="current"<% end_if %>>Banking</a>
				<a href='budgeting' <% if $Current == budgeting %>id="current"<% end_if %>>Budgeting</a>
				<a href='rewards' <% if $Current == rewards %>id="current"<% end_if %>>Rewards</a>
				<a href='tools' <% if $Current == tools %>id="current"<% end_if %>>Tools</a>
				<a href='settings' <% if $Current == settings %>id="current"<% end_if %>>Settings</a>
				
			</div>
			<div class="col-xs-3"></div>

        </div>
    </div>
</div>