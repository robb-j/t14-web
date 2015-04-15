<style>
	#colour-green {
		color: green;
	}
	#colour-red{
		color: red;
	}
	.date{
		margin: 5px;
	}
	.payee{
		margin: 5px;
	}
	.amount{
		margin: 5px;
	}
</style>
<div>
<h3>Hi $user</h3>
		<p>This email contains your monthly update for each one of your accounts as well as a mini statement.</p>
		<hr>
		<% loop $accounts %>
			<h4>$AccountType acccount:</h4>
			<ul>
				<li>Current Balance: <span id="colour-<% if $Balance > 0 %>green"<% else %>red"<% end_if %>>$Balance</span></li>
				<li>Overdraft limit: $OverdraftLimit</li>
			</ul>
			<h4>Last 10 transactions:</h4>
				
				<ul>
					<% loop $Transactions.Sort(ID, DESC).limit(10) %>
						<li><span class="date">$Date:</span><span class="payee">$Payee:</span> <span class="amount"><span id="colour-<% if $Amount > 0 %>green"<% else %>red"<% end_if %>>$Amount</span></span> </li>
					<% end_loop %>
				</ul>
			<hr>
		<% end_loop %>
		
		<h3> Thanks Team 14</h3>
</div>