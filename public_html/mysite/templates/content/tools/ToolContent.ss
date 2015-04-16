<div class="tools-container">
	
	<div class="tools-tabbar">
		
		<a href="tools/atms">
			<div class="tabbar-item <% if $ToolName == atm %> active <% end_if %>">
				<p> ATM Finder </p>
			</div>
		</a>
		
		<a href="tools/heatmap">
			<div class="tabbar-item <% if $ToolName == heatmap %> active <% end_if %>">
				<p> Heat Map </p>
			</div>
		</a>
		
	</div>
	
	$ToolContent
	
</div>