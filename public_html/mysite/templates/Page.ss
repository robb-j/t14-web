<!doctype html>
<head>
	
	$MetaTags('false')
	
	<!-- CSS -->
	<link rel="stylesheet" href="{$BaseURL}{$ThemeDir}/css/screen.css" media="screen, projection, print" type="text/css"/>
	<link rel="stylesheet" href="{$BaseURL}{$ThemeDir}/css/form.css" media="screen, projection, print" type="text/css"/>
	
</head>



<body>
	<input id="production-mode" type="hidden" value="$SiteConfig.ProductionMode"/>	
	
	<div class="page-container">
		
		
		<!-- Display the login form if needed -->
		<% if Form %>
			<div class="container">
				<div class=" offset-md-4 col-md-8">
				$Content
				$Form
				</div>
			</div>
		<% else %>
			
			<div id="app-container"></div>
			
		<% end_if %>
		
	</div>
</body>
</html>
