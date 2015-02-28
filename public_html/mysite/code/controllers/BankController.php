<?php

/* A Parent page to be subclassed for any page that wants the navigation and side bar
 * Override $Content to provide content to go in the main area
 * Override $TabTibtle to tell the navigation bar what tab you're on: banking | budgeting | rewards | tools | settings
 * Created by Rob A - Feb 2015
 */
class BankController extends Controller {
	
	// The default tab title
	public $TabTitle = "none";
	
	public $CurrentUser = null;
	
	
	public function index() {
		
		// Get the session token, if there is one
		$session = $this->GetSessionToken();
		
		if ($session == null || strlen($session) == 0) {
			
			// If there isn't one, redirect to login
			return $this->redirect("login/");
		}
		else {
			
			// Otherwise, render with page
			return $this->renderWith("Page");
		}
	}
	
	
	public function GetSessionToken() {
		
		return Cookie::get("BankingSession");
	}
}