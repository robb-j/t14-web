<!doctype html>
<head>
	
	$MetaTags('false')
</head>
<body>
		<h3>Hi $user</h3>
		<p>This email contains your monthly update for each one of your accounts as well as a mini statement</p>
		<% loop $accounts %>
			<h4>$AccountType</h4>
			<ul>
				<li>Balance: $Balance</li>
				<li>Overdraft limit: $OverdraftLimit</li>
				<li>Available Balance: ($OverdraftLimit+$Balance)</li>
			</ul>
			<h4>Transactions</h4>
				<ul>
				<% loop $transactions.$Pos %>
					<li>$Date 	$Payee 		$Amount</li>
				<% end_loop %>
				</ul>
			
		<% end_loop %>
		
		<h3> Thanks Team 14</h3>
		
</body>
