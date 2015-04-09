<?php

/* A Page that lets the user spin for points
 * Created by Rob A - March 2015
 * Completed by Seb S - April 2015
 */
class SpinController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "rewards";
	
	private static $allowed_actions = array(
		"PerformSpin"
	);
	
	public function Content() {
		// Create an API to access the database
		$api = new WebApi();
		
		$Points = $this->CurrentUser->Points - Session::get("PreSpin");
		Session::clear("PreSpin");
		$this->animation = $Points;
		
		if(Session::get("First") == 1){
			$this->message = "You earned $Points points!";
			Session::clear("First");
		}
		
		// Render with a template
		return $this->renderWith("SpinContent");
	}

	public function PerformSpin() {
		Session::set("PreSpin", $this->CurrentUser->Points);
		Session::set("First", 1);
		
		$output = WebApi::create()->performSpin($this->CurrentUser->ID);
		
		return $this->redirect("rewards/spin");
	}
}