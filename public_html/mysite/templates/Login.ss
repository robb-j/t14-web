<!doctype html>
<head>
	
	$MetaTags('false')
	
	<% base_tag %>
	
	<title> $Title </title>
	
	<% require css("mysite/css/login.css") %>
	<% require css("mysite/css/libs/bootstrap.min.css") %>
	
</head>


<body>
	
	<div class="bank-login-form">
	
		<div class="row">
			
			<div class="form-outer">
				
				<div class="col-xs-6 col-xs-offset-3">
					
					<div class="form-inner">
						
						<h1> Please Login Below </h1>
						
						$BankLoginForm
						
					</div>
					
				</div>
			

			</div>
		</div>
	</div>
</body>
