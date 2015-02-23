<!doctype html>
<head>
	
	$MetaTags('false')
	
	<% base_tag %>
	
	<title> $Title </title>
	
	<% require css("mysite/css/screen.css") %>
	<% require css("mysite/css/form.css") %>
	<% require css("mysite/css/libs/bootstrap.min.css") %>
	
</head>



<body>
	<input id="production-mode" type="hidden" value="$SiteConfig.ProductionMode"/>	
	
	<div class="page-container">
		
		
		<!-- Display the login form if needed -->
		<% if Form %>
		
			<% include AdminLogin Form=$Form %>
			
		<% else %>
			
			<% include NavigationBar %>
			
			<div class="container">
				<div class="row">
					
					<div class="col-xs-3">
						
						<% include Sidebar %>
						
					</div>
					
					<div class="col-xs-9">
						
						$Content
						
					</div>
				
				</div>
			</div>
			
		<% end_if %>
		
	</div>
</body>
</html>
