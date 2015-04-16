<!doctype html>
<head>
	
	$MetaTags('false')
	
	<% base_tag %>
	
	<title> $SiteConfig.Title </title>
	
	<% require css("mysite/css/theme.css") %>
	<% require css("mysite/css/form.css") %>
	<% require css("mysite/css/libs/bootstrap.min.css") %>
	
</head>



<body>
	<input id="production-mode" type="hidden" value="$SiteConfig.ProductionMode"/>	
	
	<div class="page-container">
		
		
		<!-- Display the login form if needed -->
		<% if Form %>
		
			<% include AdminLogin Form=$Form %>
		
		
		<!-- Othwise, render the page normally -->
		<% else %>
			
			<!-- Add the navigation bar, using TabTitle form the controller -->
			<% include NavigationBar Current=$TabTitle%>
			
			
			<!-- The main part of the side, using a bootstrap container http://getbootstrap.com/css/#overview-container -->
			<div class="main-container-outer">
				<div class="container">
					<div class="main-container">
						<div class="row no-gutter">
							
							
							<!-- Show the sidebar on the left -->
							<div class="col-xs-3">
								<div class="sidebar-container">
									<% include Sidebar CurrentUser=$CurrentUser, MainController=$Top %>
								</div>
							</div>
							
							
							<!-- Show the content on the right -->
							<div class="col-xs-9">
								<div class="content-container">
									
									<!-- Draw the content of the page, BankController subclasses override to present their page -->
									$Content()
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
			
		<% end_if %>
		
	</div>
</body>
</html>
