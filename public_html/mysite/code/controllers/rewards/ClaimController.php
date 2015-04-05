<?php

/* A Page that lets the user claim a reward
 * Created by Rob A - March 2015
 * Completed by Yifan W - April 2015
 */
class ClaimController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "rewards";
	
	public function CostClass($points, $cost) {
		
		if ($points > $cost) {
			
			return "currency-green";
		}
	}
	
	public function Content() {
		
		// Create an API to access the database
		$api = new WebApi();
		
		// Get the list of available rewards for the user
		$this->Rewards = $api->getAllRewards()->limit(7);
		
		// Render with a template
		return $this->renderWith("ClaimContent");
	}
}