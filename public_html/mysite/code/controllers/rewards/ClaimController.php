<?php

/* A Page that lets the user claim a reward
 * Created by Rob A - March 2015
 * Completed by Yifan W - April 2015
 */
class ClaimController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "rewards";
	
	private static $allowed_actions = array(
		"TestFunction","martinFunction"
	);
	
	
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
	
	public function ComparePoint($value1, $value2) {
	

		if ((int)$value1 <= (int)$value2 ) {
			
			return true;
		}
		else {
			
			return false;
		}
	}
	
	public function TestFunction(){
	
		
		echo "|Hello|";
	
	}
	
	public function martinTest(){
	
		$ID = $this->request->param('ID');
		
		echo "|".$ID."| and |".$this->CurrentUser->ID."|";
	
	}
}