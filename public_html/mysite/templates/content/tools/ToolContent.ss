<div class="tools-container">
	
	<!-- The tabbar for tools -->
	<div class="tools-tabbar">
		
		<!-- The ATMs tab -->
		<a href="tools/atms">
			<div class="tabbar-item <% if $ToolName == atm %> active <% end_if %>">
				<p> ATM Finder </p>
			</div>
		</a>
		
		
		<!-- The HeatMap tab -->
		<a href="tools/heatmap">
			<div class="tabbar-item <% if $ToolName == heatmap %> active <% end_if %>">
				<p> Heat Map </p>
			</div>
		</a>
		
	</div>
	
	<!-- Show tools content, overriden by subclasses -->
	$ToolContent
	
</div>