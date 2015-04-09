<!--  <script>

 function myFunction(){
	setInterval(function(){document.getElementById("points-message").innerHTML = "You earned $Points points!";}, 9000);
}

</script>  -->

<div class="spin-page">
	
	<div class="main-section">
		
		<div class="spin-content">
			<div class="row">
				<div class="col-xs-8 col-xs-offset-2">
				
						<h3> You have $CurrentUser.NumberOfSpins spins</h3>
					
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
						
						<% else_if $animation == 80 %>
						
						<% else %>
							<img src="mysite/images/spin-still.png" alt="roulette wheel" width="400px" height="378px"/>
						
						<% end_if %>
						
					</a>
					</div>
				</div>
			</div>
		
		
			<div class="row">
		
				<div class="col-xs-4 col-xs-offset-4">
				
					<h4 id="points-message">$message</h4>
			
					<div class="control-button cb-green cb-top">
						<a href="SpinController/PerformSpin">SPIN!</a>
					</div>
					
				
				</div>
			</div>
		</div>
	</div>
	
	
</div>