<?php

/* A Page that shows the user their rewards
 * Created by Rob A - March 2015
 */
class RewardsController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "rewards";
	
	
	public function Content() {
		
		// Create an API to access the database
		$api = new WebApi();
		
		// Get the recent point & rewards for the User
		$this->RecentPoints = $api->getLastPoints($this->CurrentUser->ID);
		$this->RecentRewards = $this->CurrentUser->RewardsTaken()->limit(7);
		
		// Render with a template
		return $this->renderWith("RewardsContent");
	}
}