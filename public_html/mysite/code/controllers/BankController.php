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
	
	public function CurrencyClass($value) {
		
		if ($value < 0.0) {
			
			return "currency-red";
		}
		else {
			
			return "currency-green";
		}
	}
	
	public function FormatCurrency($value) {
		
		if ($value < 0.0) {
			
			return "-£" . number_format(abs($value), 2);
		}
		else {
			
			return "£" . number_format($value, 2);
		}
	}
	
	public function HandleForm($request) {
		
		$data = $request->postVars();
		
		$categorise = $data["categorise"];
		
		
		// Get the action clicked
		foreach($data as $param => $value) {
			
			if(substr($param,0,7) == 'action_') {
				
				
				// Tidy up if using Get request
				if(strpos($param,'?') !== false) {
					
					list($paramName, $paramVars) = explode('?', $paramName, 2);
 					$newRequestParams = array();
 					parse_str($paramVars, $newRequestParams);
 					$vars = array_merge((array)$vars, (array)$newRequestParams);
				}
				
				$action = preg_replace(array('/^action_/','/_x$|_y$/'),'', $param);
				break;
			}
		}
		
		
		//print_r($categorise);
		
		if ($this->hasMethod($action)) {
			return $this->$action($data);
		}
		else {
			return "<p> Form Error: Method " . $action . " does not exist on Controller: " . get_class($this) . "</p>";
		}
	}
}