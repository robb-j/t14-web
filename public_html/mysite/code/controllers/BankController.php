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
	public $NewProducts = array();
	
	
	public function init() {
		
		parent::init();
		
		
		// Common Requirements
		Requirements::javascript("mysite/js/libs/jquery.js");
		Requirements::javascript("mysite/js/libs/bootstrap.js");
		Requirements::javascript("mysite/js/LogoutCheck.js");
		
		
		// Get the session token, if there is one
		$this->CurrentUser = BankAccessor::create()->getCurrentUser();
		
		
		Currency::setCurrencySymbol("£");
	}
	
	
	public function index() {
		
		if ($this->CurrentUser == null) {
			
			// If there isn't one, redirect to login
			return $this->redirect("login/");
		}
		else {
			
			// Otherwise, render with page
			return $this->renderWith("Page");
		}
	}
	
	
	
	
	/*
	 *	Get a class to apply to a currency, depending on its value
	 */
	public function CurrencyClass($value) {
		
		if ($value < 0.0) {
			
			return "currency-red";
		}
		else {
			
			return "currency-green";
		}
	}
	
	
	/*
	 *	Format a Currency to display nicely
	 */
	public function FormatCurrency($value) {
		
		if ($value < 0.0) {
			
			return "-£" . number_format(abs($value), 2);
		}
		else {
			
			return "£" . number_format($value, 2);
		}
	}
	
	
	/*
	 *	A helper function for managing forms
	 * 	Will call the action of the submit button pressed, like:
	 * 		<input class="control-button cb-green" type="submit" name="action_submitEdit" value="Save"/>
	 * 	This will call submitEdit($data) on the attached Controller, where $data is the post data from the form
	 * 	Should be used with a form of the standard:
	 *		<form class="banking-form my-cool-form" method="POST" action="MyControllerName/MyFormName" enctype="application/x-www-form-urlencoded">
	 *	Then the Controller just needs to have the 
	 *		$allowed_actions = array("MyFormName");
	 *	and implement the function:
	 *		public function MyFormName($request) { return parent::HandleForm($request); }
	 *	Then you can do whatever you want with the post data in the called function and us SS's return->redirect("someplace") if you want
	 */
	public function HandleForm($request) {
		
		
		// Gets the post values from the request
		$data = $request->postVars();
		
		
		// Get the action clicked
		foreach($data as $param => $value) {
			
			// Find the param that stats with 'action_'
			if(substr($param,0,7) == 'action_') {
				
				// Tidy up the name
				if(strpos($param,'?') !== false) {
					
					list($paramName, $paramVars) = explode('?', $paramName, 2);
 					$newRequestParams = array();
 					parse_str($paramVars, $newRequestParams);
 					$vars = array_merge((array)$vars, (array)$newRequestParams);
				}
				
				
				// Get the name, tidied, to call the function back on ourself
				$action = preg_replace(array('/^action_/','/_x$|_y$/'),'', $param);
				break;
			}
		}
		
		
		if ($this->hasMethod($action)) {
			
			// Attempt to run this action on the Controller
			return $this->$action($data);
		}
		else {
			
			// Otherise, just show an error
			return "<p> Form Error: Method " . $action . " does not exist on Controller: " . get_class($this) . "</p>";
		}
	}
}