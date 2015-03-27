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
	<div class="login-header">
		<div class="row">			
			<div class="col-xs-1 col-xs-offset-2">
				<div class="login-header-logo">
					<a href="#"><img src="mysite/images/logo.png"   
						alt="Lloyd's logo" ></a>
				</div>
			</div>
				
			<div class="col-xs-6">
				<h1>Lloyd's Banking Group</h1>
			</div>
			
			<div class="col-xs-3">
			</div>
		</div>
	</div>
	
	<div class="bank-login-form">
		<div class="row">
						
				<div class="col-xs-3 col-xs-offset-2">
					
					<div class="form-inner">
						<h2>Login</h2>
						$BankLoginForm
						
					</div>
					
				</div>
			

			</div>
		</div>
	</div>
</div>
</body>
