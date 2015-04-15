<?php

/* A Page that lets the user claim a reward
 * Created by Rob A - March 2015
 * Completed by Yifan W - April 2015
 */
class ClaimController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "rewards";
	
	private static $allowed_actions = array(
		"TakeReward"
	);
	
	public function Content() {
		
		// Create an API to access the database
		$api = new WebApi();
		
		if (array_key_exists("choose", $this->request->getVars())) {
			
			$this->ChooseID = $this->request->getVars()["choose"];
		}
		
		// Get the list of available rewards for the user
		$this->Rewards = $api->getAllRewards()->limit(7);
		
		// Render with a template
		return $this->renderWith("ClaimContent");
	}
	
	public function TakeReward() {
		
		if (array_key_exists("choose", $this->request->getVars())) {
			
			$rewardID = $this->request->getVars()["choose"];
			
			$output = WebApi::create()->chooseReward($this->CurrentUser->ID, $rewardID);
			
			if ($output->didPass() == false) {
				
				$this->ErrorMessage = "Failed to claim reward";
				return $this->index();
			}
			else {
				$this->CurrentUser = WebAPI::create()->getCurrentUser();
				$this->SuccessMessage = "Reward successfully claimed";
			}
		}
		return $this->index();
	}
}