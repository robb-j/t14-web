<div class="tools-container">
	
	<div class="tools-tabbar">
			
		<div class="tabbar-item <% if $ToolName == atm %> active <% end_if %>">
			<p><a href="tools/atms"> ATM Finder </a></p>
		</div>
	
		<div class="tabbar-item <% if $ToolName == heatmap %> active <% end_if %>">
			<p><a href="tools/heatmap"> Heat Map </a></p>
		</div>
			
		</div>
	</div>
	
	$ToolContent
	
</div>