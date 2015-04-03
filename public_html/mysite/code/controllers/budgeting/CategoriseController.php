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
		
		
		$this->NewPayments = WebApi::create()->newPayments($this->CurrentUser->ID);
		
		
		
		// Render with a template
		return $this->renderWith("CategoriseContent");
	}
	
	
	
	public function CategoriseForm(SS_HTTPRequest $request) {
		
		return parent::HandleForm($request);
	}
	
	
	public function submitCategorise($data) {
		
		
		$userID = $data["UserID"];
		$used = array();
		
		$categorised = $data["categorise"];
		
		foreach($categorised as $key => $value) {
			
			if ($value != 'none') {
				
				$used[$key] = $value;
			}
		}
		
		$output = WebApi::create()->categorizePayments($userID, $used);
		
		if ($output->didPass()) {
			
			$this->HasNewSpin = $output->allowedNewSpin();
			$this->HasCategorised = true;
		}
		else {
			$this->FormError = $output->getReason();
		}
		
		return $this->index();
	}
	
	public function cancelCategorise($data) {
		
		return $this->redirect("budgeting/");
	}
}