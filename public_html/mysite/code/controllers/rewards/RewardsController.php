<?php

/* A Page that shows the user their rewards
 * Created by Rob A - March 2015
 */
class RewardsController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "rewards";
	
	
	public function Content() {
		
		// Render with a template
		return $this->renderWith("RewardsContent");
	}
}