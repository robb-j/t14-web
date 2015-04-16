<!doctype html>
<head>
	
	$MetaTags('false')
	
	<% base_tag %>
	
	<title> $Title </title>
	
	<% require css("mysite/css/screen.css") %>
	<% require css("mysite/css/login.css") %>
	<% require css("mysite/css/libs/bootstrap.min.css") %>
	
</head>


<body>

<div class="login">
	
	<!-- The Header bar -->
	<div class="login-header">
		<div class="row">
			
			<!-- The horse logo -->		
			<div class="col-xs-1 col-xs-offset-2">
				<div class="login-header-logo">
					<a href="#"><img src="mysite/images/logo.png" alt="Lloyd's logo" ></a>
				</div>
			</div>
			
			
			<!-- The title -->
			<div class="col-xs-6">
				<h1>Lloyd's Banking Group</h1>
			</div>
			
		</div>
	</div>
	
	<div class="bank-login-form">
		<div class="row">
						
			<!-- Show the login form -->
			<div class="col-xs-3 col-xs-offset-2">
				
				<div class="form-inner">
					<h2>Login</h2>
					$BankLoginForm
				</div>
				
			</div>
		</div>
	</div>
</div>
</body>
