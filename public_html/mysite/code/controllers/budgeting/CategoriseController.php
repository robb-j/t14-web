<?php

/* A Page that lets the User give their payments a Category
 * Created by Rob A - March 2015
 */
class CategoriseController extends BankController {
	
	
	// Set the tab title
	public $TabTitle = "budgeting";
	
	private static $allowed_actions = array(
		"CategoriseForm"
	);
	
	
	public function Content() {
		
		// Pass the number of new payments to the template
		$this->NewPayments = WebApi::create()->newPayments($this->CurrentUser->ID);
		
		
		// Render with a template
		return $this->renderWith("CategoriseContent");
	}
	
	
	
	public function CategoriseForm(SS_HTTPRequest $request) {
		
		// Defer the method to the parent
		return parent::HandleForm($request);
	}
	
	
	/*
	 * 	Called by BankController.HandleForm when the user clicks the submit button
	 *	$data is the post data from the form
	 */
	public function submitCategorise($data) {
		
		// Get values from the post data
		$userID = $data["UserID"];
		$used = array();
		
		
		// Format the data for WebApi
		$categorised = $data["categorise"];
		foreach($categorised as $key => $value) {
			
			if ($value != 'none') {
				
				$used[$key] = $value;
			}
		}
		
		// Pass the values to WebApi to categorize
		$output = WebApi::create()->categorizePayments($userID, $used);
		
		
		// If it passed pass variables to the next template
		if ($output->didPass()) {
			
			$this->HasNewSpin = $output->allowedNewSpin();
			$this->HasCategorised = true;
		}
		else {
			
			$this->FormError = $output->getReason();
		}
		
		
		// Reload this page using the same Controller
		return $this->index();
	}
	
	public function cancelCategorise($data) {
		
		return $this->redirect("budgeting/");
	}
}