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
		
		if (array_key_exists("delete", $this->request->getVars())) {
			
			$this->DeleteID = $this->request->getVars()["delete"];
		}
		
		// Get the list of available rewards for the user
		$this->Rewards = $api->getAllRewards()->limit(7);
		
		// Render with a template
		return $this->renderWith("ClaimContent");
	}
	
	public function TakeReward() {
		
		if (array_key_exists("group", $this->request->getVars())) {
			
			$groupID = $this->request->getVars()["group"];
			
			$output = WebApi::create()->chooseReward($this->CurrentUser->ID, $groupID);
			
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