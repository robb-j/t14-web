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
			
				<a href="banking" class="<% if $Current == 'banking' %>current<% end_if %>">Banking</a>
				<a href='budgeting'>Budgeting</a>
				<a href='rewards'>Rewards</a>
				<a href='tools'>Tools</a>
				<a href='settings'>Settings</a>
				
			</div>
			<div class="col-xs-3">
			<p><% if $Current == banking %>current<% end_if %></p>
			</div>

        </div>
    </div>
</div>