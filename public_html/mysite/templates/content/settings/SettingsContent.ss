<p> Hello Settings </p>
<hr/>



<% loop $CurrentUser.Accounts %>

	<p> $Title </p>
	
	
	<ul>
		<% loop Transactions.limit(2) %>
			<li> $Amount </li>
		<% end_loop %>
	</ul>
		
<% end_loop %>