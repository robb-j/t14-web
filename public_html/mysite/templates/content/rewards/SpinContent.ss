<div class="spin-page">
	
	<div class="main-section">
		
		<div class="spin-content">
			<div class="row">
				<div class="col-xs-8 col-xs-offset-2">
				
						<h3> You have $CurrentUser.NumberOfSpins spins </h3>
						<p> Points: <span class="currency-green"> $CurrentUser.Points </span> </p>
						<br/>
					
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1">
					<div class="roulette">
					<a href="SpinController/PerformSpin">
						
						<!-- This if statement displays a still image or the appropriate animation for the spin -->
						<% if $animation == 20 %>
							<embed src="mysite/images/20animation.swf" width="400px" height="378px" />
						<% else_if $animation == 40 %>
							<embed src="mysite/images/40animation.swf" width="400px" height="378px" />
						<% else_if $animation == 60 %>
							<embed src="mysite/images/60animation.swf" width="400px" height="378px" />
						<% else_if $animation == 80 %>
							<embed src="mysite/images/80animation.swf" width="400px" height="378px" />
						<% else_if $animation == 100 %>
							<embed src="mysite/images/100animation.swf" width="400px" height="378px" />
						<% else %>
							<img src="mysite/images/spin-still.png" alt="roulette wheel" width="378px" height="378px"/>
						<% end_if %>
						
					</a>
					</div>
				</div>
			</div>
		
		
			<div class="row">
				
				<div class="col-xs-3 col-xs-offset-3">
					<a class="control-button cb-white cb-top" href="rewards/"> Back </a>
				</div>
		
				<div class="col-xs-3">
					<a href="SpinController/PerformSpin">
						<div class="control-button cb-green cb-top">
							Spin!
						</div>
					</a>				
				</div>
				
			</div>
		</div>
	</div>
	
	
</div>